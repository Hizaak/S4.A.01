<?php
include 'outils.php';
if (!estAdmin()) {
    header('Location:connexion.php');
}


//Tout les type de fichier csv accepté
$csvMimes = array(
    'text/csv',
    'text/plain',
    'application/csv',
    'text/comma-separated-values',
    'application/excel',
    'application/vnd.ms-excel',
    'application/vnd.msexcel',
    'text/anytext',
    'application/octet-stream',
    'application/txt',
);

$form = "<form name='form' method=\"POST\" enctype=\"multipart/form-data\" id=\"upload\">
<h2>Choisissez un fichier CSV<br>ou<br>Glissez le ici</h2>
<label class=\"btn-file\">
    <input type=\"file\" name=\"file\" multiple=\"multiple\" accept=\".csv,.txt\" id=\"btnZone\" onchange=\"test()\">
</label>
</form>";



if (!empty($_FILES)) {
    //Vérifiez si le type de fichier téléchargé est dans la liste des types de fichiers CSV
    //le type de fichier n'est pas valide
    if (!in_array($_FILES['file']['type'], $csvMimes)) {
        notifier('Veuillez télécharger un fichier CSV valide.', '#AA0000');
        echo $form;
    }

    //
    else {
        $fichier = fopen($_FILES['file']['tmp_name'], 'r');
        echo "<table>";
        echo "<tr>
                <th>login</th>
                <th>prenom</th>
                <th>nom</th>
                <th>TD</th>
                <th>TP</th>
                <th>année</th>
            </tr>
            ";
        while (($line = fgetcsv($fichier, 0, ";")) !== FALSE) {
            //on foreach sur la ligne
            echo "<tr>";
            foreach ($line as $key => $value) {
                //on supprime les espaces
                echo "<td>" . $value . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";


        fclose($fichier);
    }
} else {
    echo $form;
}




?>

<html>

<head>
    <meta charset="utf-8">
    <title>Importation des étudiants</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/styleUpload.css">
</head>
<main>
</main>

</html>

<script>
    function test() {
        document.form.submit()
    }
</script>