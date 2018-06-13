<?php

require '../init.php';
require LIB_PATH . DS . 'user.php';


hasSession();

require LIB_PATH . DS . 'blog.php';

$title = "Mes articles à moi";
$articles = getUserArticle($db, $_SESSION['user']['user_id']);

include THEME_PATH . DS . 'blog/mes-articles.phtml';