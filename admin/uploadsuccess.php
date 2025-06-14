<!-- success.php -->

<?php
// You can include your header or any common files here

// Display a success message
echo "
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Registration Success</title>
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
            border-radius:10px;
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
    <p>Service Uploaded Successfully!;<br/>Kindly Check the service catalogue.</p>
    <div class='modal-buttons'>
        <button onclick='window.location.href=\"upload.php\"'>Upload Another</button>
        <button onclick='window.location.href=\"main.php\"'>Return Home</button>
    </div>
</div>

</body>
</html>
";
?>
