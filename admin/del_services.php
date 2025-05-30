<?php
// Include database connection (adjust the path as necessary)
include('db_connection.php');

// Fetch all services from the database including the provider name
$sql = "SELECT * FROM services";  // Adjust table name if necessary
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" type="x-icon" href="logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>SerbiSeek</title>
    <style>
        .service-table-container {
    margin: 20px 220px;
}
.services-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}
.services-table caption {
    font-size: 1.5em;
    margin-bottom: 10px;
}
.services-table th,
.services-table td {
    padding: 10px;
    text-align: left;
    border: 1px solid #dddddd;
}
.services-table th {
    background-color: #34495e;
    color: white;
}
.services-table tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}
.services-table tbody tr:hover {
    background-color: #ddd;
}
.delete-btn {
    padding: 8px 16px;
    background-color: #4A628A;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    cursor: pointer;
    display: inline-block;
    text-align: center;
}
.delete-btn:hover {
    background-color: #365479;
}

        </style>
</head>
<body>
<div class="area"></div>
<nav class="main-menu">
    <ul>
        <li>
            <a>
                <img src="logo.png" alt="ticket sinema" style="width: 45px; height: 45px; margin-left:7px;">
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

<div class="msg">
    <h2 class="welcome-text">DELETE SERVICES</h2>
    <hr style="height:5px;border-width:0;color:gray;background-color:gray;">
</div>

<!-- Table to display services -->
<div class="services-table">
    <table border="1" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Provider Name</th> <!-- New Column for Provider Name -->
                <th>Service Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Location</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['provider_name'] . "</td>"; 
                    echo "<td>" . $row['service_name'] . "</td>";
                    echo "<td>" . $row['contact_no'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['location'] . "</td>";
                    echo "<td><a href='delete_service.php?id=" . $row['id'] . "' class='delete-btn'>Delete</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No services found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var toggleButton = document.querySelector('.toggle-submenu');
        var subMenu = document.querySelector('.subnav');
        var bookingContainer = document.querySelector('.booking-container');

        toggleButton.addEventListener('click', function() {
            subMenu.classList.toggle('active');
        });
    });
</script>

</body>
</html>

<?php
// Close database connection
mysqli_close($conn);
?>
