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
        <link href="../css/user.css" rel="stylesheet">
        <link href="../css/root.css" rel="stylesheet">
        <link href="../css/font.css" rel="stylesheet">
        <title>Modification des utilisateurs</title>
    </head>
    <body>
        <?php
            require 'header.php';
        ?>
        <main>
            <div class="container">
                <div class="table-button">
                    <div class="table">
                        <table>
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
                        <div class="createUser">
                            <a href='inscription-admin.php'> <button class = 'button4'> Creer un nouvel utilisateur</button></a>
                            <a href='admin.php'> <button class = 'button3'> Retour</button></a>
                        </div>
                    </div>
                    <div class="modif">
                        <div class="alone">
                            <h3>Modifier le rôle</h3>
                            <form class ='form-modif' action="" method="post">
                                <input class = 'modif-zone' type="text" name="login" placeholder="Entrez le login de l'utilisateur"/></br>
                                <select class = 'modif-zone' name="role_change">
                                    <option value="user">Utilisateur</option>
                                    <option value="modo">Modérateur</option>
                                </select></br>
                                <?php
                                    change_role();
                                ?>
                                <button class="button" type="submit" >Changer</button>
                            </form>
                        </div>
                        <div class="alone">
                            <h3>Changer le login d'un utilisateur</h3>
                            <form class ='form-modif' action="" method="post">
                                <input class = 'modif-zone' type="text" name="loginChange" placeholder="Entrez le login de l'utilisateur"/></br>
                                <input class = 'modif-zone' type="text" name="loginChangeN" placeholder="Entrez le nouveau login"/></br>
                                <?php
                                    change_login_user();
                                ?>
                                <button class="button" type="submit" >Changer</button>
                            </form>
                        </div>
                        <div class="alone">
                            <h3>Supprimer un utilisateur</h3>
                            <form class ='form-modif' action="" method="post">
                                <input class = 'modif-zone' type="text" name="loginSupp" placeholder="Entrez le login de l'utilisateur"/></br>
                                <?php
                                    delete_user();
                                ?>
                                <button class="button2" type="submit" >Supprimer</button>
                            </form>
                        </div>
                        <div class="alone">
                            <h3>Changer l'Email d'un utilisateur</h3>
                            <form class ='form-modif' action="" method="post">
                                <input class = 'modif-zone' type="text" name="emailChange" placeholder="Entrez l'Email de l'utilisateur"/></br>
                                <input class = 'modif-zone' type="text" name="emailChangeN" placeholder="Entrez le nouvel Email"/></br>
                                <?php
                                    change_email_user();
                                ?>
                                <button class="button" type="submit" >Changer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php
            require 'footer.php';
        ?>
    </body>
    <?php  ob_end_flush();?>
</html>