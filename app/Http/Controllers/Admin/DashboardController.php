<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Activity;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\Donation;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * عرض لوحة التحكم الرئيسية
     */
    public function index()
    {
        // Get counts and sums for dashboard
        $totalUsers = User::count();
        $totalActivities = Activity::count();
        $totalPosts = Post::count();
        $totalDonations = Donation::sum('amount');
        
        // Optional: Calculate growth percentages
        // This assumes you have a previous period to compare with
        // For example, compare with last month's data
        $lastMonthUsers = User::where('created_at', '<', now()->subMonth())->count();
        $userGrowth = $lastMonthUsers > 0 ? round((($totalUsers - $lastMonthUsers) / $lastMonthUsers) * 100, 1) : 0;
        
        $lastMonthActivities = Activity::where('created_at', '<', now()->subMonth())->count();
        $activityGrowth = $lastMonthActivities > 0 ? round((($totalActivities - $lastMonthActivities) / $lastMonthActivities) * 100, 1) : 0;
        
        $lastMonthPosts = Post::where('created_at', '<', now()->subMonth())->count();
        $postGrowth = $lastMonthPosts > 0 ? round((($totalPosts - $lastMonthPosts) / $lastMonthPosts) * 100, 1) : 0;
        
        $lastMonthDonations = Donation::where('created_at', '<', now()->subMonth())->sum('amount');
        $donationGrowth = $lastMonthDonations > 0 ? round((($totalDonations - $lastMonthDonations) / $lastMonthDonations) * 100, 1) : 0;
        
        $recentComments = PostComment::with('user', 'post')
        ->latest()
        ->take(4)
        ->get();
        
        return view('admin.dashboard', compact(
            'totalUsers', 'userGrowth',
            'totalActivities', 'activityGrowth',
            'totalPosts', 'postGrowth',
            'totalDonations', 'donationGrowth',
            'recentComments'
        ));
    }
}