<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Dashboard</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f8f9fa;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            z-index: 100;
            transition: all 0.3s;
        }

        .main-content {
            margin-left: 250px;
            transition: all 0.3s;
        }

        @media (max-width: 768px) {
            .sidebar {
                margin-left: -250px;
            }

            .sidebar.active {
                margin-left: 0;
            }

            .main-content {
                margin-left: 0;
            }
        }

        .nav-link {
            padding: 0.8rem 1rem;
            border-radius: 5px;
            margin-bottom: 5px;
            transition: all 0.2s;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transform: translateX(5px);
        }

        .card-dashboard {
            transition: all 0.3s;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            height: 100%;
        }

        .card-dashboard:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .toggle-sidebar {
            display: none;
        }

        @media (max-width: 768px) {
            .toggle-sidebar {
                display: block;
            }
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar bg-dark text-white" style="width: 250px; min-height: 100vh;" id="sidebar">
            <div class="p-3">
                <h4 class="text-center mb-4">Administrator Control Panel</h4>

                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center active"
                            href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i> Home
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center" href="{{ route('users.index') }}">
                            <i class="fas fa-users me-2"></i> User Management
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center" href="{{ route('activities.index') }}">
                            <i class="fas fa-calendar-alt me-2"></i> Activities Management
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center" href="{{ route('posts.index') }}">
                            <i class="fas fa-file-alt me-2"></i> Publications Management
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center" href="{{ route('comments.index') }}">
                            <i class="fas fa-comments me-2"></i> Comments Management
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white d-flex align-items-center" href="{{ route('donations.index') }}">
                            <i class="fas fa-hand-holding-usd me-2"></i> Donation Management
                        </a>
                    </li>
                </ul>

                <hr class="my-4">

                <div class="d-flex justify-content-center">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm">
                            <i class="fas fa-sign-out-alt me-1"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content flex-grow-1 p-4" id="main-content">
            <nav class="navbar navbar-expand-lg navbar-light bg-white mb-4 rounded shadow-sm">
                <div class="container-fluid">
                    <button class="btn btn-dark toggle-sidebar" id="toggleSidebar">
                        <i class="fas fa-bars"></i>
                    </button>

                    <h5 class="mb-0 ms-2">Dashboard Overview</h5>

                    <div class="ms-auto d-flex align-items-center">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="userDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="https://ui-avatars.com/api/?name=Admin+User&background=random"
                                    class="rounded-circle me-2" width="30" height="30">
                                Admin User
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profile</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Settings</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Stats Cards -->
            <div class="row my-4">
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
                                    <a href="{{ route('activities.create') }}" class="text-decoration-none">
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

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Mobile sidebar toggle
        document.getElementById('toggleSidebar').addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>
</body>

</html>