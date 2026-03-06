<?php
/**
 * Vue : Liste de foos (frontoffice)
 *
 * Cette vue affiche la liste de tous les foos disponibles.
 * Elle reçoit la variable $foos du contrôleur.
 *
 * RÔLE DE LA VUE DANS MVC :
 * La vue s'occupe uniquement de l'affichage (HTML).
 * Elle ne contient PAS de logique métier complexe.
 * Elle affiche les données transmises par le contrôleur.
 */

// Inclusion du header
require_once __DIR__ . '/../layout/header.php';
?>

<div class="catalog-page">
    <h1>Liste de Foos</h1>

    <?php
    // TODO POUR LES ÉTUDIANTS :
    // - Ajouter un formulaire de recherche
    // - Ajouter des filtres
    // - Ajouter le tri (par nom, par date)
    ?>

    <div class="foos-grid">
        <?php if (empty($foos)): ?>
            <p class="no-foos">Aucun élément disponible pour le moment.</p>
        <?php else: ?>
            <?php foreach ($foos as $foo): ?>
                <div class="foo-card">
                    <div class="foo-info">
                        <h2 class="foo-name">
                            <?= htmlspecialchars($foo['nom']) ?>
                        </h2>
                        <p class="foo-description">
                            <?= htmlspecialchars(substr($foo['description'], 0, 100)) ?>...
                        </p>
                        <div class="foo-actions">
                            <a href="index.php?controller=foo&action=show&id=<?= $foo['id'] ?>"
                               class="btn btn-primary">
                                Voir le détail
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php
// Inclusion du footer
require_once __DIR__ . '/../layout/footer.php';
?>
