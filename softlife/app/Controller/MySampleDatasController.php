<?php
App::uses('AppController', 'Controller');

class MySampleDatasController extends AppController {
//Paginationの設定
public $paginate = array(
//モデルの指定
'MySampleData' => array(
//1ページ表示できるデータ数の設定
'limit' =>5,
//データを降順に並べる
'order' => array('id' => 'asc'),
));    
public function index() {
    // レイアウト関係
    $this -> layout = "Sample";
    $this -> set("header_for_layout", "Sample Application");
    $this -> set("footer_for_layout",
         "copyright by SYODA-Tuyano. 2011.");
    // 以下がデータベース関係
    $this->set('datas', $this->paginate());
  }

}