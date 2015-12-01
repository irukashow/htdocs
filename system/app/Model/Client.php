<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppModel', 'Model');

/**
 * CakePHP Client
 * @author M-YOKOI
 */
class Client extends AppModel {
    public $validate = array(
        'username' =>  array(
                'rule' => 'notEmpty',
                'message' => 'アカウントIDを入力してください（英数字）。'
        ),
        'password' =>  array(
                'rule' => 'notEmpty',
                'message' => 'パスワードを入力してください。'
        ),
        'class' =>  array(
                'rule' => 'notEmpty',
                'message' => '所属を選択してください。'
        ),
        );

    /**
     * ユーザー情報登録前にパスワードをハッシュ化する。
     * @see Model::beforeSave()
     */
    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['password'])) {
                $passwordHasher = new SimplePasswordHasher();
                $this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
        }
        return true;
    } 
}
