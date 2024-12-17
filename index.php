<?php
$test =  "Test"; //Require istället tydligare.
echo $test;
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <title>Hotel</title>
</head>

<body>
    <header>
        <h1>Co-Spa Hotel</h1>
    </header>
    <main>
        <div class="booking-form">
            <form action="app/booking.php" method="post">
                <label for="start">Arrival: </label>
                <input type="date" id="start" name="start-date" min="2025-01-01" max="2025-01-31" value="2025-01-01">
                <label for=" end">Departure: </label>
                <input type="date" id="end" name="end-date" min="2025-01-02" max="2025-01-31" value="2025-01-02">

                <label for="standard">Rum</label>
                <select name="room" id="standard">
                    <option value="Budget">Budget</option>
                    <option value="Standard">Standard</option>
                    <option value="Luxury">Luxury</option>
                </select>

                <fieldset>
                    <legend>Features</legend>

                    <label for="feature1">Coffeemaker: </label>
                    <input name="feature1" type="checkbox" id="feature1" value="Coffeemaker">

                    <label for="feature2">Tv: </label>
                    <input name="feature2" type="checkbox" id="feature2" value="TV">

                    <label for="feature3">Minibar: </label>
                    <input name="feature3" type="checkbox" id="feature3" value="Minibar">

                </fieldset>

                <label for="transferCode">Transfercode: </label>
                <input name="transferCode" type="text" id="transferCode" required>

                <input type="submit" value="Boka" />
            </form>
        </div>

    </main>

</body>

</html>