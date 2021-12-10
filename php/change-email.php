<?php
session_start();
require('fonctions/fonction.php');
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
                <div class="form">
                    <form method="POST" action="">
                        <input class="input" type="text" name="email" placeholder = 'Votre ancien Email'>
                        <input class="input" type="text" name="newemail" placeholder = 'Votre nouveau Email'>
                        <input class="input" type="text" name="repeatnewemail" placeholder = 'Répétez votre nouveau Email'><br/><br/>
                        <div class="button-button">
                            <button class="modif" type="submit" value="Valider" name = 'submit' >Valider</button>
                            <button class = 'modif'><a class ='a' href="profil.php">  Annuler </a></button>
                        </div>
                        <?php ChangeEmail();?>
                    </form>
                </div>
            </div>
        </main>

    </body>
</html>
