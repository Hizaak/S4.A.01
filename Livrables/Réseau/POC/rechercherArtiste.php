<?php
include 'bd.php';
//On fait un input du nom d'un titre
//On affiche le titre et les playlist qui le contiennent
echo '<a href="index.php">Retour</a>';
//On affiche un input pour rechercher un chanteur


if (empty($_POST)){
    echo '<form action="rechercherArtiste.php" method="post">';
    echo '<input type="text" name="artiste" placeholder="Rechercher un artiste">';
    echo '<input type="submit" value="Rechercher">';
    echo '</form>';
}

else{
    //On recupere le titre de la base de données qui resemble à l'input
    $reponse = $bdd->prepare('SELECT * FROM titre WHERE artiste like :artiste');
    $reponse->execute(array('artiste' => '%'.$_POST['artiste'].'%'));
    echo '<h1>Resulat de la recherche de titre de  '.$user.'</h1>';
    echo '<section class="grille-titre">';
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