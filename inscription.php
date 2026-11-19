<?php
session_start();
require_once 'db.php';
$message="";

if($_SERVER['REQUEST_METHOD']==='POST'){
    if(!empty($_POST['nom']) && !empty($_POST['email']) && !empty($_POST['mdp'])){
        $nom=trim($_POST['nom'] ?? '');
        $email=trim($_POST['email'] ?? '');
        $mdp=$_POST['mdp'] ?? '' ;
        if (strlen($mdp)<8){
            $_SESSION['message']="le mdp doit au moins comporter 8 caracteres";
        }
        elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $_SESSION['message']="email non validé";
        } 
        else{
            $checkMail=$pdo->prepare("SELECT * FROM information WHERE email=?");
            $checkMail->execute([$email]);
            $utilisateur=$checkMail->fetch(PDO::FETCH_ASSOC);
            if($checkMail->rowCount()>0){
                $_SESSION['message']="email existant";
            }
            else{
            $hacheMdp=password_hash($mdp,PASSWORD_DEFAULT);
            $stmt=$pdo->prepare("INSERT INTO information (nom,email,mdp) VALUES (?,?,?)");
            $stmt->execute([$nom,$email,$hacheMdp]);   
            $_SESSION['id']=$pdo->lastInsertId();
            $_SESSION['nom']=$nom;
            $_SESSION['email']=$email;

            
            header('location:profil.php');
            exit(); 
            }
        }
        
    }
    else{
    $_SESSION['message']="veuillez remplir les champs";
        }
 header('location:inscription.php');
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
    <title>Inscritpion</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <main class="carte">
        <h1>Inscription</h1>
        <form action="inscription.php" method="POST">
            <input type="text" name="nom" placeholder="Entrer votre nom ">
            <input type="email" name="email" placeholder="Entrer votre email ">
            <input type="password" name="mdp" placeholder="Entrer votre mdp ">
            <button type="submit">Envoyer</button>
            <button type="reset">Effacer</button>

        </form>
        <p class="message"><?php    
        if ($message!=='')
            {echo htmlspecialchars($message);
        }
        ?></p>
        <p><a href="connexion.php">se connecter</a></p>

    </main>
</body>
</html>