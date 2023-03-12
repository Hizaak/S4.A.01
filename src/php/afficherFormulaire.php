<?php
session_start();
include_once 'Etudiant.php';
include_once 'question.php';
include_once 'genereHTMLQuestion.php';
include_once 'baseDeDonnees.php';


//On recherche toutes les Question que l'utilisateur n'a pas encore répondu
//On récupère les questions que l'utilisateur peut voir (donc avec un VISIBILITE de (all ou le niveau de l'utilisateur))
//faut faire un select imbriqué
$_SESSION['login']="user";
//On récupère les questions
$req=$database->prepare("SELECT ID FROM question WHERE VISIBILITE='all' OR VISIBILITE IN (SELECT NIVEAU FROM utilisateur WHERE LOGIN=:login)");
// TODO : Changer
$req->execute(array("login"=>$_SESSION['login']));

//On récupère les questions
$ListeQuestion = $req->fetchAll();

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
    <div id='jsp'>
    </div>
</body>
</html>
<script src="../script/formulaire.js"></script>


