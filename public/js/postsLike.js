document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".like-form").forEach(form => {
        form.addEventListener("submit", function (event) {
            event.preventDefault();

            let formData = new FormData(this);
            let likeButton = this.querySelector(".like-btn");
            let postId = likeButton.getAttribute("data-post-id");
            let likeStats = this.closest(".card").querySelector(".like-stats");

            fetch(this.action, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Request failed");
                }
                return fetch(`/posts/${postId}/comments`); // temporary fetch just to simulate follow-up call
            })
            .then(() => {
                // Toggle like button state
                if (likeButton.classList.contains("liked")) {
                    likeButton.classList.remove("liked");
                    likeButton.innerHTML = `<i class="bi bi-heart"></i> Like`;
                } else {
                    likeButton.classList.add("liked");
                    likeButton.innerHTML = `<i class="bi bi-heart-fill text-danger"></i> Liked`;
                }

                // Update like count manually (optional: re-fetch from server instead)
                let currentCount = parseInt(likeStats.textContent);
                likeStats.textContent = likeButton.classList.contains("liked") 
                    ? currentCount + 1 
                    : currentCount - 1;
            })
            .catch(error => console.error("Error toggling like:", error));
        });
    });
});
