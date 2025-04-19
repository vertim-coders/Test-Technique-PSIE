<?php
//CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: http://localhost:5173');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');
    http_response_code(200);
    exit();
}


header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");


require './router_helper.php';

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Chargement des fichiers JSON
$events = json_decode(file_get_contents("events.json"), true);
$reservations = json_decode(file_get_contents("reservations.json"), true);

// Routing
switch (true) {
    case matchRoute('/events', $routeParams) && $method === 'GET':
        echo json_encode(["data" => $events]);
        break;

    case matchRoute('/events/:id', $routeParams) && $method === 'GET':
        echo json_encode(["data" => $events[$routeParams['id']]]);
        break;

    case matchRoute('/events/add', $routeParams) && $method === 'POST':
        $newEvent = json_decode(file_get_contents("php://input"), true);
        if (!$newEvent || !isset($newEvent['title'], $newEvent['description'], $newEvent['date'], $newEvent['places_total'])) {
            http_response_code(400);
            echo json_encode(["error" => "Données invalides pour l'ajout d'événement."]);
            break;
        }

        $newEvent['id'] = count($events) + 1;
        $newEvent['places_booked'] = 0;
        $events[] = $newEvent;

        if (file_put_contents("events.json", json_encode($events, JSON_PRETTY_PRINT))) {
            echo json_encode(["message" => "Vous avez ajouté un événement", "event" => $newEvent]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Erreur lors de l'enregistrement de l'événement."]);
        }
        break;

    case matchRoute('/events/:id', $routeParams) && $method === 'PUT':
        $updatedEvent = json_decode(file_get_contents("php://input"), true);
        $id = (int)$routeParams['id'];
        $found = false;

        foreach ($events as &$event) {
            if ($event['id'] === $id) {
                $event = array_merge($event, $updatedEvent);
                $found = true;
                break;
            }
        }

        if ($found) {
            file_put_contents("events.json", json_encode($events, JSON_PRETTY_PRINT));
            echo json_encode(["message" => "Événement modifié", "event" => $updatedEvent]);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Événement non trouvé"]);
        }
        break;

    case matchRoute('/events/:id', $routeParams) && $method === 'DELETE':
        $id = (int)$routeParams['id'];
        $found = false;

        foreach ($events as $index => $event) {
            if ($event['id'] === $id) {
                array_splice($events, $index, 1);
                $found = true;
                break;
            }
        }

        if ($found) {
            file_put_contents("events.json", json_encode($events, JSON_PRETTY_PRINT));
            echo json_encode(["message" => "Événement supprimé"]);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Événement non trouvé"]);
        }
        break;

    case matchRoute('/reservations', $routeParams) && $method === 'GET':
        echo json_encode(["data" => $reservations]);
        break;

    case matchRoute('/reservations/add', $routeParams) && $method === 'POST':
        $newReservation = json_decode(file_get_contents("php://input"), true);
        $newReservation['id'] = count($reservations) + 1;

        $event = null;
        foreach ($events as &$ev) {
            if ($ev['id'] === $newReservation['event_id']) {
                $event = &$ev;
                break;
            }
        }

        if ($event) {
            if ($event['places_total'] > $event['places_booked']) {
                $event['places_booked']++;
                $reservations[] = $newReservation;
                file_put_contents("events.json", json_encode($events, JSON_PRETTY_PRINT));
                file_put_contents("reservations.json", json_encode($reservations, JSON_PRETTY_PRINT));
                echo json_encode(["message" => "Réservation ajoutée", "reservation" => $newReservation]);
            } else {
                echo json_encode(["error" => "Aucune place disponible pour cet événement"]);
            }
        } else {
            echo json_encode(["error" => "Événement non trouvé"]);
        }
        break;

    case matchRoute('/reservations/:id/email/:email', $routeParams) && $method === 'DELETE':
        $id = $routeParams['id'];
        $email = $routeParams['email'];

        $reservationIndex = null;
        foreach ($reservations as $index => $reservation) {
            if ($reservation['id'] == $id && $reservation['email'] == $email) {
                $reservationIndex = $index;
                break;
            }
        }

        if ($reservationIndex !== null) {
            foreach ($events as &$event) {
                if ($event['id'] === $reservations[$reservationIndex]['event_id']) {
                    $event['places_booked']--;
                    break;
                }
            }

            array_splice($reservations, $reservationIndex, 1);
            file_put_contents("events.json", json_encode($events, JSON_PRETTY_PRINT));
            file_put_contents("reservations.json", json_encode($reservations, JSON_PRETTY_PRINT));
            echo json_encode(["message" => "Réservation annulée"]);
        } else {
            echo json_encode(["error" => "Réservation non trouvée"]);
        }
        break;

    default:
        http_response_code(404);
        echo json_encode(["error" => "Route non trouvée"]);
        break;
}
?>
