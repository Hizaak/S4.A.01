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
            <h2 id="creationTitle">Créer un compte</h1>
            <p>Identifiant</p>
            <section id="mail">
                <input name="mail" type="text" id="identifiant"  required>
                <label id="domaine">@iutbayonne.univ-pau.fr</label>
                <p id="error"></p>
            </section>
            <p id="texteMDP">Mot de passe</p>
            <section>
                <!-- TODO : mettre une limite de visibilité dans la saisie pour ne pas couvrir l'oeil -->
                <input id="MDP" type="password" name="password" autocomplete="current-password" required>
                <img id="oeil-MDP" src="../sources/icons/visibility_on.svg" alt="Icone d'oeil" onclick="showPassword('MDP')">
            </section>
            <p id="texteConfirmation">Confirmer le mot de passe</p>
            <section>
                <!-- TODO : mettre une limite de visibilité dans la saisie pour ne pas couvrir l'oeil -->
                <input id="confirmation" type="password" name="conf-password" autocomplete="current-password" required>
                <img id="oeil-confirmation" src="../sources/icons/visibility_on.svg" alt="Icone d'oeil" onclick="showPassword('confirmation')">
            </section>
            <button id="boutonInscription" type="submit" name="submit">S'inscrire</button>
    
            
        </form>
        <p id="pasDeCompte">Déjà un compte ? <a href="connexion.php">Se connecter</a>.</p>
    </main>

    <footer>
        <ul>
            <li><a href="#">Politique</a></li>
            <li><a href="#">Sécurité</a></li>
            <li><a id="nousContacter" href="../html/nousContacter.html">Nous contacter</a></li>
        </ul>
    </footer>
    
    <script type="text/javascript" src="devoilerMDP.js"></script>
</body>

</html>


<?php
include('db.php');
include('outils.php');
session_start();
// Si le formulaire a été envoyé
if (isset($_POST['mail']) && isset($_POST['password']) && isset($_POST['conf-password'])) {
    // On verifie que les champs ne sont pas vides
    if (!empty($_POST['mail']) && !empty($_POST['password']) && !empty($_POST['conf-password'])){
        //on verifie que les mots de passe sont identiques
        //on verifie que le mail n'est pas déjà utilisé
        $req = $database->prepare('SELECT * FROM Utilisateur WHERE login = ?');
        $req->execute(array($_POST['mail']));
        $resultat = $req->fetch();


        if ($resultat){
            if ($resultat['estValide']==1){
                error("Le compte existe déjà");
                }
            else{
                //On stock les données de l'utilisateur dans la session pour les réutiliser sur la page de vérifications
                $_SESSION['mail'] = $_POST['mail'];
                $_SESSION['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                //On redirige vers la page de vérification
                $code = rand(100000, 999999);
                //on stock le code dans la session
                $_SESSION['code'] = $code;
                //on envoie le code par mail
                $to = $_SESSION['mail'];
                $subject = "Code de vérification";
                $message = "Voici votre code de vérification : " . $code;
                mail($to.'@etud.univ-pau.fr', $subject, $message, $headers);
                echo "le code est : " . $_SESSION['code'];
                header('Location: verification.php');
                
            }
        }
        else{
            error("Ce compte n'existe pas");
            }
    }
    else{
        error("Tout les champs ne sont pas remplis");
        }
            
    }


?>

