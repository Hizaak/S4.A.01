<html lang="fr">

<head>
    <!-- Metadonnées -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de compte</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/styleCreation.css">

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
        <form method="POST">
            <h2 id="creationTitle">Modifier son mot de passe</h1>
            <p>Identifiant</p>
            <section id="mail">
                <input name="login" type="text" id="identifiant"  required>
                <label id="domaine">@iutbayonne.univ-pau.fr</label>
                <p id="error"></p>
            </section>
            <p id="texteMDP">Nouveau Mot de passe</p>
            <section>
                <!-- TODO : mettre une limite de visibilité dans la saisie pour ne pas couvrir l'oeil -->
                <input id="MDP" type="password" name="password" autocomplete="current-password" required>
                <img id="oeil-MDP" src="../sources/icons/visibility_on.svg" alt="Icone d'oeil" onclick="showPassword('MDP')">
            </section>
            <p id="texteConfirmation">Confirmer le nouveau mot de passe</p>
            <section>
                <!-- TODO : mettre une limite de visibilité dans la saisie pour ne pas couvrir l'oeil -->
                <!-- TODO : mettre un message d'erreur si les deux mots de passe ne correspondent pas + conformité du mdp -->
                <input id="confirmation" type="password" name="conf-password" autocomplete="current-password" required>
                <img id="oeil-confirmation" src="../sources/icons/visibility_on.svg" alt="Icone d'oeil" onclick="showPassword('confirmation')">
            </section>
            <button id="boutonInscription" type="submit" name="submit">Modifier</button>
    
            
        </form>
    </main>

    <footer>
        <ul>
            <li><a href="#">Politique</a></li>
            <li><a href="#">Sécurité</a></li>
            <li><a id="nousContacter" href="../html/nousContacter.html">Nous contacter</a></li>
        </ul>
    </footer>
    
    <script type="text/javascript" src="../script/outils.js"></script>
</body>

</html>



<?php
include('outils.php');
if (isset($_SESSION['login'])) {
    echo ('<script>document.getElementById("identifiant").value ="'.$_SESSION['login'].'"</script>');
}

if (isset($_POST['submit']) && isset($_POST['login']) && isset($_POST['password']) && isset($_POST['conf-password'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $confPassword = $_POST['conf-password'];
    if (verifUtilisateur($login)){

        if ($password == $confPassword) {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $_SESSION['login'] = $login;
            $_SESSION['password'] = $password;
            $_SESSION['code']=envoyerCodeMail($login);
            header('Location: verification.php');
        }
        else {
            error("Les mots de passe ne correspondent pas");
        }}
    else {
        error('Identifiant incorrect');
    }}
?>