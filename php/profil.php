<?php $nomFichier = basename (__FILE__);
require ('fonctions/fonctionF.php');
session_start();
Deconnect();
if(!isset($_SESSION['user'])){
    header('Location: ../index.php');
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/profil.css">
        <title>Mon Profil</title>
    </head>
    <body>
        <?php require ('header.php');?>
        <main>
            <div class="Container">
                <div class="box-change-info">
                    <div class="box-change">
                        <h2 class="welcome-msg"><?php if(isset($_SESSION['user']['login'])){echo 'Bonjour, <br><a>'.$_SESSION['user']['login'].'</a> vous etes bien connecte.';}?></h2>
                        <a href = "change-login.php"><button class="modif">Modifier votre Login</button></a>
                        <a href = "change-email.php"><button class="modif">Modifier votre Email</button></a>
                        <a href = "change-password.php"><button class="modif">Modifier votre Mot de passe</button></a>
                        <form action="" method = "POST" ><button class = "deco" type = "submit" name = "deconnexion" value ='Deconnexion'>Déconnexion</buttton></form>
                    </div>
                    <div class="box-info">
                        <h2>Informations</h2>
                        <?php if(isset($_SESSION['user']['login'])){echo Info();}?>
                    </div>
                </div>
            </div>
        </main>
        <?php require ('footer.php'); ?>
    </body>
</html>
