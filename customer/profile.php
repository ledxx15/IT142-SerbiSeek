<?php
session_start();
require_once 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../logreg.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Uploads folder
$uploadDir = __DIR__. '/uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$message = '';

// Fetch user data
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

$profilePic = !empty($user['profile_picture']) ? $user['profile_picture'] : 'default-profile.png';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contact = trim($_POST['contact_number'] ?? '');
    $address = trim($_POST['address'] ?? '');

    // PHP validation: 11-digit contact
    if (!preg_match('/^\d{11}$/', $contact)) {
        $message = "Contact number must be exactly 11 digits.";
    } else {
        // Handle profile picture
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            $tmpName = $_FILES['profile_picture']['tmp_name'];
            $imageName = basename($_FILES['profile_picture']['name']);
            $imageName = time() . '_' . preg_replace("/[^a-zA-Z0-9\._-]/", "", $imageName);
            $targetPath = $uploadDir . $imageName;
            if (move_uploaded_file($tmpName, $targetPath)) {
                $profilePic = $imageName;
            }
        }

        // Save to DB
        $update = $conn->prepare("UPDATE users SET contact_number=?, address=?, profile_picture=? WHERE id=?");
        $update->bind_param("sssi", $contact, $address, $profilePic, $user_id);
        $update->execute();
        $update->close();

        $message = "Saved successfully!";

        // Refresh user
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        $profilePic = !empty($user['profile_picture']) ? $user['profile_picture'] : 'default-profile.png';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: auto; padding: 20px; }
        img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ccc;
            display: block;
            margin: 10px auto;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            font-size: 14px;
        }
        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            box-sizing: border-box;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        input[type="text"]:focus,
        input[type="email"]:focus,
        textarea:focus {
            border-color: #4CAF50;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
            outline: none;
        }
        .buttons {
            margin-top: 15px;
            display: flex;
            gap: 15px;
        }
        .buttons input,
        .buttons button {
            flex: 1;
            padding: 10px;
            font-size: 16px;
            border: none;
            background-color: #92cbcc;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .buttons input:hover,
        .buttons button:hover {
            background-color: #4A628A;
        }
    </style>
</head>
<body>
    <h2>My Profile</h2>

    <form method="POST" enctype="multipart/form-data" onsubmit="return validateForm();">
        <label>Profile Picture:</label>
        <img src="uploads/<?php echo htmlspecialchars($profilePic); ?>" alt="Profile Picture"><br>
        <input type="file" name="profile_picture" accept="image/*">

        <label>Name:</label>
        <input type="text" value="<?php echo htmlspecialchars($user['name']); ?>" disabled>

        <label>Email:</label>
        <input type="email" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>

        <label>Contact Number:</label>
        <input type="text" name="contact_number" id="contact_number" value="<?php echo htmlspecialchars($user['contact_number'] ?? ''); ?>" required>

        <label>Address:</label>
        <textarea name="address"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>

        <div class="buttons">
            <input type="submit" value="Save">
            <button type="button" onclick="window.location.href='landing.php';">Exit</button>
        </div>
    </form>

    <?php if (!empty($message)): ?>
        <script>
            alert("<?php echo htmlspecialchars($message); ?>");
        </script>
    <?php endif; ?>

    <script>
        function validateForm() {
            const contact = document.getElementById("contact_number").value.trim();
            if (!/^\d{11}$/.test(contact)) {
                alert("Contact number must be exactly 11 digits.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>