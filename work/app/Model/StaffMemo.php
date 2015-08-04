<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppModel', 'Model');

/**
 * CakePHP Item
 * @author M-YOKOI
 */
class StaffMemo extends AppModel {
    public $useTable = 'staff_memos';
    /** 主キー(省略時は「id」になるので省略も可) */
    public $primaryKey = array('id');
}
