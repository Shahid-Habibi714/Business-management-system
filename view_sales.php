<?php
#region include files
// Include the database connection file
include('includes/db_connect.php');
// Include the header file
include('includes/header.php');
#endregion
?>





<!-- #region body -->
    <div class="p-5 mb-auto">
        <h2>All Sales</h2>
        <!-- #region Filters Section -->
            <div class="mb-3 d-flex flex-column">
                <div class="row">
                    <!-- Filter by bill number -->
                    <div class="col-md-2">
                        <input type="number" id="searchBillNo" class="form-control tbox" placeholder="Bill Number">
                    </div>
                    <!-- Search by name -->
                    <div class="col-md-6">
                        <input type="text" id="searchName" class="form-control tbox" placeholder="Customer Name">
                    </div>
                    <!-- Date Filter -->
                    <div class="col-md-2">
                        <input type="date" id="filterDate" class="form-control tbox" onfocus="this.showPicker();">
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
                document.addEventListener("DOMContentLoaded", function () {
                    const billInput = document.getElementById("searchBillNo");
                    const customerInput = document.getElementById("searchName");
                    const dateInput = document.getElementById("filterDate");
                    const tableBody = document.querySelector("#salesTable tbody");
                    const paginationContainer = document.querySelector(".pagination");
                    const resetButton = document.getElementById("resetFilters");

                    function fetchFilteredResults(page = 1) {
                        const bill = billInput.value.trim();
                        const customer = customerInput.value.trim();
                        const date = dateInput.value.trim();
                        const xhr = new XMLHttpRequest();
                        xhr.open("POST", "helpers/view_sales_fetch_sales.php", true);
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
                    dateInput.addEventListener("change", () => fetchFilteredResults());

                    // Initial load
                    fetchFilteredResults();
                    resetButton.addEventListener("click", () => {
                        document.getElementById('searchBillNo').value = '';
                        document.getElementById('searchName').value = '';
                        document.getElementById('filterDate').value = '';
                        fetchFilteredResults();
                    });
                });
            </script>
        <!-- #endregion -->
        <!-- #region sales table -->
            <table class="table table-dark" id="salesTable">
                <thead style="position:sticky;top:0px;">
                    <tr>
                        <th>Bill ID</th>
                        <th>Customer Name</th>
                        <th>Total Amount</th>
                        <th>Sale Date</th>
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
<!-- #endregion -->





<!-- #region footer -->
    <?php
    // Include the footer file
    include('includes/footer.php');
    ?>

    <script>
    // Activate the sidebar link
    document.getElementById("sidebarViewSales").classList.add("active");
    </script>
<!-- #endregion -->