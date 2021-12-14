<?php
session_start();
$_POST = $_SESSION['form'];
require_once(ROOT_PATH .'Controller/UsersController.php');
$update = new UsersController();
$params = $delete->delete();

$_SESSION['login_user'] = $params['user'];