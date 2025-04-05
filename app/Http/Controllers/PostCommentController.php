<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Support\Facades\Auth;

class PostCommentController extends Controller
{
    // Store a new comment
    public function store(Request $request, Post $post)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $comment = $post->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return response()->json([
            'message' => 'Comment added successfully!',
            'comment' => [
                'user' => Auth::user()->name,
                'content' => $comment->content,
                'created_at' => $comment->created_at->diffForHumans(),
            ],
            'comments_count' => $post->comments()->count(),
        ]);
    }

    // Fetch all comments for a post
    public function fetchComments(Post $post)
    {
        $comments = $post->comments()->with('user')->latest()->get();

        return response()->json([
            'comments' => $comments->map(function ($comment) {
                return [
                    'user' => $comment->user->name,
                    'content' => $comment->content,
                    'created_at' => $comment->created_at->diffForHumans(),
                ];
            }),
            'comments_count' => $post->comments()->count(),
        ]);
    }
}
