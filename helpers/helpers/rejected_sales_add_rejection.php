<?php
session_start();
include("../includes/db_connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Variables to be stored in the rejected_sales table:
    $sale_id = $_POST['sale_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $restock_quantity = $_POST['restock_quantity'];
    $resell_quantity = $_POST['resell_quantity'];
    $resell_price = $_POST['resell_price'];
    #region $sold_date
    $stmt_sold_date = $conn->prepare("SELECT sale_date FROM sales WHERE id = ? LIMIT 1");

    if (!$stmt_sold_date) {
        die('Prepare failed: ' . $conn->error);
    }

    $stmt_sold_date->bind_param("i", $sale_id);
    $stmt_sold_date->execute();

    $result = $stmt_sold_date->get_result();
    $sold_date = ($result->num_rows > 0) ? $result->fetch_assoc()['sale_date'] : null;
    #endregion
    #region get the dollar rate
    // Fetch the latest dollar rate from the currency table
    $dollar_rate_stmt = $conn->prepare("SELECT rate, id FROM currency ORDER BY date DESC LIMIT 1");
    $dollar_rate_stmt->execute();
    $dollar_rate_result = $dollar_rate_stmt->get_result();

    if ($dollar_rate_result->num_rows > 0) {
        $dollar_data = $dollar_rate_result->fetch_assoc();
        $dollar_rate = $dollar_data['rate'];
        $dollar_rate_id = $dollar_data['id'];
    } else {
        $dollar_rate = 1; // Default to 1 if no rate is found
        $dollar_rate_id = null;
    }
    #endregion
    #region loss_per_item
    $stmt_loss_per_item = $conn->prepare("SELECT current_price FROM products WHERE id = ? LIMIT 1");

    if (!$stmt_loss_per_item) {
        die('Prepare failed: ' . $conn->error);
    }

    $stmt_loss_per_item->bind_param("i", $product_id);
    $stmt_loss_per_item->execute();

    $result = $stmt_loss_per_item->get_result();
    $loss_per_item_current_price = ($result->num_rows > 0) ? $result->fetch_assoc()['current_price'] : null;
    $loss_per_item = $loss_per_item_current_price - ($resell_price / $dollar_rate);
    #endregion
    
    // check if restock + resell quantity is more than rejected quantity
    if ($restock_quantity + $resell_quantity > $quantity) {
        $_SESSION['message'] = "Restock + Resell quantity cannot exceed rejected quantity!";
        $_SESSION['message_type'] = "danger";
    } else {
        #region Insert into rejected_sales
        $insert_stmt = $conn->prepare("
            INSERT INTO rejected_sales 
            (sale_id, product_id, quantity, restock_quantity, resell_quantity, resell_price, loss_per_item, sold_date, currency_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $insert_stmt->bind_param("iiiiiddsi", $sale_id, $product_id, $quantity, $restock_quantity, $resell_quantity, $resell_price, $loss_per_item, $sold_date, $dollar_rate_id);
        if ($insert_stmt->execute()) {
            #region Update rejected_quantity in sale_items tabble
            $update_stmt = $conn->prepare("
                UPDATE sale_items 
                SET rejected_quantity = rejected_quantity + ? 
                WHERE sale_id = ? AND product_id = ?
            ");
            $update_stmt->bind_param("iii", $quantity, $sale_id, $product_id);
            if ($update_stmt->execute()) {
                #region update the stock in the products table
                $updateProductsStmt = $conn->prepare("UPDATE products SET stock = stock + ? WHERE id = ?");
                $updateProductsStmt->bind_param("ii", $restock_quantity, $product_id);
                if ($updateProductsStmt->execute()) {
                    $_SESSION['message'] = "Rejection added successfully!";
                    $_SESSION['message_type'] = "success";
                } else {
                    $_SESSION['message'] = "Field to update products table " . $updateProductsStmt->error;
                    $_SESSION['message_type'] = "danger";
                }
                $updateProductsStmt->close();
                #endregion
            } else {
                $_SESSION['message'] = "Error updating sale items: " . $update_stmt->error;
                $_SESSION['message_type'] = "danger";
            }
            $update_stmt->close();
            #endregion
        } else {
            $_SESSION['message'] = "Error inserting into rejected_sales: " . $insert_stmt->error;
            $_SESSION['message_type'] = "danger";
        }
        $insert_stmt->close();
        #endregion
    }
    header("location: ../rejected_sales.php");
    exit();
}
?>