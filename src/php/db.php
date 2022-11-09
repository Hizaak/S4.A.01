<?php
    //connexion à la base
    global $database;
    $db_servername = "placali.fr";
    $db_username = "hegolagunak";
    $db_password = "398cve0AmLNLUFXY";
    $db_name = "hegolagunak";
    try
    {
        $database = new PDO('mysql:host='.$db_servername.';dbname='.$db_name.';charset=utf8', ''.$db_username.'', ''.$db_password.'');
    }
    catch (Exception $e)
    {
        die('Erreur : ' . $e->getMessage());
    }

    //on creer une fonction qui vérifie les données
    function verif($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        //on verifie que les données ne soit pas null
        return $data;
    }
?>