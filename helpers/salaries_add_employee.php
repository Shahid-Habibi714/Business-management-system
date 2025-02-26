<?php
session_start();
include("../includes/db_connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_name = $_POST['employee_name'];
    $salary = $_POST['salary'];

    $stmt = $conn->prepare("INSERT INTO employees (employee_name, salary) VALUES (?, ?)");
    $stmt->bind_param("ss", $employee_name, $salary);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Employee added successfully.";
        $_SESSION['message_type'] = "success";
        header("location: ../salaries.php");
        exit();
    } else {
        $_SESSION['message'] = "ERROR: Could not execute query: " . $stmt->error;
        $_SESSION['message_type'] = "danger";
        header("location: ../salaries.php");
        exit();
    }
    $stmt->close();
}
?>