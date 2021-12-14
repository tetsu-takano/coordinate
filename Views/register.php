<?php
session_start();

$_POST = $_SESSION['form'];

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once(ROOT_PATH .'Models/Users.php');

    $result = Users::checkUser($_POST['email'], $_POST['birth']);
    if(!$result){
    header('Location: err.php');
    return;
    }else{
        $_SESSION['form'] = $_POST;
    header('Location: signup_comp.php');
    exit();
    }
}

// function h($str) {
//     return htmlspecialchars($str,ENT_QUOTES,'UTF-8');
//   }
//   // ダイレクトアクセス禁止
//   header('Location: signup.php');
//     exit();
//   } else {
//     // 入if (isset($_SESSION['form'])) {
//     h力データを表示
//     $_POST = $_SESSION['form'];
//   }



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
                <form class="form-sign-in" method="post" action="signup_comp.php">
                    <div class="form-group my-5">
                        <label for="name" class="text-info lead">Username:</label><br>
                        <p><?php echo htmlspecialchars($_POST['name']); ?></p>
                    </div>
                    <div class="form-group my-5">
                        <label for="email" class="text-info lead">Mail:</label><br>
                        <p><?php echo htmlspecialchars($_POST['email']); ?></p>
                    </div>
                    <div class="form-group my-5">
                        <label for="birth" class="text-info lead">Birth:</label><br>
                        <p><?php echo htmlspecialchars($_POST['birth']); ?></p>
                    </div>
                    <div class="form-group my-5">
                        <label for="gender" class="text-info lead">Gender:</label><br>
                        <p><?php echo htmlspecialchars($_POST['gender']); ?></p>
                    </div>
                    <div class="form-group my-5">
                        <label for="hight" class="text-info lead">Hight:</label><br>
                        <p><?php echo htmlspecialchars($_POST['hight']); ?></p>
                    </div>
                    <div class="form-group my-5">
                        <label for="pass" class="text-info lead">Pass:</label><br>
                        <p><?php echo htmlspecialchars($_POST['pass']); ?></p>
                    </div>
                <dl>
                    <input class="btn btn-lg btn-primary btn-block" type="submit" value="Sign in">
                </dl>
                </form>
            </div>
            <p class="text-center smallest-text">If you'd rather set up your account by entering your account and routing numbers you can do so by <a>setting up manually</a>.</p>
        </div>
    </div>
</body>
</html>