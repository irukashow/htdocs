<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

/**
 * CakePHP ClientController
 * @author M-YOKOI
 */
class ClientController extends AppController {
    public $uses = array('StaffMaster', 'User', 'Client');
    public $title_for_layout = "現場責任者名簿 - 派遣管理システム";
    // 
    public function index() {
        $this->layout = "log";
        $this->set("title_for_layout", $this->title_for_layout);
        $this->set("headline", '現場責任者一覧');
        $this->set('getValue', $this->getValue(2));      // 項目テーブル
        $this->set('datas', $this->paginate('Client'));

        // POSTの場合
        //if ($this->request->is('post') || $this->request->is('put') || $this->request->is('get')) {
        if ($this->request->is('post') || $this->request->is('put')) {
            // 削除処理
            if(isset($this->request->data['delete'])) {
                $id_array = array_keys($this->request->data['delete']);
                $id = $id_array[0];
                $sql = '';
                $sql = $sql.' DELETE FROM clients';
                $sql = $sql.' WHERE id = '.$id;
                $this->User->query($sql);
                $this->redirect(array('action' => 'index')); 
            }
        }
    }
    // 
    public function account($id = null) {
        // レイアウト関係
        $this->layout = "sub";
        $this->set("title_for_layout", $this->title_for_layout);
        $username = $this->Auth->user('username');
        $this->set('username', $username);
        $selected_class = $this->Session->read('selected_class');
        $this->set('selected_class', $selected_class);
        // 所属のセット
        $class_arr = $this->Item->find('list', array('fields' => array( 'id', 'value'), 'conditions'=>array('item' => 2)));
        $this->set('class_arr', $class_arr);
        // 都道府県のセット
        $pref_arr = $this->Item->find('list', array('fields' => array( 'id', 'value'), 'conditions'=>array('item' => 10)));
        $this->set('pref_arr', $pref_arr);
        
        $this->log($this->request, LOG_DEBUG);
        // POSTの場合
        if ($this->request->is('post') || $this->request->is('put')) {
            // アカウントの存在チェック
            
            // データを登録する
            if ($this->Client->save($this->request->data)) {
                $this->Session->setFlash('登録完了いたしました。');
            }
        } else {
            // 登録していた値をセット
            $this->request->data = $this->Client->read(null, $id);
        }
        
    }

	/**
	 * パスワードの変更
	 */
	public function passwd2($id = null){
            // レイアウト関係
            $this->layout = "sub";
            $this->set("title_for_layout","パスワード変更 - 派遣管理システム");
            
            // POSTの場合
            if ($this->request->is('post') || $this->request->is('put')) {
                $this->set('username', $this->request->data['Client']['username']);
                if ($this->request->data['Client']['password'] != $this->request->data['Client']['password2']) {
                    $this->Session->setFlash(__('パスワードが一致しません。'));
                } else {
                    // データを登録する
                    $this->Client->save($this->request->data);
                    $this->Session->setFlash(__('パスワードは変更されました。'));

                    // indexに移動する
                    //$this->redirect(array('action' => 'view'));
                }
            } else {
                $this->request->data = $this->Client->read(null, $id); 
                $this->set('username', $this->request->data['Client']['username']);
            }
        }
        
    // 項目マスタ
    public function getValue($item = null){
        $conditions = array('item' => $item);
        $result = $this->Item->find('list', array('fields' => array('id', 'value'), 'conditions' => $conditions));
        //$this->log($result, LOG_DEBUG);
        
        return $result;
    } 
}
