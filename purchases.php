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
    <div class="p-5 flex-column mb-auto">
        <h2>Purchases</h2>

        <!-- #region Button to open the modal for adding a purchase -->
            <div class="d-flex align-items-center justify-content-center">
                <button type="button" class="btn btn-primary round p-4 my-3 text-center" data-bs-toggle="modal" data-bs-target="#addPurchaseModal">
                    <i class="bi bi-plus-circle-fill fs-3"></i><br>Add New Purchase
                </button>
            </div>
        <!-- #endregion -->

        <!-- #region Modal for adding a new purchase -->
            <div class="modal fade" id="addPurchaseModal" tabindex="-1" aria-labelledby="addPurchaseModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content text-bg-dark round">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addPurchaseModalLabel">Add New Purchase</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="helpers/purchases_add_purchase.php" method="POST" autocomplete="off" class="row">
                                <!-- Product Selection -->
                                <div class="col-md-12 mb-3">
                                    <label for="product_id" class="form-label">Product:</label>
                                    <select id="product_id" name="product_id" class="form-select tbox" required>
                                        <option value="" disabled selected>Select a product</option>
                                        <?php
                                        // Fetch products from the products table
                                        $result = $conn->query("SELECT id, name FROM products");
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- Quantity -->
                                <div class="col-md-6 mb-3">
                                    <label for="quantity" class="form-label">Quantity:</label>
                                    <input type="number" id="quantity" name="quantity" class="form-control tbox" required>
                                </div>
                                <!-- Price -->
                                <div class="col-md-6 mb-3">
                                    <label for="price" class="form-label">Price:</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-0 text-bg-primary">$</span>
                                        <input type="number" id="price" name="price" class="form-control tbox" required step="0.01">
                                    </div>
                                </div>

                                <!-- Reset and Submit -->
                                <div class="d-flex justify-content-between">
                                    <button type="reset" class="btn btn-danger">Reset</button>
                                    <button type="submit" class="btn btn-primary">Add Purchase</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <!-- #endregion -->

        <hr class="my-5">
        <!-- #region table for showing purchases -->
            <div class="text-bg-dark p-5">
                <!-- #region table header and filter -->
                    <h2 class="text-center">All Purchases</h2>
                    <h4 class="mt-3">Filter</h4>
                    <!-- Filters Section -->
                    <div class="mb-3 d-flex gap-3">
                        <!-- Filter by name or description -->
                        <input type="text" id="search" class="form-control tbox" placeholder="Filter by product name" style="flex: 2;">
                        <!-- Filter by date -->
                        <input type="date" id="filterDate" class="form-control tbox" style="flex: 1;" onfocus="this.showPicker()">
                        <!-- Reset Button -->
                        <button id="resetFilters" class="btn btn-danger" style="flex: 0;">Reset</button>
                    </div>
                    <script>
                        // Live Search and Filter by Date
                        document.getElementById('search').addEventListener('input', filterTable);
                        document.getElementById('filterDate').addEventListener('input', filterTable);
        
                        // Reset Filters
                        document.getElementById('resetFilters').addEventListener('click', () => {
                            document.getElementById('search').value = '';
                            document.getElementById('filterDate').value = '';
                            filterTable(); // Reset the table display
                        });
        
                        function filterTable() {
                            const searchValue = document.getElementById('search').value.toLowerCase();
                            const filterDate = document.getElementById('filterDate').value;
                            const tableRows = document.querySelectorAll('#purchasesTable tbody tr');
        
                            tableRows.forEach(row => {
                                const name = row.cells[1].textContent.toLowerCase(); // Purchase Name
                                const purchaseDate = row.cells[5].textContent; // Purchase Date
        
                                const matchesSearch = name.includes(searchValue);
                                const matchesDate = filterDate === '' || purchaseDate.startsWith(filterDate);
        
                                if (matchesSearch && matchesDate) {
                                    row.style.display = ''; // Show row
                                } else {
                                    row.style.display = 'none'; // Hide row
                                }
                            });
                        }
                    </script>
                <!-- #endregion -->
                <?php
                #region Fetch the current exchange rate from the currency table
                $rate_sql = "SELECT rate FROM currency ORDER BY id DESC LIMIT 1";
                $rate_result = $conn->query($rate_sql);

                if ($rate_result->num_rows > 0) {
                    $rate_row = $rate_result->fetch_assoc();
                    $current_rate = $rate_row['rate'];
                } else {
                    $current_rate = 1; // Default rate if not found
                }
                #endregion
                #region showing purchases in the table
                // Fetch and display all purchases
                $sql = "SELECT purchases.id, products.name AS product_name, purchases.quantity, purchases.price, purchases.total, purchases.purchase_date 
                        FROM purchases
                        JOIN products ON purchases.product_id = products.id
                        ORDER BY purchase_date DESC";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "<table id='purchasesTable' class='table table-dark'>
                            <thead>
                                <tr style='position: sticky;top:0px;'>
                                    <th>ID</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                    <th>Purchase Date</th>
                                </tr>
                            </thead>
                            <tbody>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row['id'] . "</td>
                                <td>" . $row['product_name'] . "</td>
                                <td>" . $row['quantity'] . "</td>
                                <td><span class='usdnum'>" . number_format($row['price'], 2) . "</span><br><span class='afnnum'>" . number_format($row['price'] * $current_rate, 2) . "</span></td>
                                <td><span class='usdnum'>" . number_format($row['total'], 2) . "</span><br><span class='afnnum'>" . number_format($row['total'] * $current_rate, 2) . "</span></td>
                                <td>" . $row['purchase_date'] . "</td>
                            </tr>";
                    }
                    echo "</tbody>
                        </table>";
                } else {
                    echo "<p>No products found.</p>";
                }
                #endregion

                $conn->close();
                ?>
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
    document.getElementById("sidebarPurchases").classList.add("active");
    </script>
<!-- #endregion -->