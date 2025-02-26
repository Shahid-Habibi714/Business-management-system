<?php
#region include files
// Include the database connection file
include('includes/db_connect.php');
// Include the header file
include('includes/header.php');
#endregion

#region getting customer details
if(isset($_GET['id'])) {
    $customer_id = $_GET['id'];
    // Get the customer details from the customers table
    $stmt = $conn->prepare("SELECT * FROM customers WHERE id = ?");
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $customer = $result->fetch_assoc();
    $stmt->close();
}
#endregion
?>





<!-- #region body -->
    <div class="mb-auto">
        <div class="text-white w-100 row" style="height: 300px;background: linear-gradient(to top, #00264d, #0f5687);">
            <div class="col-4 d-flex flex-column align-items-center justify-content-center">
                <a class="btn btn-success align-self-start" href="customers.php" id="sidebarCustomers">
                    <i class="bi bi-arrow-left me-2"></i> back
                </a>
                <i class='bi bi-person-circle' style='font-size: 5em;'></i>
                <h1>
                    <?php echo htmlspecialchars($customer['name']); ?>
                </h1>
                <p>
                    Total Loan: <span class='afnnum'><?php echo number_format(htmlspecialchars($customer['loan']), 2); ?></span>
                </p>
            </div>
            <form class="row col-6 d-flex align-items-center" action="helpers/customer_details_update_loan.php" method="post">
                <div class="col-8">
                    <input type="number" name="repayment_amount" class="form-control tbox" step="0.01" placeholder="Amount" required>
                    <input type="hidden" name="customer_id" value="<?= $customer_id ?>">
                </div>
                <div class="col-4">
                    <input type="submit" class="btn btn-primary w-100" value="Repay">
                </div>
            </form>
        </div>
        <div class="row text-bg-dark w-100">
            <div class="col-2 offset-2">
                <h5 style="line-height: 50px;">
                    <i class="bi bi-telephone-fill text-primary"></i>
                    <?php echo htmlspecialchars($customer['phone_number']); ?>
                </h5>
            </div>
            <div class="col-6">
                <h5 style="line-height: 50px;">
                    <i class="bi bi-geo-alt-fill text-primary"></i>
                    <?php echo htmlspecialchars($customer['address']); ?>
                </h5>
            </div>
        </div>















    <!-- #tab layout -->
        <div class="container my-5">
            <!-- Tabs Navigation -->
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="loans-tab" data-bs-toggle="tab" data-bs-target="#loans" type="button" role="tab" aria-controls="loans" aria-selected="true">Bills</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="payments-tab" data-bs-toggle="tab" data-bs-target="#payments" type="button" role="tab" aria-controls="payments" aria-selected="false">Payments</button>
                </li>
            </ul>

            <!-- Tabs Content -->
            <div class="tab-content text-bg-dark rounded-3 p-3" id="myTabContent">
                <div class="tab-pane fade show active" id="loans" role="tabpanel" aria-labelledby="loans-tab">
                    <table class="table table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Bill ID</th>
                            <th>Amount</th>
                            <th>Loan / Cash </th>
                            <th>Date</th>
                            <th>Bill</th>
                        </tr>
                        <?php 
                        // Get the loans of the customer from the customer_loans table
                        $stmt = $conn->prepare("SELECT cl.*, s.total_amount, s.is_loan FROM customer_loans cl
                                                JOIN sales s ON sale_id = s.id
                                                WHERE customer_id = ?");
                        $stmt->bind_param("i", $customer_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            while($bill = $result->fetch_assoc()) {
                                $isLoan = ($bill['is_loan'] == 0) ? "Cash" : "Loan";
                                echo "<tr>";
                                echo "<td>" . number_format($bill['id']) . "</td>";
                                echo "<td>" . number_format($bill['sale_id']) . "</td>";
                                echo "<td class='afnnum'>" . number_format($bill['total_amount']) . "</td>";
                                echo "<td>" . $isLoan . "</td>";
                                echo "<td>" . htmlspecialchars($bill['created_at']) . "</td>";
                                echo "<td><a href='print_bill.php?sale_id=" . $bill['sale_id'] . "' target='_blank'><i class='bi bi-box-arrow-up-right fs-3 text-white'></i></a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No loans found</td></tr>";
                        }
                        ?>
                    </table>
                </div>
                <div class="tab-pane fade" id="payments" role="tabpanel" aria-labelledby="payments-tab">
                    <table class="table table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Repayed Amount</th>
                            <th>Date</th>
                            <th>User</th>
                        </tr>
                        <?php 
                        // Get the logs of the customer from the customer_loans_log table
                        $stmt = $conn->prepare("SELECT * FROM customer_loans_log WHERE customer_id = ?");
                        $stmt->bind_param("i", $customer_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            while($loan = $result->fetch_assoc()) {
                                echo "<tr>";
                                    echo "<td>" . htmlspecialchars($loan['id']) . "</td>";
                                    echo "<td>" . htmlspecialchars($loan['amount']) . "</td>";
                                    echo "<td>" . htmlspecialchars($loan['created_at']) . "</td>";
                                    echo "<td>" . htmlspecialchars($loan['username']) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No logs found</td></tr>";
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>

    <!-- #endregion -->











    </div>
<!-- #endregion -->





<!-- #region footer -->
    <?php
    // Include the footer file
    include('includes/footer.php');
    ?>

    <script>
    // Activate the sidebar link
    document.getElementById("sidebarCustomers").classList.add("active");
    </script>
<!-- #endregion -->