<?php
$host = "localhost";
$user = "root";
$password = "";

$conn = new mysqli($host, $user, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE DATABASE IF NOT EXISTS greenpanier";
$conn->query($sql);

$conn->select_db("greenpanier");

$conn->query("CREATE TABLE IF NOT EXISTS users (
                user_id INT AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(100) NOT NULL UNIQUE,
                psswrd VARCHAR(255) NOT NULL,
                role ENUM('admin', 'user') DEFAULT 'user')");

$result = $conn->query("SELECT COUNT(*) as count FROM users WHERE email = 'test_role@admin.gp'");
$row = $result->fetch_assoc();
if ($row['count'] == 0) {
    $conn->query("INSERT INTO users (email, psswrd, role) VALUES ('test_role@admin.gp', 'adminx7xrole', 'admin')");
}

$conn->query("CREATE TABLE IF NOT EXISTS products (
                product_id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                price DECIMAL(10, 2) NOT NULL,
                description TEXT,
                img VARCHAR(255),
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP)");

?>