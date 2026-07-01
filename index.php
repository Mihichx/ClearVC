<?php

session_start();

require_once __DIR__ . '/config/PDO.php';

/** @var PDO $connect */

// Подгружаем Роутер и карту маршрутов
require_once 'Router.php';
$listRoute = require_once __DIR__ . '/config/route.php';

// Инициализируем роутинг и запускаем приложение
$router = new Router();
$router->add($listRoute);

// Передаем объект базы данных в диспетчер (теперь IDE знает, что мы передаем именно PDO)
$router->dispatch($connect);
