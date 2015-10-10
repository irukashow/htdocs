<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppModel', 'Model');

/**
 * CakePHP ShiftManagement
 * @author M-YOKOI
 */
class ShiftManagement extends AppModel {
    public $virtualFields = array(  
        'sm_name_sei2' => 'StaffMaster.name_sei2',  
    );  
}
