<!DOCTYPE html>
<?php
session_start();
include 'bd.php';
//on recupere les dvd de la base de données
$reponse = $bdd->prepare('SELECT playlist.nom AS playlist, titre.nom, titre.artiste, titre.genre, titre.note FROM playlist, titre, appartient WHERE playlist.id = appartient.idPlaylist AND titre.id = appartient.idTitre; ');
$reponse->execute();
?>

<html>
    <head>
        <title>Fiasco</title>
    </head>
    <body>
        <a href="index.php">Retour</a>
        <?php

                echo '<h1>Les Playlists de l\'utilisateur '.$user.'</h1>';
                echo '<section class="grille-titre">';
                //On affiche les titres de la playlist selectionnée
                $playlist = array();
                while ($element = $reponse->fetch()){
                    //On crée un tableau avec les titres de même nom de playlist
                    $playlist[$element['playlist']][] = $element;
                }

                //On affiche les titres de la playlist selectionnée
                foreach ($playlist as $key => $value) {
                    echo '<article class="titre">';
                    echo '<h2>'.$key.'</h2>';
                    echo '<ul>';
                    foreach ($value as $key2 => $value2) {
                        echo '<li>'.$value2['nom'].' - '.$value2['artiste'].' - '.$value2['genre'].' - '.$value2['note'].'/5</li>';     
                    }
                    echo '</ul>';
                    echo '</article>';
                }
            ?>            

</section>
    </body>
</html>