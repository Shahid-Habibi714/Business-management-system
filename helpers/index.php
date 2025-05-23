<?php
#region includes
// Include the database connection file
include('includes/db_connect.php');
// Include the header file
include('includes/header.php');
#endregion
?>

 


<div class="p-5 flex-column mb-auto">
    <h2>Dashboard</h2>
    <!-- #region backup -->
        <div class="row round shadow text-bg-dark p-5 my-3">
            <div class="col-6">
                <h3>Click the button below to back up the database to ensure data integrity:</h3>
                <p>Backing up the database is a crucial task for any business to ensure data integrity and security. Regular backups protect against data loss due to hardware failures, software issues, or cyber-attacks. By maintaining up-to-date backups, businesses can quickly restore their systems to a previous state, minimizing downtime and ensuring continuity of operations. Additionally, backups provide a safeguard against accidental data deletions or corruptions, allowing for peace of mind and reliable data management.</p>
            </div>
            <div class="col-6 d-flex justify-content-center align-items-center flex-column">
                <form action="helpers/backup.php" method="post" class="mb-2">
                    <button type="submit" class="btn btn-primary px-5 py-3">
                        Backup the database
                    </button>
                </form>
                <?php
                
                $file = "last_backup.txt";

                if (file_exists($file)) {
                    $last_backup = file_get_contents($file);
                    // echo "Last Backup: " . htmlspecialchars($last_backup);
                    echo "Last Backup: " . date("F j, Y, g:i A", strtotime($last_backup)); // Example: January 10, 2025, 2:30 PM
                } else {
                    echo "No backup recorded yet.";
                }
                
                ?>
            </div>
        </div>
    <!-- #endregion -->
    <!-- #region changing the dollar rate -->
        <?php
            $currency = $conn->query("SELECT * FROM currency ORDER BY date DESC LIMIT 1")->fetch_assoc();
        ?>
        <div class="row">
            <div class="container mb-4 col-4" style="height:300px;">
                <div class="card text-bg-dark h-100 shadow">
                    <h3 class="bg-primary text-center usdnum py-2">
                        <?php echo number_format(($currency['rate'] ?? 1), 2); ?>
                    </h3>
                    <div class="card-header text-white">
                        <h4 class="mt-3">Update Dollar Rate</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="helpers/index_update_dollar_rate.php" class="flex-column">
                            <div class="mb-3">
                                <input type="number" step="0.01" class="form-control tbox" id="dollar_rate" name="dollar_rate" required autocomplete="off">
                            </div>
                            <div class="mb-3"> 
                                <button type="submit" class="btn btn-primary w-100">Submit</button>
                            </div>
                        </form>
                        <p>Last changed: <?php echo date("F j, Y, g:i A", strtotime(($currency['date'])??"")); ?></p>
                    </div>
                </div>
            </div>
            <style>
                .slideshow-container {
                    position: relative;
                    height: 300px;
                    overflow: hidden;
                    display: flex;
                }

                .slides-wrapper {
                    display: flex;
                    width: 400%; /* 4 slides, each 100% */
                    height: 100%;
                    animation: slide 16s infinite;
                }

                .slide {
                    width: 100%;
                    height: 100%;
                    background-size: cover;
                    background-position: center;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    flex-shrink: 0;
                }

                /* Set different backgrounds for each slide */
                .slide:nth-child(1) { background-image: url('img/bg1.jpg'); }
                .slide:nth-child(2) { background-image: url('img/bg2.jpg'); }
                .slide:nth-child(3) { background-image: url('img/bg3.jpg'); }
                .slide:nth-child(4) { background-image: url('img/bg4.jpg'); }

                /* Sliding animation */
                @keyframes slide {
                    0%, 20% { transform: translateX(0); }
                    25%, 45% { transform: translateX(-100%); }
                    50%, 70% { transform: translateX(-200%); }
                    75%, 95% { transform: translateX(-300%); }
                    100% { transform: translateX(0); }
                }

                /* Styling for the text overlay */
                .overlay {
                    /* background: rgba(0, 0, 0, 0.3);
                    backdrop-filter: blur(10px); */
                    color: white;
                    font-size: 24px;
                    font-weight: bold;
                    padding: 15px 20px;
                    border-radius: 20px;
                    text-align: center;
                    max-width: 80%;
                }

                .tip {
                    font-size: 40px;
                    font-weight: 900;
                }
            </style>

            <div class="col-8 bg-danger p-0 slideshow-container round shadow">
                <div class="slides-wrapper">
                    <div class="slide">
                        <div class="overlay"><span class="tip">Tip</span><br>Keep track of your daily sales for better insights.</div>
                    </div>
                    <div class="slide">
                        <div class="overlay"><span class="tip">Tip</span><br>Monitor expenses regularly to maximize profits.</div>
                    </div>
                    <div class="slide">
                        <div class="overlay"><span class="tip">Tip</span><br>Restock products wisely to avoid overstocking or shortages.</div>
                    </div>
                    <div class="slide">
                        <div class="overlay"><span class="tip">Tip</span><br>Analyze reports to make data-driven business decisions.</div>
                    </div>
                </div>
            </div>
        </div>
    <!-- #endregion -->
    <!-- #region showing dollar rate over time in chart -->
        <div class="container">
            <div class="card text-bg-dark shadow">
                <div class="card-header text-center pt-5">
                    <h4>Dollar Rate Over Time</h4>
                </div>
                <div class="card-body">
                    <canvas id="dollarRateChart"></canvas>
                </div>
            </div>
        </div>

        <script src="js/charts/moment.min.js"></script>
        <script src="js/charts/chart.js"></script>
        <script src="js/charts/chartjs-adapter-moment.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var ctx = document.getElementById('dollarRateChart').getContext('2d');
                
                 // Create gradient
                var gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, 'rgba(75, 192, 192, 0.5)'); // Top (strong color)
                gradient.addColorStop(1, 'rgba(75, 192, 192, 0)');   // Bottom (fade out)

                var dollarRateChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: [
                            <?php
                            $date_result = mysqli_query($conn, "SELECT date FROM currency ORDER BY date DESC LIMIT 100");
                            while ($date_row = mysqli_fetch_assoc($date_result)) {
                                echo "'" . $date_row['date'] . "',";
                            }
                            ?>
                        ],
                        datasets: [{
                            label: 'Dollar Rate',
                            data: [
                                <?php
                                $rate_result = mysqli_query($conn, "SELECT rate FROM currency ORDER BY date DESC LIMIT 50");
                                while ($rate_row = mysqli_fetch_assoc($rate_result)) {
                                    echo $rate_row['rate'] . ",";
                                }
                                ?>
                            ],
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 3,
                            backgroundColor: gradient, // Apply gradient fill
                            fill: true, // Enable the filled area
                            tension: 0.4 // Smooth curve effect
                        }]
                    },
                    options: {
                        scales: {
                            x: {
                                type: 'time',
                                time: {
                                    unit: 'day'
                                }
                            },
                            y: {
                                beginAtZero: false
                            }
                        }
                    }
                });
            });
        </script>
    <!-- #endregion -->
    <!-- #region add notification for low stock items -->
        <h3 class='py-5'>Low stock items:</h3>
        <?php
            $low_stock_result = mysqli_query($conn, "SELECT name, stock FROM products WHERE stock < 500");
            $total_items = mysqli_num_rows($low_stock_result);
            $counter = 0;

            if ($total_items > 0) {
                echo "<div class='row mb-5 round overflow-hidden' id='lowStockContainer'>";
                while ($low_stock_row = mysqli_fetch_assoc($low_stock_result)) {
                    $hidden_class = ($counter >= 9) ? 'd-none' : '';
                    echo "<div class='col-4 mb-4 low-stock-item $hidden_class'>
                            <div class='card card-danger shine text-bg-dark h-100 shadow'>
                                <h4 class='p-3'>" . $low_stock_row['name'] . "<br>
                                    <span style='font-weight:900;font-size:2em;'>" . $low_stock_row['stock'] . "</span>
                                </h4>
                            </div>
                        </div>";
                    $counter++;
                }
                // Show More Button (only if more than 9 items exist)
                if ($total_items > 9) {
                    echo "<div class='text-center py-5' style='background:linear-gradient(transparent, rgba(0,0,0,0.9), rgba(0,0,0,0.9));margin-top:-250px;z-index:100;padding-top:100px !important;'>
                            <button id='showMoreBtn' style='background: none;border:none;outline:none;color:white;font-size:30px;'>
                                See More<br><i class='bi bi-chevron-down'></i>
                            </button>
                        </div>";
                }
                echo "</div>";
            } else {
                echo '<p>No low stock product found.</p>';
            }
        ?>

        <script>
        document.getElementById('showMoreBtn')?.addEventListener('click', function() {
            document.querySelectorAll('.low-stock-item').forEach(item => item.classList.add('d-none'));
            setTimeout(()=>{document.querySelectorAll('.low-stock-item').forEach(item => item.classList.remove('d-none'))},1);
            this.parentElement.style.display = 'none'; // Hide button after showing all items
        });
        </script>
    <!-- #endregion -->
    <!-- #region latest purchases -->
        <h3 class='py-5'>Latest Purchases</h3>
        <div class="row">
            <?php
            // Fetch the latest 5 products from the database
            $result = mysqli_query($conn, "SELECT p.*, products.name AS product_name FROM purchases p JOIN products ON product_id = products.id ORDER BY purchase_date DESC LIMIT 5");
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='col-md-4 mb-4'>";
                    echo "<div class='card shine shadow text-bg-dark h-100'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'><i class='bi bi-box-fill bg-primary text-center fs-4 me-3' style='display: inline-block;border-radius:50%;width:50px;height:50px;line-height:50px;'></i>" . $row['product_name'] . "</h5>";
                    echo "<span style='font-weight:900;font-size:2em;display:block;text-align:right;'>" . $row['quantity'] . "</span>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>No products available at the moment.</p>";
            }
            
            // show more button
            if ($conn->query("SELECT COUNT(*) AS total_rows FROM purchases")->fetch_assoc()['total_rows'] > 5) {
                echo "
                    <div class='col-md-4 mb-4'>
                        <div class='card h-100 bg-transparent'>
                            <div class='card-body p-0 d-flex justify-content-center align-items-center'>
                                <button type='button' onclick='location.href=\"purchases.php\"' class='btn btn-primary shine fs-4' style='border-radius: 50%;width:70px;height:70px;'><i class='bi bi-arrow-right'></i></button>
                            </div>
                        </div>
                    </div>
                ";
            }
            ?>
        </div>
    <!-- #endregion -->
</div>



<!-- #region footer -->
    <?php
    // Include the footer file
    include('includes/footer.php');
    ?>

    <script>
    // Activate the sidebar link
    document.getElementById("sidebarHome").classList.add("active");
    </script>
<!-- #endregion -->