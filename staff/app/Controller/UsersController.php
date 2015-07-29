<?php

class UsersController extends AppController {
        public $uses = array('StaffMaster', 'User', 'Message2Staff', 'Message2Member', 'TimeCard');
        // タイトル
        public $title_for_layout = "ホーム - 派遣管理システム";
        /****認証周り*****/
        public $components = array(
            'Auth' => array( //ログイン機能を利用する
                    'authenticate' => array(
                            'Form' => array(
                                    'userModel' => 'StaffMaster',
                                    'fields' => array('username' => 'account', 'password' => 'password')
                            )
                    ),
                    //ログイン後の移動先
                    'loginRedirect' => array('controller' => 'users', 'action' => 'index'),
                    //ログアウト後の移動先
                    'logoutRedirect' => array('controller' => 'users', 'action' => 'login'),
                    //ログインページのパス
                    'loginAction' => array('controller' => 'users', 'action' => 'login'),
                    //未ログイン時のメッセージ
                    'authError' => 'あなたのお名前とパスワードを入力して下さい。',
            )
        );
        
	/**
	 * index
	 */
	public function index(){
            // レイアウト関係
            $this->layout = "main";
            $this->set("title_for_layout",$this->title_for_layout);
            // ユーザー名前
            $id = $this->Auth->user('id');
            $this->set('id', $id);
            $name = $this->Auth->user('name_sei').' '.$this->Auth->user('name_mei');
            $this->set('name', $name);
            $class = $this->Session->read('class');
            if (empty($class)) {
                $this->redirect('logout');
            }
            // テーブル変更
            $this->StaffMaster->setSource('staff_'.$class);
            // 都道府県のセット
            if (substr($class, 0 ,1) == 1) {
                // 大阪（関西地方）
                $conditions1 = array('item' => 10, 'AND' => array('id >= ' => 24, 'id <= ' => 30));
            } elseif (substr($class, 0, 1) == 2) {
                // 東京（関東地方）
                $conditions1 = array('item' => 10, 'AND' => array('id >= ' => 8, 'id <= ' => 14));
            } elseif (substr($class, 0, 1) == 3) {
                // 名古屋（中部地方）
                $conditions1 = array('item' => 10, 'AND' => array('id >= ' => 15, 'id <= ' => 24));
            }
            $pref_arr = $this->Item->find('list', array('fields' => array( 'id', 'value'), 'conditions' => $conditions1));
            $this->set('pref_arr', $pref_arr);
            
            $this->log($this->request->data, LOG_DEBUG);
            // POSTの場合
            if ($this->request->is('post') || $this->request->is('put')) {
                // データを登録する
                if ($this->StaffMaster->save($this->request->data)) {
                    // スタッフのプロフィール更新履歴
                    //
                    //$this->redirect(array('controller' => 'users', 'action' => 'index#page4'));
                }
            } else {
                // 登録していた値をセット
                $this->request->data = $this->StaffMaster->find('first', array('conditions'=>array('id'=>$id)));
                //$this->request->data['StaffMaster']['zipcode'] = $this->request->data['StaffMaster']['zipcode1'].$this->request->data['StaffMaster']['zipcode2'];
            }

	}
        
	/**
	 * メッセージ
	 */
	public function message($flag = null){
            // レイアウト関係
            $this->layout = "main";
            $this->set("title_for_layout",$this->title_for_layout);
            // ユーザー名前
            $id = $this->Auth->user('id');
            $this->set('id', $id);
            $name = $this->Auth->user('name_sei').' '.$this->Auth->user('name_mei');
            $this->set('name', $name);
            $class = $this->Session->read('class');
            if (empty($class)) {
                $this->redirect('logout');
            }
            // テーブル変更
            $this->StaffMaster->setSource('staff_'.$class);
            $this->Message2Staff->setSource('message2staff');
            $this->Message2Member->setSource('message2member');

            // フラグ
            if (empty($flag)) {
                $flag = 1;
                $this->set('flag', 1);
            } else {
                $this->set('flag', $flag);
            }
            
            // GETの場合
            if ($this->request->is('get')) {
                if ($flag == 1) {
                    // メッセージ一覧の表示
                    $this->paginate = array(
                        'Message2Staff' => array(
                            'conditions' => array('Message2Staff.class' => $class, 'FIND_IN_SET('.$id.', Message2Staff.recipient_staff)', 'Message2Staff.sent_flag' => 1),
                            'fields' => 'Message2Staff.*',
                            'limit' =>10,                        //1ページ表示できるデータ数の設定
                            'order' => array('id' => 'desc'),  //データを降順に並べる 
                        )
                    );
                    $datas = $this->paginate('Message2Staff');
                    $this->set('datas', $datas);
                } elseif ($flag == 2) {
                    // 送信済みメッセージ一覧の表示
                    $this->paginate = array(
                        'Message2Member' => array(
                            'conditions' => array('Message2Member.class' => $class
                            //, 'Message2Member.staff_id' => $id
                            ),
                            'fields' => 'Message2Member.*, User.*',
                            'limit' =>10,                        //1ページ表示できるデータ数の設定
                            'order' => array('id' => 'desc'),  //データを降順に並べる
                            'joins' => array (
                                array (
                                    'type' => 'LEFT',
                                    'table' => 'users',
                                    'alias' => 'User',
                                    'conditions' => 'User.username = Message2Member.recipient_member' 
                                )
                            )  
                        )
                    );
                    $this->set('datas', $this->paginate('Message2Member'));
                } elseif ($flag == 3) {
                    
                }
                
            } 
        }
        
