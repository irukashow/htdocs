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
class OrderInfoDetail extends AppModel {
    public $useTable = 'order_info_details';
    public $primaryKey = 'id';

    public $validate = array(
            'shokushu_id' =>  array(
                    'rule' => 'notEmpty',
                    'message' => '職種を選択してください。'
            ),
        );
}
