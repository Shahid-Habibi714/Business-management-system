<?php
session_start();

// Database connection details
$dbHost = 'localhost';       // Database host
$dbUsername = 'root';        // Database username
$dbPassword = '';            // Database password (empty)
$dbName = 'mobile_shop';     // Your database name


#region display date & time under the button
date_default_timezone_set("Asia/Kabul"); // Set to your timezone
$backup_time = date("Y-m-d H:i:s"); // Get current date and time
file_put_contents("../last_backup.txt", $backup_time); // Save to a file
#endregion


// Backup directory and file name
$backupDir = 'D:/backups';  // Folder where backups will be stored
$backupFile = $backupDir . '/db_backup_' . date('Y-m-d_H-i-s') . '.sql';  // Backup file name with timestamp

// Create the backups directory if it doesn't exist
if (!file_exists($backupDir)) {
    mkdir($backupDir, 0777, true); // Create the backup folder with proper permissions
}

// Corrected mysqldump command
$mysqldumpPath = 'C:/xampp/mysql/bin/mysqldump.exe'; // Full path
$command = "\"$mysqldumpPath\" -h $dbHost -u $dbUsername " . (!empty($dbPassword) ? "-p\"$dbPassword\" " : "") . "$dbName > \"$backupFile\"";


// Execute the command and capture the output
$output = [];
$return_var = null;
exec($command, $output, $return_var);

// Check if the backup was successful
if ($return_var === 0 && file_exists($backupFile)) {
    $_SESSION['message'] = "Backup successfully created at: $backupFile";
    $_SESSION['message_type'] = "success";
} else {
    $_SESSION['message'] = "Failed to create backup. Error Code: $return_var";
    $_SESSION['message_type'] = "danger";
}

// Redirect to the main page
header("location: ../index.php");
exit();
?>
