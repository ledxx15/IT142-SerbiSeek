<?php
// Include database connection
include('db_connection.php');

// Start session to get customer information
session_start();

// Check if the customer is logged in
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    echo "You are not logged in.";
    exit;
}

$user_id = $_SESSION['user_id']; // Retrieve user ID from session

// Check if necessary POST data is available
if (isset($_POST['booking_id']) && !empty($_POST['booking_id']) && 
    isset($_POST['rating']) && !empty($_POST['rating'])) {

    $booking_id = $_POST['booking_id'];
    $service_id = $_POST['service_id'];
    $rating = $_POST['rating'];
    $review = mysqli_real_escape_string($conn, $_POST['review']); // Sanitize review text

    // Validate rating (must be between 1 and 5)
    if ($rating < 1 || $rating > 5) {
        echo "Rating must be between 1 and 5.";
        exit;
    }

    // Insert the rating and review into the database
    $insertQuery = "INSERT INTO ratings (booking_id, user_id, service_id, rating, review)
                    VALUES ('$booking_id', '$user_id', '$service_id', '$rating', '$review')";

    if (mysqli_query($conn, $insertQuery)) {
        // Redirect to the success page after submitting the rating
        header("Location: rate_success.php");
        exit(); // Don't forget to call exit after header to stop further script execution
    } else {
        echo "Error: " . mysqli_error($conn);
    }

} else {
    echo "Invalid request. Missing data.";
}

// Close the database connection
mysqli_close($conn);
?>
