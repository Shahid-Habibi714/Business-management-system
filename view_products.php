<?php
// Include the database connection
include 'includes/db_connect.php';
// Include the header file
include('includes/header.php');
?>
<div class="p-5 flex-column mb-auto">
    <h2>All Products</h2>

    <!-- Filters Section -->
    <div class="mb-3 d-flex gap-3">
        <!-- Search Field -->
        <input type="text" id="search" class="form-control" placeholder="Search by product name or description" style="flex: 2;">
        <!-- Date Filter -->
        <input type="date" id="filterDate" class="form-control" style="flex: 1;" placeholder="Filter by date">
        <!-- Reset Button -->
        <button id="resetFilters" class="btn btn-secondary" style="flex: 0;">Reset</button>
    </div>

    <?php
    // Fetch all products
    $sql = "SELECT * FROM products ORDER BY created_at DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output each product in a table
        echo "<table id='productsTable' class='table table-bordered table-striped'>
                <thead class=\"table-dark\">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Currency</th>
                        <th>Stock</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>".$row['id']."</td>
                    <td>".htmlspecialchars($row['name'])."</td>
                    <td>".htmlspecialchars($row['description'])."</td>
                    <td>".$row['price']."</td>
                    <td>".$row['currency']."</td>
                    <td>".$row['stock']."</td>
                    <td>".$row['created_at']."</td>
                  </tr>";
        }
        echo "</tbody>
            </table>";
    } else {
        echo "<div class='alert alert-warning'>No products found.</div>";
    }

    $conn->close();
    ?>
</div>

<!-- Include the footer file -->
<?php include('includes/footer.php'); ?>

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
        const createdAt = row.cells[6].textContent; // Created At

        const matchesSearch = name.includes(searchValue) || description.includes(searchValue);
        const matchesDate = filterDate === '' || createdAt.startsWith(filterDate);

        if (matchesSearch && matchesDate) {
            row.style.display = ''; // Show row
        } else {
            row.style.display = 'none'; // Hide row
        }
    });
}

// Activate the sidebar link
document.getElementById("sidebarViewProducts").classList.add("active");
</script>
