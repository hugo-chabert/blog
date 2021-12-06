<?php
require ('fonctionF.php');
require ('fonction.php');


function verif_admin_modo(){
    $bdd =  connect_database();
    if(!empty($_SESSION['user'])){
        $login = $_SESSION['user']['login'];
        $id_droits = '42';
        $requete = mysqli_query($bdd, "SELECT * FROM utilisateurs WHERE login='".$login."' AND id_droits>='".$id_droits."'");
        $Row= mysqli_num_rows($requete);
        if($Row != 1){
            header('Location: ../index.php');
        }
    }
    else{
        header('Location: ../index.php');
    }
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
                echo'<p>Compte inexistant</p><style>p{color : var(--RedError-); font-size: 1.4em;}</style>';
            }
            if ($count == 1) {
                if ($pw != $pw_confirmed) {
                    echo'<p>Mot de passe non identiques</p><style>p{color : var(--RedError-); font-size: 1.4em;}</style>';
                }
                else if (password_verify($pw, $sql_password) == FALSE) {
                    echo'<p>Mot de passe incorrect </p><style>p{color : var(--RedError-); font-size: 1.4em;}</style>';
                }
                else {
                $_SESSION['user'] = $fetch;
                header('Location: profil.php');
                }
            }
        }
        else {
            echo'<p>Remplissez tous les champs</p><style>p{color : var(--RedError-); font-size: 1.4em;}</style>';
        }
    }
    else {
        echo 'Veuillez saisir tous les champs';
    }
}
function recup_article() {
    $bdd = connect_database();
    $get_id_atc = Recup_articles();
    $id= $_GET[$get_id_atc["id"]];
    $request_select_article_w_categorie = mysqli_query($bdd, "SELECT categories.nom AS category_name,
    articles.article AS article_name,
    articles.date AS created_at,
    utilisateurs.login AS created_by,
    articles.id AS id_article
    FROM articles
    INNER JOIN categories
    INNER JOIN utilisateurs
    WHERE articles.id_categorie = categories.id && utilisateurs.id = articles.id_utilisateur && articles.id = '$id' ");
    $fetch= mysqli_fetch_assoc($request_select_article_w_categorie);
    return $fetch;
}

function convert_time() {
    $bdd = connect_database();
    $request = mysqli_query($bdd,"SELECT date FROM articles");
    $recup = mysqli_fetch_assoc($request);
    $timestamp = $recup["date"];

    foreach ($recup as $key => $value) {
        echo strftime('%A', strtotime($timestamp)).' '.strftime('%e', strtotime($timestamp)).' '.strftime('%B', strtotime($timestamp)).' '.strftime('%Y', strtotime($timestamp)).' '.strftime('%T', strtotime($timestamp));
    }
}

function disp_com() {

    $bdd = connect_database();
    $recup_atc= recup_article();
    $compt= 0;
    $request = mysqli_query($bdd,"SELECT commentaire AS comment_is,
    id_article,
    utilisateurs.login AS commented_by,
    commentaires.date AS created_at
    FROM commentaires
    INNER JOIN articles
    INNER JOIN utilisateurs
    WHERE id_article= articles.id && utilisateurs.id=articles.id_utilisateur");
    $recup = mysqli_fetch_all($request, MYSQLI_ASSOC);
    foreach($recup as $com) {
        if ($recup_atc["id_article"] == $com["id_article"]) {
            $compt++;
            echo '<div class="tchoutch">#'.$compt.'</br>'.' Commenté par : '.$com["commented_by"].' '.'le '.$com["created_at"].'</br>'.$com["comment_is"].'</br></div></br>';
        }
    }
}


function disp_count() {
    $bdd = connect_database();
    $recup_atc= recup_article();
    $compteur= 0;
    $request1 = mysqli_query($bdd,"SELECT commentaire AS comment_is,
    id_article,
    utilisateurs.login AS commented_by,
    commentaires.date AS created_at
    FROM commentaires
    INNER JOIN articles
    INNER JOIN utilisateurs
    WHERE id_article= articles.id && utilisateurs.id=articles.id_utilisateur");
    $recup_com = mysqli_fetch_all($request1, MYSQLI_ASSOC);
    foreach($recup_com as $r) {
        if ($recup_atc["id_article"] == $r["id_article"]) {
            $compteur++;
        }
    }
    $id_article = $recup_atc["id_article"];
    $request = mysqli_query($bdd,"SELECT count(commentaire) FROM `commentaires` WHERE id_article='$id_article' ");
    $recup = mysqli_fetch_all($request, MYSQLI_ASSOC);
    echo $compteur.' ';
}

function auto_list() {
    $bdd = connect_database();
    $sql = mysqli_query($bdd, "SELECT * FROM categories");
    $row2 = mysqli_fetch_all($sql, MYSQLI_ASSOC);

    foreach ($row2 as  $value) {
        echo "<option value=".$value["id"]." name=".$value["nom"]." >" .$value["nom"]. "</option>";
    }
    return $value;
}

function new_com() {
    $dbhost     = "localhost";
    $dbname     = "blog";
    $dbuser     = "root";
    $dbpass     = "root";
    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass);
    if (!$_SESSION) {
        echo 'Veuillez vous connecter pour poster un commentaire.';
    } else {
        echo '<p class="comm" >Votre commentaire :<br /><textarea name="commentaire" rows="10%" cols="90%"></textarea></p>';
        if (isset($_POST["commentaire"]) && $_POST["commentaire"] != NULL) {
            $send_comm = $_POST["commentaire"];
            $id_user = $_SESSION['user']['id'];
            $sql = "INSERT INTO commentaires (commentaire, id_utilisateur, id_article) VALUES (:commentaire, :id_user, 76)";
            $q = $conn->prepare($sql);
            $q->bindValue('commentaire' ,$send_comm ,PDO::PARAM_STR);
            $q->bindValue('id_user' ,$id_user ,PDO::PARAM_INT);
            $q->execute();
            header('Location: article.php');
            exit();
        } else {
            echo '<p class="comm" >Veuillez écrire quelque chose dans votre commentaire</p>';
        }
    }
}

function create_article() {

    $dbhost     = "localhost";
    $dbname     = "blog";
    $dbuser     = "root";
    $dbpass     = "root";
    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass);
    if(isset($_POST['txt_article']) && isset($_POST['cat'])) {
        if (!$_POST['txt_article']) {
            echo '';
        }
        elseif ($_POST['cat'] == "choose") {
            echo 'Veuillez choisir une catégorie';
        }  else {
            $title = $_POST['txt_article'];
            $id_user = $_SESSION['user']['id'];
            $id_cat = $_POST['cat'];
            $sql = "INSERT INTO articles (article,id_utilisateur,id_categorie) VALUES
            (:title,:id_user,:id_cat)";
            $q = $conn->prepare($sql);
            $q->bindValue('title' ,$title ,PDO::PARAM_STR);
            $q->bindValue('id_user' ,$id_user ,PDO::PARAM_INT);
            $q->bindValue('id_cat' ,$id_cat ,PDO::PARAM_INT);
            $q->execute();
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
            echo'<p>Mot de passe Non identique</p><style>p{color : var(--RedError-); font-size: 1.4em;}</style>';
        }
        else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo'<p>Veuillez entrer une adresse valide</p><style>p{color : var(--RedError-); font-size: 1.4em;}</style>';
        }
        else if ($check_is_use_email == 1) {
            echo'<p>Cette addresse est déjà utilisée</p><style>p{color : var(--RedError-); font-size: 1.4em;}</style>';
        }
        else if ($login == NULL ||  $email == NULL || $password == NULL || $Confirmedpassword == NULL ) {
            echo'<p>Remplissez tous les champs</p><style>p{color : var(--RedError-); font-size: 1.4em;}</style>';
        }
        else {
            $request_verif_login = mysqli_query($bdd, "SELECT * FROM utilisateurs WHERE login='$login' ");
            $check_is_use_login= mysqli_num_rows($request_verif_login);
            $pw_hash = password_hash($password, PASSWORD_DEFAULT);
            if($check_is_use_login == 1) {
                echo'<p>Ce Login est déjà utilisé</p><style>p{color : var(--RedError-); font-size: 1.4em;}</style>';
            }
            else  {
                $requete = mysqli_query($bdd, "INSERT INTO utilisateurs (email, login, password, id_droits) VALUES ('$email','$login','$pw_hash', 1)");
                header('Location: connexion.php');
            }
        }
    }
    else {
        echo 'Veuillez saisir tous les champs';
    }
}


?>