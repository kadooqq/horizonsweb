<?php
require_once('./core/routing.php');

session_start();

$url = key($_GET);  // Значение в адресной строке

Routing::addRoute("products", "./pages/products-page.php");
Routing::addRoute("vendors", "./pages/vendors-page.php");
Routing::addRoute("login", "./pages/login-page.php");
Routing::addRoute("sign-up", "./pages/sign-up-page.php");
Routing::addRoute("404", "./pages/404.php");
Routing::addRoute("order", "./pages/order.php");
Routing::addRoute("", "./pages/additional_requirements.php");
Routing::addRoute("additional_requirements", "./pages/additional_requirements.php");
Routing::addPrivateRoute("vendor-form", "./pages/vendor-form.php");
Routing::addPrivateRoute("product-form", "./pages/product-form.php");
Routing::route($url);
