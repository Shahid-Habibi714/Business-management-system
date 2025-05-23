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
        <h2>Products</h2>

        <!-- #region Button to open the modal for adding a product -->
            <div class="d-flex align-items-center justify-content-center text-bg-dark col-8 offset-2 py-5 round shadow">
                <div class='col-8 px-5'>
                    <h2 style="font-weight:700;">Add new product</h2>
                    <p>
                        To add a new purchase, you need to first add the product by clicking the <span class='text-primary'>Add new product</span> button.
                    </p>
                </div>
                <div class='col-4'>
                    <button type="button" class="btn btn-primary round p-4 my-3 text-center" data-bs-toggle="modal" data-bs-target="#addProductModal">
                        <i class="bi bi-plus-circle-fill fs-3"></i><br>Add New Product
                    </button>
                </div>
            </div>
        <!-- #endregion -->

        <!-- #region Modal for adding a new product -->
            <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content text-bg-dark round">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="helpers/products_add_product.php" method="POST" autocomplete="off">
                                <!-- Product Name -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Product Name:</label>
                                    <input type="text" id="name" name="name" class="form-control tbox" required>
                                </div>

                                <!-- Description -->
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description:</label>
                                    <textarea id="description" name="description" class="form-control tbox"></textarea>
                                </div>

                                <!-- Reset and Submit -->
                                <div class="d-flex justify-content-between">
                                    <button type="reset" class="btn btn-danger">Reset</button>
                                    <button type="submit" class="btn btn-primary">Add Product</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <!-- #endregion -->
        
        <hr class="my-5">
        <!-- #region tab layout -->
            <div class="container my-5">
                <!-- #region Tabs Navigation -->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="products-tab" data-bs-toggle="tab" data-bs-target="#products" type="button" role="tab" aria-controls="products" aria-selected="true">Products</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="accessories-tab" data-bs-toggle="tab" data-bs-target="#accessories" type="button" role="tab" aria-controls="accessories" aria-selected="false">Accessories log</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="transfer-tab" data-bs-toggle="tab" data-bs-target="#transfer" type="button" role="tab" aria-controls="transfer" aria-selected="false">Transfer log</button>
                        </li>
                    </ul>
                <!-- #endregion -->
                <!-- #region Tabs Content -->
                    <div class="tab-content text-bg-dark p-3" id="myTabContent">
                        <div class="tab-pane fade show active" id="products" role="tabpanel" aria-labelledby="products-tab">
                            <!-- #region products tab -->
                                <!-- #region table header and filter -->
                                    <h2 class="text-center">All Products</h2>
                                    <h4 class="mt-3">Filter</h4>
                                    <!-- Filters Section -->
                                    <div class="mb-3 d-flex gap-3">
                                        <!-- Filter by name or description -->
                                        <input type="text" id="search" class="form-control tbox" placeholder="Filter by product name or description" style="flex: 2;">
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
                                            const tableRows = document.querySelectorAll('#productsTable tbody tr');

                                            tableRows.forEach(row => {
                                                const name = row.cells[1].textContent.toLowerCase(); // Product Name
                                                const description = row.cells[2].textContent.toLowerCase(); // Product Description
<<<<<<< HEAD
                                                const purchaseDate = row.cells[7].textContent; // Product Date
=======
                                                const purchaseDate = row.cells[8].textContent; // Product Date
>>>>>>> d1ece8a (replace old project with new one)

                                                const matchesSearch = name.includes(searchValue) || description.includes(searchValue);
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
<<<<<<< HEAD

=======
                                
>>>>>>> d1ece8a (replace old project with new one)
                                <?php

                                #region showing products in the table
                                // Fetch and display all products
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
                                $sql = "SELECT * FROM products";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    echo "<table id='productsTable' class='table table-dark'>
                                            <thead>
                                                <tr style='position: sticky;top:0px;'>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Description</th>
                                                    <th>In Shop</th>
                                                    <th>In Warehouse</th>
                                                    <th>Total stock</th>
                                                    <th>Current Price</th>
<<<<<<< HEAD
=======
                                                    <th>Total</th>
>>>>>>> d1ece8a (replace old project with new one)
                                                    <th>Last Updated</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>";
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                                <td>" . $row['id'] . "</td>
                                                <td>" . $row['name'] . "</td>
                                                <td>" . $row['description'] . "</td>
                                                <td>" . number_format($row['stock']) . "</td>
                                                <td>" . number_format($row['warehouse']) . "</td>
                                                <td>" . number_format(($row['stock'] + $row['warehouse'])) . "</td>
                                                <td><span class='usdnum'>" . number_format($row['current_price'], 2) . "</span><br><span class='afnnum'>" . number_format($row['current_price'] * $current_rate, 2) . "</td>
<<<<<<< HEAD
=======
                                                <td><span class='usdnum'>" . number_format(($row['current_price'] * ($row['stock'] + $row['warehouse'])), 2) . "</span><br><span class='afnnum'>" . number_format((($row['current_price'] * ($row['stock'] + $row['warehouse'])) * $current_rate), 2) . "</span></td>
>>>>>>> d1ece8a (replace old project with new one)
                                                <td>" . $row['updated_at'] . "</td>
                                                <td class='text-center'>
                                                    <div class='row pe-3'>
                                                        <form action='helpers/products_transfer_to_warehouse.php' method='POST' class='toWarehouseForm col-4'>
                                                            <input type='hidden' name='id' value='{$row['id']}'>
                                                            <input type='hidden' name='max' value='{$row['stock']}'>
                                                            <input type='hidden' name='amount' value='0'>
<<<<<<< HEAD
                                                            <button type='submit' class='btn btn-warning'>
=======
                                                            <button type='submit' class='btn btn-warning'
                                                                data-bs-toggle='tooltip' data-bs-placement='top'
                                                                data-bs-title='Move to warehouse'>
>>>>>>> d1ece8a (replace old project with new one)
                                                                <i class='bi bi-arrow-up'></i>
                                                            </button>
                                                        </form>
                                                        <form action='helpers/products_transfer_to_shop.php' method='POST' class='toShopForm col-4'>
                                                            <input type='hidden' name='id' value='{$row['id']}'>
                                                            <input type='hidden' name='max' value='{$row['warehouse']}'>
                                                            <input type='hidden' name='amount' value='0'>
<<<<<<< HEAD
                                                            <button type='submit' class='btn btn-success'>
=======
                                                            <button type='submit' class='btn btn-success'
                                                                data-bs-toggle='tooltip' data-bs-placement='top'
                                                                data-bs-title='Move to shop'>
>>>>>>> d1ece8a (replace old project with new one)
                                                                <i class='bi bi-arrow-down'></i>
                                                            </button>
                                                        </form>
                                                        <div class='col-4'>
<<<<<<< HEAD
                                                            <button class='btn btn-danger openSubStockModal'>
                                                                <i class='bi bi-dash-circle'></i>
=======
                                                            <button class='btn btn-primary openSubStockModal'
                                                                data-bs-toggle='tooltip' data-bs-placement='top'
                                                                data-bs-title='Pack product'>
                                                                <i class='bi bi-box-seam'></i>
>>>>>>> d1ece8a (replace old project with new one)
                                                            </button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>";
                                    }
                                    echo "</tbody>
                                        </table>";
                                } else {
                                    echo "<p>No products found.</p>";
                                }
                                #endregion
                                ?>
                                <!-- #region handle transfer_to_shop and transfer_to_warehouse -->
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            document.querySelectorAll('.toShopForm').forEach(function (form) {
                                                form.addEventListener('submit', function (event) {
                                                    event.preventDefault(); // Prevent default form submission
                                                    let max = parseInt(form.querySelector("[name='max']").value, 10);
                                                    if (max == 0) {
                                                        alert("No product is available in the warehouse");
                                                    } else {
                                                        let amount = parseInt(prompt('Enter amount:'), 10);
                                                        if (amount != null && amount != "" && !isNaN(amount)) {
                                                            if (amount <= max) {
                                                                form.querySelector("[name='amount']").value = amount;
                                                                form.submit(); // Submit the form if amount is correct
                                                            } else {
                                                                alert("Value must be less than " + max);
                                                            }
                                                        } else {
                                                            alert("Please enter a valid amount!");
                                                        }
                                                    }
                                                });
                                            });
                                            document.querySelectorAll('.toWarehouseForm').forEach(function (form) {
                                                form.addEventListener('submit', function (event) {
                                                    event.preventDefault(); // Prevent default form submission
                                                    let max = parseInt(form.querySelector("[name='max']").value, 10);
                                                    if (max == 0) {
                                                        alert("No product is available in the shop");
                                                    } else {
                                                        let amount = parseInt(prompt('Enter amount:'), 10);
                                                        if (amount != null && amount != "" && !isNaN(amount)) {
                                                            if (amount <= max) {
                                                                form.querySelector("[name='amount']").value = amount;
                                                                form.submit(); // Submit the form if amount is correct
                                                            } else {
                                                                alert("Value must be less than " + max);
                                                            }
                                                        } else {
                                                            alert("Please enter a valid amount!");
                                                        }
                                                    }
                                                });
                                            });
                                        });
                                    </script>
                                <!-- #endregion -->
                                <!-- #region Modal for subtracting product quantity -->
                                    <div class="modal fade" id="subStockModal" tabindex="-1" aria-labelledby="subStockModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content text-bg-dark">
                                                <div class="modal-header">
