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
    <title>Article</title>
</head>
<?php require 'header.php';?>
<body>
<main>
    <div class ="container">
        <div class="containALL">
            <div class="containerArticle">
                <?php $article = recup_article();?>
                <div id="styleTitre"><h1> <?php echo $article['article_name']; ?></h1></div>
                <div id="styleTitreTime"> <?php echo convert_time(); ?> </div>
                <div id='styleTitreCat'> Catégorie :  <?php echo $article['category_name'];?> </div>
                <div id='styleTitreCreateBy'> Créer par :  <?php echo $article['created_by'];?> </div>
            </div>
            <div>
                <?php recup_article(); ?>
            </div>
            <div class="commentaires">
                <h3 class="styleTitreCom"> <?php disp_count(); ?>COMMENTAIRES</h3>
                <?php  disp_com(); ?>
            </div>
            <form method="post" >
                <?php new_com(); ?>
                <button class = 'button' type="submit" name="envoyer"> Envoyer </button>
            </form>
        </div>
    </div>
</main>
</body>
<?php require 'footer.php';?>
<?php ob_end_flush();?>
</html>