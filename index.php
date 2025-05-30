<?php
require __DIR__ . "/vendor/autoload.php";

$client = new Google\Client;

$client->setClientId("1093276350292-dnqhg7gdtvr2eb2649sr3v2v4srlu92c.apps.googleusercontent.com");
$client->setClientSecret("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");
$client->setRedirectUri("http://localhost/SerbiSeek/redirect.php");

$client->addScope("email");
$client->addScope("profile");

$url = $client->createAuthUrl();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Google Login Example</title>
</head>
<body>

    <a href="<?= htmlspecialchars($url) ?>">Sign in with Google</a>

</body>
</html>
