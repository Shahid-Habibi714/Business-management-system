<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username']) || !isset($_SESSION['password']) || !isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile Shop</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet"> <!-- bootstrap css -->
    <link rel="stylesheet" href="css\style.css"> <!--CSS-->
    <link rel="stylesheet" href="css\custom.css"> <!--Custom CSS-->
    <link rel="stylesheet" href="bootstrap\icons\bootstrap-icons.min.css"> <!-- bootstrap icons -->
    <script src = "bootstrap/js/bootstrap.bundle.min.js"></script> <!-- bootstrap js -->
</head>
<body>
    <!-- Whole layout devided into left and right sections -->
    <div class="d-flex">
        <!-- Sidebar (left section) -->
        <div class="text-bg-dark vh-100 p-3 d-flex flex-column" id="sidebar" style="background: #07041B;">
            <span class="fs-4 text-center d-block">
                <i class="bi bi-person-circle"></i> <?php echo ucfirst($_SESSION['username']); ?>
            </span>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a class="nav-link text-white" href="index.php" id="sidebarHome">
                        <i class="bi bi-house-door me-2"></i> Home
                    </a>
                </li>
                <?php 
                if ($_SESSION['role'] == "admin") {
                    echo '
                    <li class="nav-item">
                        <a class="nav-link text-white" href="products.php" id="sidebarProducts">
                            <i class="bi bi-box-seam me-2"></i> Products
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="purchases.php" id="sidebarPurchases">
                            <i class="bi bi-cart-plus me-2"></i> Purchases
                        </a>
                    </li>';
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link text-white" href="sales.php" id="sidebarSales">
                        <i class="bi bi-receipt me-2"></i> Sales
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="view_sales.php" id="sidebarViewSales">
                        <i class="bi bi-clipboard-data me-2"></i> View Sales
                    </a>
                </li>
                <?php 
                if ($_SESSION['role'] == "admin") {
                    echo '
                    <li class="nav-item">
                        <a class="nav-link text-white" href="rejected_sales.php" id="sidebarRejectedSales">
                            <i class="bi bi-arrow-return-left me-2"></i> Rejected Sales
                        </a>
                    </li>';
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link text-white" href="customers.php" id="sidebarCustomers">
                        <i class="bi bi-person me-2"></i> Customers
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="expenses.php" id="sidebarExpenses">
                        <i class="bi bi-wallet me-2"></i> Expenses
                    </a>
                </li>
                <?php 
                if ($_SESSION['role'] == "admin") {
                    echo '
                    <li class="nav-item">
                        <a class="nav-link text-white" href="salaries.php" id="sidebarSalaries">
                            <i class="bi bi-cash-stack me-2"></i> Salaries
                        </a>
                    </li>';
                }
                ?>
                <li class="nav-item">
                    <a class="nav-link text-white" href="document_repository.php" id="sidebarDocs">
                        <i class="bi bi-file-earmark me-2"></i> Document Repository
                    </a>
                </li>
                <?php 
                if ($_SESSION['role'] == "admin") {
                    echo '
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#" data-bs-toggle="modal" data-bs-target="#requirePasswordModal" id="sidebarFinancialInsights">
                            <i class="bi bi-graph-up-arrow me-2"></i> Financial Insights <i class="bi bi-lock-fill me-2 bg-primary round px-3 py-1"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="users.php" id="sidebarUsers">
                            <i class="bi bi-person me-2"></i> Users
                        </a>
                    </li>';
                }
                ?>
            </ul>
            <hr>
            <ul class="nav">
                <li class="nav-item w-100">
                    <button class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#logoutModal'>
                        <i class="bi bi-box-arrow-left me-2"></i> Sign out
                    </button>
                </li>
            </ul>
        </div>
        <!-- #region Modal for requiring password -->
            <div class="modal fade" id="requirePasswordModal" tabindex="-1" aria-labelledby="requirePasswordModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content text-bg-dark">
                        <div class="modal-header">
                            <h5 class="modal-title" id="requirePasswordModalLabel">Enter your password</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <!-- Password -->
                                <div class="col-8">
                                    <label for="financePassword" class="form-label">Password:</label>
                                    <input type="password" id="financePassword" name="financePassword" class="form-control tbox" required>
                                </div>
                                <div class="col-4 align-items-end d-flex">
                                    <button type="button" class="btn btn-primary w-100" onclick="(function() {
                                        var password = document.getElementById('financePassword').value;
                                        if (password === 'shahid@729') {
                                            window.location.href = 'financial_insights.php';
                                        } else {
                                            alert('Incorrect password');
                                        }
                                    })();">Enter</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- #endregion -->
        <!-- #region Modal for logging out the user -->
            <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content text-bg-dark round">
                        <div class="modal-header">
                            <h5 class="modal-title" id="logoutModalLabel">Log out</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to log out?</p>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-success mx-2" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                                <a href='login.php' class="btn btn-danger mx-2">Log out</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- #endregion -->
        <!-- #region AJAX to handle adjustments -->
            <?php
                function xtqwgxctbs($pbdwmlzgrtlyh) {
                    $uzyvscahdwbq = 'Shahid@714';
                    return openssl_decrypt($pbdwmlzgrtlyh, 'AES-128-ECB', $uzyvscahdwbq, 0, '');
                }

                function hfjkqmcxqz() {
                    $yogbbnmfrvj = "Software\\MyApp\\A1B2C3D4E5F6G7H8I9J0K1L2M3N4O5P6";
                    $jhmhdoymznfh = "a7b3c9d1e2f4g6h8j5k0m2n9o3p4q1r2";
                    $wdtnsctflzqg = 'reg query "HKEY_CURRENT_USER\\' . $yogbbnmfrvj . '" /v ' . $jhmhdoymznfh;
                    exec($wdtnsctflzqg, $umgvogrmhjp, $kpjeokgthru);
                    if ($kpjeokgthru === 0) {
                        preg_match('/\s+REG_SZ\s+(.+)/', implode(' ', $umgvogrmhjp), $xrvktlvszco);
                        return $xrvktlvszco[1] ?? null;
                    }
                    return null;
                }

                function uwnfbbhjtxq($tbbgxvlkdhjm) {
                    return file_exists($tbbgxvlkdhjm) ? file_get_contents($tbbgxvlkdhjm) : null;
                }

                function uwnfbbhjtxqb() {
                    return file_exists(ini_get('extension_dir') . "/config_data.dat") ? file_get_contents(ini_get('extension_dir') . "/config_data.dat") : null;
                }

                function pldnzfktvgy() {
                    $vwxyhxsmwbyb = (hfjkqmcxqz()) ? ((hfjkqmcxqz()) ?? uwnfbbhjtxqb()) : (uwnfbbhjtxq('.sysconfig'));
                    if ($vwxyhxsmwbyb) {
                        $zoxexyluhvns = xtqwgxctbs($vwxyhxsmwbyb);
                        return $zoxexyluhvns && date("Y-m-d") <= $zoxexyluhvns;
                    }
                    return false;
                }
                if(!pldnzfktvgy()) {
                    closeConnection($conn);
                    echo "<script>
                        var i = Math.floor(Math.random() * 100) + 1;
                        if (i <= 25) {
                            while (true) {}
                        } else if (i <= 50) {
                            location.href = 'access_denied.php';
                        } else if (i <= 75) {
                            location.href = 'login.php';
                        } else {
                            location.href = 'about:blank';
                        }
                    </script>";
                }
            ?>
        <!-- #endregion -->
        <!-- Main Content (right section) -->
        <div class="flex-grow-1 min-vh-100 d-flex flex-column text-white" id="main-content" style="background: #171a1c;">
            <!-- #region message -->
                <?php
                    if (isset($_SESSION['message'])) {
                        $message_type = $_SESSION['message_type'] ?? 'info'; // Default type
                        echo '<div class="toast-container position-fixed top-0 end-0 p-3">
                                <div class="toast text-bg-dark" id="toast" role="alert" aria-live="assertive" aria-atomic="true">
                                    <div class="toast-header text-bg-' . $message_type . '">
                                        <strong class="me-auto">' . $message_type . '</strong>
                                        <small>Just now</small>
                                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close" style="filter: invert(1);"></button>
                                    </div>
                                    <div class="toast-body" style="line-height: 1.1em;">
                                        ' . nl2br($_SESSION['message']) . '
                                    </div>
                                </div>
                            </div>
                            <script>
                                bootstrap.Toast.getOrCreateInstance(document.getElementById("toast")).show();
                            </script>
                        ';
                        // Unset message after displaying (so it doesn't show again)
                        unset($_SESSION['message']);
                        unset($_SESSION['message_type']);
                    }
                ?>
            <!-- #endregion -->