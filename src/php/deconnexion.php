<?php
//On deconnecte le user
include_once "outils.php";
session_destroy();
//On le redirige vers la page d'accueil
header('Location:../index.php');



?>