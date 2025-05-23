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
    <div class="p-5">
        <h1>Rejected Sales</h1>
        <hr>
        <!-- #region Adding a new rejection -->
            <form method="POST" action="helpers/rejected_sales_add_rejection.php" class="row text-bg-dark p-5 round shadow">
                <h2>Add Item</h2>
                <!-- Select Bill -->
                <div class="col-2 mb-3">
                    <label for="sale_id" class="form-label">Bill Number</label>
                    <input type="number" id="sale_id" name="sale_id" class="form-control tbox" required oninput="fetchProducts()">
                </div>

                <!-- Select Product In The Bill -->
                <div class="col-6 mb-3">
                    <label for="product_id" class="form-label">Select Product</label>
                    <select id="product_id" name="product_id" class="form-control tbox" required oninput="fetchSoldQuantity()">
                        <option value="" selected disabled>Choose a Product</option>
                    </select>
                </div>

                <!-- Quantity -->
                <div class="col-2 mb-3">
                    <label for="quantity" class="form-label">Rejected Quantity</label>
                    <input type="number" id="quantity" name="quantity" class="form-control tbox" required min="1">
                </div>

                <!-- Rejectable -->
                <div class="col-2 mb-3">
                    <label for="rejectable" class="form-label">Rejectable</label>
                    <input type="number" id="rejectable" name="rejectable" class="form-control tbox" readonly>
                </div>

                <!-- Restock Quantity -->
                <div class="col-3 mb-3">
                    <label for="restock_quantity" class="form-label">Restock Quantity</label>
                    <input type="number" id="restock_quantity" name="restock_quantity" class="form-control tbox" required min="0" value="0">
                </div>

                <!-- Resell Quantity -->
                <div class="col-3 mb-3">
                    <label for="resell_quantity" class="form-label">Resell Quantity</label>
                    <input type="number" id="resell_quantity" name="resell_quantity" class="form-control tbox" required min="0" value="0">
                </div>

                <!-- Resell Price -->
                <div class="col-3 mb-3">
                    <label for="resell_price" class="form-label">Resell Price</label>
                    <input type="number" id="resell_price" name="resell_price" class="form-control tbox" step="0.01" required value="0.00">
                </div>

                <!-- Submit button -->
                <div class="col-3 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Submit Rejection</button>
                </div>
            </form>
        <!-- #endregion -->

        <!-- #region fetching the data for auto-filling before form submission -->
            <script>
                // #region fetch products by bill number
                    function fetchProducts() {
                        var sale_id = document.getElementById("sale_id").value;

                        // Ensure sale_id is selected before making the request
                        if (sale_id) {
                            var xhr = new XMLHttpRequest();
                            xhr.open("GET", "helpers/rejected_sales_fetch_name_from_products.php?sale_id=" + sale_id, true);
                            xhr.onreadystatechange = function() {
                                if (xhr.readyState == 4 && xhr.status == 200) {
                                    console.log("Raw Response:", xhr.responseText); // Log the raw response
                                    var products = JSON.parse(xhr.responseText);
                                    var productDropdown = document.getElementById("product_id");

                                    // Clear previous options
                                    productDropdown.innerHTML = "<option value='' selected disabled>Choose a Product</option>";

                                    // Populate the dropdown with products
                                    products.forEach(function(product) {
                                        var option = document.createElement("option");
                                        option.value = product.id;
                                        option.textContent = product.name;
                                        productDropdown.appendChild(option);
                                    });
                                }
                            };
                            xhr.send();
                        }
                    }
                // #endregion

                // #region fetch rejectable quantity by a product from a bill
                    let remaining_rejected_quantity = 0;
                    function fetchSoldQuantity() {
                        var sale_id = document.getElementById("sale_id").value;
                        var product_id = document.getElementById("product_id").value;

                        // Ensure both sale_id and product_id are selected before making the request
                        if (sale_id && product_id) {
                            var xhr = new XMLHttpRequest();
                            xhr.open("GET", "helpers/rejected_sales_fetch_quantity_from_sales.php?sale_id=" + sale_id + "&product_id=" + product_id, true);
                            xhr.onreadystatechange = function() {
                                if (xhr.readyState == 4 && xhr.status == 200) {
                                    var data = JSON.parse(xhr.responseText);
                                    remaining_rejected_quantity = data.remaining_rejected_quantity;
                                    document.getElementById("rejectable").value = remaining_rejected_quantity;
                                    document.getElementById("quantity").max = remaining_rejected_quantity;
                                }
                            };
                            xhr.send();
                        }
                    }
                // #endregion
            </script>
        <!-- #endregion -->

        <hr class="my-5">

        
        <!-- #region Display Rejected Sale Items -->
            <h2>Rejected Sale Items</h2>

            <!-- #region filter by time -->
                <div class="my-3 py-5 text-bg-dark text-center round shadow">
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
                                const tableRows = document.querySelectorAll("#rejected-sales-table tbody tr");

                                // Get the current date
                                const currentDate = new Date();

                                // Filter the table rows based on the selected radio button
                                tableRows.forEach(row => {
<<<<<<< HEAD
                                    const rejectionDate = new Date(row.cells[11].textContent);
=======
                                    const rejectionDate = new Date(row.cells[12].textContent);
>>>>>>> d1ece8a (replace old project with new one)
                                    const daysDifference = Math.ceil((currentDate - rejectionDate) / (1000 * 60 * 60 * 24));
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
            <!-- #region Filter by column -->
                <div class="mb-3 d-flex flex-column text-bg-dark p-5 round shadow">
                    <h2 class="pb-3">Filter a column</h2>
                    <div class="row mb-3">
                        <!-- Filter by bill number -->
                        <div class="col-md-2">
                            <input type="number" id="searchBillNo" class="form-control tbox" placeholder="Bill Number">
                        </div>
                        <!-- Search by product name -->
                        <div class="col-md-6">
                            <input type="text" id="searchName" class="form-control tbox" placeholder="Customer Name">
                        </div>
                        <!-- Date Filter -->
                        <div class="col-md-2">
                            <input type="date" id="filterDate" class="form-control tbox" onfocus="this.showPicker()">
                        </div>
                        <!-- Reset Button -->
                        <div class="col-md-2">
                            <button id="resetFilters" class="btn btn-danger w-100">Reset</button>
                        </div>
                    </div>
                </div>
                <!-- filtering javascript logic -->
                    <script>
                        // Get the filter elements
                        document.getElementById('searchBillNo').addEventListener('input', filterTable);
                        document.getElementById('searchName').addEventListener('input', filterTable);
                        document.getElementById('filterDate').addEventListener('input', filterTable);

                        // Reset Filters
                        document.getElementById('resetFilters').addEventListener('click', () => {
                            document.getElementById('searchBillNo').value = '';
                            document.getElementById('searchName').value = '';
                            document.getElementById('filterDate').value = '';
                            filterTable(); // Reset the table display
                        });

                        function filterTable() {
                            const searchBillNoValue = document.getElementById('searchBillNo').value;
                            const searchNameValue = document.getElementById('searchName').value.toLowerCase();
                            const filterDate = document.getElementById('filterDate').value;
                            const tableRows = document.querySelectorAll('#rejected-sales-table tbody tr');

                            tableRows.forEach(row => {
                                const billNo = row.cells[1].textContent; // Bill Number
                                const name = row.cells[2].textContent.toLowerCase(); // Customer Name
                                const rejectionDate = row.cells[11].textContent; // Rejection Date

                                const matchesBillNo = billNo.includes(searchBillNoValue);
                                const matchesSearch = name.includes(searchNameValue);
                                const matchesDate = filterDate === '' || rejectionDate.startsWith(filterDate);

                                if (matchesBillNo && matchesSearch && matchesDate) {
                                    row.style.display = ''; // Show row
                                } else {
                                    row.style.display = 'none'; // Hide row
                                }
                            });
                        }
                    </script>
                <!-- #endregion -->
            <!-- #endregion -->
            
            <table class="table table-dark w-100" id="rejected-sales-table">
                <thead class="table-dark">
                    <tr style="position: sticky;top:0px;">
                        <th>ID</th>
                        <th>Bill Number</th>
                        <th>Product</th>
                        <th>Rejected Quantity</th>
                        <th>Restocked</th>
                        <th>Resold</th>
                        <th>Resold Price</th>
                        <th>Total Amount</th>
                        <th>Loss per Item</th>
                        <th>Total Loss</th>
                        <th>Purchase Date</th>
                        <th>Sold Date</th>
                        <th>Rejection Date</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = $conn->query("
                        SELECT r.*, p.name AS product_name, p.last_purchase AS purchase_date
                        FROM rejected_sales r
                        JOIN products p ON r.product_id = p.id
                        ORDER BY id DESC
                    ");
                
                    while ($row = $result->fetch_assoc()) {
                        $currency_id = $row['currency_id'];
                        if ($currency_id) {
                            $currency_stmt = $conn->prepare("SELECT rate FROM currency WHERE id = ? LIMIT 1");
                            $currency_stmt->bind_param("i", $currency_id);
                            $currency_stmt->execute();
                            $currency_result = $currency_stmt->get_result();
                            $currency_rate = ($currency_result->num_rows > 0) ? $currency_result->fetch_assoc()['rate'] : 1;
                            $currency_stmt->close();
                        } else {
                            $currency_rate = 1;
                        }
                        $resell_price_usd = $row['resell_price'] / $currency_rate;
                        $total_amount_usd = $row['total_amount'] / $currency_rate;
                        $loss_per_item_afn = $row['loss_per_item'] * $currency_rate;
                        $total_loss_afn = $row['total_loss'] * $currency_rate;
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['sale_id']}</td>
                            <td data-productId='{$row['product_id']}'>{$row['product_name']}</td>
                            <td>{$row['quantity']}</td>
                            <td>{$row['restock_quantity']}</td>
                            <td>{$row['resell_quantity']}</td>
                            <td><span class='usdnum'>" . number_format($resell_price_usd, 2) . "</span><br><span class='afnnum'>" . number_format($row['resell_price'], 2) . "</td>
                            <td><span class='usdnum'>" . number_format($total_amount_usd, 2) . "</span><br><span class='afnnum'>" . number_format($row['total_amount'], 2) . "</td>
                            <td><span class='usdnum'>" . number_format($row['loss_per_item'], 2) . "</span><br><span class='afnnum'>" . number_format($loss_per_item_afn, 2) . "</td>
                            <td><span class='usdnum'>" . number_format($row['total_loss'], 2) . "</span><br><span class='afnnum'>" . number_format($total_loss_afn, 2) . "</td>
                            <td>{$row['purchase_date']}</td>
                            <td>{$row['sold_date']}</td>
                            <td>{$row['rejection_date']}</td>
                            <td class='text-center align-middle'>
                                <button class='btn btn-sm btn-primary edit-btn'>
                                    <i class='bi bi-pencil-fill'></i>
                                </button>
                            </td>
                            <td class='d-none'>{$row['currency_id']}</td>
                            <td class='d-none'>{$row['resell_price']}</td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        <!-- #endregion -->
    </div>
<!-- #endregion -->


<!-- #region Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel">
        <div class="modal-dialog">
            <div class="modal-content text-bg-dark">
                <form id="editForm" action="helpers/rejected_sales_update_record.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Rejected Sale</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="editId" name="id">
                        <input type="hidden" id="editSaleId" name="sale_id">
                        <input type="hidden" id="editProductId" name="product_id">
                        <input type="hidden" id="editPreviousRestockedQuantity" name="previous_restocked_quantity">
                        <input type="hidden" id="editRejectedQuantity" name="rejected_quantity">
                        <input type="hidden" id="editRejectedCurrencyId" name="rejected_currency_id">
                        
                        <div class="mb-3">
                            <label for="editRestockQuantity" class="form-label">Restock Quantity</label>
                            <input type="number" id="editRestockQuantity" name="restock_quantity" class="form-control tbox" required min="0">
                        </div>
                        <div class="mb-3">
                            <label for="editResellQuantity" class="form-label">Resell Quantity</label>
                            <input type="number" id="editResellQuantity" name="resell_quantity" class="form-control tbox" required min="0">
                        </div>
                        <p id="modal-out-of">/</p>
                        <div class="mb-3">
                            <label for="editResellPrice" class="form-label">Resell Price</label>
                            <input type="number" id="editResellPrice" name="resell_price" class="form-control tbox" step="0.01" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- #endregion -->

<!-- #region javascript for updating a rejection -->
    <script>
    // modal for updating a rejected record
    var editModal;

    // Handle Edit Button Click
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function () {
            const row = this.closest('tr');

            // Get data from the table row
            const id = row.cells[0].textContent;
            const saleId = row.cells[1].textContent;
            const productId = row.cells[2].dataset.productid; // Use data attribute for product ID
            const restockQuantity = row.cells[4].textContent;
            const resellQuantity = row.cells[5].textContent;
            const rejectedQuantity = row.cells[3].textContent;
            const resellPrice = row.cells[15].textContent;
            const currencyId = row.cells[14].textContent;

            // Set data in the modal
            document.getElementById('editId').value = id;
            document.getElementById('editSaleId').value = saleId;
            document.getElementById('editProductId').value = productId;
            document.getElementById('editPreviousRestockedQuantity').value = restockQuantity;
            document.getElementById('editRejectedQuantity').value = rejectedQuantity;
            document.getElementById('editRestockQuantity').value = restockQuantity;
            document.getElementById('editResellQuantity').value = resellQuantity;
            document.getElementById('modal-out-of').innerHTML = "Total rejected quantity: " + rejectedQuantity;
            document.getElementById('editResellPrice').value = resellPrice;
            document.getElementById('editRejectedCurrencyId').value = currencyId;
            
            // Show the modal
            editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();
        });
    });
    </script>
<!-- #endregion -->




<!-- #region footer -->
    <?php
    // Include the footer file
    include('includes/footer.php');
    ?>

    <script>
    // Activate the sidebar link
    document.getElementById("sidebarRejectedSales").classList.add("active");
    </script>
<!-- #endregion -->