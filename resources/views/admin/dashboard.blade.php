@extends('admin.layout') <!-- Assuming the layout file is named layout.blade.php -->

@section('title', 'Admin Dashboard')

@section('content')
<div class="d-flex">

        <!-- Main Content -->
        <div class="main-content flex-grow-1 p-4" id="main-content">
            <!-- Stats Cards -->
            <div class="row mb-4">
                <!-- Total Users Box -->
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Total Users</h6>
                                <h2 class="mb-0">{{ number_format($totalUsers) }}</h2>
                                <div class="{{ $userGrowth >= 0 ? 'text-success' : 'text-danger' }}">
                                    <i class="bi {{ $userGrowth >= 0 ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i>
                                    {{ abs($userGrowth) }}%
                                </div>
                            </div>
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 60px; height: 60px;">
                                <i class="bi bi-people text-white fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activities Box -->
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Activities</h6>
                                <h2 class="mb-0">{{ number_format($totalActivities) }}</h2>
                                <div class="{{ $activityGrowth >= 0 ? 'text-success' : 'text-danger' }}">
                                    <i class="bi {{ $activityGrowth >= 0 ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i>
                                    {{ abs($activityGrowth) }}%
                                </div>
                            </div>
                            <div class="bg-success rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 60px; height: 60px;">
                                <i class="bi bi-calendar-event text-white fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Posts Box -->
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Posts</h6>
                                <h2 class="mb-0">{{ number_format($totalPosts) }}</h2>
                                <div class="{{ $postGrowth >= 0 ? 'text-success' : 'text-danger' }}">
                                    <i class="bi {{ $postGrowth >= 0 ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i>
                                    {{ abs($postGrowth) }}%
                                </div>
                            </div>
                            <div class="bg-info rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 60px; height: 60px;">
                                <i class="bi bi-file-text text-white fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Donations Box -->
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Donations</h6>
                                <h2 class="mb-0">${{ number_format($totalDonations) }}</h2>
                                <div class="{{ $donationGrowth >= 0 ? 'text-success' : 'text-danger' }}">
                                    <i class="bi {{ $donationGrowth >= 0 ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i>
                                    {{ abs($donationGrowth) }}%
                                </div>
                            </div>
                            <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 60px; height: 60px;">
                                <i class="bi bi-cash-coin text-white fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="card card-dashboard">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Recent Activities</h5>
                            <a href="{{ route('activities.index') }}" class="btn btn-sm btn-outline-primary">View All
                                Activities</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
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
                                            <td>Community Workshop</td>
                                            <td>Apr 02, 2025</td>
                                            <td><span class="badge bg-success">Active</span></td>
                                            <td>45</td>
                                        </tr>
                                        <tr>
                                            <td>Fundraising Event</td>
                                            <td>Mar 28, 2025</td>
                                            <td><span class="badge bg-success">Active</span></td>
                                            <td>78</td>
                                        </tr>
                                        <tr>
                                            <td>Youth Conference</td>
                                            <td>Mar 20, 2025</td>
                                            <td><span class="badge bg-warning">Pending</span></td>
                                            <td>120</td>
                                        </tr>
                                        <tr>
                                            <td>Awareness Campaign</td>
                                            <td>Mar 15, 2025</td>
                                            <td><span class="badge bg-danger">Cancelled</span></td>
                                            <td>38</td>
                                        </tr>
                                        <tr>
                                            <td>Community Service</td>
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

                <!-- resources/views/components/comments-section.blade.php -->
                <div class="col-md-4">
                    @include('components.recent-comments', ['comments' => $recentComments])
                </div>
            </div>

            <!-- Donation Statistics -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-dashboard">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Recent Donations</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary text-white rounded-circle p-2 me-3">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Anonymous</h6>
                                            <span class="text-muted small">Apr 1, 2025</span>
                                        </div>
                                    </div>
                                    <span class="badge bg-success rounded-pill p-2">$1,500</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary text-white rounded-circle p-2 me-3">
                                            <i class="fas fa-building"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">ABC Corporation</h6>
                                            <span class="text-muted small">Mar 30, 2025</span>
                                        </div>
                                    </div>
                                    <span class="badge bg-success rounded-pill p-2">$5,000</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary text-white rounded-circle p-2 me-3">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Robert Williams</h6>
                                            <span class="text-muted small">Mar 28, 2025</span>
                                        </div>
                                    </div>
                                    <span class="badge bg-success rounded-pill p-2">$750</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary text-white rounded-circle p-2 me-3">
                                            <i class="fas fa-building"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">XYZ Foundation</h6>
                                            <span class="text-muted small">Mar 25, 2025</span>
                                        </div>
                                    </div>
                                    <span class="badge bg-success rounded-pill p-2">$3,200</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card card-dashboard">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Quick Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <a href="{{ route('users.create') }}" class="text-decoration-none">
                                        <div class="card bg-primary text-white btn">
                                            <div class="card-body text-center py-4">
                                                <i class="fas fa-user-plus fa-2x mb-3"></i>
                                                <h5>Add User</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('dashboard.activities.create') }}" class="text-decoration-none">
                                        <div class="card bg-success text-white">
                                            <div class="card-body text-center py-4">
                                                <i class="fas fa-calendar-plus fa-2x mb-3"></i>
                                                <h5>Add Activity</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('posts.create') }}" class="text-decoration-none">
                                        <div class="card bg-info text-white">
                                            <div class="card-body text-center py-4">
                                                <i class="fas fa-file-upload fa-2x mb-3"></i>
                                                <h5>New Post</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('donations.index') }}" class="text-decoration-none">
                                        <div class="card bg-warning text-white">
                                            <div class="card-body text-center py-4">
                                                <i class="fas fa-chart-line fa-2x mb-3"></i>
                                                <h5>Reports</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
