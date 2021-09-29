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

        var html_data =
            "<div class='" + row_class 
            + "'><div class='col-sm-10'><div class='shadow-sm alert "
            + background_class + "'><b>"
            + data.from + " - </b>" + data.msg
            + "<br /><div class='text-right'><small><i>"
            + data.dt
            + "</i></small></div></div></div></div>";

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
});