<?php
session_start();
require_once(ROOT_PATH .'Models/Users.php');

$result = Users::checkLogin();

if($result) {
    header('Location: main.php?id='.$_SESSION['login_user']['id']);
    return;
}

$err = $_SESSION;

//セッションを消す
$_SESSION = array();
session_destroy();

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
        <div  class="row">
            <div  class="col-md-6 offset-md-3">
                <div  class="account-wall">
                    <div class="brand-logo">
                        <img class="profile-img" src="/img/logo_small.png" alt="">
                    </div>
                    <?php if(isset($err['msg'])) : ?>
                        <p class="text-danger"><?php echo $err['msg']; ?></p>
                    <?php endif; ?>
                    <form id="login-form" class="form" action="reset_mail.php" method="post">
                        <div class="form-group my-5">
                        <label for="birth" class="normal-text lead">Mail:</label><br>
                            <?php if(isset($err['email'])) : ?>
                                <p class="text-danger"><?php echo $err['email']; ?></p>
                            <?php endif; ?>
                            <input type="email" name="email" id="email" placeholder="Mail" class="form-control">
                        </div>
                        <div class="form-group my-5">
                            <label for="birth" class="normal-text lead">Birth:</label><br>
                            <?php if(isset($err['birth'])) : ?>
                                <p class="text-danger"><?php echo $err['birth']; ?></p>
                            <?php endif; ?>
                            <input type="date" name="birth" id="birth" class="form-control">
                        </div>
                        <div class="form-group my-5">
                            <dl class="py-20 d-flex d-flex justify-content-around">
                                <input type="submit" name="submit" class="btn btn-primary btn-lg" value="Send Email">
                                <a href="Login.php" class="btn btn-primary btn-lg">Back to Login Page</a>
                            </dl>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>
</html>