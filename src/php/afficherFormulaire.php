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
$ListeQuestion = $req->fetchAll();

//Si on un un get ?modify on fait pas cette partie
if(!isset($_GET['modify']) || $_GET['modify']!="1"){
    //On récupère les questions que l'utilisateur a déjà répondu et on les supprime de la liste dans la table repondreQCM et repondreLibre
    $req=$database->prepare("SELECT ID_QUESTION FROM repondreQCM WHERE LOGIN=:LEFTlogin UNION SELECT ID_QUESTION FROM repondreLibre WHERE LOGIN=:RIGHTlogin");
    $req->execute(array("LEFTlogin"=>$_SESSION['user']->getLogin(),"RIGHTlogin"=>$_SESSION['user']->getLogin()));
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
    if(empty($ListeQuestion)){
        header('Location:../index.php');
        exit();
    }
}
else{
    //L'utilisateur veut modifier ses réponses
    echo "<h1 style='text-align:center'>Vous pouvez modifier vos réponses</h1>";
    $req=$database->prepare("SELECT repondreQCM.ID_QUESTION,TEXTE FROM repondreQCM JOIN proposition ON repondreQCM.ID_PROP=proposition.ID WHERE repondreQCM.LOGIN=:LEFTlogin UNION SELECT repondreLibre.ID_QUESTION,repondreLibre.REPONSE FROM repondreLibre WHERE repondreLibre.LOGIN=:RIGHTlogin ORDER BY ID_QUESTION");
    $req->execute(array("LEFTlogin"=>$_SESSION['user']->getLogin(),"RIGHTlogin"=>$_SESSION['user']->getLogin()));
    //On fait un array avec comme clé l'id de la question et comme valeur l'array des réponses
    $ListeReponse = array();
    while($reponse = $req->fetch()){
        $ListeReponse[$reponse["ID_QUESTION"]][] = $reponse["TEXTE"];
    }
    //On remplace les clés par la position de la question dans la liste
    $ListeReponse = array_values($ListeReponse);
    
    //On injecte ca dans le js
    echo "<script>var ListeReponse =".json_encode($ListeReponse).";</script>";
}
//Si la liste est vide, on redirige vers la page d'accueil et on notifie l'utilisateur


//On fait un array qui contient le html de chaque question pour le donner au javascript
$ListeQuestionHTML = array();
foreach($ListeQuestion as $question){
    $ListeQuestionHTML[] = ReprQuestion::get_instance(Question::db_get($database, $question["ID"]))->get_html();
}
echo "<script>var ListeQuestionHTML =".json_encode($ListeQuestionHTML).";</script>";

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/styleCarteEtudiant.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="../sources/icons/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../sources/icons/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../sources/icons/favicon/favicon-16x16.png">
    
    <title>Formulaire</title>
</head>
<body>
    <!-- On place la divb -->
    <div id='carteActuelle'>
    </div>
</body>
</html>
<script src="../script/formulaire.js"></script>


