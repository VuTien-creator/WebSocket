<?php
class Controller
{
    function render($view, $data=[],$layout='layout'){
        // array data with key=>value
        extract($data);
        include 'view/'.$layout.'.php';
    }
    
    function _404(){
        $this->render('views/404.php');
    }
}