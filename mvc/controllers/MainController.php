<?php

class MainController extends Controller
{
    public function index()
    {
        echo 'test';
    }

    public function show()
    {
        echo 'show';
    }

    

    public function Tong($a, $b)
    {
        $model = $this->model('sinhVien');
        $number = $model->Tong($a, $b);
        
        $this->view('layout', [
            'number' => $number,
            'page'=>'login'
        ]);
        // var_dump( $a);
    }
}
