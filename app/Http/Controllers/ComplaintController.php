<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        $complaints = Complaint::where('user_id', $request->user()->id)
            ->latest()
            ->paginate(5);

        // If JS requests just the data (e.g., for auto-refreshing the table later)
        if ($request->wantsJson()) {
            return response()->json($complaints);
        }

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

        // API/AJAX Response
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Your complaint has been submitted. We will get back to you shortly.',
                'complaint' => $complaint
            ], 201);
        }

        // Standard Web Response
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
        $this->ensureOwnership($request, $complaint);

        $complaint->update([
            'status'      => 'resolved',
            'resolved_at' => now(),
        ]);

        // API/AJAX Response
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Complaint marked as resolved.',
                'complaint' => $complaint
            ], 200);
        }

        // Standard Web Response
        return redirect()
            ->route('complaints.index')
            ->with('success', 'Complaint marked as resolved.');
    }

    private function ensureOwnership(Request $request, Complaint $complaint): void
    {
        abort_unless($complaint->user_id === $request->user()->id, 403);
    }
}
