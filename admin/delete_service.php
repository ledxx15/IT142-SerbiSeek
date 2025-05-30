<?php
include('db_connection.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM services WHERE id = $id";
    
    if (mysqli_query($conn, $sql)) {
        echo "Service deleted successfully!";
        header("Location: del_services.php"); // Redirect back to the service listing page
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
