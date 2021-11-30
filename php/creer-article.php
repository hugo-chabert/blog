<?php
$nomFichier = basename (__FILE__);
session_start();
require('fonctions/fonctionR.php');
$bdd = connect_database();
$sql = mysqli_query($bdd, "SELECT * FROM categories");
$row2 = mysqli_fetch_all($sql, MYSQLI_ASSOC);
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
            <?php  foreach ($row2 as  $value) {
                    echo "<option value=".$value["nom"]." name=".$value["id"]." >" .$value["nom"]. "</option>";
            }?>
        </select>
        <input  type="submit" name="envoyer" value="Envoyer"/>
    </form>
</body>
<?php require 'footer.php';?>
</html>
