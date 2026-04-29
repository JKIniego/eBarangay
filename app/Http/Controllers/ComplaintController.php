<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ComplaintController extends Controller
{
    public function index(Request $request): View
    {
        $complaints = Complaint::where('user_id', $request->user()->id)
            ->latest()
            ->paginate(5);

        return view('complaints', compact('complaints'));
    }

    public function store(Request $request): RedirectResponse
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

        Complaint::create([
            'user_id'         => $request->user()->id,
            'reference_no'    => 'CMP-' . strtoupper(Str::random(8)),
            'subject'         => $validated['subject'],
            'category'        => $validated['category'],
            'description'     => $validated['description'],
            'attachment_path' => $attachmentPath,
            'status'          => 'pending',
            'priority'        => 'normal',
        ]);

        return redirect()
            ->route('complaints.index')
            ->with('success', 'Your complaint has been submitted. We will get back to you shortly.');
    }

    public function show(Request $request, Complaint $complaint): View
    {
        $this->ensureOwnership($request, $complaint);

        return view('complaints.show', compact('complaint'));
    }

    public function resolve(Request $request, Complaint $complaint): RedirectResponse
    {
        $this->ensureOwnership($request, $complaint);

        $complaint->update([
            'status'      => 'resolved',
            'resolved_at' => now(),
        ]);

        return redirect()
            ->route('complaints.index')
            ->with('success', 'Complaint marked as resolved.');
    }

    private function ensureOwnership(Request $request, Complaint $complaint): void
    {
        abort_unless($complaint->user_id === $request->user()->id, 403);
    }
}