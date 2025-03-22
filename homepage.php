<?php
// Set the content type to HTML
header("Content-Type: text/html; charset=UTF-8");

// Start output buffering
ob_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="homepage.css">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Add Bootstrap Icons in the <head> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

</head>

<body class="bg-light">

    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container-fluid">
            <!-- Sidebar & Navbar Toggle Button -->
            <button class="btn btn-outline-dark d-lg-none" id="menuToggle" aria-expanded="false">☰</button>

            <a class="navbar-brand ms-3" href="#">
                <img src="images/logo 1.png" alt="Logo" height="40">
            </a>

            <!-- Search Bar (Hidden on Small Screens) -->
            <form class="d-none d-md-flex me-auto">
                <input type="text" id="searchInput" class="form-control" placeholder="Search">
            </form>

            <!-- Navbar Icons -->
            <div class="d-flex align-items-center navbar-icons d-none d-md-flex">
                <a href="notif.html"><img src="images/Bell.png" height="30" alt="Notifications"></a>
                <a href="homepage.html" class="btn">
                    <img src="images/Home.png" height="30" alt="Home">
                </a>
                <a href="profile.html"><img src="images/Generic avatar.png" class="rounded-circle" height="40" alt="Avatar"></a>
            </div>
        </div>
    </nav>

    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="sidebar bg-white shadow-sm p-3 position-fixed" id="sidebar">
            <ul class="nav flex-column">
                <!-- Profile Link -->
                <li class="nav-item">
                    <a href="profile.html" class="nav-link text-dark">
                        <img src="images/Generic avatar.png" height="30" alt="Profile Icon"> Profile
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <button class="nav-link text-dark"><img src="images/Home.png" height="30"> Home</button>
                </li>
                <li class="nav-item mb-2">
                    <a href="notif.html" class="nav-link text-dark"><img src="images/Bell.png" height="30"> Notification</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="sched.html" class="nav-link text-dark"><img src="images/Calendar.png" height="30"> Schedules</a>
                </li>
                <li class="nav-item">
                    <a href="index.html" class="nav-link text-danger"><img src="images/Log out.png" height="30"> Log Out</a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main id="main-container" class="container mt-5 pt-4">
            <div class="card p-3 mb-2 bg-white text-dark">
                <div class="d-flex align-items-center">
                    <img src="images/Generic avatar.png" class="rounded-circle me-2" height="40" alt="Avatar">
                    <div class="position-relative w-100">
                        <textarea id="postInput" class="form-control text-dark" placeholder="Hello, what's up?" rows="1"
                            style="font-size: 15px;" data-bs-toggle="modal" data-bs-target="#createPostModal"
                            readonly></textarea>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-around">
                    <button class="btn btn-white text-success">
                        <img src="images/gallery.png" height="20" class="me-1">
                        Photo/Video</button>

                    <button class="btn btn-white text-success">
                        <img src="images/Folder.png" height="20" class="me-1">
                        Files</button>
                </div>
            </div>

            <!-- Create Post Modal -->
            <div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="createPostModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createPostModalLabel">Create Post</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="d-flex align-items-center mb-2">
                                <img src="images/Generic avatar.png" class="rounded-circle me-2" height="40"
                                    alt="Avatar">
                                <span><strong>John Doe</strong></span>
                            </div>

                            <div class="dropdown" style="left: 45px; top: -15px">
                                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                    style="width: 80px; font-size: 12px; padding: 4px; color: #8E0404; border-color: #8E0404;">
                                    Audience
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">ALL</a></li>
                                    <li><a class="dropdown-item" href="#">SHS</a></li>
                                    <li><a class="dropdown-item" href="#">COLLEGE</a></li>
                                </ul>
                            </div>

                            <textarea class="form-control mb-2" rows="3" placeholder="Hello, what's up?"
                                style="height: 150px;"></textarea>
                            <div class="d-flex justify-content-around">
                                <button class="btn btn-light text-success"><img src="images/gallery.png" height="20"
                                        class="me-1"> Photo/Video</button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary"
                                style="width: 100%; background-color: #8E0404;">Post</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dropdown sort-dropdown mb-3" style="left: 10px; top: 5px">
                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                    style="width: 80px; font-size: 12px; padding: 4px; color: #8E0404; border-color: #8E0404;">
                    Sort
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">ALL</a></li>
                    <li><a class="dropdown-item" href="#">SHS</a></li>
                    <li><a class="dropdown-item" href="#">COLLEGE</a></li>
                </ul>
            </div>

            <!-- Announcements -->
            <div class="card p-3 mb-2">
                <div class="d-flex align-items-center">
                    <img src="images/Generic avatar.png" class="rounded-circle me-2" height="40" alt="Avatar">
                    <div>
                        <strong>SSG</strong> <span class="text-muted">/Facilitator</span><br>
                        <small class="text-muted">Aug 01, 2024 at 11:59pm &middot;
                            <span class="category-label" data-category="SHS">SHS</span>
                        </small>
                    </div>
                </div>
                <p class="mt-2">Anunsyo: Tamang Kasuotan para sa Pagdidiriwang ng Buwan ng Wika na Gaganapin sa ika-30
                    ng Agosto Taong 2024.</p>
                <div class="d-flex">
                    <label class="ui-bookmark">
                        <input type="checkbox" />
                        <div class="bookmark" style="top: 5px; left: 5px;">
                            <svg viewBox="0 0 16 16" style="margin-top:4px" class="bi bi-heart-fill" height="25"
                                width="25" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314" fill-rule="evenodd"></path>
                            </svg>
                        </div>
                    </label>
                    <button class="chatbox" data-bs-toggle="modal" data-bs-target="#commentModal">
                        <i class="bi bi-chat-dots" style="font-size: 1.5rem; cursor: pointer; left: 10px;"></i>
                    </button>
                </div>
            </div>

            <!-- Comment Modal -->
            <div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="commentModalLabel">Add a Comment</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="d-flex align-items-center">
                                <img src="images/Generic avatar.png" class="rounded-circle me-2" height="40"
                                    alt="Avatar">
                                <div>
                                    <strong>SSG</strong> <span class="text-muted">/Facilitator</span><br>
                                    <small class="text-muted">Aug 01, 2024 at 11:59pm</small>
                                </div>
                            </div>
                            <p class="mt-2">Anunsyo: Tamang Kasuotan para sa Pagdidiriwang ng Buwan ng Wika na Gaganapin
                                sa ika-30 ng Agosto Taong 2024.</p>
                            <hr>
                            <textarea class="form-control" id="commentText" rows="3"
                                placeholder="Write your comment here..."></textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="submitComment">Comment</button>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <!-- Custom Script for Sidebar and Navbar Toggle -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Sidebar elements
            const sidebar = document.getElementById("sidebar");
            const menuToggle = document.getElementById("menuToggle");

            // Dropdown elements
            const audienceButton = document.querySelector(".dropdown button");
            const dropdownItems = document.querySelectorAll(".dropdown-menu .dropdown-item");
            const sortDropdown = document.querySelector(".sort-dropdown");
            const sortButton = sortDropdown.querySelector("button");
            const sortDropdownItems = sortDropdown.querySelectorAll(".dropdown-item");

            // Announcement & search elements
            const announcements = document.querySelectorAll(".announcement-card"); // Each announcement card
            const searchInput = document.getElementById("searchInput"); // Search bar input

            // Sidebar toggle functionality
            function handleSidebar() {
                if (window.innerWidth < 1900) {
                    sidebar.classList.add("collapsed");
                    menuToggle.style.display = "block";
                } else {
                    sidebar.classList.remove("collapsed");
                    menuToggle.style.display = "none";
                }
            }

            // Initialize sidebar behavior based on window size
            handleSidebar();
            window.addEventListener("resize", handleSidebar);

            // Toggle sidebar on menu button click
            menuToggle.addEventListener("click", function (event) {
                event.stopPropagation(); // Prevents the event from bubbling up
                sidebar.classList.toggle("collapsed");
                sidebar.classList.toggle("show");
            });

            // Hide sidebar when clicking outside of it
            document.addEventListener("click", function (event) {
                if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                    sidebar.classList.remove("show");
                }
            });

            // Audience dropdown functionality
            dropdownItems.forEach(item => {
                item.addEventListener("click", function (event) {
                    event.preventDefault();
                    audienceButton.textContent = this.textContent; // Update button text
                });
            });

            // Function to sort announcements by category
            function sortAnnouncements(category) {
                const selectedCategory = category.toUpperCase();

                announcements.forEach(announcement => {
                    const categoryLabel = announcement.getAttribute("data-category")?.toUpperCase();

                    if (selectedCategory === "ALL" || categoryLabel === selectedCategory) {
                        announcement.style.display = "block"; // Show matching announcements
                    } else {
 announcement.style.display = "none"; // Hide non-matching announcements
                    }
                });
                searchAnnouncements(); // Reapply search filter after sorting
            }

            // Sort dropdown functionality
            sortDropdownItems.forEach(item => {
                item.addEventListener("click", function (event) {
                    event.preventDefault();
                    const selectedText = this.textContent.trim();
                    sortButton.childNodes[0].nodeValue = selectedText + " "; // Update button text
                    sortAnnouncements(selectedText); // Apply sorting
                });
            });

            // Search functionality - filters announcements based on search input
            function searchAnnouncements() {
                const searchText = searchInput.value.trim().toLowerCase();

                announcements.forEach(announcement => {
                    const isVisible = announcement.style.display !== "none"; // Check if it's already visible
                    const textContent = announcement.textContent.toLowerCase();

                    // Hide if it doesn't match search query
                    if (isVisible && !textContent.includes(searchText)) {
                        announcement.style.display = "none";
                    }
                });
            }

            // Listen for input in the search bar
            searchInput.addEventListener("input", searchAnnouncements);

            // Like button functionality (heart icon)
            document.querySelectorAll(".heart-icon").forEach(heart => {
                heart.addEventListener("click", function () {
                    this.classList.toggle("bi-heart");
                    this.classList.toggle("bi-heart-fill");
                    this.style.color = this.classList.contains("bi-heart-fill") ? "red" : "";
                });
            });

            // Function to add a new comment when pressing "Enter"
            document.getElementById("commentText")?.addEventListener("keypress", function (event) {
                if (event.key === "Enter") {
                    addComment();
                }
            });

            // Function to add a comment dynamically
            function addComment() {
                let input = document.getElementById("commentText");
                let commentText = input.value.trim();
                if (commentText) {
                    let commentList = document.getElementById("commentList");
                    let div = document.createElement("div");
                    div.className = "comment-item";
                    div.innerHTML = `<span>${commentText}</span> 
                    <button class="delete-comment" onclick="this.parentElement.remove()">X</button>`;
                    commentList.appendChild(div);
                    input.value = ""; // Clear input field after adding comment
                }
            }

            // Function to toggle reply box visibility
            function toggleReplyBox(id) {
                let replyBox = document.getElementById(id);
                replyBox.style.display = replyBox.style.display === 'none' ? 'block' : 'none';
            }

            // Reply button functionality to toggle comment-box visibility
            document.querySelectorAll('.reply-button').forEach(button => {
                button.addEventListener('click', function () {
                    let commentBox = this.closest('.comment').querySelector('.comment-box');
                    if (commentBox.style.display === 'none' || commentBox.style.display === '') {
                        commentBox.style.display = 'block';
                    } else {
                        commentBox.style.display = 'none';
                    }
                });
            });

        });
    </script>

</body>

</html>

<?php
// Output the buffered content
ob_end_flush();
?>