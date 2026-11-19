<?php
session_start();
require_once 'db.php';
require_once 'fonction.php';
verifierSession();
$message="";
if($_SERVER['REQUEST_METHOD']==='POST'){
    $actuelMdp=$_POST['actuelMdp'];
    $nouveauMdp=$_POST['nouveauMdp'];
    $confirmerMdp=$_POST['confirmerMdp'];
    if(!empty($actuelMdp) && !empty($nouveauMdp) && !empty($confirmerMdp)){
        $checkMdp=$pdo->prepare("SELECT * FROM information WHERE id=?");
        $checkMdp->execute([$_SESSION['id']]);
        $user=$checkMdp->fetch(PDO::FETCH_ASSOC);
        if($user && password_verify($actuelMdp,$user['mdp']) && $nouveauMdp===$confirmerMdp && strlen($nouveauMdp)>=8){

            $hacheMdp=password_hash($nouveauMdp,PASSWORD_DEFAULT);
            $insererMdp=$pdo->prepare("UPDATE information SET mdp=? WHERE id=? ");
            $insererMdp->execute([$hacheMdp,$_SESSION['id']]);

            header('location:profil.php');
            exit();
        }
        else
            {
                $_SESSION['message']="Mot de passe incorrecte";
            }
    }else
    {
                $_SESSION['message']="Veuillez remplir les champs";
   
    }
    header('location:changerMdp.php');
    exit();

}
if(!empty($_SESSION['message'])){
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

    <title>changerMdp</title>
</head>
<body>
    <main>
        <h1>Changer de mot de passe</h1>
    <form action="changerMdp.php" method="POST">
        <input type="password" name="actuelMdp" placeholder="Entrer votre mdp actuel">
        <input type="password" name="nouveauMdp" placeholder="Entrer votre nouveau mdp">    
        <input type="password" name="confirmerMdp" placeholder="confirmer le nouveau mdp">
        <button type="submit">Confirmer</button>
        <button type="reset">Supprimer</button>
    </form>
    <p class="message"><?php    
    if ($message!=='')
    {echo htmlspecialchars($message);
    }
?></p>
    </main>
</body>
</html>