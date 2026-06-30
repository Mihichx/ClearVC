<?php

$configPath = __DIR__ . '/config.php';
$connect = null;

if (file_exists($configPath)) {
    $config = require_once $configPath;
    
    if (!empty($config['db']['dbname'])) {
        $dbConf = $config['db'];
        $strConnect = "mysql:host={$dbConf['host']};dbname={$dbConf['dbname']};charset={$dbConf['charset']}";

        try {
            $connect = new PDO($strConnect, $dbConf['username'], $dbConf['password']);
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $connect->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("[" . date('Y-m-d H:i:s') . "] Предупреждение БД: " . $e->getMessage() . PHP_EOL, 3, __DIR__ . '/db_errors.log');
        }
    }
}
