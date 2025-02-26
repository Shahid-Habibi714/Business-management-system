<?php
session_start();
include("includes/db_connect.php");
unset($_SESSION['username']);
unset($_SESSION['password']);
unset($_SESSION['role']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Glassmorphism Login</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <style>
        /* Background with Image */
        body {
            background: url('img/login_bg.jpg') no-repeat center center/cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(50px);
            position: relative; /* Needed for absolute positioning */
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
            opacity: 0;
            }
            to {
            opacity: 1;
            }
        }

        /* Adding a pseudo-element overlay to darken the background */
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3); /* Adjust the opacity here to make it darker */
            z-index: -1; /* Ensure the overlay is behind the content */
        }

        #top-container {
            width: 90vw;
            height: 90vh;
            background: url('img/login_bg.jpg') no-repeat center center/cover;
            /* background: rgba(255,255,255,0.2); */
            backdrop-filter: blur(10px);
            border-radius: 50px;
            box-shadow: 0px 20px 20px rgba(255,255,255,0.1);
        }

        /* Glassmorphism Effect */
        .login-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            padding: 40px;
            border-radius: 30px;
            box-shadow: 0 0 20px rgba(0, 122, 255, 0.3);
            width: 400px;
            text-align: center;
            border: 2px solid rgba(255, 255, 255, 0.2);
            position: relative;
        }
        /* Heading with Gradient */
        .login-container h2 {
            font-size: 40px;
            font-weight: 900;
            letter-spacing: 1px;
            margin-bottom: 20px;
            background: linear-gradient(to bottom left, #C40BC9, #378BDD);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Input Fields */
        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: solid 2px transparent;
            color: #fff;
            padding: 12px;
            padding-left: 25px;
            font-size: 16px;
            border-radius: 20px;
            transition: 0.3s;
        }

        .form-control:focus,
        .btn-login:hover {
            border: 2px solid #C40BC9;
            box-shadow: 0 0 15px #C40BC9;
            outline: none;
            color: white;
        }
        input {
            transition: .3s !important;
            background: rgba(0, 0, 0, 0.3) !important;
        }

        ::placeholder {
            color: #909090 !important;
        }

        /* Button with Neon Glow */
        .btn-login {
            background: linear-gradient(135deg, #C40BC9, #378BDD);
            border: 2px solid transparent;
            padding: 12px;
            width: 100%;
            font-size: 16px;
            font-weight: bold;
            border-radius: 20px;
            transition: 0.3s ease-in-out;
            color: #fff;
            text-transform: uppercase;
            cursor: pointer;
        }
    </style>
</head>
<body>
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
    <div id="top-container" class="d-flex justify-content-center align-items-center">
        <!-- Login Form -->
        <div class="login-container">
            <h2>Welcome Back</h2>
            <form action="helpers/login_validation.php" method="post" autocomplete="off">
                <div class="mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <button type="submit" class="btn btn-login">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
