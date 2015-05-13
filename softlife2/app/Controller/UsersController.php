<?php

class UsersController extends AppController {

	// Authコンポーネントの利用設定。
	public $components = array(
			'Auth'=>array(
					'allowedActions'=>array('index','login','add')
					));
	
	/**
	 * index
	 */
	public function index(){
            // レイアウト関係
            $this->layout = "main";
            $this->set("header_for_layout","派遣管理システム");
            $this->set("footer_for_layout",
                "copyright by SOFTLIFE. 2015.");
            
            $name = $this->Auth->user('name_sei').' '.$this->Auth->user('name_mei');
            $this->set('user_name', $name);
            $this->set('name', $name);
            
            //$this->render('index');
	}
	
	/**
	 * ユーザ登録情報の更新
	 */
	public function edit(){
		// 処理の記述は省略
		$this->render('edit');
	}

	/**
	 * ユーザ一覧。
	 */
    public function view() {
        // レイアウト関係
        $this->layout = "main";
        $this->set("header_for_layout","派遣管理システム");
        $this->set("footer_for_layout",
            "copyright by SOFTLIFE. 2015.");
        $name = $this->Auth->user('name_sei').' '.$this->Auth->user('name_mei');
        $this->set('user_name', $name);
        
        
    }
	/**
	 * ユーザ登録。
	 */
    public function add() {
        // レイアウト関係
        $this->layout = "main";
        $this->set("header_for_layout","派遣管理システム");
        $this->set("footer_for_layout",
            "copyright by SOFTLIFE. 2015.");
        $name = $this->Auth->user('name_sei').' '.$this->Auth->user('name_mei');
        $this->set('user_name', $name);
        
    	// POSTの場合
        if ($this->request->is('post')) {
            if (isset($this->request->data['submit'])) {
                // モデルの状態をリセットする
                $this->User->create();
                // データを登録する
                $this->User->save($this->request->data);

                // indexに移動する
                $this->redirect(array('action' => 'index'));
            }
        }
    }
    
    /**
     * ログイン処理を行う。
     */
    public function login(){
        // ログイン中の時は追い返す
        $user = $this->Auth->user();
        if(is_null($user) == false){
            $this->redirect(array('action' => 'index'));
        }
       
        // レイアウト関係
        $this->layout = "login";
        $this->set("header_for_layout","派遣管理システム");
        $this->set("footer_for_layout",
            "copyright by SOFTLIFE. 2015.");
            
    	if ($this->request->is('post')) { 
            $username = $this->request->data['User']['username'];

            // Authコンポーネントのログイン処理を呼び出す。
            if($this->Auth->login()){
                // ログイン処理成功
		//$this->Session->setFlash('認証に成功しました。');
                //$this->redirect(array('action' => 'index'));
            //$this->Session->setFlash('$username='.$username);
                $this->redirect($this->Auth->redirect());
            }else{
                // ログイン処理失敗
                $this->Session->setFlash('認証に失敗しました。');
            }
        }
    }


    /**
     * ログアウト処理を行う。
     */
    public function logout(){
    	
    	$this->redirect($this->Auth->logout());
        //$this->redirect($this->Auth->redirect());
    	//eturn $this->flash('ログアウトしました。', '/users/index');
    }

}