<?php
include '../includes/db_connect.php';

// Ensure content type is JSON
header('Content-Type: application/json');

if (isset($_POST['product1']) && isset($_POST['product2'])) {
    $product1 = intval($_POST['product1']);
    $product2 = intval($_POST['product2']);

    // Fetch quantities of both products
    $query = $conn->prepare("SELECT id, stock FROM products WHERE id IN (?, ?)");
    $query->bind_param("ii", $product1, $product2);
    $query->execute();
    $result = $query->get_result();

    $quantities = [];
    while ($row = $result->fetch_assoc()) {
        $quantities[$row['id']] = $row['stock'];
    }

    // Get the quantities, default to high if one is missing
    $quantity1 = isset($quantities[$product1]) ? $quantities[$product1] : PHP_INT_MAX;
    $quantity2 = isset($quantities[$product2]) ? $quantities[$product2] : PHP_INT_MAX;

    echo json_encode([
        "success" => true,
        "quantity1" => $quantity1,
        "quantity2" => $quantity2
    ]);
} else {
    echo json_encode(["success" => false]);
}
?>
