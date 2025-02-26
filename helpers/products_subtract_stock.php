<?php
session_start();
include_once("../includes/db_connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $amount = (int) $_POST['amount'];
    $message = $_POST['message'];
    
    $updateStmt = $conn->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
    $updateStmt->bind_param("ii", $amount, $id);
    if ($updateStmt->execute()) {
        #region calculate loss
        $product_rate = $conn->query("SELECT current_price FROM products WHERE id = $id")->fetch_assoc()['current_price'];
        $total_price = $amount * $product_rate;
        require_once("sales_calculate_daily_profit.php");
        calculateDailyProfit($conn);
        #endregion
        #region record a transaction
        $product_name = $conn->query("SELECT name FROM products WHERE id = $id")->fetch_assoc()['name'];
        require_once("financial_insights_transaction.php");
        performTransaction($conn, "subStock", 0, $amount . " " . $product_name . " has been used with $" . $total_price . " loss.", "");
        #endregion
        #region log it in the accessories_log table
        $logStmt = $conn->prepare("INSERT INTO accessories_log (product_id, amount, total_price, message) VALUES (?, ?, ?, ?)");
        $logStmt->bind_param("iids", $id, $amount, $total_price, $message);
        $logStmt->execute();
        #endregion
        $_SESSION['message'] = "Product stock subtracted successfully.";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Field to subtract stock. Error: " . $updateStmt->error();
        $_SESSION['message_type'] = "danger";
    }
    header("location: " . "../products.php");
    exit();   
}
?>