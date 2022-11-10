
<html>
    <script type="text/javascript" src="../script/outils.js"></script>
    <link rel="stylesheet" href="../style/notification.css">
    <div id='test'>salut</div>
</html>

<?php
include('outils.php');
if (!estAdmin()){
    header('Location:connexion.php');
}

else{
    notifier("Vous êtes connecté en tant qu'administrateur", "#FF0000");
}

?>