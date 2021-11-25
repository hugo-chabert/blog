<?php $nomFichier = basename (__FILE__); 
 require ('fonctions/fonctionF.php');
session_start();
Deconnect();
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
                        <h2 class="welcome-msg"><?php if(isset($_SESSION['login'])){echo 'Bonjour, <br><a>'.$_SESSION['login'].'</a> vous etes bien connecte.';}?></h2>
                        <button class="modif"><a href = "change-login.php">Modifier votre Login</a></button>
                        <button class="modif"><a href = "">Modifier votre Email</a></button>
                        <button class="modif"><a href = "">Modifier votre Mot de passe</a></button>
                        <form action="" method = "POST" ><input type = "submit" name = "deconnexion" value ='Deconnexion'></input></form>
                    </div>
                    <div class="box-info"> 
                        <?php if(isset($_SESSION['login'])){echo Info();}?>
                    </div>
                </div>
            </div>
        </main>
        <?php require ('footer.php'); ?>
    </body>
</html>