<?php

require_once "Main.php";
/**
 * @brief fonction qui affiche la matrice de distance
 * @param type $matrice 
 * @param type $listPremAn
 * @param type $listSecAn
 * @param type $nbFilleuls
 * @param type $nbParrains
 */
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

/**
 * @brief Fonction qui affiche les réponses des étudiants
 * @param type $listEtud
 * 
 */
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

/**
 * @brief Fonction qui affiche les étudiants
 * @param type $listPremAn
 * @param type $listSecAn
 */
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

/**
 * @brief Fonction qui affiche les etudiants qui ne veulent pas de filleul
 * @param type $etud 
 */
function afficherNoFilleul($etud){
    echo $etud->getLogin()." ne veut pas de filleul<br>";
}

/**
 * @brief Fonction qui affiche le nombre de filleuls
 * @param int $nbParrains
 */
function afficherNbParrains($nbParrains){
    echo "nbParrains : ".$nbParrains."<br>";
}

/**
 * @brief Fonction qui affiche la matrice de score
 * @param type $matriceScore
 * @param type $listPremAn
 * @param type $listSecAn
 * @param type $nbFilleuls
 * @param type $nbParrains
 */
function afficherMatScore($matriceScore, $listPremAn, $listSecAn, $nbFilleuls, $nbParrains){
    echo "<br>Matrice de score : <br><br>";
    afficherMatrice($matriceScore, $listPremAn, $listSecAn, $nbFilleuls, $nbParrains);
}
/**
 * @brief Fonction qui affiche la matrice de marque
 * @param type $matriceMarque
 * @param type $listPremAn
 * @param type $listSecAn
 * @param type $nbFilleuls
 * @param type $nbParrains
 */
function afficherMatMarque($matriceMarque, $listPremAn, $listSecAn, $nbFilleuls, $nbParrains){
    echo "<br>Matrice de marque : <br><br>";
    afficherMatrice($matriceMarque, $listPremAn, $listSecAn, $nbFilleuls, $nbParrains);
}

?>