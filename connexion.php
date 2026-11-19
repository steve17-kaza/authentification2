<?php
session_start();
require_once 'db.php';
require_once 'fonction.php';
connexionAuto($pdo);
if(isset($_SESSION['id'])){
    header('location:profil.php');
    exit();
}

$message="";
if($_SERVER['REQUEST_METHOD']==='POST'){
    $email=trim($_POST['email'] ?? '');
    $mdp=$_POST['mdp'] ?? ''; 
    if(!empty($email) && !empty($mdp)){
        $checkMdp=$pdo->prepare("SELECT * FROM information WHERE email=?");
        $checkMdp->execute([$email]);
        $user=$checkMdp->fetch(PDO::FETCH_ASSOC);
        if($user && password_verify($mdp, $user['mdp'])){
            $_SESSION['id']=$user['id'];
            $_SESSION['nom']=$user['nom'];
            $_SESSION['email']=$user['email'];

            //se souvenir de moi
            if(!empty($_POST['souvenir'])){
                $selecteur=bin2hex(random_bytes(12));
                $validiteur=bin2hex(random_bytes(32));
                $expiration=time() + 30 * 24 * 3600;

                $stmt=$pdo->prepare("INSERT INTO jetons_connexion (utilisateur_id,selecteur,jeton_hash,
                expire_le) VALUES (?,?,?,?)");
                $stmt->execute([$user['id'],$selecteur,hash('sha256',$validiteur),
                date('Y-m-d H:i:s',$expiration)]);

                setcookie('se_souvenir', $selecteur .':'. $validiteur,[
                    'expires'=>$expiration,
                    'path'=>'/',
                    'httponly'=>true,
                    'samesite'=>'Lax',
                ]);
            }

            session_regenerate_id(true);
            header('location:profil.php');
            exit();
        }else{
            $_SESSION['message']="mot de passe ou email incorrecte";
        }
        
    }
    else{
            $_SESSION['message']="veuillez remplir les champs";
        }
        header('location:connexion.php');
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
    <title>Connexion</title>
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <main class="carte">
        <h1>Connexion</h1>
    <form action="connexion.php" method="POST">
        <input type="email" name="email" placeholder="Entrer votre email ">
        <input type="password" name="mdp" placeholder="Entrer votre mdp ">
        <label><input type="checkbox" name="souvenir">se souvenir de moi</label>
        <button type="submit">Envoyer</button>
        <button type="reset">Effacer</button>

    </form>
        <p><a href="inscription.php">s'inscrire</a></p>
<p class="message"><?php    
    if ($message!=='')
    {echo htmlspecialchars($message);
    }
?></p>

</main>
</body>
</html>