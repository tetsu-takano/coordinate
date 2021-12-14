<?php
session_start();
require_once(ROOT_PATH .'Controller/CoordinateController.php');
require_once(ROOT_PATH .'Models/Users.php');
$Style = new CoordinateController;
$params = $Style->style();

//ユーザーIDと投稿IDを元にいいね値の重複チェックを行う
require_once(ROOT_PATH .'/database.php');
require_once(ROOT_PATH .'/Models/Db.php');

$user_id = $_SESSION['login_user']['id'];
foreach($params['style'] as $post_id){
}

$errors = $_SESSION;

// foreach($params['style'][0] as $post_id){
// }
$post_id = $post_id['post_id'];


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/like.css">
    <title>メインページ</title>
</head>
<body>
    <?php require_once("main_header.php")?>
    <main role="main mt-10">
        <section class="jumbotron text-center pt-5">
            <div class="container">
                <h1 class="jumbotron-heading">Coordination List</h1>
                <form method="POST" action="main_style.php">
                    <p>
                        <select id="style_id" name="style_id">
                            <option selected disabled>スタイルを選択して下さい。</option>
                            <option>カジュアル</option>
                            <option>綺麗め</option>
                            <option>ストリート</option>
                            <option>モード</option>
                            <option>ミリタリー</option>
                            <option>アメカジ</option>
                        </select>
                    </p>
                    <input type="submit" value="検索">
                </form>
            </div>
        </section>
        <div class="album py-5 bg-light">
            <div class="container">
                <div class="row">
                    <?php foreach($params['style'] as $style): ?>
                    <div class="col-md-4">
                        <form class="favorite_count" action="" method="post">
                        <div class="card mb-4 shadow-sm">
                            <img class="card-img-top" style="height: 500px; width: 100%; display: block;" src="<?=$style['file_path']?>" data-holder-rendered="true">
                            <div class="card-body">
                                <strong class="card-title">コーデタイトル:<?php echo $style['title'];?></strong>
                                <p class="card-subtitle text-muted my-2">ユーザー名:<?=$style['name']?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                        <input type="hidden" name="post_id" value="<?= $post_id ?>">
                                        <button type="button" class="btn btn-sm btn-outline-secondary"><a class="btn-outline-secondary" href="post_detail.php?id=<?=$style['post_id'] ?>">詳細を見る</a></button>
                                        <section class="post" data-postid="<?php echo $post_id; ?>">
                                            <div class="like_btn <?php if (!$Style->like($user_id,$post_id)) echo 'active';?>">
                                            <!-- 自分がいいねした投稿にはハートのスタイルを常に保持する -->
                                            <i class="fa-heart fa-lg px-16
                                            <?php
                                            if($Style->like($user_id,$post_id)){ //いいね押したらハートが塗りつぶされる
                                                echo ' active fas';
                                            }else{ //いいねを取り消したらハートのスタイルが取り消される
                                                echo ' far';
                                            }; ?>"></i>
                                            <p>いいね！</p>
                                            </div>
                                        </section>
                                    </div>
                                    <small class="text-muted">投稿日時:<?=$style['created_id']?></small>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                    <?php endforeach ;?>
                </div>
            </div>
        </div>
    </main>
    <script>
        var user_id = <?php echo $user_id; ?>;
        var post_id = <?php echo $post_id; ?>;

        $(document).on('click','.like_btn',function(e){
            e.preventDefault();
            var $this = $(this);

            $.ajax({
                type: 'POST',
                url: 'ajax_like.php',
                dataType: 'text',
                data: { user_id: user_id,
                        post_id: post_id}
            }).done(function(data){
                console.log(data);
                $this.children('i').toggleClass('far'); //空洞ハート
                // いいね押した時のスタイル
                $this.children('i').toggleClass('fas'); //塗りつぶしハート
                $this.children('i').toggleClass('active');
                $this.toggleClass('active');
                //window.alert(user_id);
            }).fail(function() {
                console.log('だめです');
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>