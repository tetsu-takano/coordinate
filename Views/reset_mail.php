<?php
session_start();
require_once(ROOT_PATH .'Models/Users.php');
$err = $_SESSION;


if(!isset($_SESSION['password']) && !isset($_SESSION['password_conf'])) {
    //エラーメッセージ
    $err = [];
    //バリデーション
    //メールアドレス(空チェック)
    if(!$email = filter_input(INPUT_POST, 'email')) {
        $err['email'] = 'メールアドレスを記入してください。';
    }
    //パスワード(空チェック)
    if(!$birth = filter_input(INPUT_POST, 'birth')) {
        $err['birth'] = '誕生日を記入してください。';
    }

    if(count($err) > 0) {
        //エラーがあった場合は戻す
        $_SESSION = $err;
        header('Location: pass_reset.php');
        return;
    }

    // メールアドレスと誕生日照会成功時の処理
    $result = Users::checkUser($_POST['email'], $_POST['birth']);
    //照会失敗時の処理
    if(!$result){
    header('Location: pass_reset.php');
    return;
    }elseif($result){
        mb_language("Japanese");
        mb_internal_encoding("UTF-8");

        $subject = "パスワード再設定";
        $message = "パスワード再設定URL.\n http://localhost:8888/pass_update.php";
        $headers = "From:ettsu.8725@gmail.com";
        $hoge = '-f $headers';
        mb_send_mail($_POST['email'], $subject, $message, $headers, $hoge);
        return;
    }
}
$user = $_SESSION['user'];


?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>再設定メール送信完了ページ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/css/base.css">
</head>
<body>
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="account-wall">
                <div class="brand-logo">
                    <img class="profile-img" src="/img/logo_small.png" alt="">
                </div>
                <dl class="inner_confirm">
                    <h1 class="text-center">登録済のメールアドレスに、再設定ページのURLを送信致しました。</h1>
                </dl>
            </div>
            <p class="text-center smallest-text">If you'd rather set up your account by entering your account and routing numbers you can do so by <a>setting up manually</a>.</p>
        </div>
    </div>
</body>
</html>