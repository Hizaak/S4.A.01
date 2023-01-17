
<?php

require_once "Associer.php";
require_once "ReponseQCM.php";
require_once "ReponseLibre.php";
require_once "Etudiant.php";
require_once "Main.php";

function initArray(){
    global $listEtud;
    global $listPremAn;
    global $listSecAn;
    $listEtud = array();
    $listPremAn = array();
    $listSecAn = array();
}

function nbPremiereAnnee(){
    global $listEtud;
    $nbPremiereAnnee = 0;
    foreach ($listEtud as $etudiant) {
        if ($etudiant->getNiveau() == "1") {
            $nbPremiereAnnee++;
        }
    }
    return $nbPremiereAnnee;
}

function nbDeuxiemeAnnee(){
    global $listEtud;
    $nbDeuxiemeAnnee = 0;
    foreach ($listEtud as $etudiant) {
        if ($etudiant->getNiveau() == "2") {
            $nbDeuxiemeAnnee++;
        }
    }
    return $nbDeuxiemeAnnee;
}

function listerPremAn(){
    for ($i = 0; $i < nbPremiereAnnee(); $i++) {
        $listPremAn[] = new Etudiant("login", "1");
    }
}

function listerSecAn(){
    for ($i = 0; $i < nbDeuxiemeAnnee(); $i++) {
        $listSecAn[] = new Etudiant("login", "2");
    }
}

function nbQuestions(){
    global $listEtud;
    $nbQuestions = 0;
    $lstRep = $listEtud[0]->getListeReponses();
    $nbQuestions = count($lstRep);
    return $nbQuestions;
}

?>