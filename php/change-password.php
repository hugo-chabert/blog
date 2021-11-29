<?php
session_start();
require('fonctions/fonctionF.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/change.css" rel="stylesheet">
        <link href="../css/root.css" rel="stylesheet">
        <link href="../css/font.css" rel="stylesheet">
        <title>Modification</title>
    </head>

    <body>

        <main>
        <div class="Container">
            <div class="avert-form">
                <div class="avert">
                    <h2> &#9888;&#65039; Attention!! &#9888;&#65039; <br> Si vous modifier votre Mot de passe vous devrez vous reconnecter.</h2>
                </div>
                <div class="form">
                    <form method="POST" action="">
                        <input class="input" type="password" name="password" placeholder = 'Votre ancien Password'>
                        <input class="input" type="password" name="newpassword" placeholder = 'Votre nouveau Password'>
                        <input class="input" type="password" name="repeatnewpassword" placeholder = 'Répétez votre nouveau Password'><br/><br/>
                        <div class="button-button">
                            <button class="modif" type="submit" value="Valider" name = 'submit' >Valider</button>
                            <button class = 'modif'><a class ='a' href="profil.php"> Annuler </a></button>
                        </div>
                        <?php ChangeMdp();?>
                    </form>
                </div>
            </div>
        </main>

    </body>
</html>


