<?php

require 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = $_POST['email'] ?? '';
    $psswrd = $_POST['psswrd'] ?? '';

    $hashed_psswrd = password_hash($psswrd, PASSWORD_DEFAULT);

    $statement = $conn->prepare("INSERT INTO users (email, psswrd) VALUES (?, ?)");
    $statement->bind_param("ss", $email, $hashed_psswrd);

    if ($statement->execute()) {
        echo "<h1 style='color:green; text-align:center;'>Registration successful. Redirecting to the home page...</h1>";
        header("refresh:1; url=...html");
    } else {
        echo "<h1 style='color:red; text-align:center;'>Registration failed! Try a different email.</h1>";
    }

    $statement->close();
}

$conn->close();
?>
