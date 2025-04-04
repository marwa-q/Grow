$(document).ready(function () {
    // Add Post
    $('#addPostForm').submit(function (e) {
        e.preventDefault();

        let formData = new FormData(this);
        $.ajax({
            url: "{{ route('posts.store') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $('#addPostModal').modal('hide');
                $('#addPostForm')[0].reset();
                $('#posts-container').prepend(response.posts);
            },
            error: function (xhr) {
                alert('Something went wrong!');
            }
        });
    });

    // Lazy Load More Posts
    let page = 2;
    $('#load-more-btn').click(function () {
        $.ajax({
            url: "{{ route('posts.loadMore') }}",
            type: "GET",
            data: { page: page },
            success: function (response) {
                $('#posts-container').append(response.posts);
                page++;
            },
            error: function () {
                alert('No more posts!');
            }
        });
    });
});
