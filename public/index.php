<?php

use Core\Request;
use Core\Router;

header_remove("X-Powered-By");

if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_lifetime' => 86400,
        'cookie_secure'   => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
        'cookie_httponly' => true,
        'cookie_samesite' => 'Lax'
    ]);
}

$basePath = dirname(__DIR__);

$autoloadPath = $basePath . '/vendor/autoload.php';
if (!file_exists($autoloadPath)) {
    http_response_code(500);
    require_once $basePath . '/views/errors/composer_error.php';
    exit;
}
require_once $autoloadPath;

$config = $basePath . '/config/config.php';
if (!file_exists($config)) {
    http_response_code(500);
    require_once $basePath . '/views/errors/config_error.php';
    exit;
}
$config = require_once $basePath . '/config/config.php';
$isDebug = $config['app']['debug'] ?? false;

if (class_exists('\Core\ErrorHandler')) {
    \Core\ErrorHandler::register($isDebug);
}

$db = require_once $basePath . '/config/Database.php';
\Core\App::setDb($db);

$router = new Router();
$request = new Request();

$listRoute = require_once $basePath . '/config/routes.php';
$router->add($listRoute);
$router->dispatch($request);
