<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppModel', 'Model');

/**
 * CakePHP Mail
 * @author masa
 */
class Mail extends AppModel { 
  public $useTable = false;
  public $name = 'Mail';  
  public $validate = array(  
    // 件名のバリデーション  
    'subject' => array(  
      // 空入力  
      array(  
        'rule' => array('notEmpty'),  
        'message' => '件名を入力してください',  
        'last' => true,  
        'required' => true,  
      ),  
    ),  
    // 宛先のバリデーション  
    'to' => array(  
      // email形式  
      array(  
        'rule' => array('email'),  
        'message' => '正しいメールアドレスを入力してください',  
        'last' => true,  
        'required' => true,  
      ),  
    ),  
    // 本文のバリデーション  
    'body' => array(  
      // 入力文字数  
      array(  
        'rule' => array('minLength', 5),  
        'message' => '最低5バイトは入力してください',  
        'last' => true,  
        'required' => true,  
      ),  
    ),  
  );
}
