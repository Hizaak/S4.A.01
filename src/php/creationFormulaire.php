<?php
include_once "Utilisateur.php";
include_once "genereHTMLQuestion.php";
include_once "baseDeDonnees.php";
include_once "outils.php";
include_once "Question.php";
if (!empty($_POST) && isset($_POST['ajoutCarte'])) {
    $type = $_POST['ajoutCarte'];
    if ($type == "libre") {
        //($id,$name,$image,$visibilite,$nbCaractereMax)
        $question = new Question_Libre(null,"Nouvelle question libre","../sources/images/imgplaceholder.jpg","all",255);
        $question->db_save($database);
    } else if ($type == "QCM") {
        //($id,$name,$image,$visibilite,$listPropositions,$nbReponseMax)
        $req=$database->prepare("INSERT INTO question (INTITULE,IMAGE,VISIBILITE,NBREPONSE,typequestion) VALUES (:intitule,:image,:visibilite,:nbreponse,:typequestion)");
        $req->execute(array("intitule"=>"Nouvelle question QCM","image"=>"../sources/images/imgplaceholder.jpg","visibilite"=>"all","nbreponse"=>1,"typequestion"=>"QCM"));
        $id = $database->lastInsertId();
        //On recupere la question que l'on vient de creer
        $question = Question::db_get($database,$id);
        //On ajoute 2 propositions par defaut
        $question->set_listPropositions(array(array("Réponse 1","#FF0000"),array("Réponse 2","#0000FF")));
        //On insere les propositions dans la base de donnee
        $req=$database->prepare("INSERT INTO proposition (id_question,TEXTE,COULEUR) VALUES (:id_question,:texte,:couleur)");
        foreach($question->get_listPropositions() as $proposition){
            $req->execute(array("id_question"=>$id,"texte"=>$proposition[0],"couleur"=>$proposition[1]));
        }

    }
    //On retourne le code html de la question
    echo ReprQuestion::get_instance($question)->get_html(true);
    exit();
}
if (!empty($_POST) && isset($_POST['supQuestion'])) {
    //On supprime la question de la base de donnee d'id $_POST['supQuestion']

    $id = explode("$", $_POST['supQuestion'])[0];
    $id = (int)substr($id, 5);
    //On recupere la question que l'on veut supprimer pour verifier si c'est une question QCM ou Libre et supprimer les propositions si c'est le cas
    $req=$database->prepare("SELECT * FROM question WHERE id=:id");
    $req->execute(array("id"=>$id));
    $resultat=$req->fetch();
    if($resultat['TYPEQUESTION']=="QCM"){
        $req=$database->prepare("DELETE FROM proposition WHERE id_question=:id");
        $req->execute(array("id"=>$id));
    }
    $req=$database->prepare("DELETE FROM question WHERE id=:id");
    $req->execute(array("id"=>$id));
    echo "ok";
    exit();


}





?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/styleCarteAdmin.css">
    <link rel="stylesheet" href="../style/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Création de Formulaire</title>
</head>

<body>
<header>
    <p>Type d'association : </p>
    <!-- le par default c'est auto -->
    <select name="typeAssos" id="typeAssos">
        <option value="Auto">Automatique</option>
        <option value="Manuelle">Manuelle</option>
    </select>
    <p>Date d'ouverture : </p>
    <!-- Par default le 17mars 2023 a 00h00 -->
    <input type="datetime-local" value="2023-03-17T00:00"></input>
    <p>Date de fermeture : </p>
    <!-- Par default le 18 mars 2023 a 00h00 -->
    <input type="datetime-local" value="2023-03-18T00:00"></input>
</header>
<?php
if (!isset($_SESSION['user']) || !$_SESSION['user']->estAdmin()){
    header('Location:connexion.php');
}



//On recupere toutes les questions de la base de donnee
$ListeQuestion = Question::db_get_all($database);
//On affiche les questions
foreach ($ListeQuestion as $question) {
    echo ReprQuestion::get_instance($question)->get_html(true);
}
?>
<section class='fb-ajout'>
        <label for="ajoutCarte">Ajouter une question de type</label>
        <select name="ajoutCarte" id="ajoutCarte">
            <option value="libre">Libre</option>
            <option value="QCM">QCM</option>
        </select>
        <button id="ajoutCarteBouton">Ajouter</button>
    </section>
</body>
</html>
<?php
echo '<script type="text/javascript" src="../script/carteEdit.js"></script>';
?>