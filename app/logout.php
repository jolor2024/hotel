<?php

declare(strict_types=1);

session_start();
if (isset($_SESSION["authenticated"])) {
    unset($_SESSION["authenticated"]);
}

$basePath = (strpos($_SERVER['REQUEST_URI'], '/hotel') !== false) ? '/hotel' : '';
header("Location: $basePath/admin.php");
exit();
