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
    public $uses = array('MessageMember');

    public function index() {
        // レイアウト関係
        $this->layout = "main";
        $this->set("title_for_layout","メッセージ一覧 - 派遣管理システム");
        $this->set("header_for_layout","派遣管理システム");
        $this->set("footer_for_layout",
            "copyright by SOFTLIFE. 2015.");
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
        // テーブルの設定
        $this->MessageMember->setSource('message_member');
        // 受信メッセージ一覧の表示
        $this->paginate = array(
            'MessageMember' => array(
                'conditions' => null,
                'limit' =>20,                        //1ページ表示できるデータ数の設定
                'order' => array('id' => 'desc'),  //データを降順に並べる
            )
        );
        $this->set('datas', $this->paginate());
        // 未読メッセージ件数
        $new_count = $this->MessageMember->find('count', array('conditions' => array('kidoku_flag' => 0)));
        $this->set('new_count', $new_count);
        
        // POSTの場合
        if ($this->request->is('post') || $this->request->is('put')) {
            // 属性の変更
            $class = $this->request->data['class'];
            //$this->Session->setFlash($class);
            $this->set('selected_class', $class);
            $this->Session->write('selected_class', $class);
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
                    $this->log($this->MessageMember->getDataSource()->getLog(), LOG_DEBUG);
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
        $this->MessageMember->setSource('message_member');
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
        //$this->log($this->MessageMember->getDataSource()->getLog(), LOG_DEBUG);
        $this->set('data', $datas);

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
            // 送信
            } elseif (isset($this->request->data['send'])) {
                // データを登録する
                //$this->Message->create();
                if ($this->MessageMember->save($this->request->data)) {
                    $this->log($this->MessageMember->getDataSource()->getLog(), LOG_DEBUG);
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

}
