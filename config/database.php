<?php
/**
 * Fichier de connexion à la base de données
 *
 * Ce fichier gère la connexion PDO à la base de données MySQL.
 * Il utilise le pattern Singleton pour garantir une seule instance de connexion.
 */

// Inclusion de la configuration
require_once __DIR__ . '/config.php';

/**
 * Classe Database
 * Gère la connexion PDO à la base de données
 */
class Database {

    /**
     * Instance unique de PDO (pattern Singleton)
     * @var PDO
     */
    private static $pdo = null;

    /**
     * Récupère l'instance de connexion PDO
     *
     * Cette méthode crée la connexion si elle n'existe pas encore,
     * ou retourne la connexion existante.
     *
     * @return PDO Instance de connexion à la base de données
     */
    public static function getConnection() {

        // Si la connexion n'existe pas encore, on la crée
        if (self::$pdo === null) {
            try {
                // Construction du DSN (Data Source Name)
                $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;

                // Options PDO pour améliorer la sécurité et le débogage
                $options = [
                    // Mode d'erreur : exceptions (pour gérer les erreurs avec try/catch)
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,

                    // Mode de récupération par défaut : tableau associatif
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,

                    // Désactive l'émulation des requêtes préparées (plus sécurisé)
                    PDO::ATTR_EMULATE_PREPARES => false
                ];

                // Création de la connexion PDO
                self::$pdo = new PDO($dsn, DB_USER, DB_PASS, $options);

            } catch (PDOException $e) {
                // En cas d'erreur de connexion, on affiche un message et on arrête le script
                die('Erreur de connexion à la base de données : ' . $e->getMessage());
            }
        }

        // Retourne l'instance de connexion
        return self::$pdo;
    }
}
