<?php
session_start();
require_once(ROOT_PATH . '/Controller/UsersController.php');

$_POST = $_SESSION['form'];


$create = new UsersController();
$create->create();

?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規登録ページ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/css/base.css">
    <style>
    </style>
</head>
<body>
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="account-wall">
                <div class="brand-logo">
                    <img class="profile-img" src="/img/logo_small.png" alt="">
                    <p class="text-center normal-text ">アカウントのリンクを行ってくだいさい。</p>
                </div>
                <form class="form-sign-in" method="POST" action="">
                <dl class="inner_confirm">
                    <h1 class="text-center">新規登録完了致しました。</h1>
                    <a href="login.php">
                        <button class="btn btn-lg btn-primary btn-block" type="button">
                            Login Page
                        </button>
                    </a>
                </form>
            </div>
            <p class="text-center smallest-text">If you'd rather set up your account by entering your account and routing numbers you can do so by <a>setting up manually</a>.</p>
        </div>
    </div>
</body>
</html>