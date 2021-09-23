<?php
class Controller
{
    function render($view, $data=[],$layout='layout'){
        // array data with key=>value
        extract($data);
        include 'view/'.$layout.'.php';
    }
    
}