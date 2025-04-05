document.addEventListener("DOMContentLoaded", function () {
    // Show/Hide Comments on Button Click
    document.querySelectorAll(".comment-btn").forEach(button => {
        button.addEventListener("click", function () {
            let postId = this.getAttribute("data-post-id");
            let commentsContainer = document.getElementById(`comments-${postId}`);

            if (commentsContainer.classList.contains("d-none")) {
                fetch(`/posts/${postId}/comments`)
                    .then(response => response.json())
                    .then(data => {
                        let commentsList = commentsContainer.querySelector(".comments-list");
                        commentsList.innerHTML = "";
                        data.comments.forEach(comment => {
                            commentsList.innerHTML += `
                                <div class="border-bottom py-1">
                                    <strong>${comment.user}</strong>: ${comment.content}
                                    <small class="text-muted"> (${comment.created_at})</small>
                                </div>`;
                        });
                        commentsContainer.classList.remove("d-none");
                    })
                    .catch(error => console.error("Error:", error));
            } else {
                commentsContainer.classList.add("d-none");
            }
        });
    });

    // Add Comment Without Reloading
    document.querySelectorAll(".add-comment-btn").forEach(button => {
        button.addEventListener("click", function () {
            let postId = this.getAttribute("data-post-id");
            let inputField = document.querySelector(`.comment-input[data-post-id='${postId}']`);
            let content = inputField.value;

            if (content.trim() === "") return;

            fetch(`/posts/${postId}/comments`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ content })
            })
            .then(response => response.json())
            .then(data => {
                if (data.comment) {
                    let commentsList = document.getElementById(`comments-${postId}`).querySelector(".comments-list");
                    commentsList.innerHTML += `
                        <div class="border-bottom py-1">
                            <strong>${data.comment.user}</strong>: ${data.comment.content}
                            <small class="text-muted"> (${data.comment.created_at})</small>
                        </div>`;

                    document.querySelector(`.comment-count[data-post-id='${postId}']`).textContent = data.comments_count;
                    inputField.value = "";
                }
            })
            .catch(error => console.error("Error:", error));
        });
    });
});
