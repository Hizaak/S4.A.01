
<?php

require_once "Associer.php";
require_once "ReponseQCM.php";
require_once "ReponseLibre.php";
require_once "Etudiant.php";
require_once "Main.php";

function separerEtud(&$listEtud,&$listPremAn,&$listSecAn){
    for ($i = 0; $i < count($listEtud); $i++) {
        if ($listEtud[$i]->getNiveau() == 1) {
            $listPremAn[] = $listEtud[$i];
        } else {
            $listSecAn[] = $listEtud[$i];
        }
    }

}

function calculerDistanceReponses($repPremAn,$repSecAn){
    $nbRepPremAn=count($repPremAn);
    //on creer un nouvel array avec  tout les elements sauf le dernier des deuxieme annee
    $nbRepSecAn=count($repSecAn); 
    $DEUXversUN = 0;
    for($i = 0; $i < $nbRepSecAn; $i++){
        // Si la réponse de l'étudiant de 2ème année est dans la liste des réponses de l'étudiant de 1ère année
        if(in_array($repSecAn[$i], $repPremAn)){
            //on echo le debug
            //print_r("La réponse ".$repSecAn[$i][0]." de l'étudiant de 2ème année est dans la liste des réponses de l'étudiant de 1ère année<br>");
            $DEUXversUN += 1;
        }
    }
    
    $UNversDEUX = 0;
    for($i = 0; $i < $nbRepPremAn; $i++){
        // Si la réponse de l'étudiant de 1ère année est dans la liste des réponses de l'étudiant de 2ème année
        if(in_array($repPremAn[$i], $repSecAn)){
            //on echo le debug
            //print_r("La réponse ".$repPremAn[$i][0]." de l'étudiant de 1ère année est dans la liste des réponses de l'étudiant de 2ème année<br>");
            $UNversDEUX += 1;
        }
    }
    return (($UNversDEUX/$nbRepPremAn)*($DEUXversUN/$nbRepSecAn));

}

?>