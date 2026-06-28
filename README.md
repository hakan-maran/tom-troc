# PHP Site Tom Troc

Tom Troc est une application web développée dans le cadre d'une formation OpenClassrooms. Elle permet aux passionnés de lecture d'échanger des livres entre eux, de gérer leur bibliothèque virtuelle et de discuter de leurs lectures via une messagerie intégrée.

## Fonctionnalités principales

- Inscription et connexion des utilisateurs
- Création, affichage, modification et suppression de livres
- Gestion de la disponibilité des livres
- Messagerie interne pour échanger avec d'autres lecteurs
- Profil utilisateur et affichage de profils publics
- Upload d'images de couverture pour les livres

## Technologies

- PHP 7.4+ avec autoload PSR-4
- Composer pour la gestion des dépendances
- MySQL / MariaDB pour la base de données
- HTML / CSS / JavaScript pour l'interface
- Routeur maison dans `public/index.php`

## Architecture

L'application suit une architecture MVC avec une conception orientée objet (POO).

- `public/` : point d'entrée du site et ressources publiques (CSS, JS, images)
- `src/controllers/` : contrôleurs qui gèrent les actions et les vues
- `src/models/` : entités, managers et accès aux données
- `src/views/` : templates HTML et layout
- `config/database.php` : configuration de la base de données
- `database.sql` : script de création et d'initialisation de la base

## Prérequis

- PHP 7.4 ou plus récent
- Composer
- MySQL / MariaDB
- Serveur web (Apache, Nginx) ou serveur PHP intégré

## Problèmes courants

- `DocumentRoot` non configuré sur le dossier `public/`
- Mauvaises informations de connexion MySQL dans `config/database.php`
- Permissions insuffisantes sur `public/img/books/` pour l'upload d'images
- Absence du dossier `vendor/` si `composer install` n'a pas été exécuté

## Installation

1. Cloner le dépôt ou copier les fichiers sur le serveur.
2. Placer la racine du serveur web sur le dossier `public/`.
3. Installer les dépendances Composer :

```bash
composer install
```

## Configuration de la base de données

Le fichier de configuration est `config/database.php`.

Modifiez les constantes selon votre environnement :

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'tomtroc');
define('DB_USER', 'root');
define('DB_PASS', 'root');
```

### Importer la base de données

Importer le fichier SQL dans votre base de données :

```bash
mysql -u root -p tomtroc < database.sql
```

J'ai généré un fichier de données d’amorçage supplémentaire, vous pouvez aussi l’importer ainsi :

```bash
mysql -u root -p tomtroc < seed_data.sql
```

Remplacez `root` et `tomtroc` par votre utilisateur et nom de base de données si nécessaire.

## Déploiement local

Vous pouvez lancer le site localement avec le serveur PHP intégré :

```bash
php -S localhost:8000 -t public
```

Puis ouvrir `http://localhost:8000` dans votre navigateur.

Remarque : un serveur local PHP intégré a été utilisé pour le développement (`php -S`). Il est néanmoins possible de configurer un serveur Apache ou Nginx pour un déploiement en production — suivez les exemples ci-dessous.

## Configuration du serveur web

### Apache

1. Définir le répertoire racine sur `public/`.
2. Vérifier que `mod_php` ou PHP-FPM est activé.
3. Exemple de configuration de virtual host :

```apache
<VirtualHost *:80>
    ServerName tomtroc.local
    DocumentRoot /chemin/vers/PHP-site-TomTroc/public

    <Directory /chemin/vers/PHP-site-TomTroc/public>
        AllowOverride None
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/tomtroc_error.log
    CustomLog ${APACHE_LOG_DIR}/tomtroc_access.log combined
</VirtualHost>
```

### Nginx

1. Définir le `root` sur le dossier `public/`.
2. Configurer PHP-FPM.
3. Exemple de bloc de serveur :

```nginx
server {
    listen 80;
    server_name tomtroc.local;
    root /chemin/vers/PHP-site-TomTroc/public;

    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_pass unix:/var/run/php/php-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}
```

## Permissions

Le dossier `public/img/books/` doit être inscriptible si vous souhaitez autoriser l'upload d'images :

```bash
mkdir -p public/img/books
chmod 755 public/img/books
```

## Tests rapides

- Accéder à la page d'accueil : `http://votre-domaine/`
- Vérifier que les livres s'affichent : `?action=books`
- Vérifier la connexion et l'inscription avec les formulaires disponibles

## Notes

- Le routeur principal est dans `public/index.php`.
- Les entités et managers sont dans `src/models/entities/` et `src/models/managers/`.
- Si vous changez les identifiants de la base, mettez à jour `config/database.php`.
