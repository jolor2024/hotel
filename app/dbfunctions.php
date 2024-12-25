<?php

declare(strict_types=1);

//insertTestData();
function insertTestData()
{
    /*
    $roomId = insertRoom("Budget", 200);
    insertBooking($roomId, "2025-01-16", "2025-01-19", "ab22c123", true, true, false, 500);
    
    $roomId = insertRoom("Budget", 200);
    insertBooking($roomId, "2025-01-01", "2025-01-05", "abc123", true, true, false, 500);

    $roomId = insertRoom("Budget", 200);
    insertBooking($roomId, "2025-01-06", "2025-01-10", "abcd1234", true, true, false, 500);

    $roomId = insertRoom("Standard", 500);
    insertBooking($roomId, "2025-01-06", "2025-01-12", "abc1234", true, true, true, 500);

    $roomId = insertRoom("Luxury", 1000);
    insertBooking($roomId, "2025-01-15", "2025-01-17", "abcd", true, true, true, 1000);
    */
}


function insertRoom($roomType, $price)
{
    try {
        $db = new PDO("sqlite:../db/booking.db");
        $st = $db->prepare("INSERT INTO rooms (room_type, price) VALUES (:room_type, :price)");
        $st->bindParam(":room_type", $roomType);
        $st->bindParam(":price", $price);
        $st->execute();
        return $db->lastInsertId();
    } catch (PDOException $e) {
        echo "Error connection: " . $e->getMessage();
        return false;
    }
}


//Ändra pathen här?
function insertBooking($roomType, $roomPrice, $startDate, $endDate, $transferCode, $feature1, $feature2, $feature3, $totalPrice)
{
    $roomId = insertRoom($roomType, $roomPrice); //Först insert room för få room id
    try {
        $db = new PDO("sqlite:../db/booking.db");
        $st = $db->prepare("INSERT INTO bookings (room_id, start_date, end_date, transfer_code, feature1, feature2, feature3, total_price) VALUES (:room_id, :start_date, :end_date, :transfer_code, :feature1, :feature2, :feature3, :total_price)");
        $st->bindParam(":room_id", $roomId);
        $st->bindParam(":start_date", $startDate);
        $st->bindParam(":end_date", $endDate);
        $st->bindParam(":transfer_code", $transferCode);
        $st->bindParam(":feature1", $feature1, PDO::PARAM_BOOL);
        $st->bindParam(":feature2", $feature2, PDO::PARAM_BOOL);
        $st->bindParam(":feature3", $feature3, PDO::PARAM_BOOL);
        $st->bindParam(":total_price", $totalPrice);
        $st->execute();
        return true;
    } catch (PDOException $e) {
        echo "Error connection: " . $e->getMessage();
        return false;
    }
}



function getBookings($path)
{
    error_log("path: " . $path, 4);
    try {
        $db = new PDO("sqlite:" . $path); //Path endast för index?
        $statement = $db->query("SELECT bookings.*, rooms.room_type FROM bookings JOIN rooms on bookings.room_id = rooms.id"); //right now only rooms
        $rooms = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $rooms;
    } catch (PDOException $e) {
        echo "Error connection: " . $e->getMessage();
    }
}
