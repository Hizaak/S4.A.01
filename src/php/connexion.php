<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Metadonnées -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../style/styleConnexion.css">
    <link rel="stylesheet" href="../style/style.css">

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
            <h2 id="connexionTitle">Connexion</h1>
            <p>Identifiant</p>
            <section id="mail">
                <input name='login' type="text" id="identifiant" required>
                <label id="domaine">@iutbayonne.univ-pau.fr</label>
            </section>
            <section id="sectionMDP">
                <p>Mot de passe</p>
                <a id="MDPOublie" href="motDePasseOublie.php">Mot de passe oublié</a>
            </section>
            <section>
                <!-- TODO : mettre une limite de visibilité dans la saisie pour ne pas couvrir l'oeil -->
                <input id="MDP" type="password" name="password" autocomplete="current-password" required>
                <img id="oeil-MDP" src="../sources/icons/visibility_on.svg" alt="Icone d'oeil" onclick="showPassword('MDP')">
                <p id="error"></p>
            </section>
            <button id="boutonConnexion" type="submit" name="submit">Se connecter</button>
        </form>
        <p id="pasDeCompte">Pas de compte ? <a href="creationCompte.php">Créer un compte</a>.</p>
    </main>

    <footer>
        <ul>
            <li><a href="#">Politique</a></li>
            <li><a href="#">Sécurité</a></li>
            <li><a id="nousContacter" href="nousContacter.html">Nous contacter</a></li>
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
if (isset($_POST['login']) && isset($_POST['password'])) {
    //on verifie que le mail est bien dans la base de données
    $req = $database->prepare('SELECT * FROM Utilisateur WHERE login = ?');
    $req->execute(array($_POST['login']));
    $resultat = $req->fetch();

    if (!$resultat) {
        error("Identifiant ou mot de passe incorrect");
    } else {
        //on verifie que le mot de passe est correct
        // On hash le mot de passe
        if (password_verify($_POST['password'], $resultat['password'])) {
            //on verifie que l'utilisateur a bien validé son compte
            if ($resultat['estValide'] == 1) {
                //on stocke le mail dans une variable de session
                $_SESSION['login'] = strtolower(($_POST['login']));
                $_SESSION['role'] = $resultat['role'];
                $_SESSION['message'] = ["Bienvenue ".$_SESSION['login'],"#006700"];
                //on redirige vers la page de verification
                if ($resultat['role'] == 'admin'){
                    header('Location:admin.php');

                    
                }
                else{
                    header('Location:accueil.php');
                }
                
            } else {
                error("Vous n'avez pas validé votre compte<br><a href='creationCompte.php'>Valider votre compte</a>");
            }
        } else {
            error("Identifiant ou mot de passe incorrect");
        }
    }
}



?>