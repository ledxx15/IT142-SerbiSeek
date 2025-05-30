<?php
// Include database connection
include('db_connection.php');

// Start session to get customer information
session_start();

// Check if the customer is logged in
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header('Location: logreg.php'); // Redirect to login if session is not set
    exit;
}

$user_id = $_SESSION['user_id']; // Retrieve user ID from session

// Debug print (optional)
// echo "<pre>"; print_r($_SESSION); echo "</pre>";

// Fetch bookings specific to the logged-in customer
$query = "
    SELECT 
        b.id AS booking_id,
        LOWER(b.status) AS status,
        s.service_name, 
        s.provider_name, 
        s.contact_no, 
        b.booking_date
    FROM bookings AS b
    INNER JOIN services AS s ON b.service_id = s.id
    WHERE b.user_id = '$user_id'
    ORDER BY b.booking_date DESC
";

$result = mysqli_query($conn, $query);

// Check if query execution is successful
if (!$result) {
    die("Error in query: " . mysqli_error($conn));
}

// Fetch all bookings
$bookings = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" type="x-icon" href="logo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Bookings</title>
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

        table {
            width: 90%;
            border-collapse: collapse;
            margin: 20px auto;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        td {
            font-size: 14px;
        }

        .rate-button {
            background-color: #92cbcc;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .rate-button:hover {
            background-color: #4A628A;
        }

        .return-home-btn {
            display: block;
            width: 200px;
            margin: 30px auto;
            padding: 10px;
            text-align: center;
            background-color: #92cbcc;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        .return-home-btn:hover {
            background-color: #4A628A;
        }
        body, h1, h2, ul, li {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5;
}

/* Sticky Navbar */
header {
    background-color: #a7e0e2;
    padding: 10px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 2px solid #8dc5c8;
    position: sticky;
    top: 0; /* Sticks the navbar to the top */
    z-index: 1000; /* Ensures the navbar stays above other content */
}

nav {
    font-family: Arial, sans-serif;
}

.logo {
    display: flex;
    align-items: center;
}

.logo img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 10px;
}

.logo h1 {
    font-size: 1rem;
    font-weight: bold;
    color: black;
}

nav ul {
    list-style: none;
    display: flex;
    gap: 20px;
    align-items: center;
}
/* Dropdown Menu */
.dropdown-content {
    display: none;
    position: absolute;
    background-color: #ffffff; /* Solid white background */
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
    border-radius: 8px; /* Optional: Rounds the corners */
}

.dropdown-content a {
    color: #333;
    padding: 10px 15px;
    text-decoration: none;
    display: block;
    transition: background-color 0.3s ease;
}

.dropdown-content a:hover {
    background-color: #f1f1f1; /* Subtle hover effect */
}

/* Show the dropdown when hovered */
.dropdown:hover .dropdown-content {
    display: block;
}


nav ul {
    display: flex;
    gap: 20px;
}
@media (max-width: 768px) {
    nav ul {
        flex-direction: column;
        align-items: flex-start;
        padding: 10px;
        position: absolute;
        top: 100%;
        right: 0; /* Position it to the right side */
        width: 300px; /* Adjust the width as needed */
        display: none;
        background-color: rgba(255, 255, 255, 0.9); /* Slightly opaque white background */
        border-radius: 0 0 8px 8px; /* Rounded corners for a polished look */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Optional: Add a shadow */
    }

    nav ul.show {
        display: flex; /* Show menu when toggled */
    }

    .dropdown {
        position: static; /* Adjust for stacked menu */
    }
}

/* Hamburger Menu for Mobile */
.hamburger {
    display: none;
    cursor: pointer;
    font-size: 1.5rem;
}

@media (max-width: 768px) {
    .hamburger {
        display: block; /* Show hamburger on small screens */
    }
}
nav a {
    text-decoration: none;
    color: #333;
    font-weight: bold;
    padding: 8px 15px;
    transition: background-color 0.3s;
}

nav a:hover {
    background-color: #92cbcc;
    border-radius: 5px;
}

.auth-buttons button {
    background-color: #4A628A;
    color: white;
    border: none;
    padding: 10px 15px;
    font-weight: bold;
    cursor: pointer;
    border-radius: 5px;
    font-size: 14px;
    margin: 0 5px;
}

.auth-buttons button:hover {
    background-color: #92cbcc;
}

.dropdown {
    position: relative;
}

