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
                <div style="border: solid 1px rgba(255,255,255,0.5);box-shadow:0px 0px 10px rgba(0,0,0,0.5);position:relative;" class="round d-flex">
                <div style="overflow:hidden;" class="round d-flex">
                    <div style="
                        position:absolute;
                        left:-25px; top:50%;
                        transform:translateY(-50%);
                        border-radius:50%;
                        width:50px; height:50px;
                        background:#005070;
                        color:#aaffff;
                        text-align:center;
                        line-height:45px;
                        border:solid 1px currentColor;
                        font-weight:bold;" class="shine">؋</div>
                    <div class="text-bg-dark px-5 py-1" style="font-weight:900;color:#aaffff !important;">
                        <?php echo number_format(htmlspecialchars($customer['loan'])); ?>
                    </div>
                </div> 
                </div>
            </div>
            <div class="col-3 d-flex align-items-center">
                <div class="card text-bg-dark-glass text-white shadow w-100">
                    <h4 class="text-bg-dark-glass text-center py-2">Repay money</h4>
                    <div class="card-body">
                        <form method="POST" action="helpers/customer_details_repay.php" class="flex-column">
                            <div class="mb-3">
                                <input type="number" step="0.01" class="form-control tbox text-bg-dark-glass" name="repayment_amount" required autocomplete="off" placeholder="Amount">
                                <input type="hidden" name="customer_id" value="<?= $customer_id ?>">
                            </div>
                            <div class="mb-3"> 
                                <button type="submit" class="btn btn-success w-100">Repay</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-3 offset-1 d-flex align-items-center">
                <div class="card text-bg-dark-glass text-white shadow w-100">
                    <h4 class="text-bg-dark-glass text-center py-2">Lend money</h4>
                    <div class="card-body">
                        <form method="POST" action="helpers/customer_details_lend.php" class="flex-column">
                            <div class="mb-3">
                                <input type="number" step="0.01" class="form-control tbox text-bg-dark-glass" name="amount" required autocomplete="off" placeholder="Amount">
                                <input type="hidden" name="customer_id" value="<?= $customer_id ?>">
                            </div>
                            <div class="mb-3"> 
                                <button type="submit" class="btn btn-danger w-100">Lend</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row text-bg-dark w-100">
            <div class="col-2 offset-2">
                <h5 style="line-height: 50px;">
                    <i class="bi bi-telephone-fill text-primary"></i>
                    <?php 
                        $phone = $customer['phone_number'];
                        echo htmlspecialchars(substr($phone, 0, 4) . ' ' . substr($phone, 4, 3) . ' ' . substr($phone, 7));
                    ?>
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
                            <th>Amount</th>
                            <th>Repay / Lend</th>
                            <th>Date</th>
                            <th>User</th>
                        </tr>
                        <?php 
                        // Get the logs of the customer from the customer_loans_log table
                        $stmt = $conn->prepare("SELECT * FROM customer_loans_log WHERE customer_id = ? ORDER BY created_at DESC");
                        $stmt->bind_param("i", $customer_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            while($loan = $result->fetch_assoc()) {
                                echo "<tr>";
                                    echo "<td>" . htmlspecialchars($loan['id']) . "</td>";
                                    echo "<td class='afnnum'>" . number_format($loan['amount']) . "</td>";
                                    echo "<td class='text-" . ($loan['repay_lend'] === 'repay' ? 'success' : 'danger') . "' style='font-weight: 900;'>" 
                                        . htmlspecialchars($loan['repay_lend']) 
                                        . "</td>";
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