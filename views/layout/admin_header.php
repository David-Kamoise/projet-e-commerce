<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= SITE_NAME ?> - Administration</title>
    <link rel="stylesheet" href="<?= ASSETS_PATH ?>/css/style.css">
    <link rel="stylesheet" href="<?= ASSETS_PATH ?>/css/admin.css">
</head>
<body class="admin-body">
    <header class="admin-header">
        <div class="container">
            <div class="header-content">
                <h1 class="logo">
                    <a href="admin.php"><?= SITE_NAME ?> - Admin</a>
                </h1>
                <nav class="admin-nav">
                    <ul>
                        <li><a href="admin.php?controller=product&action=list">Produits</a></li>
                        <li><a href="admin.php?controller=customer&action=list">Clients</a></li>
                        <li><a href="admin.php?controller=order&action=list">Commandes</a></li>
                        <li><a href="admin.php?controller=cart&action=list">Paniers</a></li>
                        <li><a href="index.php" target="_blank">Voir le site</a></li>
                        <li><a href="admin.php?controller=auth&action=logout">Déconnexion</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main class="admin-content">
        <div class="container">
            <?php
            // Affichage des messages de succès
            if (isset($_SESSION['success'])):
            ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($_SESSION['success']) ?>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php
            // Affichage des messages d'erreur
            if (isset($_SESSION['error'])):
            ?>
                <div class="alert alert-error">
                    <?= htmlspecialchars($_SESSION['error']) ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
