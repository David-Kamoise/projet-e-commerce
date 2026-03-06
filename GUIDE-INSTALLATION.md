# Guide d'installation - Starter Kit E-Commerce BTS SIO 1

## Prérequis

Avant de commencer, assurez-vous d'avoir installé :

- [ ] **Serveur local** : XAMPP, WAMP, MAMP ou Docker
- [ ] **PHP** : Version 7.4 minimum (8.0+ recommandé)
- [ ] **MySQL** : Version 5.7 minimum (8.0+ recommandé)
- [ ] **Navigateur web** : Chrome, Firefox, Edge ou Safari

---

## Étape 1 : Installation du serveur local

### Option A : XAMPP (Windows, Mac, Linux)

1. Téléchargez XAMPP : https://www.apachefriends.org/
2. Installez XAMPP en suivant l'assistant
3. Démarrez **Apache** et **MySQL** depuis le panneau de contrôle XAMPP

### Option B : WAMP (Windows uniquement)

1. Téléchargez WAMP : https://www.wampserver.com/
2. Installez WAMP
3. Lancez WAMP (icône verte = tout fonctionne)

### Option C : MAMP (Mac uniquement)

1. Téléchargez MAMP : https://www.mamp.info/
2. Installez MAMP
3. Lancez MAMP et cliquez sur "Start Servers"

---

## Étape 2 : Copier les fichiers du projet

Copiez le dossier `starter-kit` dans votre répertoire web :

### Sur XAMPP
```
C:\xampp\htdocs\starter-kit
```

### Sur WAMP
```
C:\wamp64\www\starter-kit
```

### Sur MAMP
```
/Applications/MAMP/htdocs/starter-kit
```

**Important** : Vous pouvez renommer le dossier selon votre projet (ex: `mon-projet-ecommerce`).

---

## Étape 3 : Créer la base de données

### 3.1 Ouvrir phpMyAdmin

Dans votre navigateur, allez à l'adresse :
```
http://localhost/phpmyadmin
```

### 3.2 Importer le script SQL

1. Cliquez sur l'onglet **SQL** en haut de la page
2. Ouvrez le fichier `database.sql` (dans le dossier starter-kit) avec un éditeur de texte
3. Copiez tout le contenu du fichier
4. Collez-le dans la zone de texte de phpMyAdmin
5. Cliquez sur le bouton **Exécuter** en bas à droite

### 3.3 Vérifier la création

1. Dans le menu de gauche, vous devriez voir apparaître la base `exemple_starter`
2. Cliquez dessus
3. Vous devriez voir 2 tables :
   - `foo_categories`
   - `foos`

⚠️ **IMPORTANT** : Cette base de données est un **exemple générique**. Vous devrez :
- Créer votre propre base de données pour votre projet (ex: `tahitigame`)
- Adapter les tables selon votre module (produits, clients, commandes, paniers)

---

## Étape 4 : Configurer la connexion à la base

### 4.1 Ouvrir le fichier de configuration

Ouvrez le fichier suivant avec un éditeur de code :
```
starter-kit/config/config.php
```

### 4.2 Vérifier les paramètres de connexion

Localisez ces lignes dans le fichier :

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'exemple_starter');
define('DB_USER', 'root');
define('DB_PASS', '');
```

### 4.3 Adapter si nécessaire

**Pour XAMPP/WAMP (Windows)** :
- Utilisateur : `root`
- Mot de passe : `` (vide)

**Pour MAMP (Mac)** :
- Utilisateur : `root`
- Mot de passe : `root`

Si vous utilisez MAMP, modifiez la ligne comme suit :
```php
define('DB_PASS', 'root');
```

---

## Étape 5 : Tester l'installation

### 5.1 Tester le frontoffice

Dans votre navigateur, allez à l'adresse :
```
http://localhost/starter-kit/public/index.php
```

**Résultat attendu** : Vous devriez voir le catalogue avec 8 éléments "Foo".

### 5.2 Tester le backoffice

Dans votre navigateur, allez à l'adresse :
```
http://localhost/starter-kit/public/admin.php
```

**Résultat attendu** : Vous devriez voir la liste des foos en mode administration.

---

## Étape 6 : Tester les fonctionnalités

### Test 1 : Afficher un élément

1. Dans le catalogue, cliquez sur **"Voir le détail"** d'un foo
2. Vous devriez voir la page de détail de l'élément

### Test 2 : Créer un élément (backoffice)

1. Allez sur `http://localhost/starter-kit/public/admin.php`
2. Cliquez sur **"+ Ajouter un Foo"**
3. Remplissez le formulaire :
   - Nom : Test Foo
   - Description : Ceci est un test
   - Valeur : 19.99
   - Quantité : 5
   - Catégorie : Catégorie A
