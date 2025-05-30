<?php
session_start();
include('db_connection.php'); // Include your database connection

// Clear previous error messages
$_SESSION['loginError'] = '';
$_SESSION['registerError'] = '';
// Clear any previous success messages
$_SESSION['registerSuccess'] = '';

// Login Process
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Use prepared statements for security
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['name']; // Store name for profile autofill
        header('Location: landing.php');
        exit;
    } else {
        $_SESSION['loginError'] = "Incorrect Credentials. Try Again.";
        header('Location: logreg.php');
        exit;
    }
}

// Registration Process
if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $check = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $_SESSION['registerError'] = "Email already registered.";
        header('Location: logreg.php');
        exit;
    } else {
        // Insert new user
        $insert = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $insert->bind_param("sss", $name, $email, $hashedPassword);

        if ($insert->execute()) {
            // Don't set session user info here; ask user to sign in
            $_SESSION['registerSuccess'] = "Registration successful! Please sign in.";
            header('Location: logreg.php');  // Redirect to login page
            exit;
        } else {
            $_SESSION['registerError'] = "Registration failed.";
            header('Location: logreg.php');
            exit;
        }
    }
}
?>
