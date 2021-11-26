<?php
$nomFichier = basename (__FILE__);
require 'header.php';
session_start();
require('fonctions/fonctionH.php');
verif_admin();
?>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="../css/inscription.css" />
        <title>Creation d'un utilisateur</title>
    </head>
<body>
<header>
</header>
<main>
<div class="login-page">
<div class="form">
    <form action="" method="post" class="login-form">
        <input type="text" id="email" name="email" placeholder="Email"/>
        <input type="text" id="login" name="login" placeholder="Login"/>
        <input type="password" id="password" name="password" placeholder="Password"/>
        <input type="password" id="Confirmedpassword" name="Confirmedpassword" placeholder="Confirmed Password"/>
        <input type="text" id="role" name="role" placeholder="Role"/>
        <input class="button" type="submit" value="Login"/>
    </form>
    <?php new_user_admin(); ?>
</div>
</div>
</form>
</main>
</body>
</html>

<?php
require 'footer.php';
?>