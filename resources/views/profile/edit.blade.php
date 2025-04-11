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

    @include('layouts.navigation');


    <!-- Profile Content -->
    <div class="my-5 container profile-container">
        <div class="row">
            <!-- Left Column - User Info -->
            <div class="col-lg-4">
                <div class="profile-card text-center">
                    <img src="/api/placeholder/150/150" class="profile-picture" alt="Profile Picture">
                    <h3>Ahmed Hassan</h3>
                    <p class="text-muted"><i class="fas fa-map-marker-alt me-1"></i> Amman, Jordan</p>
                    <div class="mt-3">
                        <span class="badge bg-secondary me-1">Volunteer</span>
                        <span class="badge badge-green">Community Leader</span>
                    </div>
                </div>

                <!-- User Stats -->
                <div class="profile-card">
                    <h5 class="mb-3">Activity Summary</h5>
                    <div class="row">
                        <div class="col-4 profile-stat">
                            <h3>24</h3>
                            <p>Activities</p>
                        </div>
                        <div class="col-4 profile-stat">
                            <h3>78</h3>
                            <p>Hours</p>
                        </div>
                        <div class="col-4 profile-stat">
                            <h3>12</h3>
                            <p>Posts</p>
                        </div>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="profile-card">
                    <h5 class="mb-3">Contact Information</h5>
                    <div class="mb-2">
                        <i class="fas fa-envelope me-2 text-muted"></i> ahmed.hassan@example.com
                    </div>
                    <div class="mb-2">
                        <i class="fas fa-phone me-2 text-muted"></i> +962 7x xxx xxxx
                    </div>
                    <div>
                        <i class="fas fa-globe me-2 text-muted"></i> www.example.com
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

                            <div class="activity-item">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge badge-green me-2">Community Support</span>
                                    <span class="activity-date">April 8, 2025</span>
                                </div>
                                <h5>Food Distribution Drive</h5>
                                <p>Participated in distributing food packages to 50 families in downtown Amman.</p>
                                <div>
                                    <i class="fas fa-clock text-muted me-1"></i> 4 hours
                                    <span class="ms-3"><i class="fas fa-map-marker-alt text-muted me-1"></i> Al-Weibdeh,
                                        Amman</span>
                                </div>
                            </div>

                            <div class="activity-item">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge badge-green me-2">Education</span>
                                    <span class="activity-date">April 2, 2025</span>
                                </div>
                                <h5>After-School Tutoring</h5>
                                <p>Provided mathematics and science tutoring for middle school students at the community
                                    center.</p>
                                <div>
                                    <i class="fas fa-clock text-muted me-1"></i> 3 hours
                                    <span class="ms-3"><i class="fas fa-map-marker-alt text-muted me-1"></i> East Amman
                                        Community Center</span>
                                </div>
                            </div>

                            <div class="activity-item">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge badge-green me-2">Environmental Awareness</span>
                                    <span class="activity-date">March 25, 2025</span>
                                </div>
                                <h5>City Park Cleanup</h5>
                                <p>Led a group of 15 volunteers to clean and restore the public park area.</p>
                                <div>
                                    <i class="fas fa-clock text-muted me-1"></i> 5 hours
                                    <span class="ms-3"><i class="fas fa-map-marker-alt text-muted me-1"></i> King
                                        Hussein Park</span>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button class="btn btn-outline-secondary">View All Activities</button>
                            </div>
                        </div>

                        <!-- Posts Tab -->
                        <div class="tab-pane fade" id="posts" role="tabpanel">
                            <h4 class="mb-4">My Posts</h4>

                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Reflections on Community Service</h5>
                                    <p class="card-text text-muted small">Posted on April 5, 2025</p>
                                    <p class="card-text">After spending the last month volunteering with various
                                        initiatives, I've gathered some thoughts on the impact of community service and
                                        how it transforms both the giver and receiver...</p>
                                    <div class="d-flex align-items-center">
                                        <button class="btn btn-sm btn-outline-secondary me-2"><i
                                                class="fas fa-heart me-1"></i> 24 Likes</button>
                                        <button class="btn btn-sm btn-outline-secondary"><i
                                                class="fas fa-comment me-1"></i> 8 Comments</button>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Tips for New Volunteers</h5>
                                    <p class="card-text text-muted small">Posted on March 28, 2025</p>
                                    <p class="card-text">For those just starting their volunteering journey, here are
                                        some practical tips I've learned along the way that can help make your
                                        experience more rewarding and impactful...</p>
                                    <div class="d-flex align-items-center">
                                        <button class="btn btn-sm btn-outline-secondary me-2"><i
                                                class="fas fa-heart me-1"></i> 37 Likes</button>
                                        <button class="btn btn-sm btn-outline-secondary"><i
                                                class="fas fa-comment me-1"></i> 12 Comments</button>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button class="btn btn-outline-secondary">View All Posts</button>
                            </div>
                        </div>

                        <!-- Settings Tab -->
                        <div class="tab-pane fade" id="settings" role="tabpanel">
                            <h4 class="mb-4">Account Settings</h4>

                            <form>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="first_name" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name"
                                            value="Ahmed">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name"
                                            value="Hassan">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="ahmed.hassan@example.com">
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" name="phone"
                                        value="+1 (567) 878-2756" placeholder="NULL">
                                </div>

                                <div class="mb-3">
                                    <label for="role" class="form-label">Role</label>
                                    <select class="form-select" id="role" name="role">
                                        <option value="user" selected>User</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="profile_image" class="form-label">Profile Image</label>
                                    <input class="form-control" type="file" id="profile_image" name="profile_image">
                                    <div class="form-text">Current image: NULL</div>
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

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remember_token"
                                            name="remember_token">
                                        <label class="form-check-label" for="remember_token">
                                            Remember me on this device
                                        </label>
                                    </div>
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

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h4>About Grow</h4>
                    <p>We connect volunteers with meaningful opportunities to make a positive impact in their
                        communities.</p>
                </div>
                <div class="col-md-4">
                    <h4>Quick Links</h4>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">Activities</a></li>
                        <li><a href="#" class="text-white">Posts</a></li>
                        <li><a href="#" class="text-white">About Us</a></li>
                        <li><a href="#" class="text-white">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h4>Connect With Us</h4>
                    <div class="social-icons">
                        <a href="#" class="text-white me-2"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-2"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white me-2"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white me-2"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12 text-center">
                    <p class="mb-0">© 2025 Grow Community. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>