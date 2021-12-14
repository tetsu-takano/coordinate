<?php
session_start();
require_once(ROOT_PATH.'/Models/Users.php');

//バリデーション
$errors = [];

if(!$email = filter_input(INPUT_POST, 'email'))
{
    $errors['email'] = 'メールアドレスをご入力下さい。';
}
if(!$pass = filter_input(INPUT_POST, 'pass'))
{
    $errors['pass'] = 'パスワードご入力下さい。';
};


if(count($errors) > 0)
{
//エラーがあった場合には戻す
    $_SESSION = $errors;
    header('Location: login.php');
    return;
}
//ログイン成功時の処理
$result = Users::login($email, $pass);
//ログイン失敗時の処理
if(!$result)
{
    header('Location: login.php');
    return;
}

$login_user = $_SESSION['login_user'];




?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログインページ</title>
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
                    <h1 class="text-center">ログイン完了致しました。</h1>
                    <a href="main.php?id=<?=$login_user['id'] ?>" class="btn btn-primary btn-lg d-block mx-auto my-5" >Main Page</a>
                </dl>
            </div>
            <p class="text-center smallest-text">If you'd rather set up your account by entering your account and routing numbers you can do so by <a>setting up manually</a>.</p>
        </div>
    </div>
</body>
</html>