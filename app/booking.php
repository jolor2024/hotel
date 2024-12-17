<?php

declare(strict_types=1);
header('Content-Type: application/json');
$successful = false;
/* Your hotel MUST give a response to every succesful booking. The response should be in json and MUST have the following properties*/
/*Your hotel MUST check if a transferCode submitted by a tourist is valid (otherwise you won't get any money)*/

if (isset(
    $_POST["start-date"],
    $_POST["end-date"],
    $_POST["room"],
    $_POST["transferCode"]
)) {
    $startDate = $_POST["start-date"];
    $endDate = $_POST["end-date"];
    $room = $_POST["room"];
    $transferCode = $_POST["transferCode"];

    $features = [];
    if (isset($_POST["feature1"])) {
        $features[] = $_POST["feature1"];
    }
    if (isset($_POST["feature2"])) {
        $features[] = $_POST["feature2"];
    }
    if (isset($_POST["feature3"])) {
        $features[] = $_POST["feature3"];
    }
}


/*Checks if valid transferCode*/
$successful = true;

if ($successful) {
    $response = [
        "island" => "Insula Bolmia",
        "hotel" => "Co-Spa Hotel",
        "arrival_date" => "2025-01-12",
        "departure_date" => "2025-01-12",
        "total_cost" => "25",
        "stars" => "5",
        "features" => [
            [
                "name" => "sauna",
                "cost" => "2"
            ]
        ],
        "additional_info" => [
            "greeting" => "Thank you for choosing Centralhotellet",
            "imageUrl" => "https://upload.wikimedia.org/wikipedia/commons/e/e2/Hotel_Boscolo_Exedra_Nice.jpg"
        ]
    ];

    //echo json_encode($response);
} else {
    echo json_encode("not valid!");
}
