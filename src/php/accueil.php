<?php
include 'outils.php';
if (0) {
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
    <link rel="stylesheet" href="../style/styleSidenav.css">
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
<!--Side Navigation-->
<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <p id="sideNavText1">Connecté en tant que :</p>
    <p id="connectedUser">USER</p>
    <hr>
    <form method="POST">

        <p>Ancien mot de passe</p>
        <input name='login' type="text" id="identifiant" required>
        <p class="errorPWD">Le mot de passe est erroné</p>
        <p>Nouveau mot de passe</p>
        <input id="MDP" type="password" name="password" autocomplete="current-password" required>
        <p>Confirmer nouveau mot de passe</p>
        <input id="MDP-verif" type="password" name="password-verif" autocomplete="current-password" required>
        <p class="errorPWD">Les mots de passe de correspondent pas</p>
        <p id="labelPWD">Le mot de passe doit faire plus de 8 caractères et contenir un caractère spécial.</p>
        <button id="boutonMAJ" type="submit" name="submit">Mettre à jour</button>

    </form>
    <hr>
    <button id="disconnect">Déconnexion</button>

</div>
<div id="dimScreen" onclick="closeNav()"></div>
    <header>
        <span id='sideNavButton' onclick="openNav()">&#9776</span>
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
                <button>Accéder aux résultats</button>
            </div>";
                break;

            case 'modificationReponse':   //TODO : A adapter
                echo "<div id='ferme'>
                <h2>Merci d'avoir répondu au<br>formulaire !</h2>
                <button>Modifier ma réponse</button>
            </div>";
                break;

            case 'ouvert':          //TODO : A adapter
                echo"<div id='divTemps'>
                <h2>Le formulaire est dispo,<br>réponds-y !</h2>
                <ul>
                    <li>
                        <h2 class='Temps' id='jours'></h2>
                        <h3 class='labelHeure'>";
                        if($jours <= 1){echo"jour";}
                        else{echo"jours";}
                        echo"</h3>
                    </li>
                    <li>
                        <h2 class='Temps' id='heures'></h2>
                        <h3 class='labelHeure'>";
                        if($heures <= 1)
                        {
                            echo"heure";
                        }
                        else{echo"heures";}
                        echo"</h3>
                    </li>
                    <li>
                        <h2 class='Temps' id='minutes'></h2>
                        <h3 class='labelHeure'>";
                        if($minutes <= 1){echo"minute";}
                        else{echo"minutes";}
                        echo"</h3>
                    </li>
                    <li>
                        <H2 class='Temps' id='secondes'></H2>
                        <h3 class='labelHeure'>";
                        if($secondes <= 1){echo"seconde";}
                        else{echo"secondes";}
                        echo"</h3>
                    </li>
                </ul>
                <button>Modifier ma réponse</button>
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
        <script>
            //VARIABLES
            const dateLimite = new Date(2023,0,0,0,0,0)//year, month, day, hour, minute, second
            //const dateActuelle = new Date();
            const dateActuelle = new Date(2022,11,30,23,59,45);

            const differenceMs = Math.abs(dateLimite - dateActuelle);

            days = Math.floor(differenceMs / (1000 * 60 * 60 * 24));
            hours = Math.floor((differenceMs % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            minutes = Math.floor((differenceMs % (1000 * 60 * 60)) / (1000 * 60));
            seconds = Math.floor((differenceMs % (1000 * 60)) / 1000);

            document.getElementById("jours").innerHTML = (days);
            document.getElementById("heures").innerHTML = (hours);
            document.getElementById("minutes").innerHTML = (minutes);
            document.getElementById("secondes").innerHTML = (seconds);



            const countdown = setInterval(function(){
                // Décrémenter le temps restant

                seconds--;

                if (seconds === -1) // Vérifier si le timer est terminé -- Si non, actualise les minutes, heures et jours.
                {
                    seconds = 59;
                    minutes--;
                    if (minutes === -1)
                    {
                        minutes = 59;
                        hours--;
                        if (hours === -1)
                        {
                            hours = 23;
                            days--;
                            if (days === -1 || hours === 23 || minutes === 59 || seconds === 59)
                            {
                                clearInterval(countdown); //Arrêter le timer
                                seconds = 0;
                                minutes = 0;
                                hours = 0;
                                days = 0;

                                //location.reload()
                            }
                            else
                            {
                                document.getElementById("jours").innerHTML = (days);
                            }
                        }
                        document.getElementById("heures").innerHTML = (hours);

                    }
                    document.getElementById("minutes").innerHTML = (minutes);

                }

                document.getElementById("secondes").innerHTML = (seconds);

            }, 1000); // Exécuter la fonction toutes les secondes (1000 millisecondes).

            function openNav() {
                document.getElementById("mySidenav").style.width = "400px";
                document.getElementById("dimScreen").style.display = "fixed";
            }

            /* Set the width of the side navigation to 0 and the left margin of the page content to 0, and the background color of body to white */
            function closeNav() {
                document.getElementById("mySidenav").style.width = "0";
                document.getElementById("dimScreen").style.display = "none";
            }
        </script>
    </main>
</body>

</html>