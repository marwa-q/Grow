@extends('layouts.app')
@section('title' , 'Grow')
@section('content')
<div class="container mt-5">
    <!-- Add Post Button -->
    @auth
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addPostModal">
            + Add Post
        </button>
    @endauth

    <!-- Posts Section -->
    <div id="posts-container">
        @include('posts.partials.post-list', ['posts' => $posts])
    </div>

    <!-- Load More Button -->
    <div class="text-center mt-3">
        <button id="load-more-btn" class="btn btn-secondary">Load More</button>
    </div>
</div>

<!-- Add Post Modal (For Authenticated Users) -->
@auth
    <div class="modal fade" id="addPostModal" tabindex="-1" aria-labelledby="addPostModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPostModalLabel">Add New Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addPostForm" method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image (optional)</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <button type="submit" class="btn btn-success">Post</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endauth

<!-- Login Reminder Modal (For Guests) -->
@guest
    <div class="modal fade" id="loginReminderModal" tabindex="-1" aria-labelledby="loginReminderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginReminderModalLabel">Notice</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="text-danger fw-bold">You must be logged in to add a post!</p>
                    <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                </div>
            </div>
        </div>
    </div>
@endguest

@endsection
