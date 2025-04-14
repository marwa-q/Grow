@extends('admin.layout')

@section('title', 'Admin Dashboard')

@section('page-title', 'Dashboard Overview')

@section('content')
<div class="row my-4">
    <!-- Total Users Box -->
    <div class="col-md-3 mb-4">
        <div class="card stat-card h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Total Users</h6>
                    <h2 class="mb-0">{{ number_format($totalUsers) }}</h2>
                    <div class="{{ $userGrowth >= 0 ? 'text-success' : 'text-danger' }} small mt-2">
                        {{-- <i class="bi {{ $userGrowth >= 0 ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i> --}}
                        {{-- {{ abs($userGrowth) }}% from last month --}}
                    </div>
                </div>
                <div class="stat-icon bg-primary-subtle text-primary">
                    <i class="bi bi-people"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Activities Box -->
    <div class="col-md-3 mb-4">
        <div class="card stat-card h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Activities</h6>
                    <h2 class="mb-0">{{ number_format($totalActivities) }}</h2>
                    <div class="{{ $activityGrowth >= 0 ? 'text-success' : 'text-danger' }} small mt-2">
                        {{-- <i class="bi {{ $activityGrowth >= 0 ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i> --}}
                        {{-- {{ abs($activityGrowth) }}% from last month --}}
                    </div>
                </div>
                <div class="stat-icon bg-success-subtle text-success">
                    <i class="bi bi-calendar-event"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Posts Box -->
    <div class="col-md-3 mb-4">
        <div class="card stat-card h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Posts</h6>
                    <h2 class="mb-0">{{ number_format($totalPosts) }}</h2>
                    <div class="{{ $postGrowth >= 0 ? 'text-success' : 'text-danger' }} small mt-2">
                        {{-- <i class="bi {{ $postGrowth >= 0 ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i> --}}
                        {{-- {{ abs($postGrowth) }}% from last month --}}
                    </div>
                </div>
                <div class="stat-icon bg-info-subtle text-info">
                    <i class="bi bi-file-text"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Donations Box -->
    <div class="col-md-3 mb-4">
        <div class="card stat-card h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-1">Donations</h6>
                    <h2 class="mb-0">${{ number_format($totalDonations ?? 0) }}</h2>
                    <div class="{{ $donationGrowth >= 0 ? 'text-success' : 'text-danger' }} small mt-2">
                        {{-- <i class="bi {{ $donationGrowth >= 0 ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i> --}}
                        {{-- {{ abs($donationGrowth) }}% from last month --}}
                    </div>
                </div>
                <div class="stat-icon bg-warning-subtle text-warning">
                    <i class="bi bi-cash-coin"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="row mb-4">
    <!-- Monthly Donations Chart -->
    <div class="col-md-8 mb-4">
        <div class="card stat-card h-100">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Monthly Donations Trend</h5>
            </div>
            <div class="card-body">
                <canvas id="monthlyDonationsChart" style="width: 100%; height: 300px;"></canvas>
            </div>
        </div>
    </div>

    <!-- Donations by Activity Pie Chart -->
    <div class="col-md-4 mb-4">
        <div class="card stat-card h-100">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Donations by Activity</h5>
            </div>
            <div class="card-body">
                <canvas id="donationsPieChart" style="width: 100%; height: 300px;"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities and Comments -->
<div class="row mb-4">
    <div class="col-md-8 mb-4">
        <div class="card stat-card h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0">Recent Activities</h5>
                <a href="{{ route('activities.index') }}" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-dashboard mb-0">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Participants</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="activity-icon bg-primary-subtle text-primary rounded-circle p-2 me-2">
                                            <i class="bi bi-people-fill"></i>
                                        </div>
                                        <span>Community Workshop</span>
                                    </div>
                                </td>
                                <td>Apr 02, 2025</td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td>45</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="activity-icon bg-warning-subtle text-warning rounded-circle p-2 me-2">
                                            <i class="bi bi-cash"></i>
                                        </div>
                                        <span>Fundraising Event</span>
                                    </div>
                                </td>
                                <td>Mar 28, 2025</td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td>78</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="activity-icon bg-info-subtle text-info rounded-circle p-2 me-2">
                                            <i class="bi bi-chat-dots"></i>
                                        </div>
                                        <span>Youth Conference</span>
                                    </div>
                                </td>
                                <td>Mar 20, 2025</td>
                                <td><span class="badge bg-warning">Pending</span></td>
                                <td>120</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="activity-icon bg-danger-subtle text-danger rounded-circle p-2 me-2">
                                            <i class="bi bi-megaphone"></i>
                                        </div>
                                        <span>Awareness Campaign</span>
                                    </div>
                                </td>
                                <td>Mar 15, 2025</td>
                                <td><span class="badge bg-danger">Cancelled</span></td>
                                <td>38</td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="activity-icon bg-secondary-subtle text-secondary rounded-circle p-2 me-2">
                                            <i class="bi bi-heart"></i>
                                        </div>
                                        <span>Community Service</span>
                                    </div>
                                </td>
                                <td>Mar 10, 2025</td>
                                <td><span class="badge bg-secondary">Completed</span></td>
                                <td>92</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Comments Section -->
    <div class="col-md-4 mb-4">
        <div class="card stat-card h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0">Recent Comments</h5>
                <a href="{{ route('comments.index') }}" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($recentComments ?? [] as $comment)
                        <li class="list-group-item border-0 px-3 py-3">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <img src="{{ $comment->user?->avatar ?? 'https://ui-avatars.com/api/?name=Anonymous&background=random' }}" 
                                         class="rounded-circle" width="40" height="40" alt="User Avatar">
                                </div>
                                <div class="ms-3">
                                    <div class="d-flex align-items-center">
                                        <h6 class="mb-0">{{ $comment->user?->name ?? 'Anonymous' }}</h6>
                                        <small class="text-muted ms-2">
                                            {{ $comment->created_at ? $comment->created_at->diffForHumans() : 'Recently' }}
                                        </small>
                                    </div>
                                    <p class="mb-0 text-muted small">
                                        On: <a href="{{ route('posts.show', $comment->post?->id ?? 0) }}">
                                            {{ $comment->post?->title ?? 'Untitled Post' }}
                                        </a>
                                    </p>
                                    <p class="mb-0 mt-1">
                                        {{ \Illuminate\Support\Str::limit($comment->content ?? 'No content', 100) }}
                                    </p>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item text-center py-4">
                            <p class="mb-0 text-muted">No comments yet</p>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Donations by Day of Week Chart and Recent Donations -->
<div class="row">
    <!-- Donations by Day of Week Bar Chart -->
    <div class="col-md-6 mb-4">
        <div class="card stat-card h-100">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Donations by Day of Week</h5>
            </div>
            <div class="card-body">
                <canvas id="donationsByDayChart" style="width: 100%; height: 250px;"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Donations -->
    <div class="col-md-6 mb-4">
        <div class="card stat-card h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0">Recent Donations</h5>
                <a href="{{ route('donations.index') }}" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @forelse($recentDonations ?? [] as $donation)
                    <li class="list-group-item d-flex justify-content-between align-items-center py-3 px-0 border-bottom">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle p-2 me-3 {{ $donation->activity_id ? 'bg-info-subtle text-info' : 'bg-primary-subtle text-primary' }}">
                                <i class="fas {{ $donation->activity_id ? 'fa-calendar-alt' : 'fa-user' }}"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">{{ $donation->user ? $donation->user->name : 'Anonymous' }}</h6>
                                <span class="text-muted small">
                                    {{ $donation->created_at ? $donation->created_at->format('M d, Y') : 'Recent' }}
                                    @if($donation->activity)
                                        - {{ $donation->activity->title }}
                                    @endif
                                </span>
                            </div>
                        </div>
                        <span class="badge bg-success rounded-pill p-2">${{ number_format($donation->amount, 2) }}</span>
                    </li>
                    @empty
                        <li class="list-group-item text-center py-4">
                            <p class="mb-0 text-muted">No recent donations</p>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Bottom Section: Quick Actions -->
<div class="row">
    <!-- Quick Actions -->
    <div class="col-12 mb-4">
        <div class="card stat-card h-100">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <a href="{{ route('users.create') }}" class="text-decoration-none">
                            <div class="card bg-primary bg-opacity-10 h-100 border-0">
                                <div class="card-body text-center py-4">
                                    <div class="mb-3 mx-auto d-flex align-items-center justify-content-center rounded-circle bg-primary text-white" style="width: 50px; height: 50px;">
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                    <h5 class="text-primary">Add User</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('dashboard.activities.create') }}" class="text-decoration-none">
                            <div class="card bg-success bg-opacity-10 h-100 border-0">
                                <div class="card-body text-center py-4">
                                    <div class="mb-3 mx-auto d-flex align-items-center justify-content-center rounded-circle bg-success text-white" style="width: 50px; height: 50px;">
                                        <i class="fas fa-calendar-plus"></i>
                                    </div>
                                    <h5 class="text-success">Add Activity</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('posts.create') }}" class="text-decoration-none">
                            <div class="card bg-info bg-opacity-10 h-100 border-0">
                                <div class="card-body text-center py-4">
                                    <div class="mb-3 mx-auto d-flex align-items-center justify-content-center rounded-circle bg-info text-white" style="width: 50px; height: 50px;">
                                        <i class="fas fa-file-upload"></i>
                                    </div>
                                    <h5 class="text-info">New Post</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('donations.index') }}" class="text-decoration-none">
                            <div class="card bg-warning bg-opacity-10 h-100 border-0">
                                <div class="card-body text-center py-4">
                                    <div class="mb-3 mx-auto d-flex align-items-center justify-content-center rounded-circle bg-warning text-white" style="width: 50px; height: 50px;">
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                    <h5 class="text-warning">Reports</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
       
       const monthlyDonationsCtx = document.getElementById('monthlyDonationsChart').getContext('2d');
       const monthlyDonationsChart = new Chart(monthlyDonationsCtx, {
           type: 'line',
           data: {
               labels: @json($chartLabels ?? []),
               datasets: [{
                   label: 'Donations ($)',
                   data: @json($chartData ?? []),
                   backgroundColor: 'rgba(255, 193, 7, 0.2)',
                   borderColor: 'rgba(255, 193, 7, 1)',
                   borderWidth: 2,
                   tension: 0.3,
                   fill: true,
                   pointBackgroundColor: 'rgba(255, 193, 7, 1)',
                   pointBorderColor: '#fff',
                   pointBorderWidth: 2,
                   pointRadius: 5,
                   pointHoverRadius: 7
               }]
           },
           options: {
               responsive: true,
               maintainAspectRatio: false,
               plugins: {
                   legend: {
                       position: 'top',
                   },
                   tooltip: {
                       mode: 'index',
                       intersect: false,
                       callbacks: {
                           label: function(context) {
                               return '$' + context.parsed.y.toLocaleString();
                           }
                       }
                   }
               },
               scales: {
                   y: {
                       beginAtZero: true,
                       ticks: {
                           callback: function(value) {
                               return '$' + value.toLocaleString();
                           }
                       }
                   }
               }
           }
       });

       // Donations by Activity Pie Chart
       const donationsPieCtx = document.getElementById('donationsPieChart').getContext('2d');
       const donationsPieChart = new Chart(donationsPieCtx, {
           type: 'pie',
           data: {
               labels: {!! json_encode($pieLabels ?? []) !!},
               datasets: [{
                   data: {!! json_encode($pieData ?? []) !!},
                   backgroundColor: [
                       'rgba(54, 162, 235, 0.7)',
                       'rgba(255, 99, 132, 0.7)',
                       'rgba(255, 206, 86, 0.7)',
                       'rgba(75, 192, 192, 0.7)',
                       'rgba(153, 102, 255, 0.7)',
                       'rgba(255, 159, 64, 0.7)'
                   ],
                   borderColor: [
                       'rgba(54, 162, 235, 1)',
                       'rgba(255, 99, 132, 1)',
                       'rgba(255, 206, 86, 1)',
                       'rgba(75, 192, 192, 1)',
                       'rgba(153, 102, 255, 1)',
                       'rgba(255, 159, 64, 1)'
                   ],
                   borderWidth: 1
               }]
           },
           options: {
               responsive: true,
               maintainAspectRatio: false,
               plugins: {
                   legend: {
                       position: 'right',
                       labels: {
                           boxWidth: 15,
                           padding: 10
                       }
                   },
                   tooltip: {
                       callbacks: {
                           label: function(context) {
                               const label = context.label || '';
                               const value = context.parsed || 0;
                               const total = context.dataset.data.reduce((acc, val) => acc + val, 0);
                               const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                               return `${label}: $${value.toLocaleString()} (${percentage}%)`;
                           }
                       }
                   }
               }
           }
       });

       // Donations by Day of Week Bar Chart
       const donationsByDayCtx = document.getElementById('donationsByDayChart').getContext('2d');
       const donationsByDayChart = new Chart(donationsByDayCtx, {
           type: 'bar',
           data: {
               labels: {!! json_encode($daysOfWeek ?? []) !!},
               datasets: [{
                   label: 'Donations ($)',
                   data: {!! json_encode($barData ?? []) !!},
                   backgroundColor: 'rgba(75, 192, 192, 0.6)',
                   borderColor: 'rgba(75, 192, 192, 1)',
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
                               return '$' + context.parsed.y.toLocaleString();
                           }
                       }
                   }
               },
               scales: {
                   y: {
                       beginAtZero: true,
                       ticks: {
                           callback: function(value) {
                               return '$' + value.toLocaleString();
                           }
                       }
                   }
               }
           }
       });
   });
</script>
@endsection