<!DOCTYPE html>
<html lang="en">

<head>

    
</head>

<body>

    <div class="containter">
        <br />
        <br />
        <h1 class="text-center">Chat Application in PHP & MySql using WebSocket - Email Verification</h1>
        
        <div class="row justify-content-md-center">
            <div class="col col-md-4 mt-5">
                <?php
                if($error != '')
                {
                    echo '
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                      '.$error.'
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    ';
                }

                if($success_message != '')
                {
                    echo '
                    <div class="alert alert-success">
                    '.$success_message.'
                    </div>
                    ';
                }
                ?>
                <div class="card">
                    <div class="card-header">Register</div>
                    <div class="card-body">

                        <form method="post" id="register_form">

                            <div class="form-group">
                                <label>Enter Your Name</label>
                                <input type="text" name="user_name" id="user_name" class="form-control" data-parsley-pattern="/^[a-zA-Z\s]+$/" required />
                            </div>

                            <div class="form-group">
                                <label>Enter Your Email</label>
                                <input type="text" name="user_email" id="user_email" class="form-control" data-parsley-type="email" required />
                            </div>

                            <div class="form-group">
                                <label>Enter Your Password</label>
                                <input type="password" name="user_password" id="user_password" class="form-control" data-parsley-minlength="6" data-parsley-maxlength="12" data-parsley-pattern="^[a-zA-Z]+$" required />
                            </div>

                            <div class="form-group text-center">
                                <input type="submit" name="register" class="btn btn-success" value="Register" />
                            </div>

                        </form>
                        
                    </div>
                </div>
                
            </div>
        </div>
    </div>

</body>

</html>

<script>

$(document).ready(function(){

    $('#register_form').parsley();

});

</script>