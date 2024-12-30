<?php

declare(strict_types=1);
session_start();

$authenticated = $_SESSION['authenticated'] ?? false;
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>

<body>


    <?php if ($authenticated) : ?>
        <p>Inside dashboard...</p>
        <a href="/app/logout.php">Logga out</a>
    <?php else : ?>
        <form action="/app/login.php" method="post">
            <label for="apikey">API key: </label>
            <input type="text" name="apikey" id="apikey" placeholder="123...">
            <button type="submit">Logga in</button>
        </form>
    <?php endif; ?>
</body>

</html>