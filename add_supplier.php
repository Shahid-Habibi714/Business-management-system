<?php
// Include the database connection file
include('includes/db_connect.php');
// Include the header file
include('includes/header.php');

// Initialize an empty message variable
$message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize inputs
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // Prepare SQL query to insert the new supplier
    $sql = "INSERT INTO supplier (name, phone, address, created_at)
            VALUES ('$name', '$phone', '$address', CURRENT_TIMESTAMP)";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        $message = "<div class='alert alert-success'>New supplier added successfully.</div>";
        
        // Redirect to the suppliers page after successful addition
        header("Location: view_suppliers.php");
        exit; // Ensure the script stops executing after the redirect
    } else {
        $message = "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}
?>

<div class="p-5 flex-column mb-auto">
    <h2 class="mb-4">Add New Supplier</h2>
    <?= $message; ?>

    <form action="add_supplier.php" method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea class="form-control" id="address" name="address" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add Supplier</button>
    </form>
</div>

<?php include('includes/footer.php'); ?>
<?php $conn->close(); ?>

<script>
// Activate the sidebar link
document.getElementById("sidebarAddSupplier").classList.add("active");
</script>