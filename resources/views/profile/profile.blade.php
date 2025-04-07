<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile | Charity Volunteering Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2EBF91;
            --secondary-color: #1a8e6b;
            --light-color: #e6f7f1;
            --dark-color: #0a3d2e;
            --white-color: #ffffff;
        }
        
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }
        
        .charity-navbar {
            background-color: var(--primary-color);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .charity-navbar .navbar-brand {
            color: white;
            font-weight: bold;
            font-size: 1.5rem;
        }
        
        .charity-navbar .nav-link {
            color: white;
            margin: 0 10px;
            position: relative;
        }
        
        .charity-navbar .nav-link:hover {
            color: var(--light-color);
        }
        
        .charity-navbar .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: white;
            border-radius: 3px;
        }
        
        .profile-header {
            background-color: var(--primary-color);
            color: white;
            padding: 3rem 0;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }
        
        .profile-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(26, 142, 107, 0.8) 0%, rgba(46, 191, 145, 0.4) 100%);
        }
        
        .profile-header .container {
            position: relative;
            z-index: 2;
        }
        
        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid var(--white-color);
            object-fit: cover;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .profile-card {
            background-color: var(--white-color);
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 2rem;
            margin-bottom: 2rem;
            transition: transform 0.3s ease;
        }
        
        .profile-card:hover {
            transform: translateY(-5px);
        }
        
        .card-header-custom {
            background-color: var(--light-color);
            border-bottom: 3px solid var(--primary-color);
            color: var(--dark-color);
            font-weight: bold;
            border-radius: 10px 10px 0 0;
            padding: 1rem;
        }
        
        .btn-custom {
            background-color: var(--primary-color);
            color: var(--white-color);
            border: none;
            border-radius: 5px;
            padding: 0.5rem 1.5rem;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .btn-custom:hover {
            background-color: var(--secondary-color);
            color: var(--white-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46, 191, 145, 0.3);
        }
        
        .btn-outline-custom {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            background-color: transparent;
            border-radius: 5px;
            padding: 0.5rem 1.5rem;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .btn-outline-custom:hover {
            background-color: var(--primary-color);
            color: var(--white-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46, 191, 145, 0.3);
        }
        
        footer {
            background-color: var(--dark-color);
            color: var(--white-color);
            padding: 2rem 0;
        }
        
        .social-icons a {
            color: var(--white-color);
            margin-right: 1rem;
            font-size: 1.5rem;
            transition: all 0.3s ease;
        }
        
        .social-icons a:hover {
            color: var(--primary-color);
            transform: translateY(-3px);
        }

        .badge-custom {
            background-color: var(--primary-color);
            color: var(--white-color);
            border-radius: 20px;
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
            display: inline-block;
        }
    </style>
</head>
<body>

    <!-- Profile Header -->
    <header class="profile-header">
        <div class="container text-center">

            <p class="lead">{{ $user->bio ?? 'Active volunteer serving the community' }}</p>
            <div class="d-flex justify-content-center gap-2 mt-3">
                <a href="{{ route('profile.edit') }}" class="btn btn-light px-4"><i class="fas fa-edit me-2"></i> Edit Profile</a>
                <button class="btn btn-outline-light px-4"><i class="fas fa-share-alt me-2"></i> Share</button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-4 mb-4">
                <!-- About Me -->
                <div class="profile-card">
                    <h5 class="card-header-custom mb-3"><i class="fas fa-user me-2"></i> About Me</h5>
                    <p>{{ $user->about ?? 'A passionate volunteer dedicated to serving the community and contributing to building a better future. I believe in the importance of volunteer work and always strive to participate in initiatives that make a positive impact on the lives of others.' }}</p>
                    
                    <div class="mt-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                            <div>
                                <small class="text-muted">City</small>
                                <p class="mb-0">{{ $user->city ?? 'New York' }}</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-phone text-primary me-2"></i>
                            <div>
                                <small class="text-muted">Phone</small>
                                <p class="mb-0">{{ $user->phone ?? '+1 (555) 123-4567' }}</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-envelope text-primary me-2"></i>
                            <div>
                                <small class="text-muted">Email</small>
                                <p class="mb-0">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-calendar-alt text-primary me-2"></i>
                            <div>
                                <small class="text-muted">Joined Date</small>
                                <p class="mb-0">{{ $user->created_at ? $user->created_at->format('Y/m/d') : '2023/01/15' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Skills and Interests -->
                <div class="profile-card">
                    <h5 class="card-header-custom mb-3"><i class="fas fa-lightbulb me-2"></i> Skills & Interests</h5>
                    
                    <div>
                        @if(isset($user->skills) && is_array($user->skills))
                            @foreach($user->skills as $skill)
                                <span class="badge-custom">{{ $skill }}</span>
                            @endforeach
                        @else
                            <span class="badge-custom">Project Management</span>
                            <span class="badge-custom">Organization</span>
                            <span class="badge-custom">Social Communication</span>
                            <span class="badge-custom">Fundraising</span>
                            <span class="badge-custom">Community Service</span>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Right Column -->
            <div class="col-lg-8 mb-4">
                <!-- Personal Information -->
                <div class="profile-card">
                    <h5 class="card-header-custom mb-3"><i class="fas fa-info-circle me-2"></i> Personal Information</h5>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Full Name</h6>
                            <p>{{ $user->name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Email</h6>
                            <p>{{ $user->email }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Phone</h6>
                            <p>{{ $user->phone ?? 'Not provided' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Date of Birth</h6>
                            <p>{{ $user->date_of_birth ?? 'Not provided' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Gender</h6>
                            <p>{{ $user->gender ?? 'Not provided' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Address</h6>
                            <p>{{ $user->address ?? 'Not provided' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">City</h6>
                            <p>{{ $user->city ?? 'Not provided' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Country</h6>
                            <p>{{ $user->country ?? 'Not provided' }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Additional Information -->
                <div class="profile-card">
                    <h5 class="card-header-custom mb-3"><i class="fas fa-plus-circle me-2"></i> Additional Information</h5>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Occupation</h6>
                            <p>{{ $user->occupation ?? 'Not provided' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Organization</h6>
                            <p>{{ $user->organization ?? 'Not provided' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Education</h6>
                            <p>{{ $user->education ?? 'Not provided' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Languages</h6>
                            <p>{{ $user->languages ?? 'Not provided' }}</p>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <h6 class="text-muted">Why I Volunteer</h6>
                        <p>{{ $user->volunteer_reason ?? 'I believe in giving back to the community and making a positive impact on society. Through volunteering, I aim to contribute my skills and time to meaningful causes that help those in need.' }}</p>
                    </div>
                </div>
                
                <!-- Emergency Contact -->
                <div class="profile-card">
                    <h5 class="card-header-custom mb-3"><i class="fas fa-ambulance me-2"></i> Emergency Contact</h5>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Contact Name</h6>
                            <p>{{ $user->emergency_contact_name ?? 'Not provided' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Relationship</h6>
                            <p>{{ $user->emergency_contact_relationship ?? 'Not provided' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Phone</h6>
                            <p>{{ $user->emergency_contact_phone ?? 'Not provided' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <h6 class="text-muted">Email</h6>
                            <p>{{ $user->emergency_contact_email ?? 'Not provided' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row gy-4">
                <div class="col-md-4">
                    <h5 class="mb-3">Charity Volunteering Project</h5>
                    <p>A platform that brings together volunteers and charitable organizations to make a positive impact in the community through organized volunteer work.</p>
                    <div class="social-icons mt-3">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
                <div class="col-md-4">
                    <h5 class="mb-3">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">About the Platform</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Volunteer Opportunities</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Partner Organizations</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Blog</a></li>
                        <li class="mb-2"><a href="#" class="text-white text-decoration-none">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 class="mb-3">Subscribe to Newsletter</h5>
                    <p>Subscribe to get the latest news and volunteer opportunities</p>
                    <form class="mt-3">
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Email Address" required>
                            <button class="btn btn-custom" type="submit">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>
            <hr class="mt-4 mb-3" style="border-color: rgba(255,255,255,0.2);">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">&copy; {{ date('Y') }} Charity Volunteering Project. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="text-white text-decoration-none mx-2">Privacy Policy</a>
                    <a href="#" class="text-white text-decoration-none mx-2">Terms & Conditions</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>