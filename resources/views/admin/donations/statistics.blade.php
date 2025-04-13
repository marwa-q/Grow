@extends('admin.layout')

@section('title', 'Donation Statistics')

@section('page-title', 'Donation Statistics')

@section('styles')
<style>
    .stats-card {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 20px;
    }
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.15);
    }
    .stats-icon {
        font-size: 3rem;
        opacity: 0.8;
    }
    .stats-value {
        font-size: 2.5rem;
        font-weight: 700;
    }
    .chart-container {
        position: relative;
        height: 350px;
        margin-bottom: 30px;
    }
    .activity-card {
        transition: all 0.3s ease;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 20px;
    }
    .activity-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    .progress {
        height: 10px;
        border-radius: 5px;
    }
    .back-button {
        display: inline-flex;
        align-items: center;
        padding: 8px 16px;
        border-radius: 50px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .back-button:hover {
        transform: translateX(-5px);
    }
    .donor-card {
        transition: all 0.3s ease;
        border-radius: 10px;
        overflow: hidden;
    }
    .donor-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }
    .donor-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        object-fit: cover;
    }
    .donation-size-pill {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    .time-filter {
        width: auto;
        display: inline-block;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <a href="{{ route('donations.index') }}" class="btn btn-outline-secondary back-button">
            <i class="fas fa-arrow-left me-2"></i> Back to Donations
        </a>
        
        <div>
            <select id="timeRangeFilter" class="form-select form-select-sm time-filter">
                <option value="7" {{ request('range') == '7' ? 'selected' : '' }}>Last 7 Days</option>
                <option value="30" {{ request('range') == '30' || !request('range') ? 'selected' : '' }}>Last 30 Days</option>
                <option value="90" {{ request('range') == '90' ? 'selected' : '' }}>Last 3 Months</option>
                <option value="180" {{ request('range') == '180' ? 'selected' : '' }}>Last 6 Months</option>
                <option value="365" {{ request('range') == '365' ? 'selected' : '' }}>Last Year</option>
                <option value="all" {{ request('range') == 'all' ? 'selected' : '' }}>All Time</option>
            </select>
        </div>
    </div>

    <!-- Main Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card card bg-primary text-white h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-2">Total Donations</h6>
                            <div class="stats-value">{{ number_format($totalDonations, 2) }} SR</div>
                            @if(isset($donationGrowth))
                            <div class="mt-2 {{ $donationGrowth >= 0 ? 'text-light' : 'text-danger' }}">
                                <i class="fas {{ $donationGrowth >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                                {{ abs($donationGrowth) }}% from previous period
                            </div>
                            @endif
                        </div>
                        <div>
                            <i class="fas fa-hand-holding-usd stats-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card card bg-success text-white h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-2">Donations Count</h6>
                            <div class="stats-value">{{ number_format($donationsCount ?? 0) }}</div>
                        </div>
                        <div>
                            <i class="fas fa-donate stats-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card card bg-info text-white h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-2">Avg. Donation</h6>
                            <div class="stats-value">{{ number_format($avgDonationAmount ?? 0, 2) }} SR</div>
                        </div>
                        <div>
                            <i class="fas fa-chart-line stats-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stats-card card bg-warning text-white h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-2">Unique Donors</h6>
                            <div class="stats-value">{{ number_format($uniqueDonors ?? 0) }}</div>
                        </div>
                        <div>
                            <i class="fas fa-users stats-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Donation Size Chart -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i> Donation Size Distribution</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="height: 300px">
                        <canvas id="donationSizeChart"></canvas>
                    </div>
                    
                    <div class="donation-size-legend mt-3">
                        <div class="d-flex justify-content-between mb-2">
                            <div><span class="badge bg-primary me-2">Small</span> $1-$50</div>
                            <div><strong>{{ isset($donationSizeDistribution['small']) ? $donationSizeDistribution['small']['percentage'] : 0 }}%</strong></div>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <div><span class="badge bg-success me-2">Medium</span> $51-$200</div>
                            <div><strong>{{ isset($donationSizeDistribution['medium']) ? $donationSizeDistribution['medium']['percentage'] : 0 }}%</strong></div>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <div><span class="badge bg-warning me-2">Large</span> $201-$500</div>
                            <div><strong>{{ isset($donationSizeDistribution['large']) ? $donationSizeDistribution['large']['percentage'] : 0 }}%</strong></div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div><span class="badge bg-danger me-2">Major</span> $501+</div>
                            <div><strong>{{ isset($donationSizeDistribution['major']) ? $donationSizeDistribution['major']['percentage'] : 0 }}%</strong></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Top Donors -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-trophy me-2"></i> Top Donors</h5>
                    <a href="{{ route('donations.index') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Donor</th>
                                    <th>Total Amount</th>
                                    <th>Donations</th>
                                    <th>Last Donation</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topDonors ?? [] as $donor)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($donor->user_name ?? 'Anonymous') }}&background=random" 
                                                class="donor-avatar me-2" alt="Donor Avatar">
                                            <div>
                                                <h6 class="mb-0">{{ $donor->user_name ?? 'Anonymous' }}</h6>
                                                @if(isset($donor->user_email))
                                                <small class="text-muted">{{ $donor->user_email }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td><strong>{{ number_format($donor->total_amount ?? 0, 2) }} SR</strong></td>
                                    <td>{{ number_format($donor->donations_count ?? 0) }}</td>
                                    <td>{{ isset($donor->last_donation) ? \Carbon\Carbon::parse($donor->last_donation)->format('M d, Y') : 'N/A' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <p class="mb-0 text-muted">No donor data available</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Donations by Activity -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i> Donations by Activity</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Activity</th>
                            <th>Number of Donations</th>
                            <th>Total Amount</th>
                            <th>Average Amount</th>
                            <th>Progress</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($donationsByActivity ?? [] as $activity)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-info-subtle text-info rounded-circle p-2 me-2">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                    <span>{{ $activity->activity_title ?? $activity->title ?? 'General Donations' }}</span>
                                </div>
                            </td>
                            <td>{{ number_format($activity->donations_count ?? 0) }}</td>
                            <td>{{ number_format($activity->total_amount ?? $activity->total_donations ?? 0, 2) }} SR</td>
                            <td>{{ number_format($activity->avg_donation ?? 0, 2) }} SR</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="progress flex-grow-1" style="height: 8px;">
                                        <div class="progress-bar bg-info" role="progressbar" 
                                            style="width: {{ min(100, ($activity->total_amount ?? $activity->total_donations ?? 0) / ($topActivityAmount ?? 1) * 100) }}%"></div>
                                    </div>
                                    <span class="ms-2 small">{{ round((($activity->total_amount ?? $activity->total_donations ?? 0) / ($totalDonations > 0 ? $totalDonations : 1)) * 100) }}%</span>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <p class="mb-0 text-muted">No donation data available</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Setup time range filter
    const timeRangeFilter = document.getElementById('timeRangeFilter');
    if (timeRangeFilter) {
        timeRangeFilter.addEventListener('change', function() {
            const days = this.value;
            window.location.href = `${window.location.pathname}?range=${days}`;
        });
    }
    
    // Donation Size Distribution Chart
    const donationSizeCtx = document.getElementById('donationSizeChart');
    if (donationSizeCtx) {
        new Chart(donationSizeCtx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Small ($1-$50)', 'Medium ($51-$200)', 'Large ($201-$500)', 'Major ($501+)'],
                datasets: [{
                    data: [
                        {{ $donationSizeDistribution['small']['percentage'] ?? 0 }},
                        {{ $donationSizeDistribution['medium']['percentage'] ?? 0 }},
                        {{ $donationSizeDistribution['large']['percentage'] ?? 0 }},
                        {{ $donationSizeDistribution['major']['percentage'] ?? 0 }}
                    ],
                    backgroundColor: [
                        'rgba(13, 110, 253, 0.7)',
                        'rgba(25, 135, 84, 0.7)',
                        'rgba(255, 193, 7, 0.7)',
                        'rgba(220, 53, 69, 0.7)'
                    ],
                    borderColor: [
                        'rgba(13, 110, 253, 1)',
                        'rgba(25, 135, 84, 1)',
                        'rgba(255, 193, 7, 1)',
                        'rgba(220, 53, 69, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.label}: ${context.parsed}%`;
                            }
                        }
                    }
                },
                cutout: '65%'
            }
        });
    }
});
</script>
@endsection