<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppModel', 'Model');

/**
 * CakePHP StaffSchedule
 * @author M-YOKOI
 */
class TimeCard extends AppModel {
    public $useTable = 'time_cards';
    public $validate = array(
        // 休憩時間
        'rest_time' =>  array(
                'rule' => 'notEmpty',
                'message' => '休憩時間を入力してください。'
        )
        );
}
