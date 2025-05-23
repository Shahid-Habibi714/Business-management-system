<?php
#region include files
// Include the database connection file
include('includes/db_connect.php');
// Include the header file
include('includes/header.php');
#endregion
?>

<!-- #region transactions log -->
    <div class="mb-auto p-5">
        <a class="btn btn-primary px-4 align-self-start mb-5" href="financial_insights.php" id="sidebarCustomers">
            <i class="bi bi-arrow-left me-2"></i> back
        </a>
        <?php
            $logStmt = $conn->query("SELECT message, add_sub, date FROM transactions ORDER BY date DESC");
            while ($row = $logStmt->fetch_assoc()) {
                $alertType = ($row['add_sub'] == "add") ? "success" : "danger";
                echo "<div class='row alert alert-".$alertType."'>
                        <p class='col-md-4 col-lg-2'>".$row['date']."</p>
                        <p class='col-md-8 col-lg-10'>".nl2br($row['message'])."</p>
                    </div>";
            }
        ?>
    </div>
<!-- #endregion -->


<!-- #region footer -->
    <?php
    // Include the footer file
    include('includes/footer.php');
    ?>

    <script>
    // Activate the sidebar link
    document.getElementById("sidebarFinancialInsights").classList.add("active");
    </script>
<!-- #endregion -->