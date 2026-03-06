<?php
/**
 * Modèle Foo
 *
 * Ce fichier contient la classe Foo qui gère toutes les opérations
 * liées aux foos dans la base de données (CRUD).
 *
 * RÔLE DU MODÈLE DANS MVC :
 * Le modèle représente les données et la logique métier.
 * Il interagit directement avec la base de données via PDO.
 * Il ne contient AUCUN code HTML.
 */

require_once __DIR__ . '/../config/database.php';

class Foo {

    /**
     * Connexion PDO à la base de données
     * @var PDO
     */
    private $pdo;

    /**
     * Constructeur
     * Initialise la connexion à la base de données
     */
    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    /**
     * Récupère tous les foos
     *
     * @return array Tableau de tous les foos
     */
    public function getAll() {
        // Préparation de la requête SQL
        $sql = "SELECT * FROM foos ORDER BY id DESC";

        // Exécution de la requête
        $stmt = $this->pdo->query($sql);

        // Récupération de tous les résultats sous forme de tableau associatif
        return $stmt->fetchAll();
    }

    /**
     * Récupère un foo par son ID
     *
     * @param int $id ID du foo
     * @return array|false Données du foo ou false si non trouvé
     */
    public function getById($id) {
        // Requête SQL
        $sql = "SELECT * FROM foos WHERE id = :id";

        // Préparation de la requête (IMPORTANT : requête préparée pour éviter les injections SQL)
        $stmt = $this->pdo->prepare($sql);

        // Exécution avec binding du paramètre
        $stmt->execute(['id' => $id]);

        // Récupération du résultat
        return $stmt->fetch();
    }

    /**
     * Crée un nouveau foo
     *
     * @param array $data Données du foo (nom, description)
     * @return int ID du foo créé
     */
    public function create($data) {
        // Requête SQL d'insertion
        $sql = "INSERT INTO foos (nom, description, date_ajout)
                VALUES (:nom, :description, NOW())";

        // Préparation de la requête
        $stmt = $this->pdo->prepare($sql);

        // Exécution avec binding des paramètres (SÉCURISÉ contre les injections SQL)
        $stmt->execute([
            'nom' => $data['nom'],
            'description' => $data['description']
        ]);

        // Retourne l'ID du dernier élément inséré
        return $this->pdo->lastInsertId();
    }

    /**
     * Met à jour un foo existant
     *
     * @param int $id ID du foo à modifier
     * @param array $data Nouvelles données du foo
     * @return bool Succès ou échec de la mise à jour
     */
    public function update($id, $data) {
        // Requête SQL de mise à jour
        $sql = "UPDATE foos
                SET nom = :nom,
                    description = :description
                WHERE id = :id";

        // Préparation de la requête
        $stmt = $this->pdo->prepare($sql);

        // Exécution avec binding des paramètres
        return $stmt->execute([
            'id' => $id,
            'nom' => $data['nom'],
            'description' => $data['description']
        ]);
    }

    /**
     * Supprime un foo
     *
     * @param int $id ID du foo à supprimer
     * @return bool Succès ou échec de la suppression
     */
    public function delete($id) {
        /**
         * TODO POUR LES ÉTUDIANTS :
         * Avant de supprimer un élément, il faut vérifier qu'il n'est pas
         * utilisé dans d'autres tables (contraintes référentielles).
         * Sinon, on risque d'avoir des données incohérentes.
         */

        // Requête SQL de suppression
        $sql = "DELETE FROM foos WHERE id = :id";

        // Préparation et exécution
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Recherche des foos par nom
     *
     * @param string $search Terme de recherche
     * @return array Foos correspondant à la recherche
     */
    public function search($search) {
        // Requête SQL avec LIKE (pour recherche partielle)
        $sql = "SELECT * FROM foos WHERE nom LIKE :search ORDER BY nom";

        // Préparation de la requête
        $stmt = $this->pdo->prepare($sql);

        // Exécution avec le caractère % pour recherche partielle
        $stmt->execute(['search' => '%' . $search . '%']);

        return $stmt->fetchAll();
    }
}
