<?php
class UserController extends Controller
{

    function __construct()
    {
        if (isset($_SESSION['data_user'])) {
            header('location:http://localhost/do_an/WebSocket/main/home');
        }
    }
    public function index()
    {
        //return page  register
        $this->view('empty', [
            'page' => 'register'
        ]);
    }

   
    public function register()
    {
        if (isset($_POST['register'])) {

            // if(isset)
             $this->model('UserModel');
            $userObject = new UserModel;
            // var_dump( $userObject->pdo);

            $userObject->setUserName($_POST['user_name']);
            $userObject->setUserEmail($_POST['user_email']);
            $userObject->setPassword($_POST['user_password']);
            $userObject->setProfile($userObject->make_avatar(strtoupper($_POST['user_name'][0]))); //get the first character of name
            $userObject->setStatus('Disabled');
            $userObject->setUserCreateOn(date('Y-m-d H:i:s'));
            $userObject->setUserVerification(md5(uniqid()));

            $user = $userObject->getUserDataByEmail($_POST['user_email']);

            if (!empty($user)) {
                 $error = 'This Email Already Register';
                $this->view('empty', [
                    'page' => 'register',
                    'error' => $error
                ]);
                exit;
                
            } 
            try {
                //code...
                $userObject->createNewUser();
                $_SESSION['msg'] = ' register success, please check your email to Enable Account';
                redirect(BASEURL.'main/index');
            } catch (\Exception $e) {
                //throw $th;
                exit($e->getMessage());
            }
            
        }
    }

    function checkEmailRegisterAjax($email)
    {
        $this->model('UserModel');
        $userObject =new UserModel;

        $user = $userObject->getUserDataByEmail($email);
        $result = '';

        if (!empty($user)) {
            $result = 'Email already exist';
            // echo 1;
        }
        return json_encode($result);
    }
}
