<?php 
// On se connecte à la base de données

//Si on peut ping lakartxela.fr alors
// try{
//     fsockopen("lakartxela.iutbayonne.univ-pau.fr", 80, $errno, $errstr, 30) ;


// }
// catch (Exception $e){
    //     $host="localhost";
    // }
    

//$host="lakartxela.iutbayonne.univ-pau.fr";
$host="localhost";
$user="ndargazan001_bd";
$password="ndargazan001_bd";
$database="ndargazan001_bd";

try{
    $bdd = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $user, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

catch(PDOException $e){
    echo "Erreur : " . $e->getMessage();
}





?>