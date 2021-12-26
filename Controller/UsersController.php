<?php
require_once(ROOT_PATH.'/Models/Users.php');

class UsersController {

    private $request; //リクエストパラメータ（GET,POST)
    private $Users;//Usersモデル
    
    public function __construct() {
        // リクエストパラメータの取得
        $this->request['get'] = $_GET;
        $this->request['post'] = $_POST;

        // モデルオブジェクトの生成
        $this->Users = new Users();
        // 別モデルとの連携
        $dbh = $this->Users->get_db_handler();
    }

    public function create()
    {
        $create = $this->Users->createUser($this->request['post']);
    }
    
    public function edit() {
        $edit = $this->Users->editUser($this->request['get']['id']);
        $params = [
            'user' => $edit
        ];
        return $params;
    }

    public function update() {
        $update = $this->Users->updateUser(); 
        $user = $this->Users->findById($this->request['post']['id']);
        
        $params = [
            'user' => $user
        ];
        return $params;
        $result = $this->User->updateUser();
        return $result;
        $_SESSION['login_user'] = $update;
    }


    public function reset($user_id,$password) {
        $reset = $this->Users->updatePass($user_id,$password); 
    }


    public function delete() {
        $delete = $this->Users->deleteUser(); 
    }

}

?>