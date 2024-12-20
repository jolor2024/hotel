<?php

declare(strict_types=1);

require '../vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;



//curl -X POST -d "start-date=2025-01-01&end-date=2025-01-17&room=Budget&feature1=Coffeemaker&transferCode=980fdb4f-5c72-4956-b725-03c07b50498c" http://127.0.0.1:5500/app/booking.php | json_pp




//400 bad request
/* Your hotel MUST give a response to every succesful booking. The response should be in json and MUST have the following properties*/
/*Your hotel MUST check if a transferCode submitted by a tourist is valid (otherwise you won't get any money)*/
/*Checks if valid transferCode*/
//curl -X POST -d "start-date=2025-01-01&end-date=2025-01-17&room=Budget&feature1=Coffeemaker&feature2=Minibar&transferCode=hejsan123" http://127.0.0.1:5500/app/booking.php | json_pp

//curl -X POST -d "transferCode=980fdb4f-5c72-4956-b725-03c07b50498c&totalcost=5" https://www.yrgopelago.se/centralbank/transferCode | json_pp
//{"error":"Invalid or already processed transferCode."}
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

    $features = []; //här array istället med feature namn osv slippa nedan array? key value
    //$feature_costs = array("Coffeemaker" => "20", "Minibar" => "10", )
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
    $totalCost = 10;
    $stars = 5;



    if (checkTransfer($transferCode, $totalCost)) { //Valid transfer code
        header('Content-Type: application/json');
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
        echo json_encode($response);
    } else {
        error_log("Not valid transfer code", 4);
    }
}

function checkTransfer($transferCode, $totalCost)
{
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
        error_log("Error post request? kanske fel transferCode?", 4);
        error_log((string) $response->getStatusCode(), 4);
        return false;
    }
}
