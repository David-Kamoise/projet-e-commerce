<?php
/**
 * Front Controller - Backoffice (Administration)
 *
 * Ce fichier est le point d'entrée de l'interface d'administration.
 * Son fonctionnement est similaire à index.php mais pour le backoffice.
 *
 * Exemples d'URLs :
 * - admin.php?controller=foo&action=list
 * - admin.php?controller=foo&action=create
 * - admin.php?controller=foo&action=edit&id=5
 */

// Inclusion de la configuration
require_once '../config/config.php';
require_once '../config/database.php';

/**
 * TODO POUR LES ÉTUDIANTS :
 * - Ajouter une vérification d'authentification (session admin)
 * - Rediriger vers une page de login si non authentifié
 *
 * Exemple :
 * if (!isset($_SESSION['admin_id'])) {
 *     header('Location: login.php');
 *     exit;
 * }
 */

// Récupération des paramètres de l'URL
$controller = $_GET['controller'] ?? 'foo';
$action = $_GET['action'] ?? 'list';

// Sécurisation des paramètres
$controller = preg_replace('/[^a-zA-Z]/', '', $controller);
$action = preg_replace('/[^a-zA-Z]/', '', $action);

// Construction du nom du fichier contrôleur
$controllerFile = '../controllers/' . ucfirst($controller) . 'Controller.php';

// Vérification de l'existence du fichier
if (!file_exists($controllerFile)) {
    http_response_code(404);
    die('Erreur 404 : Contrôleur non trouvé');
}

// Inclusion du contrôleur
require_once $controllerFile;

// Construction du nom de la classe
$controllerClass = ucfirst($controller) . 'Controller';

// Vérification de l'existence de la classe
if (!class_exists($controllerClass)) {
    die('Erreur : Classe contrôleur non trouvée');
}

// Instanciation du contrôleur
$controllerInstance = new $controllerClass();

// Pour le backoffice, on préfixe l'action avec "admin"
// Exemple : "list" devient "adminList"
$adminAction = 'admin' . ucfirst($action);

// Vérification de l'existence de la méthode admin
if (!method_exists($controllerInstance, $adminAction)) {
    // Si la méthode admin n'existe pas, on essaie la méthode normale
    if (!method_exists($controllerInstance, $action)) {
        die('Erreur : Action non trouvée');
    }
    $adminAction = $action;
}

// Appel de la méthode
$controllerInstance->$adminAction();
