<?php
// Include database connection
include('db_connection.php');

// Handle button actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $booking_id = $_POST['booking_id'];

    if (isset($_POST['accept_booking'])) {
        // Update status to Accepted
        $query = "UPDATE bookings SET status = 'Accepted' WHERE id = $booking_id";
        mysqli_query($conn, $query);
    } elseif (isset($_POST['delete_booking'])) {
        // Update status to Canceled
        $query = "UPDATE bookings SET status = 'Canceled' WHERE id = $booking_id";
        mysqli_query($conn, $query);
    } elseif (isset($_POST['finish_booking'])) {
        // Update status to Finished
        $query = "UPDATE bookings SET status = 'Finished' WHERE id = $booking_id";
        mysqli_query($conn, $query);
    }
}

// Fetch all bookings
$query = "SELECT * FROM bookings";
$result = mysqli_query($conn, $query);

$bookings = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Close connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" type="x-icon" href="logo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Admin Panel - Bookings</title>
    <style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        margin-bottom: 20px;
    }
    th, td {
        padding: 10px;  /* Adjusted for consistency with main.css */
        text-align: left;  /* Adjusted for consistency with main.css */
        border: 1px solid #dddddd;  /* Adjusted for consistency with main.css */
    }
    th {
        background-color: #34495e;  /* Adjusted to match main.css */
        color: white;  /* Adjusted to match main.css */
    }
    td button {
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    .accept-btn { 
        background-color: #92cbcc; 
        color: white; 
    }
    .delete-btn { 
        background-color: #4A628A; 
        color: white; 
    }
    .finish-btn { 
        background-color: #92cbcc; 
        color: white; 
    }
    .disabled { 
        background-color: #ccc; 
        cursor: not-allowed; 
    }
    tbody tr:nth-child(even) {
        background-color: #f2f2f2;  /* Adjusted for consistency with main.css */
    }
    tbody tr:hover {
        background-color: #ddd;  /* Adjusted for consistency with main.css */
    }
</style>

</head>
<body>
<nav class="main-menu">
    <ul>
        <li>
            <a>
                <img src="logo.png" alt="SerbiSeek Logo" style="width: 45px; height: 45px; margin-left:7px;">
            </a>
        </li>
        <li>
            <a href="main.php">
                <i class="fa fa-home fa-2x"></i>
                <span class="nav-text">Home</span>
            </a>
        </li>
        <li class="has-subnav booking-container" style="position: relative;">
            <a href="booking.php" class="booking-link">
                <i class="fa fa-ticket fa-2x"></i>
                <span class="nav-text">Booking</span>
            </a>
        </li>
        <li class="has-subnav">
            <a class="toggle-submenu">
                <i class="fa fa-film fa-2x"></i>
                <span class="nav-text">Services<span class="arrow">&#x21B4;</span></span>
            </a>
            <ul class="subnav">
                <li><a href="upload.php"><i class="fa fa-plus-circle"></i> <span class="nav-text">Upload Services</span></a></li>
                <li><a href="del_services.php"><i class="fa fa-minus-square"></i> <span class="nav-text">Delete Services</span></a></li>
            </ul>
        </li>
        <li class="has-subnav" style="position: absolute; bottom: 10px; left:0px;">
            <a href="logout.php">
                <i class="fa fa-power-off fa-2x"></i>
                <span class="nav-text">Logout</span>
            </a>
        </li>
    </ul>
</nav>
<center>
    <h1>Admin Panel - Bookings</h1>
</center>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer Name</th>
                <th>Address</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Message</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bookings as $booking): ?>
                <tr>
                    <td><?php echo $booking['id']; ?></td>
                    <td><?php echo $booking['customer_name']; ?></td>
                    <td><?php echo $booking['customer_address']; ?></td>
                    <td><?php echo $booking['customer_email']; ?></td>
                    <td><?php echo $booking['customer_contact']; ?></td>
                    <td><?php echo $booking['message']; ?></td>
                    <td><?php echo ucfirst($booking['status']); ?></td>
                    <td>
                    <?php if ($booking['status'] == 'Pending'): ?>
                        <form method="POST" action="">
                            <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                            <button type="submit" name="accept_booking">Accept</button>
                            <button type="submit" name="delete_booking">Delete</button>
                        </form>
                    <?php elseif ($booking['status'] == 'Accepted'): ?>
                        <form method="POST" action="">
                            <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                            <button type="submit" name="finish_booking">Finish</button>
                        </form>
                    <?php elseif ($booking['status'] == 'Finished'): ?>
                        <span>Finished</span>
                    <?php elseif ($booking['status'] == 'Canceled'): ?>
                        <span>Canceled</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var toggleButton = document.querySelector('.toggle-submenu');
        var subMenu = document.querySelector('.subnav');

        toggleButton.addEventListener('click', function() {
            subMenu.classList.toggle('active');
        });
    });
</script>
</body>
</html>
