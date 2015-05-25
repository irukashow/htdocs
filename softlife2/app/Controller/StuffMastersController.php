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
class StuffMastersController extends AppController {
    public $uses = array('StuffMaster', 'Item');
    //Paginationの設定
    public $paginate = array(
    //モデルの指定
    'StuffMaster' => array(
    //1ページ表示できるデータ数の設定
    'limit' =>10,
    //データを降順に並べる
    'order' => array('id' => 'asc'),
    )); 
    public $title_for_layout = "スタッフマスタ - 派遣管理システム";

    public function index() {
        // レイアウト関係
        $this->layout = "main";
        $this->set("title_for_layout", $this->title_for_layout);
        // タブの状態
        $this->set('active1', '');
        $this->set('active2', '');
        $this->set('active3', 'active');
        $this->set('active4', '');
        $this->set('active5', '');
        $this->set('active6', '');
        $this->set('active7', '');
        $this->set('active8', '');
        $this->set('active9', '');
        $this->set('active10', '');
        // ユーザー名前
        $name = $this->Auth->user('name_sei').' '.$this->Auth->user('name_mei');
        $this->set('user_name', $name);
        // 都道府県のセット
        $conditions = array('item' => 10);
        $pref_arr = $this->Item->find('list', array('fields' => array( 'id', 'value'), 'conditions' => $conditions));
        $this->set('pref_arr', $pref_arr); 

        // 登録番号で検索
        if (isset($this->data['txtId'])){
            $id = $this->data['txtId'];
            $conditions = array('id' => $id);
            $this->set('datas', $this->paginate('StuffMaster',$conditions));
            // 表示ページ単位
            //$this->paginate = array('StuffMaster' => array('limit' => $this->data['optDisplay']));
        // 担当者で検索
        } elseif (isset($this->data['txtTantou'])){
            $tantou = $this->data['txtTantou'];
            $conditions = array('tantou LIKE ' => $tantou);
            $this->set('datas', $this->paginate('StuffMaster',$conditions));            
        } else {
            $this->set('datas', $this->paginate());
        }

        // 以下がデータベース関係
        //$this->set('datas', $this->paginate());
        //$datas = $this->StuffMaster->find('all');
        //$this->set('datas',$datas);
        
        
      }
  
    // 登録ページ（その１）
    public function reg1() {
          // レイアウト関係
          $this->layout = "sub";
          $this->set("title_for_layout", $this->title_for_layout);
          // 都道府県のセット
          mb_language("uni");
          mb_internal_encoding("utf-8"); //内部文字コードを変更
          mb_http_input("auto");
          mb_http_output("utf-8");
          $conditions = array('item' => 10);
          $pref_arr = $this->Item->find('list', array('fields' => array( 'id', 'value'), 'conditions' => $conditions));
          $this->set('pref_arr', $pref_arr); 

      // post時の処理
      if ($this->request->is('post') || $this->request->is('put')) {
          $this->redirect(array('action' => 'reg2'));
      } else {

      }
    }
    
    // 登録ページ（その２）
    public function reg2() {
          // レイアウト関係
          $this->layout = "sub";
          $this->set("title_for_layout",$this->title_for_layout);
          // 都道府県のセット
          mb_language("uni");
          mb_internal_encoding("utf-8"); //内部文字コードを変更
          mb_http_input("auto");
          mb_http_output("utf-8");
          $conditions = array('item' => 10);
          $pref_arr = $this->Item->find('list', array('fields' => array( 'id', 'value'), 'conditions' => $conditions));
          $this->set('pref_arr', $pref_arr); 
          $stuff_no = '34567';
          $this->set('stuff_no', $stuff_no); 

        // ファイルアップロード処理
        $ds = DIRECTORY_SEPARATOR;  //1
        $storeFolder = 'files/stuff_reg'.$ds.$stuff_no.$ds;   //2
        
        // post時の処理
        if ($this->request->is('post') || $this->request->is('put')) {
            /**
            if(!empty($_FILES['upfile']['name'][0] && !empty($_FILES['upfile']['name'][1]))){
                // ディレクトリがなければ作る
                if ($this->chkDirectory($storeFolder, true) == false) {
                    $this->Session->setFlash('ファイルのアップロードに失敗しました。');
                    $this->redirect($this->referer());
                    exit();
                }
                $count = count($_FILES['upfile']['name']);
                for ($i=0; $i<$count; $i++) {
                    $tempFile = $_FILES['upfile']['tmp_name'][$i];//3
                    //$info = new SplFileInfo($_FILES['upfile']['name'][$i]);
                    //$after = $info->getExtension();
                    $targetPath = $storeFolder.$ds;  //4
                    $targetFile =  $targetPath. mb_convert_encoding($_FILES['upfile']['name'][$i], 'sjis-win', 'UTF-8');  //5
                    //$targetFile =  $targetPath.$stuff_no.'.'.$after;  //5
                    move_uploaded_file($tempFile,$targetFile); //6
                }
            } else {
                $this->Session->setFlash('「証明写真」か「履歴書」のファイルが選択されていません。');
                $this->redirect($this->referer());
                exit();
            }
            **/

            $this->redirect(array('action' => 'reg3'));
        }
        

    }
    
