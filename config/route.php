<?php

/**
 * Карта маршрутов приложения (Роутинг).
 * 
 * Каждый элемент массива представляет собой отдельный маршрут:
 * [0] string - URL-адрес (например, '/' или '/docs') или '*' для динамических модулей
 * [1] string - Обработчик в формате 'ИмяКонтроллера@метод' или специальный флаг
 * [2] string - HTTP-метод (GET, POST). //TODO: Добавить новые методы
 *
 * @var array<int, array<int, string>>
 */
return [
    ['/', 'PageController@index', 'GET'],
    ['/docs', 'PageController@docs', 'GET'],
    ['/routes', 'PageController@routes', 'GET'],
    ['*', 'DYNAMIC_MODULES_FALLBACK', 'GET'],
    ['*', 'DYNAMIC_MODULES_FALLBACK', 'POST'],
];
