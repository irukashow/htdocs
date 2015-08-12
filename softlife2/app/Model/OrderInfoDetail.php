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
    public $name = 'OrderInfoDetail';
    public $belongsTo = array(
        'OrderCalender' => array(
            'className' => 'OrderCalender',
            'conditions' => 'OrderCalender.order_id = OrderInfoDetail.order_id AND OrderCalender.shokushu_id = OrderInfoDetail.shokushu_id',
            'order' => 'OrderInfoDetail.id ASC',
            'foreignKey' => ''),
        'OrderInfo' => array (               // ここから追加
            'className' => 'OrderInfo',
            'conditions' => '',
            'order' => 'OrderInfo.id ASC',
            'foreignKey' => 'case_id')
    );

}
