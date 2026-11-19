<?php
session_start();
require_once 'db.php';
if(!empty($_COOKIE['se_souvenir'])){
    [$selecteur]=explode(':', $_COOKIE['se_souvenir']);
    $stmt=$pdo->prepare("DELETE FROM jetons_connexion WHERE selecteur=?");
    $stmt->execute([$selecteur]);
    setcookie('se_souvenir','', time() - 3600, '/');
    }

$_SESSION=[];
session_destroy();
header('location:connexion.php');
exit();