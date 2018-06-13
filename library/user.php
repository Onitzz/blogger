<?php
// user.php

function hasSession(){
    if(!isset($_SESSION['user'])){
        header('Location: login.php');
        exit;
    }

}

function authenticate(PDO $pdo, $username, $password) {
    $sql = 'SELECT * FROM user WHERE username=?';
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute(array($username))) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            unset($user['password']);
            return $user;
        }
    }

    return false;
}

function createUser(PDO $pdo, $username, $email, $password){
    $today = date("Y-m-d H:i:s");
    $sql = 'INSERT INTO user(`username`,`email`,`password`,`created_at`) VALUES(?,?,?,?)';
    $stmt = $pdo->prepare($sql);


    if($stmt->execute(array($username, $email, password_hash($password,PASSWORD_BCRYPT), $today))){
        return $stmt->rowCount();
    }
    return 0;
}

function ifExist(PDO $pdo,$champ ,$value){
    $sql = 'SELECT user_id FROM user where '.$champ.' = ?';
    $stmt = $pdo->prepare($sql);

    if($stmt->execute(array($value))){
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if($user !== false){
            return true;
        }
    }
}


