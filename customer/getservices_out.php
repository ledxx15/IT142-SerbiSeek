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

// Query to fetch all services and their average ratings
$sql = "
    SELECT 
        s.id, s.service_name, s.provider_name, s.contact_no, s.email, s.location, 
        s.license, s.description, s.image_url,
        IFNULL(AVG(r.rating), 0) AS average_rating,   -- Calculate average rating, 0 if no ratings
        COUNT(r.id) AS review_count                    -- Count the number of reviews
    FROM services s
    LEFT JOIN ratings r ON s.id = r.service_id
    GROUP BY s.id
";
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

                <!-- Display rating and review count -->
                <div class="rating">
                    <span class="star">&#9733;</span> <!-- Star icon for rating -->
                    <span><?php echo number_format($row['average_rating'], 1); ?> / 5</span> 
                    <span>(<?php echo $row['review_count']; ?> Reviews)</span>
                </div>

                <button class="book-now" onclick="window.location.href='logreg.php'">BOOK NOW</button>
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

