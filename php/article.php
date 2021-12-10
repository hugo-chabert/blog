<?php
$nomFichier = basename (__FILE__);
require('fonctions/fonction.php');
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link href="../css/article.css" rel="stylesheet">
    <title>Article</title>
</head>
<?php require 'header.php';?>
<body>
<main>
    <div class="container">
        <?php $article = recup_article();?>
        <div id="styleTitre"><h1> <?php echo $article['article_name']; ?></h1></div>
        <div id="styleTitreTime"> <?php echo convert_time(); ?> </div>
        <div id='styleTitreCat'> Catégorie :  <?php echo $article['category_name'];?> </div>
        <div id='styleTitreCreateBy'> Créer par :  <?php echo $article['created_by'];?> </div>
    </div>
    <div class="kommeAnTher">
        <h3 class="styleTitre"> <?php disp_count(); ?>COMMENTAIRES</h3>
    </div>
    <?php  disp_com(); ?>
    <form method="post" >
        <?php new_com(); ?>
        <input  type="submit" name="envoyer" value="Envoyer"/>
    </form>
</main>
</body>
<?php require 'footer.php';?>
</html>