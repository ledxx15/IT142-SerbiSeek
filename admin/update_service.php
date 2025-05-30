<?php
// Include database connection
include('db_connection.php');

// Check if the form is submitted
if (isset($_POST['edit_service'])) {
    // Loop through the services and update the details
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'provider_name_') !== false) {
            $service_id = str_replace('provider_name_', '', $key);
            $provider_name = mysqli_real_escape_string($conn, $value);
            $service_name = mysqli_real_escape_string($conn, $_POST['service_name_' . $service_id]);
            $contact = mysqli_real_escape_string($conn, $_POST['contact_' . $service_id]);
            $email = mysqli_real_escape_string($conn, $_POST['email_' . $service_id]);
            $location = mysqli_real_escape_string($conn, $_POST['location_' . $service_id]);

            // Update the service details in the database
            $query = "UPDATE services SET provider_name = '$provider_name', service_name = '$service_name', contact = '$contact', email = '$email', location = '$location' WHERE id = $service_id";
            $result = mysqli_query($conn, $query);

            if ($result) {
                echo "Service ID $service_id updated successfully!";
            } else {
                echo "Failed to update Service ID $service_id.";
            }
        }
    }
}

// Close the database connection
mysqli_close($conn);
?>
