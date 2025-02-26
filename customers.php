<?php
#region include files
// Include the database connection file
include('includes/db_connect.php');
// Include the header file
include('includes/header.php');
#endregion
?>


<!-- #region body -->
    <div class="mb-auto">
        <!-- #region adding new customer -->
            <form method="POST" action="helpers/customers_add_customer.php" autocomplete="off" class="d-flex align-items-center justify-content-center text-bg-dark w-100" style="height: 500px;">
                <div class="col-4 flex-column d-flex align-items-center">
                    <i class='bi bi-person-circle' style='font-size: 5em;'></i>
                    <h2 class="text-center">Add New Customer</h2>
                    <input type="text" name="customer_name" class="form-control me-2 mb-3 tbox" placeholder="Customer Name" required>
                    <input type="tel" name="customer_phone" class="form-control me-2 mb-3 tbox" placeholder="Phone Number" required>
                    <textarea name="customer_address" class="form-control me-2 mb-3 tbox" style="resize: none;" placeholder="Physical Address" required></textarea>
                    <input type="submit" class="btn btn-primary mb-3 w-100" value="Add">
                </div>
            </form>
        <!-- #endregion -->
        <!-- #region showing customers -->
            <div class="d-flex flex-column align-items-center justify-content-center pb-5">
                <h2 class="py-5">Customers</h2>
                <!-- #region Filters Section -->
                    <h4 class="mt-3">Filter</h4>
                    <div class="col-6 mb-3 d-flex gap-2">
                        <input type="text" id="search" class="form-control tbox" placeholder="Customer Name" style="flex: 3;">
                        <button id="resetFilter" class="btn btn-danger" style="flex: 1;">Reset</button>
                    </div>
                    <script>
                        // Live Search
                        document.getElementById('search').addEventListener('input', filterCustomers);
                        // Reset Filter
                        document.getElementById('resetFilter').addEventListener('click', () => {
                            document.getElementById('search').value = '';
                            filterCustomers(); // Reset the customers display
                        });

                        function filterCustomers() {
                            const searchValue = document.getElementById('search').value.toLowerCase();
                            const all_customers = document.querySelectorAll('.customer-card');

                            all_customers.forEach(customer => {
                                const name = customer.querySelector("div h5").innerHTML.toLowerCase(); // Customer Name

                                const matchesSearch = name.includes(searchValue);

                                if (matchesSearch) {
                                    customer.style.display = ''; // Show customer
                                } else {
                                    customer.style.display = 'none'; // Hide customer
                                }
                            });
                        }
                    </script>
                <!-- #endregion -->
                <div class="row w-100 px-5">
                    <?php
                        // Get all customers from the customers table
                        $result = $conn->query("SELECT * FROM customers");

                        // Check if there are any customers
                        if ($result->num_rows > 0) {
                            // Output data of each row
                            while($row = $result->fetch_assoc()) {
                                echo "<div class='col-3 p-3 customer-card my-2' style='position:relative;'>";
                                    if ($row["loan"] == "0") {
                                        echo "<h1 style='position:absolute;top:5%;left:50%;transform:translate(-50%,-50%);font-size:45px;text-align:center;border-radius: 50%;width:50px;height:50px;background: var(--successF);'><i class='bi bi-check' style='color:white;'></i></h1>";
                                    }
                                    echo "<div class='text-bg-dark w-100 text-center p-3 h-100 round'>";
                                        echo "<i class='bi bi-person-circle' style='font-size: 5em;'></i>";
                                        echo "<h3>" . $row["name"] . "</h3>";
                                        echo "<p style='color:rgba(255,255,255,0.5);'>Loan: <span class='afnnum'>" . number_format($row['loan'], 2) . "</span></p>";
                                        echo "<a href='customer_details.php?id=" . $row["id"] . "' class='btn btn-primary'>Details</a>";
                                    echo "</div>";
                                echo "</div>";
                            }
                        } else {
                            echo "<div class='col-3 p-3'>";
                                echo "<div class='text-bg-dark w-100 text-center p-3 h-100'>";
                                    echo "<h4 class='pb-4'>No customer found</h4>";
                                echo "</div>";
                            echo "</div>";
                        }
                    ?>
                </div>
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
    document.getElementById("sidebarCustomers").classList.add("active");
    </script>
<!-- #endregion -->