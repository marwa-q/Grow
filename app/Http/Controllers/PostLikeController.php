<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostLike;
use Illuminate\Support\Facades\Auth;

class PostLikeController extends Controller
{
    public function toggleLike(Post $post)
    {
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $existingLike = PostLike::where('post_id', $post->id)
                            ->where('user_id', Auth::id())
                            ->first();

    $likeCount = $post->likes->count(); // Get the current like count for the post

    if ($existingLike) {
        // Unlike
        $existingLike->delete();
        $likeCount--; // Decrease like count
        $liked = false;
    } else {
        // Like
        PostLike::create([
            'post_id' => $post->id,
            'user_id' => Auth::id(),
        ]);
        $likeCount++; // Increase like count
        $liked = true;
    }

    // Return the updated like state and like count
    return response()->json([
        'liked' => $liked,
        'likeCount' => $likeCount,
    ]);
}

}
