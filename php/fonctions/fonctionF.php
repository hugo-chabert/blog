<?php
require ('fonction.php');


function Deconnect(){// Fonction permettant de Deconnexion
    if (isset($_POST['deconnexion'])) {
        session_destroy();
        header('Location: ../index.php');
    }
}
function DecoOrCo(){// Fonction permettant de savoir si le user est connecté ou pas
    if (isset($_SESSION['user']['login'])){
        echo '<p class ="p">Bienvenu(e),<br>'.$_SESSION['user']['login'].' Vous êtes connecté</p>
            <style>
            .p{
                font-size:1.4em;
            }
            </style>';
    }
}
function Reco(){// Fonction permettant de Reconnexion
    if (isset($_POST['reconnexion'])) {
        session_destroy();
        header('Location: ../connexion.php');
    }
}
function ChangeEmail(){
    if (isset($_SESSION['user'])) {
        $username = $_SESSION['user']['login'];
        if (isset($_POST['submit'])) {
            $user_email = $_SESSION['user']['email'];
            $email = $_POST['email'];
            $newemail = $_POST['newemail'];
            $repeatnewemail = $_POST['repeatnewemail'];
            if ($email && $newemail && $repeatnewemail) {
                if (!filter_var($newemail, FILTER_VALIDATE_EMAIL)) {
                    echo'<p style="color:#FF0000";> <strong> Please enter a valid email ex: user@wanadoo.com </strong></p>';
                }
                else if ($newemail == $repeatnewemail) {
                    $Bdd = mysqli_connect('localhost', 'root', 'root', 'blog') or die('Erreur');
                    $Requete = mysqli_query($Bdd, "SELECT * FROM utilisateurs WHERE login = '$username' AND email = '$email'");
                    $rows = mysqli_num_rows($Requete);
                    if ($newemail == $user_email){
                        echo "<p>Votre ancienne Email est identique</p><style>p{color : var(--RedError-); font-size: 1.4em;}</style>";
                    }
                    else if ($rows==1) {
                        $newpass = mysqli_query($Bdd, "UPDATE utilisateurs SET email='$newemail' WHERE login='$username'");
                        die("<p>Votre Email a bien été modifié. Vous pouvez retourner dans l'onglet Profil</p> <button class='modif'><a class='a'href='profil.php'> Retour </a></button>");
                    }
                    else{
                        echo "<p>Votre ancien Email est incorrect</p><style>p{color : var(--RedError-); font-size: 1.4em;}</style>";
                    }
                }
                else{
                    echo "<p>Les deux champs doivent être identiques</p><style>p{color : var(--RedError-); font-size: 1.4em;}</style>";
                }
            }
            else{
                echo "<p>Veuillez saisir tous les champs</p><style>p{color : var(--RedError-); font-size: 1.4em;}</style>";
            }
        }
    }
    else{
        header("Location:connexion.php");
    }
}
function ChangeLogin(){
    if (isset($_SESSION['user'])) {
        $username = $_SESSION['user']['login'];
        if (isset($_POST['submit'])) {
            $login = $_POST['login'];
            $user_login = $_SESSION['user']['login'];
            $user_id = $_SESSION['user']['id'];
            $newlogin = $_POST['newlogin'];
            $repeatnewlogin = $_POST['repeatnewlogin'];
            if ($login && $newlogin && $repeatnewlogin) {
                if ($newlogin == $repeatnewlogin) {
                    $Bdd = mysqli_connect('localhost', 'root', 'root', 'blog') or die('Erreur');
                    $Requete = mysqli_query($Bdd, "SELECT * FROM utilisateurs WHERE login = '$username' AND login = '$login'");
                    //! $requete_error = mysqli_query($Bdd, "SELECT * FROM utilisateurs WHERE id = '$user_id'");
                    $rows = mysqli_num_rows($Requete);
                    //! $rows_error = mysqli_num_rows($requete_error);
                    //! var_dump($requete_error);
                    if ($newlogin == $user_login){
                        echo "<p>Votre ancien Login est identique</p><style>p{color : var(--RedError-); font-size: 1.4em;}</style>";
                    }
                    //! else if($rows_error==1){
                    //!     echo "<p>Ce Login est déjà utilisé </p><style>p{color : var(--RedError-); font-size: 1.4em;}</style>";
                    //! }
                    else if ($rows==1) {
                        $newpre = mysqli_query($Bdd, "UPDATE utilisateurs SET login='$newlogin' WHERE login='$username'");
                        session_destroy();
                        header('Location: connexion.php');
                    }
                    else{
                        echo "<p>Votre ancien Login est incorrect</p><style>p{color : var(--RedError-); font-size: 1.4em;}</style>";
                    }
                }
                else{
                    echo "<p>Les deux champs doivent être identiques</p><style>p{color : var(--RedError-); font-size: 1.4em;}</style>";
                }
            }
            else{
                echo "<p>Veuillez saisir tous les champs</p><style>p{color : var(--RedError-); font-size: 1.4em;}</style>";
            }
        }
    }
    else{
        header("Location:connexion.php");
    }
}
function ChangeMdp(){
    $Bdd = connect_database();
    if (isset($_POST['password']) && isset($_POST['newpassword']) && isset($_POST['repeatnewpassword'])){
        $id = $_SESSION['user']['id'];
        $password = $_SESSION['user']['password'];
        $oldpassword = $_POST['password'];
        $newpassword = $_POST['newpassword'];
        $repeatnewpassword = $_POST['repeatnewpassword'];
        $new_password_hash = password_hash($newpassword, PASSWORD_DEFAULT);
        if ($password == NULL || $newpassword == NULL || $repeatnewpassword == NULL ){
            echo "<p>Veuillez saisir tous les champs</p><style>p{color : var(--RedError-); font-size: 1.4em;}</style>";
        }
        else if(password_verify($oldpassword, $password) == false){
            echo "<p>Votre ancien Password est incorrect</p><style>p{color : var(--RedError-); font-size: 1.4em;}</style>" ;
        }
        else if ($newpassword != $repeatnewpassword){
            echo "<p>Les deux champs doivent être identiques</p><style>p{color : var(--RedError-); font-size: 1.4em;}</style>";
        }
        else{
            $requete_select_pwd = mysqli_query($Bdd, "SELECT * FROM `utilisateurs` WHERE password = '$password' ");
            $requete_update_pwd = mysqli_query($Bdd, "UPDATE utilisateurs SET password = '$new_password_hash' WHERE id = '$id'");
            session_destroy();
            header('Location: connexion.php');
            exit();
        }
    }
    else{
        echo '<p><br>Remplissez tous les champs</p><style>p{ font-size: 1.4em;}</style> ';
    }
}
function Info(){
    if (isset($_SESSION['user'])){
        $ConnectedUser = $_SESSION['user']['login'];
        $Bdd = mysqli_connect('localhost', 'root', 'root', 'blog') or die('Erreur');
        $Requete =  mysqli_query($Bdd, "SELECT * FROM `utilisateurs` INNER JOIN `droits` WHERE utilisateurs.id_droits = droits.id and  `login` = '".$ConnectedUser."'");
        $rows = mysqli_num_rows($Requete);
        if ($rows == 1){
            $Users = mysqli_fetch_all($Requete, MYSQLI_ASSOC);
            foreach ($Users as $User){
                echo'<p class = "p3">Login : '.$User['login'].'</p>';
                echo'<p class = "p2">Email : '.$User['email'].'<br></p>';
                echo'<p class = "p2">Role : '.$User['nom'].'<br></p>';
            }
        }
    }
}

