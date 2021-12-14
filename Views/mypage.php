<?php
session_start();
require_once(ROOT_PATH .'Models/Users.php');
require_once(ROOT_PATH .'Controller/CoordinateController.php');
$my_post = new CoordinateController;
$params = $my_post->myPost();

$login_user = $_SESSION['login_user'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <title>メインページ</title>
</head>
<body>
    <?php require_once("main_header.php")?>
    <main role="main mt-10">
        <div class="page-text pt-3 bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-2">
                        <div class="card mt-3 shadow-sm">
                            <div class="card-text">
                                <h3>My Page</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="btn-transition py-2 bg-light">
            <div class="container py-2 bg-light">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="new_post.php?id=<?=$login_user['id'] ?>" class="btn btn-primary btn-lg">New Post</a>
                    <a href="prof_edit.php?id=<?=$login_user['id'] ?>" class="btn btn-primary btn-lg">Edit Profile</a>
                </div>
            </div>
        </div>
        <div class="album py-2 bg-light">
            <div class="container">
                <div class="row">
                    <?php foreach($params['u_posts'] as $u_post): ?>
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                                <img class="card-img-top" style="height: 500px; width: 100%; display: block;" src="<?php echo $u_post['file_path'] ;?>" data-holder-rendered="true">
                                <strong class="card-title">コーデタイトル:</strong>
                                <dd><?php echo $u_post['title'] ?></dd>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary"><a class="btn-outline-secondary" href="past_detail.php?id=<?php echo $u_post['post_id'];?>">詳細を見る</a></button>
                                        <small class="text-muted">投稿日時:<?=$u_post['created_id']?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach;?>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <li class="page-item">
                            <?php
                                for($i=0; $i<$params['pages']; $i++) {
                                    if(isset($_GET['page']) && $_GET['page'] == $i) {
                                        echo $i+1;
                                    } else {
                                        echo "<a href='?page=".$i."'>".($i+1)."</a>";
                                    }
                                }
                                ?>
                            </li>
                        </ul>
                    </nav>
                    <div class="btn-back">
                        <div class="container">
                            <div class="row">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="main.php" class="btn btn-primary btn-lg" >To Top</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>