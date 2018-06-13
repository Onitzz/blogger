<?php

require 'init.php';

unset($_SESSION['user']);
$_SESSION = [];
session_destroy();

header('Location: index.php');