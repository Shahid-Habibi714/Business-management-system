<?php
session_start();
include '../includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    // $fileName = basename($_FILES["file"]["name"]);
    // $targetFilePath = "uploads/" . $fileName;
    
    
    $originalName = $_FILES['file']['name'];
    $cleanName = preg_replace('/[^A-Za-z0-9.\-_]/', '_', $originalName); // Replace special chars with "_"
    $targetPath = "uploads/" . $cleanName;
    $moveFileTo = "../uploads/" . $cleanName;

    if (move_uploaded_file($_FILES["file"]["tmp_name"], $moveFileTo)) {
        $stmt = $conn->prepare("INSERT INTO files (file_name, file_path) VALUES (?, ?)");
        $stmt->bind_param("ss", $cleanName, $targetPath);
        if ($stmt->execute()) {
            $_SESSION['message'] = "File uploaded successfully!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Field to upload file!";
            $_SESSION['message_type'] = "danger";
        }
    } else {
        $_SESSION['message'] = "File upload field!";
        $_SESSION['message_type'] = "danger";
    }
    header("location: ../document_repository.php");
}
?>
