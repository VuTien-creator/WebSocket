<?php
//mail library
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require './mvc/vendor/autoload.php';


class UserController extends Controller
{

    function __construct()
    {
        
        if(isset($_SESSION['user_data'])){
            redirect(BASEURL.'chat/index');
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
            $userObject->setProfile($userObject->make_avatar(strtoupper($_POST['user_name'][0]))); // the first character of name
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

            $mail = new PHPMailer(true);

            try {
                //code...
                $userObject->createNewUser();

                //send mail tp verifi
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;

                $mail->isSMTP();
                $mail->Host  = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'vtu3901@gmail.com';                     //SMTP username
                $mail->Password   = 'qjvzuldhgicsadfn';

                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption

                $mail->Port = 465;


                $mail->setFrom('1851120045@sv.ut.edu.vn', 'Nhom 10');

                $mail->addAddress($userObject->getUserEmail());


                $mail->isHTML(true);

                $mail->Subject = 'Registration Verification for Chat Application ';

                $mail->Body = '
            <p>Thank you for registering for Chat Application .</p>
                <p>This is a verification email, please click the link to verify your email address.</p>
                <p><a href="http://localhost:80/do_an/WebSocket/user/verify/' . $userObject->getUserVerification() . '">Click to Verify</a></p>
                <p>Thank you...</p>
            ';

                $mail->send();

                $_SESSION['msg'] = ' register success, please check your email to Enable Account';
                redirect(BASEURL . 'main/index');
            } catch (Exception $e) {
                //throw $th;
                exit($e->getMessage());
            }
        }
        redirect('index');
    }

    function checkEmailRegisterAjax($email)
    {
        $this->model('UserModel');
        $userObject = new UserModel;

        $user = $userObject->getUserDataByEmail($email);
        $result = '';

        if (!empty($user)) {
            $result = 'Email already exist';
            // echo 1;
        }
        return json_encode($result);
    }

    function verify($code = null)
    {
        $this->model('UserModel');
        if (!isset($code)) {
            $_SESSION['error'] = 'Please check your Email to Enable your account';
            redirect(BASEURL . 'main/index');
            return false;
        }

        $userModel = new UserModel;

        $userModel->setUserVerification($code);

        $user = $userModel->getUserDataByVerifyCode();

        if (!empty($user)) {
            $userModel->setStatus('Enable');

            $userModel->enableUserByVerifyCode();

            $_SESSION['msg'] = 'Enable account success';
            redirect(BASEURL . 'main/index');

            return true;
        } else {
            $_SESSION['error'] = 'wrong Verification code, please check your Email';
            redirect(BASEURL . 'main/index');
            return false;
        }
    }

    function login()
    {

        if ($_POST['login'] == 'Login') {

            if (isset($_POST['user_email']) && isset($_POST['user_password'])) {

                $this->model('UserModel');
                $user = new UserModel;
                $user->setUserEmail($_POST['user_email']);
                $userEmail = $user->getUserDataByEmail();

                if ($userEmail != null) {

                    if ($userEmail->status != 'Enable') {
                        $_SESSION['error'] = 'Email is Disable, please check your email to Enable your account';
                        redirect(BASEURL . 'main/index');
                        return false;
                    }

                    if ($userEmail->password != $_POST['user_password']) {
                        $_SESSION['error'] = 'Wrong password';
                        redirect(BASEURL . 'main/index');
                        return false;
                    }

                    $user->setUserId($userEmail->id);
                    $user->setUserLoginStatus('Login');

                    // $user->setUserToken(md5(uniqid()));

                    if ($user->updateUserLoginData()) {
                        $_SESSION['user_data'][$userEmail->id] = [
                            'id'    =>  $userEmail->id,
                            'name'  =>  $userEmail->name,
                            'profile'   =>  $userEmail->profile,
                            // 'token' =>  $userEmail->
                        ];
                    }
                    redirect(BASEURL . 'chat/index');
                    return true;
                }
                $_SESSION['error'] = 'Wrong Email';
                redirect(BASEURL . 'main/index');
                return false;
            }

            $_SESSION['error'] = 'please fill email and password';
            redirect(BASEURL . 'main/index');
            return false;
        }

        $_SESSION['error'] = 'Please login';
        redirect(BASEURL . 'main/index');
        return false;
    }
}
