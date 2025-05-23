<?php
$servername = "localhost";
$username = "root"; // default XAMPP MySQL user
$password = ""; // default XAMPP MySQL password
<<<<<<< HEAD
=======
// $dbname = "my_database"; // the name of your database
>>>>>>> d1ece8a (replace old project with new one)
$dbname = "mobile_shop"; // the name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function closeConnection($conn) {
    $conn->close();
}
?>