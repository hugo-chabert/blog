<?php
require ('fonctionR.php');
function CreateArticle(){
    $Bdd = connect_database();
}
function Deconnect(){// Fonction permettant de Deconnexion
    if (isset($_POST['deconnexion'])) {
        session_destroy();
        header('Location: ../index.php');
    }
}
function DecoOrCo(){// Fonction permettant de savoir si le user est connecté ou pas
    if (isset($_SESSION['login'])){
        echo '<p class ="p">Bienvenu(e),<br>'.$_SESSION['login'].' Vous êtes connecté</p>
            <style>
            .p{
                font-size:1.4em;
            }
            </style>';
    }
}
function ChangeEmail(){
    if (isset($_SESSION['login'])) {
        $username = $_SESSION['login'];
        if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            $newemail = $_POST['newemail'];
            $repeatnewemail = $_POST['repeatnewemail'];
            if ($email && $newemail && $repeatnewemail) {
                if (!filter_var($newemail, FILTER_VALIDATE_EMAIL)) {
                    echo'<p style="color:#FF0000";> <strong> Please enter a valid email ex: user@wanadoo.com </strong></p>';
                }
                else if ($newemail == $repeatnewemail) {
                    $Bdd = mysqli_connect('localhost', 'root', '', 'blog') or die('Erreur');
                    $Requete = mysqli_query($Bdd, "SELECT * FROM utilisateurs WHERE login = '$username' AND email = '$email'");
                    $rows = mysqli_num_rows($Requete);
                    if ($rows==1) {
                        $newpass = mysqli_query($Bdd, "UPDATE utilisateurs SET email='$newemail' WHERE login='$username'");
                        die("Votre Email a bien été modifié. Vous pouvez retourner dans l'onglet Profil juste <a href='profil.php'>ici</a>.");
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
    if (isset($_SESSION['login'])) {
        $username = $_SESSION['login'];
        if (isset($_POST['submit'])) {
            $login = $_POST['login'];
            $newlogin = $_POST['newlogin'];
            $repeatnewlogin = $_POST['repeatnewlogin'];
            if ($login && $newlogin && $repeatnewlogin) {
                if ($newlogin == $repeatnewlogin) {
                    $Bdd = mysqli_connect('localhost', 'root', '', 'blog') or die('Erreur');
                    $Requete = mysqli_query($Bdd, "SELECT * FROM utilisateurs WHERE login = '$username' AND login = '$login'");
                    $rows = mysqli_num_rows($Requete);
                    if ($rows==1) {
                        $newpre = mysqli_query($Bdd, "UPDATE utilisateurs SET login='$newlogin' WHERE login='$username'");
                        die("Votre Login a bien été modifié. Vous pouvez retourner dans l'onglet Profil juste <a href='profil.php'>ici</a>.");
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
    if (isset($_SESSION['login'])) {
        $username = $_SESSION['login'];
        if (isset($_POST['submit'])) {
            $password = $_POST['password'];
            $newpassword = $_POST['newpassword'];
            $repeatnewpassword = $_POST['repeatnewpassword'];
            $pw_hash = password_hash($newpassword, PASSWORD_DEFAULT);
            if ($password && $newpassword && $repeatnewpassword) {
                if ($newpassword == $repeatnewpassword) {
                    $Bdd = mysqli_connect('localhost', 'root', '', 'blog') or die('Erreur');
                    $Requete = mysqli_query($Bdd, "SELECT * FROM utilisateurs WHERE login = '$username' AND password = '$password'");
                    $rows = mysqli_num_rows($Requete);
                    if ($rows==1) {
                        $newpass = mysqli_query($Bdd, "UPDATE utilisateurs SET password='$pw_hash' WHERE login='$username'");
                        die("Votre Mot de passe a bien été modifié. Vous pouvez retourner dans l'onglet Profil juste <a href='profil.php'>ici</a>.");
                    }
                    else{
                        echo "<p>Votre ancien mot de passe est incorrect</p><style>p{color : var(--RedError-); font-size: 1.4em;}</style>";
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
function Info(){
    if (isset($_SESSION['login'])){
        $ConnectedUser = $_SESSION['login'];
        $Bdd = mysqli_connect('localhost', 'root', '', 'blog') or die('Erreur');
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

?>