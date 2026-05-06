<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\ComplaintStatusLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        $complaints = Complaint::where('user_id', $request->user()->id)
            ->with(['replies', 'statusLogs'])
            ->latest()
            ->paginate(5);

        return view('complaints', compact('complaints'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject'     => ['required', 'string', 'max:255'],
            'category'    => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'min:10'],
            'attachment'  => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')
                ->store('complaint-attachments', 'public');
        }

        $complaint = Complaint::create([
            'user_id'         => $request->user()->id,
            'reference_no'    => 'CMP-' . strtoupper(Str::random(8)),
            'subject'         => $validated['subject'],
            'category'        => $validated['category'],
            'description'     => $validated['description'],
            'attachment_path' => $attachmentPath,
            'status'          => 'pending',
            'priority'        => 'normal',
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'message'   => 'Your complaint has been submitted. We will get back to you shortly.',
                'complaint' => $complaint,
            ], 201);
        }

        return redirect()
            ->route('complaints.index')
            ->with('success', 'Your complaint has been submitted. We will get back to you shortly.');
    }

    public function show(Request $request, Complaint $complaint)
    {
        $this->ensureOwnership($request, $complaint);

        if ($request->wantsJson()) {
            return response()->json($complaint);
        }

        return view('complaints.show', compact('complaint'));
    }

    public function resolve(Request $request, Complaint $complaint)
    {
        $user = auth()->user();

        if ($user->role === 'admin' && $complaint->user_id !== $user->id) {
            // Admin allowed: pending, in_review, resolve_ready, rejected
            // "resolved" is exclusively for the complainant
            $request->validate([
                'status' => 'required|in:pending,in_review,resolve_ready,rejected',
            ]);

            $oldStatus = $complaint->status;
            $newStatus = $request->status;

            if ($oldStatus === $newStatus) {
                return back()->with('info', 'Status is already set to that value.');
            }

            // Rejection requires a reason posted as a reply
            if ($newStatus === 'rejected') {
                $request->validate([
                    'reject_message' => 'required|string|max:2000',
                ]);

                $complaint->replies()->create([
                    'user_id' => $user->id,
                    'message' => $request->reject_message,
                ]);
            }

            $complaint->update(['status' => $newStatus]);

            ComplaintStatusLog::create([
                'complaint_id' => $complaint->id,
                'user_id'      => $user->id,
                'from_status'  => $oldStatus,
                'to_status'    => $newStatus,
            ]);

            return back()->with('success', 'Status updated.');
        }

        // Regular user: only resolve their OWN complaint
        if ($complaint->user_id !== $user->id) {
            abort(403);
        }

        if (!in_array($complaint->status, ['pending', 'in_review', 'resolve_ready'])) {
            return back()->with('error', 'This complaint cannot be resolved at this stage.');
        }

        $oldStatus = $complaint->status;

        $complaint->update([
            'status'      => 'resolved',
            'resolved_at' => now(),
        ]);

        ComplaintStatusLog::create([
            'complaint_id' => $complaint->id,
            'user_id'      => $user->id,
            'from_status'  => $oldStatus,
            'to_status'    => 'resolved',
        ]);

        return back()->with('success', 'Complaint marked as resolved.');
    }

    private function ensureOwnership(Request $request, Complaint $complaint): void
    {
        abort_unless($complaint->user_id === $request->user()->id, 403);
    }

    public function adminIndex(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $query = Complaint::with(['user', 'replies', 'statusLogs'])->latest();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($category = $request->input('category')) {
            $query->where('category', $category);
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $complaints = $query->paginate(10)->withQueryString();

        $categories = Complaint::select('category')
            ->distinct()
            ->whereNotNull('category')
            ->pluck('category');

        return view('complaint-management', compact('complaints', 'categories'));
    }

    public function reply(Request $request, Complaint $complaint)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $complaint->replies()->create([
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);

        if (auth()->user()->role === 'admin' && $complaint->status === 'pending') {
            $oldStatus = $complaint->status;
            $complaint->update(['status' => 'in_review']);

            ComplaintStatusLog::create([
                'complaint_id' => $complaint->id,
                'user_id'      => auth()->id(),
                'from_status'  => $oldStatus,
                'to_status'    => 'in_review',
            ]);
        }

        return back()->with('success', 'Reply posted successfully.');
    }
}