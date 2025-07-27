<?php

namespace App;

class Router
{
    private $routes = [];

    /**
     * Adds a route to the router.
     *
     * @param string $method HTTP method (e.g., 'GET', 'POST')
     * @param string $path The URL path (e.g., '/', '/dashboard')
     * @param callable|array $callback Function or [ControllerClass, methodName] to execute
     */
    public function addRoute($method, $path, $callback)
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'callback' => $callback
        ];
    }

    /**
     * Dispatches the current request to the appropriate route.
     */
    public function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Ensure path starts with '/' and remove trailing slash
        if (empty($path) || substr($path, 0, 1) !== '/') {
            $path = '/' . $path;
        }
        if (strlen($path) > 1 && substr($path, -1) === '/') {
            $path = rtrim($path, '/');
        }

        // Add a default route for the root path if no specific route is defined
        if ($path === '' || $path === '/') {
            $path = '/'; // Normalize empty path to root
        }

        foreach ($this->routes as $route) {
            // Simple path matching for now, no dynamic segments needed for these simple frontend routes
            if ($route['method'] == $method && $route['path'] == $path) {
                $callback = $route['callback'];

                if (is_callable($callback)) {
                    call_user_func($callback);
                    return;
                } elseif (is_array($callback) && count($callback) == 2) {
                    $controllerName = "App\\Controllers\\" . $callback[0];
                    $methodName = $callback[1];

                    if (class_exists($controllerName) && method_exists($controllerName, $methodName)) {
                        $controller = new $controllerName();
                        call_user_func([$controller, $methodName]);
                        return;
                    }
                }
            }
        }

        // If no route matches, show a 404 page
        http_response_code(404);
        echo "<h1>404 - Halaman Tidak Ditemukan</h1><p>Maaf, halaman yang Anda cari tidak ada.</p>";
    }
}
