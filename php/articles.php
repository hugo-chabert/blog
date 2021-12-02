<?php
$nomFichier = basename (__FILE__);
require ('fonctions/fonctionF.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/articles.css">
        <link rel="stylesheet" href="../css/font.css">
        <link rel="stylesheet" href="../css/root.css">
        <title>Articles</title>
    </head>
    <body>
        <?php require 'header.php'; ?>
        <main>
            <div class="Container">
                <div class="box-articles-page">
                    <div class="box-articles">
                        <?php
                        Recup_articles();
                        ?>
                    </div>
                    <div class="box-page">

                    </div>
                </div>
            </div>
        </main>
        <?php require 'footer.php';?>
    </body>
</html>
