<?php
// login.php
require 'init.php';
require LIB_PATH . DS . 'user.php';

$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;

// Validation du formulaire.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = authenticate($db, $username, $password);
    var_dump($user);
}

// Affichage de la vue.
$title = "Page de connexion";
$styles = [BASE_URL.'/views/'.THEME.'/css/signin.css'];

include THEME_PATH . DS . 'login.phtml';
