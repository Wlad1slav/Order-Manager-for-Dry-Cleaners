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

                if ($rout['call_method'] !== null) {
                    // Якщо в маршруті був заданий метод, який потрібно викликати

                    $class = $rout['call_method']['class']; // Класс, який потрібно використовувати для виклику методу
                    $method = $rout['call_method']['method']; // Метод, який потрібно викликати

                    require_once "$class.php"; // Імпортує клас

                    if ($rout['call_method']['declare']) {
                        // Якщо метод нестатичний, і для його використання потрібен екземпляр классу
                        $class = new $class(); // Створення екземпляру класу
                        $redirectTo = $class->$method();
                    } else
                        // Якщо метод статичний
                        $redirectTo = $class::$method();

                    $this->redirect($redirectTo['rout-name'], $redirectTo['rout-params'], $redirectTo['page-section']);
                }

                if ($rout['controller'] !== null)
                    // Якщо в маршруті був задан файл, який потрібно викликати
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

    public function redirect(?string $name, array $params = [], string $section = null): void {
        // Метод редіректу на іншу сторінку по назві посиалання
        if ($name == null) die();
        $path = $this->url($name, $params, $section);
        header("Location: $path");
        die();
    }

    public static function redirectUrl(string $path): void {
        // Метод редіректу на іншу сторінку по посиланню
        header("Location: $path");
        die();
    }

    public function url(string $name, array $params = [], string $section = null): string {
        // Метод, що повертає посилання на сторінку по заданой назві
        foreach ($this->routes as $route)
            if ($route['name'] == $name) {

                if (count($params) === 0 and count($route['params']) == 0)
                    // Якщо жодного параметру не задано
                    $url = "/{$route['uri']}";
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
                }

                if ($section !== null)
                    $url .= "#$section";

                return $url;
            }


        // Якщо маршрут не знайдено, кидає помилку
        throw new InvalidArgumentException("url($name): Посилання з назвою \"$name\" не існує.");
    }

    protected function add(string $uri, ?string $controller, ?array $call, string $method, string $name, array $rights, array $params): void {
        // Створює маршрут, зберігає його у масив усіх маршрутів
        $this->routes[] = [
            'uri' =>            $uri,
            'controller' =>     $controller,
            'call_method' =>    $call,
            'method' =>         strtoupper($method),
            'name' =>           $name,
            'params' =>         $params,
            'rights' =>         $rights,
        ];
    }

    public function load(): void {
        // Завантаження усіх маршрутів

        $dir = scandir(self::DIR); // Отримати всі файли у директорії routers

        // Проходження по кожному маршрутизатору
        foreach ($dir as $routes) {
            // Перевіряємо, чи файл має розширення .php
            if (is_file(self::DIR."/$routes") && pathinfo($routes, PATHINFO_EXTENSION) == 'php') {
                // Включаємо файл і зберігаємо повернене ним значення
                $routes = include(self::DIR."/$routes");

                foreach ($routes['routers'] as $key => $route) {
                    // Створення кожного маршруту

                    $uri = $routes['app-name'];
                    if ($route['URL'] != '')
                        // Якщо елемент URL не пустий, то він додається в URI
                        $uri .= "/{$route['URL']}";

                    $path = null;
                    if ($route['PATH'] !== null)
                        // Якщо повинен викликатися певний файл
                        $path = "templates/{$routes['app-name']}/{$route['PATH']}";

                    $call = null;
                    if (isset($route['CALL']))
                        if ($route['CALL'] !== null)
                            // Якщо повинен викликатися певний метод
                            $call = $route['CALL'];

                    $this->add(
                        $uri, // Посилання, яке тригерить маршрут
                        $path, // Шлях до файлу, що викликається
                        $call, // Метод, що викликається (масив з класу, методу і буліана чи статичний метод)
                        $route['METHOD'],
                        $key,
                        $route['RIGHTS'],
                        $route['PARAMETERS']
                    );
                }

            }
        }
    }

}