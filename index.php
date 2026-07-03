<?php

session_start();

$autoloadPath = __DIR__ . '/vendor/autoload.php';

// Проверяем наличие автозагрузчика Composer
if (!file_exists($autoloadPath)) {
    http_response_code(500);
    
    // Ищем папку views относительно корня проекта (где лежит index.php)
    require_once __DIR__ . '/views/composer_error.php';
    
    exit;
}

require_once $autoloadPath;

/** @var PDO $connect */
require_once __DIR__ . '/config/PDO.php';

// Загружаем карту маршрутов
$listRoute = require_once __DIR__ . '/config/route.php';

// Инициализируем роутинг с учетом пространства имен Core
$router = new \Core\Router();
$router->add($listRoute);

// Передаем объект базы данных в диспетчер
$router->dispatch($connect);
