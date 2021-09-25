<?php
ob_start();
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');

require './mvc/Bridge.php';
$app = new App;
