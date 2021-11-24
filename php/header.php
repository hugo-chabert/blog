<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link href="<?php if($nomFichier != 'index.php'){ echo '../';} ?>css/header.css" rel="stylesheet">
</head>
<body>
<header>
    <div class="header">
        <div class="titreHeader">
            ADDICT N' SHOES
        </div>
        <div class="links">
            <div class="gaucheHeader">
                <a href="<?php if($nomFichier != 'index.php'){ echo '../';} ?>index.php" class="linkHeader">ACCUEIL</a>
                <a href="" class="linkHeader">CATEGORIES</a>
            </div>
            <div class="droiteHeader">
                <a href="<?php if($nomFichier != 'index.php'){ echo '../';} ?>php/inscription.php" class="linkHeader">INSCRIPTION</a>
                <a href="<?php if($nomFichier != 'index.php'){ echo '../';} ?>php/connexion.php" class="linkHeader">CONNEXION</a>
                <a href="<?php if($nomFichier != 'index.php'){ echo '../';} ?>php/profil.php" class="linkHeader"><img class="imgProfil" src="<?php if($nomFichier != 'index.php'){ echo '../';} ?>images/profil.png"></a></a>
            </div>
        </div>
    </div>
</header>
<main>

</main>
</body>
</html>