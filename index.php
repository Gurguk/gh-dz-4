<?php
require __DIR__.'/vendor/autoload.php';

$controllerName = isset($_GET['controller']) ? $_GET['controller'] : 'default';
$controllerName = ucfirst($controllerName) . 'Controller';
$controllerName = 'Controllers\\' . $controllerName;

$controller = new $controllerName();

$actionName = isset($_GET['action']) ? $_GET['action'] : 'index';
$actionName = 'action' . $actionName;
$response = $controller->$actionName();

echo $response;