	/**
	 * 勤務関連
	 */
	public function work(){
            // レイアウト関係
            $this->layout = "main";
            $this->set("title_for_layout",$this->title_for_layout);
            // ユーザー名前
            $id = $this->Auth->user('id');
            $this->set('id', $id);
            $name = $this->Auth->user('name_sei').' '.$this->Auth->user('name_mei');
            $this->set('name', $name);
            $class = $this->Session->read('class');
            if (empty($class)) {
                $this->redirect('logout');
            }
            // テーブル変更
            $this->TimeCard->setSource('time_cards');
            
            // POSTの場合
            if ($this->request->is('post') || $this->request->is('put')) {
                if (isset($this->request->data['input'])) {
                    $date_array = array_keys($this->request->data['input']);
                    $selected_date = $date_array[0];
                    //$this->set('selected_date', $selected_date);
                    $this->redirect(array('controller' => 'users', 'action' => 'work_input', $selected_date));
                }
            } else {
                // 保存データの抽出
                $now_year = date("Y"); // 現在の年を取得
                $now_month = date("n"); // 在の月を取得
                //$now_day = date("j"); // 現在の日を取得
                $date1 = $now_year.sprintf('%02d', $now_month).'01';
                $date2 = $now_year.sprintf('%02d', $now_month).'31';
                $data = $this->TimeCard->find('first', array('conditions'=>array('staff_id'=>$id, 'class'=>$class, 'work_date >= '=>$date1, 'work_date <= '=>$date2)));
                //$this->log($data['TimeCard'], LOG_DEBUG);
                $this->set('data', $data['TimeCard']);
                
            }
        }
  
	/**
	 * 勤務関連の入力アクション
	 */
	public function work_input($date = null){
            // レイアウト関係
            $this->layout = "main";
            $this->set("title_for_layout",$this->title_for_layout);
            // ユーザー名前
            $id = $this->Auth->user('id');
            $this->set('id', $id);
            $name = $this->Auth->user('name_sei').' '.$this->Auth->user('name_mei');
            $this->set('name', $name);
            $class = $this->Session->read('class');
            if (empty($class)) {
                $this->redirect('logout');
            } else {
                $this->set('class', $class);
            }
            // テーブル変更
            $this->TimeCard->setSource('time_cards');
            $this->log($date, LOG_DEBUG);
            // 指定日をセット
            $now_year = date("Y"); // 現在の年を取得
            $now_month = date("n"); // 在の月を取得
            //$now_day = date("j"); // 現在の日を取得
            $date1 = $now_year.'-'.sprintf('%02d', $now_month).'-'.sprintf('%02d', $date);
            $datetime = new DateTime($date1);
            $week = array("日", "月", "火", "水", "木", "金", "土");
            $w = (int)$datetime->format('w');
            $date2 = $now_year.'年'.$now_month.'月'.$date.'日（'.$week[$w].'）';
            $this->set('date1', $date1);
            $this->set('date2', $date2);
            
            // POSTの場合
            if ($this->request->is('post') || $this->request->is('put')) {
                // データを登録する
                if ($this->TimeCard->save($this->request->data)) {
                    // スタッフのプロフィール更新履歴
                    //
                    $this->redirect(array('controller' => 'users', 'action' => 'work'));
                }
            } else {
                // 登録していた値をセット
                $this->request->data = $this->TimeCard->find('first', array('conditions'=>array('staff_id'=>$id, 'class'=>$class, 'work_date'=>$date1)));
            }
        }
        
