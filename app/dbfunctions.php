<?php

declare(strict_types=1);

//insertTestData();
function insertTestData(): void
{
    /*
    $roomId = insertRoom("Budget", 2);
    insertBooking($roomId, "2025-01-16", "2025-01-19", "ab22c123", true, true, false, 5);
    
    $roomId = insertRoom("Budget", 2);
    insertBooking($roomId, "2025-01-01", "2025-01-05", "abc123", true, true, false, 5);

    $roomId = insertRoom("Budget", 2);
    insertBooking($roomId, "2025-01-06", "2025-01-10", "abcd1234", true, true, false, 5);

    $roomId = insertRoom("Standard", 5);
    insertBooking($roomId, "2025-01-06", "2025-01-12", "abc1234", true, true, true, 5);

    $roomId = insertRoom("Luxury", 10);
    insertBooking($roomId, "2025-01-15", "2025-01-17", "abcd", true, true, true, 10);
    */
}


function insertRoom(string $roomType, int $price): mixed
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


function insertBooking(
    string $roomType,
    int $roomPrice,
    string $startDate,
    string $endDate,
    string $transferCode,
    bool $feature1,
    bool $feature2,
    bool $feature3,
    int $totalPrice
): bool {
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



function getBookings(string $path): array
{
    try {
        $db = new PDO("sqlite:" . $path);
        $statement = $db->query("SELECT bookings.*, rooms.room_type FROM bookings JOIN rooms on bookings.room_id = rooms.id"); //right now only rooms
        $rooms = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $rooms;
    } catch (PDOException $e) {
        echo "Error connection: " . $e->getMessage();
    }
}
