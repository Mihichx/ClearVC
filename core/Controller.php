<?php

class Controller
{   
    const VERSION = '2.1.1'; 

    // Свойство для хранения объекта базы данных PDO
    protected $db;

    // Конструктор принимает соединение при создании любого контроллера
    public function __construct(?PDO $dbConnection = null)
    {
        $this->db = $dbConnection;
    }

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
