<?php
session_start();
require_once(ROOT_PATH .'Controller/CoordinateController.php');
$delete = new CoordinateController();
$delete->delete();


//リファラ情報の有無による分岐
$referer = isset( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : null;

if (preg_match( "/past_detail/", $referer)) { // 正規表現による文字列判定
    header('Location: mypage.php');
    return;
} elseif(preg_match( "/main/", $referer)) {
    header('Location: main.php');
    return;
}


// // リファラ情報の有無による分岐
// $referer = isset( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : null;

// if (preg_match( "/post_edit/", $referer)) { // 正規表現による文字列判定
//     header('Location: mypage.php');
//     return;
// } elseif(preg_match( "/main/", $referer)) {
//     header('Location: main.php');
//     return;
// }