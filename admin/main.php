<?php
// Include database connection
include('db_connection.php');

/* ------------------------------------------------------------------
   1.  Fetch services + availability
-------------------------------------------------------------------*/
$query = "
    SELECT  s.id,
            s.provider_name,
            s.service_name,
            s.contact_no,
            s.email,
            s.location,
            CASE
                WHEN b.service_id IS NULL THEN 'NOT BOOKED'
                ELSE 'BOOKED'
            END AS availability
    FROM    services AS s
    LEFT JOIN (
        SELECT DISTINCT service_id
        FROM   bookings
        WHERE  status IN ('Pending','Accepted','Finished')
    ) AS b ON s.id = b.service_id
    ORDER BY s.id;
";

$result   = mysqli_query($conn, $query);
$services = ($result && mysqli_num_rows($result) > 0)
              ? mysqli_fetch_all($result, MYSQLI_ASSOC)
              : [];

/* ------------------------------------------------------------------
   2.  Statistics
-------------------------------------------------------------------*/
// total services
$total_services = (int) mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS c FROM services")
)['c'];

// booked services = distinct services with non-canceled bookings
$booked_services = (int) mysqli_fetch_assoc(
    mysqli_query($conn, "
        SELECT COUNT(DISTINCT service_id) AS c
        FROM bookings
        WHERE status IN ('Pending','Accepted','Finished')
    ")
)['c'];

// available = total - booked
$available_services = $total_services - $booked_services;

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" type="x-icon" href="logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="main.css">
    <title>SerbiSeek</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: #f9f9f9;
        }
        .msg {
            text-align: center;
            margin: 80px 0 20px 220px;
        }
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
        .stats-container {
            margin: 20px 220px;
            display: flex;
            gap: 20px;
        }
        .stats-box {
            flex: 1;
            background-color: #fff;
            border: 2px solid #34495e;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            transition: background-color 0.3s;
        }
        .stats-box:hover {
            background-color: #ecf0f1;
        }
        .stats-box h3 {
            margin-bottom: 10px;
            color: #2c3e50;
        }
        .stats-box p {
            font-size: 18px;
            color: #34495e;
        }
    </style>
</head>
<body>
<div class="area"></div>
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

<div class="msg">
    <h2 class="welcome-text">WELCOME TO ADMIN PANEL</h2>
    <hr style="height:5px;border-width:0;color:gray;background-color:gray;">
</div>

<!-- Stats Container -->
<div class="stats-container">
    <div class="stats-box">
        <h3>SERVICES BOOKED</h3>
        <p><?php echo $booked_services; ?> services booked</p>
    </div>
    <a href="booking.php" class="stats-box">
        <h3>CURRENT SERVICES</h3>
        <p><?php echo $total_services; ?> total services</p>
    </a>
    <div class="stats-box">
        <h3>AVAILABLE BOOKINGS</h3>
        <p><?php echo $available_services; ?> services available</p>
    </div>
</div>

<!-- Displaying Services Table -->
<div class="service-table-container">
    <?php if (count($services) > 0): ?>
        <table class="services-table">
            <caption>All Available Services</caption>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Provider Name</th>
                    <th>Service Name</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Location</th>
                    <th>Availability</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($services as $service): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($service['id']); ?></td>
                        <td><?php echo htmlspecialchars($service['provider_name']); ?></td>
                        <td><?php echo htmlspecialchars($service['service_name']); ?></td>
                        <td><?php echo htmlspecialchars($service['contact_no']); ?></td>
                        <td><?php echo htmlspecialchars($service['email']); ?></td>
                        <td><?php echo htmlspecialchars($service['location']); ?></td>
                        <td><?php echo htmlspecialchars($service['availability']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No services available.</p>
    <?php endif; ?>
</div>

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
