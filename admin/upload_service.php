<?php
session_start();
include('db_connection.php');

// Check if the user is logged in
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $service_name = $_POST['service'];
    $provider_name = $_POST['full_name'];
    $contact_no = $_POST['contact_no'];
    $email = $_POST['email'];
    $location = $_POST['location'];
    $license = $_POST['license'] ?: 'NA';  // Default to 'NA' if empty
    $description = $_POST['description'];

    // Handle file upload
    $image = $_FILES['image'];
    $image_name = basename($image['name']);
    $target_dir = "./";  // Save directly in the root directory
    $target_file = $target_dir . $image_name;
    
    // Move the uploaded file to the desired directory
    if (move_uploaded_file($image['tmp_name'], $target_file)) {
        // File uploaded successfully, insert service data into database
        $servername = "localhost";
        $username = "root";  // your database username
        $password = "";  // your database password
        $dbname = "serbiseek_db";   // your database name

        // Create database connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare SQL query to insert service data
        $sql = "INSERT INTO services (service_name, provider_name, contact_no, email, location, license, description, image_url, user_id) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssi", $service_name, $provider_name, $contact_no, $email, $location, $license, $description, $image_name, $user_id);

        // Execute the query
        if ($stmt->execute()) {
            // Redirect to uploadsuccess.php after successful upload
            header("Location: uploadsuccess.php");
            exit();  // Ensure no further code is executed after the redirect
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the connection
        $stmt->close();
        $conn->close();
    } else {
        echo "Error uploading the image.";
    }
}
?>
