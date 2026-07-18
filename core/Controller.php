<?php

namespace Core;

class Controller
{    
    /** @var string Версия приложения */
    const VERSION = 'v3.0.2'; 

    /** @var PDO|null Объект базы данных для выполнения запросов */
    protected $db;

    /**
     * Конструктор принимает соединение при создании любого контроллера
     * 
     * @param PDO|null $dbConnection
     */
    public function __construct(?\PDO $dbConnection = null)
    {
        $this->db = $dbConnection;
    }

     /**
     * Рендерит указанный шаблон и автоматически прокидывает 
     * в него переменную $auth_user (данные пользователя из сессии).
     * 
     * @param string $view Имя файла шаблона (например, 'home')
     * @param array $data Массив данных для отображения
     */
    protected function render($view, $data = [])
    {
        $data['auth_user'] = $_SESSION['user'] ?? null;

        extract($data);
        
        ob_start();
        require_once __DIR__ . '/../views/' . $view . '.php';
        $content = ob_get_clean();
        
        require_once __DIR__ . '/../views/layouts/main.php';
    }
}
