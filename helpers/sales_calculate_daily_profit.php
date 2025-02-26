<?php

function calculateDailyProfit($conn) {
    $date = date('Y-m-d'); // Get today's date

    // Get total sales profit for today
    $profitQuery = $conn->query("SELECT SUM(total_profit) AS gross_profit FROM sales WHERE DATE(sale_date) = '$date'");
    $profitResult = $profitQuery->fetch_assoc();
    $gross_profit = $profitResult['gross_profit'] ?? 0;
    
    // Get today's expenses
    $expenseQuery = $conn->query("SELECT SUM(amount) AS total_expenses FROM daily_expenses WHERE DATE(date) = '$date'");
    $expenseResult = $expenseQuery->fetch_assoc();
    $daily_expenses = $expenseResult['total_expenses'] ?? 0;
    
    // get used accessories
    $accessoriesQuery = $conn->query("SELECT SUM(total_price) AS total_price FROM accessories_log WHERE DATE(date) = CURDATE()");
    $accessoriesResult = $accessoriesQuery->fetch_assoc();
    $accessories_price = $accessoriesResult['total_price'] ?? 0;

    // get the dollar rate
    $dollarRateQuery = $conn->query("SELECT rate FROM currency ORDER BY date DESC LIMIT 1");
    $dollarRateResult = $dollarRateQuery->fetch_assoc();
    $dollar_rate = $dollarRateResult['rate'] ?? 1; // Default to 1 if no rate is found
    
    // Calculate net profit in dollar
    $daily_expenses_in_usd = $daily_expenses / $dollar_rate;
    $loss = $daily_expenses_in_usd + $accessories_price;
    $net_profit = $gross_profit - $loss;
    
    // Insert or update today's net profit
    $conn->query("INSERT INTO profits (date, gross_profit, loss, net_profit)
    VALUES ('$date', '$gross_profit', '$loss', '$net_profit')
    ON DUPLICATE KEY UPDATE 
    gross_profit = VALUES(gross_profit),
    loss = VALUES(loss),
    net_profit = VALUES(net_profit)");

    calculateMonthlyProfit($conn);
}

function calculateMonthlyProfit($conn) {
    $month = date('Y-m'); // Format: YYYY-MM (e.g. 2025-02)
    $total_net_profit = $conn->query("SELECT SUM(net_profit) AS total_net_profit FROM profits WHERE DATE_FORMAT(date, '%Y-%m') = '$month'")->fetch_assoc()['total_net_profit'];

    // Get the dollar rate
    $dollarRateQuery = $conn->query("SELECT rate FROM currency ORDER BY date DESC LIMIT 1");
    $dollarRateResult = $dollarRateQuery->fetch_assoc();
    $dollar_rate = $dollarRateResult['rate'] ?? 1; // Default to 1 if no rate is found

    // get the salaries
    $salaries = $conn->query("SELECT SUM(amount_paid) AS amount_paid FROM salaries WHERE month = '$month'")->fetch_assoc()['amount_paid'];
    $salaries_in_usd = $salaries / $dollar_rate;
    
    // get the monthly expenses
    $expenses = $conn->query("SELECT SUM(amount) AS amount FROM monthly_expenses WHERE date = '$month'")->fetch_assoc()['amount'];
    $expenses_in_usd = $expenses / $dollar_rate;
    
    // calculate loss
    $monthly_loss = $salaries_in_usd + $expenses_in_usd;

    // calculate monthly net profit
    $monthly_net_profit = $total_net_profit - $monthly_loss;

    // Insert or update this month's net profit
    $conn->query("INSERT INTO monthly_profits (month, total_net_profit, monthly_loss, monthly_net_profit)
    VALUES ('$month', '$total_net_profit', '$monthly_loss', '$monthly_net_profit')
    ON DUPLICATE KEY UPDATE 
    total_net_profit = VALUES(total_net_profit),
    monthly_loss = VALUES(monthly_loss),
    monthly_net_profit = VALUES(monthly_net_profit)");

    calculateAnnualProfit($conn);
}

function calculateAnnualProfit($conn) {
    $year = date('Y'); // Format: YYYY (e.g. 2025)
    $total_net_profit = $conn->query("SELECT SUM(monthly_net_profit) AS total_net_profit 
                                    FROM monthly_profits 
                                    WHERE LEFT(month, 4) = '$year'")
                    ->fetch_assoc()['total_net_profit'];

    // Get the dollar rate
    $dollarRateQuery = $conn->query("SELECT rate FROM currency ORDER BY date DESC LIMIT 1");
    $dollarRateResult = $dollarRateQuery->fetch_assoc();
    $dollar_rate = $dollarRateResult['rate'] ?? 1; // Default to 1 if no rate is found
    
    // get the annual expenses
    $expenses = $conn->query("SELECT SUM(amount) AS amount FROM annual_expenses WHERE date = '$year'")->fetch_assoc()['amount'];
    $expenses_in_usd = $expenses / $dollar_rate;
    
    // calculate loss
    $annual_loss = $expenses_in_usd;

    // calculate monthly net profit
    $annual_net_profit = $total_net_profit - $annual_loss;

    // Insert or update this month's net profit
    $conn->query("INSERT INTO annual_profits (year, total_net_profit, annual_loss, annual_net_profit)
    VALUES ('$year', '$total_net_profit', '$annual_loss', '$annual_net_profit')
    ON DUPLICATE KEY UPDATE 
    total_net_profit = VALUES(total_net_profit),
    annual_loss = VALUES(annual_loss),
    annual_net_profit = VALUES(annual_net_profit)");
}
?>