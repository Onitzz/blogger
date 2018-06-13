<?php
require 'init.php';
require LIB_PATH . DS . 'user.php';


hasSession();

$title = "Dashboard";


include THEME_PATH . DS . 'dashboard.phtml';