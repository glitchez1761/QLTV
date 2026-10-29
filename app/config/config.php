<?php
if (!defined('APP_ROOT')) {
    define('APP_ROOT', dirname(__DIR__));
}

if (!defined('BASE_URL')) {
    define('BASE_URL', '/QLTV');
}

if (!defined('APP_LEGACY_ROOT')) {
    define('APP_LEGACY_ROOT', APP_ROOT . '/library_MVC');
}

if (!defined('DB_HOST')) {
    define('DB_HOST', 'localhost');
}
if (!defined('DB_NAME')) {
    define('DB_NAME', 'quan_ly_thu_vien');
}
if (!defined('DB_USER')) {
    define('DB_USER', 'root');
}
if (!defined('DB_PASS')) {
    define('DB_PASS', '');
}
if (!defined('DB_CHARSET')) {
    define('DB_CHARSET', 'utf8mb4');
}

date_default_timezone_set('Asia/Ho_Chi_Minh');
