<?php

declare(strict_types=1);
require_once __DIR__ . "/dbfunctions.php";

//Get the booked dates as an arrays
function datesToArray(array $booked_dates): array
{
    $dates = [];
    foreach ($booked_dates as $bd) {
        $start = new DateTime($bd["start_date"]);
        $end = new DateTime($bd["end_date"]);
        while ($start <= $end) {
            $dates[] = $start->format("d");
            $start->modify("+1 day");
        }
    }
    asort($dates);
    return $dates;
}

//Checks available dates
function checkAvailable(string $start_date, string $end_date, string $roomType): bool
{
    $start_date = new DateTime($start_date);
    $end_date = new DateTime($end_date);

    $overlaps = false;


    $all_bookings = getBookings("../db/booking.db");
    foreach ($all_bookings as $bd) {
        if ($bd["room_type"] == $roomType) {
            $start_bd = new DateTime($bd["start_date"]);
            $end_bd = new DateTime($bd["end_date"]);

            error_log("Input: dates", 4);
            error_log($start_date->format("Y-m-d"), 4);
            error_log($end_date->format("Y-m-d"), 4);

            error_log("Checked: dates", 4);
            error_log($start_bd->format("Y-m-d"), 4);
            error_log($end_bd->format("Y-m-d"), 4);

            $start_date_available = ($start_date >= $start_bd && $start_date <= $end_bd);
            error_log((string) $start_date_available, 4);


            $end_date_available = ($end_date >= $start_bd && $end_date <= $end_bd);
            error_log((string) $end_date_available, 4);

            if ($start_date_available || $end_date_available) {
                $overlaps = true;
                break;
            }
        }
    }

    if ($overlaps) {
        error_log("Dates overlaps. Can not make booking.", 4);
        return false;
    } else {
        error_log("Available, making reservation...", 4);
        return true;
    }
}
