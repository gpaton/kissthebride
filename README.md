# TEST TECHNIQUE KISS THE BRIDE

## STACK TECHNIQUE

- [PHP](https://www.php.net/) 8.2.7
- [MariaDB](https://mariadb.org/) 10.11.4
- [Framework Symfony](https://symfony.com/) 6.3.0
- [GitHub](https://github.com/)

## INSTALLATION

### PRE-REQUIS

1. Docker & Docker-compose sont installés
2. Le port 80 est disponible
3. Cloner le repository du test technique : https://github.com/gpaton/ktb

### DOCKER

Une fois le repository cloné sur la machine, à la racine du projet, exécuter la commande suivante qui construira les images et lancera les containers :

    docker-compose up -d

Une fois les containers en route, se connecter au service `ktb.server` :

    docker exec -ti ktb.server bash

### BASE DE DONNEES

Une fois connecté au service `ktb.server`, créer la structure de la base de données :

    php bin/console doctrine:migrations:migrate

Ajouter un utilisateur :

    php bin/console doctrine:fixtures:load --group=user --no-interaction

Le projet est prêt à l'emploi et disponible à l'URL [http://localhost](http://localhost)
