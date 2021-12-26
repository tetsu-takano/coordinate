<?php
require_once(ROOT_PATH.'/Models/Post.php');
require_once(ROOT_PATH.'/Models/Style.php');
require_once(ROOT_PATH.'/Models/Like.php');



class CoordinateController {
    private $request;   //リクエストパラメータ(GET,POST)
    private $Style;      //Styleモデル  
    private $Post;      //Postモデル    
    private $Like;      //Likeモデル
    
    public function __construct() {  
        //　リクエストパラメータの取得
        $this->request['get'] = $_GET;
        $this->request['post'] = $_POST;
        $this->request['files'] = $_FILES;
        
        //　モデルオブジェクトの生成 (Post.php)
        $this->Post = new Post();
        //　別モデルと連携（Style.php）
        $this->Style = new Style();
        //　別モデルと連携（Like.php）
        $this->Like = new Like();

    }

    public function main() {
        $page = 0;
        if(isset($this->request['get']['page'])) {
            $page = $this->request['get']['page'];
        }

        $posts = $this->Post->findAll($page);
        $posts_count = $this->Post->countAll($page);
        $params = [
            'posts' => $posts,
            'pages' => intdiv($posts_count,4),
        ];
        return $params;
    }


    //mypageでタイトルとユーザー名と写真を出すためのコントローラー
    public function myPost() {
        $page = 0;
        if(isset($this->request['get']['page'])) {
            $page = $this->request['get']['page'];
        }

        $u_posts = $this->Post->findByUser($page);
        $posts_count = $this->Post->countAllByUser();
        $params = [
            'u_posts' => $u_posts,
            'pages' => intdiv($posts_count,2),
        ];
        return $params;
    }

    public function view() {
        $posts = $this->Post->findById($this->request['get']['id']);
        $items = $this->Post->findItems($this->request['get']['id']);
        $params = [
            'posts' => $posts,
            'items' => $items,
        ];
        return $params;
    }

    public function create($itemsData) {
        $posts = $this->Post->savePostData();
        $postItem = $this->Post->savePostItemData($itemsData);
        $params = [
            'posts' => $posts,
            'postItem' => $postItem,
        ];
        
        return $params;

    }

    public function edit() {
        $edit = $this->Post->findById($this->request['get']['id']);
        $edit_items = $this->Post->findItems($this->request['get']['id']);
        $params = [
            'edit' => $edit,
            'edit_items' => $edit_items
        ];
        return $params;
    }

    public function update($itemData) {
        $updatePost = $this->Post->updatePostData();
        $updateItem = $this->Post->updatePostItem($itemData);
        $this->Post->editSaveItemData($itemData);
        $params = [
            'update' => $updatePost,
            'updateItem' => $updateItem,
        ];

        return $params;
    }

    public function delete() {
        $deletePost = $this->Post->deletePostData($this->request['get']['id']);
        $params = [
            'deletePost' => $deletePost,
        ];

        return $params;
    }

    public function like($user_id,$post_id) {
        $likeBool = $this->Like->check_like_duplicate($user_id,$post_id);
        
        if(!$likeBool){
            $registerLike = $this->Like->registerLike($user_id,$post_id);
            $action = '登録';
        }else{
            $clearLike = $this->Like->clearLike($user_id,$post_id);
            $action = '解除';
        };
    }

    public function style() {
        $page = 0;
        if(isset($this->request['get']['page'])) {
            $page = $this->request['get']['page'];
        }

        $style_id = $_POST['style_id'];
        $style = $this->Style->styleAll($page,$style_id);
        $posts_count = $this->Post->countAll();
        $params = [
            'style' => $style,
            'pages' => intdiv($posts_count,2),
        ];
        return $params;
    }


}

?>