4. Cliquez sur **"Créer l'élément"**
5. Vous devriez être redirigé vers la liste avec un message de succès

### Test 3 : Modifier un élément

1. Dans la liste admin, cliquez sur **"Modifier"** pour un foo
2. Modifiez le nom ou la valeur
3. Cliquez sur **"Enregistrer les modifications"**
4. Vérifiez que les changements sont bien pris en compte

### Test 4 : Supprimer un élément

1. Dans la liste admin, cliquez sur **"Supprimer"** pour un foo
2. Confirmez la suppression
3. L'élément devrait disparaître de la liste

---

## Dépannage

### Erreur : "Connexion refusée"

**Problème** : Le serveur MySQL n'est pas démarré

**Solution** :
1. Ouvrez le panneau XAMPP/WAMP/MAMP
2. Vérifiez que **MySQL** est bien démarré (bouton vert)
3. Redémarrez MySQL si nécessaire

### Erreur : "Base de données non trouvée"

**Problème** : La base `exemple_starter` n'a pas été créée

**Solution** :
1. Retournez à l'étape 3
2. Vérifiez que le script SQL a bien été exécuté
3. Vérifiez dans phpMyAdmin que la base `exemple_starter` existe

### Erreur : "Access denied for user 'root'"

**Problème** : Le mot de passe de connexion est incorrect

**Solution** :
1. Vérifiez le mot de passe MySQL dans phpMyAdmin
2. Adaptez le fichier `config/config.php` en conséquence
3. Sur MAMP, le mot de passe est généralement `root`

### Erreur 404 : Page non trouvée

**Problème** : Le chemin vers les fichiers est incorrect

**Solution** :
1. Vérifiez que le dossier est bien dans `htdocs/starter-kit`
2. Vérifiez l'URL : `http://localhost/starter-kit/public/index.php`
3. Vérifiez que Apache est bien démarré

### Le CSS ne s'applique pas

**Problème** : Le cache du navigateur ou chemin CSS incorrect

**Solution** :
1. Videz le cache : Ctrl+F5 (Windows) ou Cmd+Shift+R (Mac)
2. Testez en navigation privée

---

## Configuration avancée (optionnel)

### Activer les erreurs PHP

Pour mieux déboguer, assurez-vous que l'affichage des erreurs est activé dans `config/config.php` :

```php
if (ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}
```

---

## Checklist finale

Avant de commencer à développer, vérifiez que :

- [ ] Le serveur local (Apache + MySQL) est démarré
- [ ] La base de données `exemple_starter` existe avec ses 2 tables
- [ ] Les fichiers sont dans le bon dossier (`htdocs/starter-kit`)
- [ ] Le frontoffice affiche le catalogue : `http://localhost/starter-kit/public/index.php`
- [ ] Le backoffice affiche la liste admin : `http://localhost/starter-kit/public/admin.php`
- [ ] Vous pouvez créer, modifier et supprimer un foo
- [ ] Le CSS s'affiche correctement

---

## Prochaines étapes

Maintenant que votre environnement est installé :

1. **Lisez le README.md** pour comprendre :
   - L'architecture MVC
   - Comment fonctionne le code "Foo"
   - Comment adapter le starter-kit à votre projet

2. **Explorez le code** :
   - `models/Foo.php` : comment fonctionnent les requêtes SQL ?
   - `controllers/FooController.php` : comment le contrôleur gère les actions ?
   - Les vues : comment les données sont affichées ?

3. **Adaptez à votre projet** :
   - Binôme 1 : Foo → Product
   - Binôme 2 : Foo → Customer
   - Binôme 3 : Foo → Order
   - Binôme 4 : Foo → Cart

4. **Créez votre propre base de données** :
   - Adaptez `database.sql` selon vos besoins
   - Créez les tables pour votre module
   - Modifiez `config/config.php` avec le nom de votre base

**Bon développement !**
