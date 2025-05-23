<?php
session_start();
include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['amount'])) {
    $id = (int) $_POST['id']; // Ensure ID is an integer
    $amount = (float) $_POST['amount']; // Ensure amount is a valid number
    $currentMonth = date('Y-m');

    #region Get the salary from employees table
    $employeeSalary = $conn->query("SELECT salary FROM employees WHERE id = $id")->fetch_assoc()['salary'];
    #endregion

    #region Get the amount paid from the salaries table
    $getAmountPaidStmt = $conn->prepare("SELECT amount_paid FROM salaries WHERE employee_id = ? AND month = ?");
    $getAmountPaidStmt->bind_param("is", $id, $currentMonth);
    $getAmountPaidStmt->execute();
    $getAmountPaidResult = $getAmountPaidStmt->get_result()->fetch_assoc() ?: [];
    $amount_paid = $getAmountPaidResult['amount_paid'] ?? 0; // Default to 0 if null
    #endregion

    #region Get the current dollar rate
    $getRateStmt = $conn->prepare("SELECT id FROM currency ORDER BY date DESC LIMIT 1");
    $getRateStmt->execute();
    $rateResult = $getRateStmt->get_result()->fetch_assoc() ?: [];

    $dollar_rate = $rateResult['id'] ?? 1;
    #endregion

    if ($employeeSalary === null) {
        $_SESSION['message'] = "Employee not found.";
        $_SESSION['message_type'] = "danger";
    } elseif (($amount_paid + $amount) > $employeeSalary) {
        $_SESSION['message'] = "There's not sufficient balance in the account.\nAFN " . $amount_paid . " is already taken.\nAFN " . $employeeSalary - $amount_paid . " is remaining.";
        $_SESSION['message_type'] = "danger";
    } else {
        // Begin transaction to ensure data consistency
        $conn->begin_transaction();

        try {
            // Insert it in the salaries table, on duplicate update
            $insertSalaryStmt = $conn->prepare("INSERT INTO salaries (month, employee_id, salary, amount_paid) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE amount_paid = amount_paid + VALUES(amount_paid)");
            $insertSalaryStmt->bind_param("sidd", $currentMonth, $id, $employeeSalary, $amount);
            $insertSalaryStmt->execute();

            #region calculate the monthly profit
            // (calling calculateDailyProfit will call the calculateMonthlyProfit itself)
            require_once("sales_calculate_daily_profit.php");
            calculateDailyProfit($conn);
            #endregion

            // Log the salary payment
            $logStmt = $conn->prepare("INSERT INTO salary_log (employee_id, amount, dollar_rate) VALUES (?, ?, ?)");
            $logStmt->bind_param("idi", $id, $amount, $dollar_rate);
            $logStmt->execute();

            // Commit transaction
            $conn->commit();

            $_SESSION['message'] = "Amount paid successfully.";
            $_SESSION['message_type'] = "success";
        } catch (Exception $e) {
            $conn->rollback();
            $_SESSION['message'] = "Failed to update salary. Error: " . $e->getMessage();
            $_SESSION['message_type'] = "danger";
        }
    }

    header("location: ../salaries.php");
    exit();
}
?>