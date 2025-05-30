<?php
include('db_connection.php');

$service_id = $_GET['service_id']; // Get service_id from URL

// Fetch service details
$query = "SELECT * FROM services WHERE id = '$service_id'";
$result = mysqli_query($conn, $query);
$service = mysqli_fetch_assoc($result);

// Calculate the average rating for the service
$query = "SELECT AVG(rating) AS average_rating FROM ratings 
          INNER JOIN bookings ON bookings.id = ratings.booking_id
          WHERE bookings.service_id = '$service_id'";
$result = mysqli_query($conn, $query);
$average_rating = mysqli_fetch_assoc($result)['average_rating'];

// Display the service details and average rating
echo "<h1>" . $service['name'] . "</h1>";
echo "<p>Provider: " . $service['provider_name'] . "</p>";
echo "<p>Average Rating: " . (is_null($average_rating) ? 'No ratings yet' : round($average_rating, 1) . ' stars') . "</p>";
?>
