<?php

require_once './libs/Router.php';
require_once './app/controllers/category-api.controller.php';
require_once './app/controllers/auth-api.controller.php';

$router = new Router();

$router->addRoute('categories', 'GET', 'CategoryApiController', 'getCategories');
$router->addRoute('categories/:id', 'GET', 'CategoryApiController', 'getCategory');
$router->addRoute('categories', 'POST', 'CategoryApiController', 'addCategory');
$router->addRoute('categories/:id', 'PUT', 'CategoryApiController', 'updateCategory');
$router->addRoute('categories/:id', 'DELETE', 'CategoryApiController', 'deleteCategory');

$router->addRoute("auth/token", 'GET', 'AuthApiController', 'getToken');

$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);
