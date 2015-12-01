<?php
App::uses('AppController', 'Controller');

/**
 * CakePHP MenuController
 * @author M-YOKOI
 */
class MenuController extends AppController {
    public $uses = array('Menu', 'VersionRemarks');
    public $paginate = array('VersionRemarks' => array('order' => array('id' => 'desc')));

    public function index() {
        
    }

    public function version() {
        // レイアウト関係
        $this->layout = "log";
        $this->set("title_for_layout", $this->title_for_layout);
        $this->set("headline", 'バージョン更新履歴');
        // テーブルの設定
        //$this->VersionRemarks->setSource('version_remarks');
        
        // 初期値設定
        //$this->set('datas', $this->Menu->find('all'));
        $this->set('datas', $this->paginate());
    }
}
