<?php

declare(strict_types=1);

session_start();
require '../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();


$authenticated = $_SESSION["authenticated"] ?? false;

$basePath = (strpos($_SERVER['REQUEST_URI'], '/hotel') !== false) ? '/hotel' : '';

if (!$authenticated && isset($_POST["apikey"])) {
    $api_key = $_POST["apikey"];
    if ($api_key == $_ENV["API_KEY"]) {
        $_SESSION["authenticated"] = true;
        header("Location: $basePath/admin.php");
        exit();
    } else {
        $_SESSION["authenticated"] = false;
    }
}

header("Location: $basePath/admin.php");
exit();
