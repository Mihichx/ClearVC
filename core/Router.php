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
    private array $routes = [];

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
            if (!isset($route[2])) {
                throw new \InvalidArgumentException(
                    "Ошибка регистрации маршрута [{$route[0]}]: HTTP-метод должен быть указан явно."
                );
            }

            [$controllerName] = explode('@', $route[1]);
            $fullControllerClass = 'App\\Controllers\\' . $controllerName;

            if (!class_exists($fullControllerClass)) {
                throw new \Exception(
                    "Критическая ошибка в config/routes.php: Контроллер '{$fullControllerClass}' не найден на диске. Создайте файл или исправьте опечатку.",
                    500
                );
            }

            $this->routes[] = [
                'path'    => $route[0],
                'handler' => $route[1],
                'method'  => strtoupper($route[2]),
            ];
        }
    }

    /**
     * Перехватывает текущий HTTP-запрос, ищет совпадение по базе маршрутов
     * и передает управление нужному экшену контроллера.
     * 
     * @param Request $request Объект текущего HTTP-запроса
     * @return void
     */
    public function dispatch(Request $request): void
    {
        $method = $request->getMethod();
        $uri = $request->getUri();
        $uri = ($uri !== '/') ? rtrim($uri, '/') : '/';

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            $routePath = ($route['path'] !== '/') ? rtrim($route['path'], '/') : '/';
            $quotedPath = preg_quote($routePath, '#');
            $pattern = '#^' . preg_replace('/\\\{([a-z]+)\\\}/', '([^/]+)', $quotedPath) . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);

                [$controllerName, $action] = explode('@', $route['handler']);
                $fullControllerClass = 'App\\Controllers\\' . $controllerName;

                $controller = new $fullControllerClass();

                if (!method_exists($controller, $action)) {
                    throw new \Exception("Метод {$action} в контроллере {$fullControllerClass} не найден.", 500);
                }

                $controller->$action($request, ...$matches);
                return;
            }
        }

        throw new \Exception('Страница не найдена', 404);
    }
}
