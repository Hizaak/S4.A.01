<?php

require_once "Main.php";

function afficherMatrice($matrice, $listPremAn, $listSecAn, $nbFilleuls, $nbParrains) {
    echo "<table>";
    echo "<tr>";
    echo "<td></td>";
    for ($i = 0; $i < $nbParrains; $i++) {
        echo "<td>".$listSecAn[$i]->getLogin()."</td>";
    }
    echo "</tr>";
    for ($i = 0; $i < $nbFilleuls; $i++) {
        echo "<tr>";
        echo "<td>".$listPremAn[$i]->getLogin()."</td>";
        for ($j = 0; $j < $nbParrains; $j++) {
            echo "<td>".$matrice[$i][$j]."</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}

function afficherReponses($listEtud) {
    for ($i = 0; $i < count($listEtud); $i++) {
        echo "Etudiant : ".$listEtud[$i]->getLogin()."<br>";
        for ($j = 0; $j < count($listEtud[$i]->getListeReponses()); $j++) {
            echo $listEtud[$i]->getListeReponses()[$j]->afficherReponse()."<br>";
        }
        echo "<br>";
    }

    echo "<br>";
}

function afficherEtudiants($listPremAn, $listSecAn) {
    for ($i = 0; $i < count($listPremAn); $i++) {
        echo "Premiere annee : ".$listPremAn[$i]->getLogin()."<br>";
    }
    echo "<br>";
    
    for ($i = 0; $i < count($listSecAn); $i++) {
        echo "Deuxieme annee : ".$listSecAn[$i]->getLogin()."<br>";
    }
    
    
    echo "<br>";
}

function afficherNoFilleul($etud){
    echo $etud->getLogin()." ne veut pas de filleul<br>";
}

function afficherNbParrains($nbParrains){
    echo "nbParrains : ".$nbParrains."<br>";
}

function afficherMatScore($matriceScore, $listPremAn, $listSecAn, $nbFilleuls, $nbParrains){
    echo "<br>Matrice de score : <br><br>";
    afficherMatrice($matriceScore, $listPremAn, $listSecAn, $nbFilleuls, $nbParrains);
}

function afficherMatMarque($matriceMarque, $listPremAn, $listSecAn, $nbFilleuls, $nbParrains){
    echo "<br>Matrice de marque : <br><br>";
    afficherMatrice($matriceMarque, $listPremAn, $listSecAn, $nbFilleuls, $nbParrains);
}

?>