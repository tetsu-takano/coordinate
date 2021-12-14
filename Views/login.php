<?php
session_start();
require_once(ROOT_PATH . 'Models/Users.php');

$result = Users::checkLogin();
if($result) {
    header('Location: main.php?id='.$_SESSION['login_user']['id']);
    return;
}
$errors = $_SESSION;
$_SESSION = array();

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
                    <p class="text-center normal-text ">アカウントのリンクを行ってくだいさい。</p>
                </div>
                <?php if (isset($errors['msg'])) : ?>
                    <p class="text-center"><?php echo $errors['msg']; ?></p>
                <?php endif; ?>
                <form class="form-sign-in" method="post" action="login_comp.php">
                    <?php if (isset($errors['email'])) : ?>
                        <p><span><?php echo $errors['email']; ?></span></p>
                    <?php endif; ?>
                <input type="text" class="form-control" placeholder="Mail" name="email">
                    <?php if (isset($errors['pass'])) : ?>
                        <p><span><?php echo $errors['pass']; ?></span></p>
                    <?php endif; ?>
                <input type="password" class="form-control" placeholder="Password" name="pass">
                <dl>
                    <input class="btn btn-lg btn-primary btn-block" type="submit" value="Login">
                </dl>
                <a href="pass_reset.php" class="forgot-pass">Forgot Password? </a><span class="clearfix"></span>
                </form>
            </div>
            <a href="signup.php" class="text-center new-account">Create an account </a>
            <p class="text-center smallest-text">If you'd rather set up your account by entering your account and routing numbers you can do so by <a>setting up manually</a>.</p>
        </div>
    </div>
</body>
</html>