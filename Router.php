<?php
class Router
{
    private $routes = [];

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
    
    public function dispatch(): void
    {
        spl_autoload_register(function ($className) {
            $file = __DIR__ . '/controllers/' . $className . '.php';
            if (file_exists($file)) {
                require_once $file;
            }
        });

        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = rtrim($uri, '/');
        
        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }
            if ($route['path'] === '*') {
                if ($this->handleDynamicModules($uri)) {
                    return;
                }
                continue;
            }
            $routePath = rtrim($route['path'], '/');
            $pattern = '#^' . preg_replace('/\{([a-z]+)\}/', '([^/]+)', $routePath) . '$#';
            
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                [$controllerName, $action] = explode('@', $route['handler']);
                $controller = new $controllerName();
                $controller->$action(...$matches);
                return;
            }
        }
        http_response_code(404);
        require_once __DIR__ . '/views/404.php';
        exit;
    }
    private function handleDynamicModules(string $uri): bool
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
    if (class_exists($controllerClass)) {
        $controllerInstance = new $controllerClass();       
        if (method_exists($controllerInstance, $action)) {
            $controllerInstance->$action(...$params);
            return true;
        }
    }

    return false;
}
}