.dropbtn {
    background-color: #a7e0e2;
    color: #333;
    border: none;
    cursor: pointer;
    font-size: 14px;
    font-weight: bold;
    padding: 10px 15px;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: white;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

.dropdown-content a {
    color: #333;
    padding: 10px 15px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {
    background-color: #ddd;
}

/* Hero Section */
.hero {
    background-image: url('pic.jpg');
    background-size: cover;
    background-position: center;
    height: 250px;
}

/* Info Section */
.info-section {
    text-align: center;
    padding: 30px 0;
    background-color: #ffffff;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}

.info-section h2 {
    font-family: 'Archivo Black', sans-serif;
    font-size: 2.5rem;
    color: black;
    margin-bottom: 20px;
}

.search-bar-container {
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #d5f4f7;
    border-radius: 30px;
    padding: 10px;
    width: 60%; /* Adjust width as necessary */
    max-width: 600px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    margin: 20px auto; /* Added 'auto' to center horizontally */
    position: relative;
    transition: background-color 0.3s ease;
}


        .search-bar-container input {
            flex: 1;
            border: none;
            outline: none;
            background-color: transparent;
            font-size: 1rem;
            color: #333;
            padding: 5px 15px;
            padding-left: 40px;
        }

        .search-bar-container input::placeholder {
            color: #999;
        }

        .search-bar-container button {
            background-color:#B9E5E8;
            border: none;
            border-radius: 20px;
            padding: 8px 20px;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: bold;
            transition: background-color 0.3s;
            margin-left:200px;
        }

        .search-bar-container button:hover {
            background-color: #4A628A;
            color:white;
        }

        .search-icon {
            position: absolute;
            left: 15px;
            color: #888;
            font-size: 1.5rem;
            font-weight: bold;
            transition: opacity 0.3s ease;
        }

        .search-bar-container input:focus~.search-icon {
            opacity: 0;
        }

 /* Styles for displaying search results */
 .service-card {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .service-card img {
            max-width: 150px;
            height: auto;
            border-radius: 5px;
        }

        .details {
            flex: 1;
            margin-left: 20px;
        }

        .details h3 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .details p {
            margin: 5px 0;
            color: #555;
        }

        .book-now {
            background-color: #92cbcc;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            font-size: 16px;
        }

        .book-now:hover {
            background-color: #4A628A;
        }

        /* No results styling */
        .no-results {
            text-align: center;
            font-size: 18px;
            color: red;
            font-weight: bold;
        }
        .how-it-works {
    text-align: center;
    padding: 50px 20px;
    background-color: #f5f5f5;
}

.how-it-works h2 {
    font-family: 'Archivo Black', sans-serif;
    font-size: 2.5rem;
    margin-bottom: 40px;
    color: #333;
}

/* Grid layout like service-cards */
.steps-container {
    display: grid;
    grid-template-columns: repeat(4, 1fr); /* Ensures 4 equal columns */
    gap: 20px;
    justify-items: center;
    max-width: 1200px;
    margin: 0 auto;
}

/* Responsive Design for Smaller Screens */
@media (max-width: 992px) {
    .steps-container {
        grid-template-columns: repeat(2, 1fr); /* 2 columns for medium screens */
    }
}

@media (max-width: 600px) {
    .steps-container {
        grid-template-columns: 1fr; /* Single column for small screens */
    }
}


.step {
    background-color: white;
    border-radius: 12px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    text-align: center;
    transition: transform 0.3s ease;
}

.step:hover {
    transform: translateY(-5px);
}


.step i {
    font-size: 3rem;
    color: #4A628A;
    margin-bottom: 15px;
}

.step h3 {
    font-size: 1.5rem;
    margin: 10px 0;
    color: #333;
}

.step p {
    font-size: 1rem;
    color: #666;
    line-height: 1.5;
}

/* About Us Section */
.about-us {
    background-color: #e0f7fa; /* Updated background color */
    padding: 100px 20px;
    text-align: center;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}

.about-us h2 {
    font-family: 'Archivo Black', sans-serif;
    font-size: 2rem;
    color: black;
    margin-bottom: 20px;
}
.service-catalogue h2{
    font-family: 'Archivo Black', sans-serif;
    font-size: 2rem;
    color: black;
    margin-bottom: 20px;
}

.about-us p {
    font-size: 1.1rem;
    color: #666;
    line-height: 1.6;
    max-width: 800px;
    margin: 0 auto;
}


        /* Service Catalogue Tile Boxes */
        .service-catalogue {
    padding: 40px 20px;
    background-color: #f5f5f5;
    display: flex; /* Use flexbox to center content */
    flex-direction: column; /* Stack the heading and cards vertically */
    align-items: center; /* Center content horizontally */
    justify-content: center; /* Center content vertically */
}

.service-catalogue h2 {
    font-family: 'Archivo Black', sans-serif;
    font-size: 2rem;
    color: black;
    margin-bottom: 20px;
}

.service-catalogue .service-cards {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); /* Auto-layout grid */
    gap: 30px;
    justify-items: center; /* Centers each card inside the grid */
    max-width: 1200px; /* Optional: Adds a max-width to prevent too wide layout */
    width: 100%; /* Ensures the grid takes up available space */
}

.service-catalogue .service-card {
    background-color: white;
    width: 100%;
    border-radius: 12px;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: transform 0.3s ease;
}

        .service-catalogue .service-card:hover {
            transform: translateY(-5px);
            background-color: #f0f8ff;
        }
        .service-catalogue .service-card:hover .details h3,
        .service-catalogue .service-card:hover .details p {
    color: #007b7f; /* Dark teal text color when hovered */
}
        .service-catalogue .service-card img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%; /* Makes the image circular */
    margin: 15px auto; /* Centers the image inside the card */
    display: block;
        }

        .service-catalogue .service-card .details {
    padding: 15px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: center; /* Vertically center the content */
    align-items: center; /* Horizontally center the content */
    text-align: center; /* Center the text inside the details */
}

.service-catalogue .service-card .details h3 {
    font-size: 1.2rem;
    margin: 0 0 10px;
    font-weight: bold;
}

.service-catalogue .service-card .details p {
    font-size: 1rem;
    color: #666;
    margin: 5px 0;
}

.service-catalogue .service-card .details .rating {
    font-size: 1rem;
    color: #f39c12;
}

.service-catalogue .service-card .details .book-now {
    margin-top: 10px;
    background-color: #4A628A;
    color: white;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    font-size: 1rem;
    transition: background-color 0.3s;
    border-radius: 10px;
}

.service-catalogue .service-card .details .book-now:hover {
    background-color: #92cbcc;
}

 /* New FAQ Section */
 .faq-section {
            padding: 40px 20px;
            background-color: #f5f5f5;
            text-align: center;
        }

        .faq-section h2 {
            font-family: 'Archivo Black', sans-serif;
            font-size: 2rem;
            color: black;
            margin-bottom: 20px;
        }

        .faq-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            max-width: 800px;
            margin: 0 auto;
        }

        .faq-item {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 100%;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .faq-item:hover {
            transform: translateY(-5px);
            background-color: #e0f7fa;
        }

        .faq-item h3 {
            font-size: 1.2rem;
            margin: 0;
            color: #333;
        }

        .faq-item p {
            font-size: 1rem;
            color: #666;
            margin: 10px 0 0;
            display: none;
        }

        .faq-item.open p {
            display: block;
        }
 /* Footer Section */
 footer {
    background-color: #4A628A;
    color: white;
    padding: 30px 20px;
    text-align: center;
}

.footer-content {
    display: flex;
    justify-content: space-between; /* Distribute space evenly */
    flex-wrap: wrap; /* Allow wrapping on smaller screens */
    max-width: 1000px;
    margin: 0 auto;
    text-align: left;
    width: 100%;
}

.footer-section {
    flex: 1; /* Make sections equal width */
    min-width: 200px; /* Ensure sections don't get too narrow */
    padding: 0 10px;
    text-align: center; /* Center content for better alignment */
}



.footer-section h3 {
    font-size: 1.2rem;
    margin-bottom: 10px;
}

.footer-section p,
.footer-section a {
    font-size: 1rem;
    margin: 5px 0;
    color: white;
    text-decoration: none;
}

.footer-section a:hover {
    text-decoration: underline;
}

.social-icons a {
    margin: 0 15px;
    font-size: 1.5rem;
    color: white;
    text-decoration: none;
}

.social-icons a:hover {
    color: #92cbcc;
}

.copyright {
    font-size: 1rem;
    margin-top: 20px;
    color: #ddd;
}
/* The Modal Background */
.modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        background-color: rgba(0, 0, 0, 0.5); /* Black with opacity */
        overflow: auto; /* Enable scrolling if needed */
        padding-top: 100px; /* Position the modal at the top */
    }

    /* Modal Content Box */
    .modal-content {
        background-color: #fff;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 300px;
        text-align: center;
        border-radius: 10px;
    }

.btn {
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    margin: 5px;
    border-radius: 5px;
}

.btn-yes {
    background-color: #4A628A;
    color: white;
}

.btn-no {
    background-color: #4A628A;
    color: white;
}
/* Hover Effect */
.btn-yes:hover {
        background-color: #92cbcc; /* Slightly darker green */
        transform: scale(1.1); /* Enlarge the button slightly */
    }

    .btn-no:hover {
        background-color: #92cbcc; /* Slightly darker red */
        transform: scale(1.1); /* Enlarge the button slightly */
    }

    .btn-yes:active, .btn-no:active {
        transform: scale(1); /* Reset scale when clicked */
    }

    .btn-yes:hover, .btn-no:hover {
        opacity: 0.9; /* Slight opacity change on hover */
    }
    /* Add this CSS in your <style> block or in an external stylesheet */

.service-card {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #fff;
}

.service-card img {
    max-width: 150px;
    height: auto;
    border-radius: 5px;
}

.details {
    flex: 1;
    margin-left: 20px;
}

.details h3 {
    margin: 0;
    font-size: 18px;
    font-weight: bold;
}

.details p {
    margin: 5px 0;
}

.rating {
    margin-top: 10px;
    font-size: 14px;
}

.star {
    color: #FFD700;
}

.book-now {
    background-color: #92cbcc;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 10px;
}

.book-now:hover {
    background-color: #4A628A;
}

<style>
/* Content Area Styling */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 20px;
    background-color: #f5f7fa;
    color: #333;
}

