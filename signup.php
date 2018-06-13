<?php

require 'init.php';
require LIB_PATH . DS . 'user.php';
require LIB_PATH . DS . 'validator.php';

$errors = [];


//validation formulaire
echo ifExist($db, 'username', 'john');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'] ?? null;
    $password = $_POST['passWord'] ?? null;
    $passwordConfirm = $_POST['passWordConfirm'] ?? null;
    $email = $_POST['email'] ?? null;

    if(!validUsername($username,3,12)){
        $errors[] = 'Identifiant incorrect';
    }

    if(!validEmail($email)){
        $errors[] = 'Email incorrect';
    }

    if(validPassword($password,$passwordConfirm)){
        $errors[] = 'Mot de passe incorrect';
    }

    if(!ifExist($db,'username', $username) && !empty($username)){
        $errors[] = 'Ce nom d\'utilisateur n\'est pas autorisé';
    }

    if(!ifExist($db,'email', $email) && !empty($email)){
        $errors[] = 'Cet email est déjà enregistré';
    }




    if(empty($errors)) {

        $username = strip_tags($username);
        $password = strip_tags($password);
        $email = strip_tags($email);
        $user = createUser($db, $username, $email, $password);
        if ($user == 1) {
            $user = authenticate($db, $username, $password);
            if($user) {
                $_SESSION['user'] = $user;
                header('Location: dashboard.php');
            }
        } else {
            $errors[] =  'un problem est survenue';
        }
    }
}


// Affichage de la vue.
$title = "Page d'inscription";
$styles = [BASE_URL.'/views/'.THEME.'/css/signin.css'];


include THEME_PATH . DS . 'signup.phtml';
