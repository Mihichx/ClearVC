<?php

session_start();

// Подключаем единый автозагрузчик Composer
require_once __DIR__ . '/vendor/autoload.php';

/** @var PDO $connect */
require_once __DIR__ . '/config/PDO.php';

// Загружаем карту маршрутов
$listRoute = require_once __DIR__ . '/config/route.php';

// Инициализируем роутинг с учетом пространства имен Core
$router = new \Core\Router();
$router->add($listRoute);

// Передаем объект базы данных в диспетчер
$router->dispatch($connect);
