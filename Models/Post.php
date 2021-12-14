<?php
require_once(ROOT_PATH .'/Models/Db.php');

class Post extends Db {
    public function __construct($dbh = null) {
        parent::__construct($dbh);
    }

    /**
     * 全投稿データを参照する
     * @param void
     * @return Array $result 全参照データ
     */
    public function findAll($page) {
        $sql = " SELECT p.post_id, p.title, p.style_id, p.file_path, u.name, p.created_id, p.updated_id FROM post p INNER JOIN users u ON p.user_id = u.id WHERE del_flg = 0 ";
        $sql .= ' LIMIT 6 OFFSET '.(6 * $page);
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        // 結果の取得
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /** 
     * 全投稿のデータ数を取得
     * 
     * @return Int $count 全投稿の件数
    */
    public function countAll() {
        $sql = 'SELECT count(*) as count FROM post';
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $count = $sth->fetchColumn();
        return $count;
    }



    /**
     * postテーブルから指定IDの全データ数を取得
     * @param int $id
     * @return Int $count 全投稿の件数
    */
    public function countAllByUser() {
        $login_user = $_SESSION['login_user'];
        $id = $login_user['id'];

        $sql = ' SELECT COUNT(*) FROM post p INNER JOIN users u ON p.user_id = u.id WHERE u.id = :id ';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $count = $sth->fetchColumn();
        return $count;
    }

    /**
     * エリア別投稿データを参照する
     * @param void
     * @return Array $result 全参照データ
     */
    public function findByStyle($style_id = 0) {
        $sql = " SELECT p.post_id, p.title, p.style_id, p.file_path, u.name, p.created_id, p.updated_id FROM post p INNER JOIN users u ON p.user_id = u.id WHERE p.style_id = style_id AND del_flg = 0 ";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':style_id', $style_id, PDO::PARAM_STR);
        $stmt->execute();
        // 結果の取得
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * ユーザ別投稿データを参照する
     * @param void
     * @return Array $result 全参照データ
     */
    public function findByUser($page) {
        $login_user = $_SESSION['login_user'];
        $id = $login_user['id'];

        $sql = " SELECT * FROM post WHERE user_id = :id AND del_flg = 0 ";
        $sql .= ' LIMIT 3 OFFSET '.(3 * $page);
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        // 結果の取得
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * 投稿詳細を取得する（指定IDのデータ）
     * @param int $id 投稿のID
     * @return Array $result 指定IDの投稿データ
     */
    public function findById($id) {
        $sql = " SELECT * FROM post WHERE post_id = :id AND del_flg = 0 ";
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        // 結果の取得
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function findItems($id) {
        $sql = " SELECT i.items_id, i.user_id, i.post_id, i.brand, i.item_name, i.price, i.size, c.category_id, c.category_name FROM items i INNER JOIN categories c ON c.category_id = i.category_id WHERE post_id = :post_id ";
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':post_id', $id, PDO::PARAM_INT);
        $sth->execute();
        // 結果の取得
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function editItems($id)
    {
        $sql = " SELECT i.items_id, i.user_id, i.post_id, i.brand, i.item_name, i.price, i.size, c.category_id, c.category_name FROM items i INNER JOIN categories c ON c.category_id = i.category_id WHERE post_id = :post_id ";
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':post_id', $id, PDO::PARAM_INT);
        $sth->execute();
        // 結果の取得
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


/**
     * 新規投稿の保存(タイトル、スタイルID、コーデ内容紹介、ファイル名、保存先のパス）
     * @param int $user_id ユーザID
     * @param string $title　タイトル
     * @param int $style_id　スタイルID
     * @param string $contents　コーデ内容紹介
     * @param string $save_filename　ファイル名
     * @param string $save_path　保存先のパス
     * @return bool $result
     */
    public function savePostData() {
        $result = false;

        //ファイル関連の取得
        $file = $_FILES['img'];
        $filename = basename($file['name']);
        $tmp_path = $file['tmp_name'];
        $file_err = $file['error'];
        $filesize = $file['size'];
        
        $upload_dir = 'img/';
        $save_filename = date('YmdHis') . $filename;

        $save_path = $upload_dir . $save_filename;

       
        $postData = $_SESSION['postData'];
        
        $title  = $postData['title'];
        $style_id  = $postData['style_id'];
        $contents  = $postData['contents'];
        $user_id  = $postData['user_id'];

        $sql = " INSERT INTO post (`title`,`style_id`,`contents`,`file_name`,`file_path`,`user_id`,`created_id`, del_flg) VALUES (:title, :style_id, :contents, :file_name, :file_path, :user_id, NOW(), 0) ";
        try{
            $sth = $this->dbh->prepare($sql);
            
            $sth->bindValue(':title',$title,PDO::PARAM_STR);
            $sth->bindValue(':style_id',$style_id,PDO::PARAM_STR);
            $sth->bindValue(':contents',$contents,PDO::PARAM_STR);
            $sth->bindValue(':file_name',$save_filename,PDO::PARAM_STR);
            $sth->bindValue(':file_path',$save_path,PDO::PARAM_STR);
            $sth->bindValue(':user_id',$user_id,PDO::PARAM_INT);
            // // executeで実行
            $result = $sth->execute();


            return $result;
        } catch(\Exception $e) {
            echo $e->getMessage();
            return $result;
        }
    }

    /**
     * 新規投稿の保存(タイトル、スタイルID、コーデ内容紹介、ファイル名、保存先のパス）
     * @param int $user_id ユーザID
     * @param string $category_id　カテゴリー
     * @param string $brand　ブランド
     * @param string $item_name アイテムの名前
     * @param string $price　価格
     * @param string $size　サイズ
     * @return bool $result
     */
    public function savePostItemData($itemData) {
        $result = false;



        $user_id  = $itemData['user_id'];
        $post_id  = $itemData['post_id'];
        $category_id1 = $itemData['category1'];
        $brand1 = $itemData['brand1'];
        $item_name1 = $itemData['item_name1'];
        $price1 = $itemData['price1'];
        $size1 = $itemData['size1'];
        $category_id2 = $itemData['category2'];
        $brand2 = $itemData['brand2'];
        $item_name2 = $itemData['item_name2'];
        $price2 = $itemData['price2'];
        $size2 = $itemData['size2'];
        $category_id3 = $itemData['category3'];
        $brand3 = $itemData['brand3'];
        $item_name3 = $itemData['item_name3'];
        $price3 = $itemData['price3'];
        $size3 = $itemData['size3'];
        $category_id4 = $itemData['category4'];
        $brand4 = $itemData['brand4'];
        $item_name4 = $itemData['item_name4'];
        $price4 = $itemData['price4'];
        $size4 = $itemData['size4'];
        $category_id5 = $itemData['category5'];
        $brand5 = $itemData['brand5'];
        $item_name5 = $itemData['item_name5'];
        $price5 = $itemData['price5'];
        $size5 = $itemData['size5'];



        $sql = " INSERT INTO items(`user_id`,`post_id`,`category_id`,`brand`,`item_name`,`price`,`size`)VALUES(:user_id, (SELECT post_id FROM post ORDER BY post_id DESC LIMIT 1), :category_id1, :brand1, :item_name1, :price1, :size1);
                 INSERT INTO items(`user_id`,`post_id`,`category_id`,`brand`,`item_name`,`price`,`size`)VALUES(:user_id, (SELECT post_id FROM post ORDER BY post_id DESC LIMIT 1), :category_id2, :brand2, :item_name2, :price2, :size2);
                 INSERT INTO items(`user_id`,`post_id`,`category_id`,`brand`,`item_name`,`price`,`size`)VALUES(:user_id, (SELECT post_id FROM post ORDER BY post_id DESC LIMIT 1), :category_id3, :brand3, :item_name3, :price3, :size3);
                 INSERT INTO items(`user_id`,`post_id`,`category_id`,`brand`,`item_name`,`price`,`size`)VALUES(:user_id, (SELECT post_id FROM post ORDER BY post_id DESC LIMIT 1), :category_id4, :brand4, :item_name4, :price4, :size4);
                 INSERT INTO items(`user_id`,`post_id`,`category_id`,`brand`,`item_name`,`price`,`size`)VALUES(:user_id, (SELECT post_id FROM post ORDER BY post_id DESC LIMIT 1), :category_id5, :brand5, :item_name5, :price5, :size5); ";
        try{
            $sth = $this->dbh->prepare($sql);
            $sth->bindValue(':user_id',$user_id,PDO::PARAM_INT);
            $sth->bindValue(':post_id',$post_id,PDO::PARAM_INT);
            $sth->bindValue(':category_id1',$category_id1,PDO::PARAM_INT);
            $sth->bindValue(':category_id2',$category_id2,PDO::PARAM_INT);
            $sth->bindValue(':category_id3',$category_id3,PDO::PARAM_INT);
            $sth->bindValue(':category_id4',$category_id4,PDO::PARAM_INT);
            $sth->bindValue(':category_id5',$category_id5,PDO::PARAM_INT);
            $sth->bindValue(':brand1',$brand1,PDO::PARAM_STR);
            $sth->bindValue(':brand2',$brand2,PDO::PARAM_STR);
            $sth->bindValue(':brand3',$brand3,PDO::PARAM_STR);
            $sth->bindValue(':brand4',$brand4,PDO::PARAM_STR);
            $sth->bindValue(':brand5',$brand5,PDO::PARAM_STR);
            $sth->bindValue(':item_name1',$item_name1,PDO::PARAM_STR);
            $sth->bindValue(':item_name2',$item_name2,PDO::PARAM_STR);
            $sth->bindValue(':item_name3',$item_name3,PDO::PARAM_STR);
            $sth->bindValue(':item_name4',$item_name4,PDO::PARAM_STR);
            $sth->bindValue(':item_name5',$item_name5,PDO::PARAM_STR);
            $sth->bindValue(':price1',$price1,PDO::PARAM_STR);
            $sth->bindValue(':price2',$price2,PDO::PARAM_STR);
            $sth->bindValue(':price3',$price3,PDO::PARAM_STR);
            $sth->bindValue(':price4',$price4,PDO::PARAM_STR);
            $sth->bindValue(':price5',$price5,PDO::PARAM_STR);
            $sth->bindValue(':size1',$size1,PDO::PARAM_STR);
            $sth->bindValue(':size2',$size2,PDO::PARAM_STR);
            $sth->bindValue(':size3',$size3,PDO::PARAM_STR);
            $sth->bindValue(':size4',$size4,PDO::PARAM_STR);
            $sth->bindValue(':size5',$size5,PDO::PARAM_STR);
            // executeで実行
            $result = $sth->execute();

            return $result;
        } catch (\Exception $e) {
            error_log('エラー'.$e->getMessage());
            echo $e->getMessage();
            echo '保存できていません。';
            return $result;
        }
    }

    public function editSaveItemData($itemData) {
        $result = false;

        $user_id  = $itemData['user_id'];
        $post_id  = $itemData['post_id'];

        if(empty($itemData['items_id1'])){
            $category_id1 = $itemData['category1'];
            $brand1 = $itemData['brand1'];
            $item_name1 = $itemData['item_name1'];
            $price1 = $itemData['price1'];
            $size1 = $itemData['size1'];
        }else{
            $category_id1 = 0;
        }

        if(empty($itemData['items_id2'])){
            $category_id2 = $itemData['category2'];
            $brand2 = $itemData['brand2'];
            $item_name2 = $itemData['item_name2'];
            $price2 = $itemData['price2'];
            $size2 = $itemData['size2'];
        }else{
            $category_id2 = 0;
        }
        
        if(empty($itemData['items_id3'])){
            $category_id3 = $itemData['category3'];
            $brand3 = $itemData['brand3'];
            $item_name3 = $itemData['item_name3'];
            $price3 = $itemData['price3'];
            $size3 = $itemData['size3'];
        }else{
            $category_id3 = 0;
        }

        if(empty($itemData['items_id4'])){
            $category_id4 = $itemData['category4'];
            $brand4 = $itemData['brand4'];
            $item_name4 = $itemData['item_name4'];
            $price4 = $itemData['price4'];
            $size4 = $itemData['size4'];
        }else{
            $category_id4 = 0;
        }

        if(empty($itemData['items_id5'])){
            $category_id5 = $itemData['category5'];
            $brand5 = $itemData['brand5'];
            $item_name5 = $itemData['item_name5'];
            $price5 = $itemData['price5'];
            $size5 = $itemData['size5'];
        }else{
            $category_id5 = 0;
        }



        $sql = " INSERT INTO items(`user_id`,`post_id`,`category_id`,`brand`,`item_name`,`price`,`size`)VALUES(:user_id, :post_id, :category_id1, :brand1, :item_name1, :price1, :size1);
                 INSERT INTO items(`user_id`,`post_id`,`category_id`,`brand`,`item_name`,`price`,`size`)VALUES(:user_id, :post_id, :category_id2, :brand2, :item_name2, :price2, :size2);
                 INSERT INTO items(`user_id`,`post_id`,`category_id`,`brand`,`item_name`,`price`,`size`)VALUES(:user_id, :post_id, :category_id3, :brand3, :item_name3, :price3, :size3);
                 INSERT INTO items(`user_id`,`post_id`,`category_id`,`brand`,`item_name`,`price`,`size`)VALUES(:user_id, :post_id, :category_id4, :brand4, :item_name4, :price4, :size4);
                 INSERT INTO items(`user_id`,`post_id`,`category_id`,`brand`,`item_name`,`price`,`size`)VALUES(:user_id, :post_id, :category_id5, :brand5, :item_name5, :price5, :size5); ";
        try{
            $sth = $this->dbh->prepare($sql);
            $sth->bindValue(':user_id',$user_id,PDO::PARAM_INT);
            $sth->bindValue(':post_id',$post_id,PDO::PARAM_INT);
            $sth->bindValue(':category_id1',$category_id1,PDO::PARAM_INT);
            $sth->bindValue(':category_id2',$category_id2,PDO::PARAM_INT);
            $sth->bindValue(':category_id3',$category_id3,PDO::PARAM_INT);
            $sth->bindValue(':category_id4',$category_id4,PDO::PARAM_INT);
            $sth->bindValue(':category_id5',$category_id5,PDO::PARAM_INT);
            $sth->bindValue(':brand1',$brand1,PDO::PARAM_STR);
            $sth->bindValue(':brand2',$brand2,PDO::PARAM_STR);
            $sth->bindValue(':brand3',$brand3,PDO::PARAM_STR);
            $sth->bindValue(':brand4',$brand4,PDO::PARAM_STR);
            $sth->bindValue(':brand5',$brand5,PDO::PARAM_STR);
            $sth->bindValue(':item_name1',$item_name1,PDO::PARAM_STR);
            $sth->bindValue(':item_name2',$item_name2,PDO::PARAM_STR);
            $sth->bindValue(':item_name3',$item_name3,PDO::PARAM_STR);
            $sth->bindValue(':item_name4',$item_name4,PDO::PARAM_STR);
            $sth->bindValue(':item_name5',$item_name5,PDO::PARAM_STR);
            $sth->bindValue(':price1',$price1,PDO::PARAM_STR);
            $sth->bindValue(':price2',$price2,PDO::PARAM_STR);
            $sth->bindValue(':price3',$price3,PDO::PARAM_STR);
            $sth->bindValue(':price4',$price4,PDO::PARAM_STR);
            $sth->bindValue(':price5',$price5,PDO::PARAM_STR);
            $sth->bindValue(':size1',$size1,PDO::PARAM_STR);
            $sth->bindValue(':size2',$size2,PDO::PARAM_STR);
            $sth->bindValue(':size3',$size3,PDO::PARAM_STR);
            $sth->bindValue(':size4',$size4,PDO::PARAM_STR);
            $sth->bindValue(':size5',$size5,PDO::PARAM_STR);
            // executeで実行
            $result = $sth->execute();

            return $result;
        } catch (\Exception $e) {
            error_log('エラー'.$e->getMessage());
            echo $e->getMessage();
            echo '保存できていません。';
            return $result;
        }
    }


    public function updatePostData(){
        $result = false;

        //ファイル関連の取得
        $file = $_FILES['img'];
        $filename = basename($file['name']);
        $tmp_path = $file['tmp_name'];
        $file_err = $file['error'];
        $filesize = $file['size'];
        
        $upload_dir = 'img/';
        $save_filename = date('YmdHis') . $filename;

        $save_path = $upload_dir . $save_filename;

        $postData = $_SESSION['postData'];
        

        $post_id = $postData['post_id'];
        $title  = $postData['title'];
        $style_id  = $postData['style_id'];
        $contents  = $postData['contents'];
        $user_id  = $postData['user_id'];

        $sql = " UPDATE post SET post_id = :id, title = :title, style_id = :style_id, contents = :contents, file_name = :file_name, file_path = :file_path, contents = :contents, user_id = :user_id, del_flg = 0 ";
        $sql .= ' WHERE post_id = :id ';
        try{
            $sth = $this->dbh->prepare($sql);
            $sth->bindValue(':id', $post_id, PDO::PARAM_INT);
            $sth->bindValue(':title',$title,PDO::PARAM_STR);
            $sth->bindValue(':style_id',$style_id,PDO::PARAM_STR);
            $sth->bindValue(':contents',$contents,PDO::PARAM_STR);
            $sth->bindValue(':file_name',$save_filename,PDO::PARAM_STR);
            $sth->bindValue(':file_path',$save_path,PDO::PARAM_STR);
            $sth->bindValue(':user_id',$user_id,PDO::PARAM_INT);
            // // executeで実行
            $result = $sth->execute();

            return $result;
        } catch(\Exception $e) {
            echo $e->getMessage();
            return $result;
        }

    }

    /**
     * 新規投稿の保存(タイトル、スタイルID、コーデ内容紹介、ファイル名、保存先のパス）
     * @param int $user_id ユーザID
     * @param string $category_id　カテゴリー
     * @param string $brand　ブランド
     * @param string $item_name アイテムの名前
     * @param string $price　価格
     * @param string $size　サイズ
     * @return bool $result
     */
    public function updatePostItem() {
        $result = false;

        $itemData = $_SESSION['itemData'];
        $user_id  = $itemData['user_id'];
        $post_id  = $itemData['post_id'];
        $items_id1 = $itemData['items_id1'];
        $items_id2 = $itemData['items_id2'];
        $items_id3 = $itemData['items_id3'];
        $items_id4 = $itemData['items_id4'];
        $items_id5 = $itemData['items_id5'];
        $category_id1 = $itemData['category1'];
        $category_id2 = $itemData['category2'];
        $category_id3 = $itemData['category3'];
        $category_id4 = $itemData['category4'];
        $category_id5 = $itemData['category5'];
        $brand1 = $itemData['brand1'];
        $brand2 = $itemData['brand2'];
        $brand3 = $itemData['brand3'];
        $brand4 = $itemData['brand4'];
        $brand5 = $itemData['brand5'];
        $item_name1 = $itemData['item_name1'];
        $item_name2 = $itemData['item_name2'];
        $item_name3 = $itemData['item_name3'];
        $item_name4 = $itemData['item_name4'];
        $item_name5 = $itemData['item_name5'];
        $price1 = $itemData['price1'];
        $price2 = $itemData['price2'];
        $price3 = $itemData['price3'];
        $price4 = $itemData['price4'];
        $price5 = $itemData['price5'];
        $size1 = $itemData['size1'];
        $size2 = $itemData['size2'];
        $size3 = $itemData['size3'];
        $size4 = $itemData['size4'];
        $size5 = $itemData['size5'];

        $sql = " UPDATE items SET user_id = :user_id, post_id = :post_id, items_id = :items_id1, category_id = :category_id1, brand = :brand1, item_name = :item_name1, price = :price1, size = :size1 WHERE post_id = :post_id AND items_id = :items_id1;
                 UPDATE items SET user_id = :user_id, post_id = :post_id, items_id = :items_id2, category_id = :category_id2, brand = :brand2, item_name = :item_name2, price = :price2, size = :size2 WHERE post_id = :post_id AND items_id = :items_id2;
                 UPDATE items SET user_id = :user_id, post_id = :post_id, items_id = :items_id3, category_id = :category_id3, brand = :brand3, item_name = :item_name3, price = :price3, size = :size3 WHERE post_id = :post_id AND items_id = :items_id3;
                 UPDATE items SET user_id = :user_id, post_id = :post_id, items_id = :items_id4, category_id = :category_id4, brand = :brand4, item_name = :item_name4, price = :price4, size = :size4 WHERE post_id = :post_id AND items_id = :items_id4;
                 UPDATE items SET user_id = :user_id, post_id = :post_id, items_id = :items_id5, category_id = :category_id5, brand = :brand5, item_name = :item_name5, price = :price5, size = :size5 WHERE post_id = :post_id AND items_id = :items_id5; ";
        try{
            $sth = $this->dbh->prepare($sql);
            $sth->bindValue(':user_id',$user_id,PDO::PARAM_INT);
            $sth->bindValue(':post_id',$post_id,PDO::PARAM_INT);
            $sth->bindValue(':items_id1',$items_id1,PDO::PARAM_INT);
            $sth->bindValue(':items_id2',$items_id2,PDO::PARAM_INT);
            $sth->bindValue(':items_id3',$items_id3,PDO::PARAM_INT);
            $sth->bindValue(':items_id4',$items_id4,PDO::PARAM_INT);
            $sth->bindValue(':items_id5',$items_id5,PDO::PARAM_INT);
            $sth->bindValue(':category_id1',$category_id1,PDO::PARAM_INT);
            $sth->bindValue(':category_id2',$category_id2,PDO::PARAM_INT);
            $sth->bindValue(':category_id3',$category_id3,PDO::PARAM_INT);
            $sth->bindValue(':category_id4',$category_id4,PDO::PARAM_INT);
            $sth->bindValue(':category_id5',$category_id5,PDO::PARAM_INT);
            $sth->bindValue(':brand1',$brand1,PDO::PARAM_STR);
            $sth->bindValue(':brand2',$brand2,PDO::PARAM_STR);
            $sth->bindValue(':brand3',$brand3,PDO::PARAM_STR);
            $sth->bindValue(':brand4',$brand4,PDO::PARAM_STR);
            $sth->bindValue(':brand5',$brand5,PDO::PARAM_STR);
            $sth->bindValue(':item_name1',$item_name1,PDO::PARAM_STR);
            $sth->bindValue(':item_name2',$item_name2,PDO::PARAM_STR);
            $sth->bindValue(':item_name3',$item_name3,PDO::PARAM_STR);
            $sth->bindValue(':item_name4',$item_name4,PDO::PARAM_STR);
            $sth->bindValue(':item_name5',$item_name5,PDO::PARAM_STR);
            $sth->bindValue(':price1',$price1,PDO::PARAM_STR);
            $sth->bindValue(':price2',$price2,PDO::PARAM_STR);
            $sth->bindValue(':price3',$price3,PDO::PARAM_STR);
            $sth->bindValue(':price4',$price4,PDO::PARAM_STR);
            $sth->bindValue(':price5',$price5,PDO::PARAM_STR);
            $sth->bindValue(':size1',$size1,PDO::PARAM_STR);
            $sth->bindValue(':size2',$size2,PDO::PARAM_STR);
            $sth->bindValue(':size3',$size3,PDO::PARAM_STR);
            $sth->bindValue(':size4',$size4,PDO::PARAM_STR);
            $sth->bindValue(':size5',$size5,PDO::PARAM_STR);
            // executeで実行
            $result = $sth->execute();
            

            return $result;
        } catch (\Exception $e) {
            error_log('エラー'.$e->getMessage());
            echo $e->getMessage();
            echo '保存できていません。';
            return $result;
        }
    }

    /**
     * 削除
     * del_flgカラムが０で表示、１で非表示にするためにUPDATEで更新する。
     */
    public function deletePostData($id = 0) {
        $sql = ' UPDATE post SET del_flg = 1 ';
        $sql .= ' WHERE post_id = :post_id ';
        $sth = $this->dbh->prepare($sql);
        $sth->bindValue(':post_id', $id, PDO::PARAM_INT);
        $sth->execute();

    }

    // public function deleteItemData() {
    //     exit;
    //     $sql = ' UPDATE items SET del_flg = 1 ';
    //     $sql .= ' WHERE post_id = :post_id ';
    //     $sth = $this->dbh->prepare($sql);
    //     $sth->bindValue(':post_id', $id, PDO::PARAM_INT);
    //     $sth->execute();

    // }
    




}
