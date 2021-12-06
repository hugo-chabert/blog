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
        <title>Admin</title>
    </head>
    <body>
        <?php
            require 'header.php';
        ?>
        <main>
            <div class="container">
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
                <div class="Texts">
                    <div>
                        <a href='modif-user-admin.php'>Gestion des utilisateurs</a>
                    </div>
                    <div>
                        <a href='modif-cat-admin.php'>Gestion des catégories</a>
                    </div>
                </div>
            </div>
        </main>
        <?php
            require 'footer.php';
        ?>
    </body>
</html>