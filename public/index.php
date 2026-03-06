<?php
/**
 * Front Controller - Point d'entrée de l'application
 *
 * Ce fichier est le seul point d'entrée de l'application côté frontoffice.
 * Il gère le routing en récupérant les paramètres controller et action dans l'URL.
 *
 * Exemples d'URLs :
 * - index.php?controller=foo&action=list
 * - index.php?controller=foo&action=show&id=5
 * - index.php (par défaut : foo/list)
 */

// Inclusion de la configuration
require_once '../config/config.php';
require_once '../config/database.php';

/**
 * ROUTING SIMPLE
 *
 * Le routing consiste à déterminer quel contrôleur et quelle action appeler
 * en fonction des paramètres de l'URL.
 */

// 1. Récupération des paramètres de l'URL
// On utilise $_GET pour récupérer les paramètres passés dans l'URL
$controller = $_GET['controller'] ?? 'foo'; // Par défaut : foo
$action = $_GET['action'] ?? 'list';        // Par défaut : list

// 2. Sécurisation des paramètres
// On s'assure que les paramètres ne contiennent que des lettres (protection contre les injections)
$controller = preg_replace('/[^a-zA-Z]/', '', $controller);
$action = preg_replace('/[^a-zA-Z]/', '', $action);

// 3. Construction du nom du fichier contrôleur
// Exemple : "foo" devient "FooController.php"
$controllerFile = '../controllers/' . ucfirst($controller) . 'Controller.php';

// 4. Vérification de l'existence du fichier contrôleur
if (!file_exists($controllerFile)) {
    // Si le contrôleur n'existe pas, on affiche une erreur 404
    http_response_code(404);
    die('Erreur 404 : Contrôleur non trouvé');
}

// 5. Inclusion du contrôleur
require_once $controllerFile;

// 6. Construction du nom de la classe contrôleur
// Exemple : "foo" devient "FooController"
$controllerClass = ucfirst($controller) . 'Controller';

// 7. Vérification de l'existence de la classe
if (!class_exists($controllerClass)) {
    die('Erreur : Classe contrôleur non trouvée');
}

// 8. Instanciation du contrôleur
$controllerInstance = new $controllerClass();

// 9. Vérification de l'existence de la méthode (action)
if (!method_exists($controllerInstance, $action)) {
    die('Erreur : Action non trouvée');
}

// 10. Appel de la méthode (action) du contrôleur
$controllerInstance->$action();
