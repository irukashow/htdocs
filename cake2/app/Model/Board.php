<?php
class Board extends AppModel {
    public $name = 'Board';
 
    public $validate = array(
            'id' => array(
                    'rule' => 'numeric',
                    'message' => 'IDには数字を記入してください。'
            ),
            'name' => array(
                    'rule' => 'notEmpty',
                    'message' => '名前を記入してください。'
            ),
            'title' =>  array(
                    'rule' => 'notEmpty',
                    'message' => 'タイトルを記入してください。'
            ),
            'content' =>  array(
                    'rule' => 'notEmpty',
                    'message' => '内容を記入してください。'
            )
    );
}
?>