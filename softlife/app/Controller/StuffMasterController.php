<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

/**
 * CakePHP StuffMasterController
 * @author M-YOKOI
 */
class StuffMasterController extends AppController {
//Paginationの設定
public $paginate = array(
//モデルの指定
'StuffMaster' => array(
//1ページ表示できるデータ数の設定
'limit' =>10,
//データを降順に並べる
'order' => array('id' => 'asc'),
)); 
public function index() {
    // レイアウト関係
        $this->layout = "Main";
        $this->set("header_for_layout","派遣管理システム");
        $this->set("footer_for_layout",
            "copyright by SOFTLIFE. 2015.");
    // 以下がデータベース関係
    $this->set('datas', $this->paginate());
    //$datas = $this->StuffMaster->find('all');
    //$this->set('datas',$datas);
  }
  
  function find(){
        $this->layout = "Main";
        $this->set("header_for_layout","派遣管理システム");
        $this->set("footer_for_layout",
            "copyright by SOFTLIFE. 2015.");
     
    if (isset($this->data['id'])){
      $id = $this->data['id'];
      $status = array(
        'conditions' => 
            array('StuffMaster.id' => $id)
      );
      $data = $this->StuffMaster->find('first', $status);
    } else {
      $data = null;
    }
    $this->set('data',$data);
  }
  
  public function add() {
    // レイアウト関係
    $this->layout = "Sample";
    $this->set("header_for_layout", "Sample Application");
    $this->set("footer_for_layout", 
        "copyright by SYODA-Tuyano. 2011.");
    // post時の処理
    if ($this->request->is('post')) {
      $this->StuffMaster->save($this->request->data);
    }
  }
  
  public function edit($id) {
    // レイアウト関係
    $this->layout = "Sample";
    $this->set("header_for_layout", "Sample Application");
    $this->set("footer_for_layout", 
        "copyright by SYODA-Tuyano. 2011.");
    // post時の処理
    $this->StuffMaster->id = $id;
    if ($this->request->is('post') || $this->request->is('put')) {
      $this->StuffMaster->save($this->request->data);
      $this->redirect(array('action' => 'index'));
    } else {
      $this->request->data = 
          $this->StuffMaster->read(null, $id);
    }
  }

  public function del($id=null) {
    // レイアウト関係
    $this->layout = "Sample";
    $this->set("header_for_layout", "Sample Application");
    $this->set("footer_for_layout", 
        "copyright by SYODA-Tuyano. 2011.");
    $this->StuffMaster->id = $id;
    // post時の処理
    if ($this->request->is('post') || $this->request->is('put')) {
      $this->StuffMaster->delete($this->request->
          data('StuffMaster.id'));
    } else {
      $this->request->data = 
          $this->StuffMaster->read(null, $id);
    }
  }
  
  // findByName_sei
public function find2(){
    // レイアウト関係
    $this->layout = "Sample";
    $this->set("header_for_layout", "Sample Application");
    $this->set("footer_for_layout", 
        "copyright by SYODA-Tuyano. 2011.");
    // post時の処理
    if ($this->request->is('post')) {
      $data = $this->StuffMaster->findByName_sei($this->
          request->data('StuffMaster.name_sei'));
      $this->set('data',$data);
    }
  }  
 
  // 
public function find3(){
   // レイアウト関係
   $this->layout = "Sample";
   $this->set("header_for_layout", "Sample Application");
   $this->set("footer_for_layout", 
      "copyright by SYODA-Tuyano. 2011.");
   // post時の処理
   if ($this->request->is('post')) {
      $name_sei = $this->request->data('StuffMaster.name_sei');
      $name_mei = $this->request->data('StuffMaster.name_mei');
      $opt = array("OR" => array (
          "StuffMaster.name_sei" => $name_sei,
          "StuffMaster.name_mei" => $name_mei
        )
      );
      $data = $this->StuffMaster->
          find('all',array('conditions' => $opt));
         $this->set('data',$data);
      }
}

public function find4(){
    // レイアウト関係
    $this->layout = "Main";
    $this->set("header_for_layout","派遣管理システム");
    $this->set("footer_for_layout",
        "copyright by SOFTLIFE. 2015.");
    // post時の処理
    if ($this->request->is('post')) {
      $str = $this->request->data('StuffMaster.name_sei');
      $data = $this->StuffMaster->query
        ("select * from stuff_masters where name_sei like '%{$str}%';");
      $this->set('data',$data);
    }
  }
}
