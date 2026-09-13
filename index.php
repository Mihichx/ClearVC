<?php

if (session_status() === PHP_SESSION_NONE) session_start(); 

// Проверяем наличие автозагрузчика Composer
$autoloadPath = __DIR__ . '/vendor/autoload.php';
if (!file_exists($autoloadPath)) {
    http_response_code(500);
    require_once __DIR__ . '/views/errors/composer_error.php';
    exit;
}
require_once $autoloadPath;

// Проверяем наличие конфига
$config = __DIR__ . '/config/config.php';
if (!file_exists($config)) {
    http_response_code(500);
    require_once __DIR__ . '/views/errors/config_error.php';
    exit;
}
$config = require_once __DIR__ . '/config/config.php';
$isDebug = $config['app']['debug'] ?? false;

\Core\ErrorHandler::register($isDebug);

require_once __DIR__ . '/config/PDO.php';

$listRoute = require_once __DIR__ . '/config/route.php';

$router = new \Core\Router();
$router->add($listRoute);
$router->dispatch($connect);
