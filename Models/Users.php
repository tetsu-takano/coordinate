<?php
require_once(ROOT_PATH . '/database.php');
require_once(ROOT_PATH .'/Models/Db.php');

class Users extends Db {
    

    public function __construct($dbh = null)
    {
        parent::__construct($dbh);
    }
    
    /**
     * ユーザを登録する
     *
     * @return bool $result
     */
    public function createUser($userData)
    {
        $result = false;

        $sql = ' INSERT INTO users (email, name, birth, pass, gender, hight, role) VALUES (:email, :name, :birth, :pass, :gender, :hight, 0) ';

        $sth = $this->dbh->prepare($sql);
        
        $pass_hash = password_hash($userData['pass'], PASSWORD_DEFAULT);
        
        $sth->bindParam(':email', $userData['email'],PDO::PARAM_STR);
        $sth->bindParam(':name', $userData['name'],PDO::PARAM_STR);
        $sth->bindParam(':pass', $pass_hash, PDO::PARAM_STR);
        $sth->bindParam(':birth', $userData['birth'],PDO::PARAM_STR);
        $sth->bindParam(':gender', $userData['gender'],PDO::PARAM_STR);
        $sth->bindParam(':hight', $userData['hight'],PDO::PARAM_STR);

        $result = $sth->execute();
        return $result;

    }

    // /**
    //  * ユーザ情報の取得
    //  * @param int $id ユーザのID
    //  * @return Array $result 指定のユーザデータ
    //  */
    public function findById($id = 0) {
        $sql = ' SELECT * FROM users ';
        $sql .= ' WHERE id = :id ';
        try{
            $sth = $this->dbh->prepare($sql);
            $sth->bindParam(':id', $id, PDO::PARAM_INT);
            $sth->execute();
            $result = $sth->fetch(PDO::FETCH_ASSOC);
            return $result;
        }catch (PDOException $e) {
            echo $e->getMessage();
        }
        
    }

    /**
     * ユーザ情報を編集画面に表示する
     * @param int $id
     * @return Array $result
     */
    public function editUser($id = 0) {

        $sql = ' SELECT * FROM users WHERE id = :id ' ;

        try{
            $sth = $this->dbh->prepare($sql);
            $sth->bindParam(':id', $id, PDO::PARAM_INT);
            $sth->execute();
            $result = $sth->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    // /**
    //  * ユーザ情報の更新
    //  * @param array $_POST
    //  * @return bool $result
    //  */
    public function updateUser() {

        $id = $_POST['id'];
        $name = $_POST['name'];
        $email  = $_POST['email'];
        $gender = $_POST['gender'];
        $hight = $_POST['hight'];
        $pass  = $_POST['pass'];

        $sql = ' UPDATE users SET name = :name, email = :email, gender = :gender, hight = :hight, pass = :pass ';
        $sql .= ' WHERE id = :id ';
        try{
        $sth = $this->dbh->prepare($sql);
        $pass_hash = password_hash($pass, PASSWORD_DEFAULT);
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->bindParam(':name', $name,PDO::PARAM_STR);
        $sth->bindParam(':email', $email,PDO::PARAM_STR);
        $sth->bindParam(':gender', $gender,PDO::PARAM_STR);
        $sth->bindParam(':hight', $hight,PDO::PARAM_STR);
        $sth->bindParam(':pass', $pass_hash,PDO::PARAM_STR);
        $result = $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }

        // /**
    //  * ユーザ情報の削除
    //  * @param array $_POST
    //  * @return bool $result
    //  */
    public function deleteUser() {

        $sql = ' DELETE * FROM users ';
        try{
            $sth = $this->dbh->prepare($sql);
            $sth->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

    }


    /**
     * ログイン処理
     * @param string $email
     * @param string $pass
     * @return bool $result
     */
    public static function login($email, $pass)
    {
        //結果
        $result = false;
        //ユーザーをemailから検索して取得
        $Users = self::getUserByEmail($email);
        if (!$Users) {
            $_SESSION['msg'] = 'メールアドレスが一致しません。';
            return $result;
          }
        //パスワードの紹介
        if(password_verify($pass, $Users['pass']))
        {
            //ログイン成功
            session_regenerate_id(true);
            $_SESSION['login_user'] = $Users;
            $result = true;
            return $result;
        }else{
            $_SESSION['msg'] = 'パスワードが一致しません。';
            return $result;
        }
    }

    /**
     * emailからユーザを取得
     * @param string $email
     
     * @return array|bool $user|false
     */
    public static function getUserByEmail($email)
    {
        $result = false;

        $dbh = new PDO('mysql:dbname='.DB_NAME.';host='.DB_HOST, DB_USER, DB_PASSWD);
        $sql = 'SELECT * FROM users WHERE email = :email';
        $sth = $dbh->prepare($sql);

        $sth->bindParam(':email', $email, PDO::PARAM_STR);
        
        try {
            $sth->execute();
            $Users = $sth->fetch();
            return $Users;
          } catch (\Exception $e) {
            return false;
          }
    }

    /**
     * ログインチェック
     * @param void
     * @return bool $result
     */
    public static function checkLogin()
    {
        $result = false;
        //セッションにログインユーザーが入っていなかったらfalse
        if(isset($_SESSION['login_users']) && $_SESSION['login_users']['id'] > 0 )
        {
        return $result = true;
        }
        return $result;
    }

    /**
     * ログアウト処理
     */
    public static function logout()
    {
        $_SESSION = [];
        session_destroy();
    }


        /**
     * パスワードリセット準備（メールアドレスと誕生日の一致確認）
     * @param string $email
     * @param string $password
     * @return bool $result
     */
    public static function checkUser($email, $birth) {
        // 結果
        $result = false;
        // ユーザをemailから検索して取得
        $user = self::getUserByEmail($email);

        if(!$user) {
            $_SESSION['msg'] = 'メールアドレスが一致しません。';
            return $result;
        }

        //誕生日の照会
        if($birth != $user['birth']) {
            $_SESSION['msg'] = '誕生日が一致しません。';
            return $result;
        }
        //照会成功
        $_SESSION['user'] = $user;
        return $_SESSION['user'];
    }
    
    /**
     * パスワードリセット処理
     * @param array $_POST
     * @return bool $result
     */
    public function updatePass($user_id,$password) {

        $sql = ' UPDATE users SET pass = :pass  WHERE id = :id ';
        $sth = $this->dbh->prepare($sql);
        $pass_hash = password_hash($password, PASSWORD_DEFAULT);
        $sth->bindParam(':id', $user_id, PDO::PARAM_INT);
        $sth->bindParam(':pass', $pass_hash,PDO::PARAM_STR);

        $sth->execute();
    }

        /**
     * パスワードリセット準備（メールアドレスと誕生日の一致確認）
     * @param string $email
     * @param string $password
     * @return bool $result
     */
    public static function checkDoneUser($email, $name) {
        // 結果
        $result = false;
        // ユーザをemailから検索して取得
        $user = self::getUserByEmail($email);

        if(!$user) {
            return $result;
            $_SESSION['msg'] = 'すでに登録されております。';
            return $result;
        }

        //誕生日の照会
        if($name != $user['name']) {
            $_SESSION['msg'] = 'すでに登録されております。';
            return $result;
        }
        //照会成功
        $_SESSION['user'] = $user;
        return $_SESSION['user'];
        header('Location: login.php');
    }

}