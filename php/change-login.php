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
        <link href="css/change.css" rel="stylesheet">
        <link href="css/header&footer.css" rel="stylesheet">
        <link href="css/root&font.css" rel="stylesheet">
        <title>Profil</title>
    </head>

    <body>

        <main>
        <div class="login-page">
            <div class="form">
				<form method="POST" action="">
					<input class="input" type="text" name="login" placeholder = 'Votre ancien Login'>
					<input class="input" type="text" name="newlogin" placeholder = 'Votre nouveau Login'>
					<input class="input" type="text" name="repeatnewlogin" placeholder = 'Répétez votre nouveau Login'><br/><br/>
					<input class="button1" type="submit" value="Changer de Login" name = 'submit' placeholder="submit">
					<button class = 'button'> <a class = 'none' href="profil.php"> Annuler</a></button>
				</form>
				<?php ChangeLogin();?>
            </div>
        </main>

    </body>
</html>


