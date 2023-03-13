<?php
require_once 'baseDeDonnees.php';
if(!isset($_SESSION)){
    session_start();
}
if (isset($_SESSION['message'])){
    notifier($_SESSION['message'][0], $_SESSION['message'][1]);
    unset($_SESSION['message']);
}

interdireVisiteur();

//Insert un code d'erreur dans la page HTML dans la div d'id "erreur"
function error($message) {
    echo '<script type="text/javascript">document.getElementById("error").innerHTML ="'. $message . '" ;</script>';      
}

function genererCode($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


/*Cette fonction génère un code aléatoire et l'envoie par mail à l'utilisateur dont l'identifiant est passée en paramètre
*puis renvoie le code généré pour pouvoir le comparer avec celui entré par l'utilisateur*/
function envoyerCodeMail($login){
    $code = genererCode(6);
    $subject = "Code de vérification";
    $message = "Voici votre code de vérification : " . $code;
    envoyerUnMail($login, $subject, $message);
    return $code;


}
/*Cette fonction permet d'envoyer un mail à l'utilisateur dont l'identifiant,le sujet et le message passés en paramètre*/
function envoyerUnMail($login, $sujet, $message){
    $mail=$login;
    if ($login=='hegoberria'){$mail=$login."64@gmail.com";}
    else {$mail=$login."@iutbayonne.univ-pau.fr";}
    mail($mail, $sujet, $message);
}

function verifUtilisateur($user){
    //retourne les informations de l'utilisateur
    global $database;
    $req = $database->prepare('SELECT * FROM utilisateur WHERE login = ?');
    $req->execute(array($user));
    return $req->fetch();
}




function estConnecte(){
    //retourne true si l'utilisateur est connecté
    if (isset($_SESSION['user'])){
        return true;
    }
    else{
        return false;
    }
}






function notifier($message,$rgb="#333",$time=3000){
    //affiche un message dans la page
    $injection = '<section id="injection"><script type="text/javascript" src="../script/outils.js"></script>
          <link rel="stylesheet" href="../style/notification.css">
          <div id="notif">'."$message".'</div>
          <script>notification("'.$rgb.'","'.$time.'")</script></section>';
    echo $injection;
}

function interdireVisiteur(){
    //Interdit cette page au visiteurs
    if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
        //on redirige vers la page d'accueil
        header('Location:accueil.php');
    }
}
?>