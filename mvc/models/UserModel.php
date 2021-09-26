<?php
class UserModel extends Model
{
    private $id;
    private $name;
    private $email;
    private $password;
    private $profile;
    private $status;
    private $created_on;
    private $verification_code;
    private $login_status;
    // private $token;
    // private $connection_id;

    function setUserID($id)
    {
        $this->id = $id;
    }
    function getUserID($id)
    {
        return $this->id;
    }

    function setUserName($userName)
    {
        $this->name = $userName;
    }

    function getUserName()
    {
        return $this->name;
    }

    function setUserEmail($email)
    {
        $this->email = $email;
    }

    function getUserEmail()
    {
        return $this->email;
    }

    function setPassword($password)
    {
        $this->password = $password;
    }

    function getPassword()
    {
        return $this->password;
    }

    function setProfile($profile)
    {
        $this->profile = $profile;
    }

    function getProfile()
    {
        return $this->profile;
    }

    function setStatus($status)
    {
        $this->status = $status;
    }

    function  getStatus()
    {
        return $this->status;
    }

    function setUserCreateOn($time)
    {
        $this->created_on = $time;
    }


    function getUserCreateOn()
    {
        return $this->created_on;
    }

    function setUserVerification($code)
    {
        $this->verification_code = $code;
    }

    function getUserVerification()
    {
        return $this->verification_code;
    }

    function setUserLoginStatus($status)
    {
        $this->login_status = $status;
    }

    function getUserLoginStatus()
    {
        return $this->login_status;
    }

    function make_avatar($character)
    {
        $path = "./public/images/" . time() . ".png"; //create path to images (unique)
        $image = imagecreate(200, 200); //create image: width and height = 200

        //random color (RGB)
        $red = rand(0, 255);
        $green = rand(0, 255);
        $blue = rand(0, 255);

        imagecolorallocate($image, $red, $green, $blue); //set background color of image 

        $textcolor = imagecolorallocate($image, 255, 255, 255); //set color for text


        $font = dirname(__FILE__) . '/font/arial.ttf';

        imagettftext($image, 100, 0, 55, 150, $textcolor, $font, $character); //write text to image
        imagepng($image, $path);
        imagedestroy($image);
        return $path;
    }

    function getUserDataByEmail($email)
    {
        return $this->setQuery('SELECT id FROM `websocket`.`users` WHERE email=?')->loadRow([$email]);
    }

    function createNewUser()
    {
        $query = 'INSERT INTO `websocket`.`users`
        ( `name`, `email`, `password`,
        `profile`, `status`, `created_on`, `verification_code`
        )
        VALUES (?,?,?,?,?,?,?)';


        
        return $this->setQuery($query)->save([
                $this->name,
                $this->email,
                $this->password,
                $this->profile,
                $this->status,
                $this->created_on,
                $this->verification_code,
            ]);
        
    }
}
