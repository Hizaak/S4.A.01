<?php
include_once 'Utilisateur.php';
include_once 'outils.php';

#include 'baseDeDonnees.php';
if(!isset($_SESSION['user']) || !$_SESSION['user']->estAdmin()){
    header('Location:../index.php');
}

//Si on on a cliqué sur le bouton enregistrer
if (isset($_POST['ins_mod'])||isset($_POST['loginChange'])||isset($_POST['del'])){
    //Si ins_mod
    //0: login, 1: prenom, 2: nom, 3: niveau

    //Si loginChange
    //0: ancien login, 1: nouveau login, 2: prenom, 3: nom, 4: niveau

    //Si del
    //0: login

    $listerreur=array();
    //On commence par modifier ou créer les étudiants qui n'on pas changé de login
    //Si il ya des choses dans ins_mod
    if(isset($_POST['ins_mod'])){
        foreach ($_POST['ins_mod'] as $key => $value) {
            $error=false;
            //On envele tous les tags html eventuels en parcourant le tableau
            for ($i=0; $i < count($value); $i++) { 
                $value[$i]=strip_tags($value[$i]);
                //Si value[i] est vide on met le flag à true
                if ($value[$i]==""){
                    $error=true;
                }
            }
            $req=$database->prepare("SELECT * FROM utilisateur WHERE login=:login");
            $req->execute(array("login"=>$value[0]));
            try{
                if ($req->rowCount()==0){
                    $req=$database->prepare("INSERT INTO utilisateur (login, prenom, nom, niveau) VALUES (:login, :prenom, :nom, :niveau)");
                    $req->execute(array("login"=>$value[0],"prenom"=>$value[1],"nom"=>$value[2],"niveau"=>$value[3]));
                }
                else{
                    $req=$database->prepare("UPDATE utilisateur SET prenom=:prenom, nom=:nom, niveau=:niveau WHERE login=:login");
                    $req->execute(array("login"=>$value[0],"prenom"=>$value[1],"nom"=>$value[2],"niveau"=>$value[3]));
                }
            }
            catch (Exception $e){
                $listerreur[]=($value[0]." ".$e);

            }
        }
    }
    //On modifie les étudiants qui ont changé de login
    if(isset($_POST['loginChange'])){
        foreach ($_POST['loginChange'] as $key => $value) {
            $error=false;
            //On envele tous les tags html eventuels en parcourant le tableau
            for ($i=0; $i < count($value); $i++) { 
                $value[$i]=strip_tags($value[$i]);
                //Si value[i] est vide on met le flag à true
                if ($value[$i]==""){
                    $error=true;
                }
            }
            $req=$database->prepare("SELECT * FROM utilisateur WHERE login=:login");
            $req->execute(array("login"=>$value[0]));
            if($req->rowCount()!=0 && !$error){
                try{
                    $req=$database->prepare("UPDATE utilisateur SET login=:login, prenom=:prenom, nom=:nom, niveau=:niveau WHERE login=:ancienlogin");
                    $req->execute(array("login"=>$value[1],"prenom"=>$value[2],"nom"=>$value[3],"niveau"=>$value[4],"ancienlogin"=>$value[0]));
                }
                catch (Exception $e){
                    $listerreur[]=($value[0]);

                }
            }
            else{
                $listerreur[]=$value[0];
            }
        }
    }
    //On supprime les étudiants qui ont été supprimés
    if(isset($_POST['del'])){
        foreach ($_POST['del'] as $key => $value) {
            //On envele tous les tags html eventuels en parcourant le tableau
            $error=false;
            for ($i=0; $i < count($value); $i++) { 
                $value[$i]=strip_tags($value[$i]);
                //Si value[i] est vide on met le flag à true
                if ($value[$i]==""){
                    $error=true;
                }
            }
            $req=$database->prepare("SELECT * FROM utilisateur WHERE login=:login");
            $req->execute(array("login"=>$value[$key]));
            if($req->rowCount()!=0){
                $req=$database->prepare("DELETE FROM utilisateur WHERE login=:login");
                $req->execute(array("login"=>$value[$key]));
            }
            else{
                $listerreur[]=($value[0]);
            }
        }
    }
    if (count($listerreur)==0){
        echo "ok";

    }
    else{
        //On renvois les logins qui n'ont pas pu être importés sous forme de json
        print_r(json_encode($listerreur));
    }
    exit();
    }


?>

<html>

<head>
    <meta charset="utf-8">
    <title>Importation des étudiants</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="stylesheet" href="../style/styleUpload.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
</head>
<main>
    <section id="achanger">
        <h2>Importation des étudiants</h2>
        <input id="btn-save" type="button" value="Enregistrer">

    </section>
    <div class="scroll">
        <table id="table-etudiant">
            <tr>
                <th class="header"><input type="checkbox" class="select-all-cb" name="select-all" id="select-all"></th>
                <th class="header">Identifiant</th>
                <th class="header">Prénom</th>
                <th class="header">Nom</th>
                <th class="header">Année</th>
                <th class="header"></th>
            </tr>
            <?php
            $req=$database->query("SELECT * FROM utilisateur WHERE ROLE='user' ORDER BY NIVEAU");
            while ($ligne=$req->fetch()){
                echo "<tr>";
                echo '<td class="select"><input type="checkbox" class="select-cb" name="check"></td>';
                echo "<td class=\"info login\" data-old=".$ligne['LOGIN'].">".$ligne['LOGIN']."</td>";
                echo "<td class=\"info prenom\" data-old=".$ligne['PRENOM'].">".$ligne['PRENOM']."</td>";
                echo "<td class=\"info nom\" data-old=".$ligne['NOM'].">".$ligne['NOM']."</td>";
                echo "<td class=\"info niveau\" data-old=".$ligne['NIVEAU'].">".$ligne['NIVEAU']."</td>";
                echo '<td class="edit"><button class="btn-edit" onchange=edit_line()>Editer</button></td>';
                echo "</tr>";
            }
            ?>
        </table>
    </div>
    <section class="feedback">
        <span id="error"></span>
    </section>
    <section class="action">
        <button id="btn-delete" disabled>Supprimer</button>
        <button id="btn-add" >Ajouter</button>
        <div class="upload">
            <input type="file" name="file" multiple="multiple" accept=".csv,.txt" id="btnZone">
        </div>
    <section 

</main>
</html>
<script src="../script/importEtudiant.js"></script>