function Recup_articles(){
    $Bdd = connect_database();
    $requete_recup_articles = mysqli_query($Bdd, "SELECT categories.nom AS category_name, articles.article AS article_name,
    articles.date AS created_at,articles.nom_article AS article_title, utilisateurs.login AS created_by, articles.id AS article_id
                                        FROM categories
                                        INNER JOIN articles
                                        INNER JOIN utilisateurs
                                        WHERE articles.id_categorie = categories.id && utilisateurs.id = articles.id_utilisateur");
    $articles = mysqli_fetch_all($requete_recup_articles, MYSQLI_ASSOC);
    foreach ($articles as $article){
        ?>
        <div class='articles'>
            <p><?=$article['article_title']?></p>
            <div class='wrapper'>
            <a href='#demo-modal <?= $article['article_id']?>'><button class='button'>Plus d'informations</button></a>
            </div>

            <div id='demo-modal <?= $article['article_id'] ?>' class='modal'>
                <div class='modal-content'>
                    <h1><?=$article['article_title']?></h1>

                    <p>
                    <?=$article['article_name']?>
                    </p>

                    <div class='modal-footer'>
                        <p>Créé par <u> <?= $article['created_by']?></u></a><br>
                        dans la catégorie <u> <?= $article['category_name'] ?></u><br>
                        le <u><?= $article['created_at']?></u></p>
                        <form method="get" action="article.php">
                        <button class="button-com" type="submit" name="<?= $article['article_id']?>" id="<?= $article['article_id']?>" >Voir/Laisser un commentaire</button>
                        </form>
                    </div>

                    <a href='#' class='modal-close'>&times;</a>
                </div>
            </div>
        </div>
        <?php
    }
    return $article;
}

//! function Upload_image(){

//!     $Bdd = connect_database();
//!     if($Bdd) {
//!     echo "connecte";
//!     }
//!     else{
//!         echo"Non connecte";
//!     }

//!     if(isset($_POST['images_user'])) {
//!         $filename = $_FILES['uploadfile']['name'] ;
//!         $filetmpname = $_FILES['uploadfile']['tmp_name'];
//!         $folder = '../images_user/';

//!         move_uploaded_file($filetmpname, $folder.$filename);

//!         $sql = "INSERT INTO `images` (`imagename`)  VALUES ('$filename')";
//!         $qry = mysqli_query($Bdd,  $sql);
//!         if( $qry) {
//!             echo "</br>image uploadé";
//!         }
//!     }

//! }

?>