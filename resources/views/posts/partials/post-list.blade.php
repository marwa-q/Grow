
@foreach ($posts as $post)
    <div class="card my-3">
        <div class="card-body">
            <h5 class="card-title">{{ $post->title }}</h5>
            <p class="card-text">{{ $post->content }}</p>

            @if($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="img-fluid">
            @endif

    <div class="d-flex align-items-center mt-2">
    <form action="{{ route('posts.like', $post->id) }}" method="POST" class="like-form">
        @csrf
        @if($post->likes->contains('user_id', auth()->id()))
            @method('DELETE')
            <button type="submit" class="like-btn liked" data-post-id="{{ $post->id }}">
                ❤️ <span class="like-count">{{ $post->likes->count() }}</span>
            </button>
        @else
            <button type="submit" class="like-btn" data-post-id="{{ $post->id }}">
                🤍 <span class="like-count">{{ $post->likes->count() }}</span>
            </button>
        @endif
    </form>
            <button class="ml-1 comment-btn" data-post-id="{{ $post->id }}">
                    🗨️ <span class="comment-count">{{ $post->comments->count() }}</span>
            </button>
            </div>
            <!-- Comments Section (Hidden by Default) -->
        <div class="comments-container d-none" id="comments-{{ $post->id }}">
            <div class="comments-list"></div>

            <!-- Comment Form -->
            @auth
            <div class="mt-2">
                <input type="text" class="form-control comment-input" data-post-id="{{ $post->id }}" placeholder="Write a comment...">
                <button class="btn btn-sm btn-primary mt-1 add-comment-btn" data-post-id="{{ $post->id }}">Post</button>
            </div>
            @else
                <p class="text-muted">You must be logged in to comment.</p>
            @endauth
        </div>


        </div>
    </div>
@endforeach