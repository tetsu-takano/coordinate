<?php 
require_once(ROOT_PATH .'/Models/Db.php');

class Style extends Db {
    public function __construct($dbh = null) {
        parent::__construct($dbh);
    }

    /**
     * スタイル別投稿データを参照する
     * @param void
     * @return Array $result 全参照データ
     */
    public function styleAll($page,$style_id) {
        $sql = " SELECT p.post_id, p.title, p.style_id, p.file_path, u.name, p.created_id, p.updated_id FROM post p INNER JOIN users u ON p.user_id = u.id WHERE p.style_id = :style_id AND del_flg = 0 ";
        $sql .= ' LIMIT 9 OFFSET '.(9 * $page);
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':style_id', $style_id, PDO::PARAM_STR);
        $stmt->execute();
        // 結果の取得
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

}
?>