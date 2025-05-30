<?php
require __DIR__ . "/../vendor/autoload.php";

session_start(); // Start session to handle error messages or login sessions

$client = new Google\Client;

$client->setClientId("1093276350292-dnqhg7gdtvr2eb2649sr3v2v4srlu92c.apps.googleusercontent.com");
$client->setClientSecret("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");
$client->setRedirectUri("http://localhost/SerbiSeek/redirect.php");

$client->addScope("email");
$client->addScope("profile");

// Force Google to always ask for account selection
$client->setPrompt('select_account');

$url = $client->createAuthUrl();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="shortcut icon" type="x-icon" href="logo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Register</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;800&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>
<body>

<div class="container" id="container">
    <div class="form-container sign-up-container">
        <form action="auth.php" method="POST">
            <h1>Create Account</h1>
            <input type="text" placeholder="Name" name="name" required />
            <input type="email" placeholder="Email" name="email" required />
            <input type="password" placeholder="Password" name="password" required />
            <label>
                <input type="checkbox" name="terms" required /> I agree to the 
                <a href="#termsModal" id="termsLink">Terms and Conditions</a>
            </label>
            <?php if (!empty($_SESSION['registerError'])): ?>
                <p class="error-message"><?php echo $_SESSION['registerError']; ?></p>
            <?php endif; ?>
            <button type="submit" name="register">Sign Up</button>
        </form>
    </div>

    <div class="form-container sign-in-container">
        <form action="auth.php" method="POST">
            <h1>Sign in</h1>
            <input type="email" placeholder="Email" name="email" required />
            <input type="password" placeholder="Password" name="password" required />
            <a href="#">Forgot your password?</a>
            <?php if (!empty($_SESSION['loginError'])): ?>
                <p class="error-message" style="color: red; margin-top: 5px;">
                    <?php echo $_SESSION['loginError']; ?>
                </p>
            <?php endif; ?>

            <button type="submit" name="login">Sign In</button>

            <!-- Google Login Button -->
            <div style="margin-top: 15px;">
                <a href="<?= htmlspecialchars($url) ?>" style="text-decoration: none;">
                    <button type="button" style="background-color: #4285F4; color: white; border: none; padding: 10px 20px; font-size: 14px; cursor: pointer;">
                        <i class="fab fa-google" style="margin-right: 8px;"></i> Sign in with Google
                    </button>
                </a>
            </div>
        </form>
    </div>

    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <h1>Welcome Back!</h1>
                <p>To keep connected with us please login with your personal info</p>
                <button class="ghost" id="signIn">Sign In</button>
            </div>
            <div class="overlay-panel overlay-right">
                <h1>Hello, Friend!</h1>
                <p>Enter your personal details and start journey with us</p>
                <button class="ghost" id="signUp">Sign Up</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Terms and Conditions -->
<div id="termsModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Terms and Conditions</h2>
        <p>Please read the following terms and conditions carefully:</p>

        <h3>1. Introduction</h3>
        <p>These are the terms and conditions governing your use of this website...</p>

        <h3>2. User Responsibilities</h3>
        <p>As a user, you are responsible for...</p>

        <h3>3. Privacy</h3>
        <p>Your privacy is important to us...</p>

        <p>By using this website, you agree to the terms stated above.</p>

        <!-- Close button (inside modal content) -->
        <button class="ghost close-modal">Close</button>
    </div>
</div>

<script src="script.js"></script>
</body>
</html>
