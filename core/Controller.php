<?php

namespace Core;

class Controller
{
    /** @var string Версия приложения */
    const VERSION = 'v4.0.0-alpha';

    /**
     * Собирает страницу-матрешку: изолирует переменные, собирает контент в буфер 
     * и внедряет его внутрь глобальной HTML-оболочки (Лейаута).
     * 
     * @param string $view Имя файла представления в папке views/ (без расширения .php)
     * @param array<string, mixed> $data Ассоциативный массив переменных для вывода в HTML
     * @return void
     */
    public function render(string $view, array $data = []): void
    {
        extract($data);

        $basePath = dirname(__DIR__) . '/views/';

        ob_start();
        require $basePath . $view . '.php';
        $content = ob_get_clean();

        require $basePath . 'layouts/main.php';
    }
}
