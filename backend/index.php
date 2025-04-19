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
    case matchRoute('/events', $routeParams):
        if ($method === 'GET') {
            echo json_encode(["data" => $events]);
        }
        break;

    case matchRoute('/events/add', $routeParams):
        if ($method === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);

            if (isset($data['name'], $data['date'], $data['location'])) {
                $events[] = $data;
                file_put_contents("events.json", json_encode($events));
                echo json_encode(["message" => "Événement ajouté avec succès"]);
            } else {
                http_response_code(400);
                echo json_encode(["error" => "Données de l'événement incomplètes"]);
            }
        }
        break;

    case matchRoute('/events/:id', $routeParams):
        if ($method === 'PUT') {
            $data = json_decode(file_get_contents('php://input'), true);
            $id = $routeParams['id'];

            if (isset($events[$id])) {
                // Only update provided fields (name, date, location)
                if (isset($data['name'])) {
                    $events[$id]['name'] = $data['name'];
                }
                if (isset($data['date'])) {
                    $events[$id]['date'] = $data['date'];
                }
                if (isset($data['location'])) {
                    $events[$id]['location'] = $data['location'];
                }

                file_put_contents("events.json", json_encode($events));
                echo json_encode(["message" => "Événement mis à jour avec succès"]);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Événement non trouvé"]);
            }
        }
        break;

    case matchRoute('/events/:id', $routeParams):
        if ($method === 'DELETE') {
            $id = $routeParams['id'];

            if (isset($events[$id])) {
                unset($events[$id]);
                file_put_contents("events.json", json_encode(array_values($events)));
                echo json_encode(["message" => "Événement supprimé avec succès"]);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Événement non trouvé"]);
            }
        }
        break;

    case matchRoute('/reservations', $routeParams):
        if ($method === 'GET') {
            echo json_encode(["data" => $reservations]);
        }
        break;

    case matchRoute('/reserves/add', $routeParams):
        if ($method === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);

            if (isset($data['name'], $data['email'], $data['event_id'])) {
                $eventId = $data['event_id'];

                if (isset($events[$eventId])) {
                    $reservations[] = $data;
                    file_put_contents("reservations.json", json_encode($reservations));
                    echo json_encode(["message" => "Réservation effectuée avec succès"]);
                } else {
                    http_response_code(404);
                    echo json_encode(["error" => "Événement non trouvé"]);
                }
            } else {
                http_response_code(400);
                echo json_encode(["error" => "Données de réservation incomplètes"]);
            }
        }
        break;


    case matchRoute('/reservations', $routeParams):
        if ($method === 'GET' && isset($_GET['email'])) {
            $email = $_GET['email'];
            $filteredReservations = array_filter($reservations, function ($reservation) use ($email) {
                return isset($reservation['email']) && $reservation['email'] === $email;
            });

            echo json_encode(["data" => array_values($filteredReservations)]);
        }
        break;


    case matchRoute('/reserves/:id', $routeParams):
        if ($method === 'PUT') {
            $data = json_decode(file_get_contents('php://input'), true);
            $id = $routeParams['id'];

            if (isset($reservations[$id])) {
                if (isset($data['name'])) {
                    $reservations[$id]['name'] = $data['name'];
                }
                if (isset($data['email'])) {
                    $reservations[$id]['email'] = $data['email'];
                }

                file_put_contents("reservations.json", json_encode($reservations));
                echo json_encode(["message" => "Réservation mise à jour avec succès"]);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Réservation non trouvée"]);
            }
        }
        break;


    case matchRoute('/reservation/:id/email/:email', $routeParams):
        if ($method === 'DELETE') {
            $id = $routeParams['id'];
            $email = $routeParams['email'];

            if (isset($reservations[$id]) && $reservations[$id]['email'] === $email) {
                unset($reservations[$id]);
                file_put_contents("reservations.json", json_encode(array_values($reservations)));
                echo json_encode(["message" => "Réservation annulée avec succès"]);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Réservation non trouvée ou email incorrect"]);
            }
        }
        break;

    default:
        http_response_code(404);
        echo json_encode(["error" => "Route non trouvée"]);
        break;
}
?>