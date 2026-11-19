<?php
session_start();
require_once 'db.php';
require_once 'fonction.php';
verifierSession();
$message="";
if($_SERVER['REQUEST_METHOD']==='POST'){
    $nouveauNom=trim($_POST['nouveauNom'] ?? '');
    if(!empty($nouveauNom)){
        $checkNom=$pdo->prepare("UPDATE information SET nom=? WHERE id=?");
        $checkNom->execute([$nouveauNom,$_SESSION['id']]);
        $user=$checkNom->fetch(PDO::FETCH_ASSOC);
        $_SESSION['nom']=$nouveauNom;

        header('location:profil.php');
        exit();
    }
    else{
        $_SESSION['message']="veuillez remplir le champ";
    }
    header('location:changerNom.php');
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

    <title>ChangerNom</title>
</head>
<body>
    <main class="carte">
        <h1>Changer de nom</h1>
    <form action="changerNom.php" method="POST">
        <input type="text" name="nouveauNom" placeholder="entrer votre nouveau nom">
        <button type="submit">Envoyer</button>
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