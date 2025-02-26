<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("../includes/db_connect.php");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $amount = $_POST['amount'];
    $destination = "Stock";
    $conn->query("UPDATE products SET warehouse = warehouse - $amount, stock = stock + $amount WHERE id = $id");
    $stmt = $conn->prepare("INSERT INTO stock_transfers (product_id, quantity, transfer_date, destination) VALUES (?, ?, NOW(), ?)");
    $stmt->bind_param("iis", $id, $amount, $destination);
    $stmt->execute();
    $_SESSION['message'] = "Transaction performed successfully";
    $_SESSION['message_type'] = "success";
    header("location: ../products.php");
    exit();
}
?>