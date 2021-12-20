<?php
ob_start();
$nomFichier = basename (__FILE__);
require('fonctions/fonction.php');
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link href="../css/article.css" rel="stylesheet">
    <link href="../css/font.css" rel="stylesheet">
    <link href="../css/root.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <title>Article</title>
</head>
<?php require 'header.php';?>
<body>
<main>
    <div class ="container">
        <div class="containALL">
            <div class="containerArticle"data-aos="zoom-in" data-aos-duration="1000">
                <?php $article = recup_article();?>
                <div id="styleTitre"><h1> <?php echo $article['article_name']; ?></h1></div>
                <div id="styleTitreTime"> <?php echo convert_time(); ?> </div>
                <div id='styleTitreCat'> Catégorie :  <?php echo $article['category_name'];?> </div>
                <div id='styleTitreCreateBy'> Créer par :  <?php echo $article['created_by'];?> </div>
            </div>
            <div class = 'all' data-aos="zoom-in" data-aos-duration="2000" >
                <?php display_article();recup_article(); ?>
            </div>
            <div class="commentaires" data-aos="zoom-in" data-aos-duration="3000">
                <h3 class="styleTitreCom"> <?php disp_count(); ?>COMMENTAIRES</h3>
                <?php  disp_com(); ?>
            </div>
            <form method="post" data-aos="zoom-in" data-aos-duration="2000">
                <?php new_com(); ?>
                <button class = 'button' type="submit" name="envoyer"> Envoyer </button>
            </form>
        </div>
    </div>
</main>
</body>
<script>
        AOS.init();
</script>
<?php require 'footer.php';?>
<?php ob_end_flush();?>
</html>