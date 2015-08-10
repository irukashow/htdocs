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
class CaseManagement extends AppModel {
    //public $useTable = 'case_managements';
    /** 主キー(省略時は「id」になるので省略も可) */
    //public $primaryKey = array('id');
    
    public $validate = array(
        'case_name' =>  array(
                'rule' => 'notEmpty',
                'message' => '案件名称を入力してください。'
        ),
        'username' =>  array(
                'rule' => 'notEmpty',
                'message' => '担当者（所属・氏名）を入力してください。'
        ),
        );
}
