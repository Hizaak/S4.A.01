<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/styleCarte.css">
    <title>Création de Formulaire</title>
</head>
<body>
<iframe src="questionUpload.php" name="postkeeper" style="display:inline;"></iframe>
<form  id='formsendall' method="post">
    <input type="submit" value="Go">
</form>
</body>
</html>

<?php
include "Question.php";
include "baseDeDonnees.php";
include "outils.php";


// echo $Question1->afficher(true);
$req = $database->prepare("SELECT * FROM Question");
$req->execute();
$resultat=$req->fetchAll();
while ($resultat){
    $carte=unserialize($resultat[0]["ObjetQuestion"]);
    $carte->set_id($resultat[0]["id"]);
    echo $carte->afficher(true);
    array_shift($resultat);
}

if (isset($_SESSION['Questions'])){
    //On recupere toutes les question dans l'array
    foreach ($_SESSION['Questions'] as $question){
        //On affiche la question
        echo $question->afficher(true);
    }

}

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







//On affiche un bouton qui va générer une question


//Si le bouton ajouterQuestion est appuyé on crée une nouvelle question
if (isset($_POST["ajouterQuestion"])){
    
    //On récupère l'id de la dernière question
    $req = $database->prepare("SELECT id FROM Question ORDER BY id DESC LIMIT 1");
    $req->execute();
    $resultat=$req->fetchAll();
    $id=$resultat[0]["id"];
    $id++;
    //On crée une nouvelle question
    $carte=new Question_QCM($id,"Intitulé de la question","..\\sources\\images\\imgplaceholder.jpg",array(array("Réponse 1","#00FF00"),array("Réponse 2","#FF0000"),array("Réponse 3","#0000FF")),2);
    echo $carte->afficher(true);
    //On l'ajoute a la session
    $_SESSION['Questions'][]=$carte;


    
}




echo '<form id=addQuestion method="post">
        <input form="addQuestion" type="submit" name="ajouterQuestion" value="Ajouter une question">
    </form>';

echo '<script type="text/javascript" src="../script/carte.js"></script>';

var_dump($_POST)
?>





