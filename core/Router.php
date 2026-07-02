<?php

namespace Core;

/**
 * Класс маршрутизатора (Router).
 * Отвечает за регистрацию маршрутов и запуск соответствующих контроллеров.
 */
class Router
{   
    /** 
     * Массив со списком всех обработанных и зарегистрированных маршрутов.
     * 
     * @var array<int, array{path: string, handler: string, method: string}> 
     */
    private $routes = [];

    /**
     * Регистрирует список маршрутов в системе.
     * Преобразует плоский массив из конфига во внутреннюю структуру роутера.
     * 
     * @param array<int, array<int, string>> $routesList Массив маршрутов из config/route.php
     * @return void
     */
    public function add(array $routesList): void
    {
        foreach ($routesList as $route) {
            $this->routes[] = [
                'path'    => $route[0],
                'handler' => $route[1],
                'method'  => $route[2] ?? 'GET',
            ];
        }
    }

    /**
     * Перехватывает текущий HTTP-запрос, ищет совпадение по базе маршрутов
     * и передает управление нужному экшену контроллера.
     * 
     * @param PDO|null $db Объект подключения к базе данных PDO
     * @return void
     */
    public function dispatch($db): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = rtrim($uri, '/');
        
        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }
            if ($route['path'] === '*') {
                if ($this->handleDynamicModules($uri, $db)) {
                    return;
                }
                continue;
            }
            $routePath = rtrim($route['path'], '/');
            $pattern = '#^' . preg_replace('/\{([a-z]+)\}/', '([^/]+)', $routePath) . '$#';
            
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                [$controllerName, $action] = explode('@', $route['handler']);
                $fullControllerClass = 'App\\Controllers\\' . $controllerName;
                $controller = new $fullControllerClass($db);
                $controller->$action(...$matches);
                return;
            }
        }
        http_response_code(404);
        require_once __DIR__ . '/../views/404.php';
        exit;
    }

    /**
     * Обрабатывает динамические модули и многосегментные URL,
     * когда в карте маршрутов сработал fallback-знак '*'.
     * 
     * @param string $uri Очищенный адресный путь страницы
     * @param PDO|null $db Объект подключения к базе данных PDO
     * @return bool Возвращает true, если контроллер и метод найдены и успешно вызваны
     */
    private function handleDynamicModules(string $uri, $db): bool
    {
        $uriParts = trim($uri, '/');
        if ($uriParts === '') {
            return false;
        }

        $segments = explode('/', $uriParts);
        $segmentCount = count($segments);
        
        if ($segmentCount === 1) {
            $controllerClass = 'PageController';
            $action = $segments[0];
            $params = [];
        } else {
            $module = array_shift($segments);
            $controllerClass = ucfirst($module) . 'Controller';
            $action = array_shift($segments);
            $params = $segments;
        }

        $fullControllerClass = 'App\\Controllers\\' . $controllerClass;
        if (class_exists($fullControllerClass)) {
            $controllerInstance = new $fullControllerClass($db);      
            if (method_exists($controllerInstance, $action)) {
                $controllerInstance->$action(...$params);
                return true;
            }
        }

        return false;
    }
}
