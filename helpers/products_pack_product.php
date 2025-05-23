<?php
session_start();
include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product1 = intval($_POST['product_id_1']);
    $product1_price = $conn->query("SELECT current_price FROM products WHERE id = $product1")->fetch_assoc()['current_price'];
    $product2 = intval($_POST['product_id_2']);
    $product2_price = $conn->query("SELECT current_price FROM products WHERE id = $product2")->fetch_assoc()['current_price'];
    $final_product = intval($_POST['id']);
    $final_product_price = $product1_price + $product2_price;
    $amount = intval($_POST['amount']);
    $message = ($_POST['message'] != "") ? $_POST['message'] : $amount . " were packed.";
    
    if ($amount <= 0) {
        $_SESSION['message'] = "Invalid amount";
        $_SESSION['message_type'] = "danger";
    }
    $conn->begin_transaction(); // Start a transaction
    
    try {
        // Reduce stock for product1
        $query1 = $conn->prepare("UPDATE products SET stock = stock - ? WHERE id = ? AND stock >= ?");
        $query1->bind_param("iii", $amount, $product1, $amount);
        $query1->execute();
        if ($query1->affected_rows == 0) {
            $_SESSION['message'] = "Not enough stock for Product 1";
            $_SESSION['message_type'] = "danger";
        } else {
            // Reduce stock for product2
            $query2 = $conn->prepare("UPDATE products SET stock = stock - ? WHERE id = ? AND stock >= ?");
            $query2->bind_param("iii", $amount, $product2, $amount);
            $query2->execute();
            if ($query2->affected_rows == 0) {
                $_SESSION['message'] = "Not enough stock for Product 2";
                $_SESSION['message_type'] = "danger";
            } else {
                // Increase stock for final product
                $query3 = $conn->prepare("UPDATE products SET stock = stock + ?, current_price = ? WHERE id = ?");
                $query3->bind_param("idi", $amount, $final_product_price ,$final_product);
                $query3->execute();
                if ($query3->affected_rows == 0) {
                    $_SESSION['message'] = "Error updating final product";
                    $_SESSION['message_type'] = "danger";
                } else {
                    #region log it in the accessories_log table
                    $total_price = $final_product_price * $amount;
                    $logStmt = $conn->prepare("INSERT INTO accessories_log (product_id, amount, total_price, message) VALUES (?, ?, ?, ?)");
                    $logStmt->bind_param("iids", $final_product, $amount, $total_price, $message);
                    $logStmt->execute();
                    #endregion
            
                    $conn->commit(); // Commit transaction
                
                    $_SESSION['message'] = "Stock updated successfully";
                    $_SESSION['message_type'] = "success";
                }
            }
        }
    
    
    } catch (Exception $e) {
        $conn->rollback(); // Rollback on failure
        $_SESSION['message'] = "error" . $e->getMessage();
        $_SESSION['message_type'] = "danger";
    }
    header("location: ../products.php");
    exit();
}
?>