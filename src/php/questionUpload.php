<?php
include "Question.php";
include "baseDeDonnees.php";
include "outils.php";


if(!empty($_POST)){
    $rep=array();
    $color=array();
    $nbRepMax=1; //On met 1 par default, il sera mis a jour si on a plus
    //On fait un sorte de recuperer que le ce qu'il y a entre carte et sep dans $_POST['id']
    //On recupere les informations relatives a toutes les cartes
    $id=substr($_POST['id'],5,strpos($_POST['id'],"sep")-5);
    $type=$_POST['type'];
    $intitule=$_POST['intitule'];
    $image=$_POST['image'];
    $limit=$_POST['limit'];
    $visibilite=$_POST['visibilite'];
    //On converti la visibilite en quelque chose que la base de données peut comprendre
    // Si c'est 'parrain' alors ca vaut 2, si c'est 'filleul' alors ca vaut 1, si c'est 'tous' alors ca vaut all
    if ($visibilite=="parrain"){$visibilite=2;}
    else if ($visibilite=="filleul"){$visibilite=1;}
    else{$visibilite="all";}
    if ($type=="QCM"){
        //On recupere les informations relatives a toutes les cartes
        $propositions=$_POST['proposition'];
        // print_r($propositions);
        //Dans l'array $propositions on a les réponses et les couleurs
        //on print les clés et les valeurs
        //On recupere la longueur de l'array
        $nbProp=count($propositions);
        $reponses=array();
        for ($i=0;$i<$nbProp;$i++){
            $reponse=[$propositions['Rep'.$i]['text'],$propositions['Rep'.$i]['color']];
            $reponses[]=$reponse;
        }
    }
    
    //Nous allons maintenant traiter l'image si elle est présente
    if ($image){
        //On recupere le base64 de l'image et on la met dans un fichier dans /sources/images
        //mais avant ca on doit enlever le préfixe data:image/png;base64,
        $image=substr($image,22);
        $image=base64_decode($image);

        //On utilise l'id de la carte pour le nom du fichier
        $fileDestination = '../sources/images/question'.$id.'.png';
        imagepng(imagecreatefromstring($image),$fileDestination); //On ecrit dans le fichier



        //On ecrit dans le fichier
    }
    else{
        //On reprend celui d'avant
        $req=$database->prepare("SELECT IMAGE FROM question WHERE ID=:id");
        $req->execute(array(
            'id'=>$id
        ));
        $resultat=$req->fetch();
        $fileDestination=$resultat['IMAGE'];
    }
    //On peut integrer ca a la base de données 
    try{
        $req=$database->prepare("SELECT id FROM question WHERE ID=:id");
        $req->execute(array(
            'id'=>$id
        ));
        $resultat=$req->fetch();
        if($type=="QCM"){
                //Si la question existe deja on la met a jour
                if($resultat){
                    //On met a jour la question
                    $req=$database->prepare("UPDATE question SET INTITULE=:INTITULE, IMAGE=:IMAGE, VISIBILITE=:VISIBILITE, TYPEQUESTION=:TYPEQUESTION, NBREPONSE=:NBREPONSE WHERE ID=:ID");
                    $req->execute(array(
                        'ID'=>$id,
                        'INTITULE'=>$intitule,
                        'IMAGE'=>$fileDestination,
                        'VISIBILITE'=>$visibilite,
                        'TYPEQUESTION'=>$type,
                        'NBREPONSE'=>$limit,
                    ));
                }
                else{
                    //On insere la question
                    $req=$database->prepare("INSERT INTO question (ID, ID_FORMULAIRE, INTITULE, IMAGE, VISIBILITE, TYPEQUESTION, NBREPONSE) VALUES (:ID,1,:INTITULE, :IMAGE, :VISIBILITE, :TYPEQUESTION, :NBREPONSE)");
                    $req->execute(array(
                        'ID'=>$id,
                        'INTITULE'=>$intitule,
                        'IMAGE'=>$fileDestination,
                        'VISIBILITE'=>$visibilite,
                        'TYPEQUESTION'=>$type,
                        'NBREPONSE'=>$limit,
                    ));

                }
                //Pour eviter les doublons on supprime les reponses de la question
                //On regarde si y a des changement avant de supprimer
                $req=$database->prepare("SELECT * FROM proposition WHERE ID_QUESTION=:ID_QUESTION");
                $req->execute(array(
                    'ID_QUESTION'=>$id
                ));
                $resultat=$req->fetchAll();
                $nbProp=count($resultat);
                $nbPropNew=count($reponses);
                $change=false;
                if ($nbProp==$nbPropNew){
                    for ($i=0;$i<$nbProp;$i++){
                        if ($resultat[$i]['TEXTE']!=$reponses[$i][0] || $resultat[$i]['COULEUR']!=$reponses[$i][1]){
                            $change=true;
                        }
                    }
                }
                else{
                    $change=true;
                }
                if($change){
                    $req=$database->prepare("DELETE FROM proposition WHERE ID_QUESTION=:ID_QUESTION");
                    $req->execute(array(
                        'ID_QUESTION'=>$id
                    ));
                    //On insere les reponses
                    for ($i=0;$i<$nbPropNew;$i++){
                        $req=$database->prepare("INSERT INTO proposition (ID_QUESTION, TEXTE, COULEUR) VALUES (:ID_QUESTION, :REPONSE, :COULEUR)");
                        $req->execute(array(
                            'ID_QUESTION'=>$id,
                            'REPONSE'=>$reponses[$i][0],
                            'COULEUR'=>$reponses[$i][1]
                        ));
                    }
            }
            }
        else{
            //Si la question existe deja on la met a jour
            if($resultat){
                //On met a jour la question
                $req=$database->prepare("UPDATE question SET INTITULE=:INTITULE, IMAGE=:IMAGE, VISIBILITE=:VISIBILITE, TYPEQUESTION=:TYPEQUESTION,NBCARACTEREMAX=:NBCARACTEREMAX WHERE ID=:ID");
                $req->execute(array(
                    'ID'=>$id,
                    'INTITULE'=>$intitule,
                    'IMAGE'=>$fileDestination,
                    'VISIBILITE'=>$visibilite,
                    'TYPEQUESTION'=>$type,
                    'NBCARACTEREMAX'=>$limit,
                ));
            }
            else{
                //On insere la question
                $req=$database->prepare("INSERT INTO question (ID, ID_FORMULAIRE, INTITULE, IMAGE, VISIBILITE, TYPEQUESTION, NBCARACTEREMAX) VALUES (:ID,1,:INTITULE, :IMAGE, :VISIBILITE, :TYPEQUESTION, :NBCARACTEREMAX)");
                $req->execute(array(
                    'ID'=>$id,
                    'INTITULE'=>$intitule,
                    'IMAGE'=>$fileDestination,
                    'VISIBILITE'=>$visibilite,
                    'TYPEQUESTION'=>$type,
                    'NBCARACTEREMAX'=>$limit,
                ));
            }
        }        
    }    
    catch(Exception $e){
        die('Erreur : '.$e->getMessage());
    }
}
