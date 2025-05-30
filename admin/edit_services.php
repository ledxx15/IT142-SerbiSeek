<?php
// Include database connection
include('db_connection.php');

// Fetch all services from the database
$query = "SELECT * FROM services";
$result = mysqli_query($conn, $query);

// Check if there are services in the database
if (mysqli_num_rows($result) > 0) {
    $services = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $services = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="x-icon" href="tsinema.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="main.css">
    <title>Service List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .edit-button {
            padding: 6px 12px;
            color: white;
            background-color: #4CAF50;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .edit-button:hover {
            background-color: #45a049;
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
                <li><a href="edit_services.php"><i class="fa fa-pencil"></i> <span class="nav-text">Edit Services</span></a></li>
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
    <h2>Service List</h2>
    <table>
        <thead>
            <tr>
                <th>Service Name</th>
                <th>Provider Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Location</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($services as $service): ?>
                <tr>
                    <td><?php echo htmlspecialchars($service['service_name']); ?></td>
                    <td><?php echo htmlspecialchars($service['provider_name']); ?></td>
                    <td><?php echo htmlspecialchars($service['contact_no']); ?></td>
                    <td><?php echo htmlspecialchars($service['email']); ?></td>
                    <td><?php echo htmlspecialchars($service['location']); ?></td>
                    <td>
                        <form method="GET" action="edit_info.php">
                            <input type="hidden" name="id" value="<?php echo $service['id']; ?>">
                            <button type="submit" class="edit-button">Edit</button>
                        </form>
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
