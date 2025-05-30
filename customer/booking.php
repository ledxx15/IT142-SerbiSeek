<?php
session_start();
include('db_connection.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Please log in to book a service.";
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch logged-in user's profile info for autofill
$userQuery = "SELECT name, email, address, contact_number FROM users WHERE id = ?";
$stmtUser = $conn->prepare($userQuery);
$stmtUser->bind_param("i", $user_id);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();
$user = $resultUser->fetch_assoc();
$stmtUser->close();

// Retrieve the service_id from the URL
$service_id = $_GET['service_id'] ?? null;

if (!$service_id) {
    echo "Invalid service selected.";
    exit;
}

// Fetch the service details based on service_id
$query = "SELECT * FROM services WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $service_id);
$stmt->execute();
$result = $stmt->get_result();
$service = $result->fetch_assoc();
$stmt->close();

if (!$service) {
    echo "Service not found.";
    exit;
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" type="x-icon" href="logo.png">
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Book a Service</title>
    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        h2.title {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }

        .container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin: 20px auto;
            max-width: 800px;
        }

        /* Left panel as square box */
        .left-panel {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #ccc;
            height: 300px;
            width: 100%;
            max-width: 300px;
            margin: 0 auto;
        }

        .left-panel h3 {
            margin-top: 0;
            font-size: 1.1rem;
            color: #333;
            text-align: center;
        }

        .left-panel img {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .left-panel p {
            margin: 5px 0;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        .left-panel strong {
            font-weight: bold;
        }

        /* Right panel styling (Booking form) */
        .right-panel {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #ccc;
            min-height: 500px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        form label {
            font-weight: bold;
            margin-bottom: 0px;
            font-size: 0.9rem;
        }

        form input[type="text"],
        form input[type="email"],
        form textarea {
            padding: 10px;
            margin-bottom: 0px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            width: 100%;
            box-sizing: border-box;
        }

        form button {
            background-color: #92cbcc;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            font-size: 1rem;
            width: 100%;
        }

        form button:hover {
            background-color: #4A628A;
        }

        /* Cancel button styling */
        .cancel-button {
            background-color: #92cbcc;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            margin-top: 10px;
            width: 100%;
        }

        .cancel-button:hover {
            background-color: #4A628A;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
                gap: 15px;
            }
        }
    </style>
</head>
<body>

<h2 class="title">Book a Service: <?php echo htmlspecialchars($service['service_name']); ?></h2>

<div class="container">
    <div class="left-panel">
        <h3>Service Provider Information</h3>
        <img src="<?php echo htmlspecialchars($service['image_url']); ?>" alt="Service Provider Image" />
        <p><strong>Provider Name:</strong> <?php echo htmlspecialchars($service['provider_name']); ?></p>
        <p><strong>Service Name:</strong> <?php echo htmlspecialchars($service['service_name']); ?></p>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($service['description']); ?></p>
        <p><strong>Contact No.:</strong> <?php echo htmlspecialchars($service['contact_no']); ?></p>
        <p><strong>Location:</strong> <?php echo htmlspecialchars($service['location']); ?></p>
        <p><strong>License:</strong> <?php echo htmlspecialchars($service['license']); ?></p>
    </div>

    <div class="right-panel">
        <h3>Customer Booking Form</h3>
        <form method="POST" action="booksuccess.php">
            <input type="hidden" name="service_id" value="<?php echo htmlspecialchars($service_id); ?>">

            <label for="customer_name">Name:</label>
            <input
                type="text"
                id="customer_name"
                name="customer_name"
                required
                value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>"
            />

            <label for="customer_address">Address:</label>
            <textarea
                id="customer_address"
                name="customer_address"
                required
            ><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>

            <label for="customer_email">Email:</label>
            <input
                type="email"
                id="customer_email"
                name="customer_email"
                required
                value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>"
            />

            <label for="customer_contact">Contact Number:</label>
            <input
                type="text"
                id="customer_contact"
                name="customer_contact"
                required
                value="<?php echo htmlspecialchars($user['contact_number'] ?? ''); ?>"
            />

            <label for="message">Message:</label>
            <textarea id="message" name="message"></textarea>

            <button type="submit">Submit Booking</button>

            <a href="landing.php">
                <button type="button" class="cancel-button">Cancel</button>
            </a>
        </form>
    </div>
</div>

</body>
</html>
