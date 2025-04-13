<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Activity;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\Donation;
use Carbon\Carbon;
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
        
        // Calculate growth percentages compared to last month
        $lastMonthUsers = User::where('created_at', '<', now()->subMonth())->count();
        $userGrowth = $lastMonthUsers > 0 ? round((($totalUsers - $lastMonthUsers) / $lastMonthUsers) * 100, 1) : 0;
        
        $lastMonthActivities = Activity::where('created_at', '<', now()->subMonth())->count();
        $activityGrowth = $lastMonthActivities > 0 ? round((($totalActivities - $lastMonthActivities) / $lastMonthActivities) * 100, 1) : 0;
        
        $lastMonthPosts = Post::where('created_at', '<', now()->subMonth())->count();
        $postGrowth = $lastMonthPosts > 0 ? round((($totalPosts - $lastMonthPosts) / $lastMonthPosts) * 100, 1) : 0;
        
        $lastMonthDonations = Donation::where('created_at', '<', now()->subMonth())->sum('amount');
        $donationGrowth = $lastMonthDonations > 0 ? round((($totalDonations - $lastMonthDonations) / $lastMonthDonations) * 100, 1) : 0;
        
        // Get recent comments for the dashboard
        $recentComments = PostComment::with('user', 'post')
            ->latest()
            ->take(4)
            ->get();
        
        // Get recent donations for the dashboard
        $recentDonations = Donation::with(['user', 'activity'])
            ->latest()
            ->take(5)
            ->get();
        
        // Monthly donations chart data
        $monthlyDonations = Donation::monthlyStats(6)->get();
        [$chartLabels, $chartData] = Donation::formatMonthlyChartData($monthlyDonations);
        
        // Donations by day of week
        $donationsByDay = Donation::byDayOfWeek()->get();
        $daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        $barData = array_fill(0, 7, 0);
        
        foreach ($donationsByDay as $day) {
            $index = $day->day - 1; // MySQL's DAYOFWEEK() returns 1 for Sunday, 2 for Monday, etc.
            if ($index >= 0 && $index < 7) {
                $barData[$index] = $day->total;
            }
        }
        
        // Donations by activity for pie chart
        $donationsByActivity = Activity::withSum('donations as total_amount', 'amount')
            ->orderByDesc('total_amount')
            ->limit(5)
            ->get();
        
        $pieLabels = [];
        $pieData = [];
        
        foreach ($donationsByActivity as $activity) {
            if ($activity->total_amount > 0) {
                $pieLabels[] = $activity->title;
                $pieData[] = $activity->total_amount;
            }
        }
        
        // Add "Other" category if there are more activities
        $totalActivitiesDonations = array_sum($pieData);
        if ($totalActivitiesDonations < $totalDonations && $totalActivitiesDonations > 0) {
            $pieLabels[] = 'Other Activities';
            $pieData[] = $totalDonations - $totalActivitiesDonations;
        }
        
        return view('admin.dashboard', compact(
            'totalUsers', 'userGrowth',
            'totalActivities', 'activityGrowth',
            'totalPosts', 'postGrowth',
            'totalDonations', 'donationGrowth',
            'recentComments', 'recentDonations',
            'chartLabels', 'chartData',
            'daysOfWeek', 'barData',
            'pieLabels', 'pieData'
        ));
    }
}