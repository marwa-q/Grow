<!DOCTYPE html>
<html lang="en"">

<head>
    <meta charset=" UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>الأنشطة</title>

<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Bootstrap CSS RTL -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
<!-- Bootstrap JS + Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/activity.css') }}">
<link rel="stylesheet" href="{{ asset('css/fotter.css') }}">


<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
<style>
    .activity-info {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;
        /* محاذاة لليسار */
        padding-left: 80px;/ top: 50%;
    }

    .activity-info p {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
    }

    .activity-info i {
        width: 20px;
        margin-right: 10px;
        text-align: center;
    }

    .activity-info span {
        flex: 1;
    }


    .category-button {
        text-decoration: none;
    }

    .activity-info p {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
        /* consistent spacing between lines */
    }

    .activity-info i {
        width: 20px;
        /* fixed width for all icons */
        margin-right: 10px;
        /* consistent spacing after icons */
        text-align: center;
        /* center the icon in its fixed width */
    }

    .activity-info span {
        flex: 1;
        /* allows text to use remaining space */
    }
</style>
</head>

<body>
    @include('layouts.navigation')
    <div class="page-header">
        <h1 class="page-title">Explore our activities</h1>
        <p>Join a variety of activities and help make a positive difference</p>
    </div>

    <div class="categories">
        <a href="{{ route('activities.index') }}" class="category-button {{ !request('categoryId') ? 'active' : '' }}">
            <i class="fas fa-th-large"></i> All activities
        </a>
        @foreach ($categories as $category)
            <a href="{{ route('activities.index', ['categoryId' => $category->id]) }}"
                class="category-button {{ request('categoryId') == $category->id ? 'active' : '' }}">
                <i class="fas fa-tag"></i> {{ $category->name }}
            </a>
        @endforeach
    </div>

    <div class="container">
        @if (isset($activitiesByCategory) && count($activitiesByCategory) > 0)
            @foreach ($activitiesByCategory as $catId => $categoryData)
                <div class="section" id="category-{{ $catId }}">
                    <h2 class="section-title">{{ $categoryData['name'] }}</h2>

                    <div class="cards-container">
                        @forelse($categoryData['activities'] as $activity)
                            <div class="card">
                                <!-- الصورة والمحتوى قابلة للنقر لفتح المودال -->
                                <div class="card-clickable" style="cursor: pointer;"
                                    onclick="openActivityModal({{ $activity->id }})">
                                    <div style="position: relative; overflow: hidden;">
                                        <img src="{{ asset('img/' . $activity->image) }}" alt="{{ $activity->title }}">

                                        <div class="card-badge">{{ $categoryData['name'] }}</div>
                                    </div>
                                    <div class="card-content">
                                        <h2 class="title">{{ $activity->title }}</h2>
                                        <div class="activity-info">
                                            <p><i class="fas fa-tag"></i> <span>{{ $activity->title }}</span></p>
                                            <p><i class="fas fa-map-marker-alt"></i> <span>{{ $activity->location }}</span></p>
                                            <p><i class="fas fa-users"></i> <span>Participants:
                                                    {{ $activity->max_participants }}</span></p>
                                        </div>
                                    </div>
                                </div>
                                <!-- الأزرار منفصلة عن المنطقة القابلة للنقر للمودال -->
                                <div class="card-content">
                                    <div class="buttons-container">
                                        @if (Auth::check() && $activity->participants->contains(Auth::user()->id))
                                            <form action="{{ route('leave.activity', ['activityId' => $activity->id]) }}" method="POST"
                                                class="leave-form w-100" id="leave-form-{{ $activity->id }}">
                                                @csrf
                                                <button type="button" class="btn-action btn-leave w-100"
                                                    onclick="confirmLeave({{ $activity->id }}, '{{ $activity->title }}');">
                                                    <i class="fas fa-sign-out-alt"></i>Unsubscribe
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('join.activity', ['activityId' => $activity->id]) }}" method="POST"
                                                class="join-form" id="join-form-{{ $activity->id }}">
                                                @csrf
                                                <button type="submit" class="btn-action btn-join">
                                                    <i class="fas fa-user-plus"></i>Join
                                                </button>
                                            </form>
                                            <button type="button" class="btn-action btn-donate" data-bs-toggle="modal"
                                                data-bs-target="#donationModal-{{ $activity->id }}">
                                                <i class="fas fa-hand-holding-heart"></i>Donate
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- مودال التفاصيل لكل نشاط -->
                            <div class="modal fade" id="activityModal-{{ $activity->id }}" tabindex="-1"
                                aria-labelledby="activityModalLabel-{{ $activity->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content"
                                        style="border-radius: 15px; overflow: hidden; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
                                        <!-- Modal Header with Gradient Background -->
                                        <div class="modal-header"
                                            style="background: linear-gradient(135deg, #2e7d32, #4caf50); border: none; padding: 20px;">
                                            <h5 class="modal-title" id="activityModalLabel-{{ $activity->id }}"
                                                style="color: white; font-weight: 700; font-size: 1.5rem;">
                                                <i class="fas fa-calendar-check me-2"></i>{{ $activity->title }}
                                            </h5>
                                        </div>

                                        <div class="modal-body" style="padding: 25px;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <!-- Image with rounded corners and shadow -->
                                                    <div
                                                        style="border-radius: 12px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                                                        <img src="{{ asset('img/' . $activity->image) }}"
                                                            alt="{{ $activity->title }}" class="img-fluid">
                                                    </div>

                                                    <!-- Add a calendar widget with the date -->
                                                    <div class="mt-3 d-flex align-items-center p-3"
                                                        style="background-color: #f8f9fa; border-radius: 10px;">
                                                        <div
                                                            style="width: 60px; height: 60px; background-color: #e8f5e9; border-radius: 10px; display: flex; flex-direction: column; justify-content: center; align-items: center; margin-right: 15px;">
                                                            <i class="fas fa-calendar-day"
                                                                style="color: #2e7d32; font-size: 24px;"></i>
                                                        </div>
                                                        <div>
                                                            <h6 style="margin-bottom: 2px; color: #333;">Activity Date
                                                            </h6>
                                                            <p style="margin-bottom: 0; font-weight: bold; color: #2e7d32;">
                                                                {{ $activity->date }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <h4
                                                        style="color: #2e7d32; font-weight: 700; margin-bottom: 20px; border-bottom: 2px solid #e8f5e9; padding-bottom: 10px;">
                                                        <i class="fas fa-info-circle me-2"></i>Activity Details
                                                    </h4>

                                                    <!-- Location with icon -->
                                                    <div class="mb-3 d-flex align-items-center">
                                                        <div
                                                            style="width: 40px; height: 40px; background-color: #e8f5e9; border-radius: 50%; display: flex; justify-content: center; align-items: center; margin-right: 15px;">
                                                            <i class="fas fa-map-marker-alt" style="color: #2e7d32;"></i>
                                                        </div>
                                                        <div>
                                                            <p style="font-size: 16px; font-weight: bold; margin-bottom: 0;">
                                                                <span style="color: #2e7d32;">Location:</span>
                                                                {{ $activity->location }}
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <!-- Participants with icon -->
                                                    <div class="mb-3 d-flex align-items-center">
                                                        <div
                                                            style="width: 40px; height: 40px; background-color: #e8f5e9; border-radius: 50%; display: flex; justify-content: center; align-items: center; margin-right: 15px;">
                                                            <i class="fas fa-users" style="color: #2e7d32;"></i>
                                                        </div>
                                                        <div>
                                                            <p style="font-size: 16px; font-weight: bold; margin-bottom: 0;">
                                                                <span style="color: #2e7d32;"> Max Participants:</span>
                                                                {{ $activity->max_participants }}
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <!-- Description with icon and scrollable area with custom green scrollbar -->
                                                    <div class="mt-4">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <div
                                                                style="width: 40px; height: 40px; background-color: #e8f5e9; border-radius: 50%; display: flex; justify-content: center; align-items: center; margin-right: 15px;">
                                                                <i class="fas fa-align-left" style="color: #2e7d32;"></i>
                                                            </div>
                                                            <h5 style="color: #2e7d32; margin-bottom: 0;"> Description
                                                                :</h5>
                                                        </div>
                                                        <!-- Custom scrollbar styling -->
                                                        <style>
                                                            .custom-scrollbar::-webkit-scrollbar {
                                                                width: 8px;
                                                            }

                                                            .custom-scrollbar::-webkit-scrollbar-track {
                                                                background: #e8f5e9;
                                                                border-radius: 10px;
                                                            }

                                                            .custom-scrollbar::-webkit-scrollbar-thumb {
                                                                background: linear-gradient(to bottom, #4caf50, #2e7d32);
                                                                border-radius: 10px;
                                                                border: 2px solid #e8f5e9;
                                                            }

                                                            .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                                                                background: #2e7d32;
                                                            }

                                                            /* For Firefox */
                                                            .custom-scrollbar {
                                                                scrollbar-width: thin;
                                                                scrollbar-color: #4caf50 #e8f5e9;
                                                            }
                                                        </style>

                                                        <!-- Added fixed height and custom scrollbar class -->
                                                        <div class="custom-scrollbar"
                                                            style="background-color: #f8f9fa; border-radius: 10px; padding: 15px; margin-top: 10px; height: 150px; overflow-y: auto; border: 1px solid #e0e0e0; box-shadow: inset 0 0 5px rgba(0,0,0,0.05);">
                                                            <p style="margin-bottom: 0;">{{ $activity->description }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer"
                                            style="background-color: #f8f9fa; border: none; border-radius: 0 0 15px 15px; padding: 20px;">
                                            <!-- Button positioned at the right side -->
                                            <div style="width: 100%; display: flex; justify-content: flex-end;">
                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                                    style="border-radius: 50px; padding: 10px 25px;">
                                                    <i class="fas fa-times me-2"></i>Close
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- مودال التبرع لكل نشاط -->
                            <div class="modal fade" id="donationModal-{{ $activity->id }}" tabindex="-1"
                                aria-labelledby="donationModalLabel-{{ $activity->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="donationModalLabel-{{ $activity->id }}">
                                                <i class="fas fa-heart"></i> Donate to the
                                                activity:{{ $activity->name }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="إغلاق"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="text-muted mb-4">Contribute to support this activity and be part
                                                of the positive change.</p>
                                            <form action="{{ route('donate') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="activity_id" value="{{ $activity->id }}">

                                                <div class="mb-4">
                                                    <label for="amount" class="form-label">amount</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-coins"></i></span>
                                                        <input type="number" name="amount" class="form-control"
                                                            placeholder="Enter the amount" required min="1">
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        <i class="fas fa-times"></i> closing
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fas fa-heart"></i> Donate now
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="no-activities">
                                <i class="fas fa-info-circle fa-2x mb-3"></i>
                                <p>There are currently no activities available in this category.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endforeach
        @else
            <div class="no-activities">
                <i class="fas fa-info-circle fa-2x mb-3"></i>
                <p>There are no activities currently available.</p>
            </div>
        @endif
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </div>
    <footer class="footer">
        <div class="container">
            <div class="row">
                <!-- معلومات المؤسسة -->
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <div class="footer-logo mb-4">
                        <h3 class="text-white fw-bold mb-3">Charity Site</h3>
                        <div class="accent-line"></div>
                    </div>
                    <p class="text-light mb-4">We seek to help those in need and bring about positive change in the
                        lives of individuals and communities through sustainable charitable programs that promote social
                        solidarity.</p>
                    <div class="footer-social mb-4">
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>

                <!-- روابط سريعة -->
                <div class="col-lg-2 col-md-4 mb-5 mb-md-0">
                    <h5>Quick Links</h5>
                    <ul class="footer-links list-unstyled">
                        <li><a href="#"><i class="fas fa-angle-left ms-2"></i>Home</a></li>
                        <li><a href="#"><i class="fas fa-angle-left ms-2"></i>About Us</a></li>
                        <li><a href="#"><i class="fas fa-angle-left ms-2"></i>Our Programs</a></li>
                        <li><a href="#"><i class="fas fa-angle-left ms-2"></i>Projects</a></li>
                        <li><a href="#"><i class="fas fa-angle-left ms-2"></i>Volunteers</a></li>
                        <li><a href="#"><i class="fas fa-angle-left ms-2"></i>Contact Us</a></li>
                    </ul>
                </div>

                <!-- المساعدة والدعم -->
                <div class="col-lg-2 col-md-4 mb-5 mb-md-0">
                    Help and Support <ul class="footer-links list-unstyled">
                        <li><a href="#"><i class="fas fa-angle-left ms-2"></i>How to Donate</a></li>
                        <li><a href="#"><i class="fas fa-angle-left ms-2"></i>Frequently Asked Questions</a>
                        </li>
                        <li><a href="#"><i class="fas fa-angle-left ms-2"></i>Financial Reports</a></li>
                        <li><a href="#"><i class="fas fa-angle-left ms-2"></i>Privacy Policy</a></li>
                        <li><a href="#"><i class="fas fa-angle-left ms-2"></i>Terms and Conditions</a></li>
                    </ul>
                </div>

                <!-- الاتصال والنشرة البريدية -->
                <div class="col-lg-4 col-md-4">
                    <h5>Contact us</h5>
                    <ul class="list-unstyled contact-info mb-4">
                        <li class="mb-3">
                            <div class="d-flex align-items-center">
                                <div class="contact-icon-small ms-3">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>Al Amal Street, Al Noor District, Medina</div>
                            </div>
                        </li>
                        <li class="mb-3">
                            <div class="d-flex align-items-center">
                                <div class="contact-icon-small ms-3">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <div dir="ltr">+966 55 555 5555</div>
                            </div>
                        </li>
                        <li class="mb-3">
                            <div class="d-flex align-items-center">
                                <div class="contact-icon-small ms-3">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>info@charity-website.org</div>
                            </div>
                        </li>
                    </ul>

                    <h5>Newsletter</h5>
                    <p class="text-light mb-3">Subscribe to our newsletter to receive the latest news and events</p>
                    <form class="newsletter-form">
                        <input type="email" class="newsletter-input" placeholder="Your email" required>
                        <button type="submit" class="newsletter-btn">Subscribe</button>
                    </form>
                </div>
            </div>

            @include('layouts.footer')
        </div>
    </footer>

    <script>
        // دالة لفتح مودال النشاط
        function openActivityModal(activityId) {
            var activityModal = new bootstrap.Modal(document.getElementById('activityModal-' + activityId));
            activityModal.show();
        }

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Done successfully.',
                text: '{{ session('success') }}',
                timer: 1500,
                confirmButtonText: 'accepts',
                customClass: {
                    popup: 'animated fadeInDown faster',
                    confirmButton: 'btn btn-primary'
                }
            }).then(() => {
                // إعادة فتح المودال للتبرع مرة أخرى بعد النجاح
                var modal = bootstrap.Modal.getInstance(document.getElementById(
                    'donationModal-{{ old('activity_id') }}'));
                if (modal) modal.show();
            });
        @endif

            function confirmLeave(activityId, activityTitle) {
                Swal.fire({
                    title: '<i class="fas fa-exclamation-triangle text-warning"></i> Confirm Unsubscribe',
                    html: 'Are you sure you want to unsubscribe from the activity <strong>' + activityTitle +
                        '</strong>?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '<i class="fas fa-check"></i> Yes, Unsubscribe',
                    cancelButtonText: '<i class="fas fa-times"></i> Cancel',
                    confirmButtonColor: '#e74c3c',
                    cancelButtonColor: '#7f8c8d',
                    customClass: {
                        popup: 'animated fadeInDown faster'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('leave-form-' + activityId).submit();
                    }
                });
            }
    </script>
    <script>
        // دالة لفتح مودال النشاط
        function openActivityModal(activityId) {
            var activityModal = new bootstrap.Modal(document.getElementById('activityModal-' + activityId));
            activityModal.show();
        }

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Successful',
                text: '{{ session('success') }}',
                timer: 1500,
                confirmButtonText: 'Acept',
                customClass: {
                    popup: 'animated fadeInDown faster',
                    confirmButton: 'btn btn-primary'
                }
            }).then(() => {
                // إعادة فتح المودال للتبرع مرة أخرى بعد النجاح
                var modal = bootstrap.Modal.getInstance(document.getElementById(
                    'donationModal-{{ old('activity_id') }}'));
                if (modal) modal.show();
            });
        @endif

            function confirmLeave(activityId, activityTitle) {
                Swal.fire({
                    title: '<i class="fas fa-exclamation-triangle text-warning"></i> Confirm Unsubscribe',
                    html: 'Are you sure you want to unsubscribe from the activity <strong>' + activityTitle +
                        '</strong>?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '<i class="fas fa-check"></i> Yes, Unsubscribe',
                    cancelButtonText: '<i class="fas fa-times"></i> Cancel',
                    confirmButtonColor: '#e74c3c',
                    cancelButtonColor: '#7f8c8d',
                    customClass: {
                        popup: 'animated fadeInDown faster'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('leave-form-' + activityId).submit();
                    }
                });
            }
    </script>

