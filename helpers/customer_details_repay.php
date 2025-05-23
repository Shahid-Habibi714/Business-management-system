<?php
session_start();
include('../includes/db_connect.php');

#region handle loan repayment
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $repayment_amount = $_POST['repayment_amount'];
    $customer_id = $_POST['customer_id'];
    $user = $_SESSION['username'];
    // update the customers table
    $conn->query("UPDATE customers SET loan = loan - $repayment_amount WHERE id = $customer_id");
    // update the customers_loan_log
    $conn->query("INSERT INTO customer_loans_log (customer_id, amount, repay_lend, username) VALUES ($customer_id, $repayment_amount, 'repay', '$user')");
    // add money to drawer
    $dollar_rate = $conn->query("SELECT rate FROM currency ORDER BY date DESC LIMIT 1")->fetch_assoc()['rate'];
    $amount_in_usd = $repayment_amount / $dollar_rate;
    $conn->query("
        UPDATE drawer_safe_log 
        SET drawer_cash = drawer_cash + $amount_in_usd 
        WHERE date = (SELECT MAX(date) FROM drawer_safe_log)
    ");

    $_SESSION['message'] = "Loan updated successfully!";
    $_SESSION['message_type'] = "success";
    header("location: ../customer_details.php?id=$customer_id");
    exit();
}
#endregion
?>