
<?php
include('db.php');
session_start();
// Si le formulaire a été envoyé
if (isset($_POST['mail']) && isset($_POST['password']) && isset($_POST['conf-password'])) {
    // On verifie que les champs ne sont pas vides
    if (!empty($_POST['mail']) && !empty($_POST['password']) && !empty($_POST['conf-password'])){
        //on verifie que les mots de passe sont identiques
        if ($_POST['password'] == $_POST['conf-password']){
            //on verifie que le mail n'est pas déjà utilisé
            $req = $database->prepare('SELECT * FROM Utilisateur WHERE login = ?');
            $req->execute(array($_POST['mail']));
            $resultat = $req->fetch();

            if ($resultat){
               
                //INSERER LE MESSAGE DE CONFIRMATION ICI




                //on hash le mot de passe

                // $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                // //on ajoute l'utilisateur dans la base de données
                // $req = $database->prepare('UPDATE Utilisateur SET password = ? WHERE login = ?');

                // $req->execute(array($password,$_POST['mail']));
                // echo 'Votre compte a bien été créé';
            }
            else{
                echo 'cet email n\'est pas disponible';
            }
        }
        else{
            echo 'Les mots de passe ne sont pas identiques';
        }
    }
    else{
        echo 'Veuillez remplir tous les champs';
    }}
?>
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
            <h1 id="creationTitle">Créer un compte</h1>
            <p>Identifiant</p>
            <section id="mail">
                <input name="mail" type="text" id="identifiant"  required>
                <label id="domaine">@etud.univ-pau.fr</label>
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
            <section id="confirmation-mail">
                <?php
                    if (isset($resultat) && $resultat){
                        echo '<p>Un code vous à était envoyé par mail</p>';
                        echo '<input type="text" name="secret" id="code" required>';
                        echo '<p id="texteConfirmation">Si vous n\'avez pas reçu de mail, cliquez <a href="creation-compte.php">ici</a></p>';
                        
                    }
                ?>
            </section>
            <button id="boutonInscription" type="submit" name="submit">S'inscrire</button>
            
        </form>
        <p id="pasDeCompte">Déjà un compte ? <a href="../html/connexion.html">Se connecter</a>.</p>
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