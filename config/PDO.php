<?php

$connect = null;

// Используем уже загруженный в index.php массив конфигурации $config
if (isset($config) && !empty($config['db']['dbname'])) {
    $dbConf = $config['db'];

    if ($dbConf['host'] === 'your' || $dbConf['dbname'] === 'your') {
        return;
    }

    $strConnect = "mysql:host={$dbConf['host']};dbname={$dbConf['dbname']};charset={$dbConf['charset']}";

    try {
        $connect = new PDO($strConnect, $dbConf['username'], $dbConf['password']);
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connect->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new \RuntimeException("Ошибка подключения к базе данных: " . $e->getMessage());
    }
}
