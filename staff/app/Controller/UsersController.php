<?php
class UsersController extends AppController {
        public $uses = array('StaffMaster', 'User', 'Message2Staff', 'Message2Member', 
            'TimeCard', 'StaffSchedule', 'StaffLoginLog', 'StaffLog', 'WkSchedule', 
            'CaseManagement', 'OrderCalender', 'WorkTable');
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
            $this->set('class', $class);
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
	 * スケジュール（シフト希望）
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
            $this->StaffMaster->setSource('staff_'.$class);
            $data3 = null;
            // 職種IDのセット
            $data = $this->StaffMaster->find('first', array('conditions'=>array('id'=>$id)));
            $shokushu_id = $data['StaffMaster']['shokushu_shoukai'];
            $this->set('shokushu_id', $shokushu_id);
            // 登録していた値をセット
            if (empty($this->request->query['date'])) {
                $date1 = date('Y-m', strtotime('+1 month'));
                $date2 = null;
            } else {
                $date2 = $this->request->query['date'];
                $date1 = $date2;
            }
            $this->Session->write('date2', $date2);
            $this->set('date1', $date1);
            if (empty($this->request->query['err'])) {
                $msg = '';
            } elseif ($this->request->query['err'] == 1) {
                $msg = '【情報】'.date('n月', strtotime($date1.'-01')).'の申請を完了いたしました。';
            } elseif ($this->request->query['err'] == 2) {
                $msg = '【エラー】申請時にエラーが発生しました。';
            } else {
                $msg = '';
            }
            $this->set('msg', $msg);

