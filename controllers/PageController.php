<?php

namespace App\Controllers;

use Core\Controller;

/**
 * Контроллер для обработки основных и динамических страниц сайта.
 */
class PageController extends Controller 
{   
    /**
     * Обработка динамических страниц (вызывается через роут '*').
     * 
     * @return void
     */
    public function page() 
    {   
        echo "Динамические page работает из папки controllers!"; 
    }

     /**
     * Отображает главную страницу сайта.
     * 
     * @return void
     */
    public function index()
    {
        $this->render('home', [
            'title' => 'Главная'
        ]);
    }

    /**
     * Отображает страницу документации ClearMVC.
     * 
     * @return void
     */
    public function docs()
    {
        $this->render('docs', [
            'title' => 'Документация ClearMVC'
        ]);
    }

    /**
     * Отображает страницу со списком всех зарегистрированных роутов.
     * 
     * @return void
     */
    public function routes()
    {
        $routesList = require __DIR__ . '/../config/route.php';

        $this->render('routes', [
            'title' => 'Карта маршрутов сайта',
            'routes' => $routesList
        ]);
    }
}
