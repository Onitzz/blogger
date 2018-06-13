<?php

require 'init.php';
require LIB_PATH . DS . 'blog.php';

$title = "Blog";
$articles = getArticles($db);

include THEME_PATH . DS . 'blog.phtml';