<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use App\Models\ForumComment;
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
                    ->paginate(10);
        
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

    public function update(Request $request, ForumPost $forumPost)
    {
        if ($request->user()->id !== $forumPost->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        $validated = $request->validate([
            'body' => 'required|string|min:3',
        ]);
        
        $forumPost->update($validated);
        
        return response()->json(['message' => 'Updated']);
    }

    public function soft_delete(Request $request, ForumPost $forumPost)
    {
        if ($request->user()->role !== 'admin' && $request->user()->id !== $forumPost->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $updateData = ['is_soft_delete' => true];
        
        if ($request->user()->role === 'admin' && $request->user()->id !== $forumPost->user_id) {
            $updateData['deleted_by_admin'] = $request->user()->name;
        }

        $forumPost->update($updateData);

        return response()->json(['message' => 'Post soft deleted']);
    }

    public function getComments(ForumPost $forumPost)
    {
        $comments = $forumPost->comments()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($comments);
    }

    public function storeComment(Request $request, ForumPost $forumPost)
    {
        $validated = $request->validate([
            'body' => 'required|string|min:1',
        ]);
        
        $comment = $forumPost->comments()->create([
            'body' => $validated['body'],
            'user_id' => $request->user()->id
        ]);

        return response()->json($comment, 201);
    }

    public function updateComment(Request $request, ForumPost $forumPost, ForumComment $forumComment)
    {
        if ($forumComment->forum_post_id !== $forumPost->id) {
            return response()->json(['message' => 'Comment not found in this post'], 404);
        }

        if ($request->user()->id !== $forumComment->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate(['body' => 'required|string']);
        $forumComment->update($validated);
        
        return response()->json(['message' => 'Reply updated']);
    }

    public function destroyComment(Request $request, ForumPost $forumPost, ForumComment $forumComment)
    {
        if ($forumComment->forum_post_id !== $forumPost->id) {
            return response()->json(['message' => 'Comment not found in this post'], 404);
        }

        if ($request->user()->role !== 'admin' && $request->user()->id !== $forumComment->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $updateData = ['is_soft_delete' => true];

        if ($request->user()->role === 'admin' && $request->user()->id !== $forumComment->user_id) {
            $updateData['deleted_by_admin'] = $request->user()->name;
        }

        $forumComment->update($updateData);

        return response()->json(['message' => 'Reply deleted']);
    }
}