<<<<<<< HEAD
                                                    <h5 class="modal-title" id="subStockModalLabel">Subtract Stock Quantity</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="helpers/products_subtract_stock.php" method="POST" autocomplete="off">
                                                        <!-- amount -->
                                                        <div class="mb-3">
                                                            <label for="amount" class="form-label">Amount:</label>
                                                            <input type="number" id="amount" name="amount" class="form-control tbox" required>
=======
                                                    <h5 class="modal-title" id="subStockModalLabel">Pack Product</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="helpers/products_pack_product.php" method="POST" autocomplete="off">
                                                        <!-- #region Product Selection 1 -->
                                                            <div class="col-md-12 mb-3">
                                                                <label for="product_id_1" class="form-label">Product 1:</label>
                                                                <select id="product_id_1" name="product_id_1" class="form-select tbox" required onchange="updateMaxAmount()">
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
                                                        <!-- #endregion -->
                                                        <!-- #region Product Selection 2 -->
                                                            <div class="col-md-12 mb-3">
                                                                <label for="product_id_2" class="form-label">Product 2:</label>
                                                                <select id="product_id_2" name="product_id_2" class="form-select tbox" required onchange="updateMaxAmount()">
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
                                                        <!-- #endregion -->
                                                        <!-- amount -->
                                                        <div class="mb-3">
                                                            <label for="amount" class="form-label">Amount:</label>
                                                            <input type="number" id="packingAmount" name="amount" class="form-control tbox" required min="1">
