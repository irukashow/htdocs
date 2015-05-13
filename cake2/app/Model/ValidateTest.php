<?php
class ValidateTest extends AppModel {
public $useTable = false;

public $_schema = array(
        'input_text' => array(
        'type' => 'string', 
        'length' => 100
        )
    );

public $validate = array(
        'input_adress' => array(
        'rule' => 'email',
        'message'=> 'メールアドレスを入力してください。',
        'allowEmpty' => false
        ),
        'input_subject' => array(
            'rule' => array( 'maxLength', 10),
            'message' => '10文字以下で入力して下さい。',
          'allowEmpty' => true
        ),
        'input_text' => array(
        'rule' => 'notEmpty',
        'message'=> '本文を記入してください。'
        )
      );
}