
<?php

require "Outils.php";

//CALCULER LA MATRICE DE SCORE 

//On compte le nombre de première année
$nbFilleuls = nbPremiereAnnee();

//On compte le nombre de deuxième année
$nbParrains = nbDeuxiemeAnnee();

//On compte le nombre de questions référencées dans les réponses
$nbQuestions = nbQuestions();

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