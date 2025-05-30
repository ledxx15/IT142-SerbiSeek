<?php
// Database connection
$servername = "localhost";
$username = "root";  // your database username
$password = "";  // your database password
$dbname = "serbiseek_db";   // your database name

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch all services from the database
$sql = "SELECT id, service_name, provider_name, contact_no, email, location, license, description, image_url FROM services";
$result = $conn->query($sql);

// Check if the query was successful
if ($result === false) {
    die("Error with the SQL query: " . $conn->error);
}

// Check if any services are found
if ($result->num_rows > 0) {
    // Start output buffering to collect the HTML
    ob_start();
    while ($row = $result->fetch_assoc()) {
        ?>
        <div class="service-card">
        <img src="<?php echo $row['image_url']; ?>" alt="<?php echo $row['service_name']; ?>">
            <div class="details">
                <h3><b><?php echo $row['service_name']; ?></b></h3>
                <p><?php echo $row['provider_name']; ?></p>
                <p>Contact: <?php echo $row['contact_no']; ?></p>
                <p>Location: <?php echo $row['location']; ?></p>
                <button class="book-now" onclick="window.location.href='book.php?service_id=<?php echo $row['id']; ?>'">BOOK NOW</button>
            </div>
            </div>
        </div>
        <?php
    }
    // Get the collected HTML and store it in a variable
    $serviceCards = ob_get_clean();
    echo $serviceCards;
} else {
    echo "No services found.";
}

// Close connection
$conn->close();
?>
