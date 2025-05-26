CREATE DATABASE IF NOT EXISTS greenpanier;
USE greenpanier;

CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    psswrd VARCHAR(255) NOT NULL
);

ALTER TABLE users ADD role ENUM('admin', 'user') DEFAULT 'user';

INSERT INTO users (email, psswrd, role) VALUES ('test_role@admin.gp', 'adminx7xrole', 'admin');

CREATE TABLE IF NOT EXISTS products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    description TEXT,
    img VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);