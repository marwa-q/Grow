<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Activity;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DonationController extends Controller
{
    /**
     * Display a listing of donations
     */
    public function index()
    {
        $donations = Donation::with(['user', 'activity'])->latest()->paginate(10);
        $totalDonations = Donation::sum('amount');
        
        // Statistics for the donations page
        $totalCount = Donation::count();
        $totalDonors = Donation::distinct('user_id')->count('user_id');
        $avgDonation = $totalCount > 0 ? $totalDonations / $totalCount : 0;
        
        return view('admin.donations.index', compact(
            'donations', 
            'totalDonations', 
            'totalCount',
            'totalDonors',
            'avgDonation'
        ));
    }

    /**
     * Show the form for creating a new donation
     */
    public function create()
    {
        $users = User::orderBy('name')->get();
        $activities = Activity::orderBy('title')->get();
        
        return view('admin.donations.create', compact('users', 'activities'));
    }

    /**
     * Store a newly created donation
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'activity_id' => 'nullable|exists:activities,id',
            'amount' => 'required|numeric|min:0.01',
            'donated_at' => 'nullable|date',
            'notes' => 'nullable|string|max:500',
        ]);
        
        // Set donated_at to current time if not provided
        if (!isset($validated['donated_at'])) {
            $validated['donated_at'] = now();
        }
        
        Donation::create($validated);
        
        return redirect()->route('donations.index')
            ->with('success', 'Donation created successfully.');
    }

    /**
     * Display the specified donation
     */
    public function show(Donation $donation)
    {
        $donation->load(['user', 'activity']);
        
        // Get related donations (by same user or for same activity)
        $relatedDonations = Donation::where(function($query) use ($donation) {
                if ($donation->user_id) {
                    $query->where('user_id', $donation->user_id);
                }
                if ($donation->activity_id) {
                    $query->orWhere('activity_id', $donation->activity_id);
                }
            })
            ->where('id', '!=', $donation->id)
            ->latest()
            ->limit(5)
            ->get();
            
        return view('admin.donations.show', compact('donation', 'relatedDonations'));
    }

    /**
     * Show the form for editing the specified donation
     */
    public function edit(Donation $donation)
    {
        $users = User::orderBy('name')->get();
        $activities = Activity::orderBy('title')->get();
        
        return view('admin.donations.edit', compact('donation', 'users', 'activities'));
    }

    /**
     * Update the specified donation
     */
    public function update(Request $request, Donation $donation)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'activity_id' => 'nullable|exists:activities,id',
            'amount' => 'required|numeric|min:0.01',
            'donated_at' => 'nullable|date',
            'notes' => 'nullable|string|max:500',
        ]);
        
        $donation->update($validated);
        
        return redirect()->route('donations.index')
            ->with('success', 'Donation updated successfully.');
    }

    /**
     * Remove the specified donation
     */
    public function destroy(Donation $donation)
    {
        $donation->delete();
        
        return redirect()->route('donations.index')
            ->with('success', 'Donation deleted successfully.');
    }

    /**
     * Display donation statistics
     */
    public function statistics(Request $request)
{
    // Get time range filter, default to 30 days
    $range = $request->input('range', '30');
    
    // Base query with time filter
    $baseQuery = Donation::dateRange($range);
    
    // Get overall statistics
    $totalDonations = $baseQuery->sum('amount');
    $donationsCount = $baseQuery->count();
    $avgDonationAmount = $donationsCount > 0 ? $totalDonations / $donationsCount : 0;
    $uniqueDonors = $baseQuery->distinct('user_id')->count('user_id');
    
    // Calculate growth from previous period
    $previousPeriodEnd = now()->subDays(intval($range));
    $previousPeriodStart = $previousPeriodEnd->copy()->subDays(intval($range));
    
    $previousPeriodDonations = Donation::whereBetween('created_at', [$previousPeriodStart, $previousPeriodEnd])
        ->sum('amount');
        
    $donationGrowth = $previousPeriodDonations > 0 
        ? round((($totalDonations - $previousPeriodDonations) / $previousPeriodDonations) * 100, 1) 
        : 0;
    
    // Get donation size distribution
    $donationSizeDistribution = Donation::getSizeDistribution($range);
    
    // Get donations by activity
    $donationsByActivity = Activity::select([
            'activities.id', 
            'activities.title as activity_title',
            DB::raw('COUNT(donations.id) as donations_count'),
            DB::raw('SUM(donations.amount) as total_amount'),
            DB::raw('AVG(donations.amount) as avg_donation')
        ])
        ->leftJoin('donations', 'activities.id', '=', 'donations.activity_id')
        ->where(function($query) use ($range) {
            if ($range !== 'all') {
                $query->where('donations.created_at', '>=', now()->subDays(intval($range)));
            }
        })
        ->groupBy('activities.id', 'activities.title')
        ->having('total_amount', '>', 0)
        ->orderByDesc('total_amount')
        ->get();
        
    // Add general donations (without activity_id)
    $generalDonations = Donation::whereNull('activity_id')
        ->when($range !== 'all', function($query) use ($range) {
            return $query->where('created_at', '>=', now()->subDays(intval($range)));
        })
        ->selectRaw('COUNT(*) as donations_count, SUM(amount) as total_amount, AVG(amount) as avg_donation')
        ->first();
        
    if ($generalDonations && $generalDonations->total_amount > 0) {
        $generalDonationsObject = (object)[
            'id' => null,
            'activity_title' => 'General Donations',
            'donations_count' => $generalDonations->donations_count,
            'total_amount' => $generalDonations->total_amount,
            'avg_donation' => $generalDonations->avg_donation
        ];
        
        // Add to the beginning of the collection
        $donationsByActivity->prepend($generalDonationsObject);
    }
    
    // Get the top activity amount for progress bar calculation
    $topActivityAmount = $donationsByActivity->max('total_amount') ?? 0;
    
    // Get top donors - first let's check the user columns
    $userColumns = [];
    try {
        $userColumns = Schema::getColumnListing('users');
    } catch (\Exception $e) {
        // If we can't get columns, use a safer approach
    }
    
    // Determine if name/email columns exist
    $hasNameColumn = in_array('name', $userColumns);
    $hasEmailColumn = in_array('email', $userColumns);
    
    // Get top donors
    $topDonorsQuery = DB::table('donations')
        ->join('users', 'donations.user_id', '=', 'users.id')
        ->select('users.id');
        
    // Add name and email only if they exist    
    if ($hasNameColumn) {
        $topDonorsQuery->addSelect('users.name as user_name');
    } else {
        // Use a placeholder if name doesn't exist
        $topDonorsQuery->selectRaw("'User' as user_name");
    }
    
    if ($hasEmailColumn) {
        $topDonorsQuery->addSelect('users.email as user_email');
    }
    
    // Add aggregation columns    
    $topDonorsQuery->addSelect(
        DB::raw('COUNT(donations.id) as donations_count'),
        DB::raw('SUM(donations.amount) as total_amount'),
        DB::raw('MAX(donations.created_at) as last_donation')
    );
    
    // Add time filter
    if ($range !== 'all') {
        $topDonorsQuery->where('donations.created_at', '>=', now()->subDays(intval($range)));
    }
    
    // Setup grouping, ensuring we only group by columns that exist
    $groupColumns = ['users.id'];
    if ($hasNameColumn) {
        $groupColumns[] = 'users.name';
    }
    if ($hasEmailColumn) {
        $groupColumns[] = 'users.email';
    }
    
    // Get the top donors
    $topDonors = $topDonorsQuery
        ->groupBy($groupColumns)
        ->orderByDesc('total_amount')
        ->limit(10)
        ->get();
        
    return view('admin.donations.statistics', compact(
        'totalDonations',
        'donationsCount',
        'avgDonationAmount',
        'uniqueDonors',
        'donationGrowth',
        'donationsByActivity',
        'topActivityAmount',
        'donationSizeDistribution',
        'topDonors',
        'range'
    ));
}
}