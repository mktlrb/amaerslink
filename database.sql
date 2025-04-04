CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, -- Store hashed passwords
    role ENUM('users', 'user', 'facilitator') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


<<<<<<< HEAD
-- Insert superadmin user with hashed password
INSERT INTO admin (username, admin_password, admin_role) 
VALUES ('superadmin', '$2y$10$QqO2dYgQyHCcTVxuCGzHMOkkV8v6RhLB3yxQxF3tJ4buBzn5b5H3q', 'superadmin');


<<<<<<< HEAD
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
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 68d0decf812e762e96c6f5166f8480b4504bf096

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

/ for adduser /
CREATE TABLE addusers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usn VARCHAR(50) UNIQUE NULL, -- Only applicable for students
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'facilitator', 'student') NOT NULL,
    student_type ENUM('SHS', 'College') NULL, -- Only applicable for students
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user', 'facilitator') NOT NULL
);

INSERT INTO users (username, password, role) VALUES ('admin', MD5('admin123'), 'admin');
=======
<<<<<<< HEAD
Hashed Password: $2y$10$okKpvcIi8l2JcrA0yNy2R.Y.8GWI5PhKxPylyIAwMahFDzDUh80A6
>>>>>>> 2a6a2c42d68577ee6a28184e73df12bf6cd132eb
=======
INSERT INTO users (username, password, role) VALUES 
('admin', MD5('admin123'), 'admin');
<<<<<<< HEAD


CREATE TABLE feedbacks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    feedback TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
=======
>>>>>>> 152abee31f8cb26c62e08f5c85278c135b05c352
>>>>>>> 0c0e7dec8846dc2288b079c03f353e4104d17b0f
=======
>>>>>>> d6359cfc957ee8e675dba48add4fd1bc41d7789f
>>>>>>> 68d0decf812e762e96c6f5166f8480b4504bf096
