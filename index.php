<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');

require './mvc/Bridge.php';
// $_SESSION['user_data']=1;
$app = new App;

