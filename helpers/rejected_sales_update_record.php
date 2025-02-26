<?php
session_start();
include('../includes/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Typecast to ensure proper types
    $id = (int) $_POST['id'];
    $sale_id = (int) $_POST['sale_id'];
    $product_id = (int) $_POST['product_id'];
    $previous_restocked_quantity = (int) $_POST['previous_restocked_quantity'];
    $rejected_quantity = (int) $_POST['rejected_quantity'];
    $restock_quantity = (int) $_POST['restock_quantity'];
    $resell_quantity = (int) $_POST['resell_quantity'];
    $resell_price = (float) $_POST['resell_price'];
    $newStockQuantity = $restock_quantity - $previous_restocked_quantity;
    $currencyId = (int) $_POST['rejected_currency_id'];
    #region get the dollar rate
        // Fetch the latest dollar rate from the currency table
        $dollar_rate_stmt = $conn->prepare("SELECT rate FROM currency WHERE id = $currencyId");
        $dollar_rate_stmt->execute();
        $dollar_rate_result = $dollar_rate_stmt->get_result();

        if ($dollar_rate_result->num_rows > 0) {
            $dollar_data = $dollar_rate_result->fetch_assoc();
            $dollar_rate = $dollar_data['rate'];
        } else {
            $dollar_rate = 1; // Default to 1 if no rate is found
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

    // Validate quantities
    if ($restock_quantity + $resell_quantity > $rejected_quantity) {
        $_SESSION['message'] = "Restock + Resell quantity cannot exceed rejected quantity!";
        $_SESSION['message_type'] = "danger";
    } else {
        // Update rejected_sales table
        $query = "UPDATE rejected_sales
        SET restock_quantity = ?, resell_quantity = ?, resell_price = ?, loss_per_item = ?
        WHERE id = ? AND sale_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('iiddii', $restock_quantity, $resell_quantity, $resell_price, $loss_per_item, $id, $sale_id);
        if ($stmt->execute()) {
            // Example: Update stock in the related products table
            $updateStockQuery = "UPDATE products
                        SET stock = stock + ?
                        WHERE id = ?";
            $stockStmt = $conn->prepare($updateStockQuery);
            $stockStmt->bind_param('ii', $newStockQuantity, $product_id);
            $stockStmt->execute();
            $stockStmt->close();
            $_SESSION['message'] = "Rejection updated successfully!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Field to update the rejection. Error: " . $stmt->error;
            $_SESSION['message_type'] = "danger";
        }
        $stmt->close();
    }
    header("location: ../rejected_sales.php");
    exit();
}
?>
