<html lang="fr">

<head>
    <!-- Metadonnées -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de compte</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/styleVerification.css">

    <!-- Polices -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fira+Mono&family=Rambla:wght@700&family=Roboto:ital,wght@0,300;1,400&display=swap"
        rel="stylesheet">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="../sources/icons/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../sources/icons/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../sources/icons/favicon/favicon-16x16.png">

</head>

<body>
    <header>
        <img id="logoHegoBerria" src="../sources/icons/logo_hego_berria.svg" alt="Le logo de Hego Berria">
        <h1>Hego Berria</h1>
    </header>

    <main>

        <form action='verification.php' method='post'>
            <p id="msgCodeEnvoi">Un <b>code de vérification</b> vous a été envoyé.</p>
            <p>Veuillez entrer le code de vérification ci-dessous :</p>
            <input type='text' name='code' placeholder='000000' id='inputValidation'>
            <p id='error'></p>
            <input type='submit' value='Valider' id='boutonValidation'>
        </form>
        <p id="success"></p>
        
    </main>

</html>

<?php

/* Cette page permet de vérifier l'adresse mail de l'utilisateur en lui envoyant un code de vérification par mail
 * puis en vérifiant que le code entré par l'utilisateur est le même que celui envoyé par mail 
 * 
 * Nouveau  : il faut ajouter un contexte à la page pour savoir ce que l'ont doit faire après la vérification
 * Le contexte est dans le $_SESSION['contexte']
 * */



include('outils.php');



//on verifie que le code est correct

if(!isset($_SESSION['contexte'])){
    error("Erreur : contexte non défini");
    header("Refresh: 1; url=connexion.php");
}


if (isset($_POST['code'])){
    if ($_POST['code'] == $_SESSION['code']){
        $contexte = $_SESSION['contexte'];

        switch ($_SESSION['contexte']){
            case 'creationCompte':
                 //on actualise le mot de passe de l'utilisateur dans la table utilisateur
                $req = $database->prepare('UPDATE Utilisateur SET password = ?, estValide = 1 WHERE login = ?' );
                $req->execute(array($_SESSION['password'], $_SESSION['login']));
                $_SESSION['message'] = ["Votre compte a bien été créé !","#006700"];
                //on redirige vers la page de connexion
                header('Location:connexion.php');
                break;
            case 'MDPoublie':
                //on actualise le mot de passe de l'utilisateur dans la table utilisateur
                $req = $database->prepare('UPDATE Utilisateur SET password = ? WHERE login = ?' );
                $req->execute(array($_SESSION['password'], $_SESSION['login']));
                //on redirige vers la page de connexion
                $_SESSION['message'] = ["Votre mot de passe à bien était modifié!","#006700"];
                header('Location: connexion.php');
                break;
            default:
                error("Erreur : contexte non reconnu");
                break;
        }
        //on supprime les variables de session inutiles 
        unset($_SESSION['contexte']);
        unset($_SESSION['code']);
        unset($_SESSION['password']);


    }
    else{
        error("Le code de vérification est incorrect");
    }
}

?>