	/**
	 * プロファイル
	 */
	public function profile(){
            // レイアウト関係
            $this->layout = "main";
            $this->set("title_for_layout",$this->title_for_layout);
            // ユーザー名前
            $id = $this->Auth->user('id');
            $this->set('id', $id);
            $name = $this->Auth->user('name_sei').' '.$this->Auth->user('name_mei');
            $this->set('name', $name);
            $class = $this->Session->read('class');
            if (empty($class)) {
                $this->redirect('logout');
            }
            // テーブル変更
            $this->StaffMaster->setSource('staff_'.$class);
            // 都道府県のセット
            if (substr($class, 0 ,1) == 1) {
                // 大阪（関西地方）
                $conditions1 = array('item' => 10, 'AND' => array('id >= ' => 24, 'id <= ' => 30));
            } elseif (substr($class, 0, 1) == 2) {
                // 東京（関東地方）
                $conditions1 = array('item' => 10, 'AND' => array('id >= ' => 8, 'id <= ' => 14));
            } elseif (substr($class, 0, 1) == 3) {
                // 名古屋（中部地方）
                $conditions1 = array('item' => 10, 'AND' => array('id >= ' => 15, 'id <= ' => 24));
            }
            $pref_arr = $this->Item->find('list', array('fields' => array( 'id', 'value'), 'conditions' => $conditions1));
            $this->set('pref_arr', $pref_arr);
            
            $this->log($this->request->data, LOG_DEBUG);
            // POSTの場合
            if ($this->request->is('post') || $this->request->is('put')) {
                // データを登録する
                if ($this->StaffMaster->save($this->request->data)) {
                    // スタッフのプロフィール更新履歴
                    //
                    //$this->redirect(array('controller' => 'users', 'action' => 'index#page4'));
                }
            } else {
                // 登録していた値をセット
                $this->request->data = $this->StaffMaster->find('first', array('conditions'=>array('id'=>$id)));
                //$this->request->data['StaffMaster']['zipcode'] = $this->request->data['StaffMaster']['zipcode1'].$this->request->data['StaffMaster']['zipcode2'];
            }

	}
        
	/**
	 * スケジュール
	 */
	public function schedule(){
            // レイアウト関係
            $this->layout = "main";
            $this->set("title_for_layout",$this->title_for_layout);
            // ユーザー名前
            $id = $this->Auth->user('id');
            $this->set('id', $id);
            $name = $this->Auth->user('name_sei').' '.$this->Auth->user('name_mei');
            $this->set('name', $name);
            $class = $this->Session->read('class');
            if (empty($class)) {
                $this->redirect('logout');
            }
            // テーブル変更
            $this->StaffMaster->setSource('staff_'.$class);
            
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
                    $this->log($this->request, LOG_DEBUG);
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
        $this->layout = "main";
        $this->set("title_for_layout","スタッフ専用サイト");
        // 所属の配列
        $class = array('11', '12', '21', '22', '31', '32');
        
        // 初期値設定
        //$this->StaffMaster->virtualFields = array('full_name' => "CONCAT(name_sei , ' ', name_mei)");
        //$this->set('datas', $this->StaffMaster->find('list', array('fields' => array('username', 'full_name'))));
        $flag = false;
        
        $this->log($this->request->data, LOG_DEBUG);
        // ログイン認証
    	if ($this->request->is('post') || $this->request->is('put')) {
            foreach ($class as $cls) {
                // テーブルの設定
                $this->StaffMaster->setSource('staff_'.$cls);
                // ユーザー名に「＠」を使用できないという前提でusernameに「＠」を含んでいる場合はemail認証
                if (strstr( $this->request->data['StaffMaster']['account'], '@' ) ) {
                    $this->request->data['StaffMaster']['email1'] = $this->request->data['StaffMaster']['account'];
                    $this->Auth->authenticate['Form']['fields']['email1'] = 'email1';
                    $this->log('ここを通っている', LOG_DEBUG);
                } else {
                    $this->Auth->authenticate['Form']['fields']['email1'] = 'account';
                }
                // Authコンポーネントのログイン処理を呼び出す。
                if($this->Auth->login()){
                    // ログイン処理成功
                    $this->Session->setFlash('認証に成功しました。');
                    $this->log('認証に成功しました。', LOG_DEBUG);
                    $flag = true;
                    // 所属をセッションに
                    $this->Session->write('class', $cls);
                    // ログイン履歴
                    /**
                    $this->loadModel("LoginLog");  // ログイン履歴テーブル
                    $this->LoginLog->create();
                    $log = array('username' => $this->Auth->user('username'),
                        'status' => $this->LoginLog->status = 'login','ip_address' =>$this->request->clientIp(false));
                    $this->LoginLog->save($log);
                     * 
                     */
                    
                    $this->redirect($this->Auth->redirect());
                    return;
                }else{

                }
            }
            if ($flag == false) {
                // ログイン処理失敗
                $this->Session->setFlash('アカウントもしくはパスワードに誤りがあります。');
                $this->log('認証に失敗しました。', LOG_DEBUG);
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
    
    // 日付から曜日を計算
    public function getWeekday($val) {

    }

}