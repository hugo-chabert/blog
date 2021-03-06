<?php
ob_start();
session_start();
$nomFichier = basename (__FILE__);
require('fonctions/fonction.php');

verif_admin();
$bdd = connect_database();
$requeteUser = mysqli_query($bdd, "SELECT * FROM utilisateurs INNER JOIN droits WHERE utilisateurs.id_droits = droits.id");
$Users = mysqli_fetch_all($requeteUser, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="../css/cat.css" rel="stylesheet">
        <link href="../css/root.css" rel="stylesheet">
        <link href="../css/font.css" rel="stylesheet">
        <title>Modification des articles</title>
    </head>
    <body>
        <?php
            require 'header.php';
        ?>
        <main>
            <div class="container">
                <div class="table-button-button">
                    <div class="table-button">
                        <table>
                            <tr>
                                <th>ID de l'Article</th>
                                <th>Articles</th>
                                <th>Catégorie</th>
                            </tr>
                            <tr>
                                <?php
                                show_article_admin();
                                ?>
                            </tr>
                        </table>
                    </div>
                    <div class="modif">
                        <div class="alone2">
                            <h3>Modifier un article</h3>
                            <form class ='form-cat' action="" method="post">
                                <input class = 'input-modif' type="text" name="articleModifName" placeholder="Entrez l'id de l'article"/></br>
                                <textarea class = 'input-modif' type="text" name="articleModif" placeholder="Entrez le nouveau contenu de l'article"></textarea></br>
                                <?php
                                    modif_article();
                                ?>
                            <button class="button" type="submit">Modifier</button>
                            </form>
                        </div>
                        <div class="alone2">
                            <h3>Modifier le nom d'un article</h3>
                            <form class ='form-cat' action="" method="post">
                                <input class = 'input-modif' type="text" name="articleChange" placeholder="Entrez l'id de l'article"/></br>
                                <input class = 'input-modif' type="text" name="articleChangeN" placeholder="Entrez le nouveau nom"/></br>
                                <?php
                                    change_article_nom();
                                ?>
                                <button class="button" type="submit">Modifier</button>
                            </form>
                        </div>
                        <div class="alone2">
                            <h3>Supprimer un article</h3>
                            <form class ='form-cat' action="" method="post">
                                <input class = 'input-modif' type="text" name="articleDelete" placeholder="Entrez l'id de l'article"/></br>
                                <?php
                                    delete_article();
                                ?>
                                <button class="button" type="submit">Supprimer</button>
                            </form>
                        </div>
                        <div class="button-cancel">
                            <a href="admin.php"><button class='button2'>Retour</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php
            require 'footer.php';
        ?>
    </body>
    <?php ob_end_flush(); ?>
</html>