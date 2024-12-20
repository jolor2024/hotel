<?php

declare(strict_types=1);

/* Your hotel MUST give a response to every succesful booking. The response should be in json and MUST have the following properties*/
/*Your hotel MUST check if a transferCode submitted by a tourist is valid (otherwise you won't get any money)*/
/*Checks if valid transferCode*/
//curl -X POST -d "start-date=2025-01-01&end-date=2025-01-17&room=Budget&feature1=Coffeemaker&feature2=Minibar&transferCode=hejsan123" http://127.0.0.1:5500/app/booking.php | json_pp

//curl -X POST -d "transferCode=39778af5-cbf2-460b-94e4-deb4d036d71e&totalcost=10" https://www.yrgopelago.se/centralbank/transferCode | json_pp
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
        $features[] = $_POST["feature1"];
    }
    if (isset($_POST["feature2"])) {
        $features[] = $_POST["feature2"];
    }
    if (isset($_POST["feature3"])) {
        $features[] = $_POST["feature3"];
    }

    error_log(implode($features), 4);
    $totalCost = 10;
    $stars = 5;


    $features_data = [];


    foreach ($features as $feature) {
        $features_data[] = [
            "name" => $feature,
            "cost" => "20" //Lägg till kost här också??
        ];
    }

    if (checkTransfer($transferCode)) { //Valid transfer code
        header('Content-Type: application/json');
        $response = [
            "island" => "Insula Bolmia",
            "hotel" => "Co-Spa Hotel",
            "arrival_date" => $startDate,
            "departure_date" => $endDate,
            "total_cost" => $totalCost,
            "stars" => $stars,
            "features" => $features_data,
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

function checkTransfer($code)
{
    error_log("Valid transfer code:  " . $code, 4);
    return true;
}
