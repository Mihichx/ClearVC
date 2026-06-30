<?php
class Controller
{
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