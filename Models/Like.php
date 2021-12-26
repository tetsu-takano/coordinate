<?php
require_once(ROOT_PATH .'/Models/Db.php');

class Like extends Db {
    public function __construct($dbh = null) {
        parent::__construct($dbh);
    }

    function check_like_duplicate($user_id, $post_id){
        $result = false;
    
        $sql = " SELECT * FROM `like` WHERE user_id = :user_id AND post_id = :post_id ";
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $sth->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $sth->execute();
        $like = $sth->fetch();
        if(!empty($like)) {
            $result = true;
        }
        return $result;
    }
    

    
      //既に登録されているか確認
    function clearLike($user_id, $post_id){
        $result = false;
        
        $sql = " DELETE FROM `like` WHERE :user_id = user_id AND :post_id = post_id ";
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $sth->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $sth->execute();
        return $result;
    }

    function registerLike($user_id, $post_id){
        $result = false;
        
        $sql = $sql = " INSERT INTO `like` ( post_id, user_id ) VALUE ( :post_id, :user_id ) ";
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $sth->bindParam(':post_id', $post_id, PDO::PARAM_INT);
        $sth->execute();
        
        return $result;
    }


}
