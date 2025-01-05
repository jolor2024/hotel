<?php
require_once __DIR__ . "/app/available.php";
require_once __DIR__ . "/app/dbfunctions.php";
require(__DIR__ . '/vendor/autoload.php');



$all_bookings = getBookings(__DIR__ . "/db/booking.db");

$budget_bookings = [];
$standard_bookings = [];
$luxury_bookings = [];

foreach ($all_bookings as $booking) {
    if ($booking["room_type"] == "Budget") {
        $budget_bookings[] = $booking;
    } else if ($booking["room_type"] == "Standard") {
        $standard_bookings[] = $booking;
    } else if ($booking["room_type"] == "Luxury") {
        $luxury_bookings[] = $booking;
    }
}


$dates_budget = datesToArray($budget_bookings);
$dates_standard = datesToArray($standard_bookings);
$dates_luxury = datesToArray($luxury_bookings);

//die(var_dump($all_bookings));
?>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="widths=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Code Spa Hotel</title>
</head>

<body>
    <header id="topHeader">
        <nav>
            <h1>Code SPA Hotel</h1>
        </nav>
        <div class="hero">
            <div class="inner-text">
                <h2>Din plats för Coworking, Kod och SPA.</h2>
                <h3>&#10022; &#10022; &#10022; &#10022; &#10022;</h1>
            </div>

        </div>
    </header>

    <main>
        <div class="form">
            <div class="booking-form">
                <form action="app/booking.php" method="post">
                    <div class="content-section">
                        <div class="form-row">
                            <div class="section-form">
                                <label for="start">Incheckningsdatum: </label>
                                <input type="date" id="start" name="start-date" min="2025-01-01" max="2025-01-31" value="2025-01-01">
                            </div>

                            <div class="section-form">
                                <label for=" end">Utcheckningsdatum: </label>
                                <input type="date" id="end" name="end-date" min="2025-01-02" max="2025-01-31" value="2025-01-02">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="section-form">
                                <label for="standard">Rum:</label>
                                <select name="room" id="standard">
                                    <option value="Budget">Debug & Reboot (Budget)</option>
                                    <option value="Standard">Dev & Detox (Standard)</option>
                                    <option value="Luxury">Full Stack Relaxation (Luxury)</option>
                                </select>
                            </div>
                            <div class="section-form">
                                <label for="transferCode">Transfercode: </label>
                                <input name="transferCode" type="text" id="transferCode" required>
                            </div>
                        </div>
                    </div>
                    <div class="content-section">
                        <fieldset>
                            <legend>Features</legend>
                            <div class="feature">
                                <label for="feature1">Coffeemaker: </label>
                                <input name="feature1" type="checkbox" id="feature1" value="Coffeemaker">
                            </div>

                            <div class="feature">
                                <label for="feature2">Tv: </label>
                                <input name="feature2" type="checkbox" id="feature2" value="TV">
                            </div>


                            <div class="feature">
                                <label for="feature3">Minibar: </label>
                                <input name="feature3" type="checkbox" id="feature3" value="Minibar">
                            </div>

                        </fieldset>
                    </div>
                    <input id="submitBtn" type="submit" value="Boka" />
                </form>
            </div>
        </div>
        <section class="infoContent">
            <h1>Våra rum</h1>
            <section class="room" id="budget">
                <div class="roomImg budgetImg">
                </div>
                <div class="roomInfo">
                    <h2>Debug & Reboot (Budget)</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                    <p>Bokade tider</p>
                    <ul class="booked-dates">
                        <li class="day-header">M</li>
                        <li class="day-header">T</li>
                        <li class="day-header">O</li>
                        <li class="day-header">T</li>
                        <li class="day-header">F</li>
                        <li class="day-header">L</li>
                        <li class="day-header">S</li>
                        <?php for ($i = 1; $i <= 31; $i++) : ?>
                            <li class="<?= in_array($i, $dates_budget) ? 'booked' : '' ?>"><?= $i ?></li>
                        <?php endfor; ?>
                    </ul>
                </div>
            </section>
            <section class="room" id="standard">
                <div class="roomInfo">
                    <h2>Dev & Detox (Standard)</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                    <p>Bokade tider</p>
                    <ul class=" booked-dates">
                        <li class="day-header">M</li>
                        <li class="day-header">T</li>
                        <li class="day-header">O</li>
                        <li class="day-header">T</li>
                        <li class="day-header">F</li>
                        <li class="day-header">L</li>
                        <li class="day-header">S</li>
                        <?php for ($i = 1; $i <= 31; $i++) : ?>
                            <li class="<?= in_array($i, $dates_standard) ? 'booked' : '' ?>"><?= $i ?></li>
                        <?php endfor; ?>
                    </ul>
                </div>
                <div class="roomImg standardImg"></div>
            </section>
            <section class="room" id="luxury">
                <div class="roomImg luxuryImg"></div>
                <div class="roomInfo">
                    <h2>Full Stack Relaxation (Luxury)</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    <p>Bokade tider</p>
                    <ul class="booked-dates">
                        <li class="day-header">M</li>
                        <li class="day-header">T</li>
                        <li class="day-header">O</li>
                        <li class="day-header">T</li>
                        <li class="day-header">F</li>
                        <li class="day-header">L</li>
                        <li class="day-header">S</li>
                        <?php for ($i = 1; $i <= 31; $i++) : ?>
                            <li class="<?= in_array($i, $dates_luxury) ? 'booked' : '' ?>"><?= $i ?></li>
                        <?php endfor; ?>
                    </ul>
                </div>
            </section>
        </section>
    </main>
    <footer>
        <span>CodeSpa Hotel</span>
    </footer>
</body>

</html>