<?php
$nomFichier = basename (__FILE__);
session_start();
require('fonctions/fonction.php');

verif_admin_modo();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Creer Article</title>
</head>
<?php require 'header.php';?>
<body>
    <form method="post">
        <input type="textarea" name="txt_article" placeholder="Description de l'article">
        <input type="text" name="nom_article" placeholder="Nom de l'article">
        <select name="cat">
            <option value="choose" name="choose">--Choisissez une catégorie d'article à ajouter--</option>
            <?php  $value = auto_list();?>
        </select>
        <input  type="submit" name="envoyer" value="Envoyer"/>
    </form>
    <?php  create_article();?>
</body>
<?php require 'footer.php';?>
</html>
