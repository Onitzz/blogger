<?php

// config/app.php

// DIRECTORIES
define('ROOT_PATH', dirname(__DIR__));
define('LIB_PATH', ROOT_PATH . DS . 'library');
define('VIEWS_PATH', ROOT_PATH . DS . 'views');
define('CONF_PATH', ROOT_PATH . DS . 'config');

// DATABASE
// DSN == Data source name
define('DB_DSN', 'mysql:host=localhost;dbname=aston;charset=utf8');
define('DB_USER', 'root');
define('DB_PASS', '');

// APP
define('APP_NAME', 'Aston');
define('THEME', 'default');
define('THEME_PATH', VIEWS_PATH . DS . THEME);
define('BASE_URL', '/blogger');
