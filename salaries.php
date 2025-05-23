<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("location: access_denied.php");
    exit();
}
#region includes
// Include the database connection file
include('includes/db_connect.php');
// Include the header file
include('includes/header.php');

include('helpers/salaries_helper.php');
#endregion
?>





<div class="mb-auto p-5">
    <!-- #region Tabs Navigation -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="payments-tab" data-bs-toggle="tab" data-bs-target="#payments" type="button" role="tab" aria-controls="payments" aria-selected="true">Payments</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="payments-log-tab" data-bs-toggle="tab" data-bs-target="#paymentsLog" type="button" role="tab" aria-controls="paymentsLog" aria-selected="false">Payments Log</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="employees-tab" data-bs-toggle="tab" data-bs-target="#employees" type="button" role="tab" aria-controls="employees" aria-selected="false">Employees</button>
            </li>
        </ul>
    <!-- #endregion -->
    <!-- #region tab contents -->
        <div class="tab-content text-bg-dark rounded-3 p-3" id="myTabContent">
            <div class="tab-pane fade show active" id="payments" role="tabpanel" aria-labelledby="payments-tab">
                <?php
                    // Get distinct months
                    $monthsResult = $conn->query("SELECT DISTINCT month FROM salaries ORDER BY month DESC");

                    while ($monthRow = $monthsResult->fetch_assoc()) {
                        $month = $monthRow['month'];
                        echo "<h2 class='text-center pt-5 pb-3'>$month</h2>"; // Month header

                        // Get salary data for this specific month
                        $salaries = $conn->query("SELECT s.*, e.employee_name AS employee_name 
                                                FROM salaries s
                                                JOIN employees e ON s.employee_id = e.id
                                                WHERE s.month = '$month'");
                        echo '<table class="table table-dark">
                                <tr>
                                    <th>id</th>
                                    <th>Employee Name</th>
                                    <th>Salary</th>
                                    <th>Amount Paid</th>
                                    <th>Remaining</th>
                                </tr>';
                        while ($row = $salaries->fetch_assoc()) {
                            $remaining = $row['salary'] - $row['amount_paid'];

                            echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['employee_name']}</td>
                                    <td class='afnnum'>" . number_format($row['salary'], 2) . "</td>
                                    <td class='afnnum'>" . number_format($row['amount_paid'], 2) . "</td>
                                    <td class='afnnum'>" . number_format(($row['salary'] - $row['amount_paid']), 2) . "</td>";
                                
                                // Add Pay button if salary is not fully paid
                                if ($remaining > 0) {
                                    echo "<td>
                                            <form action='pay_salary.php' method='POST' class='d-flex'>
                                                <input type='hidden' name='employee_id' value='{$row['employee_id']}'>
                                                <input type='hidden' name='month' value='{$month}'>
                                                <input type='number' name='amount' placeholder='Enter amount' min='1' max='{$remaining}' required class='form-control form-control-sm me-2'>
                                                <button type='submit' class='btn btn-success btn-sm'>Pay</button>
                                            </form>
                                        </td>";
                                } else {
                                    echo "<td><span class='text-success'>Paid</span></td>";
                                }

                                echo "</tr>";
                        }
                        echo "</table>";
                    }
                ?>
            </div>
            <div class="tab-pane fade" id="paymentsLog" role="tabpanel" aria-labelledby="payments-log-tab">
                <!-- #region display the salary log -->
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Amount</th>
                                <th>Dollar rate</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $result = $conn->query("
                                SELECT employees.employee_name, salary_log.amount, currency.rate, salary_log.date FROM salary_log
                                JOIN employees ON salary_log.employee_id = employees.id 
                                JOIN currency ON salary_log.dollar_rate = currency.id
                                ORDER BY salary_log.date DESC");
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row['employee_name'] . "</td>";
                                        echo "<td class='afnnum'>" . number_format($row['amount'], 2) . "</td>";
                                        echo "<td class='dollarRate'>" . number_format($row['rate'], 2) . "</td>";
                                        echo "<td>" . $row['date'] . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='3'>No payments found</td></tr>";
                                }
                                $result->close();
                            ?>
                        </tbody>
                    </table>
                <!-- #endregion -->
            </div>
            <div class="tab-pane fade" id="employees" role="tabpanel" aria-labelledby="employees-tab">
                <!-- #region adding an employee -->
                    <div class="col-6 offset-3 round shadow" style="background: rgba(255, 255, 255, 0.05);">
                        <div class="text-white py-3 text-center">
                            <h5>Add new employee</h5>
                        </div>
                        <form action="helpers/salaries_add_employee.php" method="post" class="p-3" autocomplete="off">
                            <div class="form-group row">
                                <label for="employee_name" class="col-sm-3 col-form-label">Employee Name:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control tbox" id="employee_name" name="employee_name" placeholder="Employee Nmae" required>
                                </div>
                            </div>
                            <div class="form-group row mt-3">
                                <label for="salary" class="col-sm-3 col-form-label">Salary:</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control tbox" id="salary" name="salary" placeholder = "Employee Salary" required>
                                </div>
                            </div>
                            <div class="form-group row mt-3">
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Add Employee</button>
                                </div>
                            </div>
                        </form>
                    </div>
                <!-- #endregion -->
                <!-- #region showing the employees -->
                    <table class="table table-dark mt-5">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Employee Name</th>
                                <th>Salary</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = $conn->query("SELECT * FROM employees");
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td>" . $row['id'] . "</td>
                                            <td>" . $row['employee_name'] . "</td>
                                            <td class='afnnum'>" . number_format($row['salary'], 2) . "
                                                <form action='helpers/salaries_edit_salary.php' method='POST' class='editSalaryForm d-inline-block'>
                                                    <input type='hidden' name='id' value='{$row['id']}'>
                                                    <input type='hidden' name='amount' value='0'>
                                                    <button type='submit' class='btn'><i class='bi bi-pencil-fill text-white'></i></button>
                                                </form>
                                            </td>
                                            <td>
                                                <form action='helpers/salaries_pay_salary.php' method='POST' class='paySalaryForm d-inline-block'>
                                                    <input type='hidden' name='id' value='{$row['id']}'>
                                                    <input type='hidden' name='amount' value='0'>
                                                    <button type='submit' class='btn btn-primary px-3'>Pay</button>
                                                </form>
                                                <form action='helpers/salaries_delete_employee.php' method='POST' class='deleteEmployeeForm d-inline-block'>
                                                    <input type='hidden' name='id' value='{$row['id']}'>
                                                    <button type='submit' class='btn btn-danger'><i class='bi bi-trash-fill'></i></button>
                                                </form>
                                            </td>
                                        </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>No employees found</td></tr>";
                            }
                            $result->close();
                            ?>
                        </tbody>
                    </table>
                    <!-- #region handle edit_salary, pay_salary, and delete_employee -->
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                document.querySelectorAll('.editSalaryForm').forEach(function (form) {
                                    form.addEventListener('submit', function (event) {
                                        event.preventDefault(); // Prevent default form submission
                                        let amount = prompt('Enter new salary:');
                                        if (amount != null && amount != "" && !isNaN(amount)) {
                                            form.querySelector("[name='amount']").value = amount;
                                            form.submit(); // Submit the form if amount is correct
                                        } else {
                                            alert("Please enter a valid amount!");
                                        }
                                    });
                                });
                                document.querySelectorAll('.paySalaryForm').forEach(function (form) {
                                    form.addEventListener('submit', function (event) {
                                        event.preventDefault(); // Prevent default form submission
                                        let amount = prompt('Enter amount:');
                                        if (amount != null && amount != "" && !isNaN(amount)) {
                                            form.querySelector("[name='amount']").value = amount;
                                            form.submit(); // Submit the form if amount is correct
                                        } else {
                                            alert("Please enter a valid amount!");
                                        }
                                    });
                                });
                                document.querySelectorAll('.deleteEmployeeForm').forEach(function (form) {
                                    form.addEventListener('submit', function (event) {
                                        event.preventDefault(); // Prevent default form submission
                                        let password = prompt('Enter your password:');
                                        if (password == "shahid@729") {
                                            form.submit(); // Submit the form if password is correct
                                        } else {
                                            alert('Incorrect Password!');
                                        }
                                    });
                                });
                            });
                        </script>
                    <!-- #endregion -->
                <!-- #endregion -->
            </div>
        </div>
    <!-- #endregion -->
</div>





<!-- #region footer -->
    <?php
    // Include the footer file
    include('includes/footer.php');
    ?>

    <script>
    // Activate the sidebar link
    document.getElementById("sidebarSalaries").classList.add("active");
    </script>
<!-- #endregion -->