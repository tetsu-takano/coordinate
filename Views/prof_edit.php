<?php
session_start();
require_once(ROOT_PATH .'Controller/UsersController.php');
$edit = new UsersController();
$params = $edit->edit();

// 使用する変数を初期化
$name = '';
$email = '';
$gender = '';
$hight = '';
$pass = '';

// エラー内容

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    // 名前のチェック
    if(isset($_POST)){
        if(empty($_POST['name'])) {
            $errors['name'] = "名前は必須入力です。10文字以内でご入力ください。";
        } elseif(mb_strlen($_POST['name']) > 10) {
            $errors['name'] = "名前は10文字以内でご入力ください。";
        }
        // メールアドレスのチェック
        if(empty($_POST['email'])) {
            $errors['email'] = "メールアドレスは必須入力です。正しくご入力ください。";
        } elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "メールアドレスは正しくご入力ください。";
        }
        // 性別のチェック
        if(empty($_POST['gender'])) {
            $errors['gender'] = "性別は必須入力です。";
        }
        // 身長のチェック
        if(isset($_POST['hight'])){
            if(!preg_match("/[0-9]+$/", $_POST['hight'])) {
            $errors['hight'] = "身長は半角数字でご入力ください。";
            }
        }
        //パスワードのチェック
        if(isset($_POST['pass'])){
            if(!preg_match('/\A(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{8,100}+\z/', $_POST['pass'])) {
            $errors['pass'] = "パスワードは半角英数字で大文字と小文字を含めて8文字以上100文字以下でご入力ください。";
            }
        }
    }
    
    // エラーがなければ更新完了画面に移動
    if (count($errors) === 0) {
        $_SESSION['form'] = $_POST;
        header('Location:prof_update.php');
        exit();
    }
}

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
                    <p class="text-center normal-text ">下記項目に新規アカウント情報をご入力下さい。</p>
                </div>
                <form class="form-sign-in" method="POST" action="">
                    <dd>
                    <input type="hidden" name="id" id="id" value="<?php echo htmlspecialchars($params['user']['id'], ENT_QUOTES) ?>">
                        <?php if(isset($_POST['name'])):?>
                            <?php if(empty($_POST['name']) || mb_strlen($_POST['name']) > 10): ?>
                                <p class="error-message"><?php echo $errors['name']; ?></p>
                            <?php endif; ?>
                        <?php endif; ?>
                        <input type="text" class="form-control" placeholder="Username" id="name" name="name" value="<?php echo htmlspecialchars($params['user']['name'], ENT_QUOTES) ?>">
                    </dd>
                        <?php if(isset($_POST['email'])):?>
                            <?php if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)): ?>
                                <p class="error-message"><?php echo $errors['email']; ?></p>
                            <?php endif; ?>
                        <?php endif; ?>
                        <input type="text" class="form-control" placeholder="Mail" id="email" name="email" value="<?php echo htmlspecialchars($params['user']['email'], ENT_QUOTES) ?>">
                    <dt class="text-muted">
                        Gender
                    </dt>
                    <dd>
                        <input type="radio" class="form-check-input" name="gender" id="gender" value="male" <?php if($params['user']['gender'] == "male"){print "checked"; } ?>>
                            <label class="form-check-label" for="flexRadioDefault1">
                                male
                            </label>
                    </dd>
                    <dd>
                        <?php if(isset($_POST['gender'])):?>
                            <?php if(empty($_POST['gender'])): ?>
                                <p class="error-message"><?php echo $errors['gender']; ?></p>
                            <?php endif; ?>
                        <?php endif; ?>
                        <input type="radio" class="form-check-input" name="gender" id="gender" value="female" <?php if($params['user']['gender'] == "female"){print "checked"; } ?>>
                            <label class="form-check-label" for="flexRadioDefault2">
                                female
                            </label>
                    </dd>
                    <dd>
                        <?php if(isset($_POST['gender'])):?>
                            <?php if(empty($_POST['gender'])): ?>
                                <p class="error-message"><?php echo $errors['gender']; ?></p>
                            <?php endif; ?>
                        <?php endif; ?>
                        <input type="radio" class="form-check-input" name="gender" id="gender" value="others" <?php if($params['user']['gender'] == "others"){print "checked"; } ?>>
                            <label class="form-check-label" for="flexRadioDefault2">
                                others
                            </label>
                    </dd>
                    <dd>
                        <?php if(isset($_POST['hight'])):?>
                            <?php if(empty($_POST['hight']) || !preg_match("/[0-9]+$/", $_POST['hight'])): ?>
                                <p class="error-message"><?php echo $errors['hight']; ?></p>
                            <?php endif; ?>
                        <?php endif; ?>
                        <input type="text" class="form-control" placeholder="Hight" id="hight" name="hight" value="<?php echo htmlspecialchars($params['user']['hight'], ENT_QUOTES) ?>">
                    </dd>
                    <dd>
                        <?php if(isset($_POST['pass'])):?>
                            <?php if(empty($_POST['pass']) || !preg_match('/\A(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{8,100}+\z/', $_POST['pass'])): ?>
                                <p class="error-message"><?php echo $errors['pass']; ?></p>
                            <?php endif; ?>
                        <?php endif; ?>
                        <input type="password" class="form-control" placeholder="Password" id="pass" name="pass" value="<?php echo htmlspecialchars($params['user']['pass'], ENT_QUOTES) ?>">
                    </dd>
                    <dl class="py-20">
                    <input class="btn btn-lg btn-primary btn-block" type="submit" value="Update">
                    <a href="prof_delete.php?id=<?=$login_user['id'] ?>" class="btn btn-primary btn-lg" onclick="return confirm('本当にユーザーを削除しますか？')">Delete Profile</a>
                    </dl>
                </form>
            </div>
            <p class="text-center smallest-text">If you'd rather set up your account by entering your account and routing numbers you can do so by <a>setting up manually</a>.</p>
        </div>
    </div>
</body>
</html>