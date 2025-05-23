<?php
session_start();
include("../includes/db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST["amount"];
    $log = $conn->query("SELECT * FROM drawer_safe_log ORDER BY date DESC LIMIT 1")->fetch_assoc();
    $drawerCash = $log["drawer_cash"] ?? 0;
    $safeCash = $log["safe_cash"] ?? 0;
    $action = "";
    if (isset($_POST["toSafe"])) {
        if ($drawerCash < $amount) {
            $_SESSION["message"] = "Insufficient funds in drawer";
            $_SESSION['message_type'] = "danger";
            header("location: ../financial_insights.php");
            exit();
        }
        $drawerCash -= $amount;
        $safeCash += $amount;
        $action = "Safe";
    } else if (isset($_POST["deposit"])) {
        $drawerCash += $amount;
        $action = "drawerAdd";
    } else if (isset($_POST["withdraw"])) {
        if ($drawerCash < $amount) {
            $_SESSION["message"] = "Insufficient funds in drawer";
            $_SESSION['message_type'] = "danger";
            header("location: ../financial_insights.php");
            exit();
        }
        $drawerCash -= $amount;
        $action = "drawerSub";
    }
    $stmt = $conn->prepare("INSERT INTO drawer_safe_log (drawer_cash, safe_cash, amount, action, date) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("ddds", $drawerCash, $safeCash, $amount, $action);
    if ($stmt->execute()) {
        $_SESSION["message"] = "Transaction Successful";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION["message"] = "Transaction Failed";
        $_SESSION['message_type'] = "danger";
    }
    header("location: ../financial_insights.php");
    exit();
}
?>