<?php
$nomFichier = basename (__FILE__);
require ('fonctions/fonction.php');
session_start();
if(isset($_GET['page']) && !empty($_GET['page'])){
    $currentPage = (int) strip_tags($_GET['page']);
}
else{
    $currentPage = 1;
}
$Bdd = connect_database();
$sql_count = "SELECT COUNT(*) AS nb_articles FROM articles";
$requete_count = mysqli_query($Bdd, $sql_count);
$fetch_count = mysqli_fetch_assoc($requete_count);
$nbArticles = (int) $fetch_count['nb_articles'];
$parPage = 5;
// ! ceil Arrondit au nombre supérieur
$pages = ceil($nbArticles / $parPage);
$premier = ($currentPage * $parPage) - $parPage;
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
        <title>Articles</title>
    </head>
    <body>
        <?php require 'header.php'; ?>
        <main>
            <div class="Container">
                <div class="box-articles-page">
                    <div class="box-articles">
                        <?php
                        $recup = Recup_articles2();
                        ?>
                        <nav>
                    <ul class="pagination">
                        <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
                        <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                            <a href="./articles.php?page=<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
                        </li>
                        <?php for($page = 1; $page <= $pages; $page++): ?>
                        <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                        <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                                <a href="./articles.php?page=<?= $page ?>" class="page-link"><?= $page ?></a>
                            </li>
                        <?php endfor ?>
                        <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                        <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                            <a href="./articles.php?page=<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
                        </li>
                    </ul>
                </nav>
                    </div>
                    <div class="box-page">

                    </div>
                </div>
            </div>
        </main>
        <?php require 'footer.php';?>
    </body>
</html>
