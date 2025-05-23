<?php
session_start();
include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['dollar_rate'])) {
    $dollar_rate = $_POST['dollar_rate'];
    $date = date('Y-m-d H:i:s');
    $user = $_SESSION['username'];
    $insertStmt = $conn->prepare("INSERT INTO currency (rate, date, username) VALUES (?, ?, ?)");
    $insertStmt->bind_param("dss", $dollar_rate, $date, $user);
    if ($insertStmt->execute()) {
        $_SESSION['message'] = "Dollar rate updated successfully.";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Filed to update the dollar rate.";
        $_SESSION['message_type'] = "danger";
    }
    header("location: ../index.php");
    exit();
}
?>