<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

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
        if ($method === 'PUT') {
            $body = json_decode(file_get_contents('php://input'), true);
    
            $eventId = (int)$routeParams['id'];
            $index = array_search($eventId, array_column($events, 'id'));
    
            if ($index === false) {
                http_response_code(404);
                echo json_encode(["error" => "Événement non trouvé"]);
                break;
            }
    
            // Mise à jour des champs
            $events[$index]['title'] = $body['title'] ?? $events[$index]['title'];
            $events[$index]['description'] = $body['description'] ?? $events[$index]['description'];
            $events[$index]['date'] = $body['date'] ?? $events[$index]['date'];
            $events[$index]['places_total'] = isset($body['places_total']) ? (int)$body['places_total'] : $events[$index]['places_total'];
    
            // Sauvegarde
            file_put_contents("events.json", json_encode($events, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    
            echo json_encode(["data" => $events[$index]]);
        }
        if ($method === 'DELETE') {
            $eventId = (int)$routeParams['id'];
            $index = array_search($eventId, array_column($events, 'id'));
    
            if ($index === false) {
                http_response_code(404);
                echo json_encode(["error" => "Événement non trouvé"]);
                break;
            }
    
            // Suppression
            array_splice($events, $index, 1);
    
            // Sauvegarde
            file_put_contents("events.json", json_encode($events, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    
            echo json_encode(["message" => "Événement supprimé"]);
        }
        break;

    case matchRoute('/reservations', $routeParams):
        if ($method === 'GET') {
            if (isset($_GET['email'])) {
                $email = $_GET['email'];
                $filtered = array_filter($reservations, function ($res) use ($email) {
                    return strtolower($res['email']) === strtolower($email);
                });
    
                echo json_encode(["data" => array_values($filtered)]);
            } else {
                echo json_encode(["data" => $reservations]);
            }
        }
        break;

    case matchRoute('/reservation/:id/email/:email', $routeParams):
        if ($method === 'DELETE') {
            $reservationId = (int)$routeParams['id'];
            $email = $routeParams['email'];
    
            // Trouve la réservation
            $reservationIndex = array_search($reservationId, array_column($reservations, 'id'));
            if ($reservationIndex === false) {
                http_response_code(404);
                echo json_encode(["error" => "Réservation non trouvée"]);
                break;
            }
    
            // Vérifie que l'email correspond
            if (strtolower($reservations[$reservationIndex]['email']) !== strtolower($email)) {
                http_response_code(400);
                echo json_encode(["error" => "Email ne correspond pas"]);
                break;
            }
    
            // Supprime la réservation
            $eventId = $reservations[$reservationIndex]['event_id'];
            array_splice($reservations, $reservationIndex, 1);
    
            // Réduit les places réservées
            $eventIndex = array_search($eventId, array_column($events, 'id'));
            if ($eventIndex !== false) {
                $events[$eventIndex]['places_booked']--;
            }
    
            // Sauvegarde
            file_put_contents("reservations.json", json_encode($reservations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            file_put_contents("events.json", json_encode($events, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    
            echo json_encode(["message" => "Réservation annulée"]);
        }
        break;

    case matchRoute('/reserves/add', $routeParams):
        if ($method === 'POST') {
            $body = json_decode(file_get_contents('php://input'), true);
    
            $eventId = (int)$body['event_id'];
            $email = trim($body['email']);
            $nom = trim($body['nom']);
    
            if (!$eventId || !$email || !$nom) {
                http_response_code(400);
                echo json_encode(["error" => "Champs requis manquants"]);
                break;
            }
    
            // Vérifie que l'événement existe
            $eventIndex = array_search($eventId, array_column($events, 'id'));
            if ($eventIndex === false) {
                http_response_code(404);
                echo json_encode(["error" => "Événement non trouvé"]);
                break;
            }
    
            // Vérifie s'il reste des places
            if ($events[$eventIndex]['places_booked'] >= $events[$eventIndex]['places_total']) {
                http_response_code(400);
                echo json_encode(["error" => "Plus de places disponibles"]);
                break;
            }
    
            // Ajoute la réservation
            $newReservation = [
                "id" => count($reservations) + 1,
                "event_id" => $eventId,
                "email" => $email,
                "nom" => $nom
            ];
            $reservations[] = $newReservation;
    
            // Incrémente les places réservées pour l'événement
            $events[$eventIndex]['places_booked']++;
    
            // Sauvegarde
            file_put_contents("reservations.json", json_encode($reservations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            file_put_contents("events.json", json_encode($events, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    
            echo json_encode(["data" => $newReservation]);
        }
        break;

    default:
        http_response_code(404);
        echo json_encode(["error" => "Route non trouvée"]);
        break;
}
?>