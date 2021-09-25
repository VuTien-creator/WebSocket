<?php
class Controller
{
    public function model($model)
    {
        
        require_once './mvc/models/' . $model . '.php';
        return new $model;
    }

    public function view($layout, $data = [])
    {
        require_once './mvc/views/MasterLayout/' . $layout . '.php';
    }

    function render($view, $data = [], $layout = 'layout')
    {
        // array data with key=>value
        extract($data);
        include './mvc/views/' . $layout . '.php';
    }

    function _404()
    {
        $this->render('./mvc/views/404.php');
    }
}
