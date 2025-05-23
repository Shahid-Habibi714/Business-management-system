<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("location: access_denied.php");
    exit();
}
#region include files
// Include the database connection file
include('includes/db_connect.php');
// Include the header file
include('includes/header.php');
#endregion
?>




<!-- #region body -->
<div class="mb-auto p-5">
    <h2 class="mb-5 d-flex justify-content-between align-items-center">Financial Insights
    <a href='transactions_history.php' class="fs-1 text-white"><i class="bi bi-bell-fill"></i></a>
    </h2>
    <div class="p-3 text-bg-dark">
    <?php
        $transactions = $conn->query("SELECT * FROM transactions ORDER BY DATE DESC LIMIT 1")->fetch_assoc();
        $products = 0;
        $productsStmt = $conn->query("SELECT * FROM products");
        while ($product = $productsStmt->fetch_assoc()) {
            $products += ($product['stock'] + $product['warehouse']) * $product['current_price'];
        }
        // $products = ($transactions['total_products']) ?? 0;
        $cashStmt = $conn->query("SELECT * FROM drawer_safe_log ORDER BY date DESC LIMIT 1")->fetch_assoc();
        $cash = (($cashStmt['drawer_cash']) ?? 0) + (($cashStmt['safe_cash']) ?? 0);
        // $cash = ($transactions['cash']) ?? 0;
        $cash_in_banks = ($transactions['cash_in_banks']) ?? 0;
        $total_profit = $conn->query("SELECT SUM(annual_net_profit) AS net_profit FROM annual_profits")->fetch_assoc()['net_profit'];
        $total_sales = ($conn->query("
            SELECT SUM(s.total_amount / c.rate) AS total_sales_in_dollar
            FROM sales s
            JOIN currency c ON s.currency_id = c.id
            WHERE s.is_loan = 0
        ")->fetch_assoc()['total_sales_in_dollar']) ?? 0;
        $capital = ($products + $cash + $cash_in_banks) ?? 0;
    ?>
    <h1 class='p-5 text-center'>
        <span class='fs-5'>Capital:</span>
        <br>
        <span class='usdnum' style='font-size: 60px;'><?php echo number_format($capital, 2); ?></span>
    </h1>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item col-3 text-center" role="presentation">
            <button class="nav-link w-100 rounded-top" id="totalProducts-tab" data-bs-toggle="tab" data-bs-target="#totalProducts" type="button" role="tab" aria-controls="totalProducts" aria-selected="true" disabled>
                <i class='bi bi-box-seam fs-1'></i><br>
                <strong>Total products:</strong>
                <h2><span class='usdnum'><?php echo number_format($products, 2); ?></span></h2>
            </button>
        </li>
        <li class="nav-item col-3 text-center" role="presentation">
            <button class="nav-link w-100 active rounded-top" id="cash-tab" data-bs-toggle="tab" data-bs-target="#cash" type="button" role="tab" aria-controls="cash" aria-selected="true">
                <i class='bi bi-cash-stack fs-1'></i><br>
                <strong>Total cash:</strong>
                <h2><span class='usdnum'><?php echo number_format($cash, 2); ?></span></h2>
            </button>
        </li>
        <li class="nav-item col-3 text-center" role="presentation">
            <button class="nav-link w-100 rounded-top" id="cashInBanks-tab" data-bs-toggle="tab" data-bs-target="#cashInBanks" type="button" role="tab" aria-controls="cashInBanks" aria-selected="true">
                <i class='bi bi-bank fs-1'></i><br>
                <strong>Total cash in banks:</strong>
                <h2><span class='usdnum'><?php echo number_format($cash_in_banks, 2); ?></span></h2>
            </button>
        </li>
        <li class="nav-item col-3 text-center" role="presentation">
            <button class="nav-link w-100 rounded-top" id="totalProfits-tab" data-bs-toggle="tab" data-bs-target="#totalProfits" type="button" role="tab" aria-controls="totalProfits" aria-selected="true">
                <i class='bi bi-graph-up-arrow fs-1'></i><br>
                <strong>Total profit:</strong>
                <h2><spam class='usdnum'><?php echo number_format($total_profit, 2); ?></span></h2>
            </button>
        </li>
    </ul>
    <div class="tab-content text-bg-dark p-3" id="myTabContent">
        <div class="tab-pane fade show active" id="cash" role="tabpanel" aria-labelledby="cash-tab">
            <?php
                $drawer_safe_log = $conn->query("SELECT * FROM drawer_safe_log ORDER BY date DESC LIMIT 1")->fetch_assoc();
                $drawer = ($drawer_safe_log['drawer_cash']) ?? 0;
                $safe = ($drawer_safe_log['safe_cash']) ?? 0;
            ?>

            <div class="row pt-5">
                <div class="col-4 offset-1 text-center text-bg-dark-glass py-5">
                    <h5 class="m-0">Drawer:</h5>
                    <h1 class='usdnum m-0'>
                        <?php echo number_format($drawer, 2); ?>
                    </h1>
                    <form action="helpers/financial_insights_drawer.php" method="POST" class="pt-5 row px-3">
                        <input type="number" name="amount" class="form-control tbox mb-3" placeholder="Enter amount" required step="0.01">
                        <button type="submit" name="deposit" class="btn btn-success col-4" style="border-radius: 0 0 0 0;">
                            <i class="bi bi-plus-circle fs-1"></i><br> Deposit
                        </button>
                        <button type="submit" name="withdraw" class="btn btn-danger col-4" style="border-radius: 0 0 0 0;">
                            <i class="bi bi-dash-circle fs-1"></i><br> Withdraw
                        </button>
                        <button type="submit" name="toSafe" class="btn btn-dark col-4" style="border-radius: 0 0 0 0;">
                            <i class="bi bi-arrow-right-circle fs-1"></i><br> To safe
                        </button>
                    </form>
                </div>
                <div class="col-4 offset-2 text-center text-bg-dark-glass py-5">
                    <h5 class="m-0">Safe:</h5>
                    <h1 class='usdnum m-0'>
                        <?php echo number_format($safe, 2); ?>
                    </h1>
                    <form action="helpers/financial_insights_safe.php" method="POST" class="pt-5 row px-3">
                        <input type="number" name="amount" class="form-control tbox mb-3" placeholder="Enter amount" required step="0.01">
                        <button type="submit" name="toDrawer" class="btn btn-dark col-4" style="border-radius: 0 0 0 0;">
                            <i class="bi bi-arrow-left-circle fs-1"></i><br> To drawer
                        </button>
                        <button type="submit" name="deposit" class="btn btn-success col-4" style="border-radius: 0 0 0 0;">
                            <i class="bi bi-plus-circle fs-1"></i><br> Deposit
                        </button>
                        <button type="submit" name="withdraw" class="btn btn-danger col-4" style="border-radius: 0 0 0 0;">
                            <i class="bi bi-dash-circle fs-1"></i><br> Withdraw
                        </button>
                    </form>
                </div>
            </div>
            <table class="table table-dark mt-5">
                <tr>
                    <th>Id</th>
                    <th>Amound</th>
                    <th>Action</th>
                    <th>Message</th>
                    <th>Date</th>
                </tr>
                <?php
                    $logStmt = $conn->query("SELECT * FROM drawer_safe_log ORDER BY date DESC");
                    while ($row = $logStmt->fetch_assoc()) {
                        switch ($row['action']) {
                            case 'drawerAdd':
                                $action = "Deposit to Drawer";
                                $message = "Deposited <span class='usdnum'>" . number_format($row['amount'], 2) . "</span> to drawer";
                                break;
                            case 'drawerSub':
                                $action = "Withdraw from Drawer";
                                $message = "Withdrew <span class='usdnum'>" . number_format($row['amount'], 2) . "</span> from drawer";
                                break;
                            case 'safeAdd':
                                $action = "Deposit to Safe";
                                $message = "Deposited <span class='usdnum'>" . number_format($row['amount'], 2) . "</span> to safe";
                                break;
                            case 'safeSub':
                                $action = "Withdraw from Safe";
                                $message = "Withdrew <span class='usdnum'>" . number_format($row['amount'], 2) . "</span> from safe";
                                break;
                            case 'drawer':
                                $action = "Transfer to Drawer";
                                $message = "Transferred <span class='usdnum'>" . number_format($row['amount'], 2) . "</span> to drawer";
                                break;
                            case 'safe':
                                $action = "Transfer to Safe";
                                $message = "Transferred <span class='usdnum'>" . number_format($row['amount'], 2) . "</span> to safe";
                                break;
                        }
                        
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td class='usdnum'>" . number_format($row['amount'], 2) . "</td>
                                <td>{$action}</td>
                                <td>{$message}</td>
                                <td>{$row['date']}</td>
                              </tr>";
                    }
                ?>
            </table>
        </div>
        <div class="tab-pane fade" id="cashInBanks" role="tabpanel" aria-labelledby="cashInBanks-tab">
            <div class="row py-5 d-flex justify-content-center">
                <div class="col-3">
                    <button type='button' class='btn btn-success w-100' data-bs-toggle='modal' data-bs-target='#addCashInBankModal'>Deposit</button>
                </div>
                <div class="col-3">
                    <button type='button' class='btn btn-danger w-100' data-bs-toggle='modal' data-bs-target='#subCashInBankModal'>Withdraw</button>
                </div>
            </div>
            <table class="table table-dark">
                <tr>
                    <th>Id</th>
                    <th>Amound</th>
                    <th>Deposit / Withdraw</th>
                    <th>Date</th>
                </tr>
                <?php
                    $logStmt = $conn->query("SELECT * FROM cash_in_bank_log ORDER BY date DESC");
                    while ($row = $logStmt->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td class='usdnum'>" . number_format($row['amount'], 2) . "</td>
                                <td>{$row['add_sub']}</td>
                                <td>{$row['date']}</td>
                              </tr>";
                    }
                ?>
            </table>
        </div>
        <div class="tab-pane fade" id="totalProfits" role="tabpanel" aria-labelledby="totalProfits-tab">
            <!-- #region showing the profit over time in chart -->
                <div class="container my-4">
                    <div class="card text-bg-dark">
                    <div class="card-header text-white" style="background:#2d3339;">
                        <h4>Profit Over Time</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="profitChart"></canvas>
                    </div>
                    </div>
                </div>

                <script src="js/charts/moment.min.js"></script>
                <script src="js/charts/chart.js"></script>
                <script src="js/charts/chartjs-adapter-moment.js"></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var ctx = document.getElementById('profitChart').getContext('2d');
                        
                        // Create gradient
                        var gradient = ctx.createLinearGradient(0, 0, 0, 400);
                        gradient.addColorStop(0, 'rgba(75, 192, 192, 0.5)'); // Top (strong color)
                        gradient.addColorStop(1, 'rgba(75, 192, 192, 0)');   // Bottom (fade out)

                        var profitChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: [
                                    <?php
                                        $date_result = mysqli_query($conn, "SELECT date FROM profits ORDER BY date DESC LIMIT 7");
                                        while ($date_row = mysqli_fetch_assoc($date_result)) {
                                            echo "'" . $date_row['date'] . "',";
                                        }
                                    ?>
                            ],
                            datasets: [{
                                label: 'Profit',
                                data: [
                                    <?php
                                    $profit_result = mysqli_query($conn, "SELECT net_profit FROM profits ORDER BY date DESC LIMIT 100");
                                    while ($profit_row = mysqli_fetch_assoc($profit_result)) {
                                        echo $profit_row['net_profit'] . ",";
                                    }
                                ?>
                                ],
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 3,
                                    backgroundColor: gradient, // Apply gradient fill
                                    fill: true, // Enable the filled area
                                    tension: 0.4 // Smooth curve effect
                                }]
                            },
                        options: {
                            scales: {
                                    x: {
                                        type: 'time',
                                        time: {
                                            unit: 'day'
                                        }
                                    },
                                    y: {
                                        beginAtZero: false
                                    }
                                }
                            }
                        });
                    });
                </script>
            <!-- #endregion -->
            <!-- #region tab layout for daily, monthly, and annual profits -->
                <div class="container my-5">
                    <!-- #region Tabs Navigation -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="daily-tab" data-bs-toggle="tab" data-bs-target="#daily" type="button" role="tab" aria-controls="daily" aria-selected="true">Daily</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="monthly-tab" data-bs-toggle="tab" data-bs-target="#monthly" type="button" role="tab" aria-controls="monthly" aria-selected="false">Monthly</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="annual-tab" data-bs-toggle="tab" data-bs-target="#annual" type="button" role="tab" aria-controls="annual" aria-selected="false">Annual</button>
                            </li>
                        </ul>
                    <!-- #endregion -->
                    <!-- #region Tabs Content -->
                        <div class="tab-content text-bg-dark p-3" id="myTabContent">
                            <div class="tab-pane fade show active" id="daily" role="tabpanel" aria-labelledby="daily-tab">
                                <!-- #region daily profits -->
                                    <table class="table table-dark">
                                        <tr>
                                            <th>Date</th>
                                            <th>Gross Profit</th>
                                            <th>Loss</th>
                                            <th>Net Profit</th>
                                        </tr>
                                        <?php
                                            // $result = $conn->query("SELECT * FROM profits ORDER BY date DESC");
                                            // while ($row = $result->fetch_assoc()) {
                                            //     echo "<tr>
                                            //         <td>{$row['date']}</td>
                                            //         <td class='usdnum'>" . number_format($row['gross_profit'], 2) . "</td>
                                            //         <td class='usdnum'>" . number_format($row['loss'], 2) . "</td>
                                            //         <td class='usdnum'>" . number_format($row['net_profit'], 2) . "</td>
                                            //     </tr>";
                                            // }
                                            $result = $conn->query("SELECT * FROM profits ORDER BY date DESC");
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr style='cursor:pointer;' data-bs-toggle='modal' data-bs-target='#profitModal' 
                                                        data-date='{$row['date']}' onclick='fetchDailySales();fetchDailyLoans();'>
                                                    <td>{$row['date']}</td>
                                                    <td class='usdnum'>" . number_format($row['gross_profit'], 2) . "</td>
                                                    <td class='usdnum'>" . number_format($row['loss'], 2) . "</td>
                                                    <td class='usdnum'>" . number_format($row['net_profit'], 2) . "</td>
                                                </tr>";
                                            }
                                        ?>
                                    </table>

                                    <!-- Bootstrap Modal -->
                                    <div class="modal fade" id="profitModal" tabindex="-1" aria-labelledby="profitModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content text-bg-dark round">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="profitModalLabel">Profit Details</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <span id="modal-date" style="font-size:50px;text-align:center;display:block;font-weight:900;"></span>
                                                    <!-- #region tab layout -->
                                                        <div class="container my-5">
                                                            <!-- #region Tabs Navigation -->
                                                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                                    <li class="nav-item" role="presentation">
                                                                        <button class="nav-link active" id="salesTabInModal-tab" data-bs-toggle="tab" data-bs-target="#salesTabInModal" type="button" role="tab" aria-controls="salesTabInModal" aria-selected="true">Sales</button>
                                                                    </li>
                                                                    <li class="nav-item" role="presentation">
                                                                        <button class="nav-link" id="loansTabInModal-tab" data-bs-toggle="tab" data-bs-target="#loansTabInModal" type="button" role="tab" aria-controls="loansTabInModal" aria-selected="false">Loans</button>
                                                                    </li>
                                                                </ul>
                                                            <!-- #endregion -->
                                                            <!-- #region Tabs Content -->
                                                                <div class="tab-content text-bg-dark p-3" id="myTabContent">
                                                                    <div class="tab-pane fade show active" id="salesTabInModal" role="tabpanel" aria-labelledby="salesTabInModal-tab">











