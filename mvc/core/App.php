<?php
class App
{
    function __construct()
    {
        $action = $_GET['action'] ?? 'index';
        $controllerName = ($_GET['controller'] ?? 'Main') . 'Controller';

        $path = './mvc/controllers/' . $controllerName . '.php';


        if (file_exists($path)) {

            include $path;
            $controller = new $controllerName();
            if (method_exists($controller, $action)) {
                if (isLogin()) {

                    $controller->$action();
                } else {

                    include_once './mvc/controllers/UserController.php';
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
    }
}
