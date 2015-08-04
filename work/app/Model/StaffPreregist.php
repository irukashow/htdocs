<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppModel', 'Model');

/**
 * CakePHP Regist
 * @author M-YOKOI
 */
class StaffPreregist extends AppModel {
    public $useTable = 'staff_preregists';
    //public $useTable = false;
    
    public $validate = array(
        // 登録１
        'account' =>  array(
            'rule' => array( 'between', 4, 15),
            'message' => '4文字以上、15文字以下で入力して下さい。',
            'allowEmpty' => false
        ),
        'password' =>  array(
            'rule' => array( 'between', 8, 15),
            'message' => '8文字以上、15文字以下で入力して下さい。',
            'allowEmpty' => false
        ),
        'password2' =>  array(
            'rule' => array( 'between', 8, 15),
            'message' => '8文字以上、15文字以下で入力して下さい。',
            'allowEmpty' => false
        ),
        'name_sei' =>  array(
                'rule' => 'notEmpty',
                'message' => '氏名（姓）を入力してください。'
        ),
        'name_mei' =>  array(
                'rule' => 'notEmpty',
                'message' => '氏名（名）を入力してください。'
        ),
        'name_sei2' =>  array(
                'rule' => 'notEmpty',
                'message' => '氏名（姓）（フリガナ）を入力してください。'
        ),
        'name_mei2' =>  array(
                'rule' => 'notEmpty',
                'message' => '氏名（名）（フリガナ）を入力してください。'
        ),
        'area' =>  array(
                'rule' => 'notEmpty',
                'message' => '登録場所を入力してください。'
        ),
        'gender' =>  array(
                'rule' => 'notEmpty',
                'message' => '性別を選択してください。'
        ),
        'email1' => array(
            'rule' => array('email', false),
            'required' => false,
            'allowEmpty' => false,
            'message' => 'メールアドレスの形式で必ず入力して下さい'
        ),
        'email2' => array(
            'rule' => array('email', false),
            'required' => false,
            'allowEmpty' => true,
            'message' => 'メールアドレスの形式で必ず入力して下さい'
        ),
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
    


}
