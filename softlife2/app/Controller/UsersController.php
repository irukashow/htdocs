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
	public function index($user=null){
            // レイアウト関係
            $this->layout = "main";
            $this->set("header_for_layout","派遣管理システム");
            $this->set("footer_for_layout",
                "copyright by SOFTLIFE. 2015.");
            
            $this->render('index');
	}
	
	/**
	 * ユーザ登録情報の更新
	 */
	public function edit(){
		// 処理の記述は省略
		$this->render('edit');
	}
	
	/**
	 * ユーザ登録。
	 */
    public function add() {
    	
    	// POSTの場合
        if ($this->request->is('post')) {
        	
            // モデルの状態をリセットする
            $this->User->create();
            // データを登録する
            $this->User->save($this->request->data);
            
            // indexに移動する
            $this->redirect(array('action' => 'index'));
            
        }
    }
    
    /**
     * ログイン処理を行う。
     */
    public function login(){
        // レイアウト関係
        $this->layout = "main";
        $this->set("header_for_layout","派遣管理システム");
        $this->set("footer_for_layout",
            "copyright by SOFTLIFE. 2015.");
            
    	if ($this->request->is('post')) { 
            if ($this->User->validates()){

	    	// Authコンポーネントのログイン処理を呼び出す。
	    	if($this->Auth->login()){
	    		// ログイン処理成功
	    		$this->redirect(array('action' => 'index'),$this->request->data('username'));
	    	}else{
	    		// ログイン処理失敗
	    		$this->Session->setFlash('認証に失敗しました。');
	    	}
            }
    	}
    }

    /**
     * ログアウト処理を行う。
     */
    public function logout(){
    	
    	$this->Auth->logout();
    	return $this->flash('ログアウトしました。', '/users/index');
    }

}