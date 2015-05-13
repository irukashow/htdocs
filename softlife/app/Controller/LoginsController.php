<?php
/**
 * CakePHP LoginController
 * @author M-YOKOI
 */
class LoginsController extends AppController {
    public $uses = array('Logins');

    public function index() {
        $this->layout = "Main";
        $this->set("header_for_layout","派遣管理システム");
        $this->set("footer_for_layout",
            "copyright by SOFTLIFE. 2015.");
        
        if ($this->request->is('post')) {
            $this->Logins->set($this->request->data);
            if ($this->Logins->validates()){
                //echo 'バリデーションOK';
                $this->redirect('/');
            } else {
                //echo 'バリデーションNG';
            }
        }

      }
      
      public function success() {
        //$this->modelClass = null;
        $this->layout = "Main";
        $this->set("header_for_layout","派遣管理システム");
        $this->set("footer_for_layout",
            "copyright by SOFTLIFE. 2015.");
        
        $id = $this->request->data('Logins.id');
        $password = $this->request->data('Logins.passwd');
        
        /*
        echo '<br><br>';
        echo 'id='.$id;
        echo 'password='.$password;
        */
        
        $data = $this->Logins->getData($id, $password);
        $this->set('data', $data);

        /*
        if ($user == 1 && $password == 'passwd') {
            echo '成功';
        } else {
            $this->redirect('/login/index');
        }
         * 
         */
      }

}
