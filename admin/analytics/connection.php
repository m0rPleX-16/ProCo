<?php
    // Database configuration
    $db_host = 'localhost'; // Hostname
    $db_user = 'root'; // Username
    $db_pass = ''; // Password
    $db_name = 'barangay_db'; // Database name

    // Establishing connection to the database
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    // Check connection
    if (!$conn) {
        // If connection fails, display an error message and terminate the script
        die("Connection failed: " . mysqli_connect_error());
    }

    // Set default timezone to Asia/Manila
    date_default_timezone_set("Asia/Manila");
?>

