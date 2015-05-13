<?php
/**
 * CakePHP Login
 * @author M-YOKOI
 */
class Logins extends AppModel {
    public $name = 'Login';
 
    public $validate = array(
            'id' => array(
                    'rule' => 'numeric',
                    'message' => 'IDには数字を記入してください。'
            ),
            'passwd' =>  array(
                    'rule' => 'notEmpty',
                    'message' => 'パスワードを入力してください。'
            )
    );    
    
    public function getData($id, $passwd){
        $sql = "SELECT * FROM logins WHERE logins.id = ".$id." AND logins.passwd = '".$passwd."';";
 
        $params = array(
            'id'=> $id,
            'passwd' => $passwd
        );
 
        $data = $this->query($sql,$params);
        return $data;
    }
    
    
}
