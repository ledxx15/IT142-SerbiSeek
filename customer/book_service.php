<?php
// Include the database connection
include('db_connection.php');

// Start the session to access user ID
session_start();

// DEBUG: Check session content (remove after testing)
// var_dump($_SESSION);

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: logreg.php'); // Redirect to login if not logged in
    exit;
}

// Check if the form is submitted (POST request)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize the incoming POST data
    $service_id = $_POST['service_id']; // This should be passed as a hidden input field
    $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $customer_address = mysqli_real_escape_string($conn, $_POST['customer_address']);
    $customer_email = mysqli_real_escape_string($conn, $_POST['customer_email']);
    $customer_contact = mysqli_real_escape_string($conn, $_POST['customer_contact']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Get user ID from session
    $user_id = $_SESSION['user_id'];

    // Check if service_id is valid
    $query = "SELECT * FROM services WHERE id = '$service_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 0) {
        echo "Invalid service ID.";
        exit();
    }

    // Insert the booking details into the database, including user_id
    $query = "INSERT INTO bookings (service_id, customer_name, customer_address, customer_email, customer_contact, message, user_id) 
              VALUES ('$service_id', '$customer_name', '$customer_address', '$customer_email', '$customer_contact', '$message', '$user_id')";

    if (mysqli_query($conn, $query)) {
        // Redirect to booksuccess.php after a successful booking
        header("Location: booksuccess.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