</body>

</html>


{{--
<!DOCTYPE html>
<html lang="en"">
<head>
    <meta charset=" UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Activities</title>

<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Bootstrap CSS RTL -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
<!-- Bootstrap JS + Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/activity.css') }}">
<link rel="stylesheet" href="{{ asset('css/fotter.css') }}">


<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">


</head>

<body>
    @include('layouts.navigation')
    <div class="page-header">
        <h1 class="page-title">Explore our activities</h1>
        <p>Join a variety of activities and help make a positive difference</p>
    </div>

    <div class="categories">
        <a href="{{ route('activities.index') }}" class="category-button {{ !request('categoryId') ? 'active' : '' }}">
            <i class="fas fa-th-large"></i> All activities
        </a>
        @foreach ($categories as $category)
        <a href="{{ route('activities.index', ['categoryId' => $category->id]) }}"
            class="category-button {{ request('categoryId') == $category->id ? 'active' : '' }}">
            <i class="fas fa-tag"></i> {{ $category->name }}
        </a>
        @endforeach
    </div>

    <div class="container">
        @if (isset($activitiesByCategory) && count($activitiesByCategory) > 0)
        @foreach ($activitiesByCategory as $catId => $categoryData)
        <div class="section" id="category-{{ $catId }}">
            <h2 class="section-title">{{ $categoryData['name'] }}</h2>

            <div class="cards-container">
                @forelse($categoryData['activities'] as $activity)
                <div class="card">
                    <!-- الصورة والمحتوى قابلة للنقر لفتح المودال -->
                    <div class="card-clickable" style="cursor: pointer;"
                        onclick="openActivityModal({{ $activity->id }})">
                        <div style="position: relative; overflow: hidden;">
                            <img src="{{ asset('img/' . $activity->image) }}" alt="{{ $activity->title }}">
                            <div class="card-badge">{{ $categoryData['name'] }}</div>
                        </div>
                        <div class="card-content">
                            <h2 class="title">{{ $activity->title }}</h2>
                            <div class="activity-info">
                                <p><i class="fas fa-user-friends"></i> {{ $activity->name }}</p>
                                <p><i class="fas fa-map-marker-alt"></i> {{ $activity->location }}</p>
                            </div>
                        </div>
                    </div>
                    <!-- الأزرار منفصلة عن المنطقة القابلة للنقر للمودال -->
                    <div class="card-content">
                        <div class="buttons-container">
                            @if (Auth::check() && $activity->participants->contains(Auth::user()->id))
                            <form action="{{ route('leave.activity', ['activityId' => $activity->id]) }}" method="POST"
                                class="leave-form w-100" id="leave-form-{{ $activity->id }}">
                                @csrf
                                <button type="button" class="btn-action btn-leave w-100"
                                    onclick="confirmLeave({{ $activity->id }}, '{{ $activity->title }}');">
                                    <i class="fas fa-sign-out-alt"></i>Unsubscribe
                                </button>
                            </form>
                            @else
                            <form action="{{ route('join.activity', ['activityId' => $activity->id]) }}" method="POST"
                                class="join-form" id="join-form-{{ $activity->id }}">
                                @csrf
                                <button type="submit" class="btn-action btn-join">
                                    <i class="fas fa-user-plus"></i>Join
                                </button>
                            </form>
                            <button type="button" class="btn-action btn-donate" data-bs-toggle="modal"
                                data-bs-target="#donationModal-{{ $activity->id }}">
                                <i class="fas fa-hand-holding-heart"></i>Donate
                            </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- مودال التفاصيل لكل نشاط -->
                <div class="modal fade" id="activityModal-{{ $activity->id }}" tabindex="-1"
                    aria-labelledby="activityModalLabel-{{ $activity->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="activityModalLabel-{{ $activity->id }}">{{ $activity->title
                                    }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="إغلاق"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <img src="{{ asset('img/' . $activity->image) }}" alt="{{ $activity->title }}"
                                            class="img-fluid">
                                    </div>
                                    <div class="col-md-6">
                                        <h4>Activity Details</h4>
                                        <p><strong>Location:</strong> {{ $activity->location }}</p>
                                        <p><strong>Time:</strong> {{ $activity->time }}</p>
                                        <p><strong>Details:</strong> {{ $activity->description }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- مودال التبرع لكل نشاط -->
                <div class="modal fade" id="donationModal-{{ $activity->id }}" tabindex="-1"
                    aria-labelledby="donationModalLabel-{{ $activity->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="donationModalLabel-{{ $activity->id }}">
                                    <i class="fas fa-heart"></i> Donate to the activity:{{ $activity->name }}
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="إغلاق"></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-muted mb-4">Contribute to support this activity and be part of the
                                    positive change.</p>
                                <form action="{{ route('donate') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="activity_id" value="{{ $activity->id }}">

                                    <div class="mb-4">
                                        <label for="amount" class="form-label">amount</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-coins"></i></span>
                                            <input type="number" name="amount" class="form-control"
                                                placeholder="Enter the amount" required min="1">
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="fas fa-times"></i> closing
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-heart"></i> Donate now
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="no-activities">
                    <i class="fas fa-info-circle fa-2x mb-3"></i>
                    <p>There are currently no activities available in this category.</p>
                </div>
                @endforelse
            </div>
        </div>
        @endforeach
        @else
        <div class="no-activities">
            <i class="fas fa-info-circle fa-2x mb-3"></i>
            <p>There are no activities currently available.</p>
        </div>
        @endif
    </div>

    @include('layouts.footer')


    <script>
        // دالة لفتح مودال النشاط
        function openActivityModal(activityId) {
            var activityModal = new bootstrap.Modal(document.getElementById('activityModal-' + activityId));
            activityModal.show();
        }

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Done successfully.',
                text: '{{ session('success') }}',
                timer: 1500,
                confirmButtonText: 'accepts',
                customClass: {
                    popup: 'animated fadeInDown faster',
                    confirmButton: 'btn btn-primary'
                }
            }).then(() => {
                // إعادة فتح المودال للتبرع مرة أخرى بعد النجاح
                var modal = bootstrap.Modal.getInstance(document.getElementById('donationModal-{{ old('activity_id') }}'));
                if (modal) modal.show();
            });
        @endif

        function confirmLeave(activityId, activityTitle) {
            Swal.fire({
                title: '<i class="fas fa-exclamation-triangle text-warning"></i> Confirm Unsubscribe',
                html: 'Are you sure you want to unsubscribe from the activity <strong>' + activityTitle + '</strong>?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-check"></i> Yes, Unsubscribe',
                cancelButtonText: '<i class="fas fa-times"></i> Cancel',
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#7f8c8d',
                customClass: {
                    popup: 'animated fadeInDown faster'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('leave-form-' + activityId).submit();
                }
            });
        }

    </script>
    <script>
        // دالة لفتح مودال النشاط
        function openActivityModal(activityId) {
            var activityModal = new bootstrap.Modal(document.getElementById('activityModal-' + activityId));
            activityModal.show();
        }

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'تم بنجاح',
                text: '{{ session('success') }}',
                timer: 1500,
                confirmButtonText: 'موافق',
                customClass: {
                    popup: 'animated fadeInDown faster',
                    confirmButton: 'btn btn-primary'
                }
            }).then(() => {
                // إعادة فتح المودال للتبرع مرة أخرى بعد النجاح
                var modal = bootstrap.Modal.getInstance(document.getElementById('donationModal-{{ old('activity_id') }}'));
                if (modal) modal.show();
            });
        @endif

        function confirmLeave(activityId, activityTitle) {
            Swal.fire({
                title: '<i class="fas fa-exclamation-triangle text-warning"></i> Confirm Unsubscribe',
                html: 'Are you sure you want to unsubscribe from the activity <strong>' + activityTitle + '</strong>?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-check"></i> Yes, Unsubscribe',
                cancelButtonText: '<i class="fas fa-times"></i> Cancel',
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#7f8c8d',
                customClass: {
                    popup: 'animated fadeInDown faster'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('leave-form-' + activityId).submit();
                }
            });
        }

    </script>

</body>

</html> --}}