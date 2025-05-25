<?php

require 'db_config.php';

$sql = "SELECT product_id, name, price, description, img FROM products ORDER BY created_at ASC";
$result = $conn->query($sql);

$products = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) { $products[] = $row; }
    
    echo json_encode(["status" => "success", "products" => $products]);
} else {

    echo json_encode(["status" => "empty", "products" => []]);
}

$conn->close();

?>