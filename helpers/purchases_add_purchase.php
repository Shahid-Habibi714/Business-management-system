<?php
session_start();
include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data for adding a new purchase
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    
    // Insert purchase record into the purchases table
    $stmt = $conn->prepare("INSERT INTO purchases (product_id, quantity, price) VALUES (?, ?, ?)");
    $stmt->bind_param("iid", $product_id, $quantity, $price);
    
    // Check if the purchase was added successfully
    if ($stmt->execute()) {
        #region calculate the new price for the product
        $current_product = $conn->query("SELECT * FROM products WHERE id = $product_id")->fetch_assoc();
        $current_quantity = (($current_product['warehouse']) ?? 0) + (($current_product['stock']) ?? 0);
        $current_price = ($current_product['current_price']) ?? 0;
        $new_price = (($current_price * $current_quantity) + ($price * $quantity)) / ($current_quantity + $quantity);
        #endregion
        // Update the warehouse, current_price, and last_purchase in the products table
        $stmt2 = $conn->prepare("
        UPDATE products
        SET warehouse = warehouse + ?, current_price = ?, last_purchase = NOW()
        WHERE id = ?
        ");
        $stmt2->bind_param("idi", $quantity, $new_price, $product_id);
        $stmt2->execute();
        #region record the transaction
        $product = ($conn->query("SELECT name FROM products WHERE id = $product_id")->fetch_assoc()['name']) ?? $product_id;
        require_once("financial_insights_transaction.php");
        performTransaction($conn, "addPurchase", 0, "Added new purchase. Product: " . $product . ", quantity: " . $quantity . ", price: " . $price, "");
        #endregion
        $_SESSION['message'] = "Purchase added successfully.";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Field to add purchase. Error: " . $stmt->error;
        $_SESSION['message_type'] = "danger";
    }
    $stmt->close();
    $stmt2->close();
    
    header("location: ../purchases.php");
    exit();
}
?>