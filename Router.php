<?php

class Router {
    protected array $routes;            // Масив усіх машрутів
    protected string $uri;              // Строка запиту
    protected string $method;           // Метод HTTP (наприклад, GET, POST тощо) запиту

    public function __construct() {
        $this->uri = trim(parse_url($_SERVER['REQUEST_URI'])['path'], '/');
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    public function match() {
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

    protected function add(string $uri, string $controller, string $method, string $name): void {
        // Створює маршрут, зберігає його у масив усіх маршрутів
        $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => strtoupper($method),
            'name' => $name
        ];
    }

    public function get(string $uri, string $controller, string $name): void {
        // Додає в масив маршрутів маршрут з методом GET
        $this->add($uri, $controller, 'GET', $name);
    }

    public function post(string $uri, string $controller, string $name): void {
        // Додає в масив маршрутів маршрут з методом POST
        $this->add($uri, $controller, 'POST', $name);
    }

    public function delete(string $uri, string $controller, string $name): void {
        // Додає в масив маршрутів маршрут з методом DELETE
        $this->add($uri, $controller, 'DELETE', $name);
    }

    public function redirect(string $name): void {
        // Метод редіректу на іншу сторінку по назві посиалання
        $path = $this->url($name);
        header("Location: $path");
        die();
    }

    public static function redirectUrl(string $path): void {
        // Метод редіректу на іншу сторінку по посиланню
        header("Location: $path");
        die();
    }

    public function url(string $name): string {
        // Метод, що повертає посилання на сторінку по заданой назві
        foreach ($this->routes as $route)
            if ($route['name'] == $name)
                return '/' . $route['uri'];
        // Якщо маршрут не знайдено, кидає помилку
        throw new InvalidArgumentException("url($name): Посилання з назвою \"$name\" не існує.");
    }

}