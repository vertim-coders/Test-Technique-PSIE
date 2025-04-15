<?php
header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Chargement des données
$events = json_decode(file_get_contents("events.json"), true);
$reservations = json_decode(file_get_contents("reservations.json"), true);
// Mini router
switch ($uri) {
    case '/events':
        if ($method === 'GET') {
            echo json_encode(["data" => $events]);
        }
        break;

    case '/reservations':
        if ($method === 'GET') {
            echo json_encode(["data" => $reservations]);
        }
        break;

    default:
        http_response_code(404);
        echo json_encode(["error" => "Route non trouvée"]);
        break;
}
?>