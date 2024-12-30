<?php

declare(strict_types=1);
session_start();

$authenticated = $_SESSION['authenticated'] ?? false;


// Default values 
if ($authenticated) {
    $data = [ //Läs in först filen ifall inte finns...
        "starRating" => 5,
        "discount" => 3,
        "budgetPrice" => 2,
        "standardPrice" => 5,
        "luxuryPrice" => 10,
        "coffeemakerPrice" => 1,
        "tvPrice" => 2,
        "minibarPrice" => 3
    ];

    if (
        isset($_POST["star_rating"]) &&
        isset($_POST["discount"]) &&
        isset($_POST["budget-price"]) &&
        isset($_POST["standard-price"]) &&
        isset($_POST["luxury-price"]) &&
        isset($_POST["coffeemaker-price"]) &&
        isset($_POST["tv-price"]) &&
        isset($_POST["minibar-price"])
    ) {
        $data["starRating"] = $_POST["star_rating"];
        $data["discount"] = $_POST["discount"];
        $data["budgetPrice"] = $_POST["budget-price"];
        $data["standardPrice"] = $_POST["standard-price"];
        $data["luxuryPrice"] = $_POST["luxury-price"];
        $data["coffeemakerPrice"] = $_POST["coffeemaker-price"];
        $data["tvPrice"] = $_POST["tv-price"];
        $data["minibarPrice"] = $_POST["minibar-price"];

        file_put_contents(__DIR__ . '/infodata.json', json_encode($data, JSON_PRETTY_PRINT));
        echo "Data updated!";
    }
}



?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <style>
        #update_form {
            display: flex;
            flex-direction: column;
            max-width: 300px;
            margin: 0 auto;
            gap: 10px;
            font-size: 16px;
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>

<body>

    <!-- - where different data can be altered, such as room prices, the star rating, discount levels  --->
    <?php if ($authenticated) : ?>
        <a href="app/logout.php">Logga out</a>
        <form id="update_form" action="" method="post">
            <label for="star_rating">Star rating</label>
            <select name="star_rating" id="star_rating">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5" selected>5</option>
            </select>
            <label for="discount_level">Discount :</label>
            <input type="range" name="discount" id="discount" min="0" max="100" value="0" step="1">
            <span id="discountValue">0%</span>


            <label for="budget-price">Budget Room Price:</label>
            <input type="number" name="budget-price" id="budget-price" value="2" step="1">

            <label for="standard-price">Standard Room Price:</label>
            <input type="number" name="standard-price" id="standard-price" value="5" step="1">

            <label for="luxury-price">Luxury Room Price:</label>
            <input type="number" name="luxury-price" id="luxury-price" value="10" step="1">

            <span>Features: </span>

            <label for="coffeemaker-price">Coffeemaker Price:</label>
            <input type="number" name="coffeemaker-price" id="coffeemaker-price" value="1" step="1">

            <label for="tv-price">TV Price:</label>
            <input type="number" name="tv-price" id="tv-price" value="2" step="1">

            <label for="minibar-price">Minibar Price:</label>
            <input type="number" name="minibar-price" id="minibar_price" value="3" step="1">

            <input type="submit" value="Update Prices">

        </form>
    <?php else : ?>
        <form action="app/login.php" method="post">
            <label for="apikey">API key: </label>
            <input type="text" name="apikey" id="apikey" placeholder="123...">
            <button type="submit">Logga in</button>
        </form>
    <?php endif; ?>
    <script>
        const discountSlider = document.getElementById('discount');
        const discountValue = document.getElementById('discountValue');

        discountSlider.addEventListener('input', function() {
            discountValue.textContent = discountSlider.value + '%';
        });
    </script>
</body>

</html>