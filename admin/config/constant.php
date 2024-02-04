<?php
//start session
session_start();

// Define your database connection parameters
define("SITEURL", "http://localhost/pizza");
$hostname = 'localhost';  // Change to your database host if different
$username = 'root';      // Change to your database username
$password = 'root';      // Change to your database password
$database = 'pizza';    // Change to your database name



// Create a database connection
$conn = mysqli_connect($hostname, $username, $password, $database);

// Check the connection
    if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
    }

    echo 'Connected successfully!';


    mysqli_close($conn);
?>
