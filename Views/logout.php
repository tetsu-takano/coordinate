<?php
session_start();
require_once(ROOT_PATH . 'Models/Users.php');

if(!$logout = filter_input(INPUT_POST, 'logout'))
{
    header('Location: login.php');
    exit();
}
users::logout();

?>
