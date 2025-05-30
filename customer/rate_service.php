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

// Check if booking_id is passed via POST
if (isset($_POST['booking_id']) && !empty($_POST['booking_id'])) {
    $booking_id = $_POST['booking_id'];

    // Fetch the booking details
    $query = "SELECT b.id AS booking_id, b.status, s.id AS service_id, s.service_name
              FROM bookings b
              INNER JOIN services s ON b.service_id = s.id
              WHERE b.id = '$booking_id' AND b.user_id = '$user_id'";  // Ensure correct user_id
    $result = mysqli_query($conn, $query);

    if (!$result || mysqli_num_rows($result) == 0) {
        echo "Error: Invalid booking or you're not authorized to rate this booking.";
        exit;
    }

    $booking = mysqli_fetch_assoc($result);

    // Check if the booking is Finished (only then rating can be submitted)
    if ($booking['status'] != 'Finished') {
        echo "You can only rate a finished booking.";
        exit;
    }
} else {
    echo "Invalid booking.";
    exit;
}

// Close the database connection
mysqli_close($conn);
?>

<!-- HTML Form for Rating -->
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="shortcut icon" type="x-icon" href="logo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rate Service</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .rating-container {
            width: 50%;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        label {
            font-size: 16px;
            margin-bottom: 10px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        input[type="number"] {
            width: 60px;
            padding: 8px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        button {
            padding: 10px 20px;
            background-color: #92cbcc;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #4A628A;
        }

        .cancel-btn {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 10px;
            background-color: #ccc;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .cancel-btn:hover {
            background-color: #999;
        }
    </style>
</head>
<body>

<h2>Rate Service: <?php echo $booking['service_name']; ?></h2>

<div class="rating-container">
    <form method="POST" action="insert_rating.php">
        <input type="hidden" name="booking_id" value="<?php echo $booking['booking_id']; ?>">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <input type="hidden" name="service_id" value="<?php echo $booking['service_id']; ?>">

        <label for="rating">Rating (1 to 5):</label>
        <input type="number" id="rating" name="rating" min="1" max="5" required>

        <label for="review">Review (optional):</label>
        <input type="text" id="review" name="review" placeholder="Write a review...">

        <button type="submit">Submit Rating</button>
    </form>

    <form action="track.php" method="get">
        <button type="submit" class="cancel-btn">Cancel</button>
    </form>
</div>

</body>
</html>
