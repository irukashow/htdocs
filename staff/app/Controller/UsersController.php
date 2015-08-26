<?php

class UsersController extends AppController {
        public $uses = array('StaffMaster', 'User', 'Message2Staff', 'Message2Member', 'TimeCard', 'StaffSchedule', 'StaffLoginLog', 'StaffLog');
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
            } else {
                $this->set('class', $class);
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
            
            // POSTの場合
            if ($this->request->is('post') || $this->request->is('put')) {
                $this->log($this->request->data, LOG_DEBUG);
                // 送信
                // 添付ファイルのセット
                if (!empty($_FILES['attachment']['name'][0])) {
                    $this->request->data['Message2Member']['attachment'] = $_FILES['attachment']['name'][0];
                }
                // データを登録する
                if ($this->Message2Member->save($this->request->data)) {
                    //$this->log($this->MessageStaff->getDataSource()->getLog(), LOG_DEBUG);
                    $this->log($_FILES['attachment']['name'], LOG_DEBUG);
                    // insertした宛先メンバーIDを取得
                    $username0 = $this->request->data['Message2Member']['recipient_member'];
                    $username = sprintf("%07d", $username0);
                    $this->log($username, LOG_DEBUG);
                    //$this->log($this->request->data['Message2Member']['attachment'], LOG_DEBUG);
                    // ファイルアップロード処理の初期セット
                    $ds = DIRECTORY_SEPARATOR;  //1
                    $storeFolder = 'files/message/member'.$ds.$username.$ds;   //2
                    // ファイルのアップロード
                    if(!empty($_FILES['attachment']['name'][0])){
                        // ディレクトリがなければ作る
                        if ($this->chkDirectory($storeFolder, true) == false) {
                            $this->log('ファイルのアップロードに失敗しました。', LOG_DEBUG);
                            $this->redirect($this->referer());
                            exit();
                        }
                        $count = count($_FILES['attachment']['name']);
                        for ($i=0; $i<$count; $i++) {
                            $tempFile = $_FILES['attachment']['tmp_name'][$i];//3
                            $targetPath = $storeFolder.$ds;  //4
                            $targetFile =  $targetPath. mb_convert_encoding($_FILES['attachment']['name'][$i], 'sjis-win', 'UTF-8');  //5
                            //$targetFile =  $targetPath.$staff_id.'.'.$after;  //5
                            // ファイルアップ実行
                            if (move_uploaded_file($tempFile, $targetFile)) {
                                // アップの成功
                                $this->log('ファイルのアップロードに成功しました：'.$id, LOG_DEBUG);
                                $this->redirect(array('action'=>'message', 2));
                            } else {
                                // アップの失敗
                                $this->log('ファイルのアップロードに失敗しました。'.$id, LOG_DEBUG);
                            }
                        }
                    }
                    $this->Session->setFlash('送信処理を完了しました。');
                    if ($flag == 3) {
                        // 宛先配列
                        $this->User->virtualFields['name'] = 'CONCAT(User.name_sei, " ", User.name_mei)';
                        $list_member = $this->User->find('list', array('fields'=>array('username', 'name'), 'conditions'=>array('FIND_IN_SET('.$class.', auth)')));
                        $this->set('list_member', $list_member);
                        //$this->log($list_member, LOG_DEBUG);
                    }
                    //$this->redirect('index');
                }       
            // GETの場合
            } elseif ($this->request->is('get')) {
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
                            'conditions' => array('Message2Member.class' => $class, 'Message2Member.staff_id' => $id
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
                    // 宛先配列
                    $this->User->virtualFields['name'] = 'CONCAT(User.name_sei, " ", User.name_mei)';
                    $list_member = $this->User->find('list', array('fields'=>array('username', 'name'), 'conditions'=>array('FIND_IN_SET('.$class.', auth)')));
                    $this->set('list_member', $list_member);
                    //$this->log($list_member, LOG_DEBUG);
                }
            } else {

            } 
        }
        
        /** 受信メッセージの詳細を表示 **/
        public function message_detail($id = null) {
            // レイアウト関係
            $this->layout = "main";
            $this->set("title_for_layout","メッセージ内容 - スタッフ専用サイト");
            // ユーザー名前
            $staff_id = $this->Auth->user('staff_id');
            $this->set('staff_id', $staff_id);
            $name = $this->Auth->user('name_sei').' '.$this->Auth->user('name_mei');
            $this->set('user_name', $name);
            $class = $this->Session->read('class');
            $this->set('class', $class);
            // テーブルの設定
            $this->Message2Staff->setSource('message2staff');
            // 既読フラグ: 1
            // 更新する内容を設定
            $data = array('Message2Staff' => array('id' => $id, 'kidoku_flag' => 1));
            // 更新する項目（フィールド指定）
            $fields = array('kidoku_flag');
            // 更新
            if ($this->Message2Staff->save($data, false, $fields)) {
            }
            // 受信メッセージの内容表示
            $datas = $this->Message2Staff->find('first', array('conditions' => array('id' => $id)));
            //$this->log($this->MessageStaff->getDataSource()->getLog(), LOG_DEBUG);
            $this->set('data', $datas);

            // POSTの場合
            if ($this->request->is('post') || $this->request->is('put')) {
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
        
        /** 送信済メッセージの詳細を表示 **/
        public function message_detail_sent($id = null) {
            // レイアウト関係
            $this->layout = "main";
            $this->set("title_for_layout","メッセージ内容 - スタッフ専用サイト");
            // ユーザー名前
            $staff_id = $this->Auth->user('id');
            $this->set('staff_id', $staff_id);
            $name = $this->Auth->user('name_sei').' '.$this->Auth->user('name_mei');
            $this->set('user_name', $name);
            $class = $this->Session->read('class');
            if (empty($class)) {
                $this->redirect('logout');
            } else {
                $this->set('class', $class);
            }
            // テーブルの設定
            $this->Message2Member->setSource('message2member');
            //$this->MessageStaff->setSource('message_staff');
            // 送信済メッセージの内容表示
            $data = $this->Message2Member->find('first', array('conditions' => array('id' => $id)));
            //$this->log($this->MessageStaff->getDataSource()->getLog(), LOG_DEBUG);
            $this->set('data', $data);
            // 宛先名の取得
            $username = $data['Message2Member']['recipient_member'];
            $result = $this->User->find('first', array('conditions' => array('User.username' => $username)));
            //$this->log($result, LOG_DEBUG);
            //$this->log($this->User->getDataSource()->getLog(), LOG_DEBUG);
            $name_member = $result['User']['name_sei'].' '.$result['User']['name_mei'];
            //$this->log($name_member, LOG_DEBUG);
            $this->set('name_member', $name_member);

            // POSTの場合
            if ($this->request->is('post') || $this->request->is('put')) {

            } else {

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
                return;
            }
            $this->set('class', $class);
            // テーブル変更
            //$this->StaffMaster->setSource('staff_'.$class);
            //
            // POSTの場合
            if ($this->request->is('post') || $this->request->is('put')) {
                $this->log($this->request->data, LOG_DEBUG);
                $this->log($this->request->data['StaffSchedule'], LOG_DEBUG);
                
                // データを登録する
                if ($this->StaffSchedule->saveAll($this->request->data['StaffSchedule'])) {
                    //$this->log($this->StaffSchedule->getDataSource()->getLog(), LOG_DEBUG);
                    // スタッフのシフト希望登録履歴
                    //　
                    $this->redirect(array('controller' => 'users', 'action' => 'schedule'));
                } else {
                    $this->log('エラーが発生しました。', LOG_DEBUG);
                }
            } elseif ($this->request->is('get')) {
                //$this->log($this->request->data, LOG_DEBUG);
                // 登録していた値をセット
                if (empty($this->request->query['date'])) {
                    $date1 = date('Y-m');
                    $date2 = null;
                } else {
                    $date2 = $this->request->query['date'];
                    $date1 = $date2;
                }
                $this->Session->write('date2', $date2);

                for ($i=1; $i<=31; $i++) {
                    $data[$i] = $this->StaffSchedule->find('first', 
                            array('conditions'=>array('staff_id'=>$id, 'class'=>$class, 'work_date'=>$date1.'-'.sprintf("%02d", $i))));
                    if (!empty($data[$i])) {
                        $data[$i] = $data[$i]['StaffSchedule'];
                    }
                }
                //$this->log($data, LOG_DEBUG);
                $this->set('data', $data);
            } else {
                
            }
        }
        
	/**
	 * スケジュール（シフト希望）入力
	 */
	public function schedule_input($y = null, $m = null, $d = null){
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
            //$this->StaffSchedule->setSource('staff_schedules');

            // POSTの場合
            if ($this->request->is('post') || $this->request->is('put')) {
                $this->log($this->request->data, LOG_DEBUG);
                // データを登録する
                if ($this->StaffSchedule->save($this->request->data)) {
                    //$this->log($this->StaffSchedule->getDataSource()->getLog(), LOG_DEBUG);
                    // スタッフのシフト希望登録履歴
                    //　
                    $this->redirect(array('controller' => 'users', 'action' => 'schedule'));
                } else {
                    $this->log('エラーが発生しました。', LOG_DEBUG);
                }
            } else {
                // 日付セット
                $date1 = $y.'-'.sprintf("%02d", $m).'-'.sprintf("%02d", $d);
                $datetime = new DateTime($date1);
                $week = array("日", "月", "火", "水", "木", "金", "土");
                $w = (int)$datetime->format('w');
                $date2 = $y.'年'.$m.'月'. $d.'日（'.$week[$w].'）';
                $this->set('date1', $date1);
                $this->set('date2', $date2);
                // 登録していた値をセット
                //$this->log($this->StaffSchedule->find('first', array('conditions'=>array('staff_id'=>$id, 'class'=>$class, 'work_date'=>$date1))), LOG_DEBUG);
                $this->request->data = $this->StaffSchedule->find('first', array('conditions'=>array('staff_id'=>$id, 'class'=>$class, 'work_date'=>$date1)));
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
                if (empty($data)) {
                    $this->set('data', null);
                } else {
                    $this->set('data', $data['TimeCard']);
                }
            }
        }

	/**
	 * 勤務関連（タイムカード）
	 */
	public function work_timecard(){
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
                //$this->log($this->request->data, LOG_DEBUG);
                if (isset($this->request->data['input'])) {
                    $date_array = array_keys($this->request->data['input']);
                    $selected_date = $date_array[0];
                    $this->set('selected_date', $selected_date);
                    $this->redirect(array('controller' => 'users', 'action' => 'work_input', $selected_date));
                }
            } else {
                // 保存データの抽出
                if (empty($this->request->query['date'])) {
                    $date1 = date('Y').'-'.date('m');
                    $date2 = null;
                } else {
                    $date2 = $this->request->query['date'];
                    $date1 = $date2;
                }
                $this->Session->write('date2', $date2);

                for ($i=1; $i<=31; $i++) {
                    $data[$i] = $this->TimeCard->find('first', 
                            array('fields'=>array('*'), 'conditions'=>array('staff_id'=>$id, 'class'=>$class, 'work_date'=>$date1.'-'.sprintf("%02d", $i))));
                    if (!empty($data[$i])) {
                        $data[$i] = $data[$i]['TimeCard'];
                    }
                }
                $this->set('data', $data);
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

            // POSTの場合
            if ($this->request->is('post') || $this->request->is('put')) {
                if (isset($this->request->data['request'])) {
                    // データを登録する
                    if ($this->TimeCard->save($this->request->data)) {
                        $this->redirect(array('controller' => 'users', 'action' => 'work_timecard'));
                        $this->request->query['page'] = $this->Session->read('date');
                    }
                } elseif (isset($this->request->data['delete'])) {
                    $this->log($this->request->data, LOG_DEBUG);
                    // 削除処理
                    if ($this->TimeCard->delete($this->request->data['TimeCard']['id'])) {
                        // 成功
                        $this->redirect(array('controller' => 'users', 'action' => 'work_timecard'));
                    }
                }
            } else {
                // 指定日をセット
                $datetime = new DateTime($date);
                $week = array("日", "月", "火", "水", "木", "金", "土");
                $w = (int)$datetime->format('w');
                $date2 = $datetime->format('Y').'年'.$datetime->format('n').'月'.$datetime->format('j').'日（'.$week[$w].'）';
                $this->set('date1', $date);
                $this->set('date2', $date2);
                // 登録していた値をセット
                $this->request->data = $this->TimeCard->find('first', array('conditions'=>array('staff_id'=>$id, 'class'=>$class, 'work_date'=>$date)));
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
            $pref_arr = $this->Item->find('list', array('fields' => array('id', 'value'), 'conditions' => $conditions1));
            $this->set('pref_arr', $pref_arr);
            // メッセージ
            $this->set('message', $this->Session->read('message'));
            $this->Session->delete('message');
            
            $this->log($this->request->data, LOG_DEBUG);
            // POSTの場合
            if ($this->request->is('post') || $this->request->is('put')) {
                // プロフィールの種類
                if ($this->request->data['StaffMaster']['status'] == 1) {
                    $status = 1;
                } elseif ($this->request->data['StaffMaster']['status'] == 2) {
                    $status = 2;
                } elseif ($this->request->data['StaffMaster']['status'] == 3) {
                    $status = 3;
                }
                // データを登録する
                if ($this->StaffMaster->save($this->request->data)) {
                    // スタッフのプロフィール更新履歴
                    $this->setStaffLog(0, $class, $id, $name, 0, $status, $this->request->clientIp()); // プロフィール更新コード:1
                    //$this->redirect(array('action' => 'profile', 1));
                    $this->Session->write('message', 1);
                }
            } else {
                // 登録していた値をセット
                $this->request->data = $this->StaffMaster->find('first', array('conditions' => array('id' => $id)));
                //$this->request->data['StaffMaster']['zipcode'] = $this->request->data['StaffMaster']['zipcode1'].$this->request->data['StaffMaster']['zipcode2'];
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
        $this->set("title_for_layout","ログイン");
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
                    //$this->loadModel("LoginLog");  // ログイン履歴テーブル
                    $this->StaffLoginLog->create();
                    $log = array('class' => $cls, 'staff_id' => $this->Auth->user('id'), 
                        'staff_name' => $this->Auth->user('name_sei').' '.$this->Auth->user('name_mei'), 'user_agent' => $_SERVER['HTTP_USER_AGENT'],
                        'status' => $this->StaffLoginLog->status = 'login','ip_address' =>$this->request->clientIp(false));
                    $this->StaffLoginLog->save($log);
                    
                    $this->redirect($this->Auth->redirect());
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
        //$this->loadModel("LoginLog");  // ログイン履歴テーブル
        $this->StaffLoginLog->create();
        $log = array('class' => $this->Session->read('class'), 'staff_id' => $this->Auth->user('id'), 
            'staff_name' => $this->Auth->user('name_sei').' '.$this->Auth->user('name_mei'), 'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'status' => $this->StaffLoginLog->status = 'logout','ip_address' => $this->request->clientIp(false));
        $this->StaffLoginLog->save($log);
        // 所属のセッションを消す
        $this->Session->delete('selected_class');
        
    	$this->redirect($this->Auth->logout());
        //$this->redirect($this->Auth->redirect());
    	//eturn $this->flash('ログアウトしました。', '/users/index');
    }
    
  /*** ディレクトリの存在をチェック ***/
  static public function chkDirectory($dirpath,$create_flg = true){
    $return = false;
    if(file_exists($dirpath)){
      $return = true;
    }
    if(!$return){
      if($create_flg){
        mkdir($dirpath, 0777);
        chmod($dirpath, 0777);
      }
      $return = true;
    }
    return $return;
  }
  
    /** マスタ更新ログ書き込み **/
    public function setStaffLog($username, $class, $staff_id, $staff_name, $kaijo_flag, $status, $ip_address) {
        $sql = '';
        $sql = $sql. ' INSERT INTO staff_logs (username, class, staff_id, staff_name, kaijo_flag, status, ip_address, created)';
        $sql = $sql. ' VALUES ('.$username.', '.$class.', '.$staff_id.', "'.$staff_name.'", '.$kaijo_flag.', '.$status.', "'.$ip_address.'", now())';
        
        // sqlの実行
        $ret = $this->StaffLog->query($sql);
        
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