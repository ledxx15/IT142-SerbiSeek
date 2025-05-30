<?php
session_start();

require __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/customer/db_connection.php";  // Database connection

// Google OAuth setup
$client = new Google\Client();
$client->setClientId("1093276350292-dnqhg7gdtvr2eb2649sr3v2v4srlu92c.apps.googleusercontent.com");
$client->setClientSecret("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");
$client->setRedirectUri("http://localhost/SerbiSeek/redirect.php");
$client->addScope("email");
$client->addScope("profile");

// Check if Google OAuth code exists
if (!isset($_GET['code'])) {
    exit("No code parameter");
}

// Get the access token
$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

if (isset($token['error'])) {
    exit("Token error: " . $token['error']);
}

$client->setAccessToken($token['access_token']);

// Get user info from Google
$oauth = new Google\Service\Oauth2($client);
$userinfo = $oauth->userinfo->get();

$email = $userinfo->email;
$first_name = $userinfo->givenName;
$last_name = $userinfo->familyName;
$full_name = $userinfo->name;

// Hash for OAuth-only users (so password column isn't empty)
$placeholder_password = password_hash("google_oauth_user_placeholder", PASSWORD_DEFAULT);

// Check if user already exists
$sql = "SELECT id, name FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Existing user
    $stmt->bind_result($user_id, $user_name);
    $stmt->fetch();
    $stmt->close();
} else {
    // New user, insert into DB
    $stmt->close();
    $insert_sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("sss", $full_name, $email, $placeholder_password);
    $insert_stmt->execute();
    $user_id = $insert_stmt->insert_id;
    $user_name = $full_name;
    $insert_stmt->close();
}

$conn->close();

// Save necessary info to session for profile.php
$_SESSION['user_id'] = $user_id;
$_SESSION['user_email'] = $email;
$_SESSION['user_name'] = $user_name;
$_SESSION['user_first_name'] = $first_name;
$_SESSION['user_last_name'] = $last_name;

// Redirect to landing page
header("Location: http://localhost/SerbiSeek/customer/landing.php");
exit();
