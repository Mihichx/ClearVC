<?php

/**
 * Файл инициализации подключения к базе данных MySQL через PDO.
 * 
 * Проверяет конфигурационный массив, валидирует параметры и возвращает
 * настроенный объект подключения или прерывает выполнение при дефолтных настройках.
 * 
 * @var array{db: array{host: string, dbname: string, charset: string, username: string, password: string}} $config Глобальный массив конфигурации приложения
 * @return \PDO|null Возвращает объект PDO при успешном подключении или null/прерывает работу, если конфиг не задан
 * @throws \RuntimeException Если не удалось подключиться к базе данных с указанными параметрами
 */

$connect = null; 

if (isset($config) && !empty($config['db']['dbname'])) { 
    $dbConf = $config['db']; 
    
    if ($dbConf['host'] === 'your' || $dbConf['dbname'] === 'your') { 
        return null; 
    } 
    
    $strConnect = "mysql:host={$dbConf['host']};dbname={$dbConf['dbname']};charset={$dbConf['charset']}"; 
    
    try { 
        $connect = new PDO($strConnect, $dbConf['username'], $dbConf['password']); 
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        $connect->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
    } catch (PDOException $e) { 
        throw new \RuntimeException("Ошибка подключения к базе данных: " . $e->getMessage()); 
    } 
    
    return $connect; 
}
