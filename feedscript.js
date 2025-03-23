document.addEventListener("DOMContentLoaded", () => {
    const feedbackContainer = document.getElementById("feedback-container");

    // Sample feedback data (can be replaced with an API call)
    const feedbackData = [
        { id: 1, message: "Great event! Very well managed." },
        { id: 2, message: "Would love to see more networking sessions." },
        { id: 3, message: "The keynote speaker was amazing!" }
    ];

    function displayFeedback() {
        feedbackContainer.innerHTML = ""; // Clear existing feedback

        feedbackData.forEach(feedback => {
            const feedbackItem = document.createElement("div");
            feedbackItem.classList.add("feedback-item");

            feedbackItem.innerHTML = `
                <p>${feedback.message}</p>
                <button class="delete-btn" onclick="deleteFeedback(${feedback.id})">Dismiss</button>
            `;

            feedbackContainer.appendChild(feedbackItem);
        });

        // Update notification count
        document.querySelector(".msg_count").textContent = feedbackData.length;
    }

    // Function to delete feedback
    window.deleteFeedback = function (id) {
        const index = feedbackData.findIndex(f => f.id === id);
        if (index !== -1) {
            feedbackData.splice(index, 1);
            displayFeedback();
        }
    };

    // Load feedback on page load
    displayFeedback();
});
