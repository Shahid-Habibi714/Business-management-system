<?php
include "../includes/db_connect.php"; // Include database connection

$customer = isset($_POST['customer']) ? $_POST['customer'] : '';
$date = isset($_POST['date']) ? $_POST['date'] : '';
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$limit = 20;
$offset = ($page - 1) * $limit;

$query = "SELECT cll.*, customers.name AS c_name FROM customer_loans_log cll JOIN customers ON cll.customer_id = customers.id WHERE 1";

if (!empty($customer)) {
    $query .= " AND customers.name LIKE '%$customer%'";
}
if (!empty($date)) {
    $query .= " AND DATE_FORMAT(cll.created_at, '%Y-%m-%d') = '$date'";
}

$total_query = str_replace("SELECT cll.*, customers.name AS c_name", "SELECT COUNT(*) as total", $query);
$total_result = $conn->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_sales = $total_row['total'];
$total_pages = ceil($total_sales / $limit);

$query .= " ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($query);

$output = "";
while ($sale = $result->fetch_assoc()) {
    $output .= "<tr>
        <td>{$sale['c_name']}</td>
        <td class='afnnum'>" . number_format($sale['amount'], 2) . "</td>
        <td>{$sale['created_at']}</td>
        <td>{$sale['repay_lend']}</td>
        <td>" . ucfirst(htmlspecialchars($sale['username'])) . "</td>
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