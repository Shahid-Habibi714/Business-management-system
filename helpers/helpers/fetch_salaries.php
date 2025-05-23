<?php
include '../includes/db_connect.php';

// Fetch the salaries
function getSalaries($conn) {
    $date = date("Y-m-01");
    $query = "SELECT e.id, e.employee_name, e.salary, s.amount_paid, 
                     (e.salary - s.amount_paid) AS amount_remaining
              FROM salaries s
              JOIN employees e ON s.employee_id = e.id
              WHERE s.month = '$date'";
    $result = mysqli_query($conn, $query);
    
    $salaries = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $salaries[] = $row;
    }
    return $salaries;
}

$salaries = getSalaries($conn);

header('Content-Type: application/json');
echo json_encode($salaries);

?>