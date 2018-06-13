<?php
require 'init.php';

if(!isset($_SESSION['user'])){
    header('Location: login.php');
    exit;
}

echo 'Hello';