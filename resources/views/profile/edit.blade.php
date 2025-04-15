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
                        @if($user->profile_image)
                            <form action="{{ route('profile.remove-photo') }}" method="POST" class="mb-3">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="fas fa-trash-alt me-1"></i> Remove Photo
                                </button>
                            </form>
                        @endif
                        <h4 class="mb-1">{{ $user->first_name }} {{ $user->last_name }}</h4>
                        <p class="text-muted">
                            <i class="bi bi-geo-alt-fill"></i> {{ $user->bio ?? 'No Bio Added' }}
                        </p>
                        <span class="badge bg-secondary">{{ $user->role }}</span>
                    </div>
                </div>

                <!-- User Stats -->
                <div class="profile-card">
                    <h5 class="mb-3 text-center">Activity Summary</h5>
                    <div class="row row-cols-2 row-cols-md-4 g-3">
                        <div class="col-md-6 text-center profile-stat">
                            <h3 class="text-success">{{ $activityCount ?? 1 }}</h3>
                            <p>Activities</p>
                        </div>
                        <div class="col-md-6 text-center profile-stat">
                            <h3 class="text-success">{{ $postCount ?? 1}}</h3>
                            <p>Posts</p>
                        </div>
                    </div>
                </div>  

                <!-- Contact Info -->
                <div class="profile-card">
                    <h5 class="mb-3">Contact Information</h5>
                    <div class="mb-2">
                        <i class="fas fa-envelope me-2 text-muted"></i>{{ $user->email }}
                        <a href="#" class="ps-5" data-bs-toggle="modal" data-bs-target="#emailChangeModal">Change
                            Email</a>
                    </div>
                    <div class="mb-2">
                        <i class="fas fa-phone me-2 text-muted"></i>
                        <span>{{ $user->phone ?? '+962 7x xxx xxxx' }}</span>
                    </div>
                </div>
            </div>

            <!-- Email Change Modal using Bootstrap 5 -->
            <div class="modal fade" id="emailChangeModal" tabindex="-1" aria-labelledby="emailChangeModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="emailChangeModalLabel">Change Email Address</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('profile.update-email') }}" method="POST" id="emailChangeForm">
                            @csrf
                            <div class="modal-body">
                                <p>Current Email: <span class="fw-bold">{{ $user->email }}</span></p>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Enter Password to Confirm</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>

                                <div class="mb-3">
                                    <label for="new_email" class="form-label">New Email Address</label>
                                    <input type="email" class="form-control" id="new_email" name="new_email" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success" id="updateEmailBtn">Update Email</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script>
                // Wait for the document to be fully loaded
                document.addEventListener('DOMContentLoaded', function () {
                    // Log for debugging
                    console.log('DOM fully loaded');

                    // Function to auto-dismiss alerts after 5 seconds
                    function setupAutoDismissAlerts() {
                        const alerts = document.querySelectorAll('.alert');
                        alerts.forEach(alert => {
                            setTimeout(() => {
                                // Create a bootstrap alert instance and hide it
                                const bsAlert = new bootstrap.Alert(alert);
                                bsAlert.close();
                            }, 5000); // 5000 milliseconds = 5 seconds
                        });
                    }

                    // Call the function for any alerts that exist when page loads
                    setupAutoDismissAlerts();

                    // Get the email change form
                    const emailChangeForm = document.getElementById('emailChangeForm');

                    if (emailChangeForm) {
                        console.log('Email change form found');

                        // Add submit event listener to the form
                        emailChangeForm.addEventListener('submit', function (e) {
                            // Prevent the default form submission
                            e.preventDefault();
                            console.log('Form submission intercepted');

                            // Create formData object
                            const formData = new FormData(this);

                            // Create an AJAX request
                            fetch(this.action, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                credentials: 'same-origin'
                            })
                                .then(response => {
                                    console.log('Response received');
                                    return response.json();
                                })
                                .then(data => {
                                    console.log('Data processed:', data);

                                    // Close the modal
                                    const modalElement = document.getElementById('emailChangeModal');
                                    const modal = bootstrap.Modal.getInstance(modalElement);
                                    modal.hide();

                                    // Create flash message
                                    let alertHtml = '';

                                    if (data.success) {
                                        alertHtml = `
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            ${data.success}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `;

                                        // Update the displayed email
                                        const emailDisplay = document.querySelector('.fas.fa-envelope.me-2.text-muted').nextSibling;
                                        if (emailDisplay) {
                                            emailDisplay.textContent = data.email;
                                        }
                                    } else if (data.error) {
                                        alertHtml = `
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            ${data.error}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `;
                                    }

                                    // Find the flash message container and insert the message
                                    const flashContainer = document.querySelector('.row:first-child .col-12');
                                    if (flashContainer) {
                                        flashContainer.innerHTML = alertHtml;
                                        // Scroll to top to show the message
                                        window.scrollTo(0, 0);

                                        // Setup auto-dismiss for the newly added alert
                                        setupAutoDismissAlerts();
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    // Handle error
                                    const modalElement = document.getElementById('emailChangeModal');
                                    const modal = bootstrap.Modal.getInstance(modalElement);
                                    modal.hide();

                                    // Create error flash message
                                    const alertHtml = `
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        An error occurred while processing your request. Please try again.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;

                                    const flashContainer = document.querySelector('.row:first-child .col-12');
                                    if (flashContainer) {
                                        flashContainer.innerHTML = alertHtml;
                                        window.scrollTo(0, 0);

                                        // Setup auto-dismiss for the newly added alert
                                        setupAutoDismissAlerts();
                                    }
                                });
                        });
                    } else {
                        console.error('Email change form not found');
                    }
                });
            </script>


            <!-- Right Column - Tabs and Content -->
            <div class="col-lg-8">
                <div class="profile-card p-0 overflow-hidden">
                    <!-- Tabs -->
                    <ul class="nav nav-tabs profile-tabs" id="profileTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings"
                                type="button" role="tab">Account Settings</button>
                        </li>
                    </ul>

                    <!-- Tab Contents -->
                    <div class="tab-content p-4" id="profileTabsContent">

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
                                    <label for="bio" class="form-label">Bio</label>
                                    <textarea class="form-control" id="bio" name="bio" rows="3"
                                        placeholder="Tell us about yourself">{{ $user->bio }}</textarea>
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
        document.addEventListener('DOMContentLoaded', function() {
            // Find the account settings tab and activate it
            var settingsTab = document.getElementById('settings-tab');
            if (settingsTab) {
                var tab = new bootstrap.Tab(settingsTab);
                tab.show();
            }
        });
    </script>
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
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function () {
                let alerts = document.querySelectorAll('.alert');
                alerts.forEach(function (alert) {
                    // Check if Bootstrap is loaded
                    if (typeof bootstrap !== 'undefined') {
                        let bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    } else {
                        // Fallback if Bootstrap JS is not loaded
                        alert.style.opacity = '0';
                        alert.style.transition = 'opacity 0.5s';
                        setTimeout(function () {
                            alert.style.display = 'none';
                        }, 500);
                    }
                });
            }, 5000);
        });
    </script>

</body>

</html>