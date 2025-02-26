<?php
include('includes/db_connect.php');

// Check if sale_id is provided
if (isset($_GET['sale_id'])) {
    $sale_id = $_GET['sale_id'];

    // Prepare the SQL query to fetch products related to the sale_id
    $query = "
        SELECT p.id, p.name 
        FROM products p
        JOIN sale_items si ON p.id = si.product_id
        WHERE si.sale_id = ?
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $sale_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch all products for the selected sale_id
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    // Return products as JSON
    echo json_encode($products);

    $stmt->close();
}
?>
