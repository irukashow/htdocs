<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

/**
 * CakePHP LogController
 * @author M-YOKOI
 */
class LogController extends AppController {
    var $uses = array('LoginLogs', 'Users', 'Item', 'StaffMaster', 'StaffMasterLogs');
    public $title_for_layout = "履歴情報 - 派遣管理システム";
    
    public $paginate = array (
    'LoginLogs' => array (
        'limit' => 20,
        'order' => 'LoginLogs.id',
        'fields' => '*',
        'joins' => array (
            array (
                'type' => 'LEFT',
                'table' => 'users',
                'alias' => 'Users',
                'conditions' => 'LoginLogs.username = Users.username' 
                ) 
            ) 
        ), 
        "Role" => array() 
    );
    
    // ルート
    public function index() {
        $this->redirect('/log/login');
    }
    
    // ログイン履歴
    public function login() {
        // レイアウト関係
        $this->layout = "log";
        $this->set("title_for_layout", $this->title_for_layout);
        $this->set("headline", 'ログイン履歴');

        $this->set('datas', $this->paginate('LoginLogs'));
    }
    
    // スタッフマスタ更新履歴
    public function staff_master() {
        // レイアウト関係
        $this->layout = "log";
        $this->set("title_for_layout", $this->title_for_layout);
        $this->set("headline", 'スタッフマスタ更新履歴');
        // テーブルの設定
        $this->LoginLogs->setSource('staff_master_logs');
        // 項目配列セット
        $this->set('data_item', $this->getValue());
        
        $this->set('datas', $this->paginate('LoginLogs'));
        //$this->log($this->LoginLogs->getDataSource()->getLog(), LOG_DEBUG);
        //$this->paginate['joins'] = null;
    }
    
    // 項目マスタ
    public function getValue(){
        $conditions = null;
        $result = $this->Item->find('list', array('fields' => array('id', 'value', 'item'), 'conditions' => $conditions));
        //$this->log($result, LOG_DEBUG);
        
        return $result;
    } 
}
