<!DOCTYPE html>
<html lang="en"">
<head>
    <meta charset="UTF-8">
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
    @foreach($categories as $category)
    <a href="{{ route('activities.index', ['categoryId' => $category->id]) }}" class="category-button {{ request('categoryId') == $category->id ? 'active' : '' }}">
    <i class="fas fa-tag"></i> {{ $category->name }}
                </a>
            @endforeach
        </div>

    <div class="container">
        @if(isset($activitiesByCategory) && count($activitiesByCategory) > 0)
        @foreach($activitiesByCategory as $catId => $categoryData)
        <div class="section" id="category-{{ $catId }}">
        <h2 class="section-title">{{ $categoryData['name'] }}</h2>
        
        <div class="cards-container">
                        @forelse($categoryData['activities'] as $activity)
                            <div class="card">
                                <!-- الصورة والمحتوى قابلة للنقر لفتح المودال -->
                                <div class="card-clickable" style="cursor: pointer;" onclick="openActivityModal({{ $activity->id }})">
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
                                        @if(Auth::check() && $activity->participants->contains(Auth::user()->id))
                                            <form action="{{ route('leave.activity', ['activityId' => $activity->id]) }}" method="POST" class="leave-form w-100" id="leave-form-{{ $activity->id }}">
                                                @csrf
                                                <button type="button" class="btn-action btn-leave w-100" onclick="confirmLeave({{ $activity->id }}, '{{ $activity->title }}');">
                                                    <i class="fas fa-sign-out-alt"></i>Unsubscribe
                                                </button>
                                            </form>
                                        @else
                                        <form action="{{ route('join.activity', ['activityId' => $activity->id]) }}" method="POST" class="join-form" id="join-form-{{ $activity->id }}">
                                            @csrf
                                            <button type="submit" class="btn-action btn-join">
                                            <i class="fas fa-user-plus"></i>Join
                                            </button>
                                            </form>
                                            <button type="button" class="btn-action btn-donate" data-bs-toggle="modal" data-bs-target="#donationModal-{{ $activity->id }}">
                                            <i class="fas fa-hand-holding-heart"></i>Donate
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- مودال التفاصيل لكل نشاط -->
                            <div class="modal fade" id="activityModal-{{ $activity->id }}" tabindex="-1" aria-labelledby="activityModalLabel-{{ $activity->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="activityModalLabel-{{ $activity->id }}">{{ $activity->title }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <img src="{{ asset('img/' . $activity->image) }}" alt="{{ $activity->title }}" class="img-fluid">
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
                            <div class="modal fade" id="donationModal-{{ $activity->id }}" tabindex="-1" aria-labelledby="donationModalLabel-{{ $activity->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="donationModalLabel-{{ $activity->id }}">
                                                <i class="fas fa-heart"></i> Donate to the activity:{{ $activity->name }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="text-muted mb-4">Contribute to support this activity and be part of the positive change.</p>
                                            <form action="{{ route('donate') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="activity_id" value="{{ $activity->id }}">

                                                <div class="mb-4">
                                                    <label for="amount" class="form-label">amount</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-coins"></i></span>
                                                        <input type="number" name="amount" class="form-control" placeholder="Enter the amount" required min="1">
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
                                <p>There are currently no activities available in this category.</p>                            </div>
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

    @if(session('success'))
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

    @if(session('success'))
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
</html>