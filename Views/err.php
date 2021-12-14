<?php
session_start();
$_SESSION = [];
session_destroy();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/css/base.css">
<title>エラー画面</title>
</head>
<body>
  <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="account-wall">
                <div class="brand-logo">
                  <img class="profile-img" src="/img/logo_small.png" alt="">
                </div>
                <form class="form-sign-in" method="POST" action="signup_comp.php">
                  <dl class="inner_confirm">
                    <h1 class="text-center text-danger">既に登録されているユーザです。</h1>
                    <a href="login.php">
                        <button class="btn btn-lg btn-primary btn-block" type="button">
                            Login Page
                        </button>
                    </a>
                    <a href="signup.php">
                        <button class="btn btn-lg btn-primary btn-block" type="button">
                            Signup Page
                        </button>
                    </a>
                  </dl>
                </form>
            </div>
            <p class="text-center smallest-text">If you'd rather set up your account by entering your account and routing numbers you can do so by <a>setting up manually</a>.</p>
        </div>
    </div>
</body>
</html>
</body>
</html>
