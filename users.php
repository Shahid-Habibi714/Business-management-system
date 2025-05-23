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
        <h1 class="pb-5 px-5">Users</h1>
        <!-- #region adding a new user -->
            <div class="d-flex justify-content-center pb-5">
                <button type="button" class="btn btn-primary round p-4 my-3 text-center" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="bi bi-plus-circle-fill fs-3"></i><br>Add New User
                </button>
            </div>
        <!-- #endregion -->
        <!-- #region Modal for adding a new user -->
            <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content text-bg-dark round">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="helpers/users_add_user.php" method="POST" autocomplete="off">
                                <!-- User Name -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">User Name:</label>
                                    <input type="text" id="name" name="name" class="form-control tbox" required>
                                </div>

                                <!-- Password -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password:</label>
                                    <input type="text" id="password" name="password" class="form-control tbox" required>
                                </div>

                                <!-- Role -->
                                <div class="mb-3">
                                    <label for="role" class="form-label">Role:</label>
                                    <select id="role" name="role" class="form-control tbox">
                                        <option value="Admin">Admin</option>
                                        <option value="Standard">Standard</option>
                                    </select>
                                </div>

                                <!-- Reset and Submit -->
                                <div class="d-flex justify-content-between">
                                    <button type="reset" class="btn btn-danger">Reset</button>
<<<<<<< HEAD
                                    <button type="submit" class="btn btn-primary">Add Product</button>
=======
                                    <button type="submit" class="btn btn-primary">Add User</button>
>>>>>>> d1ece8a (replace old project with new one)
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <!-- #endregion -->



        <hr class="py-5">
        <div class="row w-100">
            <?php
                // Get all customers from the customers table
                $result = $conn->query("SELECT * FROM users");

                // Check if there are any customers
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<div class='col-4 p-3 customer-card' style='position:relative;'>";
                            echo "<h3 style='position:absolute;top:5%;left:50%;transform:translate(-50%,-50%)' class='badge-" . (($row["role"] == "admin") ? "success" : "warning") . " px-3 py-1'>" . $row["role"] . "</h3>";
                            echo "<div class='text-bg-dark w-100 text-center p-3 pt-5 h-100 round'>";
                                echo "<i class='bi bi-person-circle' style='font-size: 5em;'></i>";
                                echo "<h4 class='pb-4'>" . ucFirst($row["username"]) . "</h4>";
                                echo "<h5 class='pb-4' style='color: rgba(255,255,255,0.5);'>Passowrd: " . $row["password"] . "</h5>";
<<<<<<< HEAD
                                echo "<button class='w-50 mb-3 btn btn-success'  data-bs-toggle='modal' data-bs-target='#changeModal' data-id='" . $row['id'] . "' data-user='" . $row['username'] . "' data-pass='" . $row['password'] . "' data-role='" . $row['role'] . "'>Change Credintials</button><br>";
=======
                                echo "<button class='w-50 mb-3 btn btn-success'  data-bs-toggle='modal' data-bs-target='#changeModal' data-id='" . $row['id'] . "' data-user='" . $row['username'] . "' data-pass='" . $row['password'] . "' data-role='" . $row['role'] . "' data-currentUser='" . (($_SESSION['username'] == $row['username']) ? "yes" : "no") . "'>Change Credintials</button><br>";
>>>>>>> d1ece8a (replace old project with new one)
                                echo "<button class='w-50 mb-3 btn btn-danger'  data-bs-toggle='modal' data-bs-target='#deleteModal' data-id='" . $row['id'] . "' " . (($_SESSION['username'] == $row['username']) ? "disabled" : "") . ">Delete Account</button>";
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
        <!-- #region Modal for updating a user -->
            <div class="modal fade" id="changeModal" tabindex="-1" aria-labelledby="changeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content text-bg-dark round">
                        <div class="modal-header">
                            <h5 class="modal-title" id="changeModalLabel">Update User's Credintials</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="helpers/users_update_user.php" method="POST" autocomplete="off">
                                <input type="hidden" id="updateId" name="id">
<<<<<<< HEAD
=======
                                <input type="hidden" id="currentUser" name="currentUser">
>>>>>>> d1ece8a (replace old project with new one)
                                <!-- User Name -->
                                <div class="mb-3">
                                    <label for="updateUsername" class="form-label">User Name:</label>
                                    <input type="text" id="updateUsername" name="updateUsername" class="form-control tbox" required>
                                </div>

                                <!-- Password -->
                                <div class="mb-3">
                                    <label for="updatePassword" class="form-label">Password:</label>
                                    <input type="text" id="updatePassword" name="updatePassword" class="form-control tbox" required>
                                </div>

                                <!-- Role -->
                                <div class="mb-3">
                                    <label for="updateRole" class="form-label">Role:</label>
                                    <select id="updateRole" name="updateRole" class="form-control tbox">
                                        <option value="admin">Admin</option>
                                        <option value="standard">Standard</option>
                                    </select>
                                </div>
                                
                                <!-- Reset and Submit -->
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-success mx-2" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                    <button type="submit" class="btn btn-danger mx-2">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var changeModal = document.getElementById('changeModal');
                    changeModal.addEventListener('show.bs.modal', function(event) {
                        var button = event.relatedTarget;
                        var id = button.getAttribute('data-id'); 
                        var user = button.getAttribute('data-user'); 
                        var pass = button.getAttribute('data-pass'); 
                        var role = button.getAttribute('data-role'); 
<<<<<<< HEAD
                        document.getElementById('updateId').value = id; 
                        document.getElementById('updateUsername').value = user; 
                        document.getElementById('updatePassword').value = pass; 
=======
                        var currentUser = button.getAttribute('data-currentUser');
                        document.getElementById('updateId').value = id; 
                        document.getElementById('updateUsername').value = user; 
                        document.getElementById('updatePassword').value = pass; 
                        document.getElementById('currentUser').value = currentUser; 
>>>>>>> d1ece8a (replace old project with new one)
                         // Set the correct role as selected
                        var roleSelect = document.getElementById('updateRole');
                        for (var i = 0; i < roleSelect.options.length; i++) {
                            if (roleSelect.options[i].value === role) {
                                roleSelect.options[i].selected = true;
                                break;
                            }
                        }
<<<<<<< HEAD
=======
                        if (currentUser == "yes") {
                            roleSelect.disabled = "true";
                        }
>>>>>>> d1ece8a (replace old project with new one)
                    });
                });
            </script>
        <!-- #endregion -->
        <!-- #region Modal for deleteing a user -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content text-bg-dark round">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Delete User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete the user?</p>
                            <form action="helpers/users_delete_user.php" method="POST" autocomplete="off">
                                <input type="hidden" id="user" name="id">
                                <!-- Reset and Submit -->
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-success mx-2" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                    <button type="submit" class="btn btn-danger mx-2">Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var deleteModal = document.getElementById('deleteModal');
                    deleteModal.addEventListener('show.bs.modal', function(event) {
                        var button = event.relatedTarget; // Button that triggered the modal
                        var id = button.getAttribute('data-id'); // Extract info from data-id
                        document.getElementById('user').value = id; // Set the hidden input field
                    });
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
    document.getElementById("sidebarUsers").classList.add("active");
    </script>
<!-- #endregion -->