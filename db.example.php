<?php
try{
    $pdo=new PDO("mysql:host=localhost;dbname=NOM_DE_LA_BASE;charset=utf8",'UTILISATEUR','MOT_DE_PASSE');
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    echo "erreur:".$e->getMessage();
}
?>