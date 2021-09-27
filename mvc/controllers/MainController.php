<?php

class MainController extends Controller
{
    
    function __construct()
    {
        if(isset($_SESSION['user_data'])){
            redirect(BASEURL.'chat/index');
        }
    }
    public function index()
    {
        //return page  login
        $this->view('empty',[
            'page'=>'login'
        ]);
    }


    
}
