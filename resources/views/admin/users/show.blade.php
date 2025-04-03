@extends('layouts.admin')

@section('title', 'User Details')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"
                                class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}"
                                class="text-decoration-none">Users</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>
                    </ol>
                </nav>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="mb-0">User Details</h2>
                    <div>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">
                            <i class="bi bi-pencil-square me-1"></i> Edit
                        </a>
                        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary ms-2">
                            <i class="bi bi-arrow-left me-1"></i> Back
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 mb-4">
                <!-- User Profile Card -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center pt-4">
                        <div class="avatar mb-3">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}"
                                    class="img-fluid rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                            @else
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 100px; height: 100px; margin: 0 auto;">
                                    <span class="fs-1">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <h4 class="card-title mb-1">{{ $user->name }}</h4>
                        <p class="text-muted mb-2">{{ $user->email }}</p>
                        <div class="mb-3">
                            <span class="badge bg-{{ $user->is_admin ? 'danger' : 'success' }} rounded-pill px-3 py-2">
                                {{ $user->is_admin ? 'Administrator' : 'Volunteer' }}
                            </span>
                        </div>
                        <p class="card-text text-muted">
                            <i class="bi bi-calendar3 me-2"></i> Joined {{ $user->created_at->format('M d, Y') }}
                        </p>
                    </div>
                    <div class="card-footer bg-light border-0">
                        <div class="d-flex justify-content-around">
                            <div class="text-center">
                                <h5 class="mb-0">{{ isset($user->donations) ? $user->donations->count() : 0 }}</h5>
                                <small class="text-muted">Donations</small>
                            </div>
                            <div class="text-center">
                                <h5 class="mb-0">{{ $user->volunteer_hours ?? 0 }}</h5>
                                <small class="text-muted">Hours</small>
                            </div>
                            <div class="text-center">
                                <h5 class="mb-0">
                                    ${{ isset($user->donations) ? number_format($user->donations->sum('amount'), 2) : '0.00' }}
                                </h5>
                                <small class="text-muted">Total</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <!-- User Details -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0">
                        <h5 class="card-title mb-0">Personal Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4 text-muted">Full Name</div>
                            <div class="col-md-8">{{ $user->name }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 text-muted">Email Address</div>
                            <div class="col-md-8">{{ $user->email }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 text-muted">Phone Number</div>
                            <div class="col-md-8">{{ $user->phone ?? 'Not provided' }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4 text-muted">Address</div>
                            <div class="col-md-8">{{ $user->address ?? 'Not provided' }}</div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 text-muted">Account Status</div>
                            <div class="col-md-8">
                                <span class="badge bg-{{ $user->is_active ? 'success' : 'warning' }} rounded-pill">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Donations -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Recent Donations</h5>
                        <a href="{{ route('donations.index', ['user_id' => $user->id]) }}"
                            class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Campaign</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($user->donations) && $user->donations->count() > 0)
                                        @foreach($user->donations->take(5) as $donation)
                                            <tr>
                                                <td>{{ $donation->created_at->format('M d, Y') }}</td>
                                                <td>{{ $donation->campaign->name ?? 'N/A' }}</td>
                                                <td>${{ number_format($donation->amount, 2) }}</td>
                                                <td>
                                                    <span
                                                        class="badge bg-{{ $donation->status == 'completed' ? 'success' : ($donation->status == 'pending' ? 'warning' : 'danger') }}">
                                                        {{ ucfirst($donation->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center py-3">No donations found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Volunteer Activity -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Volunteer Activity</h5>
                        <a href="{{ route('activities.index', ['user_id' => $user->id]) }}"
                            class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Event</th>
                                        <th>Hours</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($user->volunteerActivities) && $user->volunteerActivities->count() > 0)
                                        @foreach($user->volunteerActivities->take(5) as $activity)
                                            <tr>
                                                <td>{{ $activity->date->format('M d, Y') }}</td>
                                                <td>{{ $activity->event->name ?? 'N/A' }}</td>
                                                <td>{{ $activity->hours }}</td>
                                                <td>
                                                    <span
                                                        class="badge bg-{{ $activity->status == 'completed' ? 'success' : ($activity->status == 'pending' ? 'warning' : 'info') }}">
                                                        {{ ucfirst($activity->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center py-3">No volunteer activity found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
    <style>
        .avatar {
            display: inline-block;
            position: relative;
        }

        .card {
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .card-header {
            border-top-left-radius: 10px !important;
            border-top-right-radius: 10px !important;
        }

        .badge {
            font-weight: 500;
        }

        .table> :not(caption)>*>* {
            padding: 0.75rem 1.25rem;
        }
    </style>
@endpush