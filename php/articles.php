<?php
$nomFichier = basename (__FILE__);
require ('fonctions/fonction.php');
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/articles.css">
        <link rel="stylesheet" href="../css/font.css">
        <link rel="stylesheet" href="../css/root.css">
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <title>Articles</title>
    </head>
    <body>
        <?php require 'header.php'; ?>
        <main>
            <div class="Container">
                <div class="box-articles-page">
                    <div class="box-articles">
                        <?php
                        $recup = Recup_articles();
                        ?>
                    </div>
                    <div class="box-page">
                        <?= pagination(); ?>
                    </div>
                </div>
            </div>
        </main>
        <?php require 'footer.php';?>
    </body>
    <script>
        AOS.init();
    </script>
</html>
