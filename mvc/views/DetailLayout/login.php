<div class="row justify-content-md-center mt-5">
    <div class="col-md-4">
        <?php
        if (isset($_SESSION['msg'])) {
            echo '
                        <div class="alert alert-success">
                        ' . $_SESSION["msg"] . '
                        </div>
                        ';
            unset($_SESSION['msg']);
        }

        // if ($error != '') {
        //     echo '
        //                 <div class="alert alert-danger">
        //                 ' . $error . '
        //                 </div>
        //                 ';
        // }
        // if (!empty($data['msg'])) {
        //     echo '
        //                     <div class="alert alert-success">
        //                     ' . $data['msg']. '
        //                     </div>
        //                     ';
        // }
        ?>

            <div class="card">
                <div class="card-header">Login</div>
                <div class="card-body">
                    <form method="post" id="login_form" action="./main/test">
                        <div class="form-group">
                            <label>Enter Your Email Address</label>
                            <input type="text" name="user_email" id="user_email" class="form-control" data-parsley-type="email" required />
                        </div>
                        <div class="form-group">
                            <label>Enter Your Password</label>
                            <input type="password" name="user_password" id="user_password" class="form-control" required />
                        </div>
                        <div class="form-group text-center">
                            <input type="submit" name="login" id="login" class="btn btn-primary" value="Login" />
                        </div>
                    </form>
                    <div><a href="user/registerpage">đăng kí tài khoản</a></div>
                </div>
            </div>
    </div>
</div>