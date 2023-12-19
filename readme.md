# README pour le Projet Éditeur de CV en Ligne

## Description

Ce projet est un éditeur de CV en ligne, conçu pour offrir une interface facile à utiliser pour la création et la gestion de CVs. Une caractéristique clé de ce système est sa capacité à stocker les données dans une base de données, permettant ainsi aux utilisateurs de récupérer et de modifier leurs informations à tout moment.

## Fonctionnalités

- **Édition en Ligne de CVs** : Permet aux utilisateurs de créer et de modifier leurs CVs en ligne.
- **Stockage des Données** : Les informations du CV sont enregistrées dans une base de données pour un accès et une modification faciles.
- **Accessibilité** : Les données peuvent être récupérées à tout moment, garantissant une mise à jour facile du CV.

## Prérequis

Pour utiliser cette application, vous devez avoir Docker installé sur votre machine.

## Installation et Démarrage

1. **Installation de Docker** : Assurez-vous que Docker est installé et en cours d'exécution sur votre machine.

2. **Clonage du Projet** : Clonez le dépôt du projet sur votre machine locale.

3. **Démarrage avec Docker Compose** :
    - Ouvrez un terminal.
    - Naviguez jusqu'au dossier du projet cloné.
    - Exécutez la commande suivante pour démarrer l'application via Docker Compose :
      ```
      docker-compose up
      ```

4. **Accès à l'Application** :
    - Ouvrez un navigateur web.
    - Accédez à `http://localhost` pour utiliser l'éditeur de CV.

## Configuration de la Base de Données

- Par défaut, le projet inclut une fonctionnalité de population de la base de données pour la démonstration.
- Pour désactiver cette fonctionnalité, commentez ou retirez la ligne suivante du fichier `docker-compose.yml` : `./populate.sql:/docker-entrypoint-initdb.d/populate.sql`


## Utilisation

Après avoir lancé l'application, vous pouvez créer, visualiser, et modifier vos CVs directement depuis votre navigateur en accédant à `http://localhost`.
