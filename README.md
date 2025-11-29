# Boutique Z-H

Boutique Z-H est une application web e-commerce dédiée à la vente de livres en ligne. Elle offre une interface pour les clients afin de parcourir, rechercher et acheter des livres, ainsi qu'un panneau d'administration complet pour gérer le catalogue et les commandes.

## Fonctionnalités

### Partie Client
- **Catalogue** : Parcourir les livres par catégories, auteurs ou via une recherche globale.
- **Recherche et Filtres** : Rechercher des livres par titre, auteur ou catégorie. Filtrer par prix, année de publication, nombre de pages, langue, etc.
- **Panier** : Ajouter des livres au panier, modifier les quantités et supprimer des articles.
- **Commande** : Passer commande une fois authentifié.
- **Espace Client** : Consulter l'historique des commandes et gérer son profil.
- **Authentification** : Inscription et connexion sécurisées.

### Partie Administration
- **Tableau de Bord** : Vue d'ensemble des statistiques (total commandes, chiffre d'affaires, état des commandes).
- **Gestion du Catalogue** : Ajouter, modifier et supprimer des livres, des catégories et des auteurs.
- **Gestion des Commandes** : Suivre et mettre à jour l'état des commandes (En attente, En cours, Terminée, etc.).
- **Gestion des Clients** : Visualiser la liste des clients inscrits.

## Technologies Utilisées

- **Backend** : PHP 7/8
- **Base de Données** : MySQL
- **Frontend** : HTML5, CSS3, JavaScript (jQuery)
- **Framework CSS** : Bootstrap 5
- **Icônes** : Font Awesome

## Installation

1.  **Cloner le projet** ou télécharger les fichiers sources.
    ```bash
    git clone https://github.com/BENCHEKROUN-Zineb/boutique_livres_php.git
    ```
2.  **Placer le projet** dans le répertoire racine de votre serveur web (ex: `htdocs` pour XAMPP ou `www` pour WAMP).
3.  **Base de Données** :
    - Créer une base de données nommée `boutique` dans phpMyAdmin ou MySQL.
    - Importer le fichier SQL de la base de données ou créer les tables nécessaires (`utilisateur`, `produit`, `categorie`, `auteur`, `panier`, `commande`, etc.).
4.  **Configuration** :
    - Vérifier les paramètres de connexion à la base de données dans `include/connexion.php`.
    ```php
    $pdo = new PDO('mysql:host=localhost;dbname=boutique', 'root', '');
    ```

## Utilisation

1.  Lancer votre serveur web (Apache/MySQL).
2.  Accéder à l'application via votre navigateur :
    - **Client** : `http://localhost/boutique_livres_php/index.php`
    - **Admin** : `http://localhost/boutique_livres_php/Admin/indexAdmin.php`

## Structure du Projet

- `Admin/` : Scripts et pages de l'interface administrateur.
- `assets/` : Ressources statiques (polices, icônes).
- `auth/` : Scripts d'authentification (login, signup, logout).
- `catalogue/` : Pages d'affichage des produits.
- `client/` : Espace client (dashboard, commandes).
- `css/` : Feuilles de style CSS.
- `img/` & `uploads/` : Images du site et des produits.
- `include/` : Fichiers inclus (connexion DB, navbar, footer).
- `js/` : Scripts JavaScript.
- `panier/` : Gestion du panier d'achat.

## Auteurs

- **BENCHEKROUN Zineb** - *Développement initial*
