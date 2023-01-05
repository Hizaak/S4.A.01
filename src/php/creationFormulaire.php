<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/styleCarte.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Création de Formulaire</title>
</head>
<body>
</body>
</html>

<?php
include_once "genereHTMLQuestion.php";
include_once "baseDeDonnees.php";
include_once "outils.php";

if(!empty($_POST) && !isset($_SESSION['Questions'])){
    print_r($_POST);
    $rep=array();
    $color=array();
    $nbRepMax=1; //On met 1 par default, il sera mis a jour si on a plus
    echo "<br>";
    foreach ($_POST as $key => $value) {
        //on split la clé pour récupérer le nom de la carte
        $newkey = explode("$",$key);
        $id=$newkey[0];
        echo $newkey[0].$newkey[1]." : ".$value."<br>";
        if ($newkey[1]=="editName"){
            $intitule=$value;
        }
        if ($newkey[1]=="editNbRepMax"){
            $nbRepMax=$value;
        }
        //on recupere que les 7 premiers caractères de la clé pour savoir si c'est une réponse
        if (substr($newkey[1],0,7)=="editRep"){
            $rep[]=$value;
        }        
        if (substr($newkey[1],0,7)=="editCol"){
            $color[]=$value;
        }        
    }
    $id=(int)substr($id,5);
    //on converti id en int
    echo $id;
}


//On recupere toutes les questions de la base de donnee
$ListeQuestion=Question::db_get_all($database);
//On affiche les questions
foreach ($ListeQuestion as $question) {
    echo ReprQuestion::get_instance($question)->get_html(true);
}





echo '<script type="text/javascript" src="../script/carteEdit.js"></script>';