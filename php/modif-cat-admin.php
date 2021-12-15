<?php
ob_start();
session_start();
$nomFichier = basename (__FILE__);
require('fonctions/fonction.php');

verif_admin();
$bdd = connect_database();
$requeteUser = mysqli_query($bdd, "SELECT * FROM utilisateurs INNER JOIN droits WHERE utilisateurs.id_droits = droits.id");
$Users = mysqli_fetch_all($requeteUser, MYSQLI_ASSOC);
$requeteCate = mysqli_query($bdd, "SELECT * FROM categories");
$Cate = mysqli_fetch_all($requeteCate, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="../css/cat.css" rel="stylesheet">
        <link href="../css/root.css" rel="stylesheet">
        <link href="../css/font.css" rel="stylesheet">
        <title>Modification des catégories</title>
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
                                <th>Catégories</th>
                            </tr>
                            <tr><?php
                                foreach($Cate as $C){
                                    echo '<tr><td>'.$C['nom'].'</td>';
                                }?>
                            </tr>
                        </table>
                    </div>
                    <div class="modif">
                        <div class="alone2">
                            <h3>Creer une catégorie</h3>
                            <form class ='form-cat' action="" method="post">
                                <input class = 'input-modif' type="text" name="categorieCreate" placeholder="Entrez le nom de la catégorie"/></br>
                                <button class="button" type="submit"> Creer </button>
                            </form>
                            <?php
                                create_categorie();
                            ?>
                        </div>
                        <div class="alone2">
                            <h3>Modifier une catégorie</h3>
                            <form class ='form-cat' action="" method="post">
                                <input class = 'input-modif' type="text" name="categorieChange" placeholder="Entrez le nom de la catégorie"/></br>
                                <input class = 'input-modif' type="text" name="categorieChangeN" placeholder="Entrez le nouveau nom"/></br>
                                <button class="button" type="submit">Modifier</button>
                            </form>
                            <?php
                                change_categorie();
                            ?>
                        </div>
                        <div class="alone2">
                            <h3>Supprimer une catégorie</h3>
                            <form class ='form-cat' action="" method="post">
                                <input class = 'input-modif' type="text" name="categorieDelete" placeholder="Entrez le nom de la catégorie"/></br>
                                <button class="button" type="submit">Supprimer</button>
                            </form>
                            <?php
                                delete_categorie();
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
    <?php ob_end_flush();?>
</html>