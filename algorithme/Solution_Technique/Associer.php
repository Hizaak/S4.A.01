
<?php

require "Outils.php";
require "Main.php";

//CALCULER LA MATRICE DE SCORE 

//On sépare les étudiants en deux listes : les parrains et les filleuls

//On compte le nombre de Filleuls

//On compte le nombre de Parrains

//On compte le nombre de questions référencées dans les réponses

$scoreMax = $nbQuestions*100;

//On initialise la matrice de score
$matriceScore = array();
for ($i = 0; $i < $nbFilleuls; $i++) {
    for ($j = 0; $j < $nbParrains; $j++) {
        $matriceScore[$i][$j] = $scoreMax;
    }
}

//Appliquer la méthode de l'agorithme hongrois

//En déduire les associations parrain-filleul

?>