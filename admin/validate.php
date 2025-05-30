<?php

include_once('db_connection.php');

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the 'email' and 'password' keys exist in the POST array
    if (isset($_POST["email"]) && isset($_POST["password"])) {
        $email = test_input($_POST["email"]);
        $password = test_input($_POST["password"]);
        
        // Prepare SQL query to check if email and password match an admin in the database
        $stmt = $conn->prepare("SELECT * FROM admins WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $password);  // Bind email and password as string parameters
        
        // Execute the query
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Check if a match is found
        if ($result->num_rows > 0) {
            // Redirect to the main page if login is successful
            header("Location: main.php");
            exit;
        } else {
            // If no match is found, show an error message
            echo "<script language='javascript'>";
            echo "alert('WRONG INFORMATION')";
            echo "</script>";
            die();
        }
        
        // Close the statement
        $stmt->close();
    } else {
        // Handle the case where email or password are not set
        echo "Email or Password is missing!";
    }
}

?>
