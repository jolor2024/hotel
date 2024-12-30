<?php


declare(strict_types=1);

require '../vendor/autoload.php';
require __DIR__ . "/available.php";
require_once __DIR__ . "/dbfunctions.php";

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

if (isset(
    $_POST["start-date"],
    $_POST["end-date"],
    $_POST["room"],
    $_POST["transferCode"]
)) {
    $startDate = $_POST["start-date"];
    $endDate = $_POST["end-date"];

    $room = $_POST["room"];

    if ($room != "Budget" && $room != "Standard" && $room != "Luxury") { //Checks if correct $room input
        $room = "Budget"; //annars default Budget
    }


    //Läser in priser om rummen osv.
    $bookingData = json_decode(file_get_contents('../infodata.json'), true);

    $transferCode = $_POST["transferCode"];

    $features = [];
    if (isset($_POST["feature1"])) {
        $features[] = [
            "name" => "coffeemaker",
            "cost" => $bookingData["coffeemakerPrice"]
        ];
    }
    if (isset($_POST["feature2"])) {
        $features[] = [
            "name" => "tv",
            "cost" => $bookingData["tvPrice"]
        ];
    }
    if (isset($_POST["feature3"])) {
        $features[] = [
            "name" => "minibar",
            "cost" => $bookingData["minibarPrice"]
        ];
    }



    //Hämta priser här + features
    $stars = $bookingData["starRating"];
    $roomCost = 0;
    $totalCost = 0;

    if ($room == "Budget") {
        $roomCost += $bookingData["budgetPrice"];
        $totalCost += $roomCost;
    } else if ($room == "Standard") {
        $roomCost += $bookingData["standardPrice"];
        $totalCost += $roomCost;
    } else if ($room == "Luxury") {
        $roomCost += $bookingData["luxuryPrice"];
        $totalCost += $roomCost;
    }


    foreach ($features as $feature) {
        $totalCost += $feature["cost"];
    }

    error_log("Total Cost: " . $totalCost, 4);



    if ((new DateTime($startDate))->diff(new DateTime($endDate))->days > 3) {
        $discountAmount = ($bookingData["discount"] / 100) * $totalCost;
        $totalCost = $totalCost - $discountAmount;
    }


    header('Content-Type: application/json');
    if (checkTransfer($transferCode, $totalCost)) { //Valid transfer code
        if (checkAvailable($startDate, $endDate, $room)) { //Check available dates.
            //Fixa här features.
            if (insertBooking($room, $roomCost, $startDate, $endDate, $transferCode, true, false, false, $totalCost)) {
                error_log("Success.  Booking created.", 4);
                if (deposit($transferCode)) {
                    error_log("Success deposit.", 4);
                    $response = [
                        "island" => "Insula Bolmia",
                        "hotel" => "Code Spa Hotel",
                        "arrival_date" => $startDate,
                        "departure_date" => $endDate,
                        "total_cost" => $totalCost,
                        "stars" => $stars,
                        "features" => $features,
                        "additional_info" => [
                            "greeting" => "Thank you for choosing Code Spa Hotel!",
                            "imageUrl" => "https://upload.wikimedia.org/wikipedia/commons/3/3e/Bolms%C3%B6_-_KMB_-_16000700009625.jpg"
                        ]
                    ];
                    echo json_encode($response);
                } else {
                    error_log("Error deposit", 4);
                }
            } else {
                error_log("Error inserting order...", 4);
            }
        } else {
            error_log("Selected dates not available.", 4);
            echo json_encode("Selected dates not available.");
        }
    } else {
        error_log("Not valid transfer code.", 4);
        echo json_encode("Not valid transfer code. ");
    }
}


/* Checks if transfer code is valid */
function checkTransfer(string $transferCode, float $totalCost): bool
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
        error_log("Body: " . (string) $response->getBody(), 4);
        error_log("Error, not valid transferCode or totalcost exceeds that of the transfercode", 4);
        error_log((string) $response->getStatusCode(), 4);
        return false;
    }
}


//Deposit transfercode
function deposit(string $transferCode): bool
{
    $username = "Jonatan";

    $client = new Client(["base_uri" => "https://www.yrgopelago.se/centralbank/"]);
    try {
        $response = $client->request("POST", "deposit", [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ],
            "form_params" => [
                "user" => $username,
                "transferCode" => $transferCode,
                "numberOfDays" => 3 //Fixa detta?
            ]
        ]);
        error_log("Status code" . (string) $response->getStatusCode(), 4);
        error_log("Response body" . (string) $response->getBody(), 4);
        return true;
    } catch (ClientException $e) {
        $response = $e->getResponse();
        error_log("Body: " . (string) $response->getBody(), 4);
        error_log((string) $response->getStatusCode(), 4);
        error_log("Error deposit...", 4);
        return false;
    }

    return true;
}
