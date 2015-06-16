<?php
App::uses('AppController', 'Controller');

/**
 * CakePHP MenuController
 * @author M-YOKOI
 */
class MenuController extends AppController {

    public function index() {
        
    }

    public function version() {
        // レイアウト関係
        $this->layout = "log";
        $this->set("title_for_layout", $this->title_for_layout);
        $this->set("headline", 'バージョン更新履歴');
        
        // 初期値設定
        //$this->set('datas', $this->Menu->find('all'));
        $this->paginate = array('VersionRemarks' => 
            array('order' => array('id' => 'DESC')));
        $this->set('datas',$this->paginate());
    }
}
