<?php

class Router {
    private array $routes;            // Масив усіх машрутів
    private string $uri;              // Строка запиту
    private string $method;           // Метод HTTP (наприклад, GET, POST тощо) запиту

    const DIR = 'routers/';

    public function __construct() {
        $this->uri = trim(parse_url($_SERVER['REQUEST_URI'])['path'], '/');
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    public function match(): void {
        // Перевіряє усі маршрути, додані до $routes
        $matches = false;
        foreach ($this->routes as $rout) {
            if (($rout['uri'] == $this->uri) && ($rout['method'] == strtoupper($this->method))) {
                require_once $rout['controller'];
                $matches = true;
                break;
            }
        }
        if (!$matches) {
            $errNum = 404;
            require_once 'templates/error-page.php';
        }
    }

    protected function add(string $uri, string $controller, string $method, string $name, array $rights, array $params): void {
        // Створює маршрут, зберігає його у масив усіх маршрутів
        $this->routes[] = [
            'uri' =>            $uri,
            'controller' =>     $controller,
            'method' =>         strtoupper($method),
            'name' =>           $name,
            'params' =>         $params,
            'rights' =>         $rights,
        ];
    }

    public function redirect(string $name, array $params = []): void {
        // Метод редіректу на іншу сторінку по назві посиалання
        $path = $this->url($name, $params);
        header("Location: $path");
        die();
    }

    public static function redirectUrl(string $path): void {
        // Метод редіректу на іншу сторінку по посиланню
        header("Location: $path");
        die();
    }

    public function url(string $name, array $params = []): string {
        // Метод, що повертає посилання на сторінку по заданой назві
        foreach ($this->routes as $route)
            if ($route['name'] == $name) {
                if (count($params) === 0 and count($route['params']) == 0)
                    // Якщо жодного параметру не задано
                    return "/{$route['uri']}";
                else {
                    $url = "/{$route['uri']}?";
                    foreach ($route['params'] as $param)
                        // Проход по усім обов'язковим параметрам
                        if (!array_key_exists($param, $params))
                            // Якщо не був наданий обов'язковий параметр виникає помилка
                            throw new InvalidArgumentException("url($name): В посиланні $name не вистачає параметру $param.");

                    foreach ($params as $param => $value)
                        // Додає параметри в посилання
                        $url .= "$param=$value&";

                    return $url;
                }
            }
        // Якщо маршрут не знайдено, кидає помилку
//        throw new InvalidArgumentException("url($name): Посилання з назвою \"$name\" не існує.");
        return '';
    }

    public function load(): void {
        // Завантаження усіх маршрутів

        $routers = scandir(self::DIR); // Отримати всі файли у директорії routers

        // Проходження по кожному маршрутизатору
        foreach ($routers as $router) {
            // Перевіряємо, чи файл має розширення .php
            if (is_file(self::DIR."/$router") && pathinfo($router, PATHINFO_EXTENSION) == 'php') {
                // Включаємо файл і зберігаємо повернене ним значення
                $rout = include(self::DIR."/$router");

                foreach ($rout['routers'] as $key => $r) {
                    // Створення кожного маршруту

                    $uri = $rout['app-name'];
                    if ($r['URL'] != '')
                        // Якщо елемент URL не пустий, то він додається в URI
                        $uri .= "/{$r['URL']}";

                    $this->add($uri, "templates/{$rout['app-name']}/{$r['PATH']}", $r['METHOD'], $key, $r['RIGHTS'], $r['PARAMETERS']);
                }

            }
        }
    }

}