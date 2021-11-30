<?php
$nomFichier = basename (__FILE__);
require 'header.php';
session_start();
require('fonctions/fonctionR.php');
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
        <title>Inscription</title>
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
              <button class="button" type="submit" >S'incrire</button>
              <p class="message">Déjà un compte ? <a class = 'link' href="connexion.php"><strong>Connectez vous !!</strong></a></p>
          </form>
          <?php new_user(); ?>
        </div>
      </div>
      </form>
    </main>
    <?php
    require 'footer.php';
    ?>
  </body>
</html>
