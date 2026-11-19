# proxiGo

Projet Technologies Web 2A (PHP MVC).

## Installation
1. Installer XAMPP, demarrer Apache et MySQL.
2. Cloner le repo dans C:\xampp\htdocs\ :
   git clone https://github.com/malek-abidiEsp/proxiGo.git
3. Dans phpMyAdmin, onglet Importer, choisir database.sql
   (cree la base "session" et la table "users").
4. Ouvrir http://localhost/proxiGo/index.php?action=register
5. Pour creer un admin : modifier la colonne "role" en "admin" dans phpMyAdmin.

## Travail en equipe
- Ne jamais pousser directement sur "main".
- Une branche par fonctionnalite : feature/nom-de-la-tache
- Pull Request + une relecture avant le merge.