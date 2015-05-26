<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

/**
 * CakePHP MenuController
 * @author M-YOKOI
 */
class MenuController extends AppController {

    public function index() {
        
    }

    public function version() {
        // レイアウト関係
        $this->layout = "sub";
        $this->set("title_for_layout","バージョン更新情報 - 派遣管理システム");
        
        // 初期値設定
        //$this->set('datas', $this->Menu->find('all'));
        $this->set('datas',$this->paginate());
    }
}
