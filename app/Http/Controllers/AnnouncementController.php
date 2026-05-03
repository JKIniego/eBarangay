<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnnouncementRequest;
use App\Models\Announcement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

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

    public function bulletin()
    {
        $announcements = Announcement::orderByDesc('is_featured')
            ->orderByDesc('published_at')
            ->paginate(12);

        return view('bulletin', compact('announcements'));
    }

    public function bulletinShow(Announcement $announcement)
    {
        return view('bulletin-show', compact('announcement'));
    }

    // API Endpoints for AJAX
    public function apiIndex(Request $request): JsonResponse
    {
        $announcements = Announcement::with('user')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $announcements->items(),
            'pagination' => [
                'total' => $announcements->total(),
                'per_page' => $announcements->perPage(),
                'current_page' => $announcements->currentPage(),
                'last_page' => $announcements->lastPage(),
                'has_more' => $announcements->hasMorePages(),
            ],
        ]);
    }

    public function apiStore(AnnouncementRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $data['published_at'] = $request->boolean('is_published') ? now() : null;

        $announcement = Announcement::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Announcement created successfully.',
            'data' => $announcement->load('user'),
        ], 201);
    }

    public function apiUpdate(AnnouncementRequest $request, Announcement $announcement): JsonResponse
    {
        $this->ensureOwnership($request, $announcement);

        $data = $request->validated();
        $data['published_at'] = $request->boolean('is_published')
            ? ($announcement->published_at ?? now())
            : null;

        $announcement->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Announcement updated successfully.',
            'data' => $announcement->fresh()->load('user'),
        ]);
    }

    public function apiDestroy(Request $request, Announcement $announcement): JsonResponse
    {
        $this->ensureOwnership($request, $announcement);

        $announcement->delete();

        return response()->json([
            'success' => true,
            'message' => 'Announcement deleted successfully.',
        ]);
    }
}