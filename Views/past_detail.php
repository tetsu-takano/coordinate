<?php
require_once(ROOT_PATH .'Controller/CoordinateController.php');
$Post = new CoordinateController();
$params = $Post->view();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <title>past_detail 投稿詳細</title>
</head>
<body>
<?php require_once("main_header.php")?>
    <main>
        <div class="container mt-3">
            <div class="row">
                <div class="col-6">
                    <div class="card shadow-sm col-6">
                        <div class="card-text">
                            <h3>Past Post Detail</h3>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="container py-2">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="post_edit.php?id=<?php echo $params['posts']['post_id'];?>" class="btn btn-primary btn-lg">Edit Post</a>
                            <a href="post_delete.php?id=<?=$params['posts']['post_id'] ?>" class="btn btn-primary btn-lg" onclick="return confirm('本当に投稿を削除しますか？')">Delete Post</a>
                            <a href="mypage.php" class="btn btn-primary btn-lg">My Page</a>
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
