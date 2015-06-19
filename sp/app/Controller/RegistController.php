<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

/**
 * CakePHP RegistController
 * @author M-YOKOI
 */
class RegistController extends AppController {
    public $uses = array('StaffPreregist', 'User', 'Item', 'StaffPreregistLog');

    public function index() {
        $this->redirect('page1');
        
    }

    public function page1($staff_id = null) {
        // レイアウト関係
        $this->layout = "main_pc";
        $this->set("title_for_layout","スタッフ仮登録 - 入力１");
        // テーブルの設定
        //$this->StaffPreregist->setSource('staff_preregist');
        // 初期値設定
        $datas = $this->StaffPreregist->find('first', array('fields' => array('*'), 'conditions' => array('id' => $staff_id)));
        $this->set('datas', $datas);
        $username = 0;
        // 都道府県のセット
        $pref_arr = $this->Item->find('list', array('fields' => array( 'id', 'value'), 'conditions' => array('item' => '10')));
        $this->set('pref_arr', $pref_arr);
        // post時の処理
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->log($this->request->data, LOG_DEBUG);
            if ($this->StaffPreregist->validates() == false) {
                return;
            }
            // パスワードの同一性チェック
            if ($this->request->data['StaffPreregist']['password'] != $this->request->data['StaffPreregist']['password2']) {
                $this->Session->setFlash('パスワードが一致しません。');
                return;
            }
            // 値のセット
            $selected_class = $this->request->data['StaffPreregist']['area'].'1';     // 人材派遣に限る
            $this->request->data['StaffPreregist']['class'] =$selected_class;
            // データを登録する
            if ($this->StaffPreregist->save($this->request->data)) {
                if (is_null($staff_id)) {
                    // 新規登録したIDを取得
                    $id = $this->StaffPreregist->getLastInsertID();
                } else {
                    $id = $staff_id;
                }
                // ログ書き込み
                $this->setSMLog($username, $selected_class, $id, $this->request->data['StaffPreregist']['name_sei'].' '.$this->request->data['StaffPreregist']['name_mei'], 
                        9, 31, $this->request->clientIp()); // 仮登録１コード:31
                // 登録２にリダイレクト
                $this->redirect(array('action' => 'page2', $id));
            } else {
                $this->Session->setFlash('登録時にエラーが発生しました。');
            }
        } else {
            // 登録していた値をセット
            $this->request->data = $this->StaffPreregist->read(null, $staff_id);
            $this->request->data['StaffPreregist']['area'] = substr($this->request->data['StaffPreregist']['class'], 0, 1);
        }
        
    }
    
    public function page2($staff_id = null) {
        // レイアウト関係
        $this->layout = "main_pc";
        $this->set("title_for_layout", "スタッフ仮登録 - 入力２");
        // テーブルの設定
        //$this->StaffPreregist->setSource('staff_preregist');
        // 初期値設定
        $datas = $this->StaffPreregist->find('first', array('fields' => array('*'), 'conditions' => array('id' => $staff_id)));
        //$this->log($datas, LOG_DEBUG);
        $this->set('datas', $datas); 
        $username = 0;
        // 所属
        //$staff_id = 11;      // テスト用
        //$selected_class = 11;     // テスト用
        $selected_class = $datas['StaffPreregist']['class'];
        $this->set("staff_id", $staff_id); 
        //$this->set('class_name', $this->getClass($selected_class));
        $this->set('class', $selected_class);

        // 都道府県のセット
        if (substr($selected_class, 0 ,1) == 1) {
            // 大阪（関西地方）
            $conditions = array('item' => 10, 'AND' => array('id >= ' => 24, 'id <= ' => 30));
        } elseif (substr($selected_class, 0, 1) == 2) {
            // 東京（関東地方）
            $conditions = array('item' => 10, 'AND' => array('id >= ' => 8, 'id <= ' => 14));
        } elseif (substr($selected_class, 0, 1) == 3) {
            // 名古屋（中部地方）
            $conditions = array('item' => 10, 'AND' => array('id >= ' => 15, 'id <= ' => 24));
        } else {
            $conditions = null;
        }
        $pref_arr = $this->Item->find('list', array('fields' => array( 'id', 'value'), 'conditions' => $conditions));
        $this->set('pref_arr', $pref_arr); 
        // 職種マスタ配列
        $conditions2 = array('item' => 16);
        $list_shokushu = $this->Item->find('list', array('fields' => array( 'id', 'value'), 'conditions' => $conditions2));
        $this->set('list_shokushu', $list_shokushu); 
        
        // ファイルアップロード処理の初期セット
        $ds = DIRECTORY_SEPARATOR;  //1
        $storeFolder = 'files/staff_prereg'.$ds.sprintf('%010d', $staff_id).$ds;   //2
        
        // post時の処理
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->StaffPreregist->validates() == false) {
                exit();
            }           
            if (isset($this->request->data['submit'])) {
                $_after = null;
                $_after2 = null;
                // ファイルのアップロード
                if(!empty($_FILES['upfile']['name'][0]) || !empty($_FILES['upfile']['name'][1])){
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
                        $targetFile =  $targetPath.$staff_id.'.'.$after;  //5
                        // ファイルアップ実行
                        if (move_uploaded_file($tempFile, $targetFile)) {
                            // アップの成功
                            $this->log('ファイルのアップロードに成功しました：'.$staff_id);
                        } else {
                            // アップの失敗
                            $this->log('ファイルのアップロードに失敗しました。'.$staff_id);
                        }
                    }
                }
                // 写真ファイルの拡張子セット
                if (is_null($_after) == false) {
                    $this->request->data['StaffPreregist']['pic_extension'] = $_after;
                }
                // 履歴書ファイルの拡張子セット
                if (is_null($_after2) == false) {
                    $this->request->data['StaffPreregist']['pic_extension2'] = $_after2;
                }
                // 職種のセット
                $val1 = $this->setShokushu($this->request->data['StaffPreregist']['shokushu_shoukai']);
                $val2 = $this->setShokushu($this->request->data['StaffPreregist']['shokushu_kibou']);
                $val3 = $this->setShokushu($this->request->data['StaffPreregist']['shokushu_keiken']);
                // その他の職業セット
                $val4 = $this->setShokushu($this->request->data['StaffPreregist']['extra_job']);
                // 勤務可能曜日
                $val5 = $this->setShokushu($this->request->data['StaffPreregist']['workable_day']);
                // きっかけ
                $val6 = $this->setShokushu($this->request->data['StaffPreregist']['regist_trigger']);
                // セット
                $this->request->data['StaffPreregist']['shokushu_shoukai'] = $val1;
                $this->request->data['StaffPreregist']['shokushu_kibou'] = $val2;
                $this->request->data['StaffPreregist']['shokushu_keiken'] = $val3;
                $this->request->data['StaffPreregist']['extra_job'] = $val4;
                $this->request->data['StaffPreregist']['workable_day'] = $val5;
                $this->request->data['StaffPreregist']['regist_trigger'] = $val6;
                // 駅を未入力ならばNULLをセットする
                if (empty($this->request->data['StaffPreregist']['s1_1'])) {
                    //$this->request->data['StaffPreregist']['pref1'] = null;
                    //$this->request->data['StaffPreregist']['s0_1'] = null;
                    $this->request->data['StaffPreregist']['s1_1'] = null;
                }
                if (empty($this->request->data['StaffPreregist']['s1_2'])) {
                    //$this->request->data['StaffPreregist']['pref2'] = null;
                    //$this->request->data['StaffPreregist']['s0_2'] = null;
                    $this->request->data['StaffPreregist']['s1_2'] = null;
                }
                if (empty($this->request->data['StaffPreregist']['s1_3'])) {
                    //$this->request->data['StaffPreregist']['pref3'] = null;
                    //$this->request->data['StaffPreregist']['s0_3'] = null;
                    $this->request->data['StaffPreregist']['s1_3'] = null;
                }
                // モデルの状態をリセットする
                //$this->StaffPreregist->create();
                // データを登録する
                if ($this->StaffPreregist->save($this->request->data)) {
                    // 登録したIDを取得
                    //$id = $this->StaffPreregist->getLastInsertID();
                    // ログ書き込み
                    $this->setSMLog($username, $selected_class, $staff_id, $this->request->data['StaffPreregist']['name_sei'].' '.$this->request->data['StaffPreregist']['name_mei'], 
                        9, 32, $this->request->clientIp()); // 仮登録２コード:32
                    // 登録２にリダイレクト
                    //$this->redirect(array('action' => 'reg3', $staff_id, $koushin_flag));
                    // 登録完了メッセージ
                    $this->Session->setFlash('登録しました。');
                    $this->redirect(array('action' => 'page2', $staff_id));
                } else {
                    $this->Session->setFlash('登録時にエラーが発生しました。');
                }
            } else {
                /**
                $this->Session->setFlash('「証明写真」か「履歴書」のファイルが選択されていません。');
                $this->redirect($this->referer());
                exit();
                 * 
                 */
            }

        } else {
            // 登録していた値をセット
            $this->request->data = $this->StaffPreregist->read(null, $staff_id);
            $this->set('data', $this->request->data);
            //$this->set('selected', array(1,3,7));
        }
    }
    
    public function page3($staff_id = null) {
        // レイアウト関係
        $this->layout = "main_pc";
        $this->set("title_for_layout","スタッフ仮登録 - 入力２"); 
        $this->set("staff_id", $staff_id); 
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
    
    /*** 職種をカンマ区切りに ***/
    static public function setShokushu($val){
        $ret = '';
        if (!empty($val)) {
            foreach ($val as $value) {
                $ret = $ret.','.$value;  
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
    
    /** マスタ更新ログ書き込み **/
    public function setSMLog($username, $class, $staff_id, $staff_name, $kaijo_flag, $status, $ip_address) {
        $sql = '';
        $sql = $sql. ' INSERT INTO staff_master_logs (username, class, staff_id, staff_name, kaijo_flag, status, ip_address, created)';
        $sql = $sql. ' VALUES ('.$username.', '.$class.', '.$staff_id.', "'.$staff_name.'", '.$kaijo_flag.', '.$status.', "'.$ip_address.'", now())';
        
        // sqlの実行
        $ret = $this->StaffPreregistLog->query($sql);
        
        return $ret;
    }
    
    public function beforeFilter(){
        parent::beforeFilter();

        //未ログインでアクセスできるアクションを指定
        //これ以外のアクションへのアクセスはloginにリダイレクトされる規約になっている
        $this->Auth->allow('page1', 'page2');
    }
}
