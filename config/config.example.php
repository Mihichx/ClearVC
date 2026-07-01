<?php

/**
 * Глобальный конфигурационный файл приложения.
 * 
 * Возвращает ассоциативный массив настроек, сгруппированных по модулям.
 * Из соображений безопасности данный файл должен быть добавлен в .gitignore
 * и настраиваться индивидуально на каждом сервере.
 *
 * @return array{
 *     db: array{
 *         host: string,
 *         dbname: string,
 *         username: string,
 *         password: string,
 *         charset: string
 *     }
 * }
 */
return [
    'db' => [
        'host'     => 'your',
        'dbname'   => 'your',
        'username' => 'your',
        'password' => 'your',
        'charset'  => 'utf8mb4'
    ],
    // Сюда в будущем можно будет дописывать другие настройки фреймворка
];
