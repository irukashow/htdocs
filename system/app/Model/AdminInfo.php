<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppModel', 'Model');

/**
 * CakePHP Admin
 * @author M-YOKOI
 */
class AdminInfo extends AppModel {
    public $useTable = 'admin_info';
    public $primaryKey = 'id';
        
}
