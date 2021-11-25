<?php $nomFichier = basename (__FILE__); ?>
<!DOCTYPE html>
<html >
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Création d'article</title>
    </head>
    <body>
        <?php
            require 'header.php';
        ?>
        <main>
            <form action="" method="post">
                <select name="style" id="style">
                    <option value="choix" class="Choix">---Choisissez la catégorie de votre article---</option>
                    <option value="style1" class="Choix">Streetwear-Shoes</option>
                    <option value="style2" class="Choix">BasketBall-Shoes</option>
                    <option value="style3" class="Choix">Luxury-Shoes</option>
                </select>
                <br>
                <br>
                <label for="article"></label><br/>
                <textarea name="article" id="article" placeholder = 'Ecrivez votre article'></textarea>
                <input type="submit" value="Send">
            </form>
        </main>
        <?php
            require 'footer.php';
        ?>
    </body>
</html>