<?php

namespace Core;

/**
 * Класс глобального перехвата и обработки ошибок (ErrorHandler).
 * Регистрирует кастомные обработчики для всех типов исключений, runtime-ошибок
 * и фатальных сбоев, обеспечивая красивый вывод отладочной информации 
 * или контролируемых страниц ошибок (404, 500 и т.д.).
 */
class ErrorHandler
{
    /**
     * Режим отладки (дебага).
     * Если true — выводится детальный стек вызовов и файл ошибки.
     * Если false — пользователь видит только лаконичную страницу заглушки.
     * 
     * @var bool
     */
    private static bool $debug = false;

    /**
     * Регистрирует систему обработки ошибок в ядре PHP.
     * Перехватывает стандартные механизмы PHP и перенаправляет их на методы класса.
     * 
     * @param bool $debug Флаг активации режима отладки (по умолчанию false)
     * @return void
     */
    public static function register(bool $debug = false): void
    {
        self::$debug = $debug;

        set_exception_handler([self::class, 'handleException']);

        set_error_handler([self::class, 'handleError']);

        register_shutdown_function([self::class, 'handleFatalError']);
    }

    /**
     * Обработчик невыловленных исключений.
     * Автоматически вызывается ядром PHP при выбросе любого необработанного Exception.
     * 
     * @param \Throwable $exception Объект перехваченного исключения
     * @return void
     */
    public static function handleException(\Throwable $exception): void
    {
        self::render($exception);
    }

    /**
     * Обработчик стандартных runtime-ошибок PHP.
     * Преобразует обычные системные предупреждения в объект ErrorException 
     * для стандартизации процесса рендеринга.
     * 
     * @param int $level Уровень ошибки (например, E_WARNING, E_NOTICE)
     * @param string $message Текст системного сообщения
     * @param string $file Путь к файлу, в котором произошёл сбой
     * @param int $line Номер строки с ошибкой
     * @return void
     */
    public static function handleError(int $level, string $message, string $file, int $line): void
    {
        self::render(new \ErrorException($message, 0, $level, $file, $line));
    }

    /**
     * Обработчик фатальных ошибок (Fatal Errors).
     * Вызывается перед полной остановкой интерпретатора PHP. Проверяет, 
     * был ли финиш скрипта вызван критическим падением.
     * 
     * @return void
     */
    public static function handleFatalError(): void
    {
        $error = error_get_last();

        if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
            self::render(new \ErrorException($error['message'], 0, $error['type'], $error['file'], $error['line']));
        }
    }

    /**
     * Финальный рендеринг экрана ошибки.
     * Определяет корректный HTTP-статус, очищает буфер вывода (чтобы скрыть поломанную верстку)
     * и подключает нужный шаблон отображения в зависимости от режима отладки.
     * 
     * @param \Throwable $exception Любой объект ошибки или исключения, реализующий \Throwable
     * @return void
     */
    private static function render(\Throwable $exception): void
    {
        if (ob_get_length()) {
            ob_end_clean();
        }

        $basePath = dirname(__DIR__);
        $statusCode = 500;
        $text_error = 'Внутренняя ошибка сервера';

        $exceptionCode = (int)$exception->getCode();
        if (in_array($exceptionCode, [400, 401, 403, 404, 405])) {
            $statusCode = $exceptionCode;
            $text_error = $exception->getMessage();
        } elseif ($exception instanceof \InvalidArgumentException || $exception instanceof \TypeError) {
            $statusCode = 400;
            $text_error = 'Некорректный запрос (Неверные параметры)';
        }

        http_response_code($statusCode);

        if (!self::$debug) {
            $error = $statusCode;

            require_once $basePath . '/views/errors/http.php';
            exit;
        }

        require_once $basePath . '/views/errors/error.php';
        exit;
    }
}
