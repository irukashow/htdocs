<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppModel', 'Model');

/**
 * CakePHP StaffMaster
 * @author M-YOKOI
 */
class StaffMaster extends AppModel {
    //public $useTable = 'StaffMasters';
    //public $useTable = false;
    
    public $validate = array(
        // 登録１
        'name_sei' =>  array(
                'rule' => 'notEmpty',
                'message' => '氏名（姓）を入力してください。'
        ),
        'name_mei' =>  array(
                'rule' => 'notEmpty',
                'message' => '氏名（名）を入力してください。'
        ),
        'birthday' =>  array(
                'rule' => 'notEmpty',
                'message' => '誕生日を入力してください。'
        ),
        'zipcode1' =>  array(
            'rule' => 'numeric',
            'required' => false,
            'allowEmpty' => true,
            'message' => '郵便番号は半角数字で入力して下さい。'
        ),
        'zipcode2' =>  array(
            'rule' => 'numeric',
            'required' => false,
            'allowEmpty' => true,
            'message' => '郵便番号は半角数字で入力して下さい。'
        ),
        'email1' =>  array(
                'rule' => 'notEmpty',
                'message' => 'メールアドレスを入力してください。'
        ),
        /**
        'email1' => array(
            'rule' => array('email', false),
            'required' => false,
            'allowEmpty' => false,
            'message' => 'メールアドレスの形式で入力して下さい'
        ),
        'email2' => array(
            'rule' => array('email', false),
            'required' => false,
            'allowEmpty' => true,
            'message' => 'メールアドレスの形式で入力して下さい'
        ),
         * 
         */
        // 登録２
        'height' =>  array(
            'rule' => 'numeric',
            'required' => false,
            'allowEmpty' => true,
            'message' => '身長は半角数字で入力して下さい。'
        ),
        'per_week' =>  array(
            'rule' => 'numeric',
            'required' => false,
            'allowEmpty' => true,
            'message' => '希望勤務回数（週）は半角数字で入力して下さい。'
        ),
        'per_month' =>  array(
            'rule' => 'numeric',
            'required' => false,
            'allowEmpty' => true,
            'message' => '希望勤務回数（月）は半角数字で入力して下さい。'
        ),
        'bank_kouza_num' =>  array(
            'rule' => 'numeric',
            'required' => false,
            'allowEmpty' => true,
            'message' => '口座番号は半角数字で入力して下さい。'
        )
    ); 
 
	/**
	 * ユーザー情報登録前にパスワードをハッシュ化する。
	 * @see Model::beforeSave()
	 */
	public function beforeSave($options = array()) {
            if (isset($this->data[$this->alias]['password'])) {
                    $passwordHasher = new SimplePasswordHasher();
                    $this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
            }
            return true;
	}
}
