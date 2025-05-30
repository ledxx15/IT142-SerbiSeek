<?php
// Include database connection
include('db_connection.php');

// Check if the form is submitted
if (isset($_POST['accept_booking'])) {
    $booking_id = $_POST['booking_id'];

    // Update booking status to 'BOOKED'
    $query = "UPDATE bookings SET status = 'BOOKED' WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $booking_id);

    if (mysqli_stmt_execute($stmt)) {
        // Redirect back to the bookings page after successful update
        header('Location: booking.php');
    } else {
        echo "Error updating booking status.";
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

// Close the database connection
mysqli_close($conn);
?>
