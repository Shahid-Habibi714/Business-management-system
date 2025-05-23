<?php
include '../includes/db_connect.php';

header('Content-Type: application/json'); // Set the content-type to JSON

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if database connection is successful
if (!$conn) {
    die(json_encode(["status" => "error", "message" => "Database connection failed."]));
}

// Function to pay salary for a specific month
function paySalary($conn, $employee_id, $amount, $month) {
    // Validate month format (YYYY-MM)
    if (!preg_match("/^\d{4}-\d{2}$/", $month)) {
        echo json_encode(["status" => "error", "message" => "Invalid month format."]);
        exit;
    }

    $date = $month . "-01";

    // Check if the salary can be paid
    $query = "SELECT e.salary, s.amount_paid 
              FROM salaries s
              JOIN employees e ON s.employee_id = e.id
              WHERE s.employee_id = $employee_id
              AND s.month = '$date'";
    $stmt = $conn->query($query);

    if (!$stmt || $stmt->num_rows === 0) {
        echo json_encode(["status" => "error", "message" => "Salary record not found for the selected month."]);
        exit;
    }

    $result = $stmt->fetch_assoc();
    $salary = $result['salary'];
    $amount_paid = $result['amount_paid'];

    // Check if salary plus amount exceeds the actual salary
    if (($amount_paid + $amount) > $salary) {
        echo json_encode(["status" => "error", "message" => "Salary payment exceeds the total salary."]);
        exit;
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

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["employee_id"], $_POST["amount"], $_POST["month"])) {
        $employee_id = $_POST["employee_id"];
        $amount = $_POST["amount"];
        $month = $_POST["month"];
        paySalary($conn, $employee_id, $amount, $month);
    } else {
        echo json_encode(["status" => "error", "message" => "Missing employee ID, amount, or month."]);
    }
}
?>
