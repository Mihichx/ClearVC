<?php

namespace Core;

use PDO;

class Controller
{
    /** @var string Версия приложения */
    const VERSION = 'v3.1.2';

    /** @var PDO|null Объект базы данных для выполнения запросов */
    protected ?PDO $db = null;

    /** @var Request Объект безопасного HTTP-запроса */
    protected Request $request;

    /**
     * Конструктор принимает соединение при создании любого контроллера
     * 
     * @param PDO|null $dbConnection
     */
    public function __construct(?PDO $dbConnection, Request $request)
    {
        $this->db = $dbConnection;
        $this->request = $request;
    }

    /**
     * Рендерит указанный шаблон и автоматически прокидывает 
     * в него переменную $auth_user (данные пользователя из сессии).
     * 
     * @param string $view Имя файла шаблона (например, 'home')
     * @param array $data Массив данных для отображения
     */
    protected function render(string $view, array $data = [], string $layout = 'main'): void // TODO: Указать в документации о том что можно указывать шаблон
    {
        $data['auth_user'] = $_SESSION['user'] ?? null;

        $basePath = dirname(__DIR__);

        $viewFile = $basePath . "/views/{$view}.php";
        if (!file_exists($viewFile)) {
            throw new \Exception("Файл отображения (View) [views/{$view}.php] не найден.", 500);
        }

        $layoutFile = $basePath . "/views/layouts/{$layout}.php";
        if (!file_exists($layoutFile)) {
            throw new \Exception("Файл макета (Layout) [views/layouts/{$layout}.php] не найден.", 500);
        }

        extract($data);

        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        require $layoutFile;
    }
}
