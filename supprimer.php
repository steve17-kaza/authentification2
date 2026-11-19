<?php
session_start();
require_once 'db.php';
require_once 'fonction.php';
verifierSession();
$message="";
if($_SERVER['REQUEST_METHOD']==='POST'){
    $mdp=$_POST['mdp'] ?? '';
    if(!empty($mdp)){
        $checkMdp=$pdo->prepare("SELECT * FROM information WHERE id=:id");
        $checkMdp->execute(['id'=>$_SESSION['id']]);
        $user=$checkMdp->fetch(PDO::FETCH_ASSOC);
        if($user && password_verify($mdp,$user['mdp'])){
            $supprimer=$pdo->prepare("DELETE FROM information WHERE id=:id");
            $supprimer->execute(['id'=>$_SESSION['id']]);

            $_SESSION=[];
            session_destroy();

            header('location:connexion.php');
            exit();
        }
        else{
            $_SESSION['message']="mot de passe incorrecte";
        }
    }
    else{
            $_SESSION['message']="veuillez remplir le champ";

    }
    header('location:suprimer.php');
    exit();

}
if(isset($_SESSION['message'])){
    $message=$_SESSION['message'];
    unset($_SESSION['message']);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">

    <title>Supprimer</title>
</head>
<body>
<main class="carte">
    <h1>Supprimer mon compte</h1>
    <form action="supprimer.php" method="POST" onsubmit="return confirm('supprimer definitivement
    votre compte')">
        <input type="password" name="mdp" placeholder="entrer votre mdp">
        <button type="submit">Envoyer</button>
        <button type="reset">Effacer</button>
    </form>
    <p class="message">
        <?php if($message!==''){
            echo htmlspecialchars($message);
            }?>
    </p>
</main>
</body>
</html>