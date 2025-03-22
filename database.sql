-- Create the main database for the application
CREATE DATABASE amaers;

-- Use the newly created database
USE amaers;

-- Users table to store user information
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Unique identifier for each user
    usn VARCHAR(50) NOT NULL UNIQUE,    -- Unique username for the user
    email VARCHAR(255) NOT NULL UNIQUE, -- Unique email address for the user
    password_hash VARCHAR(255) NOT NULL, -- Hashed password for security
    profile_picture VARCHAR(255),        -- URL or path to the user's profile picture
    role ENUM('user', 'admin') DEFAULT 'user', -- User role (default is 'user')
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Timestamp for when the user was created
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP -- Timestamp for when the user was last updated
);

-- Password Resets table to manage password reset requests
CREATE TABLE password_resets (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Unique identifier for each password reset request
    email VARCHAR(255) NOT NULL,       -- Email of the user requesting the reset
    token VARCHAR(255) NOT NULL,       -- Unique token for the password reset
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Timestamp for when the reset request was created
    FOREIGN KEY (email) REFERENCES users(email) ON DELETE CASCADE -- Foreign key to link to the users table
);

-- Categories table to categorize posts
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Unique identifier for each category
    name VARCHAR(50) NOT NULL UNIQUE    -- Name of the category
);

-- Posts table to store user-generated content
CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Unique identifier for each post
    user_id INT NOT NULL,               -- ID of the user who created the post
    title VARCHAR(255) NOT NULL,        -- Title of the post
    body TEXT NOT NULL,                 -- Main content of the post
    category_id INT,                    -- ID of the category for the post
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Timestamp for when the post was created
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE, -- Foreign key to link to the users table
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL -- Foreign key to link to the categories table
);

-- Comments table to store comments on posts
CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Unique identifier for each comment
    post_id INT NOT NULL,               -- ID of the post being commented on
    user_id INT NOT NULL,               -- ID of the user who made the comment
    body TEXT NOT NULL,                 -- Content of the comment
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Timestamp for when the comment was created
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE, -- Foreign key to link to the posts table
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE -- Foreign key to link to the users table
);

-- Likes table to store likes on posts
CREATE TABLE likes (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Unique identifier for each like
    post_id INT NOT NULL,               -- ID of the post being liked
    user_id INT NOT NULL,               -- ID of the user who liked the post
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Timestamp for when the like was made
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE, -- Foreign key to link to the posts table
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE -- Foreign key to link to the users table
);

-- Follows table to manage user follow relationships
CREATE TABLE follows (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Unique identifier for each follow relationship
    follower_id INT NOT NULL,           -- ID of the user who is following
    following_id INT NOT NULL,          -- ID of the user being followed
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Timestamp for when the follow was created
    FOREIGN KEY (follower_id) REFERENCES users(id) ON DELETE CASCADE, -- Foreign key to link to the users table
    FOREIGN KEY (following_id) REFERENCES users(id) ON DELETE CASCADE -- Foreign key to link to the users table
);

-- Notifications table to store user notifications
CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Unique identifier for each notification
    user_id INT NOT NULL,               -- ID of the user receiving the notification
    body TEXT NOT NULL,                 -- Content of the notification
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Timestamp for when the notification was created
    status ENUM('unread', 'read') DEFAULT 'unread', -- Status of the notification
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE -- Foreign key to link to the users table
);

-- Messages table to store direct messages between users
CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Unique identifier for each message
    sender_id INT NOT NULL,             -- ID of the user sending the message
    receiver_id INT NOT NULL,           -- ID of the user receiving the message
    body TEXT NOT NULL,                 -- Content of the message
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Timestamp for when the message was sent
    status ENUM('sent', 'delivered', 'read') DEFAULT 'sent', -- Status of the message
    FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE, -- Foreign key to link to the users table
    FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE -- Foreign key to link to the users table
);