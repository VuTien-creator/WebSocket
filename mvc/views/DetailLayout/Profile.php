
<div class="container">
    <br />
    <br />
    <h1 class="text-center">Manage your profile</h1>
    <br />
    <br />
    <?php 
    // echo $message; 
    ?>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">Profile</div>
                <div class="col-md-6 text-right"><a href="<?php echo BASEURL?>chat/index" class="btn btn-warning btn-sm">Go to Chat</a></div>
            </div>
        </div>
        <div class="card-body">
            <form method="post" action="<?php echo BASEURL?>Chat/updateInfo" id="profile_form" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="user_name" id="user_name" value="<?php echo $data['user']->name; ?>"
                     class="form-control" data-parsley-pattern="/^[a-zA-Z\s]+$/" required  />
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="user_email" id="user_email" value="<?php echo $data['user']->email; ?>" 
                    class="form-control" data-parsley-type="email" required readonly  />
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="user_password" id="user_password" value="<?php echo $data['user']->password; ?>" 
                    class="form-control" data-parsley-minlength="6" data-parsley-maxlength="12" data-parsley-pattern="^[a-zA-Z]+$" required />
                </div>
            <input type="hidden" name="id_user" value="<?php echo $data['user']->id?>"/>

                <div class="form-group">
                    <label>Profile</label><br />
                    <input type="file" name="user_profile" id="user_profile" />
                    <br />
                    <img src="<?php echo BASEURL.$data['user']->profile?>" class="img-fluid img-thumbnail mt-3" width="100" />
                    <input type="hidden" name="hidden_user_profile" />
                </div>

                <div class="form-group text-center">
                    <input type="submit" name="edit" class="btn btn-primary" value="Edit" />
                </div>
            </form>
        </div>
    </div>
</div>
<script>

$(document).ready(function(){

    $('#profile_form').parsley();

    $('#user_profile').change(function(){
        var extension = $('#user_profile').val().split('.').pop().toLowerCase();
        if(extension != '')
        {
            if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
            {
                alert("Invalid Image File");
                $('#user_profile').val('');
                return false;
            }
        }
    });

});

</script>