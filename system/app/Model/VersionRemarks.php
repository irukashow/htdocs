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
class VersionRemarks extends AppModel {
    public $useTable = 'version_remarks';
    public $primaryKey = 'id';

        public $validate = array(
            'version_no' =>  array(
                    'rule' => 'notEmpty',
                    'message' => 'バージョン番号を選択してください。'
            ),
            'status' =>  array(
                    'rule' => 'notEmpty',
                    'message' => 'ステータスを入力してください。'
            ),
            'title' =>  array(
                    'rule' => 'notEmpty',
                    'message' => '更新タイトルを入力してください。'
            ),
            'release_date' =>  array(
                    'rule' => 'notEmpty',
                    'message' => 'リリース日付を入力してください。'
            ),
            'remarks' =>  array(
                    'rule' => 'notEmpty',
                    'message' => '備考を入力してください。'
            )
       );
}
