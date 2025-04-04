document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".like-form").forEach(form => {
        form.addEventListener("submit", function (event) {
            event.preventDefault(); // Prevent full page reload

            let formData = new FormData(this);
            let likeButton = this.querySelector(".like-btn");
            let likeCountElement = likeButton.querySelector(".like-count");
            let postId = likeButton.getAttribute("data-post-id");

            fetch(this.action, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                },
                body: formData
            })
            .then(() => {
                return fetch(`/posts/${postId}`); // Re-fetch the post to get updated like count
            })
            .then(response => response.text())
            .then(html => {
                let tempDiv = document.createElement("div");
                tempDiv.innerHTML = html;
                let newLikeSection = tempDiv.querySelector(`.like-form[data-post-id="${postId}"]`);

                if (newLikeSection) {
                    form.parentElement.replaceWith(newLikeSection.parentElement);
                }
            })
            .catch(error => console.error("Error:", error));
        });
    });
});
