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

    	if ($this->request->is('post')) {
	    	// Authコンポーネントのログイン処理を呼び出す。
	    	if($this->Auth->login()){
	    		// ログイン処理成功
	    		return $this->flash('認証に成功しました。', '/users/index');
	    	}else{
	    		// ログイン処理失敗
	    		return $this->flash('認証に失敗しました。', '/users/index');
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