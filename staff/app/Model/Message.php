<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppModel', 'Model');

/**
 * CakePHP Message
 * @author M-YOKOI
 */
class Message extends AppModel {
    public $useTable = 'message2staff';
    
    public $validate = array(
        // メッセージ送信
        'title' =>  array(
                'rule' => 'notEmpty',
                'message' => '標題を入力してください。'
        ),
        'body' =>  array(
                'rule' => 'notEmpty',
                'message' => '本文を入力してください。'
        )
        );
    
}
