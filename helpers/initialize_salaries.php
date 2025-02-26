<?php
include '../includes/db_connect.php';

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1); // Enable error display

$date = date("Y-m-01");

// Check if salaries already exist for this month
$checkQuery = "SELECT COUNT(*) AS count FROM salaries WHERE month = '$date'";
$result = mysqli_query($conn, $checkQuery);

if (!$result) {
    echo json_encode(["success" => false, "message" => "SQL Error: " . mysqli_error($conn)]);
    exit;
}

$row = mysqli_fetch_assoc($result);

if ($row['count'] > 0) {
    echo json_encode(["success" => false, "message" => "Salaries are already initialized for this month."]);
    exit;
}

// Insert missing salary records
$insertQuery = "INSERT INTO salaries (employee_id, month, amount_paid)
                SELECT e.id, '$date', 0
                FROM employees e
                WHERE NOT EXISTS (
                    SELECT 1 FROM salaries s
                    WHERE s.employee_id = e.id
                    AND s.month = DATE_FORMAT(NOW(), '%Y-%m')
                )";

if (mysqli_query($conn, $insertQuery)) {
    echo json_encode(["success" => true, "message" => "Salaries initialized successfully!"]);
} else {
    echo json_encode(["success" => false, "message" => "SQL Error: " . mysqli_error($conn)]);
}
?>