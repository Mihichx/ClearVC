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
    }

    public static function handleException(\Throwable $exception): void
    {
        self::render($exception);
    }

    public static function handleError(int $level, string $message, string $file, int $line): void
    {
        self::render(new \ErrorException($message, 0, $level, $file, $line));
    }

    private static function render(\Throwable $exception): void
    {
        if (ob_get_length()) ob_end_clean();

        if (!self::$debug) {
            http_response_code(500);
            $error = 500;
            $text_error = 'Ошибка на сервере';
            require_once __DIR__ . '/../views/errors/http.php';
            exit;
        }

        http_response_code(500);
        require_once __DIR__ . '/../views/errors/error.php';
        exit;
    }
}
