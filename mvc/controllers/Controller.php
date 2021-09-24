<?php
class Controller
{
    function render($view, $data=[],$layout='layout'){
        // array data with key=>value
        extract($data);
        include './mvc/views/'.$layout.'.php';
    }
    
    function _404(){
        $this->render('./mvc/views/404.php');
    }
}