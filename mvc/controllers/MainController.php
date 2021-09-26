<?php

class MainController extends Controller
{
    public function index()
    {
        //return page  login
        $this->view('empty',[
            'page'=>'login'
        ]);
    }


    public function home()
    {
        echo 'home';
    }

    

    
}
