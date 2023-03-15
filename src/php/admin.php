<?php
    include_once 'Utilisateur.php';
    include_once 'outils.php';
    include_once 'Formulaire.php';
    if (!$_SESSION['user']->estAdmin()) {
        header('Location:connexion.php');
    }
?>

<html>
    <head>
        <!-- Metadonnées -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Hego Lagunak</title>

        <!-- CSS -->
        <link rel="stylesheet" href="../style/styleSidenav.css">
        <link rel="stylesheet" href="../style/style.css">
        <link rel="stylesheet" href="../style/styleAdmin.css">

        <!-- Polices -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Fira+Mono&family=Rambla:wght@700&family=Roboto:ital,wght@0,300;1,400&display=swap" rel="stylesheet">

        <!-- Favicon -->
        <link rel="apple-touch-icon" sizes="180x180" href="../sources/icons/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="../sources/icons/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="../sources/icons/favicon/favicon-16x16.png">
        
        <script type="text/javascript" src="../script/outils.js"></script>
    </head>

<body>
<!--Side Navigation-->
<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <p id="sideNavText1">Connecté en tant que :</p>
    <p id="connectedUser">HEGO BERRIA</p>
    <hr>
    <form method="POST">

        <p>Ancien mot de passe</p>
        <input name='login' type="text" id="identifiant" required>
        <p class="errorPWD"></p> <!--TODO: Coder la partie changement mot de passe-->
        <p>Nouveau mot de passe</p>
        <input id="MDP" type="password" name="password" autocomplete="current-password" required>
        <p>Confirmer nouveau mot de passe</p>
        <input id="MDP-verif" type="password" name="password-verif" autocomplete="current-password" required>
        <p class="errorPWD"></p> <!--TODO: Coder la partie changement mot de passe-->
        <p id="labelPWD">Le mot de passe doit faire plus de 8 caractères et contenir un caractère spécial.</p>
        <button id="boutonMAJ" type="submit" name="submit">Mettre à jour</button>

    </form>
    <hr>
    <post>
        <button id="boutonList" onclick='window.location.href = "importEtudiant.php"'>Modifier la liste étudiante</button>
    </post>
    <button id="disconnect">Déconnexion</button>

</div>
<div id="dimScreen" onclick="closeNav()"></div>
<!--SIDENAV END-->
    <header>
        <span id='sideNavButton' onclick="openNav()">&#9776</span>
        <img id="logoHegoBerria" src="../sources/icons/logo_hego_berria.svg" alt="Le logo de Hego Berria">
        <h1>Hego Berria</h1>
    </header>


<?php
    $formulaire = Formulaire::getInstance($database);
    //On doit récupérer l'etat du formulaire
    $dateDebut=$formulaire->getDateDebut();
    $dateFin=$formulaire->getDateFin();
    
    if($formulaire->existe($database)){
        //Si le formulaire n'a pas encore commencé
        if($dateDebut>date("Y-m-d")){
            echo "<div class='info' id='ferme'>
                <h2>Vous êtes connecté en tant qu'administrateur</h2>
                <button onclick='window.location.href = \"creationFormulaire.php\"'>Modifier le formulaire</button>
            </div>";
        }
        //Si le formulaire est en cours
        else if($dateDebut<=date("Y-m-d") && $dateFin>=date("Y-m-d")){
            echo "<div class='info' id='ouvert'>
                <h2>Vous ne pouvez plus modifier le formulaire</h2>
                <button onclick='window.location.href = \"accueil.php\"'>Accueil</button>
            </div>";
        }
        //Si le formulaire est terminé
        else if($dateFin<date("Y-m-d")){
            echo "<div class='info' id='ferme'>
                <h2>Le formulaire est terminé</h2>
                <button onclick='window.location.href = \"resultats.php\"'>Afficher les résultats</button>
            </div>";
        }
    }
    else {
        echo "<div class='info' id='ferme'>
            <h2>Vous êtes connecté en tant qu'administrateur</h2>
            <button onclick='window.location.href = \"creationFormulaire.php\"'>Rédiger le formulaire</button>
        </div>";
    }
?>
<script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "400px";
        document.getElementById("dimScreen").style.display = "initial";
    }

    /* Set the width of the side navigation to 0 and the left margin of the page content to 0, and the background color of body to white */
    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
        document.getElementById("dimScreen").style.display = "none";
    }
    document.getElementById("disconnect").addEventListener("click", function(){
                //On va sur la page de déconnexion
                window.location.href = "deconnexion.php";
        });
</script>
</body>
</html>