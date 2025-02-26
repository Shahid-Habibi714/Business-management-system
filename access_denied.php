<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Denied</title>
    
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/icons/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style.css">
    
    <style>
        body {
            background: var(--bg);
            color: var(--onPrimary);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
        }
        
        .container {
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: scale(1.5); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>
</head>
<body>
    <div class="container text-bg-dark shine round py-5 col-4">
        <div class="text-danger" style="font-size: 100px;"><i class="bi bi-shield-lock-fill"></i></div>
        <h1 class="text-danger">Access Denied</h1>
        <p>You do not have permission to access this page.</p>
        <a href="index.php" class="btn btn-primary">Go to Homepage</a>
    </div>
</body>
</html>
