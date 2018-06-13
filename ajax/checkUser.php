<?php

require '../init.php';
require LIB_PATH . DS . 'user.php';

$name = $_GET['name'] ?? '';
$email = $_GET['email'] ?? '';
$data = new stdClass();
$data->hasUser = false;
$data->hasEmail= false;

if(!empty($name)) {
    $data->hasUser = ifExist($db,'username', $name);
}

if(!empty($email)) {
    $data->hasEmail = ifExist($db,'email', $email);
}

header('Content-Type: application/json');
echo json_encode($data);