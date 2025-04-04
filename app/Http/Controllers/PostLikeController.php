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

        if ($existingLike) {
            $existingLike->delete();
        } else {
            PostLike::create([
                'post_id' => $post->id,
                'user_id' => Auth::id(),
            ]);
        }

        return back(); // No JSON response
    }
}
