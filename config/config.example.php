<?php

/**
 * Глобальный конфигурационный файл приложения.
 * 
 * Возвращает ассоциативный массив настроек, сгруппированных по модулям.
 * Из соображений безопасности данный файл должен быть добавлен в .gitignore
 * и настраиваться индивидуально на каждом сервере.
 *
 * @return array{
 *     app: array{
 *         debug: bool
 *     }
 * 
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
    'app' => [
        'debug' => true,
    ],

    'db' => [
        'host'     => 'your',
        'dbname'   => 'your',
        'username' => 'your',
        'password' => 'your',
        'charset'  => 'utf8mb4'
    ],
];
