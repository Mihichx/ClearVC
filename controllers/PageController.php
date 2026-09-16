<?php

namespace App\Controllers;

use Core\Controller;

/**
 * Контроллер для обработки основных и динамических страниц сайта.
 */
class PageController extends Controller
{
    /**
     * Отображает главную страницу сайта.
     * 
     * @return void
     */
    public function index() // TODO: Сделать отображение метода (к какому методу относиться данная функция)
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
