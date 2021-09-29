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
    private $user_token;
    // private $token;
    // private $connection_id;

    function setUserID($id)
    {
        $this->id = $id;
    }
    function getUserID()
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
        $path = "public/images/" . time() . ".png"; //create path to images (unique)
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

    function getUserDataByEmail()
    {
        try {
            //code...
            return $this->setQuery('SELECT * FROM `websocket`.`users` WHERE email=?')->loadRow([$this->getUserEmail()]);
            //  $this->setQuery('SELECT * FROM `websocket`.`users` WHERE email=?')->loadRow([$this->getUserEmail()]);
        } catch (Exception $e) {
            //throw $th;
            exit($e->getMessage());
        }
    }

    function getUserDataByVerifyCode()
    {
        try {
            //code...
            return $this->setQuery('SELECT id FROM `websocket`.`users` where verification_code =?')
                ->loadRow([$this->getUserVerification()]);
        } catch (Exception $e) {
            //throw $th;
            exit($e->getMessage());
        }
    }

    function enableUserByVerifyCode()
    {
        try {
            //code...
            $this->setQuery("UPDATE `websocket`.`users` SET status='Enable' WHERE verification_code=?")
                ->save([$this->getUserVerification()]);
            return true;
        } catch (Exception $e) {
            //throw $th;
            exit($e->getMessage());
        }
    }

    function createNewUser()
    {
        $query = 'INSERT INTO `websocket`.`users`
        ( `name`, `email`, `password`,
        `profile`, `status`, `created_on`, `verification_code`
        )
        VALUES (?,?,?,?,?,?,?)';

        try {
            //code...
            $this->setQuery($query)->save([
                $this->name,
                $this->email,
                $this->password,
                $this->profile,
                $this->status,
                $this->created_on,
                $this->verification_code,
            ]);
            return true;
        } catch (Exception $e) {
            exit($e->getMessage());
        }
    }
    function setUserToken($token)
    {
        $this->user_token = $token;
    }

    function updateUserLoginData()
    {
        $query ="UPDATE `websocket`.`users` SET login_status=? WHERE id=?";
        try {
            //code...
            $this->setQuery($query)->save([$this->getUserLoginStatus(), $this->getUserID()]);
            return true;
        } catch (Exception $e) {
            //throw $th;
            exit($e->getMessage());
        }
    }
    function getUserDataById() {
        $query = 'SELECT * FROM `websocket`.`users` where id =?';

        try {
            //code...
            return $this->setQuery($query)->loadRow([$this->getUserID()]);
        } catch (Exception $e) {
            //throw $th;
            exit($e->getMessage());
        }
    }

    function upload_image($fileName){
        try {
            //code...
            $extension = explode('.', $fileName['name']);
            $new_name = rand() . '.' . $extension[1];
            $destination = 'public/images/' . $new_name;
            move_uploaded_file($fileName['tmp_name'], $destination);

            return $destination;
        } catch (Exception $e) {
            //throw $th;
            exit($e->getMessage());
        }
    }

    function updateProfile(){
        // $query ="UPDATE `websocket`.`users` SET name=?, password=? , profile=? WHERE id=?";
        $query ="UPDATE `websocket`.`users` SET name=?, password=? , profile=? WHERE id=?";


        try {
            // $this->statement = $this->pdo->prepare($query);
            // return $this->statement->execute();
            $this->setQuery($query)
            ->save([$this->getUserName(),$this->getPassword(),$this->getProfile(), $this->getUserID()]);
            return true;
        } catch (Exception $e) {
            //throw $th;
            exit($e->getMessage());
        }
    }

    function userLogout(){
        $query = "UPDATE `websocket`.`users` SET login_status=? WHERE id=?";
        
        try {
            $this->setQuery($query)->save([$this->getUserLoginStatus(),$this->getUserID()]);
            return true;
        } catch (Exception $e) {
            //throw $th;
            exit($e->getMessage());
        }
    }
}
