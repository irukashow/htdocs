<?php
App::uses('AppController', 'Controller');
class ValidateTestsController extends AppController {
public function index() {
        if ($this->request->is('post')) {
            $this->ValidateTest->set($this->request->data);
            if ($this->ValidateTest->validates()){
                echo 'バリデーションOK';
            } else {
                echo 'バリデーションNG';
            }
        }
    }
} 