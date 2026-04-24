<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ForumController extends Controller
{
    public function index(): View
    {
        // Fetch posts from your schema, ordered by pinned status first
        $posts = ForumPost::with('user')
                    ->orderBy('is_pinned', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->get();

        // This sends the $posts variable to your forum.blade.php
        return view('forum', compact('posts'));
    }
    
    public function create(): View
    {
        return view('forum.create');
    }
}