<?php
/**
 * Vue : Détail d'un foo (frontoffice)
 *
 * Cette vue affiche les informations détaillées d'un foo.
 * Elle reçoit la variable $foo du contrôleur.
 */

// Inclusion du header
require_once __DIR__ . '/../layout/header.php';
?>

<div class="foo-detail-page">
    <div class="foo-detail">
        <div class="foo-info-large">
            <h1><?= htmlspecialchars($foo['nom']) ?></h1>

            <div class="foo-description">
                <h2>Description</h2>
                <p><?= nl2br(htmlspecialchars($foo['description'])) ?></p>
            </div>

            <div class="foo-meta">
                <p class="foo-date">
                    Ajouté le <?= date('d/m/Y', strtotime($foo['date_ajout'])) ?>
                </p>
            </div>

            <?php
            // TODO POUR LES ÉTUDIANTS :
            // - Ajouter des fonctionnalités selon votre projet
            // - Par exemple : prix, bouton ajouter au panier, images, etc.
            ?>

            <div class="foo-actions">
                <a href="index.php?controller=foo&action=list" class="btn btn-secondary">
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>

</div>

<?php
// Inclusion du footer
require_once __DIR__ . '/../layout/footer.php';
?>
