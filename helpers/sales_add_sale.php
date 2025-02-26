<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("../includes/db_connect.php");

// Handle form submission for adding a new sale
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    #region fetch the latest dollar rate from the currency table
    // Fetch the latest dollar rate from the currency table
    $dollar_rate_stmt = $conn->prepare("SELECT rate, id FROM currency ORDER BY date DESC LIMIT 1");
    $dollar_rate_stmt->execute();
    $dollar_rate_result = $dollar_rate_stmt->get_result();

    if ($dollar_rate_result->num_rows > 0) {
        $dollar_data = $dollar_rate_result->fetch_assoc();
        $dollar_rate = $dollar_data['rate'];
        $dollar_rate_id = $dollar_data['id'];
    } else {
        $dollar_rate = 1; // Default to 1 if no rate is found
        $dollar_rate_id = null;
    }
    #endregion
    if ($_POST['type-of-customer'] == "permanent-customer") {
        $customer_id = $_POST['permanent_customer_name'];
        $loan_check = isset($_POST['loan-check']) ? 1 : 0;
        $customer_name_stmt = $conn->prepare("SELECT name FROM customers WHERE id = ?");
        $customer_name_stmt->bind_param("i", $customer_id);
        $customer_name_stmt->execute();
        $result = $customer_name_stmt->get_result();

        if ($result->num_rows > 0) {
            $customer_name = $result->fetch_assoc()['name'];
        }
    } else {
        $customer_id = null;
        $loan_check = 0;
        $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
    }
    $total_amount = 0;
    $total_sale_profit = 0;
    $user = $_SESSION['username'];
    $conn->begin_transaction();
    try {
        // Insert the sale into the sales table
        $stmt = $conn->prepare("INSERT INTO sales (customer_name, total_amount, total_profit, currency_id, username) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sidis", $customer_name, $total_amount, $total_sale_profit, $dollar_rate_id, $user);
        $stmt->execute();
        $sale_id = $stmt->insert_id; // Get the last inserted sale ID (insert_id is default property in PHP)
        
        if ($_POST['type-of-customer'] == "permanent-customer") {
            $stmt4 = $conn->prepare("INSERT INTO customer_loans (customer_id, sale_id) VALUES (?, ?)");
            $stmt4->bind_param("ii", $customer_id, $sale_id);
            $stmt4->execute();
        }

        // Insert each product into the sale_items table
        for ($i = 0; $i < count($_POST['product_id']); $i++) {
            $product_id = $_POST['product_id'][$i];
            $quantity = $_POST['quantity'][$i];
            $price = $_POST['price'][$i];
            $total = $quantity * $price;
            #region total_profit calculation
                $stmt1 = $conn->prepare("SELECT current_price FROM products WHERE id = ?");
                $stmt1->bind_param("i", $product_id);
                $stmt1->execute();
                $result1 = $stmt1->get_result();

                if ($result1->num_rows > 0) {
                    $current_price = $result1->fetch_assoc()['current_price'];
                    $price_in_dollar = $price / $dollar_rate;
                    $total_profit = ($price_in_dollar - $current_price) * $quantity;
                } else {
                    $total_profit = 0;
                }
            #endregion
            $stmt2 = $conn->prepare("INSERT INTO sale_items (sale_id, product_id, quantity, price, total_profit) VALUES (?, ?, ?, ?, ?)");
            $stmt2->bind_param("iiidd", $sale_id, $product_id, $quantity, $price, $total_profit);
            $stmt2->execute();
            
            #region record a transaction
            require_once("financial_insights_transaction.php");
            performTransaction($conn, "addSale", 0, "Sale added successfully with " . number_format($total_profit, 2) . " profit.", "");
            #endregion

            // Update product quantity in the products table
            $stmt3 = $conn->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
            $stmt3->bind_param("ii", $quantity, $product_id);
            $stmt3->execute();

            $total_amount += $total;
            $total_sale_profit += $total_profit;
        }

        // require_once("../includes/header.php");
        $conn->commit();
        
        // Update the total_amount and total_profit in the sales table
        $stmt3 = $conn->prepare("UPDATE sales SET total_amount = ?, total_profit = ? WHERE id = ?");
        $stmt3->bind_param("ddi", $total_amount, $total_sale_profit, $sale_id);
        $stmt3->execute();

        #region If the sale is marked as loan
        if ($loan_check) {
            // update the customer's total loan amount in the customers table
            $stmt5 = $conn->prepare("UPDATE customers SET loan = loan + ? WHERE id = ?");
            $stmt5->bind_param("di", $total_amount, $customer_id);
            $stmt5->execute();

            // mark the bill as loan in the sales table
            $stmt6 = $conn->prepare("UPDATE sales SET is_loan = 1 WHERE id = ?");
            $stmt6->bind_param("i", $sale_id);
            $stmt6->execute();
        }
        #endregion
        
        // calculate the profits and losses
        require_once("sales_calculate_daily_profit.php");
        calculateDailyProfit($conn);

        // Redirect to the print bill page
        echo "
        <!DOCTYPE html>
        <html> <body> </body> </html>
        <script>
            var myLink = document.createElement('a');
            myLink.href = '../print_bill.php?sale_id=$sale_id';
            myLink.target = '_blank';
            document.body.appendChild(myLink); // Append the link to the body (necessary for some browsers)
            myLink.click();
            document.body.removeChild(myLink); // Clean up by removing the link
            window.location.href = '../sales.php';
        </script>";

    } catch (Exception $e) {
        $conn->rollback();
        echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}
?>