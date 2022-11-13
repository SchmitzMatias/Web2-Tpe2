<?php

require_once './libs/Router.php';
require_once './app/controllers/product-api.controller.php';
require_once './app/controllers/category-api.controller.php';

$router = new Router();

$router->addRoute('categories', 'GET', 'CategoryApiController', 'getCategories');
$router->addRoute('categories/:id', 'GET', 'CategoryApiController', 'getCategory');
$router->addRoute('categories', 'POST', 'CategoryApiController', 'addCategory');
$router->addRoute('categories/:id', 'PUT', 'CategoryApiController', 'updateCategory');
$router->addRoute('categories/:id', 'DELETE', 'CategoryApiController', 'deleteCategory');


$router->addRoute('products', 'GET', 'ProductApiController', 'getProducts');
$router->addRoute('products/:id', 'GET', 'ProductApiController', 'getProduct');
$router->addRoute('products', 'POST', 'ProductApiController', 'addProduct');
$router->addRoute('products/:id', 'PUT', 'ProductApiController', 'updateProduct');
$router->addRoute('products/:id', 'DELETE', 'ProductApiController', 'deleteProduct');

$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);
