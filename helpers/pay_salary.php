<?php
include '../includes/db_connect.php';

header('Content-Type: application/json'); // Set the content-type to JSON

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if database connection is successful
if (!$conn) {
    die(json_encode(["status" => "error", "message" => "Database connection failed."]));
}

// Function to pay salary
function paySalary($conn, $employee_id, $amount) {
    $date = date("Y-m-01");

    // Check if the salary can be paid
    $query = "SELECT e.salary, s.amount_paid 
                FROM salaries s
                JOIN employees e ON s.employee_id = e.id
                WHERE s.employee_id = $employee_id
                AND s.month = '$date'";
    $stmt = $conn->query($query);
    $result = $stmt->fetch_assoc();
    $salary = $result['salary'];
    $amount_paid = $result['amount_paid'];

    //Check if salary plus amount exceeds the actual salary
    if (($amount_paid + $amount) > $salary) {
        echo json_encode(["status" => "error", "message" => "Salary payment exceeds the total salary."]);
        exit;  // Ensures no further output is generated
    }

    // Update the salary by adding the payment
    $updateQuery = "UPDATE salaries 
                    SET amount_paid = amount_paid + ? 
                    WHERE employee_id = ? 
                    AND month = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("dis", $amount, $employee_id, $date);
    if ($updateStmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Salary paid successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error processing salary payment."]);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure necessary data is passed
    if (isset($_POST["employee_id"]) && isset($_POST["amount"])) {
        $employee_id = $_POST["employee_id"];
        $amount = $_POST["amount"];
        // Call the function to pay salary
        paySalary($conn, $employee_id, $amount);
    } else {
        echo json_encode(["status" => "error", "message" => "Missing employee ID or amount."]);
    }
}
?>