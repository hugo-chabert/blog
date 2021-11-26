<?php
session_start();
$nomFichier = basename (__FILE__);
require('fonctions/fonctionH.php');

verif_admin();
$bdd = connect_database();
$requete = mysqli_query($bdd, "SELECT * FROM utilisateurs INNER JOIN droits WHERE utilisateurs.id_droits = droits.id");
$Users = mysqli_fetch_all($requete, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="../css/admin.css" rel="stylesheet">
        <link href="../css/inscription.css" rel="stylesheet">
        <title>Admin</title>
    </head>
    <body>
        <?php
            require 'header.php';
        ?>
        <main>
            <table class="tableau">
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
            <div>
                <a href='inscription_admin.php'>Creer un nouvel utilisateur</a>
            </div></br>
            <div>
                Modifier le rôle
                <form action="" method="post">
                    <input type="text" name="login" placeholder="Entrez le login de l'utilisateur"/></br>
                    <select name="role_change">
                        <option value="user">Utilisateur</option>
                        <option value="modo">Modérateur</option>
                    </select></br>
                    <input class="button" type="submit" value="Changer"/>
                </form>
                <?php change_role();?>
            </div></br>
            <div>
                Supprimer un utilisateur
                <form action="" method="post">
                    <input type="text" name="loginSupp" placeholder="Entrez le login de l'utilisateur"/></br>
                    <input class="button" type="submit" value="Supprimer"/>
                </form>
                <?php delete_user();?>
            </div></br>
            <div>
                Changer le login d'un utilisateur
                <form action="" method="post">
                    <input type="text" name="loginChange" placeholder="Entrez le login de l'utilisateur"/></br>
                    <input type="text" name="loginChangeN" placeholder="Entrez le nouveau login"/></br>
                    <input class="button" type="submit" value="Changer"/>
                </form>
                <?php change_login_user();?>
            </div></br>
            <div>
                Changer l'Email d'un utilisateur
                <form action="" method="post">
                    <input type="text" name="emailChange" placeholder="Entrez l'Email de l'utilisateur"/></br>
                    <input type="text" name="emailChangeN" placeholder="Entrez le nouvel Email"/></br>
                    <input class="button" type="submit" value="Changer"/>
                </form>
                <?php change_email_user();?>
            </div></br>
        </main>
        <?php
            require 'footer.php';
        ?>
    </body>
</html>