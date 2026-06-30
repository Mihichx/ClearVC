<?php

require_once __DIR__ . '/../core/Controller.php';

class PageController extends Controller 
{
    public function page() 
    { 
        echo "Динамические page работает из папки controllers!"; 
    }

    // Главная страница
    public function index()
    {
        $this->render('home', [
            'title' => 'Главная'
        ]);
    }

    // Страница документации
    public function docs()
    {
        $this->render('docs', [
            'title' => 'Документация ClearMVC'
        ]);
    }

    // Страница со списком роутов
    public function routes()
    {
        $routesList = require __DIR__ . '/../config/route.php';

        $this->render('routes', [
            'title' => 'Карта маршрутов сайта',
            'routes' => $routesList
        ]);
    }
}
