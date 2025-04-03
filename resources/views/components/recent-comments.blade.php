<!-- resources/views/components/recent-comments.blade.php -->
<div class="card card-dashboard">
    <div class="card-header bg-white">
        <h5 class="mb-0">Recent Comments</h5>
    </div>
    <div class="card-body p-0">
        <ul class="list-group list-group-flush">
            @forelse($comments as $comment)
            <li class="list-group-item p-3">
                <div class="d-flex">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name) }}&background=random"
                        class="rounded-circle me-3" width="40" height="40" alt="{{ $comment->user->name }}">
                    <div>
                        <h6 class="mb-1">{{ $comment->user->name }}</h6>
                        <p class="mb-1 text-muted small">{{ $comment->content }}</p>
                        <span class="small text-muted">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </li>
            @empty
            <li class="list-group-item p-3 text-center">
                <p class="mb-0 text-muted">No comments yet.</p>
            </li>
            @endforelse
        </ul>
    </div>
    <div class="card-footer bg-white text-center">
    <a href="{{ route('comments.index') }}" class="btn btn-sm btn-outline-primary">View All Comments</a>
    </div>
</div>