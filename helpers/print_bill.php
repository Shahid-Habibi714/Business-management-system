<?php
include('includes/db_connect.php');

// Get the sale ID from the query string
if (!isset($_GET['sale_id'])) {
    die("Sale ID is required.");
}

$sale_id = intval($_GET['sale_id']);

// Fetch the sale details
$sale_sql = "SELECT * FROM sales WHERE id = ?";
$stmt = $conn->prepare($sale_sql);
$stmt->bind_param("i", $sale_id);
$stmt->execute();
$sale_result = $stmt->get_result();
$sale = $sale_result->fetch_assoc();

if (!$sale) {
    die("Sale not found.");
}

// Fetch the sale items
$sale_items_sql = "SELECT si.*, p.name FROM sale_items si JOIN products p ON si.product_id = p.id WHERE si.sale_id = ?";
$stmt2 = $conn->prepare($sale_items_sql);
$stmt2->bind_param("i", $sale_id);
$stmt2->execute();
$sale_items_result = $stmt2->get_result();
?>

<!DOCTYPE html>
<html lang="ps" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Bill</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <style>
        img {
            width: 100%;
        }
        @media print {
            .no-print { display: none; }
        }
        #footer-container {
            position: fixed;
            bottom: 0px;
            left: 0px;
            right: 0px;
            width: 100%;
            height: 70px;
            line-height: 50px;
            font-size: 20px;
            padding: 0px 20px;
            margin: 0px;
        }
        #watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50%;
            opacity: .1;
        }
    </style>
</head>
<body>
    <img src="img/bill_header.png" alt="bill image">
    <img src="img/logo.png" id="watermark">
    <div class="container" style="margin-top:-50px;">
        <div class="mb-4 row">
            <p class="col-md-6">د پیریدونکی نوم: <?= htmlspecialchars($sale['customer_name']); ?></p>
            <p class="col-md-2">د بل نمبر: <?= $sale['id']; ?></p>
            <p class="col-md-4">نیټه: <?= $sale['sale_date']; ?></p>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>جنس</th>
                    <th>تعداد</th>
                    <th>قیمت</th>
                    <th>مجموعه</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $index = 1;
                while ($item = $sale_items_result->fetch_assoc()):
                ?>
                    <tr>
                        <td><?= $index++; ?></td>
                        <td><?= htmlspecialchars($item['name']); ?></td>
                        <td><?= $item['quantity']; ?></td>
                        <td><?= number_format($item['price'], 2); ?></td>
                        <td><?= number_format($item['total'], 2); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="text-end">عمومی مجموعه</th>
                    <th><?= number_format($sale['total_amount'], 2); ?></th>
                </tr>
            </tfoot>
        </table>
    </div>
    <p id="footer-container">
        <span>پته: د پل خشتی جومات مخی ته، د موبایل سنټر لومړی منزل، دوکان نمبر</span>
        <span>A96</span>
    </p>
</body>
</html>

<script>
    window.addEventListener("load", () => {
        window.print();
    });
</script>