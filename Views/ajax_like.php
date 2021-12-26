<?php
require_once(ROOT_PATH .'Controller/CoordinateController.php');
require_once(ROOT_PATH .'/Models/Like.php');

$user_id = $_POST['user_id'];
$post_id = $_POST['post_id'];

$like = new CoordinateController;
$params = $like->like($user_id,$post_id);
