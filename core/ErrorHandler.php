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
