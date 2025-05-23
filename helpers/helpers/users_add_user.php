<?php
session_start();
include("../includes/db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = strtolower($_POST["name"]);
    $password = $_POST["password"];
    $role = $_POST["role"];

    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $role);
    if ($stmt->execute()) {
        $_SESSION['message'] = "User created successfully!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Field to create user! Error: " . $stmt->error;
        $_SESSION['message_type'] = "danger";
    }
    header("location: ../users.php");
    exit();
}
?>