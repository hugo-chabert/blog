<?php

function connect_database() {
    $bdd =  mysqli_connect('localhost', 'root', 'root', 'blog');
    mysqli_set_charset($bdd, 'utf8');
    return $bdd;
}


function connect_user() {
    $bdd =  connect_database();
    if (isset($_POST['login']) && isset($_POST['password'])) {
        $login = $_POST['login'];
        $pw= $_POST['password'];
        $pw_confirmed=$_POST['Confirmedpassword'];
        if ($login != NULL && $pw != NULL) {
            $requete = mysqli_query($bdd, "SELECT * FROM utilisateurs WHERE login='$login' ");
            $count= mysqli_num_rows($requete);
            $fetch= mysqli_fetch_assoc($requete);
            if (isset($fetch)) {
                $sql_password= $fetch['password'];
            }
            else {
                echo'<p style="color:#FF0000";> <strong> Account not found</strong></p>';
            }
            if ($count == 1) {
                if ($pw != $pw_confirmed) {
                    echo'<p style="color:#FF0000";> <strong> Your password and your confirmed password is wrong</strong></p>';
                }
                else if (password_verify($pw, $sql_password) == FALSE) {
                    echo'<p style="color:#FF0000";> <strong> Password invalid </strong></p>';
                }
                else {
                header('Location: profil.php');
                $_SESSION['user'] = $fetch;
                $_SESSION['login'] = $login;
                }
            }
        }
        else {
            echo'<p style="color:#FF0000";> <strong> You have an empty fields</strong></p>';
        }
    }
    else {
        echo 'Please complete all fields';
    }
}
function select_categorie() {
    $bdd = connect_database();
    if (isset($_POST['txt_article']) && isset($_POST['article_categorie'])) {
        $txt_article = $_POST['txt_article'];
        $article_categorie = $_POST['article_categorie'];
        if ($txt_article != NULL && $article_categorie != NULL) {
            $request_select_article_w_categorie = mysqli_query($bdd, "SELECT categories.nom AS category_name, articles.article AS article_name,
            articles.date AS created_at, utilisateurs.login AS created_by FROM categories INNER JOIN articles INNER JOIN utilisateurs
            WHERE articles.id_categorie = categories.id && utilisateurs.id_droits = articles.id_utilisateur");
            $fetch= mysqli_fetch_all($request_select_article_w_categorie, MYSQLI_ASSOC);
            var_dump($fetch);
            if ($request_select_article_w_categorie == TRUE) {
                echo 'ok';
                // ? si article_name existe mais categorie diff de bdd alors c bon
                // ? si article name existe et categorie de bdd meme alors c pas bon
                if ($fetch == null) {
                    echo 'creer';
                    //INSERT INTO articles (article,id_utilisateur,id_categorie) VALUES ()
                    //$request_create_article = mysqli_query($bdd,"INSERT INTO articles (article,id_utilisateur,id_categorie) VALUES ('$txt_article','$article_categorie',1337 ) ");
                 } else {
                    echo 'existant';
                }
            }
        }
    }
}

function new_user() {
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
                header('Location: connexion.php');
            }
        }
    }
    else {
        echo 'Please complete all fields';
    }
}


?>