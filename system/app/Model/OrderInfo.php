<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppModel', 'Model');

/**
 * CakePHP VersionRemarks
 * @author M-YOKOI
 */
class OrderInfo extends AppModel {
    public $useTable = 'order_infos';
    public $primaryKey = 'id';

    public $validate = array(
            'order_name' =>  array(
                    'rule' => 'notEmpty',
                    'message' => '名前を選択してください。'
            ),
            'period_from' =>  array(
                    'rule' => 'notEmpty',
                    'message' => 'パスワードを入力してください。'
            ),
            'period_to' =>  array(
                    'rule' => 'notEmpty',
                    'message' => '氏名（姓）を入力してください。'
            )
        );
}
