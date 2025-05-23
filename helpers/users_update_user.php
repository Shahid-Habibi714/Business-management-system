<?php
session_start();
include("../includes/db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $username = strtolower($_POST['updateUsername']);
    $password = $_POST['updatePassword'];
    $role = $_POST['updateRole'];
<<<<<<< HEAD
=======
    $currentUser = $_POST['currentUser'];
>>>>>>> d1ece8a (replace old project with new one)

    $stmt = $conn->prepare("UPDATE users SET username = ?, password = ?, role = ? WHERE id = ?");
    $stmt->bind_param("sssi", $username, $password, $role, $id);
    if ($stmt->execute()) {
<<<<<<< HEAD
=======
        if ($currentUser == "yes") {
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
            $_SESSION['role'] = $role;
        }
>>>>>>> d1ece8a (replace old project with new one)
        $_SESSION['message'] = "User updated successfully!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Field to update user! Error: " . $stmt->error;
        $_SESSION['message_type'] = "danger";
    }
    header("location: ../users.php");
    exit();
}
?>