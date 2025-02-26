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
        $products = ($transactions['total_products']) ?? 0;
        $cash = ($transactions['cash']) ?? 0;
        $cash_in_banks = ($transactions['cash_in_banks']) ?? 0;
        $total_profit = $conn->query("SELECT SUM(annual_net_profit) AS net_profit FROM annual_profits")->fetch_assoc()['net_profit'];
        $capital = ($products + $cash + $cash_in_banks + $total_profit) ?? 0;
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
                <h2><span class='usdnum'><?php echo number_format($cash + $total_profit, 2); ?></span></h2>
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
            <div class="row py-5 d-flex justify-content-center">
                <div class="col-3">
                    <button type='button' class='btn btn-success w-100' data-bs-toggle='modal' data-bs-target='#addCashModal'>Deposit</button>
                </div>
                <div class="col-3">
                    <button type='button' class='btn btn-danger w-100' data-bs-toggle='modal' data-bs-target='#subCashModal'>Withdraw</button>
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
                    $logStmt = $conn->query("SELECT * FROM cash_log ORDER BY date DESC");
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

                <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@^1.0.0"></script>
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
                                            $result = $conn->query("SELECT * FROM profits ORDER BY date DESC");
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>
                                                    <td>{$row['date']}</td>
                                                    <td class='usdnum'>" . number_format($row['gross_profit'], 2) . "</td>
                                                    <td class='usdnum'>" . number_format($row['loss'], 2) . "</td>
                                                    <td class='usdnum'>" . number_format($row['net_profit'], 2) . "</td>
                                                </tr>";
                                            }
                                        ?>
                                    </table>
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
    <!-- #region Modal for adding cash -->
        <div class="modal fade" id="addCashModal" tabindex="-1" aria-labelledby="addCashModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content text-bg-dark">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCashModalLabel">Deposit Cash</h5>
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
                            <input type="hidden" name="type" value="addCash">
                            <!-- Reset and Submit -->
                            <div class="d-flex justify-content-between">
                                <button type="reset" class="btn btn-danger">Reset</button>
                                <button type="submit" name="depositCash" class="btn btn-success">Deposit Cash</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <!-- #endregion -->
    <!-- #region Modal for subtracting cash -->
        <div class="modal fade" id="subCashModal" tabindex="-1" aria-labelledby="subCashModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content text-bg-dark">
                    <div class="modal-header">
                        <h5 class="modal-title" id="subCashModalLabel">Withdraw Cash</h5>
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
                            <input type="hidden" name="type" value="subCash">
                            <!-- Reset and Submit -->
                            <div class="d-flex justify-content-between">
                                <button type="reset" class="btn btn-danger">Reset</button>
                                <button type="submit" name="withdrawCash" class="btn btn-danger">Withdraw</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <!-- #endregion -->
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