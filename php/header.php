<link href="<?php if($nomFichier != 'index.php'){ echo '../';} ?>css/header.css" rel="stylesheet">
<header>
    <div class="header">
        <div class="links">
            <div class="gaucheHeader">
                <a href="<?php if($nomFichier != 'index.php'){ echo '../';} ?>index.php" class="linkHeader">ACCUEIL</a>
                <div class="dropdown">
                    <a>CATEGORIES</a>
                    <div class="dropdown-content">
                        <?php show_categories();?>
                    </div>
                </div>
                <a href="<?php if($nomFichier != 'index.php'){ echo '../';} ?>php/articles.php" class="linkHeader">ARTICLES</a>
            </div>
            <div class="droiteHeader">
                <?php if(empty($_SESSION['user'])){echo ('<a href="'); if($nomFichier != 'index.php'){ echo '../';} echo ('php/inscription.php" class="linkHeader">INSCRIPTION</a>');} ?>
                <?php if(empty($_SESSION['user'])){echo ('<a href="'); if($nomFichier != 'index.php'){ echo '../';} echo ('php/connexion.php" class="linkHeader">CONNEXION</a>');} ?>
                <?php if(!empty($_SESSION['user'])){if($_SESSION['user']['id_droits'] == '1337' || $_SESSION['user']['id_droits'] == '42' ){echo ('<a href="'); if($nomFichier != 'index.php'){ echo '../';} echo ('php/creer-article.php" class="linkHeader">CREER UN ARTICLE</a>');}} ?>
                <?php if(!empty($_SESSION['user'])){if($_SESSION['user']['id_droits'] == '1337'){echo ('<a href="'); if($nomFichier != 'index.php'){ echo '../';} echo ('php/admin.php" class="linkHeader">ADMIN</a>');}} ?>
                <?php if(!empty($_SESSION['user'])){echo ('<form action="" method = "POST" class="decoButton"><button class = "deco2" type = "submit" name = "deconnexion" value ="Deconnexion">DECONNEXION</button></form>');} ?>
                <?php if(!empty($_SESSION['user'])){echo ('<a href="'); if($nomFichier != 'index.php'){ echo '../';} echo ('php/profil.php" class="linkHeader"><img class="imgProfil" alt="ImgProfil" src="'); if($nomFichier != "index.php"){ echo "../";}; echo ('images/profil.png"></a></a>');} ?>
            </div>
        </div>
    </div>
</header>
<?php
if (isset($_POST['deconnexion'])) {
    session_destroy();
    if($nomFichier != 'index.php'){
        header('Location: ../index.php');
        exit();
    }
    else if($nomFichier == 'index.php'){
        header('Location: index.php');
        exit();
    }
}
?>