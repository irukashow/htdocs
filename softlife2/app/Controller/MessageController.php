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
    public $uses = array('MessageMember', 'MessageStaff', 'User');

    public function index() {
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
        $this->set('user_name', $name);
        $selected_class = $this->Session->read('selected_class');
        // テーブルの設定
        //$this->MessageStaff->setSource('message_staff');
        $this->MessageMember->setSource('message_staff');
        // 受信メッセージ一覧の表示
        $this->paginate = array(
            'MessageMember' => array(
                'conditions' => array('class' => $selected_class),
                'fields' => 'MessageMember.*, User.*',
                'limit' =>20,                        //1ページ表示できるデータ数の設定
                'order' => array('id' => 'desc'),  //データを降順に並べる
                'joins' => array (
                    array (
                        'type' => 'LEFT',
                        'table' => 'users',
                        'alias' => 'User',
                        'conditions' => 'User.username = MessageMember.recipient_member' 
                    )
                )  
            )
        );
        $this->set('datas', $this->paginate());
        //$this->log($this->MessageMember->getDataSource()->getLog(), LOG_DEBUG);
        // 未読メッセージ件数
        $new_count = $this->MessageMember->find('count', array('conditions' => array('class' => $selected_class, 'kidoku_flag' => 0)));
        $this->set('new_count', $new_count);
        
        // POSTの場合
        if ($this->request->is('post') || $this->request->is('put')) {
            // 属性の変更
            $class = $this->request->data['class'];
            $this->set('selected_class', $class);
            $this->Session->write('selected_class', $class);
            //$this->log($class, LOG_DEBUG);
            $this->redirect('.');
        } else {
            $this->set('selected_class', $selected_class);
        }
    }
    /** メッセージを送信 **/
    public function send() {
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
        $this->set('selected_class', $this->Session->read('selected_class'));
        // テーブルの設定
        $this->MessageMember->setSource('message_member');

        // POSTの場合
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->log($this->request->data, LOG_DEBUG);
            // 属性の変更
            if (isset($this->request->data['class'])) {
                $class = $this->request->data['class'];
                //$this->Session->setFlash($class);
                $this->set('selected_class', $class);
                $this->Session->write('selected_class', $class);
            // 送信
            } elseif (isset($this->request->data['send'])) {
                // データを登録する
                //$this->Message->create();
                if ($this->MessageMember->save($this->request->data)) {
                    //$this->Session->setFlash('送信処理を完了しました。');
                    $this->redirect('index');
                }                
            // キャンセル
            } elseif (isset($this->request->data['cancel'])) {
                $this->redirect('index');
            }
        } else {
            
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
        $this->MessageMember->setSource('message_staff');
        //$this->MessageStaff->setSource('message_staff');
        // 既読フラグ: 1
        // 更新する内容を設定
        $data = array('MessageMember' => array('id' => $id, 'kidoku_flag' => 1));
        // 更新する項目（フィールド指定）
        $fields = array('kidoku_flag');
        // 更新
        if ($this->MessageMember->save($data, false, $fields)) {
        }
        // 受信メッセージの内容表示
        $datas = $this->MessageMember->find('first', array('conditions' => array('id' => $id)));
        //$this->log($this->MessageStaff->getDataSource()->getLog(), LOG_DEBUG);
        $this->set('data', $datas);
        // 宛先名の取得
        $username = $datas['MessageMember']['recipient_member'];
        $result = $this->User->find('first', array('conditions' => array('User.username' => $username))); 
        //$this->log($this->User->getDataSource()->getLog(), LOG_DEBUG);
        $name_member = $result['User']['name_sei'].' '.$result['User']['name_mei'];
        $this->set('name_member', $name_member);

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
        $this->MessageStaff->setSource('message_staff');

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
                $this->request->data['MessageStaff']['attachment'] = $val;
                // データを登録する
                if ($this->MessageStaff->save($this->request->data)) {
                    //$this->log($this->MessageStaff->getDataSource()->getLog(), LOG_DEBUG);
                    //$this->log($this->request->params['form']['attachment'], LOG_DEBUG);
                    // insertしたIDを取得
                    $id0 = $this->MessageStaff->getLastInsertID();
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
