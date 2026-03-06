<?php
/**
 * Contrôleur Foo
 *
 * Ce fichier contient la classe FooController qui gère toutes les actions
 * liées aux foos (affichage, création, modification, suppression).
 *
 * RÔLE DU CONTRÔLEUR DANS MVC :
 * Le contrôleur fait le lien entre le modèle (données) et la vue (affichage).
 * Il récupère les données du modèle et les transmet à la vue.
 * Il traite les formulaires et appelle les méthodes du modèle.
 */

require_once __DIR__ . '/../models/Foo.php';

class FooController {

    /**
     * Instance du modèle Foo
     * @var Foo
     */
    private $fooModel;

    /**
     * Constructeur
     * Initialise le modèle Foo
     */
    public function __construct() {
        $this->fooModel = new Foo();
    }

    /**
     * Affiche la liste des foos (frontoffice)
     *
     * Cette méthode récupère tous les foos et les affiche dans une vue.
     * URL : index.php?controller=foo&action=list
     */
    public function list() {
        // 1. Récupération des données depuis le modèle
        $foos = $this->fooModel->getAll();

        /**
         * TODO POUR LES ÉTUDIANTS :
         * - Ajouter la recherche par nom
         * - Ajouter la pagination (10 éléments par page)
         * - Ajouter le tri (par nom, par date)
         */

        // 2. Transmission des données à la vue
        // On inclut la vue et on lui passe les données via des variables
        require_once __DIR__ . '/../views/shop/catalog.php';
    }

    /**
     * Affiche le détail d'un foo (frontoffice)
     *
     * URL : index.php?controller=foo&action=show&id=5
     */
    public function show() {
        // 1. Récupération de l'ID du foo depuis l'URL
        $id = $_GET['id'] ?? null;

        // 2. Validation de l'ID
        if (!$id || !is_numeric($id)) {
            die('Erreur : ID invalide');
        }

        // 3. Récupération du foo depuis le modèle
        $foo = $this->fooModel->getById($id);

        // 4. Vérification que le foo existe
        if (!$foo) {
            http_response_code(404);
            die('Erreur 404 : Élément non trouvé');
        }

        /**
         * TODO POUR LES ÉTUDIANTS :
         * - Ajouter des fonctionnalités supplémentaires selon votre projet
         */

        // 5. Affichage de la vue
        require_once __DIR__ . '/../views/shop/foo.php';
    }

    /**
     * Affiche la liste des foos (backoffice - administration)
     *
     * URL : admin.php?controller=foo&action=list
     */
    public function adminList() {
        // Récupération de tous les foos
        $foos = $this->fooModel->getAll();

        /**
         * TODO POUR LES ÉTUDIANTS :
         * - Ajouter une colonne "Actions" (Modifier, Supprimer)
         * - Ajouter un bouton "Ajouter un élément"
         * - Ajouter la recherche
         */

        // Affichage de la vue admin
        require_once __DIR__ . '/../views/admin/foos/list.php';
    }

    /**
     * Affiche le formulaire de création d'un foo (backoffice)
     *
     * URL : admin.php?controller=foo&action=create
     */
    public function adminCreate() {
        // Par défaut, on affiche juste le formulaire vide
        // Le traitement du formulaire se fait dans adminStore()

        /**
         * TODO POUR LES ÉTUDIANTS :
         * - Ajouter des champs supplémentaires selon votre projet
         */

        // Affichage du formulaire
        require_once __DIR__ . '/../views/admin/foos/form.php';
    }

    /**
     * Traite la soumission du formulaire de création (backoffice)
     *
     * URL : admin.php?controller=foo&action=store (méthode POST)
     */
    public function adminStore() {
        // Vérification que la requête est bien en POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            die('Erreur : Méthode non autorisée');
        }

        // 1. Récupération des données du formulaire
        $data = [
            'nom' => $_POST['nom'] ?? '',
            'description' => $_POST['description'] ?? ''
        ];

        // 2. Validation des données
        $errors = [];

        if (empty($data['nom'])) {
            $errors[] = 'Le nom est obligatoire';
        }

        /**
         * TODO POUR LES ÉTUDIANTS :
         * - Ajouter plus de validations (longueur du nom, etc.)
         * - Protéger contre les injections XSS avec htmlspecialchars()
         */

        // 3. Si des erreurs existent, on les affiche et on arrête
        if (!empty($errors)) {
            // Affichage des erreurs (version simplifiée)
            foreach ($errors as $error) {
                echo '<p style="color: red;">' . htmlspecialchars($error) . '</p>';
            }
            // Réaffichage du formulaire avec les données déjà saisies
            require_once __DIR__ . '/../views/admin/foos/form.php';
            return;
        }

        // 4. Si tout est ok, on crée le foo
        try {
            $fooId = $this->fooModel->create($data);

            // 5. Redirection vers la liste avec un message de succès
            $_SESSION['success'] = 'Élément créé avec succès !';
            header('Location: admin.php?controller=foo&action=list');
            exit;

        } catch (Exception $e) {
            // En cas d'erreur, on affiche un message
            die('Erreur lors de la création : ' . $e->getMessage());
        }
    }

    /**
     * Affiche le formulaire de modification d'un foo (backoffice)
     *
     * URL : admin.php?controller=foo&action=edit&id=5
     */
    public function adminEdit() {
        // 1. Récupération de l'ID
        $id = $_GET['id'] ?? null;

        // 2. Validation de l'ID
        if (!$id || !is_numeric($id)) {
            die('Erreur : ID invalide');
        }

        // 3. Récupération du foo
        $foo = $this->fooModel->getById($id);

        // 4. Vérification que le foo existe
        if (!$foo) {
            http_response_code(404);
            die('Erreur 404 : Élément non trouvé');
        }

        /**
         * TODO POUR LES ÉTUDIANTS :
         * - Pré-remplir le formulaire avec les données actuelles
         */

        // 5. Affichage du formulaire (réutilisation du même formulaire que create)
        require_once __DIR__ . '/../views/admin/foos/form.php';
    }

    /**
     * Traite la soumission du formulaire de modification (backoffice)
     *
     * URL : admin.php?controller=foo&action=update&id=5 (méthode POST)
     */
    public function adminUpdate() {
        // Vérification de la méthode POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            die('Erreur : Méthode non autorisée');
        }

        // 1. Récupération de l'ID
        $id = $_POST['id'] ?? null;

        if (!$id || !is_numeric($id)) {
            die('Erreur : ID invalide');
        }

        // 2. Récupération des données du formulaire
        $data = [
            'nom' => $_POST['nom'] ?? '',
            'description' => $_POST['description'] ?? ''
        ];

        // 3. Validation (même logique que create)
        // ... (code de validation similaire à adminStore)

        // 4. Mise à jour du foo
        try {
            $this->fooModel->update($id, $data);

            // 5. Redirection avec message de succès
            $_SESSION['success'] = 'Élément modifié avec succès !';
            header('Location: admin.php?controller=foo&action=list');
            exit;

        } catch (Exception $e) {
            die('Erreur lors de la modification : ' . $e->getMessage());
        }
    }

    /**
     * Supprime un foo (backoffice)
     *
     * URL : admin.php?controller=foo&action=delete&id=5
     */
    public function adminDelete() {
        // 1. Récupération de l'ID
        $id = $_GET['id'] ?? null;

        // 2. Validation
        if (!$id || !is_numeric($id)) {
            die('Erreur : ID invalide');
        }

        /**
         * TODO POUR LES ÉTUDIANTS :
         * - Ajouter une confirmation JavaScript avant suppression
         * - Vérifier les contraintes référentielles
         * - Utiliser une méthode POST plutôt que GET pour plus de sécurité
         */

        // 3. Suppression
        try {
            $this->fooModel->delete($id);

            // 4. Redirection avec message
            $_SESSION['success'] = 'Élément supprimé avec succès !';
            header('Location: admin.php?controller=foo&action=list');
            exit;

        } catch (Exception $e) {
            die('Erreur lors de la suppression : ' . $e->getMessage());
        }
    }
}
