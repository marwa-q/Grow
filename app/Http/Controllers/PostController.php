<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    // Show all posts
    public function index()
    {
        $posts = Post::with(['user', 'comments', 'likes'])->latest()->get();
        return view('posts.index', compact('posts'));
    }

    // Show form to create a post
    public function create()
    {
        return view('posts.create');
    }

    // Store a new post
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $post = new Post();
        $post->user_id = Auth::id();
        $post->title = $request->title;
        $post->content = $request->content;
        
        if ($request->hasFile('image')) {
            $post->image = $request->file('image')->store('posts', 'public');
        }
        
        $post->save();

        return Redirect::route('posts.index');
    }

    // Show a single post
    public function show(Post $post)
    {
        //
    }

    // Show form to edit a post
    public function edit(Post $post)
    {
        // Authorization check - only allow post owner to edit
        if (Auth::id() !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('posts.edit', compact('post'));
    }
    
    public function update(Request $request, Post $post)
    {
        // Authorization check - only allow post owner to update
        if (Auth::id() !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        // Validate the request
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048', // Optional: Allow updating the image
        ]);
        
        // Update the post
        $post->title = $validated['title'];
        $post->content = $validated['content'];
        
        // Handle image upload if a new one is provided
        if ($request->hasFile('image')) {
            
            // Store the new image
            $imagePath = $request->file('image')->store('posts', 'public');
            $post->image = $imagePath;
        }
        
        $post->save();
        
        return redirect()->route('posts.index')->with('success', 'Post updated successfully!');
    }

    // Delete a post
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index');
    }
    
}
