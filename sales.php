<?php
#region include files
// Include the database connection file
include('includes/db_connect.php');
// Include the header file
include('includes/header.php');
#endregion
?>





<!-- #region body -->
    <div class="p-5 d-flex flex-column mb-auto">
        <h2>Record Sale</h2>
        <form method="POST" action="helpers/sales_add_sale.php" autocomplete="off">
            <!-- Form Row -->
            <div class="d-flex justify-content-center text-bg-dark w-100 my-5 py-5 round shadow">
                <!-- #region custom style for customer selection radios -->
                    <style>
                        .btn-check-custom + .btn-primary {
                            border-radius: 10px;
                        }
                    </style>
                <!-- #endregion -->
                <!-- Single Time -->
                <div class="col-5 p-3">
                    <input type="radio" class="btn-check btn-check-custom" name="type-of-customer" id="single-time" autocomplete="off" checked onchange="toggleCustomerSelection()" value="single-time">
                    <label class="btn btn-primary my-3 fs-5" for="single-time"><i class="bi bi-check-lg"></i>Single Time</label><br>
                    <label for="customer_name" class="form-label">Customer Name</label>
                    <input type="text" id="customer_name" name="customer_name" class="form-control tbox" required>
                </div>
                <!-- Permanent Customer -->
                <div class="col-md-5 p-3">
                    <input type="radio" class="btn-check btn-check-custom" name="type-of-customer" id="permanent-customer" autocomplete="off" onchange="toggleCustomerSelection()" value="permanent-customer">
                    <label class="btn btn-primary my-3 fs-5" for="permanent-customer"><i class="bi bi-check-lg"></i>Permanent Customer</label><br>
                    <label for="permanent_customer_name" class="form-label">Customer Name</label>
                    <select name="permanent_customer_name" id="permanent_customer_name" class="form-control tbox" required>
                        <option value="" disabled selected>Select a customer</option>
                        <?php 
                            // Fetch all customers for the customer dropdown
                            $customer_name_result = $conn->query("SELECT * FROM customers");
                            while ($row = $customer_name_result->fetch_assoc()) {
                                echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                            }
                        ?>
                    </select>
                    <input type="checkbox" class="btn-check" name="loan-check" id="loan-check" autocomplete="off">
                    <label class="btn btn-primary my-3" for="loan-check"><i class="bi bi-check-lg"></i>Mark as loan</label>
                </div>
                <!-- #region javascript logic to handle customer type selection -->
                    <script>
                        function toggleCustomerSelection() {
                            var singleTime = document.getElementById("single-time");
                            var permanentCustomer = document.getElementById("permanent-customer");
                            var customerName = document.getElementById("customer_name");
                            var customerNameDropdown = document.getElementById("permanent_customer_name");
                            var loanCheck = document.getElementById("loan-check");

                            if (singleTime.checked) {
                                customerNameDropdown.disabled = true;
                                loanCheck.disabled = true;
                                customerName.disabled = false;
                            } else if (permanentCustomer.checked) {
                                customerNameDropdown.disabled = false;
                                loanCheck.disabled = false;
                                customerName.disabled = true;
                            }
                        }
                        toggleCustomerSelection(); // Call the function to set the initial state
                    </script>
                <!-- #endregion -->
            </div>
            <!-- #region product row -->
                <div class="row mb-3 align-items-end product-section text-bg-dark py-5 px-1 round shadow">
                    <div class="product-item row mb-3">
                        <!-- Product -->
                        <div class="col-md-6">
                            <label for="product_id[]" class="form-label">Product</label>
                            <select name="product_id[]" id="product_id[]" class="form-control tbox" required onchange="fetchStockQuantity(this)">
                                <option value="" disabled selected>Select a product</option>
                                <?php 
                                    // Fetch all products for the product dropdown
                                    $product_result = $conn->query("SELECT * FROM products");
                                    while ($row = $product_result->fetch_assoc()) {
                                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                    }
                                ?>
                            </select>
                        </div>

                        <!-- Quantity -->
                        <div class="col-md-2">
                            <label for="quantity[]" class="form-label">Quantity</label>
                            <input type="number" name="quantity[]" id="quantity[]" class="form-control tbox" required min="1">
                        </div>

                        <!-- In Stock -->
                        <div class="col-md-1">
                            <label for="in_stock[]" class="form-label">In Stock</label>
                            <input type="text" name="in-stock[]" id="in-stock[]" class="form-control tbox" readonly>
                        </div>

                        <!-- #region fetch the stock quantity from the products table -->
                            <script>
                                function fetchStockQuantity(dropdown) {
                                    var product_id = dropdown.value;

                                    // Find the parent row containing all inputs
                                    var row = dropdown.closest(".product-item");
                                    var stockInput = row.querySelector("[name='in-stock[]']");
                                    var quantityInput = row.querySelector("[name='quantity[]']");

                                    var xhr = new XMLHttpRequest();
                                    // Prevent caching by appending a random query parameter
                                    xhr.open("GET", "helpers/sales_fetch_stock_from_products.php?product_id=" + product_id + "&_=" + new Date().getTime(), true);
                                    xhr.onreadystatechange = function() {
                                        if (xhr.readyState === 4 && xhr.status === 200) {
                                            var data = JSON.parse(xhr.responseText);

                                            // Update the stock and max quantity dynamically
                                            stockInput.value = data.stock;
                                            quantityInput.max = data.stock;
                                        }
                                    };
                                    xhr.send();
                                }
                            </script>
                        <!-- #endregion -->

                        <!-- Price -->
                        <div class="col-md-2">
                            <label for="price[]" class="form-label">Price</label>
                            <input type="number" id="price[]" name="price[]" class="form-control tbox" required>
                        </div>

                        <div class="col-md-1">
                            <label for="delete[]" class="form-label">delete</label>
                            <button type="button" class="btn btn-danger deleteRow" disabled>
                                <i class="bi bi-trash-fill" id="delete[]"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <!-- #endregion -->

            <!-- Buttons (Add Product and Submit) -->
            <div class="row">
                <div class="col-md-12">
                    <button type="button" id="addProduct" class="btn btn-secondary">Add Product</button>
                    <button type="submit" class="btn btn-primary">Record Sale</button>
                </div>
            </div>
        </form>
        <!-- #region adding and removing new product row -->
            <script>
                document.getElementById("addProduct").addEventListener("click", function () {
                    // Clone the product row
                    const productSection = document.querySelector(".product-section");
                    const newRow = productSection.querySelector(".product-item").cloneNode(true);

                    // Clear values in the new row
                    newRow.querySelector('input[name="price[]"]').value = '';
                    newRow.querySelector('input[name="quantity[]"]').value = '';
                    newRow.querySelector('input[name="in-stock[]"]').value = '';
                    
                    // new row delete-button
                    newRow.querySelector(".deleteRow").addEventListener("click", function() {
                        this.closest(".product-item").remove();
                    });
                    newRow.querySelector(".deleteRow").disabled = false;

                    // add the new product row to the page
                    productSection.appendChild(newRow);
                });
            </script>
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
    document.getElementById("sidebarSales").classList.add("active");
    </script>
<!-- #endregion -->