@foreach ($posts as $post)
<div class="post-card card rounded shadow-sm my-3 p-2" style="max-width: 600px; margin: auto;">

<!-- User Info Section -->
    <div class="card-header bg-white border-0 d-flex align-items-center p-3">
        <div class="avatar me-2">
            <img src="{{ $post->user->profile_photo ?? asset('images/avatar.jpg') }}" class="rounded-circle" width="40" height="40" alt="User Avatar">
        </div>
        <div class="user-info">
            <h6 class="mb-0 fw-bold">{{ $post->user->first_name }}</h6>
            <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
        </div>
        
        <!-- Options Menu (three dots) -->
        <div class="dropdown ms-auto">
            <button class="btn btn-sm text-muted bg-transparent border-0" type="button" id="postOptionsMenu{{ $post->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-three-dots-vertical"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="postOptionsMenu{{ $post->id }}">
                <li><a class="dropdown-item" href="#">Report</a></li>
                @if(auth()->id() == $post->user_id)
                    <li><a class="dropdown-item" href="{{ route('posts.edit', $post->id) }}">Edit</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="dropdown-item text-danger" type="submit">Delete</button>
                        </form>
                    </li>
                @endif
            </ul>
        </div>
    </div>
    
    <!-- Post Content -->
    <div class="card-body pt-1 pb-2 px-3">
        <!-- Post Title (if exists) -->
        @if($post->title)
            <h5 class="card-title mb-2">{{ $post->title }}</h5>
        @endif
        
        <!-- Post Content Text -->
        <p class="card-text mb-3">{{ $post->content }}</p>
        
        <!-- Post Image (if exists) -->
        @if($post->image)
        
            <div class="post-image mb-3">
                <img  style="width: 700px;" src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="img-fluid rounded">
            </div>
        @endif
        
        <!-- Post Stats (Likes/Comments count) -->
        <div class="d-flex align-items-center mt-2 text-muted small">
            <div class="me-3">
                <p><span class="like-stats">{{ $post->likes->count() }}</span> Likes
                </p>
            </div>
            <div>
                <p><span class="comment-stats">{{ $post->comments->count() }}</span> comments
                </p>
        </div>
        </div>
    </div>
    
    <!-- Divider -->
    <hr class="my-1">
    
    <!-- Action Buttons -->
    <div class="card-footer bg-white border-0 d-flex justify-content-between p-2">
        <form action="{{ Auth::check() ? route('posts.like', $post->id) : route('login') }}" method="POST" class="like-form flex-fill">
            @csrf
            @if($post->likes->contains('user_id', auth()->id()))
                @method('DELETE')
                <button type="submit" class="btn btn-light w-100 like-btn liked rounded-pill py-1" data-post-id="{{ $post->id }}">
                    <i class="bi bi-heart-fill text-danger"></i> Liked
                </button>
            @else
                <button type="submit" class="btn btn-light w-100 like-btn rounded-pill py-1" data-post-id="{{ $post->id }}">
                    <i class="bi bi-heart"></i> Like
                </button>
            @endif
        </form>
        
        <button class="btn btn-light flex-fill ms-2 comment-btn rounded-pill py-1" data-post-id="{{ $post->id }}">
            <i class="bi bi-chat"></i> Comment
        </button>
    
    </div>
    
    <!-- Comments Section -->
    <div class="comments-container bg-light p-3 d-none" id="comments-{{ $post->id }}">
        <div class="comments-list mb-3">
            <!-- Comments will be loaded here -->
        </div>
        
        <!-- Comment Form -->
        @auth
            <div class="d-flex">
                <div class="avatar me-2">
                    <img src="{{ auth()->user()->profile_photo ?? asset('images/avatar.jpg') }}" class="rounded-circle" width="32" height="32" alt="Avatar">
                </div>
                <div class="flex-grow-1">
                    <div class="input-group">
                        <input type="text" class="form-control rounded-pill comment-input" data-post-id="{{ $post->id }}" placeholder="Write a comment...">
                        <button class="btn btn-primary rounded-pill ms-2 add-comment-btn" data-post-id="{{ $post->id }}">Post</button>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-2">
                <p class="text-muted mb-0">
                    <a href="{{ route('login') }}" class="text-primary">Sign in</a> to comment on this post
                </p>
            </div>
        @endauth
    </div>
</div>
@endforeach

    <!-- Load More Button -->
    <div class="text-center">
        <a href="{{ route('posts.index')}}" id="load-more-btn" class="btn btn-primary btn-lg mt-3 mb-3">Load More</a>
    </div>
