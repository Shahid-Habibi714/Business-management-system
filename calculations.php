<?php
include('includes/db_connect.php');

// Set the dollar rate
if (isset($_POST['rate'])) {
    $rate = $_POST['rate'];
    $today = date('Y-m-d');
    $add_rate = mysqli_query($conn, "INSERT INTO currency (rate, date) VALUES ('$rate', '$today')");
    if ($add_rate) {
        echo "<div class='alert alert-success' role='alert'>";
        echo "Today's dollar rate has been added successfully. Redirecting...";
        echo "<meta http-equiv='refresh' content='3;index.php'>";
        echo "</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>";
        echo "Failed to add today's dollar rate.";
        echo "</div>";
    }
}


// Calculate everything in dollar update the database
function calculate() {
    #region Get today's exchange rate
    $todays_rate_query = "SELECT rate FROM currency WHERE date = CURDATE()";
    $todays_rate_result = $conn->query($todays_rate_query);
    $todays_rate = ($todays_rate_result->num_rows > 0) ? $todays_rate_result->fetch_assoc()['rate'] : 1; // Default to 1 if no rate found
    #endregion

    // #region calculate loss
    // // Calculate today's total daily expenses
    // $todays_total_expenses_query = "SELECT SUM(amount) AS total FROM daily_expenses WHERE date = CURDATE()";
    // $todays_total_expenses = $conn->query($todays_total_expenses_query)->fetch_assoc()['total'] ?? 0;

    // // Calculate total shop expenses
    // $total_shop_expenses_query = "SELECT SUM(amount) AS total FROM shop_expenses WHERE date = CURDATE()";
    // $total_shop_expenses = $conn->query($total_shop_expenses_query)->fetch_assoc()['total'] ?? 0;

    // // Convert expenses to USD and store in total_loss
    // $total_loss = ($todays_total_expenses + $total_shop_expenses) / $todays_rate;
    // // Update the total_loss in currency table
    // $update_loss_query = "UPDATE currency SET total_loss = $total_loss WHERE date = CURDATE()";
    // $conn->query($update_loss_query);

    
    // // Update the capital history
    // $update_loss_query = "UPDATE capital_history SET total_loss = $total_loss WHERE date = CURDATE()";
    // $conn->query($update_loss_query);
    // #endregion    
    #region calculate profit
        // Initialize total profit for today
        $todays_total_profit = 0;

        // Get today's sales
        $todays_sales = $conn->query("SELECT id FROM sales WHERE date = CURDATE()");

        if ($todays_sales->num_rows > 0) {
            // Fetch product prices once and store them in an associative array
            $product_prices = [];
            $products_result = $conn->query("SELECT id, current_price FROM products");
            while ($product = $products_result->fetch_assoc()) {
                $product_prices[$product['id']] = $product['current_price']; // Purchase price in USD
            }

            while ($sale = $todays_sales->fetch_assoc()) {
                $sale_id = $sale['id'];
                $total_profit_for_sale = 0; // Initialize total profit for this sale

                // Get all sale items for the sale
                $sales_sale_items = $conn->query("SELECT id, product_id, quantity, total FROM sale_items WHERE sale_id = $sale_id");

                if ($sales_sale_items->num_rows > 0) {
                    while ($sale_item = $sales_sale_items->fetch_assoc()) {
                        $sale_item_id         = $sale_item['id'];
                        $sale_item_product_id = $sale_item['product_id'];
                        $sale_item_quantity   = $sale_item['quantity'];
                        $sale_item_total      = $sale_item['total']; // Total sale price in AFN

                        // Get the purchase price in USD
                        $purchase_price_usd = $product_prices[$sale_item_product_id] ?? 0;

                        // Convert sales total from AFN to USD
                        $sale_total_usd = $sale_item_total / $todays_rate;

                        // Calculate total profit in USD
                        $sale_item_total_profit = $sale_total_usd - ($sale_item_quantity * $purchase_price_usd);

                        // Update the total_profit for the sale_item in USD
                        $conn->query("UPDATE sale_items SET total_profit = $sale_item_total_profit WHERE id = $sale_item_id");

                        // Add to total profit for this sale
                        $total_profit_for_sale += $sale_item_total_profit;
                    }
                }
                // Update the total_profit column in the sales table for this sale
                $conn->query("UPDATE sales SET total_profit = $total_profit_for_sale WHERE id = $sale_id");

                // Add to today's total profit
                $todays_total_profit += $total_profit_for_sale;
            }
        } else {
            // No sales for today
        }
        // Ensure total_profit is updated in capital_history
        $check_existing = $conn->query("SELECT COUNT(*) as count FROM capital_history WHERE date = CURDATE()");
        $existing_record = $check_existing->fetch_assoc()['count'];
        if ($existing_record == 0) {
            $conn->query("INSERT INTO capital_history (date, total_profit) VALUES (CURDATE(), $todays_total_profit)");
        }
    #endregion




        






    // // Calculate total salaries for this month
    // $total_salaries_query = "SELECT SUM(salary) AS total FROM salaries WHERE MONTH(month) = MONTH(CURDATE()) AND YEAR(month) = YEAR(CURDATE())";
    // $total_salaries = $conn->query($total_salaries_query)->fetch_assoc()['total'] ?? 0;

    // // Subtract salaries from total sales profit
    // $total_profit_afn -= $total_salaries;

    // // Convert profit to USD
    // $total_profit = $total_profit_afn / $todays_rate;

    // // Update the capital history
    // $update_profit_query = "UPDATE capital_history SET total_profit = $total_profit WHERE date = CURDATE()";
    // $conn->query($update_profit_query);
}

?>