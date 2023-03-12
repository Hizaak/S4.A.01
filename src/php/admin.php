<?php
    include_once 'outils.php';
    include_once 'Formulaire.php';
    if (!estAdmin()) {
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
        
        <script type="text/javascript" src="../script/outils.js"></script>
    </head>

<body>
    <header>
        <img id="logoHegoBerria" src="../sources/icons/logo_hego_berria.svg" alt="Le logo de Hego Berria">
        <h1>Hego Berria</h1>
    </header>


<?php
    $formulaire = Formulaire::getInstance($database);
    if($formulaire->existe($database)){
        echo "<div id='ferme'>
            <h2>Vous êtes connecté en tant qu'administrateur</h2>
            <button href='#'>Modifier le formulaire</button>
        </div>";
    }
    else {
        echo "<div id='ferme'>
            <h2>Vous êtes connecté en tant qu'administrateur</h2>
            <button href='#'>Rédiger le formulaire</button>
        </div>";
    }
?>
</body>
</html>