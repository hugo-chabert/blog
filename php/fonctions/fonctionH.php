<?php

function connect_database() {
    $bdd =  mysqli_connect('localhost', 'root', 'root', 'blog');
    mysqli_set_charset($bdd, 'utf8');
    return $bdd;
}

function verif_admin(){
    $bdd =  connect_database();
    if(isset($_SESSION['user'])){
        $login = $_SESSION['login'];
        $id_droits = '1337';
        $requete = mysqli_query($bdd, "SELECT * FROM utilisateurs WHERE login='".$login."' AND id_droits='".$id_droits."'");
        $Row= mysqli_num_rows($requete);
        if($Row != 1){
            header('Location: ../index.php');
        }
    }
    else{
        header('Location: ../index.php');
    }
}

function new_user_admin() {
    $bdd =  connect_database();
    if (isset($_POST['login']) && isset($_POST['email']) && isset($_POST['password'])) {
        $login= $_POST['login'];
        $email=$_POST['email'];
        $password = $_POST['password'];
        $Confirmedpassword = $_POST['Confirmedpassword'];
        $request_verif_email = mysqli_query($bdd, "SELECT * FROM utilisateurs WHERE email='$email' ");
        $check_is_use_email= mysqli_num_rows($request_verif_email);
        if ($password != $Confirmedpassword) {
            echo'<p style="color:#FF0000";> <strong> Your password and your confirmed password is wrong</strong></p>';
        }
        else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo'<p style="color:#FF0000";> <strong> Please enter a valid email ex: user@wanadoo.com </strong></p>';
        }
        else if ($check_is_use_email == 1) {
            echo'<p style="color:#FF0000";> <strong> This email is already use</strong></p>';
        }
        else if ($login == NULL ||  $email == NULL || $password == NULL || $Confirmedpassword == NULL ) {
            echo'<p style="color:#FF0000";> <strong> You have an empty fields</strong></p>';
        }
        else {
            $request_verif_login = mysqli_query($bdd, "SELECT * FROM utilisateurs WHERE login='$login' ");
            $check_is_use_login= mysqli_num_rows($request_verif_login);
            $pw_hash = password_hash($password, PASSWORD_DEFAULT);
            if($check_is_use_login == 1) {
                echo'<p style="color:#FF0000";> <strong> This login is already use</strong></p>';
            }
            else  {
                $requete = mysqli_query($bdd, "INSERT INTO utilisateurs (email, login, password, id_droits) VALUES ('$email','$login','$pw_hash', 1)");
                header('Location: admin.php');
            }
        }
    }
    else {
        echo 'Please complete all fields';
    }
}

function change_role(){
    $bdd = connect_database();
    if(isset($_POST['login'])){
        $login = $_POST['login'];
        $role = '1337';
        $Requete = mysqli_query($bdd, "SELECT * FROM utilisateurs WHERE login='$login' AND id_droits='$role'");
        $Rows= mysqli_num_rows($Requete);
        foreach ($_POST as $key => $value) {
            if($value == 'user'){
                $id_droits = '1';
            }
            if($value == 'modo'){
                $id_droits = '42';
            }
        }
        if($Rows != 1){
            $Requete2 = mysqli_query($bdd, "UPDATE `utilisateurs` SET id_droits = '$id_droits' WHERE login = '$login'");
            header('Location: admin.php');
        }
        else{
            echo "Vous n'avez pas le droit de changer le role d'un admin";
        }
    }
}

function verif_admin_user(){
    $bdd =  connect_database();
    if(isset($_POST['loginSupp'])){
        $login = $_POST['loginSupp'];
        $id_droits = '1337';
        $requete = mysqli_query($bdd, "SELECT * FROM utilisateurs WHERE login='".$login."' AND id_droits='".$id_droits."'");
        $Row= mysqli_num_rows($requete);
        if($Row != 1){
            return false;
        }
        return true;
    }
}

function delete_user(){
    if(verif_admin_user() == false){
        if(isset($_POST['loginSupp'])){
            $bdd = connect_database();
            $login = $_POST['loginSupp'];
            $Requete = mysqli_query($bdd, "SELECT * FROM utilisateurs WHERE login='$login'");
            $Rows= mysqli_num_rows($Requete);
            if($Rows == 1){
                $Requete2 = mysqli_query($bdd, "DELETE FROM utilisateurs WHERE login='$login'");
                header('Location: admin.php');
            }
        }
    }
    else{
        echo "Vous n'avez pas le droit de supprimer un admin";
    }
}

function change_login_user(){
    $bdd = connect_database();
    if(isset($_POST['loginChange']) && isset($_POST['loginChangeN'])){
        $login = $_POST['loginChange'];
        $Nlogin = $_POST['loginChangeN'];
        $Requete = mysqli_query($bdd, "SELECT * FROM utilisateurs WHERE login='$login'");
        $Requete2 = mysqli_query($bdd, "SELECT * FROM utilisateurs WHERE login='$Nlogin'");
        $Rows = mysqli_num_rows($Requete);
        $Rows2 = mysqli_num_rows($Requete2);
        if($Rows2 != 1){
            if($Rows == 1){
                $requete_change = mysqli_query($bdd, "UPDATE `utilisateurs` SET login = '$Nlogin' WHERE login = '$login'");
                header('Location: admin.php');
            }
            else{
                echo "Cet utilisateur n'existe pas";
            }
        }
        else{
            echo "Vous ne pouvez pas utiliser ce login";
        }
    }
}

function change_email_user(){
    $bdd = connect_database();
    if(isset($_POST['emailChange']) && isset($_POST['emailChangeN'])){
        $email = $_POST['emailChange'];
        $Nemail = $_POST['emailChangeN'];
        $Requete = mysqli_query($bdd, "SELECT * FROM utilisateurs WHERE email='$email'");
        $Requete2 = mysqli_query($bdd, "SELECT * FROM utilisateurs WHERE email='$Nemail'");
        $Rows = mysqli_num_rows($Requete);
        $Rows2 = mysqli_num_rows($Requete2);
        if($Rows2 != 1){
            if (!filter_var($Nemail, FILTER_VALIDATE_EMAIL)) {
                echo"Entrez un email valide ex: user@wanadoo.com";
            }
            else if($Rows == 1){
                $requete_change = mysqli_query($bdd, "UPDATE `utilisateurs` SET email = '$Nemail' WHERE email = '$email'");
                header('Location: admin.php');
            }
            else{
                echo "Cet email n'existe pas";
            }
        }
        else{
            echo "Vous ne pouvez pas utiliser cet email";
        }
    }
}

?>