<!-- #region Filters Section -->
    <div class="mb-3 d-flex flex-column">
        <div class="row d-flex justify-content-center">
            <!-- Filter by bill number -->
            <div class="col-md-2">
                <input type="number" id="searchBillNo" class="form-control tbox" placeholder="Bill Number">
            </div>
            <!-- Search by name -->
            <div class="col-md-3">
                <input type="text" id="searchName" class="form-control tbox" placeholder="Customer Name">
            </div>
            <!-- Reset Button -->
            <div class="col-md-2">
                <button id="resetFilters" class="btn btn-danger w-100">Reset</button>
            </div>
        </div>
    </div>
<!-- #endregion -->

<!-- #region filter javascript logic -->
    <script>
        function fetchDailySales() {
            const billInput = document.getElementById("searchBillNo");
            const customerInput = document.getElementById("searchName");
            const dateInput = document.getElementById("modal-date");
            const tableBody = document.querySelector("#salesTable tbody");
            const paginationContainer = document.querySelector(".pagination");
            const resetButton = document.getElementById("resetFilters");

            function fetchFilteredResults(page = 1) {
                const bill = billInput.value.trim();
                const customer = customerInput.value.trim();
                const date = dateInput.innerHTML;
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "helpers/financial_insights_fetch_sales.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                xhr.onload = function () {
                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        tableBody.innerHTML = response.table;
                        paginationContainer.innerHTML = response.pagination;

                        document.querySelectorAll(".pagination .page-link").forEach(link => {
                            link.addEventListener("click", function (e) {
                                e.preventDefault();
                                fetchFilteredResults(this.getAttribute("data-page"));
                            });
                        });
                    }
                };
                xhr.send(`bill=${bill}&customer=${customer}&date=${date}&page=${page}`);
            }

            // Fetch data when filters change
            billInput.addEventListener("input", () => fetchFilteredResults());
            customerInput.addEventListener("input", () => fetchFilteredResults());

            // Initial load
            fetchFilteredResults();
            resetButton.addEventListener("click", () => {
                document.getElementById('searchBillNo').value = '';
                document.getElementById('searchName').value = '';
                fetchFilteredResults();
            });
        }
    </script>
