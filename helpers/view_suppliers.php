<?php
// Include the database connection file
include('includes/db_connect.php');
// Include the header file
include('includes/header.php');

// Fetch all suppliers
$sql = "SELECT * FROM supplier ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<div class="p-5 flex-column mb-auto">
    <h2 class="mb-4">Suppliers</h2>

    <?php if ($result->num_rows > 0): ?>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['phone']) ?></td>
                        <td><?= htmlspecialchars($row['address'] ?: 'N/A') ?></td>
                        <td><?= $row['created_at'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning">No suppliers found.</div>
    <?php endif; ?>

    <!-- Button to add a new supplier -->
    <a href="add_supplier.php" class="btn btn-primary mt-3">Add New Supplier</a>
</div>

<?php include('includes/footer.php'); ?>

<?php $conn->close(); ?>

<script>
// Activate the sidebar link
document.getElementById("sidebarViewSuppliers").classList.add("active");
</script>