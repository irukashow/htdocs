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
    var $uses = array('LoginLogs', 'Users');
    public $title_for_layout = "ログイン履歴 - 派遣管理システム";
    
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
        
        /*
        $option = array();
        $option['recursive'] = -1; 
        $option['joins'][] = array(
            'type' => 'LEFT',
            'table' => 'users',
            'alias' => 'Users',
            'conditions' => 'Users.username = LoginLogs.username'
        );
        $option['order'] = 'id';
        //$option['conditions'] = array('User.id' => 1, 'Post.isPrivate' => 1);
        $option['fields'] = array('LoginLogs.*, Users.name_sei, Users.name_mei'); //<- 追加
        $result = $this->LoginLogs->find('all', $option);
         * 
         */

        $this->set('datas', $this->paginate('LoginLogs'));
    }
}
