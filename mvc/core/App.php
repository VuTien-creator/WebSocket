<?php
class App
{
    protected $controller = 'MainController';
    protected $action = 'index';
    protected $params = [];

    function __construct()
    {

        $arr = $this->UrlProcess();
        // $arr return Array ( [0] => controller [1] => action [2] => param1 [3] => param2 [4] => param3 )
        if (!empty($arr)) {
            if (file_exists('./mvc/controllers/' . $arr[0] . 'Controller.php')) {

                $this->controller = $arr[0] . 'Controller';
            }
            unset($arr[0]);

            require_once './mvc/controllers/' . $this->controller . '.php';

            if (isset($arr[1])) {
                //check action in controller
                if (method_exists($this->controller, $arr[1])) {
                    $this->action = $arr[1];
                }
                unset($arr[1]);
            }

            $this->params = $arr ? array_values($arr) : [];
        } else {

            require_once './mvc/controllers/' . $this->controller . '.php';
        }

        $this->controller = new $this->controller; // create new object
        
        // $action = $this->action;
        // $this->controller->$action($this->params);
        
        call_user_func_array([$this->controller, $this->action], $this->params);

    }


    function UrlProcess()
    {
        if (isset($_GET['controller'])) {
            return explode('/', filter_var(trim($_GET['controller'])));
        }
    }
}
