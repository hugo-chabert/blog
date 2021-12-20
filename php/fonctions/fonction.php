<?php

function connect_database() {
    $bdd =  mysqli_connect('localhost', 'francois-niang1', 'bdblog', 'francois-niang_blog');
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
                exit();
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
    $get_id_article = $_GET['id'];
    $request = mysqli_query($bdd,"SELECT commentaire AS comment_is,
    id_article,
    commentaires.id_utilisateur AS commented_by,
    commentaires.date AS created_at,
    utilisateurs.id AS id_users,
    commentaires.id AS idCom
    FROM commentaires
    INNER JOIN articles
    INNER JOIN utilisateurs
    WHERE id_article= articles.id && utilisateurs.id=articles.id_utilisateur");
    $recup = mysqli_fetch_all($request, MYSQLI_ASSOC);
    foreach($recup as $com) {
        if ($recup_atc["id_article"] == $com["id_article"]) {
            $compt++;
            echo '<div class="ComAndProfil">';
            $idUser = $com["commented_by"];
            $idToLogin = mysqli_query($bdd,"SELECT * FROM utilisateurs WHERE $idUser = id");
            $Row = mysqli_num_rows($idToLogin);
            if($Row == 1){
                $fetch_idToLogin = mysqli_fetch_all($idToLogin, MYSQLI_ASSOC);
                foreach($fetch_idToLogin as $login){
                    $idDroit = $login['id_droits'];
                    $nomIdDroit = mysqli_query($bdd,"SELECT * FROM droits WHERE $idDroit = id");
                    $Row2 = mysqli_num_rows($nomIdDroit);
                    if($Row2 == 1){
                        $fetch_nomIdDroit = mysqli_fetch_all($nomIdDroit, MYSQLI_ASSOC);
                        foreach($fetch_nomIdDroit as $droit){
                            echo '<div class="show_profil">#'.$compt.'</br>'.' Commenté par : '.$login["login"].'</br> le '.$com["created_at"].'</br>Rôle : '.$droit["nom"].'</br></br></br>';
                            if(!empty($_SESSION['user'])){
                                $login = $_SESSION['user']['login'];
                                $id_droits = '1337';
                                $requete = mysqli_query($bdd, "SELECT * FROM utilisateurs WHERE login='".$login."' AND id_droits='".$id_droits."'");
                                $Row69= mysqli_num_rows($requete);
                                if($Row69 == 1){
                                    echo '<form method = POST><button class = "deco2" type = "submit" name = "supprimer" value ="Supprimer">SUPPRIMER</button></form></div>';
                                    if(isset($_POST['supprimer'])){
                                        $idCom = $com['idCom'];
                                        $DeleteCom = mysqli_query($bdd, "DELETE FROM commentaires WHERE id='$idCom'");
                                        header('Location: article.php?id='.$get_id_article);
                                        exit();
                                    }
                                }
                                else{
                                    echo '</div>';
                                }
                            }
                            else{
                                echo '</div>';
                            }
                        }
                    }
                }
            }
            else{
                echo '<div class="show_profil">#'.$compt.'</br>'.' Commenté par : <a class="UserDelete">Utilisateur supprimé</a></br> le '.$com["created_at"].'</br></br></br></div>';
            }
            echo '<div class="show_com">'.$com["comment_is"].'</br></div></br></div>';
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
    $dbname     = "francois-niang_blog";
    $dbuser     = "francois-niang1";
    $dbpass     = "bdblog";
    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
    if (!$_SESSION) {
        echo 'Veuillez vous connecter pour poster un commentaire.';
    } else {
        echo '<a class="comm" >Votre commentaire :<br /><textarea class = "send_com" name="commentaire" rows="10%" cols="90%"></textarea></a>';
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
        }
    }
}

function create_article() {
    $bdd = connect_database();
    $dbhost     = "localhost";
    $dbname     = "francois-niang_blog";
    $dbuser     = "francois-niang1";
    $dbpass     = "bdblog";
    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname",$dbuser,$dbpass, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
    if(isset($_POST['txt_article']) && isset($_POST['cat']) && isset($_POST['nom_article'])) {
        if (!$_POST['txt_article']) {
            echo '';
        }
        elseif ($_POST['cat'] == "choose") {
            echo 'Veuillez choisir une catégorie';
        }
        else {
            $title = $_POST['txt_article'];
            $id_user = $_SESSION['user']['id'];
            $id_cat = $_POST['cat'];
            $nom_article = $_POST['nom_article'];
            $articleExist = mysqli_query($bdd, "SELECT * FROM articles WHERE nom_article = '".$nom_article."' AND id_categorie = '".$id_cat."'");
            $check_if_same_cat= mysqli_num_rows($articleExist);
            if($check_if_same_cat == 1){
                echo 'Cet article existe déjà';
            }
            else{
                $sql = "INSERT INTO articles (article,nom_article, id_utilisateur,id_categorie) VALUES
                (:title,:nom_article, :id_user,:id_cat)";
                $q = $conn->prepare($sql);
                $q->bindValue('title' ,$title ,PDO::PARAM_STR);
                $q->bindValue('nom_article' ,$nom_article ,PDO::PARAM_STR);
                $q->bindValue('id_user' ,$id_user ,PDO::PARAM_INT);
                $q->bindValue('id_cat' ,$id_cat ,PDO::PARAM_INT);
                $q->execute();
                header('Location: articles.php');
                exit();
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
                exit();
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
            exit();
        }
    }
    else{
        header('Location: ../index.php');
        exit();
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
            echo'<p style="color:#FF0000";> <strong> Mot depasses non identiques</strong></p>';
        }
        else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo'<p style="color:#FF0000";> <strong> Entrez une adresse valide ex: user@wanadoo.com </strong></p>';
        }
        else if ($check_is_use_email == 1) {
            echo'<p style="color:#FF0000";> <strong> Email déjà utilisée </strong></p>';
        }
        else if ($login == NULL ||  $email == NULL || $password == NULL || $Confirmedpassword == NULL ) {
            echo'<p style="color:#FF0000";> <strong> Remplissez tous les champs</strong></p>';
        }
        else {
            $request_verif_login = mysqli_query($bdd, "SELECT * FROM utilisateurs WHERE login='$login' ");
            $check_is_use_login= mysqli_num_rows($request_verif_login);
            $pw_hash = password_hash($password, PASSWORD_DEFAULT);
            if($check_is_use_login == 1) {
                echo'<p style="color:#FF0000";> <strong>Login existant</strong></p>';
            }
            else  {
                $requete = mysqli_query($bdd, "INSERT INTO utilisateurs (email, login, password, id_droits) VALUES ('$email','$login','$pw_hash', 1)");
                header('Location: admin.php');
                exit();
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
        $Requete = mysqli_query($bdd, "SELECT * FROM utilisateurs WHERE login='$login'");
        $Rows= mysqli_num_rows($Requete);
        foreach ($_POST as $key => $value) {
            if($value == 'user'){
                $id_droits = '1';
            }
            else if($value == 'modo'){
                $id_droits = '42';
            }
        }
        if($Rows == 1){
            $check_if_admin = mysqli_query($bdd, "SELECT * FROM utilisateurs WHERE login='$login' AND id_droits='$role'");
            $Rows420= mysqli_num_rows($check_if_admin);
            if($Rows420 != 1){
                $Requete2 = mysqli_query($bdd, "UPDATE `utilisateurs` SET id_droits = '$id_droits' WHERE login = '$login'");
                header('Location: modif-user-admin.php');
                exit();
            }
            else{
                echo "<p>Vous n'avez pas le droit de changer le role d'un admin</p><style>p{color : var(--RedError-);}</style>";
            }
        }
        else{
            echo "<p>Utilisateur inexistant</p><style>p{color : var(--RedError-);}</style>";
        }
    }
    else if(isset($_POST['login'])){
        echo '<p>Remplissez tout les champs</p><style>p{color : var(--RedError-);}</style>';
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
                exit();
            }
            else{
                echo "<p>Cet utilisateur n'existe pas</p><style>p{color : var(--RedError-);}</style>";
            }
        }
        else if(isset($_POST['loginSupp'])){
            echo '<p>Remplissez tout les champs</p><style>p{color : var(--RedError-);}</style>';
        }
    }
    else{
        echo "<p>Vous n'avez pas le droit de supprimer un admin</p><style>p{color : var(--RedError-);}</style>";
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
                exit();
            }
            else{
                echo "<p>Cet utilisateur n'existe pas</p><style>p{color : var(--RedError-);}</style>";
            }
        }
        else{
            echo "<p>Vous ne pouvez pas utiliser ce login</p><style>p{color : var(--RedError-);}</style>";
        }
    }
    else if(isset($_POST['loginChange']) || isset($_POST['loginChangeN'])){
        echo '<p>Remplissez tout les champs</p><style>p{color : var(--RedError-);}</style>';
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
                exit();
            }
            else{
                echo "<p>Cet email n'existe pas</p><style>p{color : var(--RedError-);}</style>";
            }
        }
        else{
            echo "<p>Vous ne pouvez pas utiliser cet email</p><style>p{color : var(--RedError-);}</style>";
        }
    }
    else if(isset($_POST['emailChange']) || isset($_POST['emailChangeN'])){
        echo '<p>Remplissez tout les champs</p><style>p{color : var(--RedError-);}</style>';
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
            exit();
        }
        else{
            echo '<p>Cette catégorie est déjà existante</p><style>p{color : var(--RedError-);}</style>';
        }
    }
    else if(isset($_POST['categorieCreate'])){
        echo '<p>Remplissez tout les champs</p><style>p{color : var(--RedError-);}</style>';
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
            exit();
        }
        else{
            echo "<p>Cette catégorie n'existe pas</p><style>p{color : var(--RedError-);}</style>";
        }
    }
    else if(isset($_POST['categorieChange']) || isset($_POST['categorieChangeN'])){
        echo '<p>Remplissez tout les champs</p><style>p{color : var(--RedError-);}</style>';
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
            exit();
        }
        else{
            echo "<p>Cette catégorie n'existe pas</p><style>p{color : var(--RedError-);}</style>";
        }
    }
    else if(isset($_POST['categorieDelete'])){
        echo '<p>Remplissez tout les champs</p><style>p{color : var(--RedError-);}</style>';
    }
}

