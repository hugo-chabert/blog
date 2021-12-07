<?php
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
        <link href="../css/admin.css" rel="stylesheet">
        <title>Modification des catégories</title>
    </head>
    <body>
        <?php
            require 'header.php';
        ?>
        <main>
            <div class="containerCAT">
                <table class="tableau">
                    <tr>
                        <th>Catégories</th>
                    </tr>
                    <tr><?php
                        foreach($Cate as $C){
                            echo '<tr><td>'.$C['nom'].'</td>';
                        }?>
                    </tr>
                </table>
                <div class="modif">
                    <div class="alone2 modifGD">
                        Creer une catégorie
                        <form action="" method="post">
                            <input type="text" name="categorieCreate" placeholder="Entrez le nom de la catégorie"/></br>
                            <input class="button" type="submit" value="Creer"/>
                        </form>
                        <?php
                            create_categorie();
                        ?>
                    </div>
                    <div class="alone2 modifGD">
                        Modifier une catégorie
                        <form action="" method="post">
                            <input type="text" name="categorieChange" placeholder="Entrez le nom de la catégorie"/></br>
                            <input type="text" name="categorieChangeN" placeholder="Entrez le nouveau nom"/></br>
                            <input class="button" type="submit" value="Modifier"/>
                        </form>
                        <?php
                            change_categorie();
                        ?>
                    </div>
                    <div class="alone2 modifGD">
                        Supprimer une catégorie
                        <form action="" method="post">
                            <input type="text" name="categorieDelete" placeholder="Entrez le nom de la catégorie"/></br>
                            <input class="button" type="submit" value="Supprimer"/>
                        </form>
                        <?php
                            delete_categorie();
                        ?>
                    </div>
                </div>
            </div>
        </main>
        <?php
            require 'footer.php';
        ?>
    </body>
</html>