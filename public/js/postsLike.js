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
            .then(response => response.json())  // Parse as JSON to get the result from the server
            .then(data => {
                // Toggle like button state
                if (data.liked) {
                    likeButton.classList.add("liked");
                    likeButton.innerHTML = `<i class="bi bi-heart-fill text-danger"></i> Liked`;
                    likeStats.textContent = data.likeCount;
                } else {
                    likeButton.classList.remove("liked");
                    likeButton.innerHTML = `<i class="bi bi-heart"></i> Like`;
                    likeStats.textContent = data.likeCount;
                }
            })
            .catch(error => console.error("Error toggling like:", error));
        });
    });
});
