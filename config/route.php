<?php

/**
 * Карта маршрутов приложения (Роутинг).
 * 
 * Каждый элемент массива представляет собой отдельный маршрут:
 * [0] string - URL-адрес (например, '/' или '/docs') или '*' для динамических модулей
 * [1] string - Обработчик в формате 'ИмяКонтроллера@метод' или специальный флаг
 * [2] string - HTTP-метод (GET, POST). По умолчанию: GET
 *
 * @var array<int, array<int, string>>
 */
return [
    ['/', 'PageController@index'],
    ['/docs', 'PageController@docs'],
    ['/routes', 'PageController@routes'],
    ['*', 'DYNAMIC_MODULES_FALLBACK'],
    ['*', 'DYNAMIC_MODULES_FALLBACK', 'POST'],
];
