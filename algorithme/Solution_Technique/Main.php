
<?php

require_once "Associer.php";
require_once "hongroise.php";

//Récuperer les étudiants dans la base de données

$listEtud = array();

$listEtud[] = new Etudiant("Bastien", 1); //etud de 1annee
$listEtud[] = new Etudiant("Remi", 2); //etud de 2annee

$listEtud[] = new Etudiant("Alexandre", 1); //etud de 1annee
$listEtud[] = new Etudiant("Julien", 2); //etud de 2annee

$listEtud[] = new Etudiant("Romain", 1); //etud de 1annee
$listEtud[] = new Etudiant("Nicolas", 2); //etud de 2annee


//Récuperer les réponses dans la base de données
//TO DO

//BASTIEN a répondu à 3 questions
$listEtud[0]->ajouterReponse(new ReponseQCM(1, "Bastien", ["oui"])); //rep1 de Bastien
$listEtud[0]->ajouterReponse(new ReponseQCM(2, "Bastien", ["non"])); //rep2 de Bastien
$listEtud[0]->ajouterReponse(new ReponseQCM(3, "Bastien", ["oui"])); //rep3 de Bastien

//REMI a répondu à 4 questions
$listEtud[1]->ajouterReponse(new ReponseQCM(1, "Remi", ["oui"])); //rep1 de Remi
$listEtud[1]->ajouterReponse(new ReponseQCM(2, "Remi", ["non"])); //rep2 de Remi
$listEtud[1]->ajouterReponse(new ReponseQCM(3, "Remi", ["oui"])); //rep3 de Remi
$listEtud[1]->ajouterReponse(new ReponseQCM(4, "Remi", ["oui"])); //rep3 de Remi

//ALEXANDRE a répondu à 3 questions
$listEtud[2]->ajouterReponse(new ReponseQCM(1, "Alexandre", ["oui"])); //rep1 de Alexandre
$listEtud[2]->ajouterReponse(new ReponseQCM(2, "Alexandre", ["oui"])); //rep2 de Alexandre
$listEtud[2]->ajouterReponse(new ReponseQCM(3, "Alexandre", ["non"])); //rep2 de Alexandre

//JULIEN a répondu à 4 questions
$listEtud[3]->ajouterReponse(new ReponseQCM(1, "Julien", ["non"])); //rep1 de Julien
$listEtud[3]->ajouterReponse(new ReponseQCM(2, "Julien", ["non"])); //rep2 de Julien
$listEtud[3]->ajouterReponse(new ReponseQCM(3, "Julien", ["non"])); //rep3 de Julien
$listEtud[3]->ajouterReponse(new ReponseQCM(4, "Julien", ["oui"])); //rep4 de Julien

//ROMAIN a répondu à 3 questions
$listEtud[4]->ajouterReponse(new ReponseQCM(1, "Romain", ["oui"])); //rep1 de Romain
$listEtud[4]->ajouterReponse(new ReponseQCM(2, "Romain", ["oui"])); //rep2 de Romain
$listEtud[4]->ajouterReponse(new ReponseQCM(3, "Romain", ["oui"])); //rep2 de Romain

//NICOLAS a répondu à 4 questions
$listEtud[5]->ajouterReponse(new ReponseQCM(1, "Nicolas", ["oui"])); //rep1 de Nicolas
$listEtud[5]->ajouterReponse(new ReponseQCM(2, "Nicolas", ["non"])); //rep2 de Nicolas
$listEtud[5]->ajouterReponse(new ReponseQCM(3, "Nicolas", ["non"])); //rep3 de Nicolas
$listEtud[5]->ajouterReponse(new ReponseQCM(4, "Nicolas", ["oui"])); //rep4 de Nicolas


//Afficher les réponses des étudiants
for ($i = 0; $i < count($listEtud); $i++) {
    echo "Etudiant : ".$listEtud[$i]->getLogin()."<br>";
    for ($j = 0; $j < count($listEtud[$i]->getListeReponses()); $j++) {
        echo "Reponse : ".$listEtud[$i]->getListeReponses()[$j]->getReponseQCM()[0]."<br>";
    }
    echo "<br>";
}

echo "<br>";

//On sépare les étudiants en deux listes : les premières années et les deuxièmes années

$listPremAn=array();
$listSecAn=array();
separerEtud($listEtud,$listPremAn,$listSecAn);
//On affiche les deux listes pour vérifier (seulement leurs login)
for ($i = 0; $i < count($listPremAn); $i++) {
    echo "Premiere annee : ".$listPremAn[$i]->getLogin()."<br>";
}
echo "<br>";

for ($i = 0; $i < count($listSecAn); $i++) {
    echo "Deuxieme annee : ".$listSecAn[$i]->getLogin()."<br>";
}


echo "<br>";

//Supprimer les parrains qui ne veulent pas de filleul
//On part du principe que la dernière question des deuxieme annee est la question sur le fait de vouloir un filleul ou non
foreach($listSecAn as $etud){
    if($etud->getListeReponses()[count($etud->getListeReponses())-1]->getReponseQCM()==["non"]){
        echo $etud->getLogin()." ne veut pas de filleul<br>";
        //On pop l'etudiant $etud de la liste $listSecAn
        $key = array_search($etud, $listSecAn);
        array_splice($listSecAn, $key, 1);

    }
}

//Associer les parrains aux filleuls (fichier Associer.php)
//On initialise la matrice de score
$nbParrains = count($listSecAn);
$nbFilleuls = count($listPremAn);
echo "nbParrains : ".$nbParrains."<br>";
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
            if ($listPremAn[$i]->getListeReponses()[$k]->getReponseQCM() == $listSecAn[$j]->getListeReponses()[$k]->getReponseQCM()) {
                $matriceScore[$i][$j] -=calculerDistanceReponses($listPremAn[$i]->getListeReponses()[$k]->getReponseQCM(),$listSecAn[$j]->getListeReponses()[$k]->getReponseQCM());
            }
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

echo "<br>Matrice de score : <br><br>";
//On affiche la matrice score de facon lissible avec en ligne les filleuls et en colonne les parrains en affichant les collone et lignes
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
        echo "<td>".$matriceScore[$i][$j]."</td>";
    }
    echo "</tr>";
}
echo "</table>";

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
echo "<br>Matrice marque : <br><br>";
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
        if($matMarque[$i][$j]==2){
            echo "<td>null</td>";
        }else{
            echo "<td>".$matMarque[$i][$j]."</td>";
        }
        
    }
    echo "</tr>";
}
echo "</table>";

//On associe les filleuls aux parrains


//Enregistrer les associations dans la base de données

?>