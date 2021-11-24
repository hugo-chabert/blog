<?php
session_start();
 require('fonctions/fonctionR.php');

?>
<html >
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="../css/inscription.css" />
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
        <input class="button" type="submit" value="Login"/>
        <p class="message">Not registered ? <a href="inscription.php"><strong>Sign in</strong></a></p>
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