<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile | Grow Community</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --main-green: #2AC289;
            --dark-green: #1fa575;
            --light-gray: #f8f9fa;
            --medium-gray: #e9ecef;
        }



        .user-dropdown {
            background-color: #f8f9fa;
            border-radius: 30px;
            padding: 5px 15px;
            cursor: pointer;
        }

        .profile-header {
            background-color: var(--main-green);
            color: white;
            padding: 3rem 0 6rem;
            position: relative;
        }

        .profile-container {
            margin-top: -80px;
        }

        .profile-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 30px;
        }

        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-top: -75px;
            margin-bottom: 15px;
            object-fit: cover;
        }

        .profile-tabs .nav-link {
            color: #555;
            font-weight: 500;
            padding: 15px 20px;
            border: none;
            border-bottom: 2px solid transparent;
        }

        .profile-tabs .nav-link.active {
            color: var(--main-green);
            border-bottom: 2px solid var(--main-green);
            background-color: transparent;
        }

        .activity-item {
            border-left: 3px solid var(--main-green);
            padding-left: 15px;
            margin-bottom: 20px;
            position: relative;
        }

        .activity-date {
            color: #777;
            font-size: 0.85rem;
        }

        .badge-green {
            background-color: var(--main-green);
            color: white;
        }

        .profile-stat {
            text-align: center;
            padding: 15px 0;
        }

        .profile-stat h3 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 5px;
            color: var(--main-green);
        }

        .profile-stat p {
            font-size: 0.9rem;
            color: #777;
            margin-bottom: 0;
        }

        .btn-green {
            background-color: var(--main-green);
            color: white;
            border: none;
        }

        .btn-green:hover {
            background-color: var(--dark-green);
            color: white;
        }

        .footer {
            background-color: #333;
            color: white;
            padding: 2rem 0;
            margin-top: 3rem;
        }
    </style>
</head>

<body>

    @include('layouts.navigation')

    <div class="w-100">
        <h2 class="text-center mt-4">My Profile</h2>
    </div>
    <!-- Profile Content -->
    <div class="my-5 container profile-container">

    <!-- Flash Messages -->
<div class="row">
    <div class="col-12">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>