<!-- #endregion -->
<!-- #region sales table -->
    <table class="table table-dark" id="salesTable">
        <thead style="position:sticky;top:0px;">
            <tr>
                <th>Bill ID</th>
                <th>Customer Name</th>
                <th>Total Amount</th>
                <th>Date & Time</th>
                <th>Loan / Cash</th>
                <th>Total Profit</th>
                <th>Dollar rate</th>
                <th>Created By</th>
                <th>Bill</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <!-- Pagination Controls -->
    <style>
        .pagination .page-item.active .page-link {
            background-color: var(--primary);
            border: none;
            color: var(--onPrimary);
            font-weight: bold;
        }

        .pagination .page-link {
            background: var(--bg2);
            border-radius: 5px;
            margin: 0 3px;
            padding: 8px 12px;
            transition: background 0.3s;
            border: none;
            color: white;
        }

        .pagination .page-item.disabled .page-link {
            background: transparent;
            color: gray;
        }

        .pagination .page-link:hover {
            background: var(--primary);
            color: var(--onPrimary);
        }

    </style>
    <nav>
        <ul class="pagination justify-content-center">

        </ul>
    </nav>
<!-- #endregion -->













                                                                    </div>
                                                                    <div class="tab-pane fade" id="loansTabInModal" role="tabpanel" aria-labelledby="loansTabInModal-tab">

                                                                    









                                                                    
