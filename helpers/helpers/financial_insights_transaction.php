<?php
include_once("../includes/db_connect.php");

#region add/sub cash in bank
if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['depositCashInBank']) || isset($_POST['withdrawCashInBank']))) {
    session_start();
    $type = $_POST['type'];
    $amount = (float) $_POST['amount'];
    $message = ($type == "addCashInBank") ? $amount . " Cash added to bank\n" . $_POST['message'] : $amount . " Cash subtracted from bank\n" . $_POST['message'];
    performTransaction($conn, $type, $amount, $message, "../financial_insights.php");
}
#endregion

// calculate everything after a transaction
function performTransaction($conn, $type, $amount = 0, $mes, $headerLocation) {
    #region calculate all the products
    $total_products = 0;
    $products = $conn->query("SELECT * FROM products");
    while ($product = $products->fetch_assoc()) {
        $total_products += ($product['stock'] + $product['warehouse']) * $product['current_price'];
    }
    #endregion
    #region cash
    $cashStmt = $conn->query("SELECT * FROM drawer_safe_log ORDER BY date DESC LIMIT 1")->fetch_assoc();
    $cash = ($cashStmt['drawer_cash'] ?? 0) + ($cashStmt['safe_cash'] ?? 0);
    #endregion
    #region cash_in_banks
    $cash_in_banks = (float) $conn->query("SELECT cash_in_banks FROM transactions ORDER BY date DESC LIMIT 1")->fetch_assoc()['cash_in_banks'];
    #endregion
    
    $add_sub = "";
    
    if ($type == "addCashInBank") {
        $cash_in_banks += $amount;
        $add_sub = "add";
        #region log the cash in the cash_in_bank_log table
        $logStmt = $conn->prepare("INSERT INTO cash_in_bank_log (amount, add_sub, date) VALUES (?, ?, NOW())");
        $logStmt->bind_param("ds", $amount, $add_sub);
        $logStmt->execute();
        #endregion
    } elseif ($type == "subCashInBank") {
        $cash_in_banks -= $amount;
        $add_sub = "sub";
        #region log the cash in the cash_in_bank_log table
        $logStmt = $conn->prepare("INSERT INTO cash_in_bank_log (amount, add_sub, date) VALUES (?, ?, NOW())");
        $logStmt->bind_param("ds", $amount, $add_sub);
        $logStmt->execute();
        #endregion
    } elseif ($type == "addPurchase") {
        $add_sub = "add";
    }
    #region add the transaction to the transactions table
    $insertStmt = $conn->prepare("INSERT INTO transactions (total_products, cash, cash_in_banks, message, add_sub) VALUES (?, ?, ?, ?, ?)");
    $insertStmt->bind_param("dddss", $total_products, $cash, $cash_in_banks, $mes, $add_sub);
    if ($insertStmt->execute()) {
        $_SESSION['message'] = "Transaction performed successfully.";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Field to perform the transaction. Error: " . $insertStmt->error();
        $_SESSION['message_type'] = "danger";
    }
    #endregion
    if ($headerLocation != "") {
        header("location: " . $headerLocation);
        exit();
    }
}
?>