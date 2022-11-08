<?php
include('db.php');
session_start();

//Insert un code d'erreur dans la page HTML dans la div d'id "erreur"
function error($message) {
    echo '<script type="text/javascript">document.getElementById("error").innerHTML ="'. $message . '" ;</script>';      
}

function envoyerCodeMail($mail,){
    $code = rand(100000, 999999);
    $_SESSION['code'] = $code;
    $to = $_SESSION['mail'];
    $subject = "Code de vérification";
    $message = "Voici votre code de vérification : " . $code;
    mail($to.'@etud.univ-pau.fr', $subject, $message);


}


?>