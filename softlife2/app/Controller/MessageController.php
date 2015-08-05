<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

/**
 * CakePHP MailController
 * @author M-YOKOI
 */
class MessageController extends AppController {
    public $uses = array('Message2Member', 'Message2Staff', 'StaffMaster', 'User');

    public function index($type = null) {
        // レイアウト関係
        $this->layout = "main";
        $this->set("title_for_layout","メッセージ一覧 - 派遣管理システム");
        // タブの状態
        $this->set('active1', '');
        $this->set('active2', 'active');
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
        $username = $this->Auth->user('username');
        $this->set('user_name', $name);
        $selected_class = $this->Session->read('selected_class');
        $this->set('type', $type);
        // テーブルの設定
        $this->Message2Member->setSource('message2member');
        $this->Message2Staff->setSource('message2staff');
        $this->StaffMaster->setSource('staff_'.$selected_class);

        if (empty($type) || $type == 'trashbox') {
            if (empty($type)) {
                $delete_flag = 0;
            } else {
                $delete_flag = 1;
            }
            // 受信メッセージ一覧の表示
            $this->paginate = array(
                'Message2Member' => array(
                    'conditions' => array('Message2Member.class' => $selected_class, 'Message2Member.recipient_member' => $username, 'Message2Member.delete_flag' => $delete_flag),
                    'fields' => 'Message2Member.*, User.*',
                    'limit' =>15,                        //1ページ表示できるデータ数の設定
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
            $this->set('datas', $this->paginate());
        //$this->log($this->Message2Member->getDataSource()->getLog(), LOG_DEBUG);
        } elseif ($type == 'send' || $type == 'draft') {
            // 送信済みか下書きか
            if ($type == 'send') {
                $sent_flag = 1;
                $delete_flag = 0;
            } elseif ($type == 'draft') {
                $sent_flag = 0;
                $delete_flag = 0;
            }
            // メッセージ一覧の表示
            $this->paginate = array(
                'Message2Staff' => array(
                    'conditions' => array('Message2Staff.class' => $selected_class, 'Message2Staff.username' => $username, 'Message2Staff.sent_flag' => $sent_flag,  'Message2Staff.delete_flag' => $delete_flag),
                    'fields' => 'Message2Staff.*, StaffMaster.*',
                    'limit' =>15,                        //1ページ表示できるデータ数の設定
                    'order' => array('id' => 'desc'),  //データを降順に並べる
                    'joins' => array (
                        array (
                            'type' => 'LEFT',
                            'table' => 'staff_'.$selected_class,
                            'alias' => 'StaffMaster',
                            'conditions' => 'StaffMaster.id = Message2Staff.recipient_staff' 
                        )
                    )  
                )
            );
            $datas = $this->paginate('Message2Staff');
            $this->set('datas', $datas);
            //$this->log($this->Message2Staff->getDataSource()->getLog(), LOG_DEBUG);
            //$this->log($this->paginate(), LOG_DEBUG);
        }
        // 未読メッセージ件数
        $this->Message2Member->setSource('message2member');
        $new_count = $this->Message2Member->find('count', array('conditions' => array('class' => $selected_class, 'recipient_member' => $username, 'kidoku_flag' => 0)));
        $this->set('new_count', $new_count);
        // 下書きメッセージ件数
        $this->Message2Staff->setSource('message2staff');
        $draft_count = $this->Message2Staff->find('count', array('conditions' => array('class' => $selected_class, 'recipient_member' => $username, 'sent_flag' => 0)));
        $this->set('draft_count', $draft_count);
        
        //$this->log($this->request->data, LOG_DEBUG);
        // POSTの場合
        if ($this->request->is('post') || $this->request->is('put')) {
            if (isset($this->request->data['2trashbox'])) {
                $result = $this->request->data['check'];
                foreach ($result as $key => $val) {
                    //$this->log($key.'=>'.$val, LOG_DEBUG);
                    if ($val == 1) {
                        // ゴミ箱行き処理($keyを消す)
                        $data = array('Message2Member' => array('id' => $key, 'delete_flag' => 1));
                        $fields = array('delete_flag');
                        // 更新
                        $this->Message2Member->save($data, false, $fields);
                    }
                }
                $this->redirect('.');
            } elseif (isset($this->request->data['delete'])) {
                $result = $this->request->data['check'];
                foreach ($result as $key => $val) {
                    //$this->log($key.'=>'.$val, LOG_DEBUG);
                    if ($val == 1) {
                        // 削除
                        if ($type == 'send') {
                            // ゴミ箱行き処理($keyを消す)
                            $data = array('Message2Staff' => array('id' => $key, 'delete_flag' => 2));
                            $fields = array('delete_flag');
                            // 更新
                            $this->Message2Staff->save($data, false, $fields);
                            //$this->Message2Staff->delete($key);
                        } elseif ($type == 'draft') {
                            $this->Message2Staff->delete($key);
                        } elseif ($type == 'trashbox') {
                            // ゴミ箱行き処理($keyを消す)
                            $data = array('Message2Member' => array('id' => $key, 'delete_flag' => 2));
                            $fields = array('delete_flag');
                            // 更新
                            $this->Message2Member->save($data, false, $fields);
                            //$this->Message2Member->delete($key);
                        }
                    }
                }
                if ($type == 'draft') {
                    $this->redirect('index/draft');
                } elseif ($type == 'send') {
                    $this->redirect('index/send');
                } elseif ($type == 'trashbox') {
                    $this->redirect('index/trashbox');
                }
            } else {
                // 属性の変更
                $class = $this->request->data['class'];
                $this->set('selected_class', $class);
                $this->Session->write('selected_class', $class);
                //$this->log($class, LOG_DEBUG);
                $this->redirect('.');
            }
        } else {
            $this->set('selected_class', $selected_class);
        }
    }
    /** メッセージを送信 **/
    public function send($id = null) {
        // レイアウト関係
        $this->layout = "main";
        $this->set("title_for_layout","メッセージ作成 - 派遣管理システム");
        // タブの状態
        $this->set('active1', '');
        $this->set('active2', 'active');
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
        $selected_class = $this->Session->read('selected_class');
        $this->set('selected_class', $selected_class);
        // テーブルの設定
        $this->Message2Staff->setSource('message2staff');
        $this->StaffMaster->setSource('staff_'.$selected_class);
        // スタッフの配列
        $this->StaffMaster->virtualFields['name'] = 'CONCAT(id, "： ", name_sei, " ", name_mei)';
        $staff_array = $this->StaffMaster->find('list', array('fields' => array('id', 'name')));
        $this->set('staff_array', $staff_array);
        $this->set('recipient_staff', null);
        $recipient_staff = null;
        $recipient_staff_list = null;

        // POSTの場合
        if ($this->request->is('post') || $this->request->is('put')) {
            //$this->log($this->request->data, LOG_DEBUG);
            // 属性の変更
            if (isset($this->request->data['class'])) {
                $class = $this->request->data['class'];
                //$this->Session->setFlash($class);
                $this->set('selected_class', $class);
                $this->Session->write('selected_class', $class);
                $this->redirect('send');
            // 検索
            } elseif (isset($this->request->data['search'])) {
                $search_staff_name = $this->request->data['Message2Staff']['search_staff_name'];
                $keyword = mb_convert_kana($search_staff_name, 's');
                $ary_keyword = preg_split('/[\s]+/', $keyword, -1, PREG_SPLIT_NO_EMPTY);
                $conditions2 = null;
                foreach( $ary_keyword as $val ){
                    // 検索条件を設定するコードをここに書く
                    $conditions2[] = array('CONCAT(StaffMaster.name_sei, StaffMaster.name_mei) LIKE ' => '%'.$val.'%');
                }

                // 宛先を戻す
                $staff_ids = $this->request->data['Message2Staff']['recipient_staff'];
                if (!empty($staff_ids)) {
                    foreach($staff_ids as $id) {
                        $recipient_staff[$id] = $staff_array[$id];
                    }
                    $this->set('recipient_staff', $recipient_staff);
                }
                // スタッフリスト
                $staff_lists = $this->request->data['Message2Staff']['recipient_staff_list'];
                if (empty($staff_lists)) {
                    // スタッフの配列
                    $this->StaffMaster->virtualFields['name'] = 'CONCAT(id, "： ", name_sei, " ", name_mei)';
                    $staff_array = $this->StaffMaster->find('list', array('fields' => array('id', 'name'), 'conditions' => $conditions2));
                    $this->set('staff_array', $staff_array);
                } else {
                    foreach($staff_lists as $val) {
                        $recipient_staff_list[$val] = $staff_array[$val];
                    }
                    $this->set('staff_array', $recipient_staff_list);
                }
            // 下書き
            } elseif (isset($this->request->data['draft'])) {
                // 宛先の配列をカンマ区切りに
                $this->request->data['Message2Staff']['recipient_staff'] = implode(',', $this->request->data['Message2Staff']['recipient_staff']);
                // 送信済みフラグ：0
                $this->request->data['Message2Staff']['sent_flag'] = 0;
                // データを登録する
                if ($this->Message2Staff->save($this->request->data)) {
                    $this->Session->setFlash('下書き保存しました。');
                    $this->redirect('index');
                }    
            // 送信
            } elseif (isset($this->request->data['send'])) {
                // 宛先の配列をカンマ区切りに
                $this->request->data['Message2Staff']['recipient_staff'] = implode(',', $this->request->data['Message2Staff']['recipient_staff']);
                // 送信済みフラグ：１
                $this->request->data['Message2Staff']['sent_flag'] = 1;
                // 添付ファイル名称のセット
                if (!empty(array_filter($_FILES['attachment']['name']))) {
                    $this->request->data['Message2Staff']['attachment'] = implode(',', $_FILES['attachment']['name']);
                }
                // データを登録する
                //$this->Message->create();
                if ($this->Message2Staff->save($this->request->data)) {
                    //$this->log($_FILES['attachment']['name'], LOG_DEBUG);
                    // insertした宛先メンバーIDを取得
                    $staff_id0 = $this->request->data['Message2Staff']['recipient_staff'];
                    $staff_id = sprintf("%010d", $staff_id0);
                    //$this->log($staff_id, LOG_DEBUG);
                    //$this->log($this->request->data['Message2Member']['attachment'], LOG_DEBUG);
                    // ファイルアップロード処理の初期セット
                    $ds = DIRECTORY_SEPARATOR;  //1
                    $storeFolder = 'files/message/staff'.$ds.$staff_id.$ds;   //2
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
                                //$this->redirect(array('action'=>'message', 2));
                            } else {
                                // アップの失敗
                                $this->log('ファイルのアップロードに失敗しました。'.$id, LOG_DEBUG);
                            }
                        }
                    }
                    $this->Session->setFlash('送信を完了しました。');
                    $this->redirect('index');
                }                
            // キャンセル
            } elseif (isset($this->request->data['cancel'])) {
                $this->redirect('index');
            }
        } else {
            // 登録していた値をセット
            $this->request->data = $this->Message2Staff->read(null, $id);
            if (!empty($this->request->data)) {
                // 宛先のカンマ区切りを配列に
                $this->request->data['Message2Staff']['recipient_staff'] = explode(',', $this->request->data['Message2Staff']['recipient_staff']);
                // 宛先を戻す
                $staff_ids = $this->request->data['Message2Staff']['recipient_staff'];
                if (!empty($staff_ids)) {
                    foreach($staff_ids as $id) {
                        $recipient_staff[$id] = $staff_array[$id];
                    }
                    $this->set('recipient_staff', $recipient_staff);
                }
            }
            
        }
    }

    /** メッセージの詳細を表示 **/
    public function detail($id = null) {
        // レイアウト関係
        $this->layout = "main";
        $this->set("title_for_layout","メッセージ内容 - 派遣管理システム");
        // タブの状態
        $this->set('active1', '');
        $this->set('active2', 'active');
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
        $this->Message2Member->setSource('message2member');
        //$this->MessageStaff->setSource('message_staff');
        // 既読フラグ: 1
        // 更新する内容を設定
        $data = array('Message2Member' => array('id' => $id, 'kidoku_flag' => 1));
        // 更新する項目（フィールド指定）
        $fields = array('kidoku_flag');
        // 更新
        if ($this->Message2Member->save($data, false, $fields)) {
        }
        // 受信メッセージの内容表示
        $datas = $this->Message2Member->find('first', array('conditions' => array('id' => $id)));
        //$this->log($this->MessageStaff->getDataSource()->getLog(), LOG_DEBUG);
        $this->set('data', $datas);
        // 宛先名の取得
        $username = $datas['Message2Member']['recipient_member'];
        $result = $this->User->find('first', array('conditions' => array('User.username' => $username))); 
        //$this->log($this->User->getDataSource()->getLog(), LOG_DEBUG);
        $name_member = $result['User']['name_sei'].' '.$result['User']['name_mei'];
        $this->set('name_member', $name_member);

        // POSTの場合
        if ($this->request->is('post') || $this->request->is('put')) {
            //$this->log($this->request->data, LOG_DEBUG);
            if ($this->Message2Member->validates() == false) {
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

    /** メッセージの詳細を表示（送信済み） **/
    public function detail2($id = null) {
        // レイアウト関係
        $this->layout = "main";
        $this->set("title_for_layout","メッセージ内容 - 派遣管理システム");
        // タブの状態
        $this->set('active1', '');
        $this->set('active2', 'active');
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
        $selected_class = $this->Session->read('selected_class');
        $this->set('selected_class', $selected_class);
        // テーブルの設定
        $this->Message2Staff->setSource('message2staff');

        // 送信済みメッセージの内容表示
        $datas = $this->Message2Staff->find('first', array('conditions' => array('id' => $id)));
        //$this->log($this->MessageStaff->getDataSource()->getLog(), LOG_DEBUG);
        $this->set('data', $datas);
        // 宛先の取得
        $staff_id = explode(',', $datas['Message2Staff']['recipient_staff']);
        $this->StaffMaster->setSource('staff_'.$selected_class);
        $staff_name = '';
        foreach ($staff_id as $id) {
            $result = $this->StaffMaster->find('first', array('conditions' => array('StaffMaster.id' => $id))); 
            //$this->log($this->User->getDataSource()->getLog(), LOG_DEBUG);
            if (empty($staff_name)) {
                $staff_name = '<font style="font-size: 110%;">'.$result['StaffMaster']['name_sei'].' '.$result['StaffMaster']['name_mei'].'</font> ('.$id.')';
            } else {
                $staff_name = $staff_name.', <font style="font-size: 110%;">'.$result['StaffMaster']['name_sei'].' '.$result['StaffMaster']['name_mei'].'</font> ('.$id.')';
            }
        }
        $this->set('staff_name', $staff_name);
        
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
    
    /** メッセージ送信（スタッフ用仮設ページ） **/
    public function staff() {
        // レイアウト関係
        $this->layout = "sub";
        $this->set("title_for_layout","メッセージ作成 - 派遣管理システム");
        // 仮想スタッフ情報
        $class = 11;
        $this->set('staff_class', $class);
        $this->set('staff_id', 11);
        $name = '京橋 華子';
        $this->set('name', $name);
        // 所属エリアの社員一覧
        $this->User->virtualFields['name'] = 'CONCAT(name_sei, " ", name_mei)';
        $selected_username = $this->User->find('list', 
                array('fields' => array('username', 'name'), 'conditions' => array('OR' => array(array('area' => substr($class, 0, 1)), array('area' => 99)))));
        $this->set('selected_username', $selected_username);
        // テーブルの設定
        $this->Message2Member->setSource('message2member');

        // POSTの場合
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->log($this->request->data, LOG_DEBUG);
            // 送信
            if (isset($this->request->data['send'])) {
                // ファイル名称を登録
                $val = '';
                foreach ($_FILES['attachment']['name'] as $name) {
                    $val = $val.','.$name;
                }
                $this->request->data['Message2Staff']['attachment'] = $val;
                // データを登録する
                if ($this->Message2Member->save($this->request->data)) {
                    //$this->log($this->MessageStaff->getDataSource()->getLog(), LOG_DEBUG);
                    //$this->log($this->request->params['form']['attachment'], LOG_DEBUG);
                    // insertしたIDを取得
                    $id0 = $this->Message2Member->getLastInsertID();
                    $id = sprintf("%010d", $id0);
                    //$this->log($id, LOG_DEBUG);
                    // ファイルアップロード処理の初期セット
                    $ds = DIRECTORY_SEPARATOR;  //1
                    $storeFolder = 'files/message/staff'.$ds.$id.$ds;   //2
                    // ファイルのアップロード
                    if(!empty($_FILES['attachment']['name'][0]) || !empty($_FILES['attachment']['name'][1]) || !empty($_FILES['attachment']['name'][2])){
                        // ディレクトリがなければ作る
                        if ($this->chkDirectory($storeFolder, true) == false) {
                            $this->Session->setFlash('ファイルのアップロードに失敗しました。');
                            $this->redirect($this->referer());
                            exit();
                        }
                        $count = count($_FILES['attachment']['name']);
                        for ($i=0; $i<$count; $i++) {
                            $tempFile = $_FILES['attachment']['tmp_name'][$i];//3
                            /**
                            $info = new SplFileInfo($_FILES['attachment']['name'][$i]);
                            $after = $info->getExtension();
                            if ($i == 0) {
                                if (!empty($after)) {
                                    $_after = $after;
                                }
                            } elseif ($i == 1) {
                                if (!empty($after)) {
                                    $_after2 = $after;
                                }
                            } 
                             * 
                             */
                            $targetPath = $storeFolder.$ds;  //4
                            $targetFile =  $targetPath. mb_convert_encoding($_FILES['attachment']['name'][$i], 'sjis-win', 'UTF-8');  //5
                            //$targetFile =  $targetPath.$staff_id.'.'.$after;  //5
                            // ファイルアップ実行
                            if (move_uploaded_file($tempFile, $targetFile)) {
                                // アップの成功
                                $this->log('ファイルのアップロードに成功しました：'.$id);
                            } else {
                                // アップの失敗
                                $this->log('ファイルのアップロードに失敗しました。'.$id);
                            }
                        }
                    }
                    $this->Session->setFlash('送信処理を完了しました。');
                    //$this->redirect('index');
                }                
            // キャンセル
            } elseif (isset($this->request->data['cancel'])) {
                $this->redirect('index');
            }
        } else {
            
        }
    }
    
    /*** 配列をカンマ区切りに ***/
    static public function setComma($val){
        $ret = '';
        if (!empty($val)) {
            foreach ($val as $value) {
                $ret = $ret.','.$value;  
            }
        }
        return $ret;
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
}
