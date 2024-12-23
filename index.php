<?php

require __DIR__ . "/app/available.php";

$dates = datesToArray(getBookedDates());
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <title>Code Spa Hotel</title>
</head>

<body>
    <header id="topHeader">
        <nav>
            <h1>Code Spa Hotel</h1>
        </nav>
        <div class="hero">
            <div class="inner-text">
                <h2>Din plats för Coworking, Kod och SPA.</h2>
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
                                    <option value="Budget">Code & Chill (Budget)</option>
                                    <option value="Standard">Debug & Reboot (Standard)</option>
                                    <option value="Luxury">Dev & Detox (Luxury)</option>
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
                <div class="roomImg">
                </div>
                <div class="roomInfo">
                    <h2>Code & Chill (Budget)</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                    <p style="text-align: center;">Bokade tider</p>
                    <ul class="booked-dates">
                        <?php for ($i = 0; $i < count($dates); $i++) : ?>
                            <li><?= $dates[$i] ?> Jan</li>
                        <?php endfor; ?>
                    </ul>
                </div>
            </section>
            <section class="room" id="standard">
                <div class="roomInfo">
                    <h2>Debug & Reboot (Standard)</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                    <p style="text-align: center;">Bokade tider</p>
                    <ul class="booked-dates">
                        <?php for ($i = 0; $i < count($dates); $i++) : ?>
                            <li><?= $dates[$i] ?> Jan</li>
                        <?php endfor; ?>
                    </ul>
                </div>
                <div class="roomImg"></div>
            </section>
            <section class="room" id="luxury">
                <div class="roomImg"></div>
                <div class="roomInfo">
                    <h2>Dev & Detox (Luxury)</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                    <p style="text-align: center;">Bokade tider</p>
                    <ul class="booked-dates">
                        <?php for ($i = 0; $i < count($dates); $i++) : ?>
                            <li><?= $dates[$i] ?> Jan</li>
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