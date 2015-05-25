<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppModel', 'Model');

/**
 * CakePHP Admin
 * @author M-YOKOI
 */
class Admin extends AppModel {
    public $useTable = 'version_remarks';

        public $validate = array(
            'version_no' =>  array(
                    'rule' => 'notEmpty',
                    'message' => '名前を選択してください。'
            ),
            'status' =>  array(
                    'rule' => 'notEmpty',
                    'message' => 'パスワードを入力してください。'
            ),
            'title' =>  array(
                    'rule' => 'notEmpty',
                    'message' => '氏名（姓）を入力してください。'
            ),
            'remarks' =>  array(
                    'rule' => 'notEmpty',
                    'message' => '氏名（名）を入力してください。'
            )
       );
        
}
