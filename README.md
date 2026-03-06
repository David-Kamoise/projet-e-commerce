# Starter Kit Pédagogique - Projet E-Commerce BTS SIO 1

**Exemple générique avec architecture MVC**

## Table des matières

1. [Introduction](#introduction)
2. [Architecture MVC](#architecture-mvc)
3. [Installation](#installation)
4. [Structure des fichiers](#structure-des-fichiers)
5. [Guide d'utilisation](#guide-dutilisation)
6. [Exemples de code](#exemples-de-code)
7. [Comment adapter le starter-kit à votre projet](#comment-adapter-le-starter-kit-à-votre-projet)
8. [FAQ](#faq)

---

## Introduction

Ce starter kit vous fournit une base de travail pour démarrer votre projet e-commerce. Il contient :

- Une architecture MVC simplifiée
- Un **exemple CRUD complet générique** (modèle "Foo")
- Une connexion PDO sécurisée
- Des vues HTML/CSS de base
- Un script SQL avec des données de test

⚠️ **IMPORTANT** : Ce starter-kit contient un **exemple générique avec "Foo"** plutôt qu'un exemple spécifique à votre projet. Cela vous force à :
- Comprendre le code avant de l'adapter
- Éviter le copier-coller aveugle
- Appliquer les concepts MVC à votre propre contexte

**Ce qu'il contient DÉJÀ :**
- Modèle `Foo.php` : exemple de classe modèle avec CRUD
- Contrôleur `FooController.php` : exemple de contrôleur
- Vues : exemples de vues backoffice et frontoffice
- Tables SQL : `foos` et `foo_categories`

**Ce que VOUS devez développer (en vous inspirant de l'exemple) :**
- Module 1 (Produits) : Binôme 1
- Module 2 (Clients) : Binôme 2
- Module 3 (Commandes) : Binôme 3
- Module 4 (Paniers) : Binôme 4

---

## Architecture MVC

### Qu'est-ce que le pattern MVC ?

MVC signifie **Model-View-Controller** (Modèle-Vue-Contrôleur). C'est une façon d'organiser son code pour séparer les responsabilités :

```
┌──────────────┐
│   UTILISATEUR│
└──────┬───────┘
       │ 1. Requête HTTP
       ▼
┌──────────────────┐
│   CONTRÔLEUR     │ ← Fait le lien entre Model et Vue
│  (FooController) │
└────┬─────────┬───┘
     │         │
     │ 2.     │ 4.
     │         │
     ▼         ▼
┌─────────┐ ┌──────────┐
│  MODEL  │ │   VUE    │
│  (Foo)  │ │(catalog.php)│
└─────────┘ └──────────┘
     │
     │ 3. Données
     ▼
┌──────────────────┐
│   BASE DE DONNÉES│
└──────────────────┘
```

### Rôle de chaque composant

#### 1. Model (Modèle)
- **Rôle** : Gérer les données et la logique métier
- **Fichier** : `models/Foo.php`
- **Responsabilités** :
  - Se connecter à la base de données
  - Exécuter les requêtes SQL (CRUD)
  - Retourner les données

**Ne contient PAS** : Code HTML, logique d'affichage

#### 2. View (Vue)
- **Rôle** : Afficher les données à l'utilisateur
- **Fichier** : `views/shop/catalog.php`
- **Responsabilités** :
  - Afficher le HTML
  - Utiliser les données transmises par le contrôleur
  - Gérer la mise en forme visuelle

**Ne contient PAS** : Requêtes SQL, logique métier complexe

#### 3. Controller (Contrôleur)
- **Rôle** : Faire le lien entre Model et Vue
- **Fichier** : `controllers/FooController.php`
- **Responsabilités** :
  - Récupérer les paramètres de l'URL
  - Appeler les méthodes du modèle
  - Transmettre les données à la vue
  - Traiter les formulaires

**Ne contient PAS** : Requêtes SQL directes, code HTML

---

## Installation

Voir le fichier [GUIDE-INSTALLATION.md](GUIDE-INSTALLATION.md) pour les instructions détaillées.

**Résumé rapide** :

1. Installer un serveur local (XAMPP/WAMP/MAMP)
2. Copier les fichiers dans `htdocs/`
3. Importer `database.sql` dans phpMyAdmin
4. Configurer `config/config.php`
5. Tester : `http://localhost/votre-projet/public/index.php`

---

## Structure des fichiers

```
starter-kit/
│
├── config/
│   ├── config.php          ← Configuration générale
│   └── database.php        ← Connexion PDO
│
├── controllers/
│   └── FooController.php   ← Exemple de contrôleur
│
├── models/
│   └── Foo.php             ← Exemple de modèle
│
├── views/
│   ├── layout/
│   │   ├── header.php      ← En-tête du site
│   │   ├── footer.php      ← Pied de page du site
│   │   └── admin_header.php ← En-tête admin
│   ├── shop/
│   │   ├── catalog.php     ← Vue liste (frontoffice)
│   │   └── foo.php         ← Vue détail
│   └── admin/
│       └── foos/
│           ├── list.php    ← Vue liste admin
│           └── form.php    ← Formulaire CRUD
│
├── public/
│   ├── index.php           ← Point d'entrée frontoffice
│   ├── admin.php           ← Point d'entrée backoffice
│   └── .htaccess           ← Configuration Apache
│
├── assets/
│   ├── css/
│   │   ├── style.css       ← Styles frontoffice
│   │   └── admin.css       ← Styles backoffice
│   ├── js/
│   │   └── main.js         ← JavaScript
│   └── img/
│
├── database.sql            ← Script SQL
├── GUIDE-INSTALLATION.md   ← Guide d'installation détaillé
└── README.md               ← Ce fichier
```

---

## Guide d'utilisation

### Comment fonctionne le routing ?

Le routing détermine quel contrôleur et quelle action appeler en fonction de l'URL.

#### Exemples d'URLs

**Frontoffice** :
- `index.php` → Affiche le catalogue (par défaut)
- `index.php?controller=foo&action=list` → Liste des foos
- `index.php?controller=foo&action=show&id=5` → Détail du foo 5

**Backoffice** :
- `admin.php` → Liste des foos (par défaut)
- `admin.php?controller=foo&action=list` → Liste des foos
- `admin.php?controller=foo&action=create` → Formulaire de création
- `admin.php?controller=foo&action=edit&id=5` → Formulaire de modification

---

## Exemples de code

### Exemple 1 : Récupérer tous les éléments

```php
// Dans le modèle (Foo.php)
public function getAll() {
    $sql = "SELECT * FROM foos ORDER BY nom";
    $stmt = $this->pdo->query($sql);
    return $stmt->fetchAll();
}

// Dans le contrôleur (FooController.php)
public function list() {
    $foos = $this->fooModel->getAll();
    require_once __DIR__ . '/../views/shop/catalog.php';
}

// Dans la vue (catalog.php)
<?php foreach ($foos as $foo): ?>
    <h2><?= htmlspecialchars($foo['nom']) ?></h2>
    <p><?= number_format($foo['valeur'], 2) ?> €</p>
<?php endforeach; ?>
```

### Exemple 2 : Ajouter un élément

```php
// Dans le modèle (Foo.php)
public function create($data) {
    $sql = "INSERT INTO foos (nom, valeur, quantite) VALUES (:nom, :valeur, :quantite)";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([
        'nom' => $data['nom'],
        'valeur' => $data['valeur'],
        'quantite' => $data['quantite']
    ]);
    return $this->pdo->lastInsertId();
}

// Dans le contrôleur (FooController.php)
public function adminStore() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'nom' => $_POST['nom'],
            'valeur' => $_POST['valeur'],
            'quantite' => $_POST['quantite']
        ];

        $this->fooModel->create($data);

        header('Location: admin.php?controller=foo&action=list');
        exit;
    }
}
```

### Exemple 3 : Sécurité - Requêtes préparées

**MAUVAIS (Vulnérable à l'injection SQL)** :
```php
$id = $_GET['id'];
$sql = "SELECT * FROM foos WHERE id = $id";  // DANGEREUX !
```

**BON (Requête préparée)** :
```php
$id = $_GET['id'];
$sql = "SELECT * FROM foos WHERE id = :id";
$stmt = $this->pdo->prepare($sql);
$stmt->execute(['id' => $id]);
```

### Exemple 4 : Affichage sécurisé (protection XSS)

**MAUVAIS** :
```php
<h1><?= $foo['nom'] ?></h1>  <!-- Risque XSS -->
```

**BON** :
```php
<h1><?= htmlspecialchars($foo['nom']) ?></h1>  <!-- Protégé -->
```

---

## Comment adapter le starter-kit à votre projet

### Pour le Binôme 1 (Produits)

**Étape 1** : Comprendre l'exemple "Foo"
- Lisez `models/Foo.php` : comment fonctionnent les requêtes CRUD ?
- Lisez `controllers/FooController.php` : comment le contrôleur appelle le modèle ?
- Lisez les vues : comment les données sont affichées ?

**Étape 2** : Adapter la base de données
- Modifier `database.sql` :
  - Renommer `foos` en `produits`
  - Renommer `foo_categories` en `categories`
  - Adapter les champs : `valeur` → `prix`, `quantite` → `stock`
  - Ajouter le champ `image`

**Étape 3** : Créer le modèle Product
- Copier `models/Foo.php` en `models/Product.php`
- Renommer la classe `Foo` en `Product`
- Adapter les noms de tables dans les requêtes SQL
- Adapter les noms de champs

**Étape 4** : Créer le contrôleur ProductController
- Copier `controllers/FooController.php` en `controllers/ProductController.php`
- Renommer `FooController` en `ProductController`
- Renommer `$fooModel` en `$productModel`
- Adapter les noms de variables

**Étape 5** : Créer les vues
- Copier `views/admin/foos/` en `views/admin/products/`
- Copier `views/shop/foo.php` en `views/shop/product.php`
- Adapter les noms de variables : `$foo` → `$product`, `$foos` → `$products`

**Étape 6** : Tester
- `index.php?controller=product&action=list`
- `admin.php?controller=product&action=list`

### Pour les autres binômes

Suivez la même logique :
- **Binôme 2 (Clients)** : Adaptez Foo → Customer, foos → clients
- **Binôme 3 (Commandes)** : Adaptez Foo → Order, foos → commandes
- **Binôme 4 (Paniers)** : Adaptez Foo → Cart, foos → paniers

---

## FAQ

### Pourquoi "Foo" et pas "Product" ?

Pour éviter de vous donner directement la solution du Binôme 1. "Foo" est un placeholder générique utilisé en programmation. Vous devez comprendre le code et l'adapter à votre contexte.

### Comment déboguer mon code PHP ?

1. **Afficher les erreurs** : Vérifiez que `display_errors = On` dans `config.php`

2. **Utiliser var_dump()** :
```php
var_dump($foos);  // Affiche le contenu de la variable
die();  // Arrête l'exécution
```

3. **Vérifier les erreurs SQL** :
```php
try {
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($data);
} catch (PDOException $e) {
    echo "Erreur SQL : " . $e->getMessage();
    die();
}
```

### Comment tester mes requêtes SQL ?

1. Ouvrez phpMyAdmin
2. Sélectionnez la base `exemple_starter`
3. Cliquez sur l'onglet **SQL**
4. Testez vos requêtes directement

### Mes modifications CSS ne s'appliquent pas, pourquoi ?

Le navigateur met en cache le CSS. Solutions :

1. **Vider le cache** : Ctrl+F5 (Windows) ou Cmd+Shift+R (Mac)
2. **Mode navigation privée** : Testez en navigation privée

---

## Ressources utiles

- **PHP** : https://www.php.net/manual/fr/
- **MySQL** : https://dev.mysql.com/doc/
- **PDO** : https://www.php.net/manual/fr/book.pdo.php
- **Git** : https://git-scm.com/book/fr/v2

---

**Bon développement à tous !**

Pour toute question, contactez votre professeur ou consultez vos collègues.
