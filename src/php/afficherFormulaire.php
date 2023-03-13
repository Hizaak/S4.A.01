<?php
include_once 'Utilisateur.php';
include_once 'question.php';
include_once 'genereHTMLQuestion.php';
include_once 'baseDeDonnees.php';

//L'utilisateur doit être connecté et ne doit pas être un admin
if(!isset($_SESSION['user']) || $_SESSION['user']->estAdmin()){
    header('Location:../index.php');
}


//On recherche toutes les Question que l'utilisateur n'a pas encore répondu
//On récupère les questions que l'utilisateur peut voir (donc avec un VISIBILITE de (all ou le niveau de l'utilisateur))
//faut faire un select imbriqué
//On récupère les questions
$req=$database->prepare("SELECT ID FROM question WHERE VISIBILITE='all' OR VISIBILITE IN (SELECT NIVEAU FROM utilisateur WHERE LOGIN=:login)");
$req->execute(array("login"=>$_SESSION['user']->getLogin()));
//On récupère les questions
$ListeQuestion = $req->fetchAll();

//On récupère les questions que l'utilisateur a déjà répondu et on les supprime de la liste dans la table repondreQCM et repondreLibre
$req=$database->prepare("SELECT ID_QUESTION FROM repondreQCM UNION SELECT ID_QUESTION FROM repondreLibre WHERE LOGIN=:login");
$req->execute(array("login"=>$_SESSION['user']->getLogin()));
//On récupère les questions
$ListeQuestionDejaRepondu = $req->fetchAll();
//On parcourt les questions déjà répondu
foreach($ListeQuestionDejaRepondu as $question){
    //On parcourt les questions
    foreach($ListeQuestion as $key=>$question2){
        //Si la question est la même
        if($question["ID_QUESTION"]==$question2["ID"]){
            //On supprime la question de la liste
            unset($ListeQuestion[$key]);
        }
    }
}
//Si la liste est vide, on redirige vers la page d'accueil et on notifie l'utilisateur
if(empty($ListeQuestion)){
    header('Location:../index.php');
    exit();
}

//On fait un array qui contient le html de chaque question pour le donner au javascript
$ListeQuestionHTML = array();
foreach($ListeQuestion as $question){
    $ListeQuestionHTML[] = ReprQuestion::get_instance(Question::db_get($database, $question["ID"]))->get_html();
}
echo "<script>var ListeQuestionHTML =".json_encode($ListeQuestionHTML).";</script>";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/styleCarte.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
    <title>Formulaire</title>
</head>
<body>
    <!-- On place la divb -->
    <div id='carteActuelle'>
    </div>
</body>
</html>
<script src="../script/formulaire.js"></script>


