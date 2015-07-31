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
class StaffSchedule extends AppModel {
    public $useTable = 'staff_schedules';
    public $validate = array(
        // 勤務希望
        'work_flag' =>  array(
                'rule' => 'notEmpty',
                'message' => '勤務希望を選択してください。'
        )
        );
}
