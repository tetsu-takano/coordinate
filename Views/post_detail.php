<?php
require_once(ROOT_PATH .'Controller/CoordinateController.php');
$Post = new CoordinateController();
$params = $Post->view();

//ユーザーIDと投稿IDを元にいいね値の重複チェックを行う
require_once(ROOT_PATH .'/database.php');
require_once(ROOT_PATH .'/Models/Db.php');

$user_id = $params['posts']['user_id'];
$post_id = $params['posts']['post_id'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/like.css">
    <title>post_detail 投稿詳細</title>
</head>
<body>
<?php require_once("main_header.php")?>
    <main>
        <div class="container mt-3">
            <div class="row">
                <div class="col-6">
                    <div class="card shadow-sm col-6">
                        <div class="card-text">
                            <h3>Posts Detail</h3>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="container py-2">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="main.php" class="btn btn-primary btn-lg">To Top</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-3 py-2 pb-5">
            <div class="row">
                <div class="col-6">
                    <div class="input-group mb-3">
                        <dd class="input-group-text" id="inputGroup-sizing-default">Title</dd>
                        <dd class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"><?=$params['posts']['title']?></dd>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex">
                        <div class="col-4">
                        <label for="body" class="form-label">
                            Style
                        </label>
                            <dd class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"><?=$params['posts']['style_id']?></dd>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="card width-100">
                    <img class="card-img-top" style="height: 500px; width: 100%; display: block;" src="<?php echo $params['posts']['file_path'] ;?>" data-holder-rendered="true">
                    </div>
                    <div class="btn-group d-md-flex justify-content-md-end">
                        <input type="hidden" name="user_id" value="<?= $user_id ?>">
                        <input type="hidden" name="post_id" value="<?= $post_id ?>">
                        <section class="post" data-postid="<?php echo $post_id; ?>">
                            <div class="like_btn <?php if (!$Post->like($user_id,$post_id)) echo 'active';?>">
                            <!-- 自分がいいねした投稿にはハートのスタイルを常に保持する -->
                            <i class="fa-heart fa-lg px-16
                            <?php
                            if($Post->like($user_id,$post_id)){ //いいね押したらハートが塗りつぶされる
                                echo ' active fas';
                            }else{ //いいねを取り消したらハートのスタイルが取り消される
                                echo ' far';
                            }; ?>"></i>
                            <p>いいね！</p>
                            </div>
                        </section>
                    </div>
                    <div class="coordinateContents mx-auto my-auto">
                        <label for="body" class="form-label">Coordinate Contents</label>
                        <dd class="form-control" id="body" rows="8" name="contents"><?=$params['posts']['contents']?></dd>
                    </div>
                </div>
                <div class="col-6">
                <?php foreach($params['items'] as $item): ?>
                    <label for="body" class="form-label">
                        Item Detail
                    </label>
                        <dd class="form-control" aria-label="Sizing example input" name="brand" aria-describedby="inputGroup-sizing-default"><?=$item['category_name']?></dd>
                        <dd class="form-control" aria-label="Sizing example input" name="brand" aria-describedby="inputGroup-sizing-default"><?=$item['brand']?></dd>
                        <dd class="form-control" aria-label="Sizing example input" name="item_name" aria-describedby="inputGroup-sizing-default"><?=$item['item_name']?></dd>
                        <dd class="form-control" aria-label="Sizing example input" name="price" aria-describedby="inputGroup-sizing-default"><?=$item['price']?></dd>
                        <dd class="form-control" aria-label="Sizing example input" name="size" aria-describedby="inputGroup-sizing-default"><?=$item['size']?></dd>
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
