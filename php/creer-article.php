<?php
$nomFichier = basename (__FILE__);
session_start();
require('fonctions/fonctionR.php');
$bdd = connect_database();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creer Article</title>
</head>
<?php require 'header.php';?>
<body>
    <form method="post">
        <input type="text" name="txt_article" placeholder="Créer un Article">
        <select name="categories">
            <option value="">--Choisissez une catégorie d'article à ajouter--</option>
            <?php  auto_list()?>
        </select>
        <input  type="submit" name="envoyer" value="Envoyer"/>
    </form>
    <?php  create_article()?>
</body>
<?php require 'footer.php';?>
</html>
