<?php

declare(strict_types=1);

require '../vendor/autoload.php';
require __DIR__ . "/available.php";

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

/* Your hotel MUST give a response to every succesful booking. The response should be in json and MUST have the following properties*/
/*Your hotel MUST check if a transferCode submitted by a tourist is valid (otherwise you won't get any money)*/
//Your hotel MUST check availibilty of the requested room and dates before making the booking and sending the response package as json.


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

    //Kolla om giltiga namn features?
    $features = [];
    if (isset($_POST["feature1"])) {
        $features[] = [
            "name" => $_POST["feature1"],
            "price" => "20"
        ];
    }
    if (isset($_POST["feature2"])) {
        $features[] = [
            "name" => $_POST["feature2"],
            "price" => "10"
        ];
    }
    if (isset($_POST["feature3"])) {
        $features[] = [
            "name" => $_POST["feature3"],
            "price" => "15"
        ];
    }

    //error_log(implode(array_values($features)[0]), 4);

    $stars = 5;


    //Calculating cost function?
    $totalCost = 0;

    if ($room == "Budget") {
        $totalCost += 100;
    } else if ($room == "Standard") {
        $totalCost += 200;
    } else if ($room == "Luxury") {
        $totalCost += 1000;
    }


    foreach ($features as $feature) {
        $totalCost += $feature["price"];
    }

    error_log("Total Cost: " . $totalCost, 4);


    ////The hotel can give discounts, for example, how about 30% off for a visit longer than three days?
    if ((new DateTime($startDate))->diff(new DateTime($endDate))->days > 3) {
        $totalCost = 0.7 * $totalCost;
        error_log("More than 3 days, give discount", 4);
    }

    $totalCost = 2; //Temporary for testing
    $totalCost = (string) $totalCost;




    if (checkTransfer($transferCode, $totalCost)) { //Valid transfer code
        header('Content-Type: application/json');
        if (checkAvailable($startDate, $endDate)) { //Check available dates.
            $response = [
                "island" => "Insula Bolmia",
                "hotel" => "Co-Spa Hotel",
                "arrival_date" => $startDate,
                "departure_date" => $endDate,
                "total_cost" => $totalCost,
                "stars" => $stars,
                "features" => $features,
                "additional_info" => [
                    "greeting" => "Thank you for choosing Centralhotellet",
                    "imageUrl" => "https://upload.wikimedia.org/wikipedia/commons/e/e2/Hotel_Boscolo_Exedra_Nice.jpg"
                ]
            ];
            if (addBooking($startDate, $endDate)) {
                echo json_encode($response); //
            }
        } else {
            error_log("Selected dates not available", 4);
        }
    } else {
        echo json_encode("Not valid transfer code");
        error_log("Not valid transfer code", 4);
    }
}


/* Checks if transfer code is valid */
function checkTransfer($transferCode, $totalCost)
{
    error_log("Code: " . $transferCode, 4);
    $client = new Client(["base_uri" => "https://www.yrgopelago.se/centralbank/"]);
    try {
        $response = $client->request("POST", "transferCode", [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ],
            "form_params" => [
                "transferCode" => $transferCode,
                "totalcost" => $totalCost
            ]
        ]);
        error_log("Status code" . (string) $response->getStatusCode(), 4);
        error_log("Response body" . (string) $response->getBody(), 4);
        return true;
    } catch (ClientException $e) {
        $response = $e->getResponse();
        error_log("Error,  not valid transferCode", 4);
        error_log((string) $response->getStatusCode(), 4);
        return false;
    }
}


function addBooking($startDate, $endDate)
{
    //Add to database

    //Deposit money.
    error_log("Creating booking order..", 4);
    return true;
}
