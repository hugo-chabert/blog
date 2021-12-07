<?php
$nomFichier = basename (__FILE__);
session_start();
require('fonctions/fonctionR.php');
verif_admin_modo();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Creer Article</title>
        <link rel="stylesheet" href="../css/creation.css">
        <link rel="stylesheet" href="../css/root.css">
        <link rel="stylesheet" href="../css/font.css">
    </head>
    <body>
        <?php require 'header.php';?>
        <main>
            <div class="container">
                <div class="box-form">
                    <h1>Impressionnez nous en ecrivant votre plus bel article !!</h1>
                    <form class ='form' method="post">
                        <input type="text" name="nom_article" placeholder="Titre de l'Article">
                        <select name="cat">
                            <option value="choose" name="choose">-Choisissez une catégorie-</option>
                            <?php  $value = auto_list();?>
                        </select>
                        <textarea type="textarea" name="txt_article" placeholder="Description de l'Article"></textarea>
                        <?php create_article(); ?>
                        <div class="annuler-submit">
                            <button class = 'button' type="submit" name="envoyer"> Créer l'article</button>
                            <button class = 'button'><a href="profil.php"> Annuler</a></button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    <?php require 'footer.php';?>
    </body>
</html>
