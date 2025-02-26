<?php
session_start();
include("../includes/db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $customer_phone = mysqli_real_escape_string($conn, $_POST['customer_phone']);
    $customer_address = mysqli_real_escape_string($conn, $_POST['customer_address']);

    $user = $_SESSION['username'];

    // Insert customer record into the customers table
    $stmt = $conn->prepare("INSERT INTO customers (name, phone_number, address, username) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $customer_name, $customer_phone, $customer_address, $user);

    // Check if the customer was added successfully
    if ($stmt->execute()) {
        $_SESSION['message'] = "New customer added successfully!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Field to add customer. Error: " . $stmt->error;
        $_SESSION['message_type'] = "danger";
    }
    $stmt->close();
    header("location: ../customers.php");
    exit();
}
?>