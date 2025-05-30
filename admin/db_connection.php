<?php
// db_connection.php

// Database credentials
$servername = "localhost"; // Replace with your database server
$username = "root";        // Replace with your database username
$password = "";            // Replace with your database password
$dbname = "serbiseek_db"; // Replace with your database name

// Create a new connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
