<?php
#region includes
// Include the database connection file
include('includes/db_connect.php');
// Include the header file
include('includes/header.php');
#endregion
?>




<!-- #region body -->
    <div class="mb-auto p-5">
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
                    <!-- #region adding a new expense -->
                        <form action="helpers/daily_expenses_add_expense.php" method="post" class="row mb-5 text-bg-dark-glass p-5 w-100">
                            <h2 class="pb-3">Add new expense</h2>
                            <div class="col-5 px-1">
                                <input type="text" name="description" class="form-control tbox" placeholder="Description" required>
                            </div>
                            <div class="col-5 px-1">
                                <input type="number" name="amount" class="form-control tbox" placeholder="Amount" step="0.01" required>
                            </div>
                            <div class="col-2 px-1">
                                <input type="submit" class="form-control btn btn-primary">    
                            </div>
                        </form>
                    <!-- #endregion -->
                    <!-- #region filter by time -->
                        <div class="my-3 py-5 text-bg-dark-glass text-center">
                            <h2 class="pb-3">Filter by time</h2>
                            <input type="radio" class="btn-check" name="reporting-filter" id="reporting-all" autocomplete="off" checked>
                            <label class="btn btn-primary" for="reporting-all"><i class="bi bi-check-lg"></i>All</label>

                            <input type="radio" class="btn-check" name="reporting-filter" id="reporting-today" autocomplete="off">
                            <label class="btn btn-primary" for="reporting-today"><i class="bi bi-check-lg"></i>Today</label>

                            <input type="radio" class="btn-check" name="reporting-filter" id="reporting-week" autocomplete="off">
                            <label class="btn btn-primary" for="reporting-week"><i class="bi bi-check-lg"></i>Last Week</label>

                            <input type="radio" class="btn-check" name="reporting-filter" id="reporting-month" autocomplete="off">
                            <label class="btn btn-primary" for="reporting-month"><i class="bi bi-check-lg"></i>Last Month</label>
                            
                            <input type="radio" class="btn-check" name="reporting-filter" id="reporting-3months" autocomplete="off">
                            <label class="btn btn-primary" for="reporting-3months"><i class="bi bi-check-lg"></i>Last 3 Months</label>

                            <input type="radio" class="btn-check" name="reporting-filter" id="reporting-6months" autocomplete="off">
                            <label class="btn btn-primary" for="reporting-6months"><i class="bi bi-check-lg"></i>Last 6 Months</label>

                            <input type="radio" class="btn-check" name="reporting-filter" id="reporting-year" autocomplete="off">
                            <label class="btn btn-primary" for="reporting-year"><i class="bi bi-check-lg"></i>Last Year</label>
                        </div>
                        <!-- #region Javascript logic to filter the table -->
                            <script>
                                document.querySelectorAll(".btn-check").forEach(radio => {
                                    radio.addEventListener("change", () => {
                                        // Get the selected radio button
                                        const selectedRadio = document.querySelector(".btn-check:checked");
                                        const selectedRadioId = selectedRadio.id;

                                        // Get the table rows
                                        const tableRows = document.querySelectorAll("#expensesTable tbody tr");

                                        // Get the current date
                                        const currentDate = new Date();

                                        // Filter the table rows based on the selected radio button
                                        tableRows.forEach(row => {
                                            const expenseDate = new Date(row.cells[3].textContent);
                                            const daysDifference = Math.ceil((currentDate - expenseDate) / (1000 * 60 * 60 * 24));
                                            switch (selectedRadioId) {
                                                case "reporting-today":
                                                    if (daysDifference === 1) {
                                                        row.style.display = "";
                                                    } else {
                                                        row.style.display = "none";
                                                    }
                                                    break;
                                                case "reporting-week":
                                                    if (daysDifference <= 7) {
                                                        row.style.display = "";
                                                    } else {
                                                        row.style.display = "none";
                                                    }
                                                    break;
                                                case "reporting-month":
                                                    if (daysDifference <= 30) {
                                                        row.style.display = "";
                                                    } else {
                                                        row.style.display = "none";
                                                    }
                                                    break;
                                                case "reporting-3months":
                                                    if (daysDifference <= 90) {
                                                        row.style.display = "";
                                                    } else {
                                                        row.style.display = "none";
                                                    }
                                                    break;
                                                case "reporting-6months":
                                                    if (daysDifference <= 180) {
                                                        row.style.display = "";
                                                    } else {
                                                        row.style.display = "none";
                                                    }
                                                    break;
                                                case "reporting-year":
                                                    if (daysDifference <= 365) {
                                                        row.style.display = "";
                                                    } else {
                                                        row.style.display = "none";
                                                    }
                                                    break;
                                                default:
                                                    row.style.display = "";
                                            }
                                        });
                                    });
                                });
                            </script>
                        <!-- #endregion -->
                    <!-- #endregion -->
                    <!-- #region displaying the expenses -->
                        <?php
                            // Fetch and display all expenses
                            $sql = "SELECT * FROM daily_expenses ORDER BY date DESC";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                echo "<table id='expensesTable' class='table table-dark'>
                                        <thead class=\"table-dark\">
                                            <tr style='position: sticky;top:0px;'>
                                                <th>ID</th>
                                                <th>Description</th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>";
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td>" . $row['id'] . "</td>
                                            <td>" . $row['description'] . "</td>
                                            <td class='afnnum'>" . number_format($row['amount'], 2) . "</td>
                                            <td>" . $row['date'] . "</td>
                                        </tr>";
                                }
                                echo "</tbody>
                                    </table>";
                            } else {
                                echo "<p>No products found.</p>";
                            }
                        ?>
                    <!-- #endregion -->
                </div>
                <div class="tab-pane fade" id="monthly" role="tabpanel" aria-labelledby="monthly-tab">
                    <!-- #region adding a new expense -->
                        <form action="helpers/monthly_expenses_add_expense.php" method="post" class="row mb-5 text-bg-dark-glass p-5 w-100">
                            <h2 class="pb-3">Add new expense</h2>
                            <div class="col-5 px-1">
                                <input type="text" name="description" class="form-control tbox" placeholder="Description" required>
                            </div>
                            <div class="col-5 px-1">
                                <input type="number" name="amount" class="form-control tbox" placeholder="Amount" step="0.01" required>
                            </div>
                            <div class="col-2 px-1">
                                <input type="submit" class="form-control btn btn-primary">    
                            </div>
                        </form>
                    <!-- #endregion -->
                    <!-- #region displaying the expenses -->
                        <?php
                            // Fetch and display all expenses
                            $sql = "SELECT * FROM monthly_expenses ORDER BY date DESC";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                echo "<table id='monthlyExpensesTable' class='table table-dark'>
                                        <thead class=\"table-dark\">
                                            <tr style='position: sticky;top:0px;'>
                                                <th>ID</th>
                                                <th>Description</th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>";
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td>" . $row['id'] . "</td>
                                            <td>" . $row['description'] . "</td>
                                            <td class='afnnum'>" . number_format($row['amount'], 2) . "</td>
                                            <td>" . $row['date'] . "</td>
                                        </tr>";
                                }
                                echo "</tbody>
                                    </table>";
                            } else {
                                echo "<p>No products found.</p>";
                            }
                        ?>
                    <!-- #endregion -->
                </div>
                <div class="tab-pane fade" id="annual" role="tabpanel" aria-labelledby="annual-tab">
                    <!-- #region adding a new expense -->
                        <form action="helpers/annual_expenses_add_expense.php" method="post" class="row mb-5 text-bg-dark-glass p-5 w-100">
                            <h2 class="pb-3">Add new expense</h2>
                            <div class="col-5 px-1">
                                <input type="text" name="description" class="form-control tbox" placeholder="Description" required>
                            </div>
                            <div class="col-5 px-1">
                                <input type="number" name="amount" class="form-control tbox" placeholder="Amount" step="0.01" required>
                            </div>
                            <div class="col-2 px-1">
                                <input type="submit" class="form-control btn btn-primary">    
                            </div>
                        </form>
                    <!-- #endregion -->
                    <!-- #region displaying the expenses -->
                        <?php
                            // Fetch and display all expenses
                            $sql = "SELECT * FROM annual_expenses ORDER BY date DESC";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                echo "<table id='annualExpensesTable' class='table table-dark'>
                                        <thead class=\"table-dark\">
                                            <tr style='position: sticky;top:0px;'>
                                                <th>ID</th>
                                                <th>Description</th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>";
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td>" . $row['id'] . "</td>
                                            <td>" . $row['description'] . "</td>
                                            <td class='afnnum'>" . number_format($row['amount'], 2) . "</td>
                                            <td>" . $row['date'] . "</td>
                                        </tr>";
                                }
                                echo "</tbody>
                                    </table>";
                            } else {
                                echo "<p>No products found.</p>";
                            }
                        ?>
                    <!-- #endregion -->
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
    document.getElementById("sidebarExpenses").classList.add("active");
    </script>
<!-- #endregion -->