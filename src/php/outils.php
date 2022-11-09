<?php
include('db.php');
session_start();

//Insert un code d'erreur dans la page HTML dans la div d'id "erreur"
function error($message) {
    echo '<script type="text/javascript">document.getElementById("error").innerHTML ="'. $message . '" ;</script>';      
}




/*Cette fonction génère un code aléatoire et l'envoie par mail à l'utilisateur dont l'adresse mail est passée en paramètre
*puis renvoie le code généré pour pouvoir le comparer avec celui entré par l'utilisateur*/
function envoyerCodeMail($mail){
    $code = rand(100000, 999999);
    $subject = "Code de vérification";
    $message = "Voici votre code de vérification : " . $code;
    echo $code;
    //mail($mail.'@etud.univ-pau.fr', $subject, $message);
    return $code;


}


?>