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
        <p>Un code de vérification a été envoyé</p><br>
        <p>Veuillez entrer le code de vérification ci-dessous :</p><br>

</html>

<?php
include('db.php');
session_start();

echo "<form action='verification.php' method='post'>";
echo "<input type='text' name='code' placeholder='Code de vérification'>";
echo "<input type='submit' value='Valider'>";
echo "</form>";


//on verifie que le code est correct
echo $_SESSION['code'];
if (isset($_POST['code'])){
    if ($_POST['code'] == $_SESSION['code']){
        //on actualise le mot de passe de l'utilisateur dans la table utilisateur
        $req = $database->prepare('UPDATE Utilisateur SET password = ?, estValide = 1 WHERE login = ?' );
        $req->execute(array($_SESSION['password'], $_SESSION['mail']));


        //on redirige vers la page de connexion
        header('Location: connexion.php');
    }
    else{
        echo "Le code de vérification est incorrect";
    }
}
?>
