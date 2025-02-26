<?php

// used by sales.php

include('../includes/db_connect.php');

// Check if sale_id and product_id are provided
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Prepare the SQL query to fetch the stock quantity from the products table
    $query = "
        SELECT stock FROM products WHERE id = ?
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the stock quantity
    $data = $result->fetch_assoc();
    $stock = $data['stock'] ? $data['stock'] : 0;

    // Return the stock quantity as JSON
    echo json_encode(['stock' => $stock]);

    $stmt->close();
}
?>
