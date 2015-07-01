<?php
App::uses('AppModel', 'Model');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');


class User extends AppModel {
    public $name = 'User';
    public $useTable = 'users';
    /** 主キー(省略時は「id」になるので省略も可) */
    public $primaryKey = 'username';
 
    public $validate = array(
            'username' =>  array(
                    'rule' => 'notEmpty',
                    'message' => '名前を選択してください。'
            ),
            'password' =>  array(
                    'rule' => 'notEmpty',
                    'message' => 'パスワードを入力してください。'
            ),
            'name_sei' =>  array(
                    'rule' => 'notEmpty',
                    'message' => '氏名（姓）を入力してください。'
            ),
            'name_mei' =>  array(
                    'rule' => 'notEmpty',
                    'message' => '氏名（名）を入力してください。'
            ),
            'area' =>  array(
                    'rule' => 'notEmpty',
                    'message' => '地域を選択してください。'
            ),
            'auth' =>  array(
                    'rule' => 'notEmpty',
                    'message' => '権限を少なくとも一つは選択してください。'
            ),

            'role' =>  array(
                    'rule' => 'notEmpty',
                    'message' => 'ユーザーの種類を選択してください。'
            )
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