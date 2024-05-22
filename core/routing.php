<?php

class Routing {
    // Общедоступные маршруты
    private static array $pages;

    // Приватные маршруты
    private static array $private_pages;

    // Добавление нового общедоступного маршрута
    public static function addRoute($url, $path): void
    {
        self::$pages[$url] = $path;
    }

    // Добавление нового приватного маршрута
    public static function addPrivateRoute($url, $path): void {
        self::$private_pages[$url] = $path;
    }

    // Переход на страницу по маршруту
    public static function route($url): void
    {
        $path = self::$pages[$url] ?? '';
        if (file_exists($path)) {
            require $path;
            return;
        }

        $path = self::$private_pages[$url] ?? '';
        if (file_exists($path) && isset($_SESSION['login_user'])) {
            require $path;
            return;
        }

        require "pages/404.php";
    }

    public static function notFound($path): void 
    {
        require $path;
        return;
    }
}