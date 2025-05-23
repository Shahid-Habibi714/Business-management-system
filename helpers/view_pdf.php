<?php
$filePath = urldecode($_GET['file']) ?? '';

if (!$filePath || !file_exists($filePath)) {
    die("File not found!");
}

// Set headers to force inline view (instead of download)
header("Content-Type: application/pdf");
header("Content-Disposition: inline; filename=\"" . basename($filePath) . "\"");
readfile($filePath);
exit;
