<?php

// this file is used by rejected_sales.php


include('../includes/db_connect.php');

// Check if sale_id and product_id are provided
if (isset($_GET['sale_id']) && isset($_GET['product_id'])) {
    $sale_id = $_GET['sale_id'];
    $product_id = $_GET['product_id'];

    // Prepare the SQL query to fetch the sold quantity and rejected quantity for the specific product in the given sale
    $query = "
            SELECT 
            SUM(si.quantity) AS sold_quantity, 
            SUM(si.rejected_quantity) AS rejected_quantity
            FROM sale_items si
            WHERE si.sale_id = ? AND si.product_id = ?
        ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $sale_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the sold quantity and rejected quantity
    $data = $result->fetch_assoc();
    $sold_quantity = $data['sold_quantity'] ? $data['sold_quantity'] : 0;
    $rejected_quantity = $data['rejected_quantity'] ? $data['rejected_quantity'] : 0;

    // Calculate the remaining rejected quantity
    $remaining_rejected_quantity = $sold_quantity - $rejected_quantity;

    // Return the remaining rejected quantity as JSON
    echo json_encode(['remaining_rejected_quantity' => $remaining_rejected_quantity]);

    $stmt->close();
}
?>
