
<html>
    <script type="text/javascript" src="../script/outils.js"></script>
    <link rel="stylesheet" href="../style/notification.css">
    <div id='test'>salut</div>
</html>

<?php
include('outils.php');
if (!estAdmin($_SESSION['login'])){
    header('Location:connexion.php');
}

else{
    notifier("loremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremloremlorem","#FF0000");
}

?>