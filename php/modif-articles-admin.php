<?php
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
                                <input class = 'input-modif' type="text" name="articleModifName" placeholder="Entrez le nom de l'article"/></br>
                                <input class = 'input-modif' type="text" name="articleModif" placeholder="Entrez le nouveau contenu de l'article"/></br>
                                <button class="button" type="submit">Modifier</button>
                            </form>
                            <?php
                                modif_article();
                            ?>
                        </div>
                        <div class="alone2">
                            <h3>Modifier le nom d'un article</h3>
                            <form class ='form-cat' action="" method="post">
                                <input class = 'input-modif' type="text" name="articleChange" placeholder="Entrez le nom de l'article"/></br>
                                <input class = 'input-modif' type="text" name="articleChangeN" placeholder="Entrez le nouveau nom"/></br>
                                <button class="button" type="submit">Modifier</button>
                            </form>
                            <?php
                                change_article_nom();
                            ?>
                        </div>
                        <div class="alone2">
                            <h3>Supprimer un article</h3>
                            <form class ='form-cat' action="" method="post">
                                <input class = 'input-modif' type="text" name="articleDelete" placeholder="Entrez le nom de l'article"/></br>
                                <button class="button" type="submit">Supprimer</button>
                            </form>
                            <?php
                                delete_article();
                            ?>
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
</html>