// francois

function Deconnect(){// Fonction permettant de Deconnexion
    if (isset($_POST['deconnexion'])) {
        session_destroy();
        header('Location: ../index.php');
        exit();
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
        exit();
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
                    $Bdd = mysqli_connect('localhost', 'francois-niang1', 'bdblog', 'francois-niang_blog') or die('Erreur');
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
        exit();
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
                    $Bdd = mysqli_connect('localhost', 'francois-niang1', 'bdblog', 'francois-niang_blog') or die('Erreur');
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
                        exit();
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
        exit();
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
        $Bdd = mysqli_connect('localhost', 'francois-niang1', 'bdblog', 'francois-niang_blog') or die('Erreur');
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
    if(isset($_GET['page']) && !empty($_GET['page'])){
        $currentPage = (int) strip_tags($_GET['page']);
    }
    else{
        $currentPage = 1;
    }
    $Bdd = connect_database();
    if(isset($_GET['categorie'])){
        $id_cat = $_GET['categorie'];
    }
    $sql_count = "SELECT COUNT(*) AS nb_articles FROM articles";
    $requete_count = mysqli_query($Bdd, $sql_count);
    $fetch_count = mysqli_fetch_assoc($requete_count);
    $nbArticles = (int) $fetch_count['nb_articles'];
    $parPage = 5;
    // ! ceil Arrondit au nombre supérieur
    $pages = ceil($nbArticles / $parPage);
    $premier = ($currentPage * $parPage) - $parPage;
    if(isset($id_cat)){
        if(is_numeric($id_cat)){
            $requete_recup_articles = mysqli_query($Bdd, "SELECT categories.nom AS category_name, articles.article AS article_name,
            articles.date AS created_at,articles.nom_article AS article_title, utilisateurs.login AS created_by, articles.id AS article_id
                                                FROM categories
                                                INNER JOIN articles
                                                INNER JOIN utilisateurs
                                                WHERE articles.id_categorie = categories.id && utilisateurs.id = articles.id_utilisateur && categories.id = $id_cat
                                                ORDER BY date DESC LIMIT $premier, $parPage ");
            $articles = mysqli_fetch_all($requete_recup_articles, MYSQLI_ASSOC);
            $requete_recup_categories = mysqli_query($Bdd, "SELECT * FROM categories ");
            $categories = mysqli_fetch_all($requete_recup_categories, MYSQLI_ASSOC);
            foreach ($articles as $article){
                ?>
                <div class='articles'>
                    <p><?=$article['article_title']?></p>
                    <div class='wrapper'>
                    <a href='#demo-modal <?= $article['article_id']?>'><button class='button'>Lire la suite</button></a>
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
                                <?php echo "<button class ='button-com'><a href='article.php?id=".$article['article_id']."'>Voir/Laisser un commentaire</a></button>"; ?>
                                </form>
                            </div>
                            <a href='#' class='modal-close'>&times;</a>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        else{
            echo 'Catégorie inexistante !!';
        }
    }
    else if(!isset($id_cat)){
        $requete_recup_articles = mysqli_query($Bdd, "SELECT categories.nom AS category_name, articles.article AS article_name,
        articles.date AS created_at,articles.nom_article AS article_title, utilisateurs.login AS created_by, articles.id AS article_id
                                            FROM categories
                                            INNER JOIN articles
                                            INNER JOIN utilisateurs
                                            WHERE articles.id_categorie = categories.id && utilisateurs.id = articles.id_utilisateur
                                            ORDER BY date DESC LIMIT $premier, $parPage ");
        $articles = mysqli_fetch_all($requete_recup_articles, MYSQLI_ASSOC);
        $requete_recup_categories = mysqli_query($Bdd, "SELECT * FROM categories ");
        $categories = mysqli_fetch_all($requete_recup_categories, MYSQLI_ASSOC);
        foreach ($articles as $article){
            ?>
            <div class='articles'>
                <p><?=$article['article_title']?></p>
                <div class='wrapper'>
                <a href='#demo-modal <?= $article['article_id']?>'><button class='button'>Lire la suite</button></a>
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
                            <?php echo "<button class ='button-com'><a href='article.php?id=".$article['article_id']."'>Voir/Laisser un commentaire</a></button>"; ?>
                            </form>
                        </div>
                        <a href='#' class='modal-close'>&times;</a>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}

function show_categories() {
    $bdd = connect_database();
    $sql = mysqli_query($bdd, "SELECT * FROM categories");
    $row2 = mysqli_fetch_all($sql, MYSQLI_ASSOC);
    foreach ($row2 as $value_cat) {
        ?>
        <form methode="get">
        <?php
        echo "<a href='articles.php?categorie=".$value_cat['id']."'>".$value_cat["nom"]."</a>";
        ?>
        </form>
        <?php
    }
    if(isset($_GET['categorie'])){
        $id_cat = $_GET['categorie'];
    }
}

function show_categories_index() {
    $bdd = connect_database();
    $sql = mysqli_query($bdd, "SELECT * FROM categories");
    $row2 = mysqli_fetch_all($sql, MYSQLI_ASSOC);
    foreach ($row2 as $value_cat) {
        ?>
        <form methode="get">
        <?php
        echo "<a href='php/articles.php?categorie=".$value_cat['id']."'>".$value_cat["nom"]."</a>";
        ?>
        </form>
        <?php
    }
    if(isset($_GET['categorie'])){
        $id_cat = $_GET['categorie'];
    }
}

function recup_article_index($place){
    $bdd = connect_database();
    if(isset($place)){
        $requete = mysqli_query($bdd, "SELECT * FROM articles WHERE id = (SELECT max(id)-$place FROM articles)");
        $row = mysqli_fetch_all($requete, MYSQLI_ASSOC);
        foreach($row as $value){
            ?>
            <form methode="get">
            <?php
            echo "<a>".$value["article"]."</a></br></br></br>";
            echo "<button class ='button'><a href='php/article.php?id=".$value['id']."'>Voir/Laisser un commentaire</a></button>";
            ?>
            </form>
            <?php
        }
        if(empty($row)){
            echo '</br></br></br><a class="DELETE">Article supprimé</a>';
        }
    }
}

function pagination(){
    if(isset($_GET['page']) && !empty($_GET['page'])){
        $currentPage = (int) strip_tags($_GET['page']);
    }
    else{
        $currentPage = 1;
    }
    if(isset($_GET['categorie'])){
        $id_cat = $_GET['categorie'];
    }
    $Bdd = connect_database();
    $sql_count = "SELECT COUNT(*) AS nb_articles FROM articles";
    $requete_count = mysqli_query($Bdd, $sql_count);
    $fetch_count = mysqli_fetch_assoc($requete_count);
    $nbArticles = (int) $fetch_count['nb_articles'];
    $parPage = 5;
    // ! ceil Arrondit au nombre supérieur
    $pages = ceil($nbArticles / $parPage);
    $premier = ($currentPage * $parPage) - $parPage;
    if(isset($id_cat)){
        if(is_numeric($id_cat)){
            ?>
            <nav>
                <ul class="pagination">
                    <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
                    <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                        <a href="./articles.php?categorie=<?=$id_cat?>&page=<?= $currentPage - 1 ?>" class="page-link"><<</a>
                    </li>
                    <?php for($page = 1; $page <= $pages; $page++): ?>
                    <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                    <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                        <a href="./articles.php?categorie=<?=$id_cat?>&page=<?= $page ?>" class="page-link"><?= $page ?></a>
                    </li>
                    <?php endfor ?>
                    <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                    <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                        <a href="./articles.php?categorie=<?=$id_cat?>&page=<?= $currentPage + 1 ?>" class="page-link">>></a>
                    </li>
                </ul>
            </nav>
            <?php
        }
        else{
            echo '<p>Catégorie inexistante !!</p><style>p{color : var(--RedError-);}</style>';
        }
    }
    else if(!isset($id_cat)){
        ?>
        <nav>
                <ul class="pagination">
                    <!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
                    <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                        <a href="./articles.php?page=<?= $currentPage - 1 ?>" class="page-link"><<</a>
                    </li>
                    <?php for($page = 1; $page <= $pages; $page++): ?>
                    <!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
                    <li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
                        <a href="./articles.php?page=<?= $page ?>" class="page-link"><?= $page ?></a>
                    </li>
                    <?php endfor ?>
                    <!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
                    <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                        <a href="./articles.php?page=<?= $currentPage + 1 ?>" class="page-link">>></a>
                    </li>
                </ul>
            </nav>
            <?php
    }
}

function show_article_admin(){
    $bdd = connect_database();
    $requeteArticles = mysqli_query($bdd, "SELECT * FROM articles");
    $Articles = mysqli_fetch_all($requeteArticles, MYSQLI_ASSOC);
    foreach($Articles as $Art){
        $idCate = $Art['id_categorie'];
        $nomCate = mysqli_query($bdd,"SELECT * FROM categories WHERE $idCate = id");
        $Row = mysqli_num_rows($nomCate);
        if($Row == 1){
            $fetch_nomCate = mysqli_fetch_all($nomCate, MYSQLI_ASSOC);
            foreach($fetch_nomCate as $C){
                echo '<tr><td>'.$Art['id'].'</td>';
                echo '<td>'.$Art['nom_article'].'</td>';
                echo '<td>'.$C['nom'].'</td>';
            }
        }
    }
}

function change_article_nom(){
    $bdd = connect_database();
    if(!empty($_POST['articleChange']) && !empty($_POST['articleChangeN'])){
        $article = $_POST['articleChange'];
        $Narticle = $_POST['articleChangeN'];
        $Requete = mysqli_query($bdd, "SELECT * FROM articles WHERE id ='$article'");
        $Rows = mysqli_num_rows($Requete);
        $ArticleD = mysqli_fetch_all($Requete, MYSQLI_ASSOC);
        foreach($ArticleD as $D){
            $id_cat = $D['id_categorie'];
        }
        if($Rows == 1){
            $articleCheck = mysqli_query($bdd, "SELECT * FROM articles");
            $articleExist = mysqli_query($bdd, "SELECT * FROM articles WHERE nom_article = '".$Narticle."' AND id_categorie = '".$id_cat."'");
            $check_if_same_cat= mysqli_num_rows($articleExist);
            if($check_if_same_cat != 1){
                $RequeteChange = mysqli_query($bdd, "UPDATE articles SET nom_article = '$Narticle' WHERE id = '$article'");
                header('Location: modif-articles-admin.php');
                exit();
            }
            else{
                echo "<p>Cet article existe déjà</p><style>p{color : var(--RedError-);}</style>";
            }
        }
        else{
            echo "<p>Cet article n'existe pas</p><style>p{color : var(--RedError-);}</style>";
        }
    }
    else if(isset($_POST['articleChange']) || isset($_POST['articleChangeN'])){
        echo '<p>Remplissez tout les champs</p><style>p{color : var(--RedError-);}</style>';
    }
}

function modif_article(){
    $bdd = connect_database();
    if(!empty($_POST['articleModifName']) && !empty($_POST['articleModif'])){
        $articleName = $_POST['articleModifName'];
        $articleModif = $_POST['articleModif'];
        $Requete = mysqli_query($bdd, "SELECT * FROM articles WHERE id ='$articleName'");
        $Rows = mysqli_num_rows($Requete);
        if($Rows == 1){
            $RequeteChange = mysqli_query($bdd, "UPDATE articles SET article = '$articleModif' WHERE id = '$articleName'");
            header('Location: modif-articles-admin.php');
            exit();
        }
        else{
            echo "<p>Cet article n'existe pas</p><style>p{color : var(--RedError-);}</style>";
        }
    }
    else if(isset($_POST['articleModifName']) || isset($_POST['articleModif'])){
        echo '<p>Remplissez tout les champs</p><style>p{color : var(--RedError-);}</style>';
    }
}

function delete_article(){
    $bdd = connect_database();
    if(!empty($_POST['articleDelete'])){
        $article = $_POST['articleDelete'];
        $Requete = mysqli_query($bdd, "SELECT * FROM articles WHERE id ='$article'");
        $Rows = mysqli_num_rows($Requete);
        if($Rows == 1){
            $RequeteDelete =  mysqli_query($bdd, "DELETE FROM articles WHERE id='$article'");
            header('Location: modif-articles-admin.php');
            exit();
        }
        else{
            echo "<p>Cet article n'existe pas</p><style>p{color : var(--RedError-);}</style>";
        }
    }
    else if(isset($_POST['articleDelete'])){
        echo '<p>Remplissez tout les champs</p><style>p{color : var(--RedError-);}</style>';
    }
}

function display_article(){
    $bdd = connect_database();
    $id_article = $_GET['id'];
    $display_article = mysqli_query($bdd, "SELECT * FROM articles WHERE id = '$id_article'");
    $ArticleD = mysqli_fetch_all($display_article, MYSQLI_ASSOC);
    foreach($ArticleD as $D){
        echo "<div class = 'Controller'><div class='display_article'><p>".$D['article']."</p></div></div>";
    }
}
?>