<?php
// Include the database connection file
include('includes/db_connect.php');
// Include the header file
include('includes/header.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $product_name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = !empty($_POST['description']) ? mysqli_real_escape_string($conn, $_POST['description']) : NULL;
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $currency = mysqli_real_escape_string($conn, $_POST['currency']);
    $custom_currency = !empty($_POST['custom_currency']) ? mysqli_real_escape_string($conn, $_POST['custom_currency']) : NULL;
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);
    $supplier_id = mysqli_real_escape_string($conn, $_POST['supplier_id']);

    // If the custom currency is set, use that as the currency
    if ($currency == "Other" && $custom_currency) {
        $currency = $custom_currency;
    }

    // Prepare the SQL query to insert the data using prepared statements
    $stmt = $conn->prepare("INSERT INTO products (name, description, price, currency, stock, supplier_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdssi", $product_name, $description, $price, $currency, $stock, $supplier_id);

    // Execute the query and check if successful
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>New product added successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }
    $stmt->close();
}
?>

<div class="p-5 flex-column mb-auto">
    <h2>Add New Product</h2>
    <form action="add_product.php" method="POST" autocomplete="off" class="row">
        <!-- Product Name and Supplier in the first column -->
        <div class="col-md-6 mb-3">
            <label for="name" class="form-label">Product Name:</label>
            <input type="text" id="name" name="name" class="form-control bg-transparent text-white" required>
        </div>

        <div class="col-md-6 mb-3">
            <label for="supplier_id" class="form-label">Supplier:</label>
            <select id="supplier_id" name="supplier_id" class="form-select text-bg-dark" required>
                <option value="" disabled selected>Select a supplier</option>
                <?php
                // Fetch suppliers from the supplier table
                $result = mysqli_query($conn, "SELECT id, name FROM supplier");
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                }
                ?>
            </select>
        </div>

        
    
        <!-- Price, Currency, and Custom Currency as a Single Input Group -->
        <div class="col-md-6 mb-3">
            <label for="price" class="form-label">Price:</label>
            <div class="input-group d-flex">
                <!-- Currency Select (fixed width) -->
                <select id="currency" name="currency" class="form-select text-bg-dark" required onchange="toggleCustomCurrencyField()" style="flex-shrink: 0; width: 100px;">
                    <option value="USD">USD</option>
                    <option value="AFN">AFN</option>
                    <option value="Other">Other</option>
                </select>

                <!-- Custom Currency Input (appears when "Other" is selected) -->
                <input type="text" id="custom_currency" name="custom_currency" class="form-control bg-transparent text-white" style="display: none;">

                <!-- Price Input (flexible width) -->
                <input type="number" id="price" name="price" class="form-control bg-transparent text-white flex-grow-1" required>
            </div>

        </div>

        <!-- Stock Quantity -->
        <div class="col-md-6 mb-3">
            <label for="stock" class="form-label">Stock Quantity:</label>
            <input type="number" id="stock" name="stock" class="form-control bg-transparent text-white" required>
        </div>

        <!-- Description field spanning full width -->
        <div class="col-md-12 mb-3">
            <label for="description" class="form-label">Description:</label>
            <textarea id="description" name="description" class="form-control bg-transparent text-white"></textarea>
        </div>

        <button type="reset" class="btn btn-danger col-md-6 mb-3">Reset</button>
        <button type="submit" class="btn btn-primary col-md-6 mb-3">Add Product</button>
    </form>
</div>



<?php
// Include the footer file
include('includes/footer.php');
?>

<script>
// Function to toggle the visibility of the custom currency input
function toggleCustomCurrencyField() {
    var currencySelect = document.getElementById("currency");
    var customCurrency = document.getElementById("custom_currency");

    if (currencySelect.value == "Other") {
        customCurrency.style.display = "block";  // Show custom currency field
    } else {
        customCurrency.style.display = "none";   // Hide custom currency field
    }
}
// Activate the sidebar link
document.getElementById("sidebarAddProduct").classList.add("active");
</script>
