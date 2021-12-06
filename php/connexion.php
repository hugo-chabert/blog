<?php
$nomFichier = basename (__FILE__);
require 'header.php';
session_start();
require('fonctions/fonction.php');
if (isset($_SESSION['user'])){
  header('Location: profil.php');
}
?>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="../css/inscription.css" />
        <link href="../css/root.css" rel="stylesheet">
        <link href="../css/font.css" rel="stylesheet">
        <title>Connexion</title>
    </head>
<body>
<header>
</header>
<main>
<div class="login-page">
  <div class="form">
    <form action="" method="post" class="login-form">
        <input type="text" id="login" name="login" placeholder="Login"/>
        <input type="password" id="password" name="password" placeholder="Password"/>
        <input type="password" id="Confirmedpassword" name="Confirmedpassword" placeholder="Confirmed Password"/>
        <button class="button" type="submit" > Se connecter</button>
        <p class="message">Pas de compte ? <a class = 'link' href="inscription.php"><strong>Inscrivez vous !</strong></a></p>
    </form>
    <?php connect_user(); ?>
  </div>
</div>
</form>
</main>
<footer>
</footer>
</body>
</html>

<?php
require 'footer.php';
?>