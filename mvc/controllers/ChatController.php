<?php
class ChatController extends Controller
{
    private $idUser;
    function __construct()
    {
        // session_destroy();
        // exit;
        if (!isset($_SESSION['user_data'])) {
            header('location:http://localhost/do_an/WebSocket/main/home');
            exit;
        }
    }
    function setUserIdController($id)
    {
        $this->idUser = $id;
    }
    function getUserIdController()
    {
        return $this->idUser;
    }

    function index()
    {
        // $this->idUser = $id;
        // if ($id != $this->idUser) {
        //     header('location:http://localhost/do_an/WebSocket/chat/index/'.$id);
        //     exit;
        // }
        // session_destroy();
        // exit;
        // $this->setUserIdController($id);
        // var_dump($_SESSION['user_data']);exit;
        $this->view('mainLayout', [
            'page' => 'ChatRoom',
            'user' => $_SESSION['user_data']
        ]);
    }

    function checkValidUser($userId)
    {
        if (empty($userId)) {
            $_SESSION['error'] = 'Wrong Url';
            redirect(BASEURL . 'chat/index');
        }

        // var_dump($this->getUserIdController());
        // exit;
        // if ($this->getUserIdController() != $userId) {
        //     $_SESSION['error'] = 'Wrong Url';
        //     redirect(BASEURL . 'chat/index/'.$this->getUserIdController());
        // }

        $this->model('UserModel');

        $model = new UserModel;

        $model->setUserID($userId);
        $user = $model->getUserDataById();

        if ($user->login_status != 'Login' || $user->status != 'Enable' || $user == null || $_SESSION['user_data']['id'] != $user->id) {
            $_SESSION['error'] = 'Something wrong, watch your action';
            redirect(BASEURL . 'chat/index'); //aaaaaa
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

        $this->checkValidUser($_POST['id_user']);

        $this->model('UserModel');

        $user = new UserModel;



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
            $_SESSION['user_data']['name'] = $user->getUserName();
            $_SESSION['user_data']['profile'] = $user->getProfile();

            $_SESSION['msg'] = 'Update your profile success';
            redirect(BASEURL . 'chat/index');
            exit;
        }
        $_SESSION['error'] = 'something wrong, try again';
        redirect(BASEURL . 'chat/index');
    }

    function logout()
    {
        
        if (isset($_POST['action']) && $_POST['action'] == 'logout') {

            $this->model('UserModel');
            $user = new UserModel;

            //get user by Id from ajax post
            $user->setUserID($_POST['user_id']);
            $model = $user->getUserDataById();


            //check invalid user
            if (
                $model == null || $model->status == 'Disable'
                || $model->login_status == 'Logout' ||
                $_SESSION['user_data']['id'] != $model->id
            ) {
                $_SESSION['error'] = 'some action wrong, try again';
                redirect(BASEURL . 'chat/index');
            }

            //set status user o
            $user->setUserLoginStatus('Logout');
            
            if ($user->userLogout()) {
                unset($_SESSION['user_data']);

                session_destroy();

                // return true;

                return json_encode(['status' => 1],200);
            }
            $_SESSION['error'] = 'something wrong, try again';
            redirect(BASEURL . 'chat/index');
        }
        $_SESSION['error'] = 'something wrong, try again';
        redirect(BASEURL . 'chat/index');
    }
}
