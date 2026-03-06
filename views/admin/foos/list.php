<?php
/**
 * Vue : Liste des foos (backoffice - administration)
 *
 * Cette vue affiche la liste de tous les foos avec possibilité de modifier/supprimer.
 * Elle reçoit la variable $foos du contrôleur.
 */

// Inclusion du header admin
require_once __DIR__ . '/../../layout/admin_header.php';
?>

<div class="admin-foos-page">
    <div class="page-header">
        <h1>Gestion des Foos</h1>
        <a href="admin.php?controller=foo&action=create" class="btn btn-success">
            + Ajouter un Foo
        </a>
    </div>

    <?php
    // TODO POUR LES ÉTUDIANTS :
    // - Ajouter un champ de recherche
    // - Ajouter des filtres
    // - Ajouter une pagination
    ?>

    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Description</th>
                <th>Date d'ajout</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($foos)): ?>
                <tr>
                    <td colspan="5" class="text-center">Aucun élément disponible.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($foos as $foo): ?>
                    <tr>
                        <td><?= $foo['id'] ?></td>
                        <td><?= htmlspecialchars($foo['nom']) ?></td>
                        <td><?= htmlspecialchars(substr($foo['description'], 0, 50)) ?>...</td>
                        <td><?= date('d/m/Y', strtotime($foo['date_ajout'])) ?></td>
                        <td class="actions">
                            <a href="admin.php?controller=foo&action=edit&id=<?= $foo['id'] ?>"
                               class="btn btn-sm btn-primary"
                               title="Modifier">
                                Modifier
                            </a>
                            <a href="admin.php?controller=foo&action=delete&id=<?= $foo['id'] ?>"
                               class="btn btn-sm btn-danger"
                               title="Supprimer"
                               onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')">
                                Supprimer
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="table-stats">
        <p>Total : <?= count($foos) ?> élément(s)</p>
    </div>
</div>

<?php
// Inclusion du footer
require_once __DIR__ . '/../../layout/footer.php';
?>
