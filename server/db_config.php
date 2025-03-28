<?php

$host = "localhost";  // Runing nta3 MySQL mn taraf XAMPP locally
$user = "root";       // Hada default MySQL user 3nd XAMPP
$password = "";       // Hada default password but empty
$dbname = "greenbasket"; // Name nta3 database

// Hna l'creating nta3 l'connection
$conn = new mysqli($host, $user, $password, $dbname);

// Hna checking nta3 l'connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully";

?>