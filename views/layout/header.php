<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= SITE_NAME ?> - Boutique de jeux vidéo</title>
    <link rel="stylesheet" href="<?= ASSETS_PATH ?>/css/style.css">
</head>
<body>
    <header class="main-header">
        <div class="container">
            <div class="header-content">
                <h1 class="logo">
                    <a href="index.php"><?= SITE_NAME ?></a>
                </h1>
                <nav class="main-nav">
                    <ul>
                        <li><a href="index.php?controller=product&action=list">Catalogue</a></li>
                        <li><a href="index.php?controller=cart&action=show">Panier</a></li>
                        <?php if (isset($_SESSION['client_id'])): ?>
                            <li><a href="index.php?controller=customer&action=account">Mon compte</a></li>
                            <li><a href="index.php?controller=customer&action=logout">Déconnexion</a></li>
                        <?php else: ?>
                            <li><a href="index.php?controller=customer&action=login">Connexion</a></li>
                            <li><a href="index.php?controller=customer&action=register">Inscription</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main class="main-content">
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
