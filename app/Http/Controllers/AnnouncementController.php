<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->paginate(8);

        return view('announcements.index', compact('announcements'));
    }
}