h2 {
    text-align: center;
    margin-top: 30px;
    font-size: 2rem;
    color: #222;
}

/* Table Styling */
table {
    width: 90%;
    margin: 30px auto;
    border-collapse: collapse;
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

table th, table td {
    padding: 15px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

table th {
    background-color: #4A628A;
    color: white;
    text-transform: uppercase;
    letter-spacing: 1px;
}

table tr:hover {
    background-color: #f1f1f1;
}

/* Status Color Tags */
td span {
    font-weight: bold;
}

/* Rate Button */
.rate-button {
    background-color: #28a745;
    color: white;
    padding: 8px 16px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.rate-button:hover {
    background-color: #218838;
}

/* Return Home Button */
.return-home-btn {
    display: block;
    margin: 40px auto 20px auto;
    padding: 10px 25px;
    background-color: #92cbcc;
    color: white;
    font-size: 1rem;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.return-home-btn:hover {
    background-color: #4A628A;
}

/* No Bookings Message */
p {
    font-size: 1.2rem;
    color: #666;
}
</style>

    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="logo.png" alt="SerbiSeek Logo">
            <h1>SerbiSeek</h1>
        </div>
        <nav>
        <div class="hamburger" onclick="toggleMenu()">☰</div>
            <ul>
            <li><a href="landing.php#home">HOME</a></li>
                <li><a href="landing.php#service">SERVICES</a></li>
                <li class="dropdown">
                    <button class="dropbtn" onclick="toggleDropdown()">FAQs ▼</button>
                    <div class="dropdown-content">
                        <a href="landing.php#aboutus">About Us</a>
                        <a href="landing.php#process">Process</a>
                        <a href="landing.php#service-faqs">Services FAQs</a>
                    </div>
                </li>
                <li><a href="landing.php#contact">CONTACT US</a></li>
                <li class="auth-buttons">
                <!-- Register Button (Redirect to register.php) -->
                 
                <button onclick="window.location.href='landing.php#service'">Book Service</button>

                <li class="dropdown">
                <button class="dropbtn" onclick="toggleDropdown()">Profile ▼</button>
                    <div class="dropdown-content">
                    <a href="profile.php">Profile</a>
                    <a href="track.php">Track Service</a>
                    <a href="history.php">History</a>
                    <a href="#" onclick="confirmLogout(event)">Logout</a>
                    </div>
                    </li>
                </li>
            </ul>
        </nav>
    </header>
    </style>
</head>
<body>
    
    <h2>Your Bookings</h2>

    <?php if (count($bookings) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Service Name</th>
                    <th>Provider Name</th>
                    <th>Contact</th>
                    <th>Booking Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($booking['service_name']); ?></td>
                        <td><?php echo htmlspecialchars($booking['provider_name']); ?></td>
                        <td><?php echo htmlspecialchars($booking['contact_no']); ?></td>
                        <td><?php echo date("F j, Y", strtotime($booking['booking_date'])); ?></td>
                        <td>
                            <?php 
                                switch (strtolower($booking['status'])) {
                                    case 'pending': echo "<span style='color: orange;'>Pending</span>"; break;
                                    case 'booked': echo "<span style='color: blue;'>Booked</span>"; break;
                                    case 'accepted': echo "<span style='color: green;'>Accepted</span>"; break;
                                    case 'finished': echo "<span style='color: green;'>Finished</span>"; break;
                                    case 'canceled': echo "<span style='color: red;'>Canceled</span>"; break;
                                    default: echo htmlspecialchars($booking['status']);
                                }
                            ?>
                        </td>
                        <td>
                            <?php if (strtolower($booking['status']) === 'finished'): ?>
                                <form method="POST" action="rate_service.php">
                                    <input type="hidden" name="booking_id" value="<?php echo $booking['booking_id']; ?>">
                                    <button type="submit" class="rate-button">Rate</button>
                                </form>
                            <?php else: ?>
                                <span>N/A</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
   <?php else: ?>
    <p style="text-align: center; margin-top: 50px;">No bookings found.</p>
    <?php endif; ?>

    <!-- Return Home Button -->
    <form action="landing.php" method="get">
        <button type="submit" class="return-home-btn">Return Home</button>
    </form>
</body>
</html>