<?php
include_once 'Utilisateur.php';
include_once 'question.php';
include_once 'baseDeDonnees.php';



//On recupere les réponses de l'utilisateur dans le POST
if (isset($_POST['reponse'])&&isset($_POST['idQuestion'])) {
    //Nous récupérons l'id de la question dans idQuestion
    $idQuestion = $_POST['idQuestion'];
    $idUtilisateur = $_SESSION['user']->getLogin();
    //Nous recupérons dans un premier temps le type de la question
    $req = $database->prepare("SELECT TYPEQUESTION FROM question WHERE ID=:idQuestion");
    $req->execute(array("idQuestion" => $idQuestion));
    $typeQuestion = $req->fetch();
    $error=[];
    if ($typeQuestion['TYPEQUESTION'] == "QCM"){
        //On recupere les propositions de la question possibles
        $req = $database->prepare("SELECT ID,TEXTE FROM proposition WHERE ID_QUESTION=:idQuestion");
        $req->execute(array("idQuestion" => $idQuestion));
        $propositions = $req->fetchAll();
        //On recupere les réponses de l'utilisateur
        $reponses = $_POST['reponse'];
        //On parcourt les réponses de l'utilisateur

        //On recupere les réponse de l'utilisateur si elles existe déjà
        $req=$database->prepare("SELECT * FROM repondreQCM WHERE ID_QUESTION=:idQuestion AND LOGIN=:Login");
        $req->execute(array("idQuestion" => $idQuestion, "Login" => $idUtilisateur));
        //Si elle existe déjà on la supprime
        if($req->fetch()){
            //On supprime la réponse précédente et on ajoute la nouvelle
            $req = $database->prepare("DELETE FROM repondreQCM WHERE ID_QUESTION=:idQuestion AND LOGIN=:Login");
            $req->execute(array("idQuestion" => $idQuestion, "Login" => $idUtilisateur));
        }
        foreach ($reponses as $reponse) {
            //On parcourt les propositions de la question
            foreach ($propositions as $proposition) {
                //Si la proposition est la bonne
                if ($proposition['TEXTE'] == $reponse) {
                    //On recupere l'id de la proposition
                    $idProposition = $proposition['ID'];
                    //On recupere l'id de l'utilisateur
                    //On ajoute la réponse dans la base de données
                    try{
                        $req = $database->prepare("INSERT INTO repondreQCM (ID_QUESTION,LOGIN, ID_PROP) VALUES (:idQuestion,:Login,:idProposition)");
                        $req->execute(array("idQuestion" => $idQuestion, "Login" => $idUtilisateur, "idProposition" => $idProposition));
                    }catch(Exception $e){
                        $error[]=$idQuestion;
                    }
                }
            }
        }
    }
    else{
        //Pour une question Libre
        //On recupere la réponse de l'utilisateur
        $reponse = $_POST['reponse'][0];
        //On ajoute la réponse dans la base de données

        try{
            $req = $database->prepare("INSERT INTO repondreLibre (ID_QUESTION,LOGIN, REPONSE) VALUES (:idQuestion,:Login, :reponse) ON DUPLICATE KEY UPDATE REPONSE = '".$reponse."'");
            $req->execute(array("idQuestion" => $idQuestion, "Login" => $idUtilisateur, "reponse" => $reponse));
        }
        catch(Exception $e){
            $error[]=$idQuestion;
        }
    }
    if (empty($error)){
        echo "ok";
    }
    else{
        echo json_encode($error);
    }
}




?>