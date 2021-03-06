<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

/**
 * CakePHP AdminController
 * @author M-YOKOI
 */
class AdminController extends AppController {
    public $uses = array('VersionRemarks', 'AdminInfo', 'User', 'Item', 'StaffMaster');

    public function index() {
        /* 管理権限がある場合 */
        if ($this->isAuthorized($this->Auth->user())) {

        }else{
            $this->Session->setFlash('管理者しか権限がありません。');
            $this->redirect($this->referer());
        }

            // レイアウト関係
            $this->layout = "main";
            $this->set("title_for_layout","ユーザー登録 - 派遣管理システム");
            $this->set("header_for_layout","派遣管理システム");
            $this->set("footer_for_layout",
                "copyright by SOFTLIFE. 2015.");
            // タブの状態
            $this->set('active1', '');
            $this->set('active2', '');
            $this->set('active3', '');
            $this->set('active4', '');
            $this->set('active5', '');
            $this->set('active6', '');
            $this->set('active7', '');
            $this->set('active8', '');
            $this->set('active9', '');
            $this->set('active10', 'active');
            // 絞り込みセッションを消去
            $this->Session->delete('filter');
            // ユーザー名前
            $name = $this->Auth->user('name_sei').' '.$this->Auth->user('name_mei');
            $this->set('user_name', $name);       
            
        // POSTの場合
        if ($this->request->is('post')) {
            // 属性の変更
            $class = $this->request->data['class'];
            //$this->Session->setFlash($class);
            $this->set('selected_class', $class);
            $this->Session->write('selected_class', $class);
        } else {
            $this->set('selected_class', $this->Session->read('selected_class'));
        }
    }

    // 管理者のお知らせ一覧ページ
    public function admin_info_list() {
        // レイアウト関係
        $this->layout = "log";
        $this->set("title_for_layout","管理者のお知らせ一覧 - 派遣管理システム");
        $this->set("headline", '管理者のお知らせ一覧');
        // ユーザー名前
        $name = $this->Auth->user('name_sei').' '.$this->Auth->user('name_mei');
        $this->set('user_name', $name); 
        // データのセット
        $this->paginate = array('order'=>array('id'=>'desc'));
        $this->set('datas', $this->paginate('AdminInfo'));
        
    	// POSTの場合
        if ($this->request->is('post')) {
            if (isset($this->request->data['submit'])) {
                /**
                // テーブルの設定
                $this->Admin->setSource('admin_info');
                // モデルの状態をリセットする
                $this->Admin->create();
                // データを登録する
                $this->Admin->save($this->request->data);
                // 登録完了
                $this->Session->setFlash('登録を完了しました。');

                // indexに移動する
                //$this->redirect(array('action' => 'index'));
                 * 
                 */
            }
        }
        
    }
    
    // 管理者のお知らせ入力ページ
    public function admin_info($id = null) {
        // レイアウト関係
        $this->layout = "sub";
        $this->set("title_for_layout","管理者のお知らせ入力 - 派遣管理システム");
        // ユーザー名前
        $name = $this->Auth->user('name_sei').' '.$this->Auth->user('name_mei');
        $this->set('user_name', $name); 
        $this->set('id', $id); 
        // テーブルの設定
        $this->AdminInfo->setSource('admin_info');
        
    	// POSTの場合
        if ($this->request->is('post') || $this->request->is('put')) {
            if (isset($this->request->data['submit'])) {
                // モデルの状態をリセットする
                //$this->AdminInfo->create();
                // データを登録する
                $this->AdminInfo->save($this->request->data);
                // 登録完了
                $this->Session->setFlash('登録を完了しました。');
                // 一覧に移動する
                $this->redirect(array('action' => 'admin_info_list'));
            }
        } else {
            // 登録していた値をセット
            $this->request->data = $this->AdminInfo->read(null, $id);
        }
    }
    
