<?php


// Define database credentials
$SITEURL = 'http://localhost/pizza/admin/';
$hostname = 'localhost';
$username = 'root';
$password = 'root';
$database = 'pizza';

// Create a database connection
$conn = mysqli_connect($hostname, $username, $password, $database);

// Check the connection
if (!$conn) {
    die("Database connection error: " . mysqli_connect_error());
}

// Select the database
$db_select = mysqli_select_db($conn, $database);

// Check the database selection
if (!$db_select) {
    die("Selection Database error: " . mysqli_error($conn));
}
?>
