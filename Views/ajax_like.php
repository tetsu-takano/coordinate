<?php
require_once(ROOT_PATH .'Controller/CoordinateController.php');
require_once(ROOT_PATH .'/database.php');
require_once(ROOT_PATH .'/Models/Db.php');

$user_id = $_POST['user_id'];
$post_id = $_POST['post_id'];

$like = new CoordinateController;
$params = $like->like($user_id,$post_id);
