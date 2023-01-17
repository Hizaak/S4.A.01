
<?php

require "Associer.php";
require "ReponseQCM.php";
require "ReponseLibre.php";
require "Etudiant.php";
require "Main.php";

$listEtud = array();
$listPremAn = array();
$listSecAn = array();

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
    foreach ($listEtud as $etudiant) {
        $nbQuestions += count($etudiant->getListeReponses());
    }
    return $nbQuestions;
}

?>