<?php
// Include database connection
include('db_connection.php');
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Please log in first.";
    exit;
}

// Check if form submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user_id from session
    $user_id = $_SESSION['user_id'];

    // Get all POSTed form data safely using prepared statements instead of mysqli_real_escape_string
    $service_id = $_POST['service_id'] ?? '';
    $customer_name = $_POST['customer_name'] ?? '';
    $customer_address = $_POST['customer_address'] ?? '';
    $customer_email = $_POST['customer_email'] ?? '';
    $customer_contact = $_POST['customer_contact'] ?? '';
    $message = $_POST['message'] ?? '';

    // Validate required fields (you can expand this as needed)
    if (empty($service_id) || empty($customer_name) || empty($customer_address) || empty($customer_email) || empty($customer_contact)) {
        echo "Please fill all required fields.";
        exit;
    }

    // Set default booking date and status
    $booking_date = date('Y-m-d H:i:s');
    $status = 'pending';

    // Prepare the insert statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, service_id, customer_name, customer_address, customer_email, customer_contact, message, booking_date, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iisssssss", $user_id, $service_id, $customer_name, $customer_address, $customer_email, $customer_contact, $message, $booking_date, $status);

    if ($stmt->execute()) {
        // Booking success HTML
        echo "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Booking Success</title>
            <link href='https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap' rel='stylesheet'>
            <style>
                body {
                    text-align: center;
                    padding: 40px 0;
                    background: #EBF0F5;
                }
                h1 {
                    color: #4A628A;
                    font-family: 'Nunito Sans', 'Helvetica Neue', sans-serif;
                    font-weight: 900;
                    font-size: 40px;
                    margin-bottom: 10px;
                }
                p {
                    color: #404F5E;
                    font-family: 'Nunito Sans', 'Helvetica Neue', sans-serif;
                    font-size: 20px;
                    margin: 0;
                }
                .checkmark {
                    color: #4A628A;
                    font-size: 100px;
                    line-height: 200px;
                    margin-left: -15px;
                }
                .card {
                    background: white;
                    padding: 60px;
                    border-radius: 4px;
                    box-shadow: 0 2px 3px #C8D0D8;
                    display: inline-block;
                    margin: 0 auto;
                }
                .modal-buttons {
                    margin-top: 20px;
                }
                .modal-buttons button {
                    background-color: #4A628A;
                    border: none;
                    color: white;
                    padding: 10px 20px;
                    margin: 5px;
                    cursor: pointer;
                    border-radius: 10px;
                }
                .modal-buttons button:hover {
                    background-color: #92cbcc;
                }
            </style>
        </head>
        <body>
        <div class='card'>
            <div style='border-radius:200px; height:200px; width:200px; background: #92cbcc; margin:0 auto;'>
                <i class='checkmark'>✓</i>
            </div>
            <h1>Success</h1>
            <p>The Service is Booked Successfully!<br/>Kindly wait for the Confirmation from the service provider.</p>
            <div class='modal-buttons'>
                <button onclick='window.location.href=\"landing.php\"'>Book Another</button>
                <button onclick='window.location.href=\"landing.php\"'>Return Home</button>
            </div>
        </div>
        </body>
        </html>
        ";
    } else {
        echo "Error booking service: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}

$conn->close();
?>
