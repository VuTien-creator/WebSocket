<?php

ob_start();
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');

define('TEMPLATE_PATH','public/');

// define constant to connect data
define('HOST','localhost');
define('PORT','3306');
define('DBNAME','websocket');
define('USERNAME','root');
define('PASSWORD','');
define('BASEURL','http://localhost/do_an/WebSocket/');
