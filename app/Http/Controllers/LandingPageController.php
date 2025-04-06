<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Activity; // If you have this model

class LandingPageController extends Controller
{
    public function index()
    {
        $latestPosts = Post::latest()->take(3)->get();
        $latestActivities = Activity::latest()->take(3)->get(); // adjust as needed

        return view('landing', compact('latestPosts', 'latestActivities'));
    }
}
