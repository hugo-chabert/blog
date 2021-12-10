<?php

function connect_database() {
    $bdd =  mysqli_connect('localhost', 'root', 'root', 'blog');
    mysqli_set_charset($bdd, 'utf8');
    return $bdd;
}
function verif_admin_modo(){
    $bdd =  connect_database();
    if(!empty($_SESSION['user'])){
        $login = $_SESSION['user']['login'];
        $id_droits = '42';
        $requete = mysqli_query($bdd, "SELECT * FROM utilisateurs WHERE login='".$login."' AND id_droits>='".$id_droits."'");
        $Row= mysqli_num_rows($requete);
        if($Row != 1){
            header('Location: ../index.php');
            exit();
        }
    }
    else{
        header('Location: ../index.php');
        exit();
    }
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

function connect_user() {
    $bdd =  connect_database();
    if (isset($_POST['login']) && isset($_POST['password'])) {
        $login = $_POST['login'];
        $pw= $_POST['password'];
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
                if (password_verify($pw, $sql_password) == FALSE) {
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
            $get_id_article = $_GET['id'];
            $sql = "INSERT INTO commentaires (commentaire, id_utilisateur, id_article) VALUES (:commentaire, :id_user, :id_article)";
            $q = $conn->prepare($sql);
            $q->bindValue('commentaire' ,$send_comm ,PDO::PARAM_STR);
            $q->bindValue('id_user' ,$id_user ,PDO::PARAM_INT);
            $q->bindValue('id_article' ,$get_id_article ,PDO::PARAM_INT);
            $q->execute();
            header('Location: article.php?id='.$get_id_article);
            exit();
        } else {
            echo '<p class="comm" >Veuillez écrire un commentaire</p>';
        }
    }
}

function create_article() {

    $dbhost     = "localhost";
    $dbname     = "blog";
    $dbuser     = "root";
    $dbpass     = "root";
    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass);
    if(isset($_POST['txt_article']) && isset($_POST['cat']) && isset($_POST['nom_article'])) {
        if (!$_POST['txt_article']) {
            echo '';
        }
        elseif ($_POST['cat'] == "choose") {
            echo 'Veuillez choisir une catégorie';
        }  else {
            $title = $_POST['txt_article'];
            $id_user = $_SESSION['user']['id'];
            $id_cat = $_POST['cat'];
            $nom_article = $_POST['nom_article'];
            $sql = "INSERT INTO articles (article,nom_article, id_utilisateur,id_categorie) VALUES
            (:title,:nom_article, :id_user,:id_cat)";
            $q = $conn->prepare($sql);
            $q->bindValue('title' ,$title ,PDO::PARAM_STR);
            $q->bindValue('nom_article' ,$nom_article ,PDO::PARAM_STR);
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
//HUGO

function verif_admin(){
    $bdd =  connect_database();
    if(!empty($_SESSION['user'])){
        $login = $_SESSION['user']['login'];
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
    $bdd = connect_database();
    if (!empty($_POST['login']) && !empty($_POST['email']) && !empty($_POST['password'])){
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
    else if(isset($_POST['login']) || isset($_POST['email']) || isset($_POST['password'])){
        echo 'Please complete all fields';
    }
}

function change_role(){
    $bdd = connect_database();
    if(!empty($_POST['login'])){
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
            header('Location: modif-user-admin.php');
        }
        else{
            echo "Vous n'avez pas le droit de changer le role d'un admin";
        }
    }
    else if(isset($_POST['login'])){
        echo 'Remplissez tout les champs';
    }
}

function verif_admin_user(){
    $bdd = connect_database();
    if(!empty($_POST['loginSupp'])){
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
        if(!empty($_POST['loginSupp'])){
            $bdd = connect_database();
            $login = $_POST['loginSupp'];
            $Requete = mysqli_query($bdd, "SELECT * FROM utilisateurs WHERE login='$login'");
            $Rows= mysqli_num_rows($Requete);
            if($Rows == 1){
                $Requete2 = mysqli_query($bdd, "DELETE FROM utilisateurs WHERE login='$login'");
                header('Location: modif-user-admin.php');
            }
            else{
                echo "Cet utilisateur n'existe pas";
            }
        }
        else if(isset($_POST['loginSupp'])){
            echo 'Remplissez tout les champs';
        }
    }
    else{
        echo "Vous n'avez pas le droit de supprimer un admin";
    }
}

function change_login_user(){
    $bdd = connect_database();
    if(!empty($_POST['loginChange']) && !empty($_POST['loginChangeN'])){
        $login = $_POST['loginChange'];
        $Nlogin = $_POST['loginChangeN'];
        $Requete = mysqli_query($bdd, "SELECT * FROM utilisateurs WHERE login='$login'");
        $Requete2 = mysqli_query($bdd, "SELECT * FROM utilisateurs WHERE login='$Nlogin'");
        $Rows = mysqli_num_rows($Requete);
        $Rows2 = mysqli_num_rows($Requete2);
        if($Rows2 != 1){
            if($Rows == 1){
                $requete_change = mysqli_query($bdd, "UPDATE `utilisateurs` SET login = '$Nlogin' WHERE login = '$login'");
                header('Location: modif-user-admin.php');
            }
            else{
                echo "Cet utilisateur n'existe pas";
            }
        }
        else{
            echo "Vous ne pouvez pas utiliser ce login";
        }
    }
    else if(isset($_POST['loginChange']) || isset($_POST['loginChangeN'])){
        echo 'Remplissez tout les champs';
    }
}

function change_email_user(){
    $bdd = connect_database();
    if(!empty($_POST['emailChange']) && !empty($_POST['emailChangeN'])){
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
                header('Location: modif-user-admin.php');
            }
            else{
                echo "Cet email n'existe pas";
            }
        }
        else{
            echo "Vous ne pouvez pas utiliser cet email";
        }
    }
    else if(isset($_POST['emailChange']) || isset($_POST['emailChangeN'])){
        echo 'Remplissez tout les champs';
    }
}

function create_categorie(){
    $bdd = connect_database();
    if(!empty($_POST['categorieCreate'])){
        $categorie = $_POST['categorieCreate'];
        $Requete = mysqli_query($bdd, "SELECT * FROM categories WHERE nom='$categorie'");
        $Rows = mysqli_num_rows($Requete);
        if($Rows != 1){
            $RequeteInsert = mysqli_query($bdd, "INSERT INTO categories (nom) VALUES ('$categorie')");
            header('Location: modif-cat-admin.php');
        }
        else{
            echo 'Cette catégorie est déjà existante';
        }
    }
    else if(isset($_POST['categorieCreate'])){
        echo 'Remplissez tout les champs';
    }
}

function change_categorie(){
    $bdd = connect_database();
    if(!empty($_POST['categorieChange']) && !empty($_POST['categorieChangeN'])){
        $categorie = $_POST['categorieChange'];
        $Ncategorie = $_POST['categorieChangeN'];
        $Requete = mysqli_query($bdd, "SELECT * FROM categories WHERE nom='$categorie'");
        $Rows = mysqli_num_rows($Requete);
        if($Rows == 1){
            $RequeteChange = mysqli_query($bdd, "UPDATE categories SET nom = '$Ncategorie' WHERE nom = '$categorie'");
            header('Location: modif-cat-admin.php');
        }
        else{
            echo "Cette catégorie n'existe pas";
        }
    }
    else if(isset($_POST['categorieChange']) || isset($_POST['categorieChangeN'])){
        echo 'Remplissez tout les champs';
    }
}

function delete_categorie(){
    $bdd = connect_database();
    if(!empty($_POST['categorieDelete'])){
        $categorie = $_POST['categorieDelete'];
        $Requete = mysqli_query($bdd, "SELECT * FROM categories WHERE nom='$categorie'");
        $Rows = mysqli_num_rows($Requete);
        if($Rows == 1){
            $RequeteDelete =  mysqli_query($bdd, "DELETE FROM categories WHERE nom='$categorie'");
            header('Location: modif-cat-admin.php');
        }
        else{
            echo "Cette catégorie n'existe pas";
        }
    }
    else if(isset($_POST['categorieDelete'])){
        echo 'Remplissez tout les champs';
    }
}

// francois

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
                    $rows = mysqli_num_rows($Requete);
                    if ($newlogin == $user_login){
                        echo "<p>Votre ancien Login est identique</p><style>p{color : var(--RedError-); font-size: 1.4em;}</style>";
                    }
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

function recup_article() {
    $bdd = connect_database();
    $id = $_GET['id'];
    $request_select_article_w_categorie = mysqli_query($bdd, "SELECT categories.nom AS category_name,
	articles.nom_article AS article_name,
    articles.article AS article_text,
    articles.date AS created_at,
    utilisateurs.login AS created_by,
    articles.id AS id_article
    FROM articles
    INNER JOIN categories
    INNER JOIN utilisateurs
    WHERE  articles.id_categorie = categories.id && utilisateurs.id = articles.id_utilisateur && articles.id = $id");
    $fetch= mysqli_fetch_assoc($request_select_article_w_categorie);
    return $fetch;
}



function Recup_articles(){
    $Bdd = connect_database();
    $requete_recup_articles = mysqli_query($Bdd, "SELECT categories.nom AS category_name, articles.article AS article_name,
    articles.date AS created_at,articles.nom_article AS article_title, utilisateurs.login AS created_by, articles.id AS article_id
                                        FROM categories
                                        INNER JOIN articles
                                        INNER JOIN utilisateurs
                                        WHERE articles.id_categorie = categories.id && utilisateurs.id = articles.id_utilisateur ");
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
                    <p><?=$article['article_name']?></p>
                    <div class='modal-footer'>
                        <p>Créé par <u> <?= $article['created_by']?></u></a><br>
                        dans la catégorie <u> <?= $article['category_name'] ?></u><br>
                        le <u><?= $article['created_at']?></u></p>
                        <form method="get">
                        <?php echo "<a href='article.php?id=".$article['article_id']."'>Voir/Laisser un commentaire</a>"; ?>
                        </form>
                    </div>

                    <a href='#' class='modal-close'>&times;</a>
                </div>
            </div>
        </div>
        <?php
    }
    return $articles;
}

function pagination() {
    $bdd = connect_database();
    $sql = "SELECT * FROM articles ORDER BY date DESC";
    $requete = mysqli_query($bdd, $sql);
    $fetch = mysqli_fetch_all($requete, MYSQLI_ASSOC);
    return $fetch;

}

// function create_article() {

//     $dbhost     = "localhost";
//     $dbname     = "blog";
//     $dbuser     = "root";
//     $dbpass     = "root";
//     $conn = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass);
//     if(isset($_POST['txt_article']) && isset($_POST['cat']) && isset($_POST['nom_article'])) {
//         if (!$_POST['txt_article']) {
//             echo '';
//         }
//         elseif ($_POST['cat'] == "choose") {
//             echo 'Veuillez choisir une catégorie';
//         }  else {
//             $title = $_POST['txt_article'];
//             $id_user = $_SESSION['user']['id'];
//             $id_cat = $_POST['cat'];
//             $nom_article = $_POST['nom_article'];
//             $sql = "INSERT INTO articles (article,nom_article, id_utilisateur,id_categorie) VALUES
//             (:title,:nom_article, :id_user,:id_cat)";
//             $q = $conn->prepare($sql);
//             $q->bindValue('title' ,$title ,PDO::PARAM_STR);
//             $q->bindValue('nom_article' ,$nom_article ,PDO::PARAM_STR);
//             $q->bindValue('id_user' ,$id_user ,PDO::PARAM_INT);
//             $q->bindValue('id_cat' ,$id_cat ,PDO::PARAM_INT);
//             $q->execute();
//         }
//     }
// }
?>