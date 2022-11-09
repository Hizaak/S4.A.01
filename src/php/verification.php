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
        
    </main>

</html>

<?php

include('outils.php');

//on verifie que le code est correct
if (isset($_POST['code'])){
    if ($_POST['code'] == $_SESSION['code']){
        //on actualise le mot de passe de l'utilisateur dans la table utilisateur
        $req = $database->prepare('UPDATE Utilisateur SET password = ?, estValide = 1 WHERE login = ?' );
        //TODO : faire verifier par le prof
        $req->execute(array($_SESSION['password'], $_SESSION['mail']));


        //on redirige vers la page de connexion
        header('Location: connexion.php');
    }
    else{
        error("Le code de vérification est incorrect");
    }
}

?>