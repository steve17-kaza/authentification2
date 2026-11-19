<?php
session_start();
require_once 'db.php';
require_once 'fonction.php';
verifierSession();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">

    <title>Profil</title>
</head>
<body>
    <main class="carte">
        <h1>Mon profil</h1>
    <p class="bienvenue"><?php echo "Bienvenu sur votre compte:".htmlspecialchars($_SESSION['nom'])?></p>
    <nav class="actions">
        <a class="lien-bouton" href="deconnexion.php">se deconnecter</a>
        <a class="lien-bouton" href="changerNom.php">changer de nom</a>
        <a class="lien-bouton secondaire" href="changerMdp.php">changer de mdp</a>
        <a class="lien-bouton danger" href="supprimer.php">supprimer mon compte</a>
    </nav>
</main>

</body>
</html>