<?php 
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