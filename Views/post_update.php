<?php
session_start();
// $postData = $_SESSION['postData'];
// $itemData = $_SESSION['itemData'];
// $postImage = $_SESSION['postImage'];
$_FILES['img'] = $_SESSION['postImage'];

$file = $_FILES['img'];
$filename = basename($file['name']);
$tmp_path = $file['tmp_name'];
$file_err = $file['error'];
$filesize = $file['size'];

$upload_dir = 'img/';
$save_filename = date('YmdHis') . $filename;

$save_path = $upload_dir . $save_filename;


require_once(ROOT_PATH .'Controller/CoordinateController.php');
$Post = new CoordinateController();
$params = $Post->update($_SESSION['itemData']);

header('Location: mypage.php')



?>