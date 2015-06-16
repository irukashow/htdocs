<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

/**
 * CakePHP RegistController
 * @author M-YOKOI
 */
class RegistController extends AppController {

    public function index() {
        $this->redirect('page1');
        
    }

    public function page1() {
        // レイアウト関係
        $this->layout = "main_pc";
        $this->set("title_for_layout","スタッフ仮登録 - 入力１");
        
        $pref_arr = $this->Item->find('list', array('fields' => array( 'id', 'value'), 'conditions' => array('item' => '10')));
        $this->set('pref_arr', $pref_arr);  
    }
    
    public function page2() {
        // レイアウト関係
        $this->layout = "main_pc";
        $this->set("title_for_layout","スタッフ仮登録 - 入力２"); 
    }
    
    

}
