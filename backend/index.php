<?php
header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

require './router_helper.php';


// Chargement des données
$events = json_decode(file_get_contents("events.json"), true);
$reservations = json_decode(file_get_contents("reservations.json"), true);
// Mini router

switch (true) {
    case matchRoute('/events/add', $routeParams):
        if ($method === 'POST') {
            $body = json_decode(file_get_contents('php://input'), true);
            
            // Validation rapide
            if (!isset($body['title'], $body['description'], $body['date'], $body['places_total'])) {
                http_response_code(400);
                echo json_encode(["error" => "Champs manquants"]);
                break;
            }
    
            // Générer un nouvel ID
            $newId = count($events) + 1;
    
            $newEvent = [
                "id" => $newId,
                "title" => $body['title'],
                "description" => $body['description'],
                "date" => $body['date'],
                "places_total" => (int)$body['places_total'],
                "places_booked" => 0
            ];
    
            $events[] = $newEvent;
    
            // Sauvegarder dans le fichier
            file_put_contents("events.json", json_encode($events, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    
            echo json_encode(["data" => $newEvent]);
        }
        break;
    case matchRoute('/events', $routeParams):
        if ($method === 'GET') {
            echo json_encode(["data" => $events]);
        }
        break;

    case matchRoute('/events/:id', $routeParams):
        if ($method === 'GET') {
            echo json_encode(["data" => $events[$routeParams['id']]]);
        }
        break;

    case matchRoute('/reservations', $routeParams):
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