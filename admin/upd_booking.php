<?php
// Include database connection
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = $_POST['booking_id'];

    if (isset($_POST['accept_booking'])) {
        // Update to BOOKED
        $query = "UPDATE bookings SET status = 'BOOKED' WHERE id = '$booking_id'";
        mysqli_query($conn, $query);
    } elseif (isset($_POST['delete_booking'])) {
        // Update to Canceled
        $query = "UPDATE bookings SET status = 'Canceled' WHERE id = '$booking_id'";
        mysqli_query($conn, $query);
    } elseif (isset($_POST['finish_booking'])) {
        // Update to Finished
        $query = "UPDATE bookings SET status = 'Finished' WHERE id = '$booking_id'";
        mysqli_query($conn, $query);
    }
    
    // Redirect back to bookings page
    header("Location: booking.php");
    exit();
}

// Close the database connection
mysqli_close($conn);
?>
