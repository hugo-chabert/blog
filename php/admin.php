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
        <link href="../css/root.css" rel="stylesheet">
        <link href="../css/font.css" rel="stylesheet">
        <title>Admin</title>
    </head>
    <body>
        <?php
            require 'header.php';
        ?>
        <main>
            <div class="Container">
                <div class="container-tab">
                    <div class="Tabs">
                        <table class="table1">
                            <tr>
                                <th>Login</th>
                                <th>Email</th>
                                <th>Rôle</th>
                            </tr>
                            <tr><?php
                                foreach($Users as $User){
                                    echo '<tr><td>'.$User['login'].'</td>';
                                    echo '<td>'.$User['email'].'</td>';
                                    echo '<td>'.$User['nom'].'</td>';
                                }?>
                            </tr>
                        </table>
                        <table class="table2">
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
                    <div class="button-gestion">
                        <div>
                            <a href='modif-user-admin.php'> <button class ='button'> Gestion des utilisateurs </button></a>
                        </div>
                        <div>
                            <a href='modif-articles-admin.php'><button class ='button'> Gestion des articles </button></a>
                        </div>
                        <div>
                            <a href='modif-cat-admin.php'><button class ='button'> Gestion des catégories </button></a>
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