    // 登録ページ（その３）
    public function reg3() {
          // レイアウト関係
          $this->layout = "sub";
          $this->set("title_for_layout",$this->title_for_layout);
          // 都道府県のセット
          mb_language("uni");
          mb_internal_encoding("utf-8"); //内部文字コードを変更
          mb_http_input("auto");
          mb_http_output("utf-8");
          $conditions = array('item' => 10);
          $pref_arr = $this->Item->find('list', array('fields' => array( 'id', 'value'), 'conditions' => $conditions));
          $this->set('pref_arr', $pref_arr); 

      // post時の処理
      if ($this->request->is('post') || $this->request->is('put')) {
          $this->redirect(array('action' => 'reg3'));
      } else {

      }
    }
    
    // プロフィールページ
    public function profile() {
          // レイアウト関係
          $this->layout = "sub";
          $this->set("title_for_layout",$this->title_for_layout);
          // 都道府県のセット
          mb_language("uni");
          mb_internal_encoding("utf-8"); //内部文字コードを変更
          mb_http_input("auto");
          mb_http_output("utf-8");
          $conditions = array('item' => 10);
          $pref_arr = $this->Item->find('list', array('fields' => array( 'id', 'value'), 'conditions' => $conditions));
          $this->set('pref_arr', $pref_arr); 

      // post時の処理
      if ($this->request->is('post') || $this->request->is('put')) {
          $this->redirect(array('action' => 'reg1'));
      } else {

      }
    }
  
  public function edit($id) {
    // レイアウト関係
    $this->layout = "sub";
    $this->set("title_for_layout",$this->title_for_layout);
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
  
  /*
   * アップロード処理
   */
   public function uptest($msg = null){
        $this->set('msg', '');
       
   }
   
  public function upload(){
        $this->autoRender = false;
        
        $ds          = DIRECTORY_SEPARATOR;  //1
        $storeFolder = 'files';   //2
        if(!empty($_FILES)){
                $tempFile = $_FILES['upfile']['tmp_name'];//3
                $info = new SplFileInfo($_FILES['upfile']['name']);
                $after = $info->getExtension();
                
                $targetPath = $storeFolder . $ds;  //4
                //$targetFile =  $targetPath. $_FILES['upfile']['name'];  //5
                $targetFile =  $targetPath. '34567.'.$after;  //5
                move_uploaded_file($tempFile,$targetFile); //6
                
                $this->redirect($this->referer());
        }
        /*
        if (is_uploaded_file($_FILES["upfile"]["tmp_name"])) {
            if (move_uploaded_file($_FILES["upfile"]["tmp_name"], "files/" . $_FILES["upfile"]["name"])) {
              chmod("files/" . $_FILES["upfile"]["name"], 0644);
              //$this->Session->setFlash( $_FILES["upfile"]["name"] . "をアップロードしました。");
              $this->redirect($this->referer());
            } else {
              $this->Session->setFlash( $_FILES["upfile"]["name"] . "ファイルをアップロードできません。");
              $this->redirect($this->referer());
            }
            } else {
              $this->Session->setFlash( $_FILES["upfile"]["name"] . "ファイルが選択されていません。");
              $this->redirect($this->referer());
        } 
         * 
         */   
  }
  
  /*** ディレクトリの存在をチェック ***/
  static public function chkDirectory($dirpath,$create_flg = true){
    $return = false;
    if(file_exists($dirpath)){
      $return = true;
    }
    if(!$return){
      if($create_flg){
        mkdir($dirpath, 0777);
        chmod($dirpath, 0777);
      }
      $return = true;
    }
    return $return;
  }
}
