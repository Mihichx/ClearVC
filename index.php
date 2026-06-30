<?php
session_start();

// раскоммениторуйте подходящее вам подключение в каталоге config.
// mysqli.php или PDO.php и выполните настройку
require_once __DIR__ . '/config/PDO.php';
// require_once __DIR__ . '/config/mysqli.php';

// служебная часть
require_once 'Router.php';
$listRoute = require_once __DIR__ . '/config/route.php';
$router = new Router();
$router->add($listRoute);
$router->dispatch();