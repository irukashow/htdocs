<?php

class UsersController extends AppController {
        public $uses = array('MessageMember', 'LoginLogs', 'AdminInfo');
	// Authコンポーネントの利用設定。
	public $components = array('Auth'=>array('allowedActions'=>array('login')));
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
            // 絞り込みセッションを消去
            $this->Session->delete('filter');
            // ユーザー名前
            $name = $this->Auth->user('name_sei').' '.$this->Auth->user('name_mei');
            $this->set('user_name', $name);
            $this->set('name', $name);
            $username = $this->Auth->user('username');
            $this->set('username', $username);
            $selected_class = $this->Session->read('selected_class');
            // テーブルの設定
            $this->MessageMember->setSource('message_staff');
            //$this->AdminInfo->setSource('admin_info');
            // 未読メッセージ件数
            $new_count = $this->MessageMember->find('count', array('conditions' => array('class' => $selected_class,'kidoku_flag' => 0)));
            $this->set('new_count', $new_count);
            // 最終ログイン時刻
            $last_login = $this->LoginLogs->find('first', array('fields' => array('created'), 
                'conditions' => array('username' => $this->Auth->user('username'), 'status' => 'login'), 'order' => array('id' => 'desc')));
            if (!is_null($last_login['LoginLogs']['created'])) {
                $this->set('last_login', $last_login['LoginLogs']['created']);
            } else {
                $this->set('last_login', '');
            }
            // 受信メッセージ一覧の表示
            $this->paginate = array(
                'AdminInfo' => array(
                    'fields' => '*',
                    'limit' =>5,                        //1ページ表示できるデータ数の設定
                    'order' => array('id' => 'desc')  //データを降順に並べる
                )
            );
            $this->set('datas', $this->paginate('AdminInfo'));
            //$this->log($this->MessageMember->getDataSource()->getLog(), LOG_DEBUG);

