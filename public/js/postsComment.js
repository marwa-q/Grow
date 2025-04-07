document.addEventListener("DOMContentLoaded", function () {
    // Toggle comments visibility
    document.querySelectorAll(".comment-btn").forEach(button => {
        button.addEventListener("click", function () {
            const postId = this.getAttribute("data-post-id");
            const commentsContainer = document.getElementById(`comments-${postId}`);
            
            if (commentsContainer.classList.contains("d-none")) {
                fetch(`/posts/${postId}/comments`)
                    .then(response => response.json())
                    .then(data => {
                        const commentsList = commentsContainer.querySelector(".comments-list");
                        commentsList.innerHTML = "";
                        data.comments.forEach(comment => {
                            // Check if user data is available
                            const fullName = comment.user ? `${comment.user.first_name} ${comment.user.last_name}` : 'Anonymous';
                            commentsList.innerHTML += `
                                <div class="border-bottom py-1">
                                    <strong>${fullName}</strong>: ${comment.comment}
                                    <small class="text-muted"> ${comment.created_at}</small>
                                </div>`;
                        });
                        commentsContainer.classList.remove("d-none");
                    })
                    .catch(error => console.error("Error fetching comments:", error));
            } else {
                commentsContainer.classList.add("d-none");
            }
        });
    });

    // Add comment without page reload
    document.querySelectorAll(".add-comment-btn").forEach(button => {
        button.addEventListener("click", function () {
            const postId = this.getAttribute("data-post-id");
            const inputField = document.querySelector(`.comment-input[data-post-id='${postId}']`);
            const comment = inputField.value.trim();

            if (comment === "") return;

            fetch(`/posts/${postId}/comments`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ comment: comment })
            })
            .then(response => response.json())
            .then(data => {
                if (data.comment) {
                    // Check if user data is available
                    const fullName = data.comment.user ? `${data.comment.user.first_name} ${data.comment.user.last_name}` : 'Anonymous';
                    const commentsList = document.getElementById(`comments-${postId}`).querySelector(".comments-list");
                    commentsList.innerHTML += `
                        <div class="border-bottom py-1">
                            <strong>${fullName}</strong> ${data.comment.comment}
                            <small class="text-muted"> (${data.comment.created_at})</small>
                        </div>`;
                    
                    const commentCountElement = document.querySelector(`.comment-count[data-post-id='${postId}']`);
                    if (commentCountElement) {
                        commentCountElement.textContent = data.comments_count;
                    }
                    inputField.value = "";
                }
            })
            .catch(error => console.error("Error adding comment:", error));
        });
    });
});
