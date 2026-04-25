<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnnouncementRequest;
use App\Models\Announcement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    public function index(Request $request): View
    {
        $announcements = Announcement::with('user')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('announcements.index', compact('announcements'));
    }

    public function create(): View
    {
        return view('announcements.create', [
            'announcement' => new Announcement(),
        ]);
    }

    public function store(AnnouncementRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $data['published_at'] = $request->boolean('is_published') ? now() : null;

        Announcement::create($data);

        return redirect()
            ->route('announcements.index')
            ->with('success', 'Announcement created.');
    }

    public function edit(Request $request, Announcement $announcement): View
    {
        $this->ensureOwnership($request, $announcement);

        return view('announcements.edit', compact('announcement'));
    }

    public function update(AnnouncementRequest $request, Announcement $announcement): RedirectResponse
    {
        $this->ensureOwnership($request, $announcement);

        $data = $request->validated();
        $data['published_at'] = $request->boolean('is_published')
            ? ($announcement->published_at ?? now())
            : null;

        $announcement->update($data);

        return redirect()
            ->route('announcements.index')
            ->with('success', 'Announcement updated.');
    }

    public function destroy(Request $request, Announcement $announcement): RedirectResponse
    {
        $this->ensureOwnership($request, $announcement);

        $announcement->delete();

        return redirect()
            ->route('announcements.index')
            ->with('success', 'Announcement deleted.');
    }

    private function ensureOwnership(Request $request, Announcement $announcement): void
    {
        abort_unless($announcement->user_id === $request->user()->id, 403);
    }
}