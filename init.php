<?php

define('DS', DIRECTORY_SEPARATOR);

require 'config' . DS . 'app.php';

// On|Off
ini_set('display_errors', 'On');

$db = new PDO(DB_DSN, DB_USER, DB_PASS);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

session_start();
