<?php
include_once 'Utilisateur.php';
include_once 'outils.php';

//L'utilisateur doit être connecté
if(!isset($_SESSION['user'])){
    header('Location:../index.php');
}

//Si le formulaire n'est pas terminé on redirige vers la page d'accueil
if(!isset($_SESSION['formulaire'])){
    header('Location:../index.php');
}

//Si l'utilisateur est un simple utilisateur on affiche simplement les autre utilisateur avec qui il est pararainer
if(!$_SESSION['user']->estAdmin()){
    $req=$database->prepare("SELECT utilisateur.prenom, utilisateur.nom FROM parrainer JOIN utilisateur ON parrainer.LOGIN_PARRAIN=utilisateur.LOGIN 
    OR parrainer.LOGIN_FILLEUL=utilisateur.LOGIN WHERE (parrainer.LOGIN_PARRAIN=:loginleft AND parrainer.LOGIN_FILLEUL=utilisateur.LOGIN) 
    OR (parrainer.LOGIN_FILLEUL=:loginright AND parrainer.LOGIN_PARRAIN=utilisateur.LOGIN)");
    $req->execute(array("loginleft"=>$_SESSION['user']->getLogin(),"loginright"=>$_SESSION['user']->getLogin()));
    $ListeAssos=$req->fetchAll();
    echo "<h1 style='text-align:center'>Liste des utilisateurs avec qui vous êtes parrainé</h1>";
    echo "<br>";
    echo "<table id='tableassos' style='margin:auto;'>";
    echo "<tr><th>Nom</th><th>Prénom</th></tr>";
    foreach($ListeAssos as $assos){
        echo "<tr><td>".$assos["nom"]."</td><td>".$assos["prenom"]."</td></tr>";
    }
    echo "</table>";
}

//Un admin lui va voir toutes les associations des étudiants
else{
    $req=$database->prepare("SELECT 
    utilisateur_parrain.prenom AS prenom_parrain, 
    utilisateur_parrain.nom AS nom_parrain, 
    utilisateur_filleul.prenom AS prenom_filleul, 
    utilisateur_filleul.nom AS nom_filleul
  FROM 
    parrainer 
  JOIN 
    utilisateur AS utilisateur_parrain ON parrainer.LOGIN_PARRAIN = utilisateur_parrain.LOGIN 
  JOIN 
    utilisateur AS utilisateur_filleul ON parrainer.LOGIN_FILLEUL = utilisateur_filleul.LOGIN
  ORDER BY nom_parrain ASC;
  "); 
     //On recupere les informations des utilisateurs parrain et filleul sus la forme d'un tableau associatif nom,prenom nom,prenom
    $req->execute();
    $ListeAssos=$req->fetchAll();
    echo "<h1 style='text-align:center'>Liste des associations</h1>";
    echo "<br>";
    echo "<table id='tableassos' style='margin:auto;'>";
    echo "<tr><th>Nom parrain</th><th>Prénom parrain</th><th>Nom filleul</th><th>Prénom filleul</th></tr>";
    foreach($ListeAssos as $assos){
        echo "<tr><td>".$assos["nom_parrain"]."</td><td>".$assos["prenom_parrain"]."</td><td>".$assos["nom_filleul"]."</td><td>".$assos["prenom_filleul"]."</td></tr>";
    }
    echo "</table>";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats des parrainages</title>
    <!-- On ajoute le css -->
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/resultats.css">
</head>
<body>

    <input id="retour" type="button" value="Retour" onclick="window.location.href='accueil.php'">
    
</body>
</html>