    // 管理者のお知らせ一覧ページ
    public function version_list() {
        // レイアウト関係
        $this->layout = "log";
        $this->set("title_for_layout","管理者のお知らせ一覧 - 派遣管理システム");
        $this->set("headline", 'バージョン情報一覧');
        // ユーザー名前
        $name = $this->Auth->user('name_sei').' '.$this->Auth->user('name_mei');
        $this->set('user_name', $name); 
        // データのセット
        $this->paginate = array('order'=>array('id'=>'desc'));
        $this->set('datas', $this->paginate('VersionRemarks'));
        
    	// POSTの場合
        if ($this->request->is('post')) {
            if (isset($this->request->data['submit'])) {

            }
        }
        
    }
    
    // バージョン情報入力ページ
    public function version($id = null) {
        // レイアウト関係
        $this->layout = "sub";
        $this->set("title_for_layout","バージョン情報入力 - 派遣管理システム");
        // ユーザー名前
        $name = $this->Auth->user('name_sei').' '.$this->Auth->user('name_mei');
        $this->set('user_name', $name); 
        $this->set('id', $id); 
        // テーブルの設定
        $this->VersionRemarks->setSource('version_remarks');
        
        $this->log($this->request->data, LOG_DEBUG);
    	// POSTの場合
        if ($this->request->is('post') || $this->request->is('put')) {
            if (isset($this->request->data['submit'])) {
                // モデルの状態をリセットする
                $this->VersionRemarks->create();
                // データを登録する
                $this->VersionRemarks->save($this->request->data);
                // 登録完了
                $this->Session->setFlash('登録を完了しました。');

                // indexに移動する
                //$this->redirect(array('action' => 'index'));
            }
        } else {
            // 登録していた値をセット
            $this->request->data = $this->VersionRemarks->read(null, $id);
        }
        
    }
    
    /**
     * スタッフアカウント
     */
    public function staff_account() {
        // レイアウト関係
        $this->layout = "main";
        $this->set("title_for_layout","スタッフアカウント - 派遣管理システム");
        $this->set("header_for_layout","派遣管理システム");
        // タブの状態
        $this->set('active1', '');
        $this->set('active2', '');
        $this->set('active3', '');
        $this->set('active4', '');
        $this->set('active5', '');
        $this->set('active6', '');
        $this->set('active7', '');
        $this->set('active8', '');
        $this->set('active9', '');
        $this->set('active10', 'active');
        // ユーザー名前
        $name = $this->Auth->user('name_sei').' '.$this->Auth->user('name_mei');
        $this->set('user_name', $name);  
        $username = $this->Auth->user('username');
        $this->set('username', $username);
        $selected_class = $this->Session->read('selected_class');
        $this->set('selected_class', $selected_class);
        // 職種マスタ配列
        $conditions0 = array('item' => 17);
        $list_shokushu = $this->Item->find('list', array('fields' => array('id', 'value'), 'conditions' => $conditions0));
        $this->set('list_shokushu', $list_shokushu);
        // テーブルの設定
        $this->StaffMaster->setSource('staff_'.$selected_class);
            
        // POSTの場合
        if ($this->request->is('post') || $this->request->is('put')) {
            if (isset($this->request->data['initiation'])) {
                // 初期化
                $sql = 'update staff_'.$selected_class.' set account = CONCAT('.$selected_class.', id)';
                $this->StaffMaster->query($sql);
                $passwordHasher = new SimplePasswordHasher();
                $datas = $this->StaffMaster->find('all');
                foreach ($datas as $data) {
                    $sql = '';
                    $sql = ' update staff_'.$selected_class.' set password = "'.$passwordHasher->hash(str_replace('-', '', $data['StaffMaster']['birthday'])).'"';
                    $sql .= ' WHERE id = '.$data['StaffMaster']['id'];
                    $this->StaffMaster->query($sql);
                }
                $this->Session->setFlash('【情報】初期化が完了しました。');
                $this->redirect(array(''));
            } elseif (isset($this->request->data['class'])) {
                // 属性の変更
                $class = $this->request->data['class'];
                //$this->Session->setFlash($class);
                $this->set('selected_class', $class);
                $this->Session->write('selected_class', $class);
                $this->redirect(array(''));
            }
        } else {
            // ページネーション
            $this->set('datas', $this->paginate('StaffMaster'));
        }
    }

}
