<?php
require_once(ROOT_PATH .'/database.php');
require_once(ROOT_PATH .'/Models/Db.php');

class Like extends Db {
    public function __construct($dbh = null) {
        parent::__construct($dbh);
    }

    function check_like_duplicate($user_id, $post_id){
        $result = false;
        $dbh = new PDO(
            'mysql:dbname='.DB_NAME.
            ';host='.DB_HOST, DB_USER, DB_PASSWD
        );
    
        $sql = " SELECT * FROM `like` WHERE user_id = :user_id AND post_id = :post_id ";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->execute();
        $like = $stmt->fetch();
        if(!empty($like)) {
            $result = true;
        }
        return $result;
    }
    

    
      //既に登録されているか確認
    function clearLike($user_id, $post_id){
        $result = false;
        $dbh = new PDO(
            'mysql:dbname='.DB_NAME.
            ';host='.DB_HOST, DB_USER, DB_PASSWD
        );

        $sql = " DELETE FROM `like` WHERE :user_id = user_id AND :post_id = post_id ";
        $sth = $dbh->prepare($sql);
        $sth->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $sth->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $sth->execute();
        return $result;
    }

    function registerLike($user_id, $post_id){
        $result = false;
        $dbh = new PDO(
            'mysql:dbname='.DB_NAME.
            ';host='.DB_HOST, DB_USER, DB_PASSWD
        );
    
        $sql = $sql = " INSERT INTO `like` ( post_id, user_id ) VALUE ( :post_id, :user_id ) ";
        $sth = $dbh->prepare($sql);
        $sth->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $sth->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $sth->execute();
        
        return $result;
    }


}
