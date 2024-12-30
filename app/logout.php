<?php

declare(strict_types=1);

session_start();
if (isset($_SESSION["authenticated"])) {
    unset($_SESSION["authenticated"]);
}

header("location: /admin.php");