            // POSTの場合
            if ($this->request->is('post') || $this->request->is('put')) {
                $this->log($this->request->data, LOG_DEBUG);
                $this->log($this->request->data['StaffSchedule'], LOG_DEBUG);
                
                $this->Session->write('datas_schedule', $this->request->data['StaffSchedule']);
                $this->redirect(array('controller' => 'users', 'action' => 'schedule_confirm', '?date='.$date1));
            } elseif ($this->request->is('get')) {
                //$this->log($this->request->data, LOG_DEBUG);
                for ($i=1; $i<=31; $i++) {
                    $data2[$i] = $this->StaffSchedule->find('first', 
                            array('conditions'=>array('staff_id'=>$id, 'class'=>$class, 'work_date'=>$date1.'-'.sprintf("%02d", $i))));
                    if (!empty($data2[$i])) {
                        $data3[$i] = $data2[$i]['StaffSchedule'];
                    }
                }
                $this->log($data3, LOG_DEBUG);
                $this->set('data', $data3);
            } else {
                
            }
        }
        
	/**
	 * スケジュール（シフト希望）：編集
	 */
	public function schedule_edit(){
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
            $this->StaffMaster->setSource('staff_'.$class);
            $data3 = null;
            // 職種IDのセット
            $data = $this->StaffMaster->find('first', array('conditions'=>array('id'=>$id)));
            $shokushu_id = $data['StaffMaster']['shokushu_shoukai'];
            $this->set('shokushu_id', $shokushu_id);
            // 登録していた値をセット
            if (empty($this->request->query['date'])) {
                $date1 = date('Y-m', strtotime('+1 month'));
                $date2 = null;
            } else {
                $date2 = $this->request->query['date'];
                $date1 = $date2;
            }
            $this->Session->write('date2', $date2);
            $this->set('date1', $date1);
            if (empty($this->request->query['err'])) {
                $msg = '';
            } elseif ($this->request->query['err'] == 1) {
                $msg = '【情報】'.date('n月', strtotime($date1.'-01')).'の申請を完了いたしました。';
            } elseif ($this->request->query['err'] == 2) {
                $msg = '【エラー】申請時にエラーが発生しました。';
            } elseif ($this->request->query['err'] == 3) {
                $msg = '【エラー】△の日には、備考欄に理由をご記入ください。';
            } else {
                $msg = '';
            }
            $this->set('msg', $msg);

            // POSTの場合
            if ($this->request->is('post') || $this->request->is('put')) {
                $this->log($this->request->data, LOG_DEBUG);
                // チェック
                /**
                for($d=1; $d<=31; $d++) {
                    if ($this->request->data['StaffSchedule'][$d]['work_flag'] == 2) {
                        if (empty($this->request->data['StaffSchedule'][$d]['conditions'])) {
                            $this->redirect(array('controller' => 'users', '?date='.$date1.'&err=3'));
                            //$this->set('msg', '【エラー】△の日には、備考欄に理由をご記入ください。');
                            break;
                        }
                    }
                }
                 * 
                 */
                $this->Session->write('datas_schedule', $this->request->data['StaffSchedule']);
                $this->redirect(array('controller' => 'users', 'action' => 'schedule_confirm', '?date='.$date1));
                /**
                // データを登録する
                if ($this->StaffSchedule->saveAll($this->request->data['StaffSchedule'])) {
                    //$this->log($this->StaffSchedule->getDataSource()->getLog(), LOG_DEBUG);
                    // スタッフのシフト希望登録履歴
                    //　
                    $this->redirect(array('controller' => 'users', 'action' => 'schedule', '?date='.$date1.'&err=1'));
                } else {
                    $this->log('エラーが発生しました。', LOG_DEBUG);
                    $this->redirect(array('controller' => 'users', 'action' => 'schedule', '?date='.$date1.'&err=2'));
                }
                 * 
                 */
            } elseif ($this->request->is('get')) {
                //$this->log($this->request->data, LOG_DEBUG);
                for ($i=1; $i<=31; $i++) {
                    $data2[$i] = $this->StaffSchedule->find('first', 
                            array('conditions'=>array('staff_id'=>$id, 'class'=>$class, 'work_date'=>$date1.'-'.sprintf("%02d", $i))));
                    if (!empty($data2[$i])) {
                        $data3[$i] = $data2[$i]['StaffSchedule'];
                    }
                }
                $this->log($data3, LOG_DEBUG);
                $this->set('data', $data3);
            } else {
                
            }
        }

	/**
	 * スケジュール（シフト希望）
	 */
	public function schedule_confirm(){
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
            $this->StaffMaster->setSource('staff_'.$class);
            // 職種IDのセット
            $data = $this->StaffMaster->find('first', array('conditions'=>array('id'=>$id)));
            $shokushu_id = $data['StaffMaster']['shokushu_shoukai'];
            $this->set('shokushu_id', $shokushu_id);
            // 登録していた値をセット
            if (empty($this->request->query['date'])) {
                $date1 = date('Y-m', strtotime('+1 month'));
                $date2 = null;
            } else {
                $date2 = $this->request->query['date'];
                $date1 = $date2;
            }
            $this->Session->write('date2', $date2);
            $this->set('date1', $date1);
            // セッションの読み込み
            $datas = $this->Session->read('datas_schedule');
            $this->log($datas, LOG_DEBUG);
            $this->set('msg', null);
            
            // POSTの場合
            if ($this->request->is('post') || $this->request->is('put')) {
                $this->log($this->request->data, LOG_DEBUG);
                // データを登録する
                if ($this->StaffSchedule->saveAll($datas)) {
                    //$this->log($this->StaffSchedule->getDataSource()->getLog(), LOG_DEBUG);
                    // セッションの削除
                    //　
                    $this->redirect(array('controller' => 'users', 'action' => 'schedule', '?date='.$date1.'&err=1'));
                } else {
                    $this->log('エラーが発生しました。', LOG_DEBUG);
                    $this->redirect(array('controller' => 'users', 'action' => 'schedule', '?date='.$date1.'&err=2'));
                }
            } elseif ($this->request->is('get')) {
                if (empty($datas)) {
                    $this->log('エラーが発生しました。', LOG_DEBUG);
                    $this->redirect(array('controller' => 'users', 'action' => 'schedule', '?date='.$date1.'&err=2'));
                } else {
                    $this->set('data', $datas);
                }
            } else {
                
            }
        }
        
	/**
	 * スケジュール（確定シフト）
	 */
	public function schedule2(){
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
            $this->StaffMaster->setSource('staff_'.$class);
            $this->WkSchedule->setSource('wk_schedules');
            // 職種IDのセット
            $data = $this->StaffMaster->find('first', array('conditions'=>array('id'=>$id)));
            $shokushu_id = $data['StaffMaster']['shokushu_shoukai'];
            $this->set('shokushu_id', $shokushu_id);
            // 職種マスタ配列
            $conditions0 = array('item' => 17);
            $shokushu_arr = $this->Item->find('list', array('fields' => array('id', 'value'), 'conditions' => $conditions0));
            $this->set('shokushu_arr', $shokushu_arr);
            // 案件リスト
            $conditions1 = array('class'=>$class);
            $list_case2 = $this->CaseManagement->find('list', array('fields'=>array('id', 'case_name'), 'conditions'=>$conditions1, 'order'=>array('sequence'=>'asc')));
            $list_case2 += array(''=>'');
            $this->set('list_case2', $list_case2);
        
            // 登録していた値をセット
            if (empty($this->request->query['date'])) {
                $date1 = date('Y-m');
                $date2 = null;
            } else {
                $date2 = $this->request->query['date'];
                $date1 = $date2;
            }
            $this->Session->write('date2', $date2);
            $this->set('date1', $date1);

            // POSTの場合
            if ($this->request->is('post') || $this->request->is('put')) {
                $this->log($this->request->data, LOG_DEBUG);
                $this->log($this->request->data['StaffSchedule'], LOG_DEBUG);
                
                // データを登録する
                if ($this->WkSchedule->saveAll($this->request->data['StaffSchedule'])) {
                    //$this->log($this->StaffSchedule->getDataSource()->getLog(), LOG_DEBUG);
                    // スタッフのシフト希望登録履歴
                    //　
                    $this->redirect(array('controller' => 'users', 'action' => 'schedule', '?date='.$date1));
                } else {
                    $this->log('エラーが発生しました。', LOG_DEBUG);
                }
            } elseif ($this->request->is('get')) {
                //$this->log($this->request->data, LOG_DEBUG);
                $data2 = $this->WkSchedule->find('first', 
                        array('conditions'=>array('staff_id'=>$id, 'class'=>$class, 'month'=>$date1.'-01')));
                $this->log($data2, LOG_DEBUG);
                $this->set('data2', $data2);
            } else {
                
            }
        }
        
	/**
	 * スケジュール（スタッフシフト表）
	 */
	public function schedule3($case_id = null){
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
            $this->StaffMaster->setSource('staff_'.$class);
            $this->WkSchedule->setSource('wk_schedules');
            // 職種IDのセット
            $data = $this->StaffMaster->find('first', array('conditions'=>array('id'=>$id)));
            $shokushu_id = $data['StaffMaster']['shokushu_shoukai'];
            $this->set('shokushu_id', $shokushu_id);
            // 職種マスタ配列
            $conditions0 = array('item' => 17);
            $list_shokushu = $this->Item->find('list', array('fields' => array('id', 'value'), 'conditions' => $conditions0));
            $this->set('list_shokushu', $list_shokushu);
            // 案件リスト
            $conditions1 = array('class'=>$class);
            $list_case2 = $this->CaseManagement->find('list', array('fields'=>array('id', 'case_name'), 'conditions'=>$conditions1, 'order'=>array('sequence'=>'asc')));
            $list_case2 += array(''=>'');
            $this->set('list_case2', $list_case2);
            $this->set('case_id', $case_id);
        
            // 登録していた値をセット
            if (empty($this->request->query['date'])) {
                $date1 = date('Y-m');
                $date2 = null;
            } else {
                $date2 = $this->request->query['date'];
                $date1 = $date2;
            }
            $this->Session->write('date2', $date2);
            $this->set('date1', $date1);
            $y = date('Y', strtotime($date1.'-01'));
            $m = date('n', strtotime($date1.'-01'));
            // 案件あたりの職種数
            $conditions2 = array('class'=>$class, 'OrderCalender.year' => $y, 'OrderCalender.month' => $m, 'OrderCalender.case_id' => $case_id);
            $col = $this->OrderCalender->find('count', array('conditions' => $conditions2));
            $this->set('col', $col);
            // スタッフ配列
            $this->StaffMaster->virtualFields['name'] = 'CONCAT(name_sei, " ", name_mei)';
            $staff_arr = $this->StaffMaster->find('list', array('fields'=>array('id', 'name_sei')));
            $this->set('staff_arr', $staff_arr);

            // POSTの場合
            if ($this->request->is('post') || $this->request->is('put')) {
                $this->log($this->request->data, LOG_DEBUG);
                if (isset($this->request->data['changeCase'])) {
                    $case_id = $this->request->data['StaffSchedule']['case_id']; 
                    $this->redirect(array('action'=>'schedule3', $case_id, '?date='.$date1));
                }
            } elseif ($this->request->is('get')) {
                //$this->log($this->request->data, LOG_DEBUG);
                $data2 = $this->WkSchedule->find('first', 
                        array('conditions'=>array('staff_id'=>$id, 'class'=>$class, 'month'=>$date1.'-01')));
                //$this->log($data2, LOG_DEBUG);
                $case_arr = null;$case_arr2 = null;$case_arr3 = null;
                if (empty($data2)) {
                    
                } else {
                    for($d=1; $d<=31; $d++) {
                        $ret = $data2['WkSchedule']['c'.$d];
                        if (empty($ret)) {
                            continue;
                        }
                        $ret_arr = explode(',', $ret);
                        $case_arr[$d] = $ret_arr[0];
                    }
                    //$this->log($case_arr, LOG_DEBUG);
                    if (empty($case_arr)) {
                        $case_arr2 = null;
                    } else {
                        $case_arr2 = array_unique($case_arr);
                        foreach($case_arr2 as $value) {
                            $case_arr3[$value] = $list_case2[$value];
                        }
                    }
                }
                $this->set('case_arr', $case_arr3);
                $this->set('case_num', count($case_arr3));
                if (empty($case_id) && !empty($case_arr3)) {
                    reset($case_arr3);
                    $case_id = key($case_arr3);
                    $this->redirect(array('action'=>'schedule3', $case_id, '?date='.$date1));
                }
                // スタッフの抽出条件
                $joins = array(
                    array(
                        'type' => 'left',// innerもしくはleft
                        'table' => 'order_info_details',
                        'alias' => 'OrderInfoDetail',
                        'conditions' => array(
                            'WorkTable.order_id = OrderInfoDetail.order_id',
                            'WorkTable.shokushu_num = OrderInfoDetail.shokushu_num',
                        )    
                    )
                );
                $options = array(
                    'fields'=> array('WorkTable.*', 'OrderInfoDetail.*'),
                    'conditions' => array(
                        'WorkTable.class' => $class,
                        'WorkTable.month' => $date1.'-01',
                        'WorkTable.case_id' => $case_id,
                        'WorkTable.flag' => 1,
                        ),
                    'limit' => 20,
                    //'group' => array('staff_id'),
                    'joins' => $joins
                );
                // ページネーション
                $this->paginate = $options;
                $datas = $this->paginate('WorkTable');
                //$this->log($this->StaffSchedule->getDataSource()->getLog(), LOG_DEBUG);
                $this->set('datas', $datas);
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
	public function work_timecard($date = null){
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
                $this->log($this->request->data, LOG_DEBUG);
                if (isset($this->request->data['input'])) {
                    $date_array = array_keys($this->request->data['input']);
                    $selected_date = $date_array[0];
                    $this->set('selected_date', $selected_date);
                    $this->redirect(array('controller' => 'users', 'action' => 'work_input', $selected_date));
                }
            } else {
                // 保存データの抽出
                if (!empty ($date)) {
                    $date1 = $date;
                    $date2 = null;
                } elseif (!empty($this->request->query['date'])) {
                    $date2 = $this->request->query['date'];
                    $date1 = $date2;
                } else {
                    $date1 = date('Y').'-'.date('m');
                    $date2 = null;
                }
                $this->set('date1', $date1);
                $this->log($date1, LOG_DEBUG);
                $this->Session->write('date2', $date2);
                // タイムシートの保存済の情報
                for ($i=1; $i<=31; $i++) {
                    $data[$i] = $this->TimeCard->find('first', 
                            array('fields'=>array('*'), 'conditions'=>array('staff_id'=>$id, 'class'=>$class, 'work_date'=>$date1.'-'.sprintf("%02d", $i))));
                    if (!empty($data[$i])) {
                        $data[$i] = $data[$i]['TimeCard'];
                    }
                }
                $this->set('data', $data);              
                // 確定シフト
                $data2 = $this->WkSchedule->find('first', 
                        array('conditions'=>array('staff_id'=>$id, 'class'=>$class, 'month'=>$date1.'-01')));
                //$this->log($data2, LOG_DEBUG);
                $this->set('data2', $data2);
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
            // 案件リスト
            $conditions1 = array('class'=>$class);
            $list_case2 = $this->CaseManagement->find('list', array('fields'=>array('id', 'case_name'), 'conditions'=>$conditions1, 'order'=>array('sequence'=>'asc')));
            $list_case2 += array(''=>'');
            $this->set('list_case2', $list_case2);
            // 

            // POSTの場合
            if ($this->request->is('post') || $this->request->is('put')) {
                $this->log($this->request->data, LOG_DEBUG);
                if (isset($this->request->data['request'])) {
                    // データを登録する
                    if ($this->TimeCard->save($this->request->data)) {
                        $date3 = date('Y-m', strtotime($this->request->data['TimeCard']['work_date']));
                        $this->log($date3, LOG_DEBUG);
                        $this->redirect(array('controller' => 'users', 'action' => 'work_timecard', $date3));
                        //$this->request->query['page'] = $this->Session->read('date');
                    }
                } elseif (isset($this->request->data['delete'])) {
                    $this->log($this->request->data, LOG_DEBUG);
                    if (empty($this->request->data['TimeCard']['id'])) {
                        $this->redirect(array('controller' => 'users', 'action' => 'work_input', $this->request->data['TimeCard']['work_date']));
                        return null;
                    }
                    // 削除処理
                    if ($this->TimeCard->delete($this->request->data['TimeCard']['id'])) {
                        // 成功
                        $date3 = date('Y-m', strtotime($this->request->data['TimeCard']['work_date']));
                        $this->redirect(array('controller' => 'users', 'action' => 'work_timecard', $date3));
                    }
                }
            } else {
                if (!empty ($date)) {
                    $date1 = $date;
                    $date2 = null;
                } elseif (!empty($this->request->query['date'])) {
                    $date2 = $this->request->query['date'];
                    $date1 = $date2;
                } else {
                    $date1 = date('Y-m-d');
                    $date2 = null;
                }
                // 指定日をセット
                $datetime = new DateTime($date1);
                $week = array("日", "月", "火", "水", "木", "金", "土");
                $w = (int)$datetime->format('w');
                $date0 = $datetime->format('Y').'-'.$datetime->format('m').'-01';
                $date2 = $datetime->format('Y').'年'.$datetime->format('n').'月'.$datetime->format('j').'日（'.$week[$w].'）';
                $this->set('date1', $date1);
                $this->log($date, LOG_DEBUG);
                $this->set('date2', $date2);
                $date3 = date('Y-m', strtotime($date1));
                $this->set('date3', $date3);
                // 登録していた値をセット
                $this->request->data = $this->TimeCard->find('first', array('conditions'=>array('staff_id'=>$id, 'class'=>$class, 'work_date'=>$date1)));
                // 確定シフト
                $data2 = $this->WkSchedule->find('first', 
                        array('conditions'=>array('staff_id'=>$id, 'class'=>$class, 'month'=>$date0)));
                //$this->log($date, LOG_DEBUG);
                //$this->log($data2, LOG_DEBUG);
                $this->set('data2', $data2);
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
            $flag = 0;
            $this->set('flag', $flag);
            // メッセージ
            $this->set('message', $this->Session->read('message'));
            $this->Session->delete('message');
            
            $this->log($this->request->data, LOG_DEBUG);
            $koushin1 = 0;$koushin2 = 0;$koushin3 = 0;$koushin4 = 0;
            // POSTの場合
            if ($this->request->is('post') || $this->request->is('put')) {
                // プロフィールの種類
                if ($this->request->data['StaffMaster']['status'] == 1) {
                    $status = 1;
                    $this->request->data['StaffMaster']['koushin_flag1'] = 1;
                } elseif ($this->request->data['StaffMaster']['status'] == 2) {
                    $status = 2;
                    $this->request->data['StaffMaster']['koushin_flag2'] = 1;
                } elseif ($this->request->data['StaffMaster']['status'] == 3) {
                    $status = 3;
                    $this->request->data['StaffMaster']['koushin_flag3'] = 1;
                } elseif ($this->request->data['StaffMaster']['status'] == 4) {
                    $status = 4;
                    $this->request->data['StaffMaster']['koushin_flag4'] = 1;
                }
                
                // データを登録する
                if ($this->StaffMaster->save($this->request->data)) {
                    // スタッフのプロフィール更新履歴
                    $this->setStaffLog(0, $class, $id, $name, 0, $status, $this->request->clientIp()); // プロフィール更新コード:1
                    //$this->redirect(array('action' => 'profile', 1));
                    //$this->Session->write('message', '<span style="color:red;">【情報】登録が完了しました。</span>');
                    $flag = 1;
                }
                $this->set('flag', $flag);
            } else {
                // 登録していた値をセット
                $this->request->data = $this->StaffMaster->find('first', array('conditions' => array('id' => $id)));
                $data = $this->request->data;
                $this->set('data', $data);
                $this->log($this->request->data, LOG_DEBUG);
                //$this->request->data['StaffMaster']['zipcode'] = $this->request->data['StaffMaster']['zipcode1'].$this->request->data['StaffMaster']['zipcode2'];
            }

	}

    /**
     * アカウント問い合わせ
     */
    public function account(){
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
        $flag = 0;
        $this->set('data', null);
        $this->set('msg', null);
        
        $this->log($this->request->data, LOG_DEBUG);
        // ログイン認証
    	if ($this->request->is('post') || $this->request->is('put')) {
            if (empty($this->request->data['StaffMaster']['email']) || empty($this->request->data['StaffMaster']['birthday'])) {
                $this->set('msg', '【エラー】未入力項目があります。');
                return;
            }
            foreach ($class as $cls) {
                // テーブルの設定
                $this->StaffMaster->setSource('staff_'.$cls);
                // ユーザー名に「＠」を使用できないという前提でusernameに「＠」を含んでいる場合はemail認証
                $address = $this->request->data['StaffMaster']['email'];
                $result = $this->StaffMaster->find('first', array('conditions'=>array('OR'=>array('email1'=>$address, 'email2'=>$address))));
                if (!empty($result)) {
                    $flag = 1;
                    if ($result['StaffMaster']['birthday'] == date('Y-m-d', strtotime($this->request->data['StaffMaster']['birthday']))) {
                        $this->set('class', $cls);
                        $this->set('data', $result);
                    } else {
                        $this->Session->setFlash('【エラー】生年月日が異なります。');
                        $this->set('msg', '【エラー】生年月日が異なります。');
                    }
                    break;
                }
            }
            if ($flag == 0) {
                $this->Session->setFlash('【エラー】メールアドレスが存在しません。');
                $this->set('msg', '【エラー】メールアドレスが存在しません。');
            }
        } else {
            
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
        $flag = 0;
        $this->set('flag', $flag);
        
        $this->log($this->request->data, LOG_DEBUG);
        // ログイン認証
    	if ($this->request->is('post') || $this->request->is('put')) {
            $flag = 1;
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
                    $flag = 0;
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
            if ($flag == 1) {
                // ログイン処理失敗
                $this->Session->setFlash('アカウントもしくはパスワードに誤りがあります。');
                $this->set('flag', $flag);
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