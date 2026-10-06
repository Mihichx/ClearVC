<?php

namespace Core;

class ErrorHandler
{
    private static bool $debug = true;

    public static function register(bool $debug = true): void
    {
        self::$debug = $debug;

        set_exception_handler([self::class, 'handleException']);
        set_error_handler([self::class, 'handleError']);

        register_shutdown_function([self::class, 'handleFatalError']);
    }

    public static function handleException(\Throwable $exception): void
    {
        self::render($exception);
    }

    public static function handleError(int $level, string $message, string $file, int $line): void
    {
        self::render(new \ErrorException($message, 0, $level, $file, $line));
    }

    public static function handleFatalError(): void
    {
        $error = error_get_last();
        if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
            self::render(new \ErrorException($error['message'], 0, $error['type'], $error['file'], $error['line']));
        }
    }

        private static function render(\Throwable $exception): void
    {
        if (ob_get_length()) ob_end_clean();

        $basePath = dirname(__DIR__);
        $statusCode = 500;
        $text_error = 'Внутренняя ошибка сервера';

        // Если у исключения есть код
        $exceptionCode = (int)$exception->getCode();
        if (in_array($exceptionCode, [400, 401, 403, 404, 405])) {
            $statusCode = $exceptionCode;
            $text_error = $exception->getMessage();
        } 
        // Перехватываем ошибки типов от левых POST/GET параметров
        elseif ($exception instanceof \InvalidArgumentException || $exception instanceof \TypeError) {
            $statusCode = 400;
            $text_error = 'Некорректный запрос (Неверные параметры)';
        }

        // Выставляем правильный HTTP-статус в заголовки ответа
        http_response_code($statusCode);

        // Если режим отладки выключен
        if (!self::$debug) {
            $error = $statusCode;
            
            require_once $basePath . '/views/errors/http.php';
            exit;
        }

        // Если режим отладки включён
        require_once $basePath . '/views/errors/error.php';
        exit;
    }
}