<!-- #region Filters Section -->
    <div class="mb-3 d-flex flex-column">
        <div class="row d-flex justify-content-center">
            <!-- Search by name -->
            <div class="col-md-3">
                <input type="text" id="searchCustomerName" class="form-control tbox" placeholder="Customer Name">
            </div>
            <!-- Reset Button -->
            <div class="col-md-2">
                <button id="resetCustomerFilter" class="btn btn-danger w-100">Reset</button>
            </div>
        </div>
    </div>
<!-- #endregion -->

<!-- #region filter javascript logic -->
    <script>
        function fetchDailyLoans() {
            const customerInput = document.getElementById("searchCustomerName");
            const dateInput = document.getElementById("modal-date");
            const tableBody = document.querySelector("#loansTable tbody");
            const paginationContainer = document.querySelector(".loanPagination");
            const resetButton = document.getElementById("resetCustomerFilter");

            function fetchLoansFilteredResults(page = 1) {
                const customer = customerInput.value.trim();
                const date = dateInput.innerHTML;
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "helpers/financial_insights_fetch_loans.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        tableBody.innerHTML = response.table;
                        paginationContainer.innerHTML = response.pagination;

                        document.querySelectorAll(".loanPagination .page-link").forEach(link => {
                            link.addEventListener("click", function (e) {
                                e.preventDefault();
                                fetchLoansFilteredResults(this.getAttribute("data-page"));
                            });
                        });
                    }
                };
                
                xhr.send(`customer=${customer}&date=${date}&page=${page}`);
            }

            // Fetch data when filters change
            customerInput.addEventListener("input", () => fetchLoansFilteredResults());

            // Initial load
            fetchLoansFilteredResults();
            resetButton.addEventListener("click", () => {
                document.getElementById('searchCustomerName').value = '';
                fetchLoansFilteredResults();
            });
        }
    </script>
