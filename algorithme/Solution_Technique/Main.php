
<?php

require "Associer.php";

//Récuperer les étudiants dans la base de données
$etudTest1 = new Etudiant("etest1", 1); //etud de 1annee
$etudTest2 = new Etudiant("etest2", 2); //etud de 2annee

//Récuperer les réponses dans la base de données
$repTest1a = new ReponseQCM(1, "etest1", 1, ["oui"]); //rep1 de etest1
$repTest1b = new ReponseQCM(2, "etest1", 1, ["oui"]); //rep2 de etest1

$repTest2a = new ReponseQCM(1, "etest2", 1, ["oui"]); //rep1 de etest2
$repTest2b = new ReponseQCM(2, "etest2", 1, ["non"]); //rep2 de etest2
$repTest3b = new ReponseQCM(3, "etest2", 1, ["oui"]); //rep3 de etest2

//Supprimer les parrains qui ne veulent pas de filleul

//Associer les parrains aux filleuls (fichier Associer.php)

//Enregistrer les associations dans la base de données

?>