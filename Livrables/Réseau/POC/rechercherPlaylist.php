<?php
include 'bd.php';
//On affiche 4 bouton des 4 playlist et il choisit
//On affiche les titres de la playlist selectionnée

//On recupere le nm des playlist de la base de données
$reponse = $bdd->prepare('SELECT nom FROM playlist');
$reponse->execute();

echo '<a href="index.php">Retour</a>';

if (empty($_POST)){
    //On affiche les playlist
    echo '<h1>Les Playlist de l\'utilisateur '.$user.'</h1>';
    echo '<section class="grille-titre">';
    while ($element = $reponse->fetch()){
        //On les affiches dans des boutons 
        echo '<article class="titre">';
        echo '<form action="rechercherPlaylist.php" method="post">';
        echo '<input type="submit" name="playlist" value="'.$element['nom'].'">';
        echo '</form>';
        echo '</article>';
    }
}

else{
    $reponse = $bdd->prepare('SELECT playlist.nom AS playlist, titre.nom, titre.artiste, titre.genre, titre.note FROM playlist, titre, appartient WHERE playlist.id = appartient.idPlaylist AND titre.id = appartient.idTitre AND playlist.nom = :playlist');
    $reponse->execute(array('playlist' => $_POST['playlist']));
    echo '<h1>Les Playlist de l\'utilisateur '.$user.'</h1>';
    echo '<section class="grille-titre">';
    //On affiche les titres de la playlist selectionnée
    echo '<h2>'.$_POST['playlist'].'</h2>';
    while ($element = $reponse->fetch()){
        //On affiche les titres de la playlist selectionnée
        echo '<article class="titre">';
        echo '<ul>';
        echo '<li>'.$element['nom'].' - '.$element['artiste'].' - '.$element['genre'].' - '.$element['note'].'/5</li>';
        echo '</ul>';
        echo '</article>';

    }
}

?>