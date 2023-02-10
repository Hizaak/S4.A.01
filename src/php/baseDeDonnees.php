<?php
    if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
        //on redirige vers la page d'accueil
        header('Location:accueil.php');
    }
    //connexion à la base
    global $database;
    // $db_servername = "placali.fr";
    // $db_username = "hegolagunak";
    // $db_password = "x4GmS1pu2E9ChYjO4o1W";
    // $db_name = "hegolagunak";
    $db_servername="localhost";
    $db_username="hegolagunak";
    $db_password="S4.01hegolagunak";
    $db_name="hegolagunak";
    try
    {
        $database = new PDO('mysql:host='.$db_servername.';dbname='.$db_name.';charset=utf8', ''.$db_username.'', ''.$db_password.'');
        $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $database->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        //$database = new mysqli($db_servername,$db_username,$db_password,$db_name);

    }
    catch (Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }

?>