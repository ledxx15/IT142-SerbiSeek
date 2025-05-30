<?php
// Include database connection
include('db_connection.php');

// Check if ID is provided
if (isset($_GET['id'])) {
    $service_id = $_GET['id'];
    echo "Service ID from GET: " . htmlspecialchars($service_id) . "<br>";

    // Fetch service details
    $query = "SELECT * FROM services WHERE id = '$service_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $service = mysqli_fetch_assoc($result);
    } else {
        echo "Service not found.";
        exit;
    }
} else {
    echo "Invalid service ID.";
    exit;
}

// Handling service update request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Debugging: Print the POST data to check the ID
    echo "POST data received: <br>";
    print_r($_POST);

    if (isset($_POST['id'])) {
        $service_id = $_POST['id'];
        $service_name = mysqli_real_escape_string($conn, $_POST['service_name']);
        $provider_name = mysqli_real_escape_string($conn, $_POST['provider_name']);
        $contact = mysqli_real_escape_string($conn, $_POST['contact']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $location = mysqli_real_escape_string($conn, $_POST['location']);

        // Update query
        $update_query = "UPDATE services SET 
                            service_name = '$service_name', 
                            provider_name = '$provider_name', 
                            contact = '$contact', 
                            email = '$email', 
                            location = '$location' 
                        WHERE id = '$service_id'";

        if (mysqli_query($conn, $update_query)) {
            // Redirect to success page after successful update
            header('Location: suc_edit.php');
            exit;
        } else {
            echo "Error updating service: " . mysqli_error($conn);
        }
    } else {
        echo "Invalid service ID.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Service</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            max-width: 600px;
            margin: auto;
        }
        label {
            display: block;
            margin: 8px 0 4px;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            padding: 10px 20px;
            color: white;
            background-color: #4CAF50;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Edit Service</h2>
    <form method="POST" action="edit_info.php">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($service['id']); ?>">
        <label for="service_name">Service Name:</label>
        <input type="text" id="service_name" name="service_name" value="<?php echo htmlspecialchars($service['service_name']); ?>"><br>
        <label for="provider_name">Provider Name:</label>
        <input type="text" id="provider_name" name="provider_name" value="<?php echo htmlspecialchars($service['provider_name']); ?>"><br>
        <label for="contact">Contact:</label>
        <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($service['contact']); ?>"><br>
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($service['email']); ?>"><br>
        <label for="location">Location:</label>
        <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($service['location']); ?>"><br>
        <button type="submit">Save Changes</button>
    </form>
</body>
</html>
