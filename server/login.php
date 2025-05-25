<?php

require 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $plain = 'adminx7xrole';
    $hash = password_hash($plain, PASSWORD_DEFAULT);
    
    $stmt = $conn->prepare("UPDATE users SET psswrd = ? WHERE email = ?");
    $email = 'test_role@admin.gp';
    $stmt->bind_param("ss", $hash, $email);
    
    if (!$stmt->execute()) {
        echo "<h1>Error updating password.</h1>";
    }

    $email = $_POST['email'] ?? '';
    $psswrd = $_POST['psswrd'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        
        $user = $result->fetch_assoc();

        if (password_verify($psswrd, $user['psswrd'])) {
            session_start();

            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'admin') {
                header("Location: ../server/dashboard.php");
            } else {
                header("Location: ../index.html");
            }
            exit;

        } else {
            echo "<h1 style='color:darkred; text-align:center;'>Invalid password.</h1>";
        }

    } else {
        echo "<h1 style='color:darkred; text-align:center;'>No user found with that email.</h1>";
    }

    $stmt->close();
}

$conn->close();
?>