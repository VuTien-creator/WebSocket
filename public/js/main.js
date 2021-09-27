
$(document).ready(function () {

    $('#register_form').parsley();

});

// $(document).ready(function(){
//     $("#user_email").keyup(function(){
//         var check = $(this).val();
//             // $('#message').html(check);
//         $.post('checkEmailRegisterAjax'),{email:check}, function(data){
//             $('#message').html(data);
//         };
//     });
// });

$(document).ready(function () {

    var conn = new WebSocket('ws://localhost:8080');
    conn.onopen = function (e) {
        console.log("Connection established!");
    };

    conn.onmessage = function (e) {
        console.log(e.data);

        var data = JSON.parse(e.data);

        var row_class = '';

        var background_class = '';

        if (data.from == 'Me') {
            row_class = 'row justify-content-start';
            background_class = 'text-dark alert-light';
        } else {
            row_class = 'row justify-content-end';
            background_class = 'alert-success';
        }

        var html_data = "<div class='" + row_class + "'><div class='col-sm-10'><div class='shadow-sm alert " + background_class + "'><b>" + data.from + " - </b>" + data.msg + "<br /><div class='text-right'><small><i>" + data.dt + "</i></small></div></div></div></div>";

        $('#messages_area').append(html_data);

        $("#chat_message").val("");
    };

    $('#chat_form').parsley();

    $('#messages_area').scrollTop($('#messages_area')[0].scrollHeight);

    $('#chat_form').on('submit', function (event) {

        event.preventDefault();

        if ($('#chat_form').parsley().isValid()) {

            var user_id = $('#login_user_id').val();

            var message = $('#chat_message').val();

            var data = {
                userId: user_id,
                msg: message
            };

            conn.send(JSON.stringify(data));

            $('#messages_area').scrollTop($('#messages_area')[0].scrollHeight);

        }

    });

    $('#logout').click(function () {

        user_id = $('#login_user_id').val();

        $.ajax({
            url: "action.php",
            method: "POST",
            data: {
                user_id: user_id,
                action: 'leave'
            },
            success: function (data) {
                var response = JSON.parse(data);

                if (response.status == 1) {
                    conn.close();
                    location = 'index.php';
                }
            }
        })

    });

});
$(document).ready(function () {

    var receiver_userid = '';

    var conn = new WebSocket('ws://localhost:8080?token=<?php echo $token; ?>');

    conn.onopen = function (event) {
        console.log('Connection Established');
    };

    conn.onmessage = function (event) {
        var data = JSON.parse(event.data);

        if (data.status_type == 'Online') {
            $('#userstatus_' + data.user_id_status).html('<i class="fa fa-circle text-success"></i>');
        }
        else if (data.status_type == 'Offline') {
            $('#userstatus_' + data.user_id_status).html('<i class="fa fa-circle text-danger"></i>');
        }
        else {

            var row_class = '';
            var background_class = '';

            if (data.from == 'Me') {
                row_class = 'row justify-content-start';
                background_class = 'alert-primary';
            }
            else {
                row_class = 'row justify-content-end';
                background_class = 'alert-success';
            }

            if (receiver_userid == data.userId || data.from == 'Me') {
                if ($('#is_active_chat').val() == 'Yes') {
                    var html_data = `
						<div class="`+ row_class + `">
							<div class="col-sm-10">
								<div class="shadow-sm alert `+ background_class + `">
									<b>`+ data.from + ` - </b>` + data.msg + `<br />
									<div class="text-right">
										<small><i>`+ data.datetime + `</i></small>
									</div>
								</div>
							</div>
						</div>
						`;

                    $('#messages_area').append(html_data);

                    $('#messages_area').scrollTop($('#messages_area')[0].scrollHeight);

                    $('#chat_message').val("");
                }
            }
            else {
                var count_chat = $('#userid' + data.userId).text();

                if (count_chat == '') {
                    count_chat = 0;
                }

                count_chat++;

                $('#userid_' + data.userId).html('<span class="badge badge-danger badge-pill">' + count_chat + '</span>');
            }
        }
    };

    conn.onclose = function (event) {
        console.log('connection close');
    };

    function make_chat_area(user_name) {
        var html = `
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col col-sm-6">
							<b>Chat with <span class="text-danger" id="chat_user_name">`+ user_name + `</span></b>
						</div>
						<div class="col col-sm-6 text-right">
							<a href="chatroom.php" class="btn btn-success btn-sm">Group Chat</a>&nbsp;&nbsp;&nbsp;
							<button type="button" class="close" id="close_chat_area" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					</div>
				</div>
				<div class="card-body" id="messages_area">

				</div>
			</div>

			<form id="chat_form" method="POST" data-parsley-errors-container="#validation_error">
				<div class="input-group mb-3" style="height:7vh">
					<textarea class="form-control" id="chat_message" name="chat_message" placeholder="Type Message Here" data-parsley-maxlength="1000" data-parsley-pattern="/^[a-zA-Z0-9 ]+$/" required></textarea>
					<div class="input-group-append">
						<button type="submit" name="send" id="send" class="btn btn-primary"><i class="fa fa-paper-plane"></i></button>
					</div>
				</div>
				<div id="validation_error"></div>
				<br />
			</form>
			`;

        $('#chat_area').html(html);

        $('#chat_form').parsley();
    }

    $(document).on('click', '.select_user', function () {

        receiver_userid = $(this).data('userid');

        var from_user_id = $('#login_user_id').val();

        var receiver_user_name = $('#list_user_name_' + receiver_userid).text();

        $('.select_user.active').removeClass('active');

        $(this).addClass('active');

        make_chat_area(receiver_user_name);

        $('#is_active_chat').val('Yes');

        $.ajax({
            url: "action.php",
            method: "POST",
            data: { action: 'fetch_chat', to_user_id: receiver_userid, from_user_id: from_user_id },
            dataType: "JSON",
            success: function (data) {
                if (data.length > 0) {
                    var html_data = '';

                    for (var count = 0; count < data.length; count++) {
                        var row_class = '';
                        var background_class = '';
                        var user_name = '';

                        if (data[count].from_user_id == from_user_id) {
                            row_class = 'row justify-content-start';

                            background_class = 'alert-primary';

                            user_name = 'Me';
                        }
                        else {
                            row_class = 'row justify-content-end';

                            background_class = 'alert-success';

                            user_name = data[count].from_user_name;
                        }

                        html_data += `
							<div class="`+ row_class + `">
								<div class="col-sm-10">
									<div class="shadow alert `+ background_class + `">
										<b>`+ user_name + ` - </b>
										`+ data[count].chat_message + `<br />
										<div class="text-right">
											<small><i>`+ data[count].timestamp + `</i></small>
										</div>
									</div>
								</div>
							</div>
							`;
                    }

                    $('#userid_' + receiver_userid).html('');

                    $('#messages_area').html(html_data);

                    $('#messages_area').scrollTop($('#messages_area')[0].scrollHeight);
                }
            }
        })

    });

    $(document).on('click', '#close_chat_area', function () {

        $('#chat_area').html('');

        $('.select_user.active').removeClass('active');

        $('#is_active_chat').val('No');

        receiver_userid = '';

    });

    $(document).on('submit', '#chat_form', function (event) {

        event.preventDefault();

        if ($('#chat_form').parsley().isValid()) {
            var user_id = parseInt($('#login_user_id').val());

            var message = $('#chat_message').val();

            var data = {
                userId: user_id,
                msg: message,
                receiver_userid: receiver_userid,
                command: 'private'
            };

            conn.send(JSON.stringify(data));
        }

    });

    $('#logout').click(function () {

        user_id = $('#login_user_id').val();

        $.ajax({
            url: "action.php",
            method: "POST",
            data: { user_id: user_id, action: 'leave' },
            success: function (data) {
                var response = JSON.parse(data);
                if (response.status == 1) {
                    conn.close();

                    location = 'index.php';
                }
            }
        })

    });

});

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
