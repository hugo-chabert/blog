<?php
$nomFichier = basename (__FILE__);
session_start();
require('fonctions/fonctionR.php');

select_categorie();
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
        <input type="text" id="txt_article" name="txt_article" placeholder="Créer un Article">
        <select name="article_categorie" id="article_categorie">
            <option value="">--Choisissez une catégorie d'article à ajouter--</option>
            <option value="Streetwear-Shoes">Streetwear-Shoes</option>
            <option value="BasketBall-Shoes">BasketBall-Shoes</option>
            <option value="Luxury-Shoes">Luxury-Shoes</option>
        </select>
        <input  type="submit" value="Envoyer"/>
    </form>
</body>
<?php require 'footer.php';?>
</html>
