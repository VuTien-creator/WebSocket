<?php

function dd($value){
    print_r($value);
    
}

function redirect($url){
    // redirect to url 
    header('location:'.$url);
    exit;
}

function href($controller, $action = 'index',$params =[]){
    $ext = '';
    foreach($params as $key => $value){

        $ext .= '&'.$key.'='.$value;
    }
    //return to url 
    return BASEURL.'?controller='.$controller.'&action='.$action.$ext;
}

function now(){
    return date('Y-m-d H:i:s');
}

/**
 * check user login
 */
function isLogin(){

    return isset($_SESSION['statusLogin']) && $_SESSION['statusLogin'];

}