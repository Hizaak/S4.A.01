<?php
include 'outils.php';
if (!estConnecter()) {
    header('Location: connexion.php');
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Metadonnées -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hego Lagunak</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../style/styleAccueil.css">
    <link rel="stylesheet" href="../style/style.css">

    <!-- Polices -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Mono&family=Rambla:wght@700&family=Roboto:ital,wght@0,300;1,400&display=swap" rel="stylesheet">

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
        <?php

//VARIABLES
$etatForm = 'ouvert';           //Variables temporaires qui permetent de tester le site

$jours = 1;
$heures = 23;
$minutes = 36;
$secondes = 6;

switch($etatForm)               //TODO : A changer en fonction de la variable indiquant l'état du questionnaire
    {
            case 'inexistant':          //TODO : A adapter
                echo"<div id='inexistant'>
                <h2>Le questionnaire n'est pas<br>encore disponible... Désolé</h2>
            </div>";
                break;

            case 'formulaireEnAttente':           //TODO : A adapter
                echo "<div id='ferme'>
                <h2>Merci d'avoir répondu au<br>formulaire !</h2>
                <hr>
                <h3 class='textH3'>Vous aller bientôt être parrainé(e) !</h3>
            </div>";
                break;

            case 'accederResultats':           //TODO : A adapter
                echo "<div id='ferme'>
                <h2>Merci d'avoir répondu au<br>formulaire !</h2>
                <button href='#'>Accéder aux résultats</button>
            </div>";
                break;

            case 'modificationReponse':   //TODO : A adapter
                echo "<div id='ferme'>
                <h2>Merci d'avoir répondu au<br>formulaire !</h2>
                <button href='#'>Modifier ma réponse</button>
            </div>";
                break;

            case 'ouvert':          //TODO : A adapter
                echo"<div id='divTemps'>
                <h2>Le formulaire est dispo,<br>réponds-y !</h2>
                <ul>
                    <li>
                        <h2 class='Temps'>".$jours."</h2>
                        <h3 class='labelHeure'>";
                        if($jours <= 1){echo"jour";}
                        else{echo"jours";}
                        echo"</h3>
                    </li>
                    <li>
                        <h2 class='Temps'>".$heures."</h2>
                        <h3 class='labelHeure'>";
                        if($heures <= 1){echo"heure";}
                        else{echo"heures";}
                        echo"</h3>
                    </li>
                    <li>
                        <h2 class='Temps'>".$minutes."</h2>
                        <h3 class='labelHeure'>";
                        if($minutes <= 1){echo"minute";}
                        else{echo"minutes";}
                        echo"</h3>
                    </li>
                    <li>
                        <H2 class='Temps'>".$secondes."</H2>
                        <h3 class='labelHeure'>";
                        if($secondes <= 1){echo"seconde";}
                        else{echo"secondes";}
                        echo"</h3>
                    </li>
                </ul>
                <button href='#'>Modifier ma réponse</button>
            </div>";
                break;
                case 'formulairePasEncoreOuvert':           //TODO : A adapter
                 echo "<div id='ferme'>
                    <h2>Le formulaire n'est pas encore ouvert...</h2>
                    <hr>
                    <h3 class='textH3'>Prenez votre mal en patience,<br> ça ne fait que tarder</h3>
                </div>";
        break;
        }
        ?>
    </main>
</body>

</html>