            // POSTの場合
            if ($this->request->is('post')) {
                // 属性の変更
                $class = $this->request->data['class'];
                //$this->Session->setFlash($class);
                $this->set('selected_class', $class);
                $this->Session->write('selected_class', $class);
                $this->redirect('.');
            } else {
                $this->set('selected_class', $this->Session->read('selected_class'));
            }

	}
        
    /** メッセージの詳細を表示 **/
    public function detail($id = null) {
        // レイアウト関係
        $this->layout = "main";
        $this->set("title_for_layout","メッセージ内容 - 派遣管理システム");
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
        $username = $this->Auth->user('username');
        $this->set('username', $username);
        $name = $this->Auth->user('name_sei').' '.$this->Auth->user('name_mei');
        $this->set('user_name', $name);
        $this->set('selected_class', $this->Session->read('selected_class'));
        // テーブルの設定
        $this->AdminInfo->setSource('admin_info');
        // 既読フラグ: ユーザーIDのカンマ区切り
        // 既読ユーザーを読み込む
        $result = $this->AdminInfo->find('first', array('fields' => 'kidoku_user', 'conditions' => array('id' => $id)));
        $kidoku_user = $result['AdminInfo']['kidoku_user'];
        if (empty($kidoku_user)) {
            $user = $username;
        } else {
            //$sql = "SELECT id FROM admin_info WHERE FIND_IN_SET('".$username."', kidoku_user) AND id = ".$id;
            $count = $this->AdminInfo->find('count', array('conditions' => array(array('id' => $id), array('FIND_IN_SET('.$username.', kidoku_user)'))));
            //$count = $this->AdminInfo->query($sql);
            if ($count == 0) {
                $user = $kidoku_user.','.$username;
            } else {
                $user = $kidoku_user;
            }
        }
        //$this->log('$kidoku_user='.$kidoku_user, LOG_DEBUG);
        //$this->log('$username='.$username, LOG_DEBUG);
        //$this->log('$user='.$user, LOG_DEBUG);
        // 更新する内容を設定
        $data = array('AdminInfo' => array('id' => $id, 'kidoku_user' => $user));
        // 更新する項目（フィールド指定）
        $fields = array('kidoku_user');
        // 更新
        $this->AdminInfo->save($data, false, $fields);
        // 受信メッセージの内容表示
        $datas = $this->AdminInfo->find('first', array('conditions' => array('id' => $id)));
        //$this->log($this->MessageStaff->getDataSource()->getLog(), LOG_DEBUG);
        $this->set('data', $datas);
        // 宛先名の取得
        //$username = $datas['AdminInfo']['recipient_member'];
        //$result = $this->User->find('first', array('conditions' => array('User.username' => $username))); 
        //$this->log($this->User->getDataSource()->getLog(), LOG_DEBUG);
        //$name_member = $result['User']['name_sei'].' '.$result['User']['name_mei'];
        //$this->set('name_member', $name_member);

        // POSTの場合
        if ($this->request->is('post') || $this->request->is('put')) {
            //$this->log($this->request->data, LOG_DEBUG);
            if ($this->MessageMember->validates() == false) {
                exit();
            }
            // 属性の変更
            if (isset($this->request->data['class'])) {
                $class = $this->request->data['class'];
                //$this->Session->setFlash($class);
                $this->set('selected_class', $class);
                $this->Session->write('selected_class', $class);
            } else {
                
            }
        } else {
            
        }
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
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->validates() == false) {
                return null;
            }
            if (isset($this->request->data['submit'])) {
                // 閲覧権限の配列をカンマ区切りに
                $val = $this->setAuth($this->request->data['User']['auth']);
                $this->request->data['User']['auth'] = $val;
                
                // モデルの状態をリセットする
                $this->User->create();
                // データを登録する
                if ($this->User->save($this->request->data)) {
                    // 登録完了
                    $this->Session->setFlash('ユーザー登録を完了しました。');
                }

                // indexに移動する
                //$this->redirect(array('action' => 'index'));
            }
        }
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
                // ユーザー名前
                $name = $this->Auth->user('name_sei').' '.$this->Auth->user('name_mei');
                $this->set('user_name', $name);

                // 初期値設定
                $this->User->virtualFields = array('full_name' => "CONCAT(name_sei , ' ', name_mei)");
                $this->set('datas', $this->User->find('list', array('fields' => array('username','full_name'))));
                $this->set('value', '');

                // POSTの場合
                if ($this->request->is('post') || $this->request->is('put')) {
                    if ($this->User->validates() == false) {
                        return null;
                    }
                    if (isset($this->request->data['regist'])) {
                        // 閲覧権限の配列をカンマ区切りに
                        $val = $this->setAuth($this->request->data['User']['auth']);
                        $this->request->data['User']['auth'] = $val;

                        // モデルの状態をリセットする
                        //$this->User->create();
                        // データを登録する
                        if ($this->User->save($this->request->data)) {
                            // 表示データの保持（権限）
                            $value = explode(',', $this->request->data['User']['auth']);
                            $this->set('value', $value);
                            // 登録完了
                            $this->Session->setFlash('ユーザー情報を更新しました。');
                        }
                    } else {
                        // データのセット
                        if (!empty($this->request->data['User']['username'])) {
                            $this->request->data = $this->User->read(null, $this->request->data['User']['username']);
                            $value = explode(',', $this->request->data['User']['auth']);
                            $this->set('value', $value);
                            //$this->log($this->request->data);
                        } else {
                            $this->request->data = $this->User->read(null, $this->request->data['username']);
                            $value = explode(',', $this->request->data['User']['auth']);
                            $this->set('value', $value);
                        }
                    }
                } else {
                    // 登録していた値をセット
                    $this->request->data = $this->User->read(null, $id);
                    
                }
	}

	/**
	 * ユーザ一覧。
	 */
    public function view() {
        // レイアウト関係
        $this->layout = "log";
        $this->set("title_for_layout", $this->title_for_layout);
        $this->set("headline", 'ユーザー一覧');
        $this->set('getValue', $this->getValue());      // 項目テーブル

        $this->set('datas', $this->paginate('User'));
        
        // POSTの場合
        //if ($this->request->is('post') || $this->request->is('put') || $this->request->is('get')) {
        if ($this->request->is('post') || $this->request->is('put')) {
            // 削除処理
            if(isset($this->request->data['delete'])) {
                $id_array = array_keys($this->request->data['delete']);
                $id = $id_array[0];
                $sql = '';
                $sql = $sql.' DELETE FROM users';
                $sql = $sql.' WHERE username = '.$id;
                $this->User->query($sql);
                $this->redirect(array('action' => 'view')); 
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
                if ($this->request->data['User']['password'] != $this->request->data['User']['password2']) {
                    $this->Session->setFlash(__('パスワードが一致しません。'));
                } else {
                    // データを登録する
                    $this->User->save($this->request->data);
                    $this->Session->setFlash(__('パスワードは変更されました。'));

                    // indexに移動する
                    $this->redirect(array('action' => 'index'));
                }
            } else {
                $this->request->data = $this->User->read(null, $this->Auth->user('username'));    
            }
        }
        
	/**
	 * パスワードの変更
	 */
	public function passwd2($username = null){
            // レイアウト関係
            $this->layout = "sub";
            $this->set("title_for_layout","パスワード変更 - 派遣管理システム");
            
            // POSTの場合
            if ($this->request->is('post') || $this->request->is('put')) {
                if ($this->request->data['User']['password'] != $this->request->data['User']['password2']) {
                    $this->Session->setFlash(__('パスワードが一致しません。'));
                } else {
                    // データを登録する
                    $this->User->save($this->request->data);
                    $this->Session->setFlash(__('パスワードは変更されました。'));

                    // indexに移動する
                    //$this->redirect(array('action' => 'view'));
                }
            } else {
                $this->request->data = $this->User->read(null, $username);    
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
        $this->User->virtualFields = array('full_name' => "CONCAT(name_sei , ' ', name_mei)");
        $option = array();
        $option['recursive'] = -1; 
        $option['fields'] = array('User.username','User.full_name', 'Item.value'); 
        $option['joins'][] = array(
            'type' => 'LEFT',   //LEFT, INNER, OUTER
            'table' => 'item',
            'alias' => 'Item',    //下でPost.user_idと書くために
            'conditions' => '`User`.`area`=`Item`.`id`',
        );
        $option['conditions'] = array('Item.item' => 1);
        $this->set('datas', $this->User->find('list', $option));
            
        // ログイン認証
    	if ($this->request->is('post') || $this->request->is('put')) { 
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
                // 所属のセット
                $username = $this->Auth->user('username');
                $conditions = array('username' => $username);
                $result = $this->User->find('first', array('conditions' => $conditions));
                if (!empty($result['User']['auth'])) {
                    $first_class = explode(',', $result['User']['auth']);
                    $this->Session->write('selected_class', $first_class[1]);
                } else {
                    $this->Session->setFlash('権限がありません。');
                    $this->redirect($this->Auth->logout());
                }
                //$this->log($first_class[1]);
    
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
        // 所属のセッションを消す
        $this->Session->delete('selected_class');
        
    	$this->redirect($this->Auth->logout());
        //$this->redirect($this->Auth->redirect());
    	//eturn $this->flash('ログアウトしました。', '/users/index');
    }
    
    /*** 所有権限をカンマ区切りに ***/
    static public function setAuth($val){
        $ret = '';
        if (!empty($val)) {
            foreach ($val as $value) {
                $ret = $ret.','.$value;  
            }
        }
        return $ret;
    }
    
    // 項目マスタ
    public function getValue(){
        $conditions = null;
        $result = $this->Item->find('list', array('fields' => array('id', 'value', 'item'), 'conditions' => $conditions));
        //$this->log($result, LOG_DEBUG);
        
        return $result;
    } 

}