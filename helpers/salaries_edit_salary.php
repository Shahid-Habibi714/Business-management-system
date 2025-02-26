<?php
session_start();
include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['amount'])) {
    $id = (int) $_POST['id']; // Ensure ID is an integer
    $amount = (float) $_POST['amount']; // Ensure amount is a valid number
    $month = date("Y-m");
    // update the employee's salary
    try {
        $stmt = $conn->prepare("UPDATE employees SET salary = ? WHERE id = ?");
        $stmt->bind_param("di", $amount, $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            
            $salariesStmt = $conn->prepare("UPDATE salaries SET salary = ? WHERE employee_id = ? AND month = ?");
            $salariesStmt->bind_param("dis", $amount, $id, $month);
            $salariesStmt->execute();

            $_SESSION['message'] = "Salary updated successfully.";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "No changes made to the salary.";
            $_SESSION['message_type'] = "danger";
        }
        $stmt->close();
    } catch (Exception $e) {
        $_SESSION['message'] = "Failed to update salary. Error: " . $e->getMessage();
        $_SESSION['message_type'] = "danger";
    }

    header("location: ../salaries.php");
    exit();
}
?>