>>>>>>> d1ece8a (replace old project with new one)
                                                        </div>
                                                        <!-- message -->
                                                        <div class="mb-3">
                                                            <label for="message" class="form-label">Message:</label>
                                                            <textarea id="message" name="message" class="form-control tbox"></textarea>
                                                        </div>
                                                        <input type="hidden" name="id" id="id">
                                                        <!-- Reset and Submit -->
                                                        <div class="d-flex justify-content-between">
                                                            <button type="reset" class="btn btn-danger">Reset</button>
<<<<<<< HEAD
                                                            <button type="submit" class="btn btn-danger">Subtract</button>
=======
                                                            <button type="submit" class="btn btn-primary">Record</button>
>>>>>>> d1ece8a (replace old project with new one)
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
<<<<<<< HEAD
=======
                                    <!-- #region ajax for fetching the max amount -->
                                        <script>
                                            function updateMaxAmount() {
                                                let product1 = document.getElementById("product_id_1").value;
                                                let product2 = document.getElementById("product_id_2").value;
                                                let amountInput = document.getElementById("packingAmount");

                                                if (product1 && product2) {
                                                    // Send AJAX request to fetch quantities
                                                    let xhr = new XMLHttpRequest();
                                                    xhr.open("POST", "helpers/products_get_product_quantity.php", true);
                                                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                                    xhr.onreadystatechange = function () {
                                                        if (xhr.readyState === 4 && xhr.status === 200) {
                                                            let response = JSON.parse(xhr.responseText);
                                                            if (response.success) {
                                                                let minQuantity = Math.min(response.quantity1, response.quantity2);
                                                                amountInput.max = minQuantity;
                                                                amountInput.value = minQuantity;
                                                            }
                                                        }
                                                    };
                                                    xhr.send("product1=" + product1 + "&product2=" + product2);
                                                }
                                            }
                                        </script>
                                    <!-- #endregion -->
