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
     * @param int $post_id 投稿のID
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

    /**
     * アイテムの投稿詳細を取得する（指定IDのデータ）
     * @param int $post_id 投稿のID
     * @return Array $result 指定IDの投稿データ
     */
    public function findItems($id) {
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
            $this->dbh->beginTransaction();

            $sth->bindValue(':title',$title,PDO::PARAM_STR);
            $sth->bindValue(':style_id',$style_id,PDO::PARAM_STR);
            $sth->bindValue(':contents',$contents,PDO::PARAM_STR);
            $sth->bindValue(':file_name',$save_filename,PDO::PARAM_STR);
            $sth->bindValue(':file_path',$save_path,PDO::PARAM_STR);
            $sth->bindValue(':user_id',$user_id,PDO::PARAM_INT);
            // // executeで実行
            $result = $sth->execute();
            $this->dbh->commit();
            return $result;
        } catch(\Exception $e) {
            $this->dbh->rollback();
            echo $e->getMessage();
            return $result;
        }
    }

    public function createItemsArray($itemData) {
        $items = [
            '1' => ['category_id' => $itemData['category1'],
                       'items_id' => $itemData['items_id1'],
                       'brand' => $itemData['brand1'],
                       'item_name' => $itemData['item_name1'],
                       'price' => $itemData['price1'],
                       'size' => $itemData['size1'],
            ],
            '2' => ['category_id' => $itemData['category2'],
                        'items_id' => $itemData['items_id2'],
                        'brand' => $itemData['brand2'],
                        'item_name' => $itemData['item_name2'],
                        'price' => $itemData['price2'],
                        'size' => $itemData['size2'],
            ],
            '3' => ['category_id' => $itemData['category3'],
                        'items_id' => $itemData['items_id3'],
                        'brand' => $itemData['brand3'],
                        'item_name' => $itemData['item_name3'],
                        'price' => $itemData['price3'],
                        'size' => $itemData['size3'],
            ],
            '4' => ['category_id' => $itemData['category4'],
                        'items_id' => $itemData['items_id4'],
                        'brand' => $itemData['brand4'],
                        'item_name' => $itemData['item_name4'],
                        'price' => $itemData['price4'],
                        'size' => $itemData['size4'],
            ],
            '5' => ['category_id' => $itemData['category5'],
                    'items_id' => $itemData['items_id5'],
                    'brand' => $itemData['brand5'],
                    'item_name' => $itemData['item_name5'],
                    'price' => $itemData['price5'],
                    'size' => $itemData['size5'],
            ],
        ];
        return $items;
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
        $items = $this->createItemsArray($itemData);

        try{
            foreach($items as $item){
                $category_id = $item['category_id'];
                $brand = $item['brand'];
                $item_name = $item['item_name'];
                $price = $item['price'];
                $size = $item['size'];

                $sql = " INSERT INTO items(`user_id`,`post_id`,`category_id`,`brand`,`item_name`,`price`,`size`)VALUES(:user_id, (SELECT post_id FROM post ORDER BY post_id DESC LIMIT 1), :category_id, :brand, :item_name, :price, :size) ";
                $sth = $this->dbh->prepare($sql);
                $this->dbh->beginTransaction();
                $sth->bindValue(':user_id',$user_id,PDO::PARAM_INT);
                $sth->bindValue(':category_id',$category_id,PDO::PARAM_INT);
                $sth->bindValue(':brand',$brand,PDO::PARAM_STR);
                $sth->bindValue(':item_name',$item_name,PDO::PARAM_STR);
                $sth->bindValue(':price',$price,PDO::PARAM_STR);
                $sth->bindValue(':size',$size,PDO::PARAM_STR);
                $result = $sth->execute();
                $this->dbh->commit();
            }
            return $result;
        } catch (\Exception $e) {
            $this->dbh->rollback();
            error_log('エラー'.$e->getMessage());
            echo $e->getMessage();
            echo '保存できていません。';
            return $result;
        }

    }

    /**
     * 投稿編集でアイテムを増やした場合に内容を保存(カテゴリー、ブランド、アイテム名、価格、サイズ）
     * @param int $user_id ユーザID
     * @param string $category_id　カテゴリー
     * @param string $brand　ブランド
     * @param string $item_name アイテムの名前
     * @param string $price　価格
     * @param string $size　サイズ
     * @return bool $result
     */
    public function editSaveItemData($itemData) {
        $result = false;

        $user_id  = $itemData['user_id'];
        $post_id  = $itemData['post_id'];
        $items = $this->createItemsArray($itemData);

        try{
            foreach($items as $item){
                if(empty($item['items_id'])){
                    $category_id = $item['category_id'];
                    $brand = $item['brand'];
                    $item_name = $item['item_name'];
                    $price = $item['price'];
                    $size = $item['size'];

                    $sql = " INSERT INTO items(`user_id`,`post_id`,`category_id`,`brand`,`item_name`,`price`,`size`)VALUES(:user_id, :post_id, :category_id, :brand, :item_name, :price, :size) ";
                    $sth = $this->dbh->prepare($sql);
                    $this->dbh->beginTransaction();
                    $sth->bindValue(':user_id',$user_id,PDO::PARAM_INT);
                    $sth->bindValue(':post_id',$post_id,PDO::PARAM_INT);
                    $sth->bindValue(':category_id',$category_id,PDO::PARAM_INT);
                    $sth->bindValue(':brand',$brand,PDO::PARAM_STR);
                    $sth->bindValue(':item_name',$item_name,PDO::PARAM_STR);
                    $sth->bindValue(':price',$price,PDO::PARAM_STR);
                    $sth->bindValue(':size',$size,PDO::PARAM_STR);
                    $result = $sth->execute();
                    $this->dbh->commit();
                }
            }
            return $result;
        } catch (\Exception $e) {
            $this->dbh->rollback();
            error_log('エラー'.$e->getMessage());
            echo $e->getMessage();
            echo '保存できていません。';
            return $result;
        }

    }

    /**
     * 投稿の更新(タイトル、スタイルID、コーデ内容紹介、ファイル名、保存先のパス）
     * @param int $user_id ユーザID
     * @param string $title　タイトル
     * @param int $style_id　スタイルID
     * @param string $contents　コーデ内容紹介
     * @param string $save_filename　ファイル名
     * @param string $save_path　保存先のパス
     * @return bool $result
     */
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
            $this->dbh->beginTransaction();
            $sth->bindValue(':id', $post_id, PDO::PARAM_INT);
            $sth->bindValue(':title',$title,PDO::PARAM_STR);
            $sth->bindValue(':style_id',$style_id,PDO::PARAM_STR);
            $sth->bindValue(':contents',$contents,PDO::PARAM_STR);
            $sth->bindValue(':file_name',$save_filename,PDO::PARAM_STR);
            $sth->bindValue(':file_path',$save_path,PDO::PARAM_STR);
            $sth->bindValue(':user_id',$user_id,PDO::PARAM_INT);
            // // executeで実行
            $result = $sth->execute();
            $this->dbh->commit();
            return $result;
        } catch(\Exception $e) {
            $this->dbh->rollback();
            echo $e->getMessage();
            return $result;
        }

    }

    /**
     * 投稿編集画面でアイテムを増やさず内容だけを変更した場合に内容を保存する処理(タイトル、スタイルID、コーデ内容紹介、ファイル名、保存先のパス）
     * @param int $user_id ユーザID
     * @param string $category_id　カテゴリー
     * @param string $brand　ブランド
     * @param string $item_name アイテムの名前
     * @param string $price　価格
     * @param string $size　サイズ
     * @return bool $result
     */
    public function updatePostItem($itemData) {
        $result = false;

        $user_id  = $itemData['user_id'];
        $post_id  = $itemData['post_id'];
        $items = $this->createItemsArray($itemData);

        try{
            foreach($items as $item){
                $category_id = $item['category_id'];
                $items_id = $item['items_id'];
                $brand = $item['brand'];
                $item_name = $item['item_name'];
                $price = $item['price'];
                $size = $item['size'];

                $sql = " UPDATE items SET user_id = :user_id, post_id = :post_id, items_id = :items_id, category_id = :category_id, brand = :brand, item_name = :item_name, price = :price, size = :size WHERE post_id = :post_id AND items_id = :items_id ";
                $sth = $this->dbh->prepare($sql);
                $this->dbh->beginTransaction();
                $sth->bindValue(':user_id',$user_id,PDO::PARAM_INT);
                $sth->bindValue(':post_id',$post_id,PDO::PARAM_INT);
                $sth->bindValue(':items_id',$items_id,PDO::PARAM_INT);
                $sth->bindValue(':category_id',$category_id,PDO::PARAM_INT);
                $sth->bindValue(':brand',$brand,PDO::PARAM_STR);
                $sth->bindValue(':item_name',$item_name,PDO::PARAM_STR);
                $sth->bindValue(':price',$price,PDO::PARAM_STR);
                $sth->bindValue(':size',$size,PDO::PARAM_STR);
                $result = $sth->execute();
                $this->dbh->commit();
            }
            return $result;
        } catch (\Exception $e) {
            $this->dbh->rollback();
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
        $result = false;

        try{
        $sql = ' UPDATE post SET del_flg = 1 ';
        $sql .= ' WHERE post_id = :post_id ';
        $sth = $this->dbh->prepare($sql);
        $this->dbh->beginTransaction();
        $sth->bindValue(':post_id', $id, PDO::PARAM_INT);
        $result = $sth->execute();
        $this->dbh->commit();
        return $result;
        }catch(\Exception $e) {
            $this->dbh->rollback();
                error_log('エラー'.$e->getMessage());
                echo $e->getMessage();
                echo '保存できていません。';
                return $result;
        }
    }

}
