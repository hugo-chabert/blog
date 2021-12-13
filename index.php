<?php
$nomFichier = basename (__FILE__);
session_start();
require('php/fonctions/fonction.php');
$place = 0;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/index.css" rel="stylesheet">
        <link href="css/root.css" rel="stylesheet">
        <link href="css/font.css" rel="stylesheet">
        <title>Accueil</title>
    </head>
    <body>
        <?php
            require 'php/header.php';
        ?>
        <main>
            <div class="header1">
                <div class="info">
                    <h1>Bienvenue<br>chez<br>Addict N' Shoes</h1>
                </div>
            </div>
            <div class="content">
                <h1> <a class = 'link-article' href="#content-article"> Actualites </a></h1>
                <div id = 'content-article' class="contentArticle">
                    <div class="article">
                        <img class = 'imgArticleIndex' src="http://cdn.shopify.com/s/files/1/0496/4325/8009/products/baskets-air-jordan-1-retro-high-og-sp-travis-scott-fragment-military-blue-air-jordan-kikikickz-604686_1200x1200.jpg?v=1626432662" alt="TS Aj1" width = '104%'>
                        <p class="textArticle">
                        <?php recup_article_index(0); ?>
                        </p>
                        <button class="glow" type="button"><b>Lire la suite</b></button>
                    </div>
                    <div class="article2">
                        <img class = 'imgArticleIndex' src="https://www.sneakerstyle.fr/wp-content/uploads/2020/06/off-white-x-air-jordan-4-wmns-sail-CV9388-100.jpg" alt="OW AJ4" width = '100%'>
                        <p class="textArticle">
                        <?php recup_article_index(1); ?>
                        </p>
                        <button class="glow" type="button"><b>Lire la suite</b></button>
                    </div>
                    <div class="article3">
                    <img class = 'imgArticleIndex' src="https://mivintagelabel.com/wp-content/uploads/2020/10/Air-Jordan-1-x-Dior-2.jpg" alt="OW AF1" width = '94%'>
                        <p class="textArticle">
                        <?php recup_article_index(2); ?>
                        </p>
                        <button class="glow" type="button"><b>Lire la suite</b></button>
                    </div>
                </div>
            </div>
        </main>
        <?php
        require 'php/footer.php';
        ?>
    </body>
</html>
