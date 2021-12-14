<?php
session_start();
require_once(ROOT_PATH .'Models/Users.php');
require_once(ROOT_PATH .'Controller/UsersController.php');
$reset = new UsersController();
$reset->reset($_POST['id'],$_POST['password']);
var_dump($reset);

//エラーメッセージ
$err = [];

//バリデーション
//パスワード(空チェック、正規表現チェック)
if(empty($_POST['password'])) {
    $err['password'] = 'パスワードを記入してください。';
} elseif(!preg_match("/\A[a-z\d]{8,100}+\z/i", $_POST['password'])) {
    $err['password'] = 'パスワードは英数字８文字以上１００文字以下にしてください。';
}
//確認用パスワード(パスワードとあっているか)
if(empty($_POST['password_conf'])) {
    $err['password_conf'] = '確認用パスワードを記入してください。';
} elseif($_POST['password'] !== $_POST['password_conf']) {
    $err['password_conf'] = 'パスワードと異なっています。';
}

if(count($err) > 0) {
    //エラーがあった場合は戻す
    $_SESSION = $err;
    header('Location: pass_update.php');
    return;
}

//エラーがない場合にパスワードを更新する
require_once(ROOT_PATH .'Controller/UsersController.php');
$reset = new UsersController();
$reset->reset($_POST['id'],$_POST['password']);

// // ログイン成功時の処理
// $result = User::login($email, $password);
// //ログイン失敗時の処理
// if(!$result){
//     header('Location: login.php');
//     return;
// }

// $login_user = $_SESSION['login_user'];

?>

<!doctype html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/css/base.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div id="col-md-6 offset-md-3">
                <div class="brand-logo">
                    <img class="profile-img" src="/img/logo_small.png" alt="">
                </div>
                <div class="container">
                    <div  class="row justify-content-center align-items-center">
                        <div  class="col-md-6">
                            <div  class="col-md-12">
                                <h3 class="text-center my-5">パスワード更新が完了致しました。</h3>
                                <a href="login.php" class="btn btn-primary btn-lg d-block mx-auto my-5">Login Page</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>
</html>