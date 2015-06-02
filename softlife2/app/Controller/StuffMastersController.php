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
    public $uses = array('StuffMaster', 'User', 'Item');
    // Paginationの設定（スタッフマスタ）
    public $paginate = array(
    //モデルの指定
    'StuffMaster' => array(
    //1ページ表示できるデータ数の設定
    'limit' =>10,
    'fields' => array('StuffMaster.*', 'User.name_sei AS koushin_name_sei', 'User.name_mei AS koushin_name_mei'),
    //データを降順に並べる
    'order' => array('id' => 'asc'),
    'joins' => array (
            array (
                'type' => 'LEFT',
                'table' => 'users',
                'alias' => 'User',
                'conditions' => 'StuffMaster.username = User.username' 
            ))
    )); 
    // Paginationの設定（スタッフ詳細） 
    public $paginate2 = array (
    //モデルの指定
    'StuffMaster' => array(
    //1ページ表示できるデータ数の設定
    'limit' =>1,
    //データを降順に並べる
    'order' => array('id' => 'asc'),
    )); 
    
    static public $selected_class;
    
    public $title_for_layout = "スタッフマスタ - 派遣管理システム";

    public function index($flag = null) {
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
        // 引数の受け取り
        if (isset($this->params['named']['limit'])) {
            $limit = $this->params['named']['limit'];
        } else {
            $limit = '10';
        }
        // 表示件数の初期値
        $this->set('limit', $limit);

        // POSTの場合
        if ($this->request->is('post') || $this->request->is('put')) {
            // 所属の変更
            if (isset($this->request->data['class'])) {
                $this->selected_class = $this->request->data['class'];
                //$this->Session->setFlash($class);
                $this->set('selected_class', $this->selected_class);
                $this->Session->write('selected_class', $this->selected_class);
                //$this->Session->setFlash($class);
                // テーブル変更
                $this->setTable($this->selected_class);
            }
            // 検索処理
            if(isset($this->request->data['search1'])) {
                $this->Session->setFlash($this->request->data['StuffMaster']['search_age_lower'].'-'.$this->request->data['StuffMaster']['search_age_upper']);
            } elseif (isset($this->request->data['search2'])) {
                $this->Session->setFlash($this->request->data['StuffMaster']['search_age_lower'].'-'.$this->request->data['StuffMaster']['search_age_upper']);
            }
            // 表示件数
            if (isset($this->request->data['limit'])) {
                $limit = $this->request->data['limit'];
                $this->set('limit', $limit);
                $this->redirect(array('limit' => $limit));
                /**
                //ページネーションの再設定
                $this->paginate = array(
                    //モデルの指定
                    'StuffMaster' => array(
                    //1ページ表示できるデータ数の設定
                    'limit' =>$limit,
                    'fields' => array('StuffMaster.*', 'User.name_sei AS koushin_name_sei', 'User.name_mei AS koushin_name_mei'),
                    //データを降順に並べる
                    'order' => array('id' => 'asc'),
                    'joins' => array (
                            array (
                                'type' => 'LEFT',
                                'table' => 'users',
                                'alias' => 'User',
                                'conditions' => 'StuffMaster.username = User.username' 
                            ))
                    ));
                 * 
                 */ 
            }
            // 登録番号で検索
            if (isset($this->data['StuffMaster']['search_id']) && !empty($this->data['StuffMaster']['search_id'])){
                $search_id = $this->data['StuffMaster']['search_id'];
                $conditions = array('id' => $search_id);
                $this->set('datas', $this->paginate('StuffMaster',$conditions));
            // 氏名で検索
            } elseif (isset($this->data['StuffMaster']['search_name']) && !empty($this->data['StuffMaster']['search_name'])){
                $search_name = $this->data['StuffMaster']['search_name'];
                $conditions = array( 'OR' => array('concat("StuffMaster.name_sei", " ", "StuffMaster.name_mei") LIKE ' => '%'.$search_name.'%'));
                $this->set('datas', $this->paginate('StuffMaster',$conditions)); 
                // ログ出力
                $this->log($this->StuffMaster->getDataSource()->getLog(), LOG_DEBUG);
            // 年齢で検索
            } elseif (isset($this->data['StuffMaster']['search_age']) && !empty($this->data['StuffMaster']['search_age'])){
                $search_age = $this->data['StuffMaster']['search_age'];
                $conditions = array('StuffMaster.birthday' => '%'.$search_age.'%');
                $this->set('datas', $this->paginate('StuffMaster',$conditions)); 
                // ログ出力
                $this->log($this->StuffMaster->getDataSource()->getLog(), LOG_DEBUG);
            // 担当者で検索
            } elseif (isset($this->data['txtTantou']) && !empty($this->data['txtTantou'])){
                $tantou = $this->data['txtTantou'];
                $conditions = array('tantou LIKE ' => $tantou);
                $this->set('datas', $this->paginate('StuffMaster',$conditions));      
            } else {
                if ($flag == '1') {
                    $conditions = array('kaijo_flag' => 1);
                } else {
                    $conditions = array('kaijo_flag' => 0);
                }
                $this->set('flag', $flag);
                $this->set('datas', $this->paginate('StuffMaster',$conditions));
                //$this->redirect(array('action' => '.'));
            }
        } else {
            // 所属の取得とセット
            $this->selected_class = $this->Session->read('selected_class');
            $this->set('selected_class', $this->selected_class);
            // テーブル変更
            $this->setTable($this->selected_class);
            // 初期表示
            if ($flag == '1') {
                $conditions = array('kaijo_flag' => 1);
            } else {
                $conditions = array('kaijo_flag' => 0);
            }
            $this->set('flag', $flag);
            $this->set('datas', $this->paginate('StuffMaster',$conditions));
        }
        $this->set('selected_class', $this->Session->read('selected_class'));
        
      }

    
    // プロフィールページ
    public function profile($stuff_id = null) {
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
          $this->set('id', $stuff_id); 
          // テーブルの設定
          //$this->setTable('stuff_'.$this->Session->read('selected_class'));
          //$this->log('stuff_'.$this->Session->read('selected_class'), LOG_DEBUG);

        // ページネーション
        if (isset($stuff_id)){
            $conditions = array('id' => $stuff_id);
            $this->set('datas', $this->paginate('StuffMaster',$conditions));
        } else {
            $this->Session->setFlash('ページ表示時にエラーが発生しました。');
        }
        
        // post時の処理
        if ($this->request->is('post') || $this->request->is('put')) {
            if (isset($this->request->data['submit'])) {
                $this->redirect(array('action' => 'reg1', $stuff_id));
            } elseif (isset($this->request->data['release'])) {
                $this->StuffMaster->save($this->request->data);
                //$this->redirect();
                $this->Session->setFlash('登録解除しました。');
            }
            
        } else {

        }
    }
    
    // 登録ページ（その１）
    public function reg1($stuff_id = null) {
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
          $this->set('stuff_id', $stuff_id); 
          $this->StuffMaster->id = $stuff_id;
          $this->set('username', $this->Auth->user('username')); 
          //$this->StuffMaster->id = $stuff_id;
          // テーブルの設定
          //$this->setTable($this->selected_class);

      // post時の処理
      if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->StuffMaster->validates() == false) {
                exit();
            }
            if (isset($this->request->data['submit'])) {
                // モデルの状態をリセットする
                //$this->StuffMaster->create();
                // データを登録する
                if ($this->StuffMaster->save($this->request->data)) {
                    if (isset($stuff_id)) {
                    // 登録したIDを取得
                        $id = $stuff_id;
                    } else {
                        $id = $this->StuffMaster->getLastInsertID();
                    } 
                    // 登録２にリダイレクト
                    $this->redirect(array('action' => 'reg2', $id));
                } else {
                    $this->Session->setFlash('登録時にエラーが発生しました。');
                }
            }
          
      } else {
          // 登録していた値をセット
          $this->request->data = $this->StuffMaster->read(null, $stuff_id);
      }
    }
    
    // 登録ページ（その２）
    public function reg2($stuff_id = null) {
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
        $this->set('stuff_id', $stuff_id); 
        // 初期値設定
        $this->set('datas', $this->StuffMaster->find('first', 
                array('fields' => array('created', 'modified'), 'conditions' => array('id' => $stuff_id) )));
        $this->set('username', $this->Auth->user('username')); 
        $this->set('class', $this->getClass($this->Session->read('selected_class')));
        // テーブルの設定
        //$this->setTable($this->selected_class);

        // ファイルアップロード処理の初期セット
        $ds = DIRECTORY_SEPARATOR;  //1
        $storeFolder = 'files/stuff_reg'.$ds.$stuff_id.$ds;   //2
        
        // post時の処理
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->StuffMaster->validates() == false) {
                exit();
            }

            // 職種のセット
            $val1 = $this->setShokushu($this->request->data['StuffMaster']['shokushu_shoukai']);
            $val2 = $this->setShokushu($this->request->data['StuffMaster']['shokushu_kibou']);
            $val3 = $this->setShokushu($this->request->data['StuffMaster']['shokushu_keiken']);
            // その他の職業セット
            $val4 = $this->setShokushu($this->request->data['StuffMaster']['extra_job']);
            // 勤務可能曜日
            $val5 = $this->setShokushu($this->request->data['StuffMaster']['workable_day']);
            
            $this->request->data['StuffMaster']['shokushu_shoukai'] = $val1;
            $this->request->data['StuffMaster']['shokushu_kibou'] = $val2;
            $this->request->data['StuffMaster']['shokushu_keiken'] = $val3;
            $this->request->data['StuffMaster']['extra_job'] = $val4;
            $this->request->data['StuffMaster']['workable_day'] = $val5;
            
            if (isset($this->request->data['submit'])) {
                $_after = null;
                $_after2 = null;
                // ファイルのアップロード
                if(!empty($_FILES['upfile']['name'][0] || !empty($_FILES['upfile']['name'][1]))){
                    // ディレクトリがなければ作る
                    if ($this->chkDirectory($storeFolder, true) == false) {
                        $this->Session->setFlash('ファイルのアップロードに失敗しました。');
                        $this->redirect($this->referer());
                        exit();
                    }
                    $count = count($_FILES['upfile']['name']);
                    for ($i=0; $i<$count; $i++) {
                        $tempFile = $_FILES['upfile']['tmp_name'][$i];//3
                        $info = new SplFileInfo($_FILES['upfile']['name'][$i]);
                        $after = $info->getExtension();
                        if ($i == 0) {
                            if (!empty($after)) {
                                $_after = $after;
                            }
                        } elseif ($i == 1) {
                            if (!empty($after)) {
                                $_after2 = $after;
                            }
                        } 
                        
                        $targetPath = $storeFolder.$ds;  //4
                        //$targetFile =  $targetPath. mb_convert_encoding($_FILES['upfile']['name'][$i], 'sjis-win', 'UTF-8');  //5
                        $targetFile =  $targetPath.$stuff_id.'.'.$after;  //5
                        // ファイルアップ実行
                        if (move_uploaded_file($tempFile, $targetFile)) {
                            // アップの成功
                            $this->log('ファイルのアップロードに成功しました：'.$stuff_id, LOG_DEBUG);
                        } else {
                            // アップの失敗
                            $this->log('ファイルのアップロードに失敗しました。'.$stuff_id, LOG_DEBUG);
                        }
                    }
                }
                // 写真ファイルの拡張子セット
                if (is_null($_after) == false) {
                    $this->request->data['StuffMaster']['pic_extension'] = $_after;
                }
                // 履歴書ファイルの拡張子セット
                if (is_null($_after2) == false) {
                    $this->request->data['StuffMaster']['pic_extension2'] = $_after2;
                }
            } else {
                /**
                $this->Session->setFlash('「証明写真」か「履歴書」のファイルが選択されていません。');
                $this->redirect($this->referer());
                exit();
                 * 
                 */
            }
                
            // モデルの状態をリセットする
            $this->StuffMaster->create();
            // データを登録する
            if ($this->StuffMaster->save($this->request->data)) {
                // 登録したIDを取得
                //$id = $this->StuffMaster->getLastInsertID();
                // 登録２にリダイレクト
                $this->redirect(array('action' => 'reg3', $stuff_id));
            } else {
                $this->Session->setFlash('登録時にエラーが発生しました。');
            }

        } else {
            // 登録していた値をセット
            $this->request->data = $this->StuffMaster->read(null, $stuff_id);
            $this->set('data', $this->request->data);
            //$this->set('selected', array(1,3,7));
        }
        

    }
    
    // 登録ページ（その３）
    public function reg3($stuff_id = null) {
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
          $this->set('stuff_id', $stuff_id);
        // 初期値設定
        $this->set('datas', $this->StuffMaster->find('first', 
                array('fields' => array('created', 'modified'), 'conditions' => array('id' => $stuff_id) )));
        $this->set('username', $this->Auth->user('username')); 
        $this->set('class', $this->getClass($this->Session->read('selected_class')));
        // テーブルの設定
        //$this->setTable($this->selected_class);

        // post時の処理
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->StuffMaster->validates() == false) {
                exit();
            }
            if (isset($this->request->data['submit'])) {
                // モデルの状態をリセットする
                //$this->StuffMaster->create();
                // データを登録する
                if ($this->StuffMaster->save($this->request->data)) {
                    // 登録したIDを取得
                    //$id = $this->StuffMaster->getLastInsertID();
                    // 登録完了メッセージ
                    $this->Session->setFlash('登録がすべて完了しました。');
                } else {
                    $this->Session->setFlash('登録時にエラーが発生しました。');
                }
            }

        } else {
          // 登録していた値をセット
          $this->request->data = $this->StuffMaster->read(null, $stuff_id);
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
  
  /*** 年齢から生年月日の最小値を得る ***/
  static public function getMinBirth($age){
    $ret = '1900-01-01';
    // セットされていれば年月日に変換
    if(isset($age)){
      $ret = true;
    }
      return $ret;
    }
    
    /*** 職種をカンマ区切りに ***/
    static public function setShokushu($val){
        $ret = '';
        if (!empty($val)) {
            foreach ($val as $value) {
                $ret = $ret.', '.$value;  
            }
        }
        return $ret;
    }
  
    /*** 所属の検索 ***/
    public function getClass($val){
        $class = '';
        
        if (!empty($val)) {
            // 所属を配列に
            $conditions = array('item' => 2, 'id' => $val);
            $data = $this->Item->find('first', array('fields' => array('value'), 'conditions' => $conditions));
            $class = $data['Item']['value'];
        }
        return $class;
    } 
    
    /*** 所属により参照するテーブルを変更 ***/
    public function setTable($val){
        $tablename = '';
        if (isset($val) && $val != 0) {
            $tablename = 'stuff_'.$val;
            $this->StuffMaster->setSource($tablename);
        } else {
            $this->StuffMaster->setSource('stuff_00');
        }
    }    
}
