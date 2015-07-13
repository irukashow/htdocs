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
    public $uses = array('Message2Staff', 'Message2Member', 'StaffMaster', 'User');

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
        // ユーザー名前
        $staff_id = $this->Auth->user('id');
        $name = $this->Auth->user('name_sei').' '.$this->Auth->user('name_mei');
        $this->set('user_name', $name);
        $this->Message2Staff->setSource('message2staff');
        $class = $this->Session->read('class');
        //$this->log($class ,LOG_DEBUG);
        // 受信メッセージ一覧の表示
        $this->paginate = array(
            'Message2Staff' => array(
                'conditions' => array('StaffMaster.id' => $staff_id),
                'fields' => 'Message2Staff.*, StaffMaster.*',
                'limit' =>20,                        //1ページ表示できるデータ数の設定
                'order' => array('id' => 'desc'),  //データを降順に並べる
                'joins' => array (
                    array (
                        'type' => 'LEFT',
                        'table' => 'staff_'.$class,
                        'alias' => 'StaffMaster',
                        'conditions' => 'StaffMaster.id = Message2Staff.recipient_staff' 
                    )
                )  
            )
        );
        $this->set('datas', $this->paginate());
        $this->log($this->Message2Staff->getDataSource()->getLog(), LOG_DEBUG);
        // 未読メッセージ件数
        $new_count = $this->Message2Staff->find('count', array('conditions' => array('recipient_staff' => $staff_id, 'class' => $class, 'kidoku_flag' => 0)));
        $this->set('new_count', $new_count);
        
        // POSTの場合
        if ($this->request->is('post') || $this->request->is('put')) {

        } else {
            $this->set('selected_class', $this->Session->read('selected_class'));
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
        $name = $this->Auth->user('name_sei').' '.$this->Auth->user('name_mei');
        $this->set('user_name', $name);
        $staff_id = $this->Auth->user('id');
        $this->set('staff_id', $staff_id);
        $class = $this->Session->read('class');
        $this->set('class', $class);
        $this->Message2Member->setSource('message2member');
        // 派遣グループへの宛先
        $conditions = array('area' => substr($class, 0, 1));
        $this->User->virtualFields['name'] = 'CONCAT(name_sei, " ", name_mei)';
        $member_array = $this->User->find('list', array('fields' => array('username', 'name'), 'conditions' => $conditions));
        $this->set('member_array', $member_array);

        // POSTの場合
        if ($this->request->is('post') || $this->request->is('put')) {
            // 送信
            if (isset($this->request->data['send'])) {
                $this->log($this->request->data, LOG_DEBUG);
                // データを登録する
                if ($this->Message2Member->save($this->request->data)) {
                    $this->log('送信処理を完了しました。', LOG_DEBUG);
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
        $selected_class = '11';
        //$this->set('selected_class', $selected_class);
        // テーブルの設定
        $this->Message2Staff->setSource('message2staff');
        $this->StaffMaster->setSource('staff_'.$selected_class);
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
        // 送信者スタッフID
        $username = $datas['Message2Staff']['username'];
        // 宛先名の取得
        $staff_id = $datas['Message2Staff']['recipient_staff'];
        $result = $this->StaffMaster->find('first', array('conditions' => array('StaffMaster.id' => $staff_id))); 
        $this->log($this->User->getDataSource()->getLog(), LOG_DEBUG);
        $staff_name = $result['StaffMaster']['name_sei'].' '.$result['StaffMaster']['name_mei'];
        $this->set('staff_name', $staff_name);

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
}
