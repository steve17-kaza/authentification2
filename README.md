# Système d'authentification en PHP

Petit projet que j'ai fait pour apprendre comment fonctionne une connexion sur un site : inscription, connexion, session et option "Se souvenir de moi".

Fait avec PHP, MySQL, HTML et CSS.

## Captures d'écran

[Inscription](captures/inscription.png)
[Connexion](captures/connexion.png)
[Profil](captures/profil.png)

## Ce que fait le site

- Créer un compte (nom, email, mot de passe)
- Se connecter
- Rester connecté après la fermeture du navigateur (case "Se souvenir de moi")
- Changer son nom et son mot de passe
- Supprimer son compte (il faut entrer son mot de passe)
- Se déconnecter

## Sécurité

- Les mots de passe sont hachés ('password_hash'), jamais enregistrés en clair
- Les requêtes SQL sont préparées avec PDO
- Les textes affichés sont protégés avec `htmlspecialchars`
- Pour " Se souvenir de moi ", le cookie contient un sélecteur et un validateur. Seul le hash du validateur est gardé en base de données

## Installation

1. Installer XAMPP et démarrer Apache et MySQL
2. Mettre le dossier du projet dans 'C:\xampp\htdocs'
3. Dans phpMyAdmin, créer une base de données et importer le fichier 'database.sql'
4. Copier 'db.example.php' en 'db.php' et y mettre le nom de votre base
5. Ouvrir 'http://localhost/authentification2/inscription.php'

## Ce que j'ai appris

- La différence entre une session (côté serveur) et un cookie (côté navigateur)
- Le rôle de `PHPSESSID`
- Comment fonctionne un cookie « Se souvenir de moi » avec sélecteur et validateur
- Comment utiliser PDO et les requêtes préparées

## À améliorer

- Ajouter une protection CSRF
- Améliorer le design
- Limiter les tentatives de connexion

## Auteur

CHRYSTOPHER Steve
GitHub : [steve17-kaza](https://github.com/steve17-kaza)
