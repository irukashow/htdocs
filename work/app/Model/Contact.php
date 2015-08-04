<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppModel', 'Model');

/**
 * CakePHP Contact
 * @author M-YOKOI
 */
class Contact extends AppModel {
    // テーブル使わない
    public $useTable = false;
    
    // バリデーションルール
    public $validate = array(
        'email' => array(
            array('rule' => 'email', 'message' => 'メールアドレスを正しく入力して下さい。')
        ),
        'body' => array(
            array('rule' => 'notEmpty', 'message' => '本文が入力されていません。')
        )
    );    
}
