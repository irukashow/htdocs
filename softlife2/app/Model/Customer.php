<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppModel', 'Model');

/**
 * CakePHP CaseManagement
 * @author M-YOKOI
 */
class Customer extends AppModel {
    public $useTable = 'customer';
    /** 主キー(省略時は「id」になるので省略も可) */
    //public $primaryKey = array('id');
    
    public $validate = array(
        // 登録１
        'corp_name' =>  array(
                'rule' => 'notEmpty',
                'message' => '企業名を入力してください。'
        )
        );
}
