<?php
include('includes/db_connect.php');

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

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
    
    #region loss_per_item
    $stmt_loss_per_item = $conn->prepare("SELECT current_price FROM products WHERE id = ? LIMIT 1");

    if (!$stmt_loss_per_item) {
        die('Prepare failed: ' . $conn->error);
    }

    $stmt_loss_per_item->bind_param("i", $product_id);
    $stmt_loss_per_item->execute();

    $result = $stmt_loss_per_item->get_result();
    $loss_per_item_current_price = ($result->num_rows > 0) ? $result->fetch_assoc()['current_price'] : null;
    $loss_per_item = $loss_per_item_current_price - $resell_price;
    #endregion

    // Validate quantities
    if ($restock_quantity + $resell_quantity > $rejected_quantity) {
        // Send the error message as a response
        $updatingError = "Restock + Resell quantity cannot exceed rejected quantity!";
        echo json_encode(array("updatingError" => $updatingError));
    } else {
        // Update rejected_sales table
        $query = "UPDATE rejected_sales
        SET restock_quantity = ?, resell_quantity = ?, resell_price = ?, loss_per_item = ?, total_loss = ?
        WHERE id = ? AND sale_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('iiiiiid', $restock_quantity, $resell_quantity, $resell_price, $loss_per_item, $total_loss, $id, $sale_id);
        if ($stmt->execute()) {
            // Example: Update stock in the related products table
            $updateStockQuery = "UPDATE products
                        SET stock = stock + ?
                        WHERE id = ?";
            $stockStmt = $conn->prepare($updateStockQuery);
            $stockStmt->bind_param('ii', $newStockQuantity, $product_id);
            $stockStmt->execute();
            $stockStmt->close();

            echo json_encode(array("updatingError" => ""));
        } else {
            echo json_encode(array("updatingError" => $stmt->error));
        }
        $stmt->close();
        $conn->close();
    }
}
?>