>>>>>>> d1ece8a (replace old project with new one)
                                <!-- #endregion -->
                                <!-- #region Handling modal with javascript -->
                                    <script>
                                        document.querySelectorAll('.openSubStockModal').forEach(button => {
                                            button.addEventListener('click', function () {
                                                const row = this.closest('tr');

                                                // Get id from the table row
                                                const id = row.cells[0].textContent;
<<<<<<< HEAD
                                                const max = row.cells[3].textContent;
                                                // Set data in the modal
                                                document.getElementById('id').value = id;
                                                document.getElementById('amount').max = max;
=======
                                                // Set data in the modal
                                                document.getElementById('id').value = id;
>>>>>>> d1ece8a (replace old project with new one)

                                                // Show the modal
                                                subModal = new bootstrap.Modal(document.getElementById('subStockModal'));
                                                subModal.show();
                                            });
                                        });
                                    </script>
                                <!-- #endregion -->
                            <!-- #endregion -->
                        </div>
                        <div class="tab-pane fade" id="accessories" role="tabpanel" aria-labelledby="accessories-tab">
<<<<<<< HEAD
                            <table class="table table-dark">
                                <thead>
                                    <tr style='position: sticky;top:0px;'>
                                        <th>id</th>
                                        <th>Product name</th>
                                        <th>Amount</th>
                                        <th>Total price</th>
                                        <th>Message</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $accessoriesLog = $conn->query("SELECT al.*, products.name as product_name FROM accessories_log al
                                                                        JOIN products ON product_id = products.id
                                                                        ORDER BY date DESC");
        
                                        if ($accessoriesLog->num_rows > 0) {
                                            while ($row = $accessoriesLog->fetch_assoc()) {
                                                echo "<tr>
                                                        <td>" . $row['id'] . "</td>
                                                        <td>" . $row['product_name'] . "</td>
                                                        <td>" . $row['amount'] . "</td>
                                                        <td class='usdnum'>" . $row['total_price'] . "</td>
                                                        <td>" . $row['message'] . "</td>
                                                        <td>" . $row['date'] . "</td>
                                                    </tr>";
                                            }
                                        } else {
                                            echo "<p>No accessories log found.</p>";
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="transfer" role="tabpanel" aria-labelledby="transfer-tab">
                            <table class="table table-dark">
                                <thead>
                                    <tr style='position: sticky;top:0px;'>
                                        <th>id</th>
                                        <th>Product name</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Destination</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $transferLog = $conn->query("SELECT tl.*, products.name as product_name FROM stock_transfers tl
                                                                        JOIN products ON product_id = products.id
                                                                        ORDER BY transfer_date DESC");
        
                                        if ($transferLog->num_rows > 0) {
                                            while ($row = $transferLog->fetch_assoc()) {
                                                $destination_name = ($row['destination'] == "warehouse")
                                                    ? "<i class='bi bi-arrow-up bg-warning'></i> Warehouse"
                                                    : "<i class='bi bi-arrow-down bg-success'></i> Shop";
                                                echo "<tr>
                                                        <td>" . $row['id'] . "</td>
                                                        <td>" . $row['product_name'] . "</td>
                                                        <td>" . $row['quantity'] . "</td>
                                                        <td>" . $row['transfer_date'] . "</td>
                                                        <td>" . $destination_name . "</td>
                                                    </tr>";
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
=======
                            <!-- #region accessories log tab -->
                                <?php
                                    $accessoriesLog = $conn->query("SELECT al.*, products.name as product_name FROM accessories_log al
                                                                    JOIN products ON product_id = products.id
                                                                    ORDER BY date DESC");

                                    if ($accessoriesLog->num_rows > 0) {
                                        echo '
                                        <table class="table table-dark">
                                            <thead>
                                                <tr style="position: sticky;top:0px;">
                                                    <th>id</th>
                                                    <th>Product name</th>
                                                    <th>Amount</th>
                                                    <th>Total price</th>
                                                    <th>Message</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                                                while ($row = $accessoriesLog->fetch_assoc()) {
                                                    echo "
                                                <tr>
                                                    <td>" . $row['id'] . "</td>
                                                    <td>" . $row['product_name'] . "</td>
                                                    <td>" . $row['amount'] . "</td>
                                                    <td class='usdnum'>" . $row['total_price'] . "</td>
                                                    <td>" . $row['message'] . "</td>
                                                    <td>" . $row['date'] . "</td>
                                                </tr>";
                                                }
                                        echo '
                                            </tbody>
                                        </table>';
                                    } else {
                                        echo "<p>No accessories log found.</p>";
                                    }
                                ?>
                            <!-- #endregion -->
                        </div>
                        <div class="tab-pane fade" id="transfer" role="tabpanel" aria-labelledby="transfer-tab">
                            <!-- #region transfer log tab -->
                                <?php
                                    $transferLog = $conn->query("SELECT tl.*, products.name as product_name FROM stock_transfers tl
                                                                    JOIN products ON product_id = products.id
                                                                    ORDER BY transfer_date DESC");
    
                                    if ($transferLog->num_rows > 0) {
                                        echo '
                                        <table class="table table-dark">
                                            <thead>
                                                <tr style="position: sticky;top:0px;">
                                                    <th>id</th>
                                                    <th>Product name</th>
                                                    <th>Amount</th>
                                                    <th>Date</th>
                                                    <th>Destination</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                                                while ($row = $transferLog->fetch_assoc()) {
                                                    $destination_name = ($row['destination'] == "warehouse")
                                                        ? "<i class='bi bi-arrow-up bg-warning'></i> Warehouse"
                                                        : "<i class='bi bi-arrow-down bg-success'></i> Shop";
                                                    echo "<tr>
                                                            <td>" . $row['id'] . "</td>
                                                            <td>" . $row['product_name'] . "</td>
                                                            <td>" . $row['quantity'] . "</td>
                                                            <td>" . $row['transfer_date'] . "</td>
                                                            <td>" . $destination_name . "</td>
                                                        </tr>";
                                                }
                                        echo '
                                            </tbody>
                                        </table>';
                                    } else {
                                        echo '<p>No transfer log found.</p>';
                                    }
                                ?>
                            <!-- #endregion -->
>>>>>>> d1ece8a (replace old project with new one)
                        </div>
                    </div>
                <!-- #endregion -->
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
    document.getElementById("sidebarProducts").classList.add("active");
    </script>
<!-- #endregion -->