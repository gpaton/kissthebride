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

## TESTS

Pour lancer les tests, commencer par créer la base de données de test :

    php bin/console --env=test doctrine:database:create
    php bin/console --env=test doctrine:schema:create
    php bin/console --env=test doctrine:fixtures:load --group=test

Exécuter les tests :

    php bin/phpunit

## POSTMAN

A la racine du projet, le fichier `postman_collection.json` contient la liste des routes avec des exemples pour utiliser l'API.

## AUTHENTIFICATION

Une méthode simple d'authentification aurait consisté à utiliser le [JSON Login](https://symfony.com/doc/current/security.html#json-login) fourni par Symfony qui permet d'authentifier l'utilisateur via un JSON envoyé en POST.
L'authentification renverrait ainsi un token identifiant l'utilisateur pour les prochains appels à l'API.

Pour améliorer la sécurité, la mise en place d'appels Stateless à l'API permettrait d'éviter des attaques par rejeu.

La mise en place de l'authentification permettrait aussi d'éviter l'utilisation de l'identifiant utilisateur dans les routes de l'API.