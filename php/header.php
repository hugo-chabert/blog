<link href="<?php if($nomFichier != 'index.php'){ echo '../';} ?>css/header.css" rel="stylesheet">
<header>
    <div class="header">
        <div class="links">
            <div class="gaucheHeader">
                <a href="<?php if($nomFichier != 'index.php'){ echo '../';} ?>index.php" class="linkHeader">ACCUEIL</a>
                <a href="" class="linkHeader">CATEGORIES</a>
            </div>
            <div class="droiteHeader">
                <?php if(empty($_SESSION['user'])){echo ('<a href="'); if($nomFichier != 'index.php'){ echo '../';} echo ('php/inscription.php" class="linkHeader">INSCRIPTION</a>');} ?>
                <?php if(empty($_SESSION['user'])){echo ('<a href="'); if($nomFichier != 'index.php'){ echo '../';} echo ('php/connexion.php" class="linkHeader">CONNEXION</a>');} ?>
                <?php if(!empty($_SESSION['user'])){echo ('<form action="" method = "POST" class="decoButton"><button class = "deco2" type = "submit" name = "deconnexion" value ="Deconnexion">DECONNEXION</button></form>');} ?>
                <?php if(!empty($_SESSION['user'])){echo ('<a href="'); if($nomFichier != 'index.php'){ echo '../';} echo ('php/profil.php" class="linkHeader"><img class="imgProfil" src="'); if($nomFichier != "index.php"){ echo "../";}; echo ('images/profil.png"></a></a>');} ?>
            </div>
        </div>
    </div>
</header>