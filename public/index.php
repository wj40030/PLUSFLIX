<?php
session_start();

require_once '../config/config.php';
require_once '../app/helpers/auth_helper.php';

spl_autoload_register(function($className) {
    $className = str_replace('\\', '/', $className);
    $file = '../' . $className . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

use Core\Router;

$init = new Router();
