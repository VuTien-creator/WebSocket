<?php
class ChatController extends Controller
{
    private $idUser;
    function __construct()
    {
        
        if (!isset($_SESSION['user_data'])) {
            header('location:http://localhost/do_an/WebSocket/main/home');
            exit;
        }
    }

    function index($id)
    {
        // $this->idUser = $id;
        // if ($id != $this->idUser) {
        //     header('location:http://localhost/do_an/WebSocket/chat/index');
        //     exit;
        // }
        // session_destroy();
        // exit;
        $this->view('mainLayout', [
            'page' => 'ChatRoom',
            'user' => $_SESSION['user_data'][$id]
        ]);
    }

    function checkValidUser($userId)
    {
        if (empty($userId)) {
            $_SESSION['error'] = 'Wrong Url';
            redirect(BASEURL . 'chat/index');
        }

        $this->model('UserModel');

        $model = new UserModel;

        $model->setUserID($userId);
        $user = $model->getUserDataById();

        if ($user->login_status != 'Login' || $user->status != 'Enable' || $user == null) {
            $_SESSION['error'] = 'Wrong Url';
            redirect(BASEURL . 'chat/index');
        }

        return $user;
    }

    function edit($userId)
    {
        $user = $this->checkValidUser($userId);
        // var_dump($user);
        // exit;
        $this->view('mainLayout', [
            'page' => 'Profile',
            'user' => $user
        ]);
    }

    function updateInfo()
    {
        if (!isset($_POST['edit'])) {
            $_SESSION['error'] = 'Wrong Url';
            redirect(BASEURL . 'chat/index');
        }
        $this->model('UserModel');

        $user = new UserModel;
        $this->checkValidUser($_POST['id_user']);


        $user->setUserID($_POST['id_user']);

        $userProfile = $_POST['hidden_user_profile'];

        if ($_FILES['user_profile']['name'] != '') {
            try {
                $userProfile = $user->upload_image($_FILES['user_profile']);
                $_SESSION['user_data'][$user->getUserID()]['profile'] = $userProfile;
                //code...
                // var_dump($userProfile);
                // exit;
            } catch (Exception $e) {
                //throw $th;

                $e->getMessage();
                exit;
            }
        }

        // echo 1;
        // var_dump($userProfile);
        // exit;
        $user->setPassword($_POST['user_password']);

        $user->setProfile($userProfile);
        $user->setUserName($_POST['user_name']);


        if ($user->updateProfile()) {
            $_SESSION['user_data'][$user->getUserID()]['name'] = $user->getUserName();


            $_SESSION['msg'] = 'Update your profile success';
            redirect(BASEURL . 'chat/index');
            exit;
        }
        $_SESSION['error'] = 'something wrong, try again';
        redirect(BASEURL . 'chat/index');
    }
}
