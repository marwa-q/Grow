<?php

namespace App\Http\Controllers;

use App\Models\PostComment;
use Illuminate\Http\Request;

class PostCommentController extends Controller
{
    // Fetch comments for a post
    public function fetchComments($postId)
    {
        // Eager load the user with comments
        $comments = \App\Models\PostComment::where('post_id', $postId)
        ->with(['user:id,first_name,last_name,profile_image']) // Eager load user
        ->latest()
        ->get();

        // Return comments in JSON format
        return response()->json([
            'comments' => $comments->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'comment' => $comment->comment,
                    'created_at' => $comment->created_at->format('Y-m-d H:i:s'),
                    'user' => [
                        'first_name' => $comment->user->first_name,
                        'last_name' => $comment->user->last_name
                    ]
                ];
            }),
            'comments_count' => $comments->count()
        ]);
    }

    // Store a new comment for a post
    public function store(Request $request, $postId)
    {
        $request->validate([
            'comment' => 'required|string|max:255'
        ]);

        // Save the comment to the database
        $comment = new PostComment();
        $comment->post_id = $postId;
        $comment->user_id = auth()->id(); // Assumes user is authenticated
        $comment->comment = $request->comment;
        $comment->save();

        // Return the saved comment with user data
        return response()->json([
            'comment' => [
                'comment' => $comment->comment,
                'created_at' => $comment->created_at->format('Y-m-d H:i:s'),
                'user' => [
                    'first_name' => $comment->user->first_name,
                    'last_name' => $comment->user->last_name
                ]
            ],
            'comments_count' => PostComment::where('post_id', $postId)->count()
        ]);
    }
}