</div>
<!-- End Flash Messages -->
        <div class="row">
            <!-- Left Column - User Info -->
            <div class="col-lg-4 ">

                <div class="profile-card mb-4">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            {!! getProfileImage($user) !!}
                        </div>
                        <h4 class="mb-1">{{ $user->first_name }} {{ $user->last_name }}</h4>
                        <p class="text-muted">
                            <i class="bi bi-geo-alt-fill"></i> {{ $user->city ?? 'No location' }}
                        </p>
                        <span class="badge bg-secondary">{{ $user->role }}</span>
                    </div>
                </div>

                <!-- User Stats -->
                <div class="profile-card">
                    <h5 class="mb-3 text-center">Activity Summary</h5>
                    <div class="row">
                        <div class="col-6 profile-stat">
                            <h3 class="text-success">{{ $activityCount ?? 0 }}</h3>
                            <p>Activities</p>
                        </div>
                        <div class="col-6 profile-stat">
                            <h3 class="text-success">{{ $postCount ?? 0}}</h3>
                            <p>Posts</p>
                        </div>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="profile-card">
                    <h5 class="mb-3">Contact Information</h5>
                    <div class="mb-2">
                        <i class="fas fa-envelope me-2 text-muted"></i> <a href="mailto:{{ $user->email }}"
                            class="text-decoration-none">{{ $user->email }}</a>
                    </div>
                    <div class="mb-2">
                        <i class="fas fa-phone me-2 text-muted"></i>
                        <span>{{ $user->phone ?? '+962 7x xxx xxxx' }}</span>
                    </div>
                </div>
            </div>


            <!-- Right Column - Tabs and Content -->
            <div class="col-lg-8">
                <div class="profile-card p-0 overflow-hidden">
                    <!-- Tabs -->
                    <ul class="nav nav-tabs profile-tabs" id="profileTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="activities-tab" data-bs-toggle="tab"
                                data-bs-target="#activities" type="button" role="tab">My Activities</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="posts-tab" data-bs-toggle="tab" data-bs-target="#posts"
                                type="button" role="tab">My Posts</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings"
                                type="button" role="tab">Account Settings</button>
                        </li>
                    </ul>

                    <!-- Tab Contents -->
                    <div class="tab-content p-4" id="profileTabsContent">

                        <!-- Activities Tab -->
                        <div class="tab-pane fade show active" id="activities" role="tabpanel">
                            <h4 class="mb-4">Recent Activities</h4>

                            @if(isset($activities) && count($activities) > 0)
                                @foreach($activities as $activity)
                                    <div class="activity-item border-start border-success border-4 ps-3 mb-4">
                                        <!-- Activity content -->
                                    </div>
                                @endforeach
                            @else
                                <div class="alert alert-success">
                                    No activities found.
                                </div>
                            @endif

                            <div class="text-center mt-4">
                                <button class="btn btn-outline-secondary">View All Activities</button>
                            </div>
                        </div>

                        <!-- Posts Tab -->
                        <div class="tab-pane fade" id="posts" role="tabpanel">
                            <h4 class="mb-4">My Posts</h4>

                            @if(isset($posts) && count($posts) > 0)
                                @foreach($posts as $post)
                                    <div class="card mb-3">
                                        <!-- post content -->
                                    </div>
                                @endforeach
                            @else
                                <div class="alert alert-success">
                                    No posts found. Start sharing your experiences!
                                </div>
                            @endif

                            <div class="text-center mt-4">
                                <button class="btn btn-outline-secondary">View All Posts</button>
                            </div>
                        </div>

                        <!-- Settings Tab -->
                        <div class="tab-pane fade" id="settings" role="tabpanel">
                            <h4 class="mb-4">Account Settings</h4>

                            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="first_name" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name"
                                            value="{{ $user->first_name }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name"
                                            value="{{ $user->last_name }}">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ $user->email }}">
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" name="phone"
                                        value="{{ $user->phone }}" placeholder="Enter phone number">
                                </div>

                                <!-- Hidden role field to preserve current role -->
                                <input type="hidden" name="role" value="{{ $user->role }}">

                                <div class="mb-3">
                                    <label for="profile_image" class="form-label">Profile Image</label>
                                    <input class="form-control" type="file" id="profile_image" name="profile_image">
                                    @if($user->profile_image)
                                        <div class="mt-2">
                                            <p class="form-text">Current image:</p>
                                            <img src="{{ asset($user->profile_image) }}" alt="Current Profile"
                                                class="rounded-circle"
                                                style="width: 100px; height: 100px; object-fit: cover;">
                                        </div>
                                    @else
                                        <div class="form-text">No profile image uploaded</div>
                                    @endif
                                </div>



                                <hr class="my-4">
                                <h5>Change Password</h5>

                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Current Password</label>
                                    <input type="password" class="form-control" id="current_password"
                                        name="current_password" placeholder="Enter current password">
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Enter new password">
                                </div>

                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" placeholder="Confirm new password">
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-green">Save Changes</button>
                                    <button type="button" class="btn btn-outline-secondary ms-2">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footer')


    <div id="image-preview" class="mt-2"></div>

    <script>
        document.getElementById('profile_image').onchange = function (event) {
            var reader = new FileReader();
            reader.onload = function () {
                var output = document.createElement('img');
                output.src = reader.result;
                output.classList.add('rounded-circle', 'mt-2');
                output.style.width = '100px';
                output.style.height = '100px';
                output.style.objectFit = 'cover';

                var previewContainer = document.getElementById('image-preview');
                previewContainer.innerHTML = '<p class="form-text">New image preview:</p>';
                previewContainer.appendChild(output);
            };
            reader.readAsDataURL(event.target.files[0]);
        };
    </script>

<script>
    // Auto-dismiss alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            let alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                // Check if Bootstrap is loaded
                if (typeof bootstrap !== 'undefined') {
                    let bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                } else {
                    // Fallback if Bootstrap JS is not loaded
                    alert.style.opacity = '0';
                    alert.style.transition = 'opacity 0.5s';
                    setTimeout(function() {
                        alert.style.display = 'none';
                    }, 500);
                }
            });
        }, 5000);
    });
</script>
</body>

</html>