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
    
    // 管理者のお知らせ入力ページ
    public function admin_info() {
        // レイアウト関係
        $this->layout = "sub";
        $this->set("title_for_layout","管理者のお知らせ入力 - 派遣管理システム");
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
        
    	// POSTの場合
        if ($this->request->is('post')) {
            if (isset($this->request->data['submit'])) {
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
            }
        }
        
    }
    
    // バージョン情報入力ページ
    public function version() {
        // レイアウト関係
        $this->layout = "sub";
        $this->set("title_for_layout","バージョン情報入力 - 派遣管理システム");
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
        
    	// POSTの場合
        if ($this->request->is('post')) {
            if ($this->Admin->validates() == false) {
                exit();
            }
            if (isset($this->request->data['submit'])) {
                // モデルの状態をリセットする
                $this->Admin->create();
                // データを登録する
                $this->Admin->save($this->request->data);
                // 登録完了
                $this->Session->setFlash('登録を完了しました。');

                // indexに移動する
                //$this->redirect(array('action' => 'index'));
            }
        }
        
    }

}
