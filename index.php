<?php

$action = $_GET['action'] ?? 'index';
$controllerName = ($_GET['controller'] ?? 'Main') . 'Controller';

$path = 'controllers/' . $controllerName . '.php';

include 'system/config/config.php';
include 'system/libs/functions.php';

include 'controllers/Controller.php'; //include class controller
include 'models/Model.php'; //include class model 

if (file_exists($path)) {
    include $path;
    $controller = new $controllerName();
    if (method_exists($controller, $action)) {
        if (isLogin()) {

            $controller->$action();
        } else {

            include_once 'controllers/UserController.php';
            $controller = new UserController();
            $controller->login();
        }
    } else {
        $controller->_404();
    }
} else {
    $controller = new Controller();
    $controller->_404();
}
