<?php
session_start();
require_once(ROOT_PATH .'Controller/CoordinateController.php');
$edit = new CoordinateController();
$params = $edit->edit();
// var_dump($params);


if(isset($_SESSION['errors'])){
    $errors = $_SESSION['errors'];
}
if(isset($_SESSION['postData'])){
    $postData = $_SESSION['postData'];
}
if(isset($_SESSION['itemData'])){
    $itemData = $_SESSION['itemData'];
}


$errors = [];

// $user_id = $_POST['user_id'];


if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST)){
        //タイトルバリデーション（空チェック）
        if(!$title= filter_input(INPUT_POST , 'title')){
            $errors['title'] = "*タイトルを入力してください。";
        }


        //スタイルバリデーション（空チェック）
        if(!$style_id = filter_input(INPUT_POST , 'style_id')){
            $errors['style_id'] = "*スタイルを選択してください。";
        }


        //コンテンツバリデーション（空チェック）
        if(!$contents = filter_input(INPUT_POST , 'contents')){
            $errors['contents'] = "*コーデの内容をご入力下さい。";
        }
        

        //カテゴリバリデーション（空チェック）
        if(!$category1 = filter_input(INPUT_POST , 'category1')){
            if(filter_input(INPUT_POST , 'brand1') || filter_input(INPUT_POST , 'price1') || filter_input(INPUT_POST , 'size1')){
            $errors['category1'] = "*カテゴリー選択してください。";
            }
        }
        if(!$category2 = filter_input(INPUT_POST , 'category2')){
            if(filter_input(INPUT_POST , 'brand2')|| filter_input(INPUT_POST , 'price2') || filter_input(INPUT_POST , 'size2')){
            $errors['category2'] = "*カテゴリー選択してください。";
            }
        }
        if(!$category3 = filter_input(INPUT_POST , 'category3')){
            if(filter_input(INPUT_POST , 'brand3') || filter_input(INPUT_POST , 'price3') || filter_input(INPUT_POST , 'size3')){
            $errors['category3'] = "*カテゴリー選択してください。";
            }
        }
        if(!$category4 = filter_input(INPUT_POST , 'category4')){
            if(filter_input(INPUT_POST , 'brand4') || filter_input(INPUT_POST , 'price4') || filter_input(INPUT_POST , 'size4')){
            $errors['category4'] = "*カテゴリー選択してください。";
            }
        }



        //ブランド１・価格１・サイズ１ バリデーション（カテゴリーが選ばれていたら、空チェックと半角数字のみ）
        if($category1 = filter_input(INPUT_POST , 'category1')){
            if(!$brand1 = filter_input(INPUT_POST , 'brand1')){
                $errors['brand1'] = '*ブランドを入力して下さい。';
            }
            if(!preg_match("/[0-9]+$/", filter_input(INPUT_POST , 'price1'))) {
                $errors['price1'] = "*価格は半角数字でご入力ください。";
            }
            if(!$price1 = filter_input(INPUT_POST , 'price1')){
                $errors['price1'] = '*価格を入力して下さい。';
            }
            if(!preg_match("/^[a-zA-Z0-9]+$/", filter_input(INPUT_POST , 'size1'))) {
                $errors['size1'] = "*サイズは半角アルファベットでご入力ください。";
            }
            if(!$size1 = filter_input(INPUT_POST , 'size1')){
                $errors['size1'] = '*サイズを入力して下さい。';
            }

        }

        //ブランド２・価格２・サイズ２ バリデーション（カテゴリーが選ばれていたら、空チェックと半角数字のみ）
        if($category2 = filter_input(INPUT_POST , 'category2')){
            if(!$brand2 = filter_input(INPUT_POST , 'brand2')){
                $errors['brand2'] = '*ブランドを入力して下さい。';
            }
            if(!preg_match("/[0-9]+$/", filter_input(INPUT_POST , 'price2'))) {
                $errors['price2'] = "*価格は半角数字でご入力ください。";
            }
            if(!$price2 = filter_input(INPUT_POST , 'price2')){
                $errors['price2'] = '*価格を入力して下さい。';
            }
            if(!preg_match("/^[a-zA-Z0-9]+$/", filter_input(INPUT_POST , 'size2'))) {
                $errors['size2'] = "*サイズは半角アルファベットでご入力ください。";
            }
            if(!$size2 = filter_input(INPUT_POST , 'size2')){
                $errors['size2'] = '*サイズを入力して下さい。';
            }
        }

        //ブランド３・価格３・サイズ３ バリデーション（カテゴリーが選ばれていたら、空チェックと半角数字のみ）
        if($category3 = filter_input(INPUT_POST , 'category3')){
            if(!$brand3 = filter_input(INPUT_POST , 'brand3')){
                $errors['brand3'] = '*ブランドを入力して下さい。';
            }
            if(!preg_match("/[0-9]+$/", filter_input(INPUT_POST , 'price3'))) {
                $errors['price3'] = "*価格は半角数字でご入力ください。";
            }
            if(!$price3 = filter_input(INPUT_POST , 'price3')){
                $errors['price3'] = '*価格を入力して下さい。';
            }
            if(!preg_match("/^[a-zA-Z0-9]+$/", filter_input(INPUT_POST , 'size3'))) {
                $errors['size3'] = "*サイズは半角アルファベットでご入力ください。";
            }
            if(!$size3 = filter_input(INPUT_POST , 'size3')){
                $errors['size3'] = '*サイズを入力して下さい。';
            }
        }

        //ブランド４・価格４・サイズ４ バリデーション（カテゴリーが選ばれていたら、空チェックと半角数字のみ）
        if($category4 = filter_input(INPUT_POST , 'category4')){
            if(!$brand4 = filter_input(INPUT_POST , 'brand4')){
                $errors['brand4'] = '*ブランドを入力して下さい。';
            }
            if(!preg_match("/[0-9]+$/", filter_input(INPUT_POST , 'price4'))) {
                $errors['price4'] = "*価格は半角数字でご入力ください。";
            }
            if(!$price4 = filter_input(INPUT_POST , 'price4')){
                $errors['price4'] = '*価格を入力して下さい。';
            }
            if(!preg_match("/^[a-zA-Z0-9]+$/", filter_input(INPUT_POST , 'size4'))) {
                $errors['size4'] = "*サイズは半角アルファベットでご入力ください。";
            }
            if(!$size4 =  filter_input(INPUT_POST , 'size4')){
                $errors['size4'] = '*サイズを入力して下さい。';
            }
        }

        //ブランド５・価格５・サイズ５ バリデーション（カテゴリーが選ばれていたら、空チェックと半角数字のみ）
        if($category5 = filter_input(INPUT_POST , 'category5')){
            if(!$brand5 = filter_input(INPUT_POST , 'brand5')){
                $errors['brand5'] = '*ブランドを入力して下さい。';
            }
            if(!preg_match("/[0-9]+$/", filter_input(INPUT_POST , 'price5'))) {
                $errors['price5'] = "*価格は半角数字でご入力ください。";
            }
            if(!$price5 = filter_input(INPUT_POST , 'price5')){
                $errors['price5'] = '*価格を入力して下さい。';
            }
            if(!preg_match("/^[a-zA-Z0-9]+$/", filter_input(INPUT_POST , 'size5'))) {
                $errors['size5'] = "*サイズは半角アルファベットでご入力ください。";
            }
            if(!$size5 =  filter_input(INPUT_POST , 'size5')){
                $errors['size5'] = '*サイズを入力して下さい。';
            }
        }

        //ファイル関連の取得
        $file = $_FILES['img'];
        $filename = basename($file['name']);
        $tmp_path = $file['tmp_name'];
        $file_err = $file['error'];
        $filesize = $file['size'];
        
        $upload_dir = 'img/';
        $save_filename = date('YmdHis') . $filename;

        $save_path = $upload_dir . $save_filename;

        //写真(拡張は画像形式か、ファイルはあるか)
        //画像形式チェック
        // $allow_ext = array('jpg', 'jpeg', 'png');
        // $file_ext = pathinfo($filename, PATHINFO_EXTENSION);


        // if(!in_array(strtolower($file_ext), $allow_ext)) {
        //     $errors['img'] = '画像ファイルを添付してください。';
        // }
    }


    // エラーがなければ更新完了画面に移動
    if (count($errors) === 0) {
        if(is_uploaded_file($tmp_path)) {
            if(move_uploaded_file($tmp_path, $upload_dir.$save_filename)) {
                echo $filename . 'を'. $upload_dir. 'アップしました。';
                echo $save_filename;
            }else {
                echo 'ファイルを保存できませんでした。';
            }
        }else {
            echo 'ファイルが選択されていません。';
            echo '</br>';
        }

        $_SESSION['postImage'] = $file;

        $post_id = $_POST['post_id'];
        $title = $_POST['title'];
        $style_id  = $_POST['style_id'];
        $contents  = $_POST['contents'];
        $user_id  = $_POST['user_id'];

        $postData = [
            'post_id' => $post_id,
            'title' => $title,
            'style_id' => $style_id,
            'contents' => $contents,
            'user_id' => $user_id,
        ];

        $_SESSION['postData'] = $postData;

        $user_id  = $_POST['user_id'];
        $post_id  = $_POST['post_id'];
        $items_id1 = $_POST['items_id1'];
        $items_id2 = $_POST['items_id2'];
        $items_id3 = $_POST['items_id3'];
        $items_id4 = $_POST['items_id4'];
        $items_id5 = $_POST['items_id5'];
        $category_id1 = $_POST['category1'];
        $category_id2 = $_POST['category2'];
        $category_id3 = $_POST['category3'];
        $category_id4 = $_POST['category4'];
        $category_id5 = $_POST['category5'];
        $brand1 = $_POST['brand1'];
        $brand2 = $_POST['brand2'];
        $brand3 = $_POST['brand3'];
        $brand4 = $_POST['brand4'];
        $brand5 = $_POST['brand5'];
        $item_name1 = $_POST['item_name1'];
        $item_name2 = $_POST['item_name2'];
        $item_name3 = $_POST['item_name3'];
        $item_name4 = $_POST['item_name4'];
        $item_name5 = $_POST['item_name5'];
        $price1 = $_POST['price1'];
        $price2 = $_POST['price2'];
        $price3 = $_POST['price3'];
        $price4 = $_POST['price4'];
        $price5 = $_POST['price5'];
        $size1 = $_POST['size1'];
        $size2 = $_POST['size2'];
        $size3 = $_POST['size3'];
        $size4 = $_POST['size4'];
        $size5 = $_POST['size5'];

        $itemData = [
            'user_id' => $user_id,
            'post_id' => $post_id,
            'items_id1' => $items_id1,
            'items_id2' => $items_id2,
            'items_id3' => $items_id3,
            'items_id4' => $items_id4,
            'items_id5' => $items_id5,
            'category1' => $category1,
            'category2' => $category2,
            'category3' => $category3,
            'category4' => $category4,
            'category5' => $category5,
            'brand1' => $brand1,
            'brand2' => $brand2,
            'brand3' => $brand3,
            'brand4' => $brand4,
            'brand5' => $brand5,
            'item_name1' => $item_name1,
            'item_name2' => $item_name2,
            'item_name3' => $item_name3,
            'item_name4' => $item_name4,
            'item_name5' => $item_name5,
            'price1' => $price1,
            'price2' => $price2,
            'price3' => $price3,
            'price4' => $price4,
            'price5' => $price5,
            'size1' => $size1,
            'size2' => $size2,
            'size3' => $size3,
            'size4' => $size4,
            'size5' => $size5,
        ];
        $_SESSION['itemData'] = $itemData;

        header('Location: post_update.php');
        exit();
    }
}

