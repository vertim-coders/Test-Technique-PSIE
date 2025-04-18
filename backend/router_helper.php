<?php
/**
 * Vérifie si l'URI actuelle correspond à un pattern de route avec paramètres
 * et extrait les valeurs des paramètres dans $routeParams.
 * 
 * @param string $pattern Le pattern de route (ex: '/events/:id')
 * @param array &$routeParams Tableau passé par référence pour récupérer les paramètres
 * @return bool True si l'URI correspond au pattern, false sinon
 */
function matchRoute($pattern, &$routeParams)
{
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    // Extraction des noms de paramètres et création de la regex
    $paramNames = [];
    $regex = preg_replace_callback('/\/:([^\/]+)/', function ($matches) use (&$paramNames) {
        $paramNames[] = $matches[1];
        return '/([^\/]+)';
    }, $pattern);

    $regex = '#^' . $regex . '$#';

    if (preg_match($regex, $uri, $matches)) {
        array_shift($matches); // Supprime le match complet
        $routeParams = array_combine($paramNames, $matches);
        return true;
    }

    return false;
}