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
            $this->set('active9', 'active');
            $this->set('active10', '');
            // ユーザー名前
            $name = $this->Auth->user('name_sei').' '.$this->Auth->user('name_mei');
            $this->set('user_name', $name);        
    }

}
