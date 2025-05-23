<?php
session_start();
include("../includes/db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = strtolower($_POST['username']);
    $password = $_POST['password'];
    $user = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $user->bind_param("ss", $username, $password);
    $user->execute();
    $result = $user->get_result();
    $userResult = $result->fetch_assoc();

    if ($userResult) {
        $_SESSION['username'] = $userResult['username'];
        $_SESSION['password'] = $userResult['password'];
        $_SESSION['role'] = $userResult['role'];
        $_SESSION['message'] = "Welcome " . $userResult['username'];
        $_SESSION['message_type'] = "success";
        header("location: ../index.php");
        exit();
    } else {
        $_SESSION['message'] = "Incorrect username or password";
        $_SESSION['message_type'] = "danger";
        header("location: ../login.php");
        exit();
    }
}
?>