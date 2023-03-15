<?php
include 'Utilisateur.php';
include 'Formulaire.php';
if (!estConnecte()) {
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
    // récupérer l'instance de formulaire
    $formulaire = Formulaire::getInstance($database);
    // on met le formulaire dans la session
    $_SESSION['formulaire'] = $formulaire;
    $etatForm = $_SESSION['formulaire']->getEtat($_SESSION['user'],$database);
    $dateFin = $_SESSION['formulaire']->getDateFin();


switch($etatForm)
    {
        // ON NE FAIT PAS CE CAS CAR IL Y A FORCEMENT UN FORMULAIRE
        // case 'formulaireInexistant': 
        //     echo"<div id='inexistant'>
        //         <h2>Le questionnaire n'est pas<br>encore disponible... Désolé</h2>
        //     </div>";
        // break;

        // ON NE FAIT PAS CE CAS CAR ON LE FERA DANS LA V2 DE L'APPLICATION
        // case 'formulaireEnAttente':
        //     echo "<div id='ferme'>
        //         <h2>Merci d'avoir répondu au<br>formulaire !</h2>
        //         <hr>
        //         <h2 class='textp'>Vous aller bientôt être parrainé(e) !</h2>
        //     </div>";
        // break;

        case 'peutConsulterEtRepondu':
            echo "<div id='ferme'>
                <h2>Merci d'avoir répondu au<br>formulaire !</h2>
                <button>Accéder aux résultats</button>
            </div>";
        break;

        case 'peutConsulterMaisPasRepondu':
            echo "<div id='ferme'>
                <h2>Vous avez été parainné !</h2>
                <button>Accéder aux résultats</button>
            </div>";
        break;

        case 'peutModifier':
            echo"<div id='divTemps'>
                <h2>Merci d'avoir d'avoir répondu,<br>tu peux toujours modifier !</h2>
                <ul>
                    <li>
                        <h2 class='Temps' id='jours'></h2>
                        <p class='labelTimer' id='labelJours'></p>
                    </li>
                    <li>
                        <h2 class='Temps' id='heures'></h2>
                        <p class='labelTimer' id='labelHeures'></p>
                    </li>
                    <li>
                        <h2 class='Temps' id='minutes'></h2>
                        <p class='labelTimer' id='labelMinutes'></p>
                    </li>
                    <li>
                        <H2 class='Temps' id='secondes'></H2>
                        <p class='labelTimer' id='labelSecondes'></p>
                    </li>
                </ul>
                <button onclick='window.location.href = \"afficherFormulaire.php?modify=1\"'>Modifier mes réponses</button>
            </div>";
        break;

        case 'peutRepondre':
            echo"<div id='divTemps'>
                <h2>Le formulaire est dispo,<br>réponds-y !</h2>
                <ul>
                    <li>
                        <h2 class='Temps' id='jours'></h2>
                        <p class='labelTimer' id='labelJours'></p>
                    </li>
                    <li>
                        <h2 class='Temps' id='heures'></h2>
                        <p class='labelTimer' id='labelHeures'></p>
                    </li>
                    <li>
                        <h2 class='Temps' id='minutes'></h2>
                        <p class='labelTimer' id='labelMinutes'></p>
                    </li>
                    <li>
                        <H2 class='Temps' id='secondes'></H2>
                        <p class='labelTimer' id='labelSecondes'></p>
                    </li>
                </ul>
                <button onclick='window.location.href = \"afficherFormulaire.php\"'>Accèder au formulaire</button>
            </div>";
        break;

        case 'continueDeRepondre':
            $QuestionsRestantes=$_SESSION['user']->getNBQuestionARepondre($database)-$_SESSION['user']->getNBQuestionRepondu($database);
            $msg="question";
            if($QuestionsRestantes>1){
                $msg.="s";
            }
            echo"<div id='divTemps'>
                <h2>Il te reste ".$QuestionsRestantes." ".$msg.",<br>réponds-y !</h2>
                <ul>
                    <li>
                        <h2 class='Temps' id='jours'></h2>
                        <p class='labelTimer' id='labelJours'></p>
                    </li>
                    <li>
                        <h2 class='Temps' id='heures'></h2>
                        <p class='labelTimer' id='labelHeures'></p>
                    </li>
                    <li>
                        <h2 class='Temps' id='minutes'></h2>
                        <p class='labelTimer' id='labelMinutes'></p>
                    </li>
                    <li>
                        <H2 class='Temps' id='secondes'></H2>
                        <p class='labelTimer' id='labelSecondes'></p>
                    </li>
                </ul>
                <button onclick='window.location.href = \"afficherFormulaire.php\"'>Continuer le formulaire</button>
            </div>";

        }
        ?>
        <script type="text/javascript">
            var dateLimite = Date.parse("<?php echo $dateFin; ?>");
            //VARIABLES
            const dateActuelle = new Date();
            const differenceMs = Math.abs(dateLimite - dateActuelle);

            days = Math.floor(differenceMs / (1000 * 60 * 60 * 24));
            hours = Math.floor((differenceMs % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            minutes = Math.floor((differenceMs % (1000 * 60 * 60)) / (1000 * 60));
            seconds = Math.floor((differenceMs % (1000 * 60)) / 1000);

            document.getElementById("jours").innerHTML = (days);
            document.getElementById("heures").innerHTML = (hours);
            document.getElementById("minutes").innerHTML = (minutes);
            document.getElementById("secondes").innerHTML = (seconds);

            if(days === 1 || days === 0)            {
                document.getElementById("labelJours").innerHTML = "jour";
            } else {
                document.getElementById("labelJours").innerHTML = "jours";
            }

            if(hours === 1 || hours === 0)            {
                document.getElementById("labelHeures").innerHTML = "heure";
            } else {
                document.getElementById("labelHeures").innerHTML = "heures";
            }

            if(minutes === 1 || minutes === 0)            {
                document.getElementById("labelMinutes").innerHTML = "minute";
            } else {
                document.getElementById("labelMinutes").innerHTML = "minutes";
            }

            if(seconds === 1 || seconds === 0)            {
                document.getElementById("labelSecondes").innerHTML = "seconde";
            } else {
                document.getElementById("labelSecondes").innerHTML = "secondes";
            }
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
                                location.reload()
                            }
                            else
                            {
                                document.getElementById("jours").innerHTML = days;
                                if(days === 1 || days === 0)
                                {
                                    document.getElementById("labelJours").innerHTML = "jour";
                                }
                                else
                                {
                                    document.getElementById("labelJours").innerHTML = "jours";
                                }
                            }
                        }
                        document.getElementById("heures").innerHTML = hours;
                        if(hours === 1 || hours === 0)
                        {
                            document.getElementById("labelHeures").innerHTML = "heure";
                        }
                        else
                        {
                            document.getElementById("labelHeures").innerHTML = "heures";
                        }
                    }
                    document.getElementById("minutes").innerHTML = minutes;
                    if(minutes === 1 || minutes === 0)
                    {
                        document.getElementById("labelMinutes").innerHTML = "minute";
                    }
                    else
                    {
                        document.getElementById("labelMinutes").innerHTML = "minutes";
                    }
                }
                document.getElementById("secondes").innerHTML = seconds;
                if(seconds === 1 || seconds === 0)
                {
                    document.getElementById("labelSecondes").innerHTML = "seconde";
                }
                else
                {
                    document.getElementById("labelSecondes").innerHTML = "secondes";
                }
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