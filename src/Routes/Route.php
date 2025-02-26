<?php

namespace App\Routes;

use App\Controllers\LogController;
use App\Controllers\LoginController;

class Route
{
    private static array $routes = [];
    private $prefix;

    public function __construct($prefix = "")
    {
        $this->prefix = $prefix;
    }

    public static function group($prefix, $callback): void
    {
        $callback(new self($prefix));
    }

    public function get($path, $callback): void
    {
        self::$routes[] = ['method' => 'GET', 'path' => $this->prefix . $path, 'callback' => $callback];
    }

    public function post($path, $callback): void
    {
        self::$routes[] = ['method' => 'POST', 'path' => $this->prefix . $path, 'callback' => $callback];
    }

    private static function createPattern($path)
    {
        return '#^' . preg_replace('/\{[a-zA-Z0-9_]+\}/', '([^/]+)', $path) . '$#';
    }

    public static function match($method, $path)
    {
        foreach (self::$routes as $route) {
            $pattern = self::createPattern($route['path']);
            if ($route['method'] === $method && preg_match($pattern, $path, $matches)) {
                array_shift($matches);
                return ['callback' => $route['callback'], 'params' => $matches];
            }
        }
        return null;
    }

    public static function dispatch($method, $path): void
    {
        $requestUri = strtok($path, '?');

        $result = self::match($method, $requestUri);
        if ($result) {
            $callback = $result['callback'];
            $params = $result['params'];
            if (is_array($callback)) {
                $controller = new $callback[0]();
                $method = $callback[1];
                call_user_func_array([$controller, $method], $params);
            } else {
                call_user_func_array($callback, $params);
            }
        } else {
            $logController = new LogController;
            $loginController = new LoginController;
            $userId = @$loginController->getUserBySession()['id'];
            $logController->createLog("Sayfa bulunamadı", "fail", $userId);
            self::notFound();
        }
    }

    public static function notFound(): void
    {
        http_response_code(404);
        echo '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>404 Not Found</title>
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
                <style>
                    body {
                        background-color: #f8f9fa;
                    }
                    .error-container {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100vh;
                    }
                    .error-content {
                        text-align: center;
                    }
                </style>
            </head>
            <body>
            
            <div class="error-container">
                <div class="error-content">
                    <h1 class="display-1">404</h1>
                    <p class="lead">Oops! Sayfa bulunamadı.</p>
                    <a href="/" class="btn btn-primary">Ana Sayfaya Dön</a>
                </div>
            </div>
            
            </body>
            </html>
            ';
    }
}
?>
