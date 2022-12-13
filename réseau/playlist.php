<!DOCTYPE html>
<?php
session_start();
include 'bd.php';
//on recupere les dvd de la base de données
$reponse = $bdd->prepare('SELECT * FROM dvd');
$reponse->execute();
?>

<html>
    <head>
        <title>Fiasco</title>
        <link rel="stylesheet" href="./stylearticle.css">
    </head>
    <body>
        <a href="index.php">Retour</a>
        <section class="grille-dvd">
            <?php
            while($dvd = $reponse->fetch()){
                echo '<article class="dvd">';
                echo '<p id="id" style="display:none">'.$dvd['id'].'</p>';

                //On verifie si l'image existe
                echo '<img src="../assets/compress/'.$dvd['img'].'" alt="img'.$dvd['titre'].'">';
                echo '<h2>'.$dvd['titre'].'</h2>';
                echo '<p>Réalisateur : '.$dvd['realisation'].'</p>';
                echo '<p>Genre : '.$dvd['genre'].'</p>';
                echo '<p> Prix : '.$dvd['prix'].'€</p>';
                echo '</article>';
            }
            ?>            

</section>
    </body>
</html>