<?php
// Include database connection
include('db_connection.php');

// Check if the search term is set
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Query to fetch services based on search term
if (!empty($searchTerm)) {
    // Use LIKE for partial matching in the service name
    $searchQuery = "SELECT id, service_name, provider_name, contact_no, location, image_url 
                    FROM services 
                    WHERE service_name LIKE '%$searchTerm%'";

    $result = mysqli_query($conn, $searchQuery);
    $services = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    // If no search term, show all services
    $services = [];
}

// Close database connection
mysqli_close($conn);
?>






<!DOCTYPE html>
<html lang="en">
<head>
<link rel="shortcut icon" type="x-icon" href="logo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SerbiSeek - Service Finder</title>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
       /* Basic Reset */
       html {
    scroll-behavior: smooth;
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
            <li><a href="#home">HOME</a></li>
                <li><a href="#service">SERVICES</a></li>
                <li class="dropdown">
                    <button class="dropbtn" onclick="toggleDropdown()">FAQs ▼</button>
                    <div class="dropdown-content">
                        <a href="#aboutus">About Us</a>
                        <a href="#process">Process</a>
                        <a href="#service-faqs">Services FAQs</a>
                    </div>
                </li>
                <li><a href="#contact">CONTACT US</a></li>
                <li class="auth-buttons">
                <!-- Register Button (Redirect to register.php) -->
                <button onclick="window.location.href='logreg.php'">Register</button>

                <!-- Log In Button (Redirect to login.php) -->
                <button onclick="window.location.href='logreg.php'">Login</button>

                </li>
            </ul>
        </nav>
    </header>
    <section id="home" class="info-section">
    <section class="hero"></section>
        <h2>FAST. EFFICIENT. RELIABLE</h2>
        <div class="search-bar-container">
        <i class="bi bi-search search-icon"></i>
        <form method="GET" action="landing.php">
            <input type="text" name="search" placeholder="SEARCH SERVICES (e.g., plumber, etc.)..." value="<?php echo htmlspecialchars($searchTerm); ?>">
            <button type="submit">SEARCH</button>
        </form>
    </div>
     <!-- Display search results in HTML -->
<?php if (!empty($services)): ?>
    <!-- Display matched services -->
    <?php foreach ($services as $service): ?>
        <div class="service-card">
            <img src="<?php echo $service['image_url']; ?>" alt="<?php echo $service['service_name']; ?>">
            <div class="details">
                <h3><b><?php echo $service['service_name']; ?></b></h3>
                <p><?php echo $service['provider_name']; ?></p>
                <p>Contact: <?php echo $service['contact_no']; ?></p>
                <p>Location: <?php echo $service['location']; ?></p>
                <button class="book-now" onclick="window.location.href='booking.php?service_id=<?php echo $service['id']; ?>'">BOOK NOW</button>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <!-- If no search query is entered or no matches found -->
    <?php if (!empty($search)): ?>
        <div class="no-results">No services found matching your search.</div>
    <?php endif; ?>
<?php endif; ?>
    </section>
    <br>
    <section id="process" class="how-it-works">
    <h2>HOW IT WORKS</h2>
    <div class="steps-container">
        <div class="step">
            <i class="bi bi-search" aria-hidden="true"></i>
            <h3>1. Search for a Service</h3>
            <p>Enter the service you need in the search bar, such as plumbing, cleaning, or electrical work.</p>
        </div>
        <div class="step">
            <i class="bi bi-list-check" aria-hidden="true"></i>
            <h3>2. Browse Providers</h3>
            <p>Review a list of trusted professionals near you, including ratings, reviews, and contact details.</p>
        </div>
        <div class="step">
            <i class="bi bi-calendar-check" aria-hidden="true"></i>
            <h3>3. Book and Confirm</h3>
            <p>Select a provider and book the service at your convenience. Receive instant confirmation and updates.</p>
        </div>
        <div class="step">
            <i class="bi bi-hand-thumbs-up" aria-hidden="true"></i>
            <h3>4. Enjoy the Service</h3>
            <p>The service provider will arrive as scheduled to complete the job efficiently and professionally.</p>
        </div>
    </div>
</section>
    <!-- About Us Section -->
     <br>
<section id="aboutus" class="about-us">
        <h2>ABOUT US</h2>
        <p>
            At SerbiSeek, we are committed to connecting people with trusted service providers to make life easier. Whether you need a plumber, electrician, cleaner, or any other professional service, we ensure fast, reliable, and efficient solutions. Our platform is designed to offer users an easy and seamless experience when booking services. Our mission is to bring convenience and peace of mind to every home and business by offering top-quality services at the click of a button.
        </p>
    </section>

    <section id="service" class="service-catalogue">
    <center><h2>SERVICE CATALOGUE</h2></center>
    <br>
    <div class="service-cards">
        <?php
            // Include the PHP file that fetches and displays the services
            include('getservices_out.php');
        ?>
    </div>
</section>


 <!-- Service FAQs Section -->
 <section id="service-faqs" class="faq-section">
        <h2>SERVICE FAQs</h2>
        <div class="faq-container">
            <div class="faq-item" onclick="toggleFAQ(this)">
                <h3>What types of services can I find on SerbiSeek?</h3>
                <i class="bi bi-plus toggle-icon"></i>
                <p>SerbiSeek offers a wide variety of services including plumbing, cleaning, electrical work, and more. You can search for any service you need using the search bar.</p>
            </div>
            <div class="faq-item" onclick="toggleFAQ(this)">
                <h3>How do I book a service?</h3>
                <i class="bi bi-plus toggle-icon"></i>
                <p>After searching for a service provider, you can view their details, read reviews, and click the "Book Now" button to schedule your appointment.</p>
            </div>
            <div class="faq-item" onclick="toggleFAQ(this)">
                <h3>Are the service providers verified?</h3>
                <i class="bi bi-plus toggle-icon"></i>
                <p>Yes, all our service providers go through a rigorous verification process to ensure they meet our standards of professionalism and reliability.</p>
            </div>
            <div class="faq-item" onclick="toggleFAQ(this)">
                <h3>Can I cancel or reschedule my booking?</h3>
                <i class="bi bi-plus toggle-icon"></i>
                <p>Yes, you can manage your bookings from your account, including rescheduling or canceling your appointments with ease.</p>
            </div>
        </div>
    </section>




 <!-- Footer Section -->
 <footer>
    <section id="contact">
        <div class="footer-content">
            <div class="footer-section">
                <h3>AUTHORS</h3>
                <p>QUEEN ELSA</p>
                
            </div>

            <div class="footer-section">
                <h3>CONTACTS</h3>
                <p>Email: serbiseek@gmail.com</p>
                <p>Phone: +1234567890</p>
                <p>Location: Ilocos Norte, Philippines</p>
            </div>

            <div class="footer-section">
                <h3>SOCIALS</h3>
                <p><a href="https://www.facebook.com" target="_blank">Facebook</a></p>
                <p><a href="https://www.instagram.com" target="_blank">Instagram</a></p>
                <p><a href="https://www.twitter.com" target="_blank">Twitter</a></p>
            </div>
        </div>

        <div class="copyright">
            <p>&copy; 2024 SerbiSeek. All Rights Reserved.</p>
        </div>
</section>
    </footer>


    <script>
        // Toggle FAQ answer visibility and icon
        function toggleFAQ(faqItem) {
            faqItem.classList.toggle('open');
            var icon = faqItem.querySelector('.toggle-icon');
            if (faqItem.classList.contains('open')) {
                icon.classList.remove('bi-plus');
                icon.classList.add('bi-dash'); // Change to minus when open
            } else {
                icon.classList.remove('bi-dash');
                icon.classList.add('bi-plus'); // Change to plus when closed
            }
        }
    </script>

    <script>
        function toggleDropdown() {
            const dropdownContent = document.querySelector('.dropdown-content');
            dropdownContent.style.display = (dropdownContent.style.display === 'block') ? 'none' : 'block';
        }
    </script>
    <script>
    function toggleMenu() {
    const menu = document.querySelector('nav ul');
    menu.classList.toggle('show');
}
</script>

</body>
</html>
