<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Donation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'activity_id',
        'amount',
        'donated_at',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'donated_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that made the donation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the activity that the donation was made for.
     */
    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
    
    /**
     * Scope a query to only include donations within a date range.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int|string  $days
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDateRange(Builder $query, $days)
    {
        if ($days !== 'all') {
            return $query->where('created_at', '>=', now()->subDays(intval($days)));
        }
        
        return $query;
    }
    
    /**
     * Scope a query to get donations by size category.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $size  ('small', 'medium', 'large', 'major')
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBySize(Builder $query, $size)
    {
        switch ($size) {
            case 'small':
                return $query->where('amount', '<=', 50);
            case 'medium':
                return $query->whereBetween('amount', [50.01, 200]);
            case 'large':
                return $query->whereBetween('amount', [200.01, 500]);
            case 'major':
                return $query->where('amount', '>', 500);
            default:
                return $query;
        }
    }
    
    /**
     * Scope a query to get monthly donation statistics.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $months
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMonthlyStats(Builder $query, $months = 6)
    {
        return $query->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(amount) as total')
            ->where('created_at', '>=', now()->subMonths($months))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month');
    }
    
    /**
     * Scope a query to get daily donation statistics.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $days
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDailyStats(Builder $query, $days = 30)
    {
        return $query->selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date');
    }
    
    /**
     * Scope a query to get donations by day of the week.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $days  Period to consider
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByDayOfWeek(Builder $query, $days = 30)
    {
        return $query->selectRaw('DAYOFWEEK(created_at) as day, SUM(amount) as total')
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('day')
            ->orderBy('day');
    }
    
    /**
     * Get donation size distribution statistics.
     *
     * @param  int|string  $days
     * @return array
     */
    public static function getSizeDistribution($days = 30)
    {
        $baseQuery = self::dateRange($days);
        $total = $baseQuery->count();
        
        if ($total === 0) {
            return [
                'small' => ['count' => 0, 'percentage' => 0],
                'medium' => ['count' => 0, 'percentage' => 0],
                'large' => ['count' => 0, 'percentage' => 0],
                'major' => ['count' => 0, 'percentage' => 0]
            ];
        }
        
        $small = $baseQuery->clone()->bySize('small')->count();
        $medium = $baseQuery->clone()->bySize('medium')->count();
        $large = $baseQuery->clone()->bySize('large')->count();
        $major = $baseQuery->clone()->bySize('major')->count();
        
        return [
            'small' => [
                'count' => $small,
                'percentage' => round(($small / $total) * 100, 1)
            ],
            'medium' => [
                'count' => $medium,
                'percentage' => round(($medium / $total) * 100, 1)
            ],
            'large' => [
                'count' => $large,
                'percentage' => round(($large / $total) * 100, 1)
            ],
            'major' => [
                'count' => $major,
                'percentage' => round(($major / $total) * 100, 1)
            ]
        ];
    }
    
    /**
     * Format monthly donation data for charts.
     *
     * @param  \Illuminate\Support\Collection  $donations
     * @return array
     */
    public static function formatMonthlyChartData($donations)
    {
        $labels = [];
        $data = [];
        
        foreach ($donations as $donation) {
            $date = Carbon::createFromDate($donation->year, $donation->month, 1);
            $labels[] = $date->format('M Y');
            $data[] = $donation->total;
        }
        
        return [$labels, $data];
    }
}