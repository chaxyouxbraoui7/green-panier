<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../pages/login.html");
    exit();
}

require_once '../server/db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $img = $_POST['img'];
    $stmt = $conn->prepare("INSERT INTO products (name, description, price, img) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $name, $description, $price, $img);
    $stmt->execute();
}

if (isset($_POST['update_product'])) {
    $id = $_POST['product_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stmt = $conn->prepare("UPDATE products SET name=?, price=? WHERE product_id=?");
    $stmt->bind_param("sdi", $name, $price, $id);
    $stmt->execute();
}

if (isset($_POST['delete_product'])) {
    $id = $_POST['product_id'];
    $stmt = $conn->prepare("DELETE FROM products WHERE product_id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

$products = [];
$result = $conn->query("SELECT * FROM products");
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="icon" href="../GreenPanier/assets/images/logo/favicon.ico" type="image/x-icon"/>
  <link rel="stylesheet" href="../assets/greenpanier.css">
  <title>GreenPanier | Admin Dashboard</title>
  <style>

    :root {
        --background: whitesmoke;
        --color: black;
        --primary-color: lightgreen;
    }

    * {
        box-sizing: border-box;
    }

    html {
        scroll-behavior: smooth;
    }

    body {
        margin: 0;
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
        background: var(--background);
        color: var(--color);
        letter-spacing: 1px;
        padding: 25px;
        width: 75%;
        margin: 0 auto;
        text-align: center;
    }

    .container::-webkit-scrollbar {
        display: none;
    }

    .admin_sec {
        border: 1px solid hsla(0, 0%, 65%, 0.158);
        box-shadow: 0 0 33px 1px rgba(0, 0, 0, 0.1);
        border-radius: 15px;
        backdrop-filter: blur(25px);
        padding: 25px;
        margin-bottom: 25px;
        position: relative;
        overflow: hidden;
    }

    form input {
        display: block;
        padding: 15px;
        width: 50%;
        margin: 11px auto;
        outline: none;
        background: none;
        border: 0.25px solid black;
        border-radius: 5px;
        letter-spacing: 1px;
        font-size: 15px;
    }

    button {
        background-color: var(--primary-color);
        display: block;
        padding: 15px;
        border-radius: 5px;
        outline: none;
        font-size: 15px;
        letter-spacing: 1.5px;
        font-weight: bolder;
        width: 11%;
        cursor: pointer;
        margin: auto;
        transition: all 0.125s ease-in-out;
        border: none;
    }

    button:hover {
        box-shadow: 0 0 15px 1px rgba(0, 0, 0, 0.125);
        transform: scale(1.25);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        border-radius: 8px;
        overflow: hidden;
    }

    th, td {
        padding: 15px;
        text-align: center;
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    }

    th {
        background-color: rgba(144, 238, 144, 0.25);
        font-weight: bold;
    }

    .edit-user_name, .edit-price, .edit-stock {
        width: 100%;
        font-size: 15px;
        text-align: center;
        padding: 7px;
        border: 1px solid rgba(0, 0, 0, 0.1);
    }

    .update_btn, .delete_btn {
        padding: 12px;
        margin: 15px;
        gap: 7px;
        width: 25%;
        display: inline-block;
        font-size: 12px;
    }

    .update_btn {
        text-decoration: overline;
        background: none;
    }

    .update_btn:hover{
        text-decoration: none;
        background: var(--primary-color);
    }

    .delete_btn {
        text-decoration: overline;
        background: none;
    }

    .delete_btn:hover{
        text-decoration: none;
        background: darkred;
    }

  </style>
</head>
<body class="container">
  <div>
    <h1>Admin Dashboard</h1>
    <section class="admin_sec">
      <div class="bubble-effect"></div>
      <h2>Add New Product</h2>
      <form method="POST">
        <input type="text" name="name" placeholder="Product Name" required/>
        <input type="text" name="description" placeholder="Description"/>
        <input type="number" step="1" min="0" max="33" name="price" placeholder="The Price" required/>
        <input type="text" name="img" placeholder="The Image path"/>
        <button type="submit" name="add_product">Add</button>
      </form>
    </section>

    <section class="admin_sec">
      <h2>Manage Products</h2>
      <table>
        <thead>
          <tr>
            <th>Product Name</th><th>Price (DH)</th><th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($products as $product):?>

            <tr>
              <form method="POST">
                <td style="border-right: 0.25px solid lightgreen">
                  <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" class="edit-user_name">
                </td>
                <td style="border-right: 0.25px solid lightgreen">
                  <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" class="edit-price">
                </td>
                <td>
                  <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                  <button type="submit" name="update_product" class="update_btn">Update</button>
                  <button type="submit" name="delete_product" class="delete_btn" onclick="return confirm('You sure want to delete this product?')">Delete</button>
                </td>
              </form>
            </tr>

          <?php endforeach; ?>
        </tbody>
      </table>
    </section>
  </div>

  <script src="../assets/greenpanier.js"></script>
</body>
</html>