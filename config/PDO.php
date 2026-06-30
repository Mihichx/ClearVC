<?
$host = 'localhost';
$dbname = '';
$username = 'root';
$password = '';
$charset = 'utf8';
$strConnect = "mysql:host=$host; dbname=$dbname; charset=$charset";

try {
    $connect = new PDO($strConnect, $username, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения к БД: " . $e->getMessage());
}
    
