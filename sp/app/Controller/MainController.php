<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

/**
 * CakePHP MainController
 * @author M-YOKOI
 */
class MainController extends AppController {
        public $title_for_layout = "スタッフ マイページ";
        
	/**
	 * index
	 */
	public function index(){
            // レイアウト関係
            $this->layout = "main";
            $this->set("title_for_layout",$this->title_for_layout);
            // ユーザー名前
            $name = $this->Auth->user('name_sei').' '.$this->Auth->user('name_mei');
            $this->set('user_name', $name);
            $this->set('name', $name);
            //$this->set('sessions', $this->Session);
            
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
        
	public function index2(){
            // レイアウト関係
            $this->layout = "main";
            $this->set("title_for_layout",$this->title_for_layout);
            // ユーザー名前
            $name = $this->Auth->user('name_sei').' '.$this->Auth->user('name_mei');
            $this->set('user_name', $name);
            $this->set('name', $name);
            //$this->set('sessions', $this->Session);
            
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
        

}
