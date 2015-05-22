<?php

class UsersController extends AppController {

	// Authコンポーネントの利用設定。
	public $components = array('Auth'=>array('allowedActions'=>array('index','login','add')));
        // タイトル
        public $title_for_layout = "ホーム - 派遣管理システム";
        
	/**
	 * index
	 */
	public function index(){
            // レイアウト関係
            $this->layout = "main";
            $this->set("title_for_layout",$this->title_for_layout);
            // タブの状態
            $this->set('active1', 'active');
            $this->set('active2', '');
            $this->set('active3', '');
            $this->set('active4', '');
            $this->set('active5', '');
            $this->set('active6', '');
            $this->set('active7', '');
            $this->set('active8', '');
            $this->set('active9', '');
            $this->set('active10', '');
            // ユーザー名前
            $name = $this->Auth->user('name_sei').' '.$this->Auth->user('name_mei');
            $this->set('user_name', $name);
            $this->set('name', $name);
            
            //$this->render('index');
	}
	
	/**
	 * ユーザ登録情報の更新
	 */
	public function edit($id=null){
            /* 管理権限がある場合 */
            if ($this->isAuthorized($this->Auth->user())) {

            }else{
                $this->Session->setFlash('管理者しか権限がありません。');
                $this->redirect($this->referer());
            }

                // レイアウト関係
                $this->layout = "sub";
                $this->set("title_for_layout","ユーザー登録 - 派遣管理システム");
                // タブの状態
                $this->set('active1', 'active');
                $this->set('active2', '');
                $this->set('active3', '');
                $this->set('active4', '');
                $this->set('active5', '');
                $this->set('active6', '');
                $this->set('active7', '');
                $this->set('active8', '');
                $this->set('active9', '');
                $this->set('active10', '');
                // ユーザー名前
                $name = $this->Auth->user('name_sei').' '.$this->Auth->user('name_mei');
                $this->set('user_name', $name);

                // 初期値設定
                $this->set('datas', $this->User->find( 'all'));
                //$username = $this->request->data('username');
                //
                //指定プライマリーキーのデータをセット
                $this->set('username', $id);
                $this->User->username = $id;
                $this->request->data = $this->User->read(null, $id);

                /*
                // POSTの場合
                if ($this->request->is('post')) {
                    $username = $this->request->data['username'];
                    $status = array('conditions' => array('User.username' => $username));
                    $data = $this->User->find('first', $status);
                    
                    if ($this->User->validates() == false) {
                        return null;
                    }
                    if (isset($this->request->data['submit'])) {
                        // データを登録する
                        $this->User->save($this->request->data);
                        // 登録完了
                        $this->Session->setFlash('ユーザー登録を完了しました。');

                        // indexに移動する
                        //$this->redirect(array('action' => 'index'));
                    }

                } else {
                    $this->request->data = $this->User->read(null, $this->Auth->user('username'));    
                    $data = null;
                }
                $this->set('data',$data);
            */
	}

	/**
	 * ユーザ一覧。
	 */
    public function view() {
        // レイアウト関係
        $this->layout = "main";
        $this->set("title_for_layout","ホーム - 派遣管理システム");
        $name = $this->Auth->user('name_sei').' '.$this->Auth->user('name_mei');
        $this->set('user_name', $name);
        
        $data = $this->User->find('all');
        $this->set('data', $data);
    }
	/**
	 * ユーザ登録。
	 */
    public function add() {
        /* 管理権限がある場合 */
        if ($this->isAuthorized($this->Auth->user())) {
            
        }else{
            $this->Session->setFlash('管理者しか権限がありません。');
            $this->redirect($this->referer());
        }
        
            // レイアウト関係
            $this->layout = "sub";
            $this->set("title_for_layout","ユーザー登録 - 派遣管理システム");
            // タブの状態
            $this->set('active1', 'active');
            $this->set('active2', '');
            $this->set('active3', '');
            $this->set('active4', '');
            $this->set('active5', '');
            $this->set('active6', '');
            $this->set('active7', '');
            $this->set('active8', '');
            $this->set('active9', '');
            $this->set('active10', '');
            // ユーザー名前
            $name = $this->Auth->user('name_sei').' '.$this->Auth->user('name_mei');
            $this->set('user_name', $name); 
        
    	// POSTの場合
        if ($this->request->is('post')) {
            if ($this->User->validates() == false) {
                return null;
            }
            if (isset($this->request->data['submit'])) {
                // モデルの状態をリセットする
                $this->User->create();
                // データを登録する
                $this->User->save($this->request->data);
                // 登録完了
                $this->Session->setFlash('ユーザー登録を完了しました。');

                // indexに移動する
                //$this->redirect(array('action' => 'index'));
            }
        }
    }

	/**
	 * パスワードの変更
	 */
	public function passwd(){
            // レイアウト関係
            $this->layout = "sub";
            $this->set("title_for_layout","パスワード変更 - 派遣管理システム");
            // タブの状態
            $this->set('active1', 'active');
            $this->set('active2', '');
            $this->set('active3', '');
            $this->set('active4', '');
            $this->set('active5', '');
            $this->set('active6', '');
            $this->set('active7', '');
            $this->set('active8', '');
            $this->set('active9', '');
            $this->set('active10', '');
            // ユーザー名前
            $name = $this->Auth->user('name_sei').' '.$this->Auth->user('name_mei');
            $this->set('user_name', $name);
            $this->set('name', $name);
            
            $this->User->username = $this->Auth->user('username');
            // POSTの場合
            if ($this->request->is('post') || $this->request->is('put')) {
                    // データを登録する
                    $this->User->save($this->request->data);
                    $this->Session->setFlash(__('パスワードは変更されました。'));

                    // indexに移動する
                    $this->redirect(array('action' => 'index'));
            } else {
                $this->request->data = $this->User->read(null, $this->Auth->user('username'));    
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
        $this->set("title_for_layout","ログイン - 派遣管理システム");
        
        // 初期値設定
        $this->set('datas', $this->User->find( 'all'));
            
        // ログイン認証
    	if ($this->request->is('post')) { 
            //$username = $this->request->data['User']['username'];

            // Authコンポーネントのログイン処理を呼び出す。
            if($this->Auth->login()){
                // ログイン処理成功
		//$this->Session->setFlash('認証に成功しました。');
                //$this->redirect(array('action' => 'index'));
            //$this->Session->setFlash('$username='.$username);
                // ログイン履歴
                $this->loadModel("LoginLog");  // ログイン履歴テーブル
                $this->LoginLog->create();
                $log = array('username' => $this->Auth->user('username'),
                    'status' => $this->LoginLog->status = 'login','ip_address' =>$this->request->clientIp(false));
                $this->LoginLog->save($log);
    
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
        // ログアウト履歴
        $this->loadModel("LoginLog");  // ログイン履歴テーブル
        $this->LoginLog->create();
        $log = array('username' => $this->Auth->user('username'),
            'status' => $this->LoginLog->status = 'logout','ip_address' => $this->request->clientIp(false));
        $this->LoginLog->save($log);
                
    	$this->redirect($this->Auth->logout());
        //$this->redirect($this->Auth->redirect());
    	//eturn $this->flash('ログアウトしました。', '/users/index');
    }

}