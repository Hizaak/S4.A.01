
<?php

require_once "hongroise.php";
require_once "Outils.php";

//Récuperer les étudiants dans la base de données

$listEtud = array();

//Récuperer les réponses dans la base de données
//TO DO

//On sépare les étudiants en deux listes : les premières années et les deuxièmes années

$listPremAn=array();
$listSecAn=array();

separerEtud($listEtud,$listPremAn,$listSecAn);

//Supprimer les parrains qui ne veulent pas de filleul
//On part du principe que la dernière question des deuxieme annee est la question sur le fait de vouloir un filleul ou non
foreach($listSecAn as $etud){
    if($etud->getListeReponses()[count($etud->getListeReponses())-1]->getReponseQCM()==["non"]){
        //On pop l'etudiant $etud de la liste $listSecAn
        $key = array_search($etud, $listSecAn);
        array_splice($listSecAn, $key, 1);

    }
}

//Associer les parrains aux filleuls (fichier Associer.php)
//On initialise la matrice de score
$nbParrains = count($listSecAn);
$nbFilleuls = count($listPremAn);
$matriceScore = array();
$nbQuestionsPrem=count($listPremAn[0]->getListeReponses());
$scoreMax = $nbQuestionsPrem;


for ($i = 0; $i < $nbFilleuls; $i++) {
    for ($j = 0; $j < $nbParrains; $j++) {
        $matriceScore[$i][$j] = $scoreMax;
    }
}

//On calcule le score de chaque parrain pour chaque filleul
for ($i = 0; $i < $nbFilleuls; $i++) {
    for ($j = 0; $j < $nbParrains; $j++) {
        for ($k = 0; $k < $nbQuestionsPrem; $k++) {
            $matriceScore[$i][$j] -= calculerDistanceReponses($listPremAn[$i]->getListeReponses()[$k]->getReponseQCM(),$listSecAn[$j]->getListeReponses()[$k]->getReponseQCM());
        }
    }
}
//on rasterise la matrice de score
for ($i = 0; $i < $nbFilleuls; $i++) {
    for ($j = 0; $j < $nbParrains; $j++) {
        //On arrondit le score a 3 chiffres apres la virgule et on le multiplie par 100 
        $matriceScore[$i][$j] = round($matriceScore[$i][$j] * 100, 3);
    }
}

//On associe les filleuls aux parrains
//On recupere la valeur maximale de la matrice de score
$max = 0;
for ($i = 0; $i < $nbFilleuls; $i++) {
    for ($j = 0; $j < $nbParrains; $j++) {
        if ($matriceScore[$i][$j] > $max) {
            $max = $matriceScore[$i][$j];
        }
    }
}

//on affiche une matrice de résultat de la méthode hongroise en affichant null si c'est null
$matMarque = appliquerMethodeHongroise($matriceScore, $max);

//On associe les filleuls aux parrains


//Enregistrer les associations dans la base de données

?>