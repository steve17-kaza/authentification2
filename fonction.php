<?php
function verifierSession(){
global $pdo;
connexionAuto($pdo);
if(empty($_SESSION['id'])){
    header('location:connexion.php');
    exit();

}
}
function connexionAuto(PDO $pdo){
    if(isset($_SESSION['id']) || empty($_COOKIE['se_souvenir'])){
        return;
    }
    $parties=explode(':',$_COOKIE['se_souvenir']);
    if(count($parties)!==2){
        return;
    }
    [$selecteur, $validateur]=$parties;
    $stmt=$pdo->prepare("SELECT * FROM jetons_connexion WHERE selecteur=? AND expire_le > NOW()");
    $stmt->execute([$selecteur]);
    $jeton=$stmt->fetch(PDO::FETCH_ASSOC);

    if($jeton && hash_equals($jeton['jeton_hash'], hash('sha256',$validateur))){
        $req=$pdo->prepare("SELECT * FROM information WHERE id=?");
        $req->execute([$jeton['utilisateur_id']]);
        $user=$req->fetch(PDO::FETCH_ASSOC);
        if($user){
            $_SESSION['id']=$user['id'];
            $_SESSION['nom']=$user['nom'];
            $_SESSION['email']=$user['email'];

            
            session_regenerate_id(true);
            return;
        }
    }
    setcookie('se_souvenir','', time() - 3600, '/');
}
