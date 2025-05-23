<?php
session_start();
include('../includes/db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['customer_id'])) {
        $customer_id = $_POST['customer_id'];

        $sql = "DELETE FROM customers WHERE id = $customer_id";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $_SESSION['message'] = "Customer deleted successfully!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Failed to delete customer!";
            $_SESSION['message_type'] = "danger";
        }
        header('location: ../customers.php');
        exit();
    }
}
?>