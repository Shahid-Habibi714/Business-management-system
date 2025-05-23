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
<<<<<<< HEAD
            <div class="d-flex flex-column align-items-center justify-content-center pb-5">
=======
            <div class="d-flex flex-column align-items-center justify-content-center pb-5 round" style="box-shadow: 0px -10px 10px rgba(0,0,0,0.5);margin-top:-20px;background:var(--bg);">
>>>>>>> d1ece8a (replace old project with new one)
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
<<<<<<< HEAD
                                const name = customer.querySelector("div h5").innerHTML.toLowerCase(); // Customer Name
=======
                                const name = customer.querySelector("div h3").innerHTML.toLowerCase(); // Customer Name
>>>>>>> d1ece8a (replace old project with new one)

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
<<<<<<< HEAD
                                echo "<div class='col-3 p-3 customer-card my-2' style='position:relative;'>";
                                    if ($row["loan"] == "0") {
                                        echo "<h1 style='position:absolute;top:5%;left:50%;transform:translate(-50%,-50%);font-size:45px;text-align:center;border-radius: 50%;width:50px;height:50px;background: var(--successF);'><i class='bi bi-check' style='color:white;'></i></h1>";
                                    }
                                    echo "<div class='text-bg-dark w-100 text-center p-3 h-100 round'>";
=======
                                echo "<div class='col-3 p-3 customer-card my-2 hover-zoom' style='position:relative;'>";
                                    if ($row["loan"] == "0") {
                                        echo "<h1 style='position:absolute;top:5%;left:50%;transform:translate(-50%,-50%);font-size:45px;text-align:center;border-radius: 50%;width:50px;height:50px;background: var(--successF);z-index:1'><i class='bi bi-check' style='color:white;'></i></h1>";
                                    }
                                    echo "<div class='text-bg-dark w-100 text-center p-3 h-100 round shadow'>";
>>>>>>> d1ece8a (replace old project with new one)
                                        echo "<i class='bi bi-person-circle' style='font-size: 5em;'></i>";
                                        echo "<h3>" . $row["name"] . "</h3>";
                                        echo "<p style='color:rgba(255,255,255,0.5);'>Loan: <span class='afnnum'>" . number_format($row['loan'], 2) . "</span></p>";
                                        echo "<a href='customer_details.php?id=" . $row["id"] . "' class='btn btn-primary'>Details</a>";
<<<<<<< HEAD
=======
                                        $disabledDeleteButton = ($row["loan"] == "0") ? "" : "disabled";
                                        echo "
                                        <button class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#deleteModal' data-id='" . $row["id"] . "' $disabledDeleteButton>
                                            <i class='bi bi-trash'></i>
                                        </button>";
>>>>>>> d1ece8a (replace old project with new one)
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
<<<<<<< HEAD
=======
        <!-- #region Modal for deleting a customer -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content text-bg-dark round">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Delete Customer</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete the customer?</p>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-success mx-2" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                <form method='POST' action='helpers/customers_delete_customer.php' style='display:inline;'>
                                    <input type='hidden' name='customer_id'>
                                    <input type='submit' class='btn btn-danger' value='Delete' $disabledDeleteButton>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- #endregion -->
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const deleteModal = document.getElementById("deleteModal");
                deleteModal.addEventListener("show.bs.modal", function (event) {
                    const button = event.relatedTarget; // Button that triggered the modal
                    const customerId = button.getAttribute("data-id"); // Get customer ID
                    deleteModal.querySelector("input[name='customer_id']").value = customerId; // Set the hidden input value
                });
            });
        </script>
>>>>>>> d1ece8a (replace old project with new one)
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