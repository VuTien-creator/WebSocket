<?php

$action = $_GET['action']??'index';
$controllerName = ($_GET['controller']??'Main').'Controller';

$path = 'controllers/'.$controllerName.'.php';

include 'system/config/config.php';
include 'controllers/Controller.php';