# Guide d'installation - Starter Kit E-Commerce BTS SIO 1

## Étape 1 : Installation de la stack LAMP

### Apache + PHP

- exécuter dans un terminal

```bash
sudo apt install apache2 libapache2-mod-php
```

- ouvrir un navigateur à l'adresse : http://localhost

### Mysql (Mariadb)

- exécuter dans un terminal

```bash
sudo apt install mariadb-server mariadb-client
```

---

## Étape 2 : Créer la base de données

- exécuter dans un terminal

```bash
sudo mysql -u root
```

- créer la base de données et un utilisateur associé

```sql
CREATE USER 'sio'@'localhost' IDENTIFIED BY '_TODO_';
GRANT ALL PRIVILEGES ON tahitigame.* TO 'sio'@'localhost';
FLUSH PRIVILEGES;
```

- importer le script SQL

```bash
sudo mysql -u root < database.sql
```

---

## Étape 3 : Gérer la base de données

- télécharger adminer : https://www.adminer.org/
- déployer adminer

```bash
sudo mkdir /var/www/html/adminer
sudo cp adminer-<version>.php /var/www/html/adminer/index.php
sudo chown -R www-data: /var/www/html/adminer
```

- ouvrir un navigateur à l'adresse : http://localhost/adminer/
- vérifier la base de données *tahitigame*

---

## Étape 4 : Déployer le projet

- configurer l'accès à la base de données

```bash
cp config/config.php.example config/config.php
nano config/config.php
  define('DB_NAME', 'tahitigame');
  define('DB_USER', 'sio');
  define('DB_PASS', '_TODO_');
chmod 600 config/config.php
```

- exécuter dans un terminal

```bash
sudo cp -r starter-kit /var/www/html
sudo chown -R www-data: /var/www/html/starter-kit
```

**Important** : Vous pouvez renommer le dossier selon votre projet (ex: `mon-projet-ecommerce`).

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

```bash
sudo systemctl status mariadb
sudo systemctl restart mariadb
```

### Erreur : "Base de données non trouvée"

**Problème** : La base `tahitigame` n'a pas été créée

**Solution** :
1. Retournez à l'étape 2
2. Vérifiez que le script SQL a bien été exécuté
3. Vérifiez dans adminer que la base `tahitigame` existe

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
- [ ] La base de données `tahitigame` existe avec ses tables
- [ ] Les fichiers sont dans le bon dossier (`/var/www/html/starter-kit`)
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
