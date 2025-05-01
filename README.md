# Application Symfony - Gestion de Panier (E-commerce)

Ce projet est une mini-application e-commerce développée avec **Symfony**. Il permet d'afficher une liste de produits, d'ajouter des produits à un panier, de les supprimer et d'afficher le total.

## Fonctionnalités

- 📦 Liste des produits avec nom, image et prix.
- 🛒 Ajout de produits au panier via la session.
- 🧮 Calcul du total du panier.
- 🗑️ Suppression de produits du panier.
- 🖼️ Affichage des images depuis le dossier `public/uploads/images`.

## Technologies utilisées

- PHP 8.x
- Symfony 6.x
- MySQL
- Doctrine ORM
- Twig
- HTML/CSS (Bootstrap)
- Session Symfony

## Installation

1. Clonez le dépôt :
```bash
git clone https://votre-url-depot.git
cd nom-du-projet
```

2. Installez les dépendances :
```bash
composer install
```

3. Créez la base de données :
```bash
php bin/console doctrine:database:create
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```

4. Chargez les données si vous avez des fixtures :
```bash
php bin/console doctrine:fixtures:load
```

5. Lancez le serveur de développement :
```bash
symfony server:start
```

6. Accédez à l'application :
```
http://localhost:8000/
```

## Structure du projet

- `src/Entity/Produit.php` : Entité produit (nom, prix, image...)
- `src/Controller/CartController.php` : Contrôleur pour gérer le panier
- `src/Controller/ProduitController.php` : Contrôleur pour afficher les produits
- `templates/produit/index.html.twig` : Vue liste des produits
- `templates/cart/index.html.twig` : Vue panier

## Exemple de fonctionnement

- Cliquez sur **Acheter** pour ajouter un produit au panier
- Le panier s'affiche automatiquement après chaque ajout
- Vous pouvez supprimer un produit depuis la page du panier

## Auteur

Ce projet a été réalisé dans le cadre d'un apprentissage Symfony.

---

© 2025 - Projet E-commerce Symfony
