<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

/**
 * CakePHP MailController
 * @author masa
 */
class MailController extends AppController {

public function index()  
  {  
    // 投稿された場合  
    if(!empty($this->data)) {  
  
      // postデータとモデルをバインド  
      $this->Mail->set($this->data);  
  
      // モデルのバリデーションを起動  
      $this->Mail->validates();  
  
    }  
  }

}
