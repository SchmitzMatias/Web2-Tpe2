<?php

require_once './libs/Router.php';
require_once './app/controllers/product-api.controller.php';
require_once './app/controllers/category-api.controller.php';

$router = new Router();

$router->addRoute('categories', 'GET', 'CategoryApiController', 'getCategories');
$router->addRoute('categories/:id', 'GET', 'CategoryApiController', 'getCategory');
$router->addRoute('categories/:id', 'PUT', 'CategoryApiController', 'updateCategory');
$router->addRoute('categories/:id', 'DELETE', 'CategoryApiController', 'deleteCategory');
$router->addRoute('categories', 'POST', 'CategoryApiController', 'addCategory');

$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);
