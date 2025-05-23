<?php
session_start();
include("../includes/db_connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM employees WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Record deleted successfully.";
        $_SESSION['message_type'] = "success";
        header("location: ../salaries.php");
        exit();
    } else {
        $_SESSION['message'] = "Error: " . $stmt->error;
        $_SESSION['message_type'] = "danger";
        header("location: ../salaries.php");
        exit();
    }
    $stmt->close();
}
?>