@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/landing.css')}}">
<!-- Hero Section -->
<section class="hero-section bg-light text-center p-5">
    <div class="hero-content">
        <h1 class="display-6 fw-bold">Grow Together with Volunteering 🌱</h1>
        <p class="lead">Join activities, make friends, and impact your community.</p>
        <a href="{{ Auth::check() ? route('activities.index') : route('register') }}" class="btn btn-primary btn-lg mt-5">Get Started</a>
    </div>
    <div class="hero-image">
        <img src="{{ asset('images/hero.png') }}" alt="Grow with us">
    </div>
</section>

<!-- Latest Activities -->
<section class="container mt-5">
    <strong><h2 class="heading mb-4 text-center">Recent Activities</h2></strong>
    <div class="row">
    @foreach($latestActivities as $activity)
    <div class="col-md-4 mb-3">
        <div class="card shadow-sm h-100 border-0 rounded-3">
            <!-- Card Image -->
            <img src="{{ asset('images/' . $activity->image) }}" class="card-img-top rounded-3" alt="{{ $activity->title }}" style="height: 200px; object-fit: cover;">
            
            <div class="card-body">
                <h5 class="card-title text-dark">{{ $activity->title }}</h5>
                <p class="card-text text-muted">{{ Str::limit($activity->description, 100) }}</p>
                <a href="{{ route('activities.show', $activity->id) }}" class="btn btn-primary btn-sm rounded-pill">View</a>
            </div>
        </div>
    </div>
@endforeach
    </div>
    <div class="text-center mt-3">
        <a href="{{ route('activities.index') }}" class="btn btn-primary btn-lg mt-5">See More Activities</a>
    </div>
</section>

<!-- Posts Section -->
<section class="container mt-5">
    <strong><h2 class="heading mb-4 text-center">Community</h2></strong>
    @include('posts.partials.post-list', ['posts' => $latestPosts])
</section>

@include('layouts.footer')
@endsection
