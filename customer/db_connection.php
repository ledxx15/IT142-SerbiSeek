<?php
// db_connection.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "serbiseek_db";

// Create connection (procedural)
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
