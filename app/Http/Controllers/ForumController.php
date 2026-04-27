<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ForumController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->query('search');

        $posts = ForumPost::with(['user', 'comments.user'])
                    ->withCount('comments')
                    ->when($query, function ($q) use ($query) {
                        return $q->where('body', 'LIKE', "%{$query}%");
                    })
                    ->orderBy('created_at', 'desc')
                    ->paginate(5);
        
        if ($request->expectsJson()) {
            return response()->json($posts);
        }
        
        return view('forum', compact('posts'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'body' => 'required|string|min:3', 
        ]);

        $post = $request->user()->forumPosts()->create($validated);

        return response()->json($post, 201);
    }
}