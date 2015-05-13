<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppModel', 'Model');

/**
 * CakePHP Sample
 * @author masa
 */
class Sample extends AppModel {
    //var $name = 'Sample';
    var $validate = array(
    'text1' => array(
        'required' => true,
        'message' => 'どちらかを選択してください。'
    )
);
}
