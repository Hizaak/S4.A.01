
<?php

require_once "Associer.php";

//Récuperer les étudiants dans la base de données
$listEtud[] = new Etudiant("Bastien", 1); //etud de 1annee
$listEtud[] = new Etudiant("Remi", 2); //etud de 2annee


//Récuperer les réponses dans la base de données


//Le premier étudiant a répondu à 2 questions
$listEtud[0]->ajouterReponse(["oui"]); //rep1 de etest1
$listEtud[0]->ajouterReponse(["oui"]); //rep2 de etest1


//Le deuxième étudiant a répondu à 3 questions
$listEtud[1]->ajouterReponse(["oui"]); //rep1 de etest2
$listEtud[1]->ajouterReponse(["non"]); //rep2 de etest2
$listEtud[1]->ajouterReponse(["oui"]); //rep3 de etest2

//afficher le nombre de questions
echo "Nombre de questions : ".nbQuestions()."<br>";

//Afficher les réponses des étudiants
for ($i = 0; $i < count($listEtud); $i++) {
    echo "Etudiant ".$listEtud[$i]->getLogin()." : ";
    for ($j = 0; $j < count($listEtud[$i]->getListeReponses()); $j++) {
        print_r($listEtud[$i]->getListeReponses()[$j][0]." ");
    }
    echo "<br>";
}

//Supprimer les parrains qui ne veulent pas de filleul

//Associer les parrains aux filleuls (fichier Associer.php)

//Enregistrer les associations dans la base de données

?>