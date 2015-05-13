<?php
App::uses('AppModel', 'Model');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');


class User extends AppModel {
    public $name = 'User';
 
    public $validate = array(
            'username' => array(
                    'rule' => 'notEmpty',
                    'message' => 'ユーザーを選択してください。'
            ),
            'password' =>  array(
                    'rule' => 'notEmpty',
                    'message' => 'パスワードを入力してください。'
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