$style_list = [
    "" => "スタイルを選択してください。",
    "カジュアル" => "カジュアル",
    "綺麗め" => "綺麗め",
    "ストリート" => "ストリート",
    "モード" => "モード",
    "ミリタリー" => "ミリタリー",
    "アメカジ" => "アメカジ",

];

$category_list = [
    "" => "カテゴリーを選択してください。",
    "1" => "outer",
    "2" => "tops",
    "3" => "pants",
    "4" => "shoos",
    "5" => "accsse"
];


$_SESSION['errors'] = '';
$_SESSION['postData'] = '';
$_SESSION['itemData'] = '';
$_SESSION['postImage'] = '';


// var_dump($_POST);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <title>new_post</title>
</head>
<body>
    <?php require_once("main_header.php")?>
    <div class="main">
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="user_id" id="user_id" value="<?php echo $login_user['id'] ?>">
            <input type="hidden" name="post_id" id="post_id" value="<?php echo $params['edit']['post_id'] ?>">
            <input type="hidden" name="items_id" id="items_id" value="<?php echo $params['edit_items'][0]['items_id'] ?>">
            <div class="container mt-3 py-2 pb-5">
                <div class="row">
                    <div class="col-6">
                        <div class="card shadow-sm col-6">
                            <div class="card-text">
                                <h3>Edit Post</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="container py-2">
                            <div class="d-grid d-md-flex justify-content-end">
                                <button type='submit' class="btn btn-primary btn-lg">Update Post</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php if (isset($errors['title'])): ?>
                        <p class="text-danger"><?php echo $errors['title']; ?></p>
                    <?php endif; ?>
                    <div class="col-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-default">Title</span>
                            <input type="text" name="title" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="<?php if(isset($_POST['title'])){echo htmlspecialchars($_POST['title'],ENT_QUOTES);}elseif(isset($params['edit']['title'])) echo htmlspecialchars($params['edit']['title'],ENT_QUOTES) ?>">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex">
                            <div class="col-4">
                            <select name="style_id" class="form-select">
                                <?php foreach($style_list as $key => $value){
                                    if(isset($_POST['style_id'])){
                                        if($_POST['style_id']  == $key){
                                            echo "<option value='$key' selected>$value</option>";
                                        }else{
                                            echo "<option value='$key'>$value</option>";
                                        }
                                    }elseif($key == $params['edit']['style_id']){
                                        echo "<option value='$key' selected>$value</option>";
                                    }else{
                                        echo "<option value='$key'>$value</option>";
                                    }
                                } ?>
                            </select>
                            </div>
                            <?php if (isset($errors['style_id'])): ?>
                                <p class="text-danger"><?php echo $errors['style_id']; ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <?php if (isset($errors['img'])): ?>
                            <p class="text-danger"><?php echo $errors['img']; ?></p>
                        <?php endif; ?>
                        <div class="card width-100">
                            <img class="card-img-top" style="height: 500px; width: 100%; display: block;" src="<?php if(isset($params['edit']['file_path'])) echo htmlspecialchars($params['edit']['file_path'],ENT_QUOTES) ;?>">
                            <input type="file" name="img" accept="image/*" value="<?php if(isset($_POST['file_path'])){echo htmlspecialchars($_POST['file_path'],ENT_QUOTES);} elseif(isset($params['edit']['file_path'])) echo htmlspecialchars($params['edit']['file_path'],ENT_QUOTES) ;?>">
                        </div>
                        <?php if (isset($errors['contents'])): ?>
                            <p class="text-danger pt-4"><?php echo $errors['contents']; ?></p>
                        <?php endif; ?>
                        <div class="coordinateContents mx-auto my-auto">
                            <label for="body" class="form-label">Coordinate Contents</label>
                            <textarea class="form-control" id="body" rows="20" name="contents"><?php if(isset($_POST['contents'])){echo nl2br(htmlspecialchars($_POST['contents'],ENT_QUOTES));}elseif(isset($params['edit']['contents'])) echo htmlspecialchars($params['edit']['contents'],ENT_QUOTES) ?></textarea>
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="body" class="form-label">
                            Item Detail
                        </label>
                            <?php if (isset($errors['category1'])): ?>
                                <p class="text-danger"><?php echo $errors['category1'];?></p>
                            <?php endif; ?>
                            <?php if (isset($errors['brand1'])): ?>
                                <p class="text-danger"><?php echo $errors['brand1'];?></p>
                            <?php endif; ?>
                            <?php if (isset($errors['price1'])): ?>
                                <p class="text-danger"><?php echo $errors['price1'];?></p>
                            <?php endif; ?>
                            <?php if (isset($errors['size1'])): ?>
                                <p class="text-danger"><?php echo $errors['size1'];?></p>
                            <?php endif; ?>
                            <select name="category1" class="form-select">
                                <?php foreach($category_list as $key => $value){
                                    if(isset($_POST['category1'])){
                                        if($_POST['category1']  == $key){
                                            echo "<option value='$key' selected>$value</option>";
                                        }else{
                                            echo "<option value='$key'>$value</option>";
                                        }
                                    }elseif($key == $params['edit_items'][0]['category_id']){
                                        echo "<option value='$key' selected>$value</option>";
                                    }else{
                                        echo "<option value='$key'>$value</option>";
                                    }
                                } ?>
                            </select>
                            <input type="hidden" name="items_id1" value="<?php if(isset($_POST['items_id1'])){echo htmlspecialchars($_POST['items_id1'],ENT_QUOTES);} elseif(isset($params['edit_items'][0]['items_id'])) echo htmlspecialchars($params['edit_items'][0]['items_id']) ?>">
                            <input type="text" class="form-control" placeholder="brand" aria-label="Sizing example input" name="brand1" aria-describedby="inputGroup-sizing-default" value="<?php if(isset($_POST['brand1'])){echo htmlspecialchars($_POST['brand1'],ENT_QUOTES);} elseif(isset($params['edit_items'][0]['brand'])) echo htmlspecialchars($params['edit_items'][0]['brand']) ?>">
                            <input type="text" class="form-control" placeholder="item name" aria-label="Sizing example input" name="item_name1" aria-describedby="inputGroup-sizing-default" value="<?php if(isset($_POST['item_name1'])){echo htmlspecialchars($_POST['item_name1'],ENT_QUOTES);} elseif(isset($params['edit_items'][0]['item_name'])) echo htmlspecialchars($params['edit_items'][0]['item_name']) ?>">
                            <input type="text" class="form-control" placeholder="price" aria-label="Sizing example input" name="price1" aria-describedby="inputGroup-sizing-default" value="<?php if(isset($_POST['price1'])){echo htmlspecialchars($_POST['price1'],ENT_QUOTES);} elseif(isset($params['edit_items'][0]['price'])) echo htmlspecialchars($params['edit_items'][0]['price']) ?>">
                            <input type="text" class="form-control" placeholder="size" aria-label="Sizing example input" name="size1" aria-describedby="inputGroup-sizing-default" value="<?php if(isset($_POST['size1'])){echo htmlspecialchars($_POST['size1'],ENT_QUOTES);} elseif(isset($params['edit_items'][0]['size'])) echo htmlspecialchars($params['edit_items'][0]['size']) ?>">
                        <label for="body" class="form-label">
                            Item Detail
                        </label>
                            <?php if (isset($errors['category2'])): ?>
                                <p class="text-danger"><?php echo $errors['category2'];?></p>
                            <?php endif; ?>
                            <?php if (isset($errors['brand2'])): ?>
                                <p class="text-danger"><?php echo $errors['brand2'];?></p>
                            <?php endif; ?>
                            <?php if (isset($errors['price2'])): ?>
                                <p class="text-danger"><?php echo $errors['price2'];?></p>
                            <?php endif; ?>
                            <?php if (isset($errors['size2'])): ?>
                                <p class="text-danger"><?php echo $errors['size2'];?></p>
                            <?php endif; ?>
                            <select name="category2" class="form-select">
                                <?php foreach($category_list as $key => $value){
                                    if(isset($_POST['category2'])){
                                        if($_POST['category2']  == $key){
                                            echo "<option value='$key' selected>$value</option>";
                                        }else{
                                            echo "<option value='$key'>$value</option>";
                                        }
                                    }elseif($key == $params['edit_items'][1]['category_id']){
                                        echo "<option value='$key' selected>$value</option>";
                                    }else{
                                        echo "<option value='$key'>$value</option>";
                                    }
                                } ?>
                            </select>
                            <input type="hidden" name="items_id2" value="<?php if(isset($_POST['items_id2'])){echo htmlspecialchars($_POST['items_id2'],ENT_QUOTES);} elseif(isset($params['edit_items'][1]['items_id'])) echo htmlspecialchars($params['edit_items'][1]['items_id']) ?>">
                            <input type="text" class="form-control" placeholder="brand" aria-label="Sizing example input" name="brand2" aria-describedby="inputGroup-sizing-default" value="<?php if(isset($_POST['brand2'])){echo htmlspecialchars($_POST['brand2'],ENT_QUOTES);} elseif(isset($params['edit_items'][1]['brand'])) echo htmlspecialchars($params['edit_items'][1]['brand']) ?>">
                            <input type="text" class="form-control" placeholder="item name" aria-label="Sizing example input" name="item_name2" aria-describedby="inputGroup-sizing-default" value="<?php if(isset($_POST['item_name2'])){echo htmlspecialchars($_POST['item_name2'],ENT_QUOTES);} elseif(isset($params['edit_items'][1]['item_name'])) echo htmlspecialchars($params['edit_items'][1]['item_name']) ?>">
                            <input type="text" class="form-control" placeholder="price" aria-label="Sizing example input" name="price2" aria-describedby="inputGroup-sizing-default" value="<?php if(isset($_POST['price2'])){echo htmlspecialchars($_POST['price2'],ENT_QUOTES);} elseif(isset($params['edit_items'][1]['price'])) echo htmlspecialchars($params['edit_items'][1]['price']) ?>">
                            <input type="text" class="form-control" placeholder="size" aria-label="Sizing example input" name="size2" aria-describedby="inputGroup-sizing-default" value="<?php if(isset($_POST['size2'])){echo htmlspecialchars($_POST['size2'],ENT_QUOTES);} elseif(isset($params['edit_items'][1]['size'])) echo htmlspecialchars($params['edit_items'][1]['size']) ?>">
                        <label for="body" class="form-label">
                            Item Detail
                        </label>
                            <?php if (isset($errors['category3'])): ?>
                                <p class="text-danger"><?php echo $errors['category3'];?></p>
                            <?php endif; ?>
                            <?php if (isset($errors['brand3'])): ?>
                                <p class="text-danger"><?php echo $errors['brand3'];?></p>
                            <?php endif; ?>
                            <?php if (isset($errors['price3'])): ?>
                                <p class="text-danger"><?php echo $errors['price3'];?></p>
                            <?php endif; ?>
                            <?php if (isset($errors['size3'])): ?>
                                <p class="text-danger"><?php echo $errors['size3'];?></p>
                            <?php endif; ?>
                            <select name="category3" class="form-select">
                                <?php foreach($category_list as $key => $value){
                                    if(isset($_POST['category3'])){
                                        if($_POST['category3']  == $key){
                                            echo "<option value='$key' selected>$value</option>";
                                        }else{
                                            echo "<option value='$key'>$value</option>";
                                        }
                                    }elseif($key == $params['edit_items'][2]['category_id']){
                                        echo "<option value='$key' selected>$value</option>";
                                    }else{
                                        echo "<option value='$key'>$value</option>";
                                    }
                                } ?>
                            </select>
                            <input type="hidden" name="items_id3" value="<?php if(isset($_POST['items_id3'])){echo htmlspecialchars($_POST['items_id3'],ENT_QUOTES);} elseif(isset($params['edit_items'][2]['items_id'])) echo htmlspecialchars($params['edit_items'][2]['items_id']) ?>">
                            <input type="text" class="form-control" placeholder="brand" aria-label="Sizing example input" name="brand3" aria-describedby="inputGroup-sizing-default" value="<?php if(isset($_POST['brand3'])){echo htmlspecialchars($_POST['brand3'],ENT_QUOTES);} elseif(isset($params['edit_items'][2]['brand'])) echo htmlspecialchars($params['edit_items'][2]['brand']) ?>">
                            <input type="text" class="form-control" placeholder="item name" aria-label="Sizing example input" name="item_name3" aria-describedby="inputGroup-sizing-default" value="<?php if(isset($_POST['item_name3'])){echo htmlspecialchars($_POST['item_name3'],ENT_QUOTES);} elseif(isset($params['edit_items'][2]['item_name'])) echo htmlspecialchars($params['edit_items'][2]['item_name']) ?>">
                            <input type="text" class="form-control" placeholder="price" aria-label="Sizing example input" name="price3" aria-describedby="inputGroup-sizing-default" value="<?php if(isset($_POST['price3'])){echo htmlspecialchars($_POST['price3'],ENT_QUOTES);} elseif(isset($params['edit_items'][2]['price'])) echo htmlspecialchars($params['edit_items'][2]['price']) ?>">
                            <input type="text" class="form-control" placeholder="size" aria-label="Sizing example input" name="size3" aria-describedby="inputGroup-sizing-default" value="<?php if(isset($_POST['size3'])){echo htmlspecialchars($_POST['size3'],ENT_QUOTES);} elseif(isset($params['edit_items'][2]['size'])) echo htmlspecialchars($params['edit_items'][2]['size']) ?>">
                        <label for="body" class="form-label">
                            Item Detail
                        </label>
                            <?php if (isset($errors['category4'])): ?>
                                <p class="text-danger"><?php echo $errors['category4'];?></p>
                            <?php endif; ?>
                            <?php if (isset($errors['brand4'])): ?>
                                <p class="text-danger"><?php echo $errors['brand4'];?></p>
                            <?php endif; ?>
                            <?php if (isset($errors['price4'])): ?>
                                <p class="text-danger"><?php echo $errors['price4'];?></p>
                            <?php endif; ?>
                            <?php if (isset($errors['size4'])): ?>
                                <p class="text-danger"><?php echo $errors['size4'];?></p>
                            <?php endif; ?>
                            <select name="category4" class="form-select">
                                <?php foreach($category_list as $key => $value){
                                    if(isset($_POST['category4'])){
                                        if($_POST['category4']  == $key){
                                            echo "<option value='$key' selected>$value</option>";
                                        }else{
                                            echo "<option value='$key'>$value</option>";
                                        }
                                    }elseif($key == $params['edit_items'][3]['category_id']){
                                        echo "<option value='$key' selected>$value</option>";
                                    }else{
                                        echo "<option value='$key'>$value</option>";
                                    }
                                } ?>
                            </select>
                            <input type="hidden" name="items_id4" value="<?php if(isset($_POST['items_id4'])){echo htmlspecialchars($_POST['items_id4'],ENT_QUOTES);} elseif(isset($params['edit_items'][3]['items_id'])) echo htmlspecialchars($params['edit_items'][3]['items_id']) ?>">
                            <input type="text" class="form-control" placeholder="brand" aria-label="Sizing example input" name="brand4" aria-describedby="inputGroup-sizing-default" value="<?php if(isset($_POST['brand4'])){echo htmlspecialchars($_POST['brand4'],ENT_QUOTES);} elseif(isset($params['edit_items'][3]['brand'])) echo htmlspecialchars($params['edit_items'][2]['brand']) ?>">
                            <input type="text" class="form-control" placeholder="item name" aria-label="Sizing example input" name="item_name4" aria-describedby="inputGroup-sizing-default" value="<?php if(isset($_POST['item_name4'])){echo htmlspecialchars($_POST['item_name4'],ENT_QUOTES);} elseif(isset($params['edit_items'][3]['item_name'])) echo htmlspecialchars($params['edit_items'][2]['item_name']) ?>">
                            <input type="text" class="form-control" placeholder="price" aria-label="Sizing example input" name="price4" aria-describedby="inputGroup-sizing-default" value="<?php if(isset($_POST['price4'])){echo htmlspecialchars($_POST['price4'],ENT_QUOTES);} elseif(isset($params['edit_items'][3]['price'])) echo htmlspecialchars($params['edit_items'][2]['price']) ?>">
                            <input type="text" class="form-control" placeholder="size" aria-label="Sizing example input" name="size4" aria-describedby="inputGroup-sizing-default" value="<?php if(isset($_POST['size4'])){echo htmlspecialchars($_POST['size4'],ENT_QUOTES);} elseif(isset($params['edit_items'][3]['size'])) echo htmlspecialchars($params['edit_items'][2]['size']) ?>">
                        <label for="body" class="form-label">
                            Item Detail
                        </label>
                            <?php if (isset($errors['category5'])): ?>
                                <p class="text-danger"><?php echo $errors['category5'];?></p>
                            <?php endif; ?>
                            <?php if (isset($errors['brand5'])): ?>
                                <p class="text-danger"><?php echo $errors['brand5'];?></p>
                            <?php endif; ?>
                            <?php if (isset($errors['price5'])): ?>
                                <p class="text-danger"><?php echo $errors['price5'];?></p>
                            <?php endif; ?>
                            <?php if (isset($errors['size5'])): ?>
                                <p class="text-danger"><?php echo $errors['size5'];?></p>
                            <?php endif; ?>
                            <select name="category5" class="form-select">
                                <?php foreach($category_list as $key => $value){
                                    if(isset($_POST['category5'])){
                                        if($_POST['category5']  == $key){
                                            echo "<option value='$key' selected>$value</option>";
                                        }else{
                                            echo "<option value='$key'>$value</option>";
                                        }
                                    }elseif($key == $params['edit_items'][4]['category_id']){
                                        echo "<option value='$key' selected>$value</option>";
                                    }else{
                                        echo "<option value='$key'>$value</option>";
                                    }
                                } ?>
                            </select>
                            <input type="hidden" name="items_id5" value="<?php if(isset($_POST['items_id5'])){echo htmlspecialchars($_POST['items_id5'],ENT_QUOTES);} elseif(isset($params['edit_items'][4]['items_id'])) echo htmlspecialchars($params['edit_items'][4]['items_id']) ?>">
                            <input type="text" class="form-control" placeholder="brand" aria-label="Sizing example input" name="brand5" aria-describedby="inputGroup-sizing-default" value="<?php if(isset($_POST['brand5'])){echo htmlspecialchars($_POST['brand5'],ENT_QUOTES);} elseif(isset($params['edit_items'][4]['brand'])) echo htmlspecialchars($params['edit_items'][4]['brand']) ?>">
                            <input type="text" class="form-control" placeholder="item name" aria-label="Sizing example input" name="item_name5" aria-describedby="inputGroup-sizing-default" value="<?php if(isset($_POST['item_name5'])){echo htmlspecialchars($_POST['item_name5'],ENT_QUOTES);} elseif(isset($params['edit_items'][4]['item_name'])) echo htmlspecialchars($params['edit_items'][4]['item_name']) ?>">
                            <input type="text" class="form-control" placeholder="price" aria-label="Sizing example input" name="price5" aria-describedby="inputGroup-sizing-default" value="<?php if(isset($_POST['price5'])){echo htmlspecialchars($_POST['price5'],ENT_QUOTES);} elseif(isset($params['edit_items'][4]['price'])) echo htmlspecialchars($params['edit_items'][4]['price']) ?>">
                            <input type="text" class="form-control" placeholder="size" aria-label="Sizing example input" name="size5" aria-describedby="inputGroup-sizing-default" value="<?php if(isset($_POST['size5'])){echo htmlspecialchars($_POST['size5'],ENT_QUOTES);} elseif(isset($params['edit_items'][4]['size'])) echo htmlspecialchars($params['edit_items'][4]['size']) ?>">
                    </div>
                </div>
            </div>
        </form>
        <div class="d-grid d-md-flex justify-content-end">
            <a href="mypage.php" class="btn btn-primary btn-lg">My Page</a>
        </div>
    </div>
</body>
</html>
