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
                    <h2> &#9888;&#65039; Attention!! &#9888;&#65039; <br> Si vous modifier votre Login vous devrez vous reconnecter.</h2>
                </div>
                <div class="form">
                    <form method="POST" action="">
                        <input class="input" type="text" name="login" placeholder = 'Votre ancien Login'>
                        <input class="input" type="text" name="newlogin" placeholder = 'Votre nouveau Login'>
                        <input class="input" type="text" name="repeatnewlogin" placeholder = 'Répétez votre nouveau Login'><br/><br/>
                        <div class="button-button">
                            <button class="modif" type="submit" value="Valider" name = 'submit' >Valider</button>
                            <button class = 'modif'><a class ='a' href="profil.php"> Annuler </a></button>
                        </div>
                        <?php ChangeLogin();?>
                    </form>
                </div>
            </div>
        </main>

    </body>
</html>


