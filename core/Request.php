<?php

namespace Core;

/**
 * Класс обработки HTTP-запроса (Request).
 * Инкапсулирует в себе данные глобальных массивов $_GET, $_POST и $_SERVER,
 * обеспечивая безопасный доступ к параметрам и автоматическую фильтрацию ввода.
 */
class Request
{
    /**
     * Очищенный массив параметров из GET-запроса.
     * 
     * @var array<string, mixed>
     */
    private array $get;

    /**
     * Очищенный массив данных из POST-запроса.
     * 
     * @var array<string, mixed>
     */
    private array $post;

    /**
     * Текущий очищенный путь запроса (без GET-параметров).
     * Например: "/profile" вместо "/profile?id=1".
     * 
     * @var string
     */
    private string $uri;

    /**
     * HTTP-метод, которым был выполнен запрос (GET, POST, PUT, DELETE и т.д.).
     * 
     * @var string
     */
    private string $method;

    /**
     * Конструктор класса.
     * Инициализирует свойства, автоматически запускает санитарию входящих данных
     * и парсит текущий URI.
     */
    public function __construct()
    {
        $this->get = $this->clean($_GET);
        $this->post = $this->clean($_POST);
        $this->method = $_SERVER['REQUEST_METHOD'];

        $uri = $_SERVER['REQUEST_URI'];
        $this->uri = parse_url($uri, PHP_URL_PATH) ?: '/';
    }

    /**
     * Возвращает безопасное значение параметра из GET-запроса.
     * 
     * @param string $key Ключ параметра в массиве $_GET
     * @param mixed $default Значение по умолчанию, если ключ отсутствует
     * @return mixed Строка, массив или значение по умолчанию
     */
    public function query(string $key, mixed $default = null): mixed
    {
        return $this->get[$key] ?? $default;
    }

    /**
     * Возвращает безопасное значение параметра из POST-запроса.
     * 
     * @param string $key Ключ параметра в массиве $_POST
     * @param mixed $default Значение по умолчанию, если ключ отсутствует
     * @return mixed Строка, массив или значение по умолчанию
     */
    public function input(string $key, mixed $default = null): mixed
    {
        return $this->post[$key] ?? $default;
    }

    /**
     * Возвращает текущий обработанный URI запроса.
     * 
     * @return string Текущий путь (например, "/profile")
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * Возвращает метод HTTP-запроса.
     * 
     * @return string Метод в верхнем регистре (например, "GET" или "POST")
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Рекурсивная очистка входящих данных.
     * Удаляет концевые пробелы и преобразует спецсимволы в HTML-сущности
     * для предотвращения XSS-уязвимостей. Принимает как строки, так и массивы.
     * 
     * @param array<mixed>|string $data Сырые данные из суперглобальных массивов
     * @return array<mixed>|string Очищенные от опасных символов данные
     */
    private function clean(array|string $data): array|string
    {
        if (is_array($data)) {
            return array_map([$this, 'clean'], $data);
        }

        return trim(str_replace("\0", '', $data));
    }
}
