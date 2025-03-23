CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    admin_password VARCHAR(255) NOT NULL,
    admin_role VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert admin user with hashed password
INSERT INTO admin (username, admin_password, admin_role) 
VALUES ('admin', '$2y$10$Zxw7E7fLh9A0J.kl5hRf.u1xaAqI1RkB5QNOk2EguVkct9GjBoq.i', 'admin');

-- Insert superadmin user with hashed password
INSERT INTO admin (username, admin_password, admin_role) 
VALUES ('superadmin', '$2y$10$QqO2dYgQyHCcTVxuCGzHMOkkV8v6RhLB3yxQxF3tJ4buBzn5b5H3q', 'superadmin');


Hashed Password: $2y$10$okKpvcIi8l2JcrA0yNy2R.Y.8GWI5PhKxPylyIAwMahFDzDUh80A6