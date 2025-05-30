<?php
session_start();
$conn = new mysqli("localhost", "root", "", "serbiseek_db");

// Assume you already have these values from Google login
$google_name = $_SESSION['google_name'];
$google_email = $_SESSION['google_email'];

// 1. Check if user already exists
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $google_email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 0) {
    // New user - insert record
    $insert = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, '')");
    $insert->bind_param("ss", $google_name, $google_email);
    $insert->execute();
    $user_id = $insert->insert_id;
    $insert->close();
} else {
    // Existing user - get ID
    $stmt->bind_result($user_id);
    $stmt->fetch();
}
$stmt->close();

// Save user session
$_SESSION['user_id'] = $user_id;

// Redirect to profile page
header("Location: profile.php");
exit;
