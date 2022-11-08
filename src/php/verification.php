<?php
include('db.php');
session_start();
// Si le formulaire a été envoyé
//INSERER LE MESSAGE DE CONFIRMATION ICI
//on genere un code de verification


echo "Un code de vérification a été envoyé<br>";
echo "Veuillez entrer le code de vérification ci-dessous : ";
echo "<form action='verification.php' method='post'>";
echo "<input type='text' name='code' placeholder='Code de vérification'>";
echo "<input type='submit' value='Valider'>";
echo "</form>";

//on envoie le code par mail
// $to = $_SESSION['mail'];
// $subject = "Code de vérification";
// $message = "Voici votre code de vérification : " . $code;
// mail($to.'@etud.univ-pau.fr', $subject, $message, $headers);
echo "le code est : " . $_SESSION['code'];


//on verifie que le code est correct
if (isset($_POST['code'])){
    if ($_POST['code'] == $_SESSION['code']){
        //on actualise le mot de passe de l'utilisateur dans la table utilisateur
        $req = $database->prepare('UPDATE Utilisateur SET password = ? WHERE login = ?');
        $req->execute(array($_SESSION['password'], $_SESSION['mail']));


        //on redirige vers la page de connexion
        header('Location: ../html/connexion.html');
    }
    else{
        echo "Le code de vérification est incorrect";
    }
}





//on hash le mot de passe

// $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
//on ajoute l'utilisateur dans la base de données
                // $req = $database->prepare('UPDATE Utilisateur SET password = ? WHERE login = ?');

                // $req->execute(array($password,$_POST['mail']));
                // echo 'Votre compte a bien été créé';

?>
