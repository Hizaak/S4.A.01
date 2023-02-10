<?php
include "Question.php";
include "baseDeDonnees.php";
include "outils.php";


if(!empty($_POST)){
    print_r($_POST);


    // $rep=array();
    // $color=array();
    // $nbRepMax=1; //On met 1 par default, il sera mis a jour si on a plus
    // foreach ($_POST as $key => $value) {
    //     //on split la clé pour récupérer le nom de la carte
    //     $newkey = explode("$",$key);
    //     $id=$newkey[0];
    //     echo $newkey[1]." : ".$value."<br>";
    //     if ($newkey[1]=="editName"){
    //         $intitule=$value;
    //     }
    //     if ($newkey[1]=="editNbRepMax"){
    //         $nbRepMax=$value;
    //     }
    //     //on recupere que les 7 premiers caractères de la clé pour savoir si c'est une réponse
    //     if (substr($newkey[1],0,7)=="editRep"){
    //         $rep[]=$value;
    //     }        
    //     if (substr($newkey[1],0,7)=="editCol"){
    //         $color[]=$value;
    //     }        
    // }
    // $id=(int)substr($id,5);
    // //on converti id en int
    // echo $id;

    // //On créer un nouvel arrey toute les 2 valeurs
    // //On regarde si le tableau color est vide si oui on met des couleurs par défaut (dans le cas d'une carte checkbox) par compatibilité avec les boutons
    // if (empty($color)){
    //     $color=array_fill(0,count($rep),"#000000");
    // }

    
    // //On crée un tableau a deux dimensions
    // $reponses=array();
    // for ($i=0;$i<count($rep);$i++){
    //     $reponses[]=array($rep[$i],$color[$i]);
    // }
    // //On affiche les différence entre les deux tableaux
    // //On crée la carte
    // $fileDestination = '../sources/images/imgplaceholder.jpg';
    // if (count($reponses)>1){ //Si on a plus de 1 réponse ce n'est pas une question libre
    //     //On crée une carte binaire
    //     $carte=new Question_QCM($id,$intitule,$fileDestination,$reponses,$nbRepMax);
    // }
    // else{
    //     echo "Question libre";
    // }



    // //On la serialize et base64_encode
    // $carte=serialize($carte);
    // //On ecrit dans la base de données;
    // $type="QCM";
    // $visibility="all";
    // try{
    //     //$req = $database->prepare("INSERT INTO Question VALUES (?, ?, 1, ?, ?)");
    //     //$resultat=$req->execute(array($id,$carte,$visibility,$type));
    // }
    // catch (Exception $e){
    //     //Si le code d'erreur est 23000 c'est que la carte existe déjà donc on la met a jour
    //     if ($e->getCode()==23000){
    //         try{
    //             //On replace tout les attributs de la carte
    //             $req = $database->prepare("UPDATE Question SET id=?, ObjetQuestion=?, idFormulaire=1, voirPar=?, typeQuestion=? WHERE id=".$id);
    //             $resultat=$req->execute(array($id,$carte,$visibility,$type));
    //         }
    //         catch (Exception $e){
    //             echo "Erreur : ".$e->getMessage();
    //         }
    //     }
    //     else{
    //         echo "Erreur : ".$e->getMessage();
    //     }

    // }
    // //On redirige vers la page de création de formulaire
    // header("Location: ../php/creationFormulaire.php");
}
