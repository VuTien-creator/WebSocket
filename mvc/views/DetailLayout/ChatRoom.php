<div class="container">
    <br />
    <h3 class="text-center">Realtime Chat App using WebSockets - Group 10</h3>
    <br />
    <div class="row">

        <div class="col-lg-8">
            <?php

            if (isset($_SESSION['msg'])) {
                echo '
                                <div class="alert alert-success">
                                ' . $_SESSION["msg"] . '
                                </div>
                                ';
                unset($_SESSION['msg']);
            }

            if (isset($_SESSION['error'])) {
                echo '
                                <div class="alert alert-danger">
                                ' . $_SESSION['error'] . '
                                </div>
                                ';
                unset($_SESSION['error']);
            }

            ?>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col col-sm-6">
                            <h3>Chat Room</h3>
                        </div>

                        <div class="col col-sm-6 text-right">
                            <a href="privatechat.php" class="btn btn-success btn-sm">Private Chat</a>
                        </div>
                    </div>
                </div>
                <div class="card-body" id="messages_area">
                    <?php
                    // foreach ($chat_data as $chat) {
                    //     if (isset($_SESSION['user_data'][$chat['userid']])) {
                    //         $from = 'Me';
                    //         $row_class = 'row justify-content-start';
                    //         $background_class = 'text-dark alert-light';
                    //     } else {
                    //         $from = $chat['user_name'];
                    //         $row_class = 'row justify-content-end';
                    //         $background_class = 'alert-success';
                    //     }

                    //     echo '
                    // 	<div class="' . $row_class . '">
                    // 		<div class="col-sm-10">
                    // 			<div class="shadow-sm alert ' . $background_class . '">
                    // 				<b>' . $from . ' - </b>' . $chat["msg"] . '
                    // 				<br />
                    // 				<div class="text-right">
                    // 					<small><i>' . $chat["created_on"] . '</i></small>
                    // 				</div>
                    // 			</div>
                    // 		</div>
                    // 	</div>
                    // 	';
                    // }
                    ?>
                </div>
            </div>

            <form method="post" id="chat_form" data-parsley-errors-container="#validation_error">
                <div class="input-group mb-3">
                    <textarea class="form-control" id="chat_message" name="chat_message" placeholder="Type Message Here" data-parsley-maxlength="1000" data-parsley-pattern="/^[a-zA-Z0-9\s]+$/" required></textarea>
                    <div class="input-group-append">
                        <button type="submit" name="send" id="send" class="btn btn-primary"><i class="fa fa-paper-plane"></i></button>
                    </div>
                </div>
                <div id="validation_error"></div>
            </form>
        </div>
        <div class="col-lg-4">
            <input type="hidden" name="login_user_id" id="login_user_id" value="<?php echo $data['user']['id'] ?>" />
            <div class="mt-3 mb-3 text-center">
                <img src="<?php echo BASEURL . $data['user']['profile'] ?>" width="150" class="img-fluid rounded-circle img-thumbnail" />
                <h3 class="mt-2"><?php echo $data['user']['name'] ?></h3>
                <a href="<?php echo BASEURL ?>chat/edit/<?php echo $data['user']['id'] ?>" class="btn btn-secondary mt-2 mb-2">Edit</a>
                <input type="button" class="btn btn-primary mt-2 mb-2" name="logout" id="logout" value="Logout" />
            </div>
            <div class="card mt-3">
                <div class="card-header">User List</div>
                <div class="card-body" id="user_list">
                    <div class="list-group list-group-flush">
                        <?php
                        // if (count($user_data) > 0) {
                        //     foreach ($user_data as $key => $user) {
                        //         $icon = '<i class="fa fa-circle text-danger"></i>';

                        //         if ($user['user_login_status'] == 'Login') {
                        //             $icon = '<i class="fa fa-circle text-success"></i>';
                        //         }

                        //         if ($user['user_id'] != $login_user_id) {
                        //             echo '
                        // 			<a class="list-group-item list-group-item-action">
                        // 				<img src="' . $user["user_profile"] . '" class="img-fluid rounded-circle img-thumbnail" width="50" />
                        // 				<span class="ml-1"><strong>' . $user["user_name"] . '</strong></span>
                        // 				<span class="mt-2 float-right">' . $icon . '</span>
                        // 			</a>
                        // 			';
                        //         }
                        //     }
                        // }
                        ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script src="<?php echo BASEURL ?>public/js/logout.js"></script>
<script src="<?php echo BASEURL ?>public/js/connect.js"></script>

