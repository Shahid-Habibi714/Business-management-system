<?php
session_start();
include("../includes/db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $description = $_POST["description"];
    $amount = $_POST["amount"];
    $month = date("Y-m");

    $insert_stmt = $conn->prepare("INSERT INTO monthly_expenses (description, amount, date) VALUES (?, ?, ?)");
    $insert_stmt->bind_param("sds", $description, $amount, $month);
    if ($insert_stmt->execute()) {
        // calculate the profits and losses
        // calling calculateDailyProfit will then call the calculateMonthlyExpenses as well
        require_once("sales_calculate_daily_profit.php");
        calculateDailyProfit($conn);

        $_SESSION['message'] = "Expense added successfully!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Field to add expense. Error: " . $insert_stmt->error;
        $_SESSION['message_type'] = "danger";
    }
    header("location: ../expenses.php");
    exit();
}
?>