<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ForumController extends Controller
{
    public function index()
    {
        $posts = ForumPost::with(['user', 'comments.user'])
                    ->withCount('comments') // Adds a 'comments_count' attribute
                    ->orderBy('is_pinned', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10); 

        return view('forum', compact('posts'));
    }
    
    public function create(): View
    {
        return view('forum.create');
    }
}