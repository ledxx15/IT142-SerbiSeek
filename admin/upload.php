<!DOCTYPE html>
<html lang="en">
<head>
<link rel="shortcut icon" type="x-icon" href="logo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Service Information</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* Form Wrapper */
        .form-wrapper {
            background: #ffffff;
            padding: 20px 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        /* Form Header */
        h1 {
            font-size: 24px;
            margin-bottom: 10px;
            text-align: center;
        }

        p {
            font-size: 14px;
            color: #666;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Labels and Inputs */
        label {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }

        textarea {
            resize: none;
        }

        /* Buttons */
        button {
            width: 100%;
            background-color: #465a78;
            color: #ffffff;
            font-size: 16px;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-transform: uppercase;
            transition: background 0.3s ease;
            margin-top: 10px; /* Space above the button */
        }

        button:hover {
            background-color: #394b66;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .form-wrapper {
                padding: 15px 20px;
            }

            h1 {
                font-size: 20px;
            }

            button {
                font-size: 14px;
                padding: 10px;
            }
        }

        /* Optional Error Styling */
        .error-message {
            color: red;
            font-size: 12px;
            margin-top: -10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="form-wrapper">
    <h1>Service Information</h1>
    <p>Details about the Service offered.</p>
    
    <form action="upload_service.php" method="POST" enctype="multipart/form-data">
        
        <label for="full_name">Full Name</label>
        <input type="text" id="full_name" name="full_name" placeholder="Value" required>

        <label for="service">Service</label>
        <input type="text" id="service" name="service" placeholder="(e.g., Plumber)" required>

        <label for="contact_no">Contact No.</label>
        <input type="text" id="contact_no" name="contact_no" placeholder="Value" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Value" required>

        <label for="location">Location</label>
        <input type="text" id="location" name="location" placeholder="Value" required>

        <label for="license">Licenses (If applicable)</label>
        <input type="text" id="license" name="license" placeholder="Type NA if none">

        <label for="description">Brief Description</label>
        <textarea id="description" name="description" placeholder="(e.g., description about the service, notes to customer)" rows="4" required></textarea>

        <label for="image">Upload Image</label>
        <input type="file" id="image" name="image" accept="image/jpeg, image/png, image/gif" required>

        <button type="submit">Upload Service</button>
        
    </form>

    <!-- Return Home button -->
    <form action="main.php" method="get">
        <button type="submit" class="return-home">Return Home</button>
    </form>

</div>

</body>
</html>
