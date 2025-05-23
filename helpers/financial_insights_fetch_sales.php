<?php
include "../includes/db_connect.php"; // Include database connection

$bill = isset($_POST['bill']) ? $_POST['bill'] : '';
$customer = isset($_POST['customer']) ? $_POST['customer'] : '';
$date = isset($_POST['date']) ? $_POST['date'] : '';
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$limit = 20;
$offset = ($page - 1) * $limit;

$query = "SELECT * FROM sales WHERE 1";

if (!empty($bill)) {
    $query .= " AND id LIKE '%$bill%'";
}
if (!empty($customer)) {
    $query .= " AND customer_name LIKE '%$customer%'";
}
if (!empty($date)) {
    $query .= " AND DATE_FORMAT(sale_date, '%Y-%m-%d') = '$date'";
}

$total_query = str_replace("SELECT *", "SELECT COUNT(*) as total", $query);
$total_result = $conn->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_sales = $total_row['total'];
$total_pages = ceil($total_sales / $limit);

$query .= " ORDER BY sale_date DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($query);

$output = "";
while ($sale = $result->fetch_assoc()) {
    $currency_id = $sale['currency_id'];
    $dollar_rate = 1;
    if ($currency_id) {
        $currency_result = $conn->query("SELECT rate FROM currency WHERE id = $currency_id");
        $currency = $currency_result->fetch_assoc();
        $dollar_rate = $currency['rate'];
    }
    $is_loan = ($sale['is_loan'] == 1) ? 'Loan' : 'Cash';

    $output .= "<tr>
        <td>{$sale['id']}</td>
        <td>{$sale['customer_name']}</td>
        <td>
            <span class='usdnum'>" . number_format($sale['total_amount'] / $dollar_rate, 2) . "</span><br>
            <span class='afnnum'>" . number_format($sale['total_amount'], 2) . "</span>
        </td>
        <td>{$sale['sale_date']}</td>
        <td>{$is_loan}</td>
        <td>
            <span class='usdnum'>" . number_format($sale['total_profit'], 2) . "</span><br>
            <span class='afnnum'>" . number_format($sale['total_profit'] * $dollar_rate, 2) . "</span>
        </td>
        <td class='dollarRate'>" . number_format($dollar_rate, 2) . "</td>
        <td>" . ucfirst(htmlspecialchars($sale['username'])) . "</td>
        <td><a href='print_bill.php?sale_id={$sale['id']}' target='_blank'>
            <i class='bi bi-box-arrow-up-right fs-3 text-white'></i></a></td>
    </tr>";
}

// Pagination controls
$pagination = "";
if ($page > 1) {
    $pagination .= "<li class='page-item'><a class='page-link' href='#' data-page='" . ($page - 1) . "'>Previous</a></li>";
}

// Define range
$range = 10;
$start = max(1, $page - floor($range / 2));
$end = min($total_pages, $start + $range - 1);

// Adjust start if near the end
if ($end - $start < $range - 1) {
    $start = max(1, $end - $range + 1);
}

// Always show the first page
if ($start > 1) {
    $pagination .= "<li class='page-item'><a class='page-link' href='#' data-page='1'>1</a></li>";
    if ($start > 2) {
        $pagination .= "<li class='page-item disabled'><span class='page-link'>...</span></li>";
    }
}

// Main page numbers
for ($i = $start; $i <= $end; $i++) {
    $active = ($i == $page) ? 'active' : '';
    $pagination .= "<li class='page-item $active'><a class='page-link' href='#' data-page='$i'>$i</a></li>";
}

// Always show the last page
if ($end < $total_pages) {
    if ($end < $total_pages - 1) {
        $pagination .= "<li class='page-item disabled'><span class='page-link'>...</span></li>";
    }
    $pagination .= "<li class='page-item'><a class='page-link' href='#' data-page='$total_pages'>$total_pages</a></li>";
}

if ($page < $total_pages) {
    $pagination .= "<li class='page-item'><a class='page-link' href='#' data-page='" . ($page + 1) . "'>Next</a></li>";
}
echo json_encode(['table' => $output, 'pagination' => $pagination]);
?>