<!-- #endregion -->
<!-- #region sales table -->
    <table class="table table-dark" id="loansTable">
        <thead style="position:sticky;top:0px;">
            <tr>
                <th>Customer Name</th>
                <th>Amount</th>
                <th>Date & Time</th>
                <th>Lend / Repayed</th>
                <th>User</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <!-- Pagination Controls -->
    <style>
        .loanPagination .page-item.active .page-link {
            background-color: var(--primary);
            border: none;
            color: var(--onPrimary);
            font-weight: bold;
        }

        .loanPagination .page-link {
            background: var(--bg2);
            border-radius: 5px;
            margin: 0 3px;
            padding: 8px 12px;
            transition: background 0.3s;
            border: none;
            color: white;
        }

        .loanPagination .page-item.disabled .page-link {
            background: transparent;
            color: gray;
        }

        .loanPagination .page-link:hover {
            background: var(--primary);
            color: var(--onPrimary);
        }

    </style>
    <nav>
        <ul class="pagination loanPagination justify-content-center">

        </ul>
    </nav>
<!-- #endregion -->












                                                                    </div>
                                                                </div>
                                                            <!-- #endregion -->
                                                        </div>
                                                    <!-- #endregion -->
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- JavaScript to Populate Modal -->
                                    <script>
                                        document.addEventListener("DOMContentLoaded", function () {
                                            let profitModal = document.getElementById('profitModal');
                                            profitModal.addEventListener('show.bs.modal', function (event) {
                                                let button = event.relatedTarget; // Row that triggered the modal
                                                document.getElementById('modal-date').textContent = button.getAttribute('data-date');
                                            });
                                        });
                                    </script>
                                <!-- #endregion -->
                            </div>
                            <div class="tab-pane fade" id="monthly" role="tabpanel" aria-labelledby="monthly-tab">
                                <!-- #region monthly profits -->
                                    <table class="table table-dark">
                                        <tr>
                                            <th>Month</th>
                                            <th>Gross Profit</th>
                                            <th>Loss</th>
                                            <th>Net Profit</th>
                                        </tr>
                                        <?php
                                            $result = $conn->query("SELECT * FROM monthly_profits ORDER BY month DESC");
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>
                                                    <td>{$row['month']}</td>
                                                    <td class='usdnum'>" . number_format($row['total_net_profit'], 2) . "</td>
                                                    <td class='usdnum'>" . number_format($row['monthly_loss'], 2) . "</td>
                                                    <td class='usdnum'>" . number_format($row['monthly_net_profit'], 2) . "</td>
                                                </tr>";
                                            }
                                        ?>
                                    </table>
                                <!-- #endregion -->
                            </div>
                            <div class="tab-pane fade" id="annual" role="tabpanel" aria-labelledby="annual-tab">
                                <!-- #region annual profits -->
                                    <table class="table table-dark">
                                        <tr>
                                            <th>Year</th>
                                            <th>Gross Profit</th>
                                            <th>Loss</th>
                                            <th>Net Profit</th>
                                        </tr>
                                        <?php
                                            $result = $conn->query("SELECT * FROM annual_profits ORDER BY year DESC");
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>
                                                    <td>{$row['year']}</td>
                                                    <td class='usdnum'>" . number_format($row['total_net_profit'], 2) . "</td>
                                                    <td class='usdnum'>" . number_format($row['annual_loss'], 2) . "</td>
                                                    <td class='usdnum'>" . number_format($row['annual_net_profit'], 2) . "</td>
                                                </tr>";
                                            }
                                        ?>
                                    </table>
                                <!-- #endregion -->
                            </div>
                        </div>
                    <!-- #endregion -->
                </div>
            <!-- #endregion -->
        </div>
    </div>
    
    <!-- #region Modal for adding cash_in_bank -->
        <div class="modal fade" id="addCashInBankModal" tabindex="-1" aria-labelledby="addCashInBankModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content text-bg-dark">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCashInBankModalLabel">Deposit Cash</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="helpers/financial_insights_transaction.php" method="POST" autocomplete="off">
                            <!-- amount -->
                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount:</label>
                                <input type="number" id="amount" name="amount" class="form-control bg-transparent text-white" required step="0.01">
                            </div>
                            <!-- message -->
                            <div class="mb-3">
                                <label for="message" class="form-label">Message:</label>
                                <textarea id="message" name="message" class="form-control bg-transparent text-white"></textarea>
                            </div>
                            <input type="hidden" name="type" value="addCashInBank">
                            <!-- Reset and Submit -->
                            <div class="d-flex justify-content-between">
                                <button type="reset" class="btn btn-danger">Reset</button>
                                <button type="submit" name="depositCashInBank" class="btn btn-success">Deposit Cash</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <!-- #endregion -->
    <!-- #region Modal for subtracting cash_in_bank -->
        <div class="modal fade" id="subCashInBankModal" tabindex="-1" aria-labelledby="subCashInBankModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content text-bg-dark">
                    <div class="modal-header">
                        <h5 class="modal-title" id="subCashInBankModalLabel">Withdraw Cash</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="helpers/financial_insights_transaction.php" method="POST" autocomplete="off">
                            <!-- amount -->
                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount:</label>
                                <input type="number" id="amount" name="amount" class="form-control bg-transparent text-white" required step="0.01">
                            </div>
                            <!-- message -->
                            <div class="mb-3">
                                <label for="message" class="form-label">Message:</label>
                                <textarea id="message" name="message" class="form-control bg-transparent text-white"></textarea>
                            </div>
                            <input type="hidden" name="type" value="subCashInBank">
                            <!-- Reset and Submit -->
                            <div class="d-flex justify-content-between">
                                <button type="reset" class="btn btn-danger">Reset</button>
                                <button type="submit" name="withdrawCashInBank" class="btn btn-danger">Withdraw</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <!-- #endregion -->
    </div>
</div>
<!-- #endregion -->


<!-- #region footer -->
    <?php
    // Include the footer file
    include('includes/footer.php');
    ?>

    <script>
    // Activate the sidebar link
    document.getElementById("sidebarFinancialInsights").classList.add("active");
    </script>
<!-- #endregion -->