$(document).ready(function () {
    $('#logout').click(function () {

        //get id user want to logout
        user_id = $('#login_user_id').val();

        $.ajax({

            url: "http://localhost/do_an/WebSocket/chat/logout",
            method: "POST",
            data: {
                // user_id: user_id,
                user_id: $('#login_user_id').val(),

                action: 'logout'
            },

            success: function (data) {

                // if (response.status == 1) {
                // conn.close();
                window.location.href = 'http://localhost/do_an/WebSocket/';
                // }
            }
        })

    });
});