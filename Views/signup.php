<?php
session_start();

// ダイレクトアクセス禁止
// function h($str)
// {
//     return htmlspecialchars($str,ENT_QUOTES,'UTF-8');
// }

// 使用する変数を初期化
$name = '';
$email = '';
$gender = '';
$birth = '';
$hight = '';
$pass = '';
$pass_conf = '';

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
        //誕生日のチェック
        if(empty($_POST['birth'])) {
            $errors['birth'] = "生年月日は必須入力です。";
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
        if(empty($_POST['pass_conf'])){
            $errors['pass_conf'] = "必須入力です。";
        }elseif($_POST['pass'] !== $_POST['pass_conf']){
            $errors['pass_conf'] = "パスワードと異なっております。";
        }
    }

     // エラーがなければ更新完了画面に移動
     if (count($errors) === 0) {
        $_SESSION['form'] = $_POST;
        header('Location: register.php');
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
                    <p class="text-center normal-text ">アカウントのリンクを行ってくだいさい。</p>
                </div>
                <form class="form-sign-in" method="post" action="">
                    <dl>
                        <dd>
                            <?php if(isset($_POST['name'])):?>
                                <?php if(empty($_POST['name']) || mb_strlen($_POST['name']) > 10): ?>
                                    <p class="error-message"><?php echo $errors['name']; ?></p>
                                <?php endif; ?>
                            <?php endif; ?>
                            <input type="text" class="form-control" placeholder="Username" name="name" value="<?php if(isset($_POST['name'])){echo htmlspecialchars($_POST['name'], ENT_QUOTES);} ?>">
                        </dd>
                        <dd>
                            <?php if(isset($_POST['email'])):?>
                                <?php if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)): ?>
                                    <p class="error-message"><?php echo $errors['email']; ?></p>
                                <?php endif; ?>
                            <?php endif; ?>
                            <input type="text" class="form-control" placeholder="Mail" id="email" name="email" value="<?php if(isset($_POST['email'])){echo htmlspecialchars($_POST['email'], ENT_QUOTES);} ?>">
                        </dd>
                        <dt class="text-muted">
                            Birth
                        </dt>
                        <dd>
                            <?php if(isset($_POST['birth'])):?>
                                <?php if(empty($_POST['birth'])): ?>
                                    <p class="error-message"><?php echo $errors['birth']; ?></p>
                                <?php endif; ?>
                            <?php endif; ?>
                            <input type="date" name="birth" placeholder="Birth" class="form-control" value="<?php if(isset($_POST['birth'])){echo htmlspecialchars($_POST['birth'], ENT_QUOTES);} ?>">
                        </dd>
                        <dt class="text-muted">
                            Gender
                        </dt>
                        <dd>
                            <?php if(isset($_POST['gender'])):?>
                                <?php if(empty($_POST['gender'])): ?>
                                    <p class="error-message"><?php echo $errors['gender']; ?></p>
                                <?php endif; ?>
                            <?php endif; ?>
                            <input type="radio" class="form-check-input" name="gender" id="gender" value="male">
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
                            <input type="radio" class="form-check-input" name="gender" id="gender" value="female" checked>
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
                            <input type="radio" class="form-check-input" name="gender" id="gender" value="others" checked>
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
                            <input type="text" class="form-control" placeholder="Hight" id="hight" name="hight" value="<?php if(isset($_POST['hight'])){echo htmlspecialchars($_POST['hight'], ENT_QUOTES);} ?>">
                        </dd>
                        <dd>
                            <?php if(isset($_POST['pass'])):?>
                                <?php if(empty($_POST['pass']) || !preg_match('/\A(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{8,100}+\z/', $_POST['pass'])): ?>
                                    <p class="error-message"><?php echo $errors['pass']; ?></p>
                                <?php endif; ?>
                            <?php endif; ?>
                            <input type="password" class="form-control" placeholder="Password" id="pass" name="pass" value="<?php if(isset($_POST['pass'])){echo htmlspecialchars($_POST['pass'], ENT_QUOTES);} ?>">
                        </dd>
                        <dd>
                            <?php if(isset($_POST['pass_conf'])):?>
                                <?php if(empty($_POST['pass_conf']) || $_POST['pass'] !== $_POST['pass_conf'] ) : ?>
                                    <p class="error-message"><?php echo $errors['pass_conf']; ?></p>
                                <?php endif; ?>
                            <?php endif; ?>
                            <input type="password" class="form-control" placeholder="Password Conf" name="pass_conf" value="<?php if(isset($_POST['pass_conf'])){echo htmlspecialchars($_POST['pass_conf'], ENT_QUOTES);} ?>">
                        </dd>
                    </dl>
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