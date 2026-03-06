<?php
/**
 * Vue : Formulaire de création/modification d'un foo (backoffice)
 *
 * Cette vue affiche un formulaire pour créer ou modifier un foo.
 * Elle reçoit la variable $foo si c'est une modification (sinon null).
 */

// Inclusion du header admin
require_once __DIR__ . '/../../layout/admin_header.php';

// Détection du mode (création ou modification)
$isEdit = isset($foo) && !empty($foo);
$pageTitle = $isEdit ? 'Modifier un Foo' : 'Ajouter un Foo';
$submitAction = $isEdit ? 'update' : 'store';
?>

<div class="admin-foo-form-page">
    <div class="page-header">
        <h1><?= $pageTitle ?></h1>
        <a href="admin.php?controller=foo&action=list" class="btn btn-secondary">
            Retour à la liste
        </a>
    </div>

    <form action="admin.php?controller=foo&action=<?= $submitAction ?>" method="POST" class="foo-form">

        <?php if ($isEdit): ?>
            <!-- Champ caché pour l'ID en mode modification -->
            <input type="hidden" name="id" value="<?= $foo['id'] ?>">
        <?php endif; ?>

        <div class="form-group">
            <label for="nom">Nom *</label>
            <input type="text"
                   id="nom"
                   name="nom"
                   value="<?= $isEdit ? htmlspecialchars($foo['nom']) : '' ?>"
                   required
                   maxlength="200"
                   placeholder="Exemple : Foo Alpha">
            <small>Maximum 200 caractères</small>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description"
                      name="description"
                      rows="5"
                      placeholder="Description détaillée..."><?= $isEdit ? htmlspecialchars($foo['description']) : '' ?></textarea>
        </div>

        <?php
        // TODO POUR LES ÉTUDIANTS :
        // - Ajouter des champs supplémentaires selon votre projet
        // - Exemples : prix, stock, catégorie, image, etc.
        ?>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <?= $isEdit ? 'Enregistrer les modifications' : 'Créer l\'élément' ?>
            </button>
            <a href="admin.php?controller=foo&action=list" class="btn btn-secondary">
                Annuler
            </a>
        </div>
    </form>
</div>

<?php
// Inclusion du footer
require_once __DIR__ . '/../../layout/footer.php';
?>
