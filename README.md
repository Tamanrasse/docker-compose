Projet Docker-Compose : Réseau social Bankai


Description de l'application
Ce projet met en place une application web basée sur Laravel, un framework PHP. Il reprend le travail fait lors du projet PHP de fin de module. L'application est déployée via Docker Compose avec trois conteneurs interconnectés :
app : Conteneur PHP (basé sur une image construite à partir d'un Dockerfile) exécutant l'application Laravel avec PHP-FPM.

webserver : Conteneur Nginx servant les fichiers statiques et redirigeant les requêtes PHP vers le conteneur app.

db : Conteneur MySQL pour la base de données de l'application.

Les conteneurs communiquent via un réseau Docker nommé laravel. Un volume nommé dbdata est utilisé pour persister les données de la base de données, et un volume de type bind est configuré pour partager le code source entre l'hôte et les conteneurs app et webserver.
L'application est une application Laravel standard, permettant de tester un environnement web avec une base de données MySQL.

Prérequis
Docker/Docker Compose doivent être installés sur la machine.
Machine Ubuntu
Ports locaux 8000 (pour Nginx) et 3306 (pour MySQL) doivent être libres.

Structure du projet
Projet_Bankai-main/ : Contient le code source de l'application Laravel.

Dockerfile : Définit l'image personnalisée pour le conteneur app (PHP-FPM avec dépendances).

docker-compose.yml : Configure les services, réseaux et volumes.

docker/nginx/conf.d/ : Contient la configuration Nginx pour le conteneur webserver.

Lancement des conteneurs
Cloner ou décompresser le projet :
Décompressez l'archive .zip un dossier local.

Naviguer dans le dossier du projet :
cd Projet_Bankai-main

Lancer les conteneurs avec Docker Compose :
sudo docker-compose up

Cette commande :
Construit l'image personnalisée pour le conteneur app à partir du Dockerfile.
Télécharge les images nginx:alpine et mysql:8.0 si nécessaire.
Crée le réseau laravel et le volume dbdata.
Lance les trois conteneurs (app, webserver, db) en arrière-plan.


Accéder à l'application :
Ouvrez un navigateur et allez à l'adresse : http://localhost:8000.

Vous devriez voir la page d'accueil du réseau social.
Vous pouvez vous créer un compte puis cliquer sur l'onglet poster.
Vous pouvez stopper les conteneurs avec un CTRL+C puis les relancer avec sudo docker compose up.
En créant un nouveau compte, (On ne peut pas se reconnecter à un compte déjà créer, problème apparu pendant le projet PHP qui n'a rien à voir avec le conteneur), vous pouvez constater que l'ancien post est toujours la.

Vérifier la connexion à la base de données :
L'application Laravel est configurée pour se connecter au conteneur db (MySQL).
Les migrations Laravel sont automatiquement exécutées lors du démarrage du conteneur app (via php artisan migrate dans le command du docker-compose.yml).

Pour tester manuellement la base de données :
sudo docker exec -it mysql mysql -u laravel -plaravel laravel

Cette commande ouvre un terminal MySQL dans le conteneur db.

Vous pouvez lister les tables avec show tables; pour vérifier que les migrations ont été appliquées.
Vous pouvez aussi constater l'utilisateur que vous avez créé avec select * from users;

Pour arrêter et supprimer les conteneurs (le volume dbdata persiste les données) :
sudo docker-compose down


Détails techniques
Communication entre conteneurs :
Les conteneurs app, webserver et db communiquent via le réseau laravel.

Le conteneur webserver (Nginx) transmet les requêtes PHP au conteneur app via fastcgi_pass app:9000.

Le conteneur app se connecte au conteneur db via l'hôte db (nom du service) sur le port 3306.

Volumes :
Un volume nommé dbdata persiste les données MySQL dans /var/lib/mysql.

Un volume bind (.:/var/www) synchronise le code source entre l'hôte et les conteneurs app et webserver.

Dockerfile :
Construit une image basée sur php:8.2-fpm.

Installe les dépendances système (Node.js, Composer, extensions PHP).

Configure l'environnement pour exécuter une application Laravel.

Configuration Nginx :
Le fichier docker/nginx/conf.d/default.conf configure Nginx pour servir les fichiers statiques et rediriger les requêtes PHP vers le conteneur app.
