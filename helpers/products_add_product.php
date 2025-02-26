<?php
session_start();
include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name'])) {
    // Get form data for adding a new product
    $product_name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = !empty($_POST['description']) ? mysqli_real_escape_string($conn, $_POST['description']) : NULL;
    $stock = 0;

    // Insert product record into the products table
    $stmt = $conn->prepare("INSERT INTO products (name, description, stock) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $product_name, $description, $stock);

    // Check if the product was added successfully
    if ($stmt->execute()) {
        $_SESSION['message'] = "Product added successfully.";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Filed to update the dollar rate. Error: " . $stmt->error;
        $_SESSION['message_type'] = "danger";
    }
    $stmt->close();
    header("location: ../products.php");
    exit();
}
?>