<?php
include('baseDeDonnees.php');
if(!isset($_SESSION)){
    session_start();
}

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
    mail($mail.'@iutbayonne.univ-pau.fr', $subject, $message);
    return $code;


}

function verifUtilisateur($user){
    //retourne les informations de l'utilisateur
    global $database;
    $req = $database->prepare('SELECT * FROM Utilisateur WHERE login = ?');
    $req->execute(array($user));
    return $req->fetch();
}


?>