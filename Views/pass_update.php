<?php
session_start();


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
                    <form id="login-form" class="form" action="pass_comp.php" method="post">
                        <input type="hidden" name="id" id="id" value="<?php echo htmlspecialchars($user_id['id'], ENT_QUOTES) ?>">
                        <div class="form-group my-5">
                            <label for="password" class="normal-text lead">New Pass:</label><br>
                            <?php if(isset($err['password'])) : ?>
                                <p class="text-danger"><?php echo $err['password']; ?></p>
                            <?php endif; ?>
                            <input type="password" name="password" placeholder="New Pass" id="password" class="form-control">
                        </div>

                        <div class="form-group my-5">
                            <label for="password_conf" class="normal-text lead">Pass Conf:</label><br>
                            <?php if(isset($err['password_conf'])) : ?>
                                <p class="text-danger"><?php echo $err['password_conf']; ?></p>
                            <?php endif; ?>
                            <input type="password" name="password_conf" placeholder="Pass Conf" id="password_conf" class="form-control">
                        </div>
                        <div class="form-group my-5">
                            <dl class="py-20 d-flex d-flex justify-content-around">
                                <input type="submit" name="submit" class="btn btn-primary btn-lg" value="Pass Reset">
                                <a href="Login.php" class="btn btn-primary btn-lg">BacK to Page</a>
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