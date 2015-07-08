<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

/**
 * CakePHP CaseManagementController
 * @author M-YOKOI
 */
class CaseManagementController extends AppController {
    public $uses = array('Item', 'StaffMaster', 'User', 'Customer');
    
    static public $selected_class;
    public $title_for_layout = "案件管理 - 派遣管理システム";
    
    public $paginate = array (
    'Item' => array (
        'limit' => 10,
        'order' => 'id',
        'fields' => '*'
        ), 
        "Role" => array() 
    );

    public function index($flag = null, $staff_id = null, $profile = null) {
        // 所属が選択されていなければ元の画面に戻す
        if (is_null($this->Session->read('selected_class')) || $this->Session->read('selected_class') == '0') {
            //$this->log($this->Session->read('selected_class'));
            $this->Session->setFlash('右上の所属を選んでください。');
            $this->redirect($this->referer());
        }
        // レイアウト関係
        $this->layout = "main";
        $this->set("title_for_layout", $this->title_for_layout);
        // タブの状態
        $this->set('active1', '');
        $this->set('active2', '');
        $this->set('active3', '');
        $this->set('active4', 'active');
        $this->set('active5', '');
        $this->set('active6', '');
        $this->set('active7', '');
        $this->set('active8', '');
        $this->set('active9', '');
        $this->set('active10', '');
        // 絞り込みセッションを消去
        $this->Session->delete('filter');
        // ユーザー名前
        $name = $this->Auth->user('name_sei').' '.$this->Auth->user('name_mei');
        $this->set('user_name', $name);
        $selected_class = $this->Session->read('selected_class');
        // 都道府県のセット
        if (substr($selected_class, 0 ,1) == 1) {
            // 大阪（関西地方）
            $conditions1 = array('item' => 10, 'AND' => array('id >= ' => 24, 'id <= ' => 30));
        } elseif (substr($selected_class, 0, 1) == 2) {
            // 東京（関東地方）
            $conditions1 = array('item' => 10, 'AND' => array('id >= ' => 8, 'id <= ' => 14));
        } elseif (substr($selected_class, 0, 1) == 3) {
            // 名古屋（中部地方）
            $conditions1 = array('item' => 10, 'AND' => array('id >= ' => 15, 'id <= ' => 24));
        }
        $pref_arr = $this->Item->find('list', array('fields' => array( 'id', 'value'), 'conditions' => $conditions1));
        $this->set('pref_arr', $pref_arr);
        // 登録担当者配列
        //$this->log($this->getTantou(), LOG_DEBUG);
        $this->set('getTantou', $this->getTantou());
        // テーブルの設定
        $this->StaffMaster->setSource('staff_'.$selected_class);
        // 引数の受け取り
        if (isset($this->params['named']['limit'])) {
            $limit = $this->params['named']['limit'];
        } else {
            $limit = '10';
        }
        // 登録担当者
        $conditions = array('area' => substr($selected_class, 0, 1));
        $this->User->virtualFields['name'] = 'CONCAT(name_sei, " ", name_mei)';
        $name_arr = $this->User->find('list', array('fields' => array('username', 'name'), 'conditions' => $conditions));
        $this->set('name_arr', $name_arr); 
        // 表示件数の初期値
        $this->set('limit', $limit);
        $conditions1 = null;$conditions2 = null;$conditions3 = null;
        $line1 = null;$line2 = null;$line3 = null;
        $station1 = null;$station2 = null;$station3 = null;
        $array_11 = null;$array_12 = null;$array_13 = null;
        $array_21 = null;$array_22 = null;$array_23 = null;
        $array_31 = null;$array_32 = null;$array_33 = null;
        // Paginationの設定
        $this->paginate = array(
        //モデルの指定
        'StaffMaster' => array(
        //1ページ表示できるデータ数の設定
        'limit' =>10,
        'fields' => array('StaffMaster.*', 'User.name_sei AS koushin_name_sei', 'User.name_mei AS koushin_name_mei'),
        //データを降順に並べる
        'order' => array('id' => 'asc'),
        'joins' => array (
                array (
                    'type' => 'LEFT',
                    'table' => 'users',
                    'alias' => 'User',
                    'conditions' => 'StaffMaster.username = User.username' 
                ))
        )); 
        
        //$this->log($this->request, LOG_DEBUG);
        // POSTの場合
        if ($this->request->is('post') || $this->request->is('put')) {
            // 初期表示
            if ($flag == 1) {
                $conditions2 = array('kaijo_flag' => 1);
            } else {
                $flag = 0;
                $conditions2 = array('kaijo_flag' => 0);
            }
            $this->set('flag', $flag);
            
            // 絞り込み
            if(isset($this->request->data['search1'])) {
                // 登録番号で検索
                if (!empty($this->data['StaffMaster']['search_id'])){
                    $search_id = $this->data['StaffMaster']['search_id'];
                    $conditions2 += array('id' => $search_id);
                }
                // 氏名で検索
                if (!empty($this->data['StaffMaster']['search_name'])){
                    $search_name = $this->data['StaffMaster']['search_name'];
                    //$conditions2 += array( 'OR' => array(array('StaffMaster.name_sei LIKE ' => '%'.$search_name.'%'), array('StaffMaster.name_mei LIKE ' => '%'.$search_name.'%')));
                    $conditions2 += array('CONCAT(StaffMaster.name_sei, StaffMaster.name_mei) LIKE ' => '%'.preg_replace('/(\s|　)/','',$search_name).'%');
                    //$this->log(preg_replace('/(\s|　)/','',$search_name), LOG_DEBUG);
                }
                // 年齢で検索
                if (!empty($this->data['StaffMaster']['search_age'])){
                    $search_age = $this->data['StaffMaster']['search_age'];
                    $conditions2 += array('StaffMaster.age' => $search_age);
                }
                // 都道府県
                if (!empty($this->data['StaffMaster']['search_area'])){
                    $search_area = $this->data['StaffMaster']['search_area'];
                    //$this->log($search_area);
                    $conditions2 += array('CONCAT(StaffMaster.address1_2, StaffMaster.address2) LIKE ' => '%'.preg_replace('/(\s|　)/','',$search_area).'%');
                }
            // 担当者で絞り込み
            } elseif (!empty($this->data['StaffMaster']['search_tantou'])){
                $search_tantou = $this->data['StaffMaster']['search_tantou'];
                $conditions2 += array('StaffMaster.tantou' => $search_tantou);
            // 年齢での絞り込み
            } elseif (isset($this->request->data['search2'])) {
                //$this->Session->setFlash($this->request->data['StaffMaster']['search_age_lower'].'-'.$this->request->data['StaffMaster']['search_age_upper']);
                $lower = $this->request->data['StaffMaster']['search_age_lower'];
                $upper = $this->request->data['StaffMaster']['search_age_upper'];
                if (!empty($lower) && !empty($upper)) {
                    $conditions2 += array(
                        array('StaffMaster.age >=' => $this->request->data['StaffMaster']['search_age_lower']), 
                        array('StaffMaster.age <= ' => $this->request->data['StaffMaster']['search_age_upper']));
                } elseif (!empty($lower) && empty($upper)) {
                    $conditions2 += array('StaffMaster.age >=' => $this->request->data['StaffMaster']['search_age_lower']);
                } elseif (empty($lower) && !empty($upper)) {
                    $conditions2 += array('StaffMaster.age <= ' => $this->request->data['StaffMaster']['search_age_upper']);
                } else {
                    $this->Session->setFlash('年齢を入力してください。');
                }
            // 所属の変更
            } elseif (isset($this->request->data['class'])) {
                $this->selected_class = $this->request->data['class'];
                //$this->Session->setFlash($class);
                $this->set('selected_class', $this->selected_class);
                $this->Session->write('selected_class', $this->selected_class);
                // テーブル変更
                $this->StaffMaster->setSource('staff_'.$this->Session->read('selected_class'));
                $this->redirect(array('page' => 1));  
            // 表示件数の変更
            } elseif (isset($this->request->data['limit'])) {
                $limit = $this->request->data['limit'];
                $this->set('limit', $limit);
                $this->redirect(array('limit' => $limit));
            }

            // 年齢の計算
            $this->setAge($this->Session->read('selected_class'));
            // ページネーションの実行
            //$this->request->params['named']['page'] = 1;
            $this->set('datas', $this->paginate('StaffMaster', $conditions2));
            $this->log($this->StaffMaster->getDataSource()->getLog(), LOG_DEBUG);
            
        } elseif ($this->request->is('get')) {
            // プロフィールページへ
            if (isset($profile)) {
                // ページ数（レコード番号）を取得
                $conditions1 = array('kaijo_flag' => $flag, 'id <= ' => $staff_id);
                $page = $this->StaffMaster->find('count', array('fields' => array('*'), 'conditions' => $conditions1));
                //$this->log($this->StaffMaster->getDataSource()->getLog(), LOG_DEBUG);
                //$this->log($page, LOG_DEBUG);
                $this->redirect(array('action' => 'profile', $flag, $staff_id, 'page' => $page));
                exit();
            }
            // テーブル変更
            $this->StaffMaster->setSource('staff_'.$this->Session->read('selected_class'));
            // 年齢の計算
            $this->setAge($this->Session->read('selected_class'));
            // 初期表示
            if ($flag == 1) {
                $conditions3 = array('kaijo_flag' => 1);
            } else {
                $flag = 0;
                $conditions3 = array('kaijo_flag' => 0);
            }
            $this->set('flag', $flag);
            // 絞り込み条件の適応
            if($this->Session->check('filter')) {
                $filter = $this->Session->read('filter');
                if ($filter == '0') {
                    $conditions3 = $conditions3;
                } else {
                    $conditions3 = $conditions3 + $filter;
                }
            } else {
                $conditions3 = $conditions3;
            }
            //$this->request->params['named']['page'] = 1;
            $this->set('datas', $this->paginate('StaffMaster', $conditions3)); 
            //$this->log('GET', LOG_DEBUG);
        } else {
            // 所属の取得とセット
            //$this->selected_class = $this->Session->read('selected_class');
            //$this->set('selected_class', $this->selected_class);
            // テーブル変更
            $this->StaffMaster->setSource('staff_'.$this->Session->read('selected_class'));
            // 年齢の計算
            $this->setAge($this->Session->read('selected_class'));
            // 初期表示
            if ($flag == 1) {
                $conditions3 = array('kaijo_flag' => 1);
            } else {
                $flag = 0;
                $conditions3 = array('kaijo_flag' => 0);
            }
            $this->set('flag', $flag);
            //$this->request->params['named']['page'] = 1;
            $this->set('datas', $this->paginate('StaffMaster', $conditions3));
            //$this->log($this->StaffMaster->getDataSource()->getLog(), LOG_DEBUG);
            //$this->log('そと通ってる', LOG_DEBUG);
        }
        $this->set('selected_class', $this->Session->read('selected_class'));
        
        // 路線・駅のコンボ値セット
        $this->set('line1', $line1);
        $this->set('line2', $line2);
        $this->set('line3', $line3);
        $this->set('station1', $station1);
        $this->set('station2', $station2);
        $this->set('station3', $station3);        
      }
    
    /** 案件情報 **/
    public function profile($flag = null, $case_id = null) {
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
        $this->set('id', $case_id); 
        $username = $this->Auth->user('username');
        $this->set('username', $username); 
        // テーブルの設定
        $selected_class = $this->Session->read('selected_class');
        $this->StaffMaster->setSource('staff_'.$selected_class);
        $this->set('class', $selected_class);
                
        // ページネーション
        //$conditions2 = array('id' => $case_id, 'kaijo_flag' => $flag);
        //$conditions2 = array('kaijo_flag' => $flag);
        $conditions2 = null;
        $this->paginate = array('StaffMaster' => array(
            'fields' => '*' ,
            'limit' =>  '1',
            //'page' => $page,
            'order' => 'id',
            'conditions' => $conditions2
        ));
        $datas = $this->paginate('StaffMaster');
        $this->set('datas', $datas);
        
        // post時の処理
        if ($this->request->is('post') || $this->request->is('put')) {
            // 登録編集
            if (isset($this->request->data['submit'])) {
                $this->redirect(array('action' => 'reg1', $this->request->data['StaffMaster']['$case_id'], 1));
            // 登録解除
            } elseif (isset($this->request->data['release'])) {
                $sql = '';
                $sql = $sql.' UPDATE staff_'.$selected_class; 
                $sql = $sql.' SET kaijo_flag = 1, modified = CURRENT_TIMESTAMP()';  
                $sql = $sql.' WHERE id = '.$this->request->data['StaffMaster']['$case_id'];
                $this->log($sql, LOG_DEBUG);
                $this->StaffMaster->query($sql);
                // ログ書き込み
                $this->setSMLog($username, $selected_class, $this->request->data['StaffMaster']['id'], $this->request->data['StaffMaster']['staff_name'], $flag, 9, $this->request->clientIp()); // 登録解除コード:9
                $this->redirect(array('action' => 'profile', $flag, $case_id, 'page' => 1));
                //$this->StaffMaster->save($this->request->data);
                //$this->log($this->StaffMaster->getDataSource()->getLog(), LOG_DEBUG);
                $this->Session->setFlash('登録解除しました。');
            } 
        } else {
            
        }
    }  
      
    /** 取引先マスタ **/
    public  function customer($flag = null) {
        // レイアウト関係
        $this->layout = "main";
        $this->set("title_for_layout", $this->title_for_layout);
        $this->set("headline", '取引先マスタ');
        // タブの状態
        $this->set('active1', '');
        $this->set('active2', '');
        $this->set('active3', '');
        $this->set('active4', 'active');
        $this->set('active5', '');
        $this->set('active6', '');
        $this->set('active7', '');
        $this->set('active8', '');
        $this->set('active9', '');
        $this->set('active10', '');
        // 絞り込みセッションを消去
        $this->Session->delete('filter');
        // ユーザー名前
        $name = $this->Auth->user('name_sei').' '.$this->Auth->user('name_mei');
        $this->set('user_name', $name);
        $selected_class = $this->Session->read('selected_class');
        $this->set('selected_class', $selected_class);
        // テーブルの設定
        $this->Customer->setSource('customer');
        // 解除フラグ
        $this->set('flag', $flag);
        // 引数の受け取り
        if (isset($this->params['named']['limit'])) {
            $limit = $this->params['named']['limit'];
        } else {
            $limit = '10';
        }
        // 表示件数の初期値
        $this->set('limit', $limit);
        $conditions1 = null;$conditions2 = null;$conditions3 = null;
        
        // Paginationの設定
        $this->paginate = array(
        //モデルの指定
        'Customer' => array(
        //1ページ表示できるデータ数の設定
        'limit' =>10,
        'fields' => array('Customer.*'),
        //データを降順に並べる
        'order' => array('id' => 'asc')
        )); 
        
        // POSTの場合
        //if ($this->request->is('post') || $this->request->is('put') || $this->request->is('get')) {
        if ($this->request->is('post') || $this->request->is('put')) {
            // 初期表示
            if ($flag == 1) {
                $conditions2 = array('kaijo_flag' => 1);
            } else {
                $flag = 0;
                $conditions2 = array('kaijo_flag' => 0);
            }
            $this->set('flag', $flag);
            
            // 絞り込み
            if(isset($this->request->data['search'])) {
                // 企業名で検索
                if (!empty($this->data['Customer']['search_corp_name'])){
                    $search_name = $this->data['Customer']['search_corp_name'];
                    $keyword = mb_convert_kana($search_name, 's');
                    $ary_keyword = preg_split('/[\s]+/', $keyword, -1, PREG_SPLIT_NO_EMPTY);
                    foreach( $ary_keyword as $val ){
                        // 検索条件を設定するコードをここに書く
                        $conditions2[] = array('Customer.corp_name LIKE ' => '%'.$val.'%');
                    }
                }
                // 電話番号で絞り込み
                if (!empty($this->data['Customer']['search_telno'])){
                    $search_telno = $this->data['Customer']['search_telno'];
                    $conditions2 += array('Customer.telno LIKE ' => '%'.$search_telno.'%');
                } 
                // メールアドレスで絞り込み
                if (!empty($this->data['Customer']['search_email'])){
                    $search_email = $this->data['Customer']['search_email'];
                    $conditions2 += array('Customer.email LIKE ' => '%'.$search_email.'%');
                } 
            // 絞り込みクリア処理
            } elseif (isset($this->request->data['clear'])) {
                // 絞り込みセッションを消去
                $this->Session->delete('filter');
                //$this->request->params['named']['page'] = 1;
                $this->redirect(array('action' => 'customer', $flag)); 
            // 所属の変更
            } elseif (isset($this->request->data['class'])) {
                // 絞り込みセッションを消去
                $this->Session->delete('filter');
                $this->selected_class = $this->request->data['class'];
                //$this->Session->setFlash($class);
                $this->set('selected_class', $this->selected_class);
                $this->Session->write('selected_class', $this->selected_class);
                // テーブル変更
                $this->StaffMaster->setSource('staff_'.$this->Session->read('selected_class'));
                $this->redirect(array('page' => 1, 'pic' => $pic));  
            // 表示件数の変更
            } elseif (isset($this->request->data['limit'])) {
                $limit = $this->request->data['limit'];
                $this->set('limit', $limit);
                $this->redirect(array('limit' => $limit, 'pic' => $pic));
            }
            // 所属
            $conditions2 += array('class' => $selected_class);
            // 絞り込み条件の保持
            $this->Session->write('filter', $conditions2);
            // ページネーションの実行
            $this->request->params['named']['page'] = 1;
            $this->set('datas', $this->paginate('Customer', $conditions2));
            $this->log($this->StaffMaster->getDataSource()->getLog(), LOG_DEBUG);
            $this->log($conditions2, LOG_DEBUG);
        // GETの処理
        } elseif ($this->request->is('get')) {
            // プロフィールページへ
            if (isset($profile)) {
                // ページ数（レコード番号）を取得
                $conditions1 = array('kaijo_flag' => $flag, 'id <= ' => $staff_id);
                $page = $this->StaffMaster->find('count', array('fields' => array('*'), 'conditions' => $conditions1));
                //$this->log($this->StaffMaster->getDataSource()->getLog(), LOG_DEBUG);
                //$this->log($page, LOG_DEBUG);
                $this->redirect(array('action' => 'profile', $flag, $staff_id, 'page' => $page));
                exit();
            }
            // テーブル変更
            $this->StaffMaster->setSource('staff_'.$this->Session->read('selected_class'));
            // 初期表示
            if ($flag == 1) {
                $conditions3 = array('kaijo_flag' => 1);
            } else {
                $flag = 0;
                $conditions3 = array('kaijo_flag' => 0);
            }
            $this->set('flag', $flag);
            // 絞り込み条件の適応
            if($this->Session->check('filter')) {
                $filter = $this->Session->read('filter');
                if ($filter == '0') {
                    $conditions3 = $conditions3;
                } else {
                    $conditions3 = $conditions3 + $filter;
                }
            } else {
                $conditions3 = $conditions3;
            }
            // 所属
            $conditions3 += array('class' => $selected_class);
            //$this->request->params['named']['page'] = 1;
            $this->set('datas', $this->paginate('Customer', $conditions3)); 
            //$this->log('GET', LOG_DEBUG);
        } else {
            // 初期表示
            if ($flag == 1) {
                $conditions3 = array('kaijo_flag' => 1);
            } else {
                $flag = 0;
                $conditions3 = array('kaijo_flag' => 0);
            }
            // 所属
            $conditions3 += array('class' => $selected_class);
            $this->set('flag', $flag);
            //$this->request->params['named']['page'] = 1;
            $this->set('datas', $this->paginate('Customer', $conditions3));
            //$this->log($this->StaffMaster->getDataSource()->getLog(), LOG_DEBUG);
            //$this->log('そと通ってる', LOG_DEBUG);
        }
        
    }
    
    /** 取引先登録 **/
    public function register_customer($flag = null, $customer_id = null) {
        // レイアウト関係
        $this->layout = "sub";
        $this->set("title_for_layout", $this->title_for_layout);
        $this->set("headline", '取引先登録');
        // 初期値
        $this->set('customer_id', $customer_id);
        $username = $this->Auth->user('username');
        $this->set('username', $username);
        $selected_class = $this->Session->read('selected_class');
        $this->set('selected_class', $selected_class);
        $this->set('flag', $flag);
        // 都道府県のセット
        //$conditions = array('item' => 10);      // 全国を選択可能に
        if (substr($selected_class, 0 ,1) == 1) {
            // 大阪（関西地方）
            $conditions = array('item' => 10, 'AND' => array('id >= ' => 24, 'id <= ' => 30));
        } elseif (substr($selected_class, 0, 1) == 2) {
            // 東京（関東地方）
            $conditions = array('item' => 10, 'AND' => array('id >= ' => 8, 'id <= ' => 14));
        } elseif (substr($selected_class, 0, 1) == 3) {
            // 名古屋（中部地方）
            $conditions = array('item' => 10, 'AND' => array('id >= ' => 15, 'id <= ' => 24));
        }
        $pref_arr = $this->Item->find('list', array('fields' => array( 'id', 'value'), 'conditions' => $conditions));
        $this->set('pref_arr', $pref_arr);
        $this->Customer->setSource('customer');
        // 登録担当者
        $conditions2 = array('area' => substr($selected_class, 0, 1));
        $this->User->virtualFields['name'] = 'CONCAT(name_sei, " ", name_mei)';
        $name_arr = $this->User->find('list', array('fields' => array('username', 'name'), 'conditions' => $conditions2));
        $this->set('name_arr', $name_arr); 
        
        // post時の処理
        if ($this->request->is('post') || $this->request->is('put')) {
            if (isset($this->request->data['submit'])) {
                // 都道府県の名称のセット
                if (!empty($this->request->data['Customer']['address1'])) {
                    $conditions = array('item' => 10, 'id' => $this->request->data['Customer']['address1']);
                    $result = $this->Item->find('first', array('conditions' => $conditions));
                    $this->request->data['Customer']['address1_2'] = $result['Item']['value'];
                }
                // 登録解除フラグ：０
                //$this->request->data['Customer']['kaijo_flag'] = 0;
                // データを登録する
                if ($this->Customer->save($this->request->data)) {
                    // 登録完了メッセージ
                    $this->Session->setFlash('登録しました。');
                    //$this->redirect(array('action' => 'reg1', $id, $koushin_flag));
                } else {
                    $this->Session->setFlash('登録時にエラーが発生しました。');
                }
            } elseif (isset($this->request->data['release'])) {
                // 都道府県の名称のセット
                if (!empty($this->request->data['Customer']['address1'])) {
                    $conditions = array('item' => 10, 'id' => $this->request->data['Customer']['address1']);
                    $result = $this->Item->find('first', array('conditions' => $conditions));
                    $this->request->data['Customer']['address1_2'] = $result['Item']['value'];
                }
                // 登録解除フラグ：１
                $this->request->data['Customer']['kaijo_flag'] = 1;
                // データを登録する
                if ($this->Customer->save($this->request->data)) {
                    // 登録完了メッセージ
                    $this->Session->setFlash('登録解除しました。');
                    //$this->redirect(array('action' => 'reg1', $id, $koushin_flag));
                } else {
                    $this->Session->setFlash('登録時にエラーが発生しました。');
                }
            }    
        } else {
            // 登録していた値をセット
            $this->request->data = $this->Customer->read(null, $customer_id);
        }

    }
      
    /** 職種マスタ管理 **/
    public function shokushu($_id = null, $_sequence = null, $direction = null) {
        // レイアウト関係
        $this->layout = "main";
        $this->set("title_for_layout", $this->title_for_layout);
        $this->set("headline", '職種マスタ');
        // タブの状態
        $this->set('active1', '');
        $this->set('active2', '');
        $this->set('active3', '');
        $this->set('active4', 'active');
        $this->set('active5', '');
        $this->set('active6', '');
        $this->set('active7', '');
        $this->set('active8', '');
        $this->set('active9', '');
        $this->set('active10', '');
        // 絞り込みセッションを消去
        $this->Session->delete('filter');
        // ユーザー名前
        $name = $this->Auth->user('name_sei').' '.$this->Auth->user('name_mei');
        $this->set('user_name', $name);
        $selected_class = $this->Session->read('selected_class');
        $this->set('selected_class', $selected_class);
        // テーブルの設定
        $this->Item->setSource('item');
        
        $this->paginate = array('Item' => array(
            'conditions' => array('item' => '16'),
            'limit' => '15','order' => array('sequence' => 'asc', 'id' => 'asc')));
        $this->log($this->paginate(), LOG_DEBUG);
        $this->set('datas', $this->paginate());
        
        // POSTの場合
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->log($this->request->data, LOG_DEBUG);
            if (isset($this->request->data['insert'])) {
                // データを登録する
                $id = $this->request->data['Item']['id'];
                $value = $this->request->data['Item']['value'];
                $sequence = $this->request->data['Item']['sequence'];
                // 削除
                $sql = '';
                $sql = $sql.' DELETE FROM item';
                $sql = $sql.' WHERE item = 16 AND id = '.$id;
                $this->log($this->Item->query($sql));
                // 追加
                $sql = "";
                $sql = $sql." INSERT INTO item (item, id, value, sequence, created)";
                $sql = $sql." VALUES (16, ".$id.", '".$value."', ".$sequence.", now())";
                $this->log($this->Item->query($sql));
                $this->redirect('shokushu');
                $this->Session->setFlash('ID='.$id.', 値='.$value.'を追加しました。');
            } elseif (isset($this->request->data['delete'])) {
                $id_array = array_keys($this->request->data['delete']);
                $id = $id_array[0];
                $sql = '';
                $sql = $sql.' DELETE FROM item';
                $sql = $sql.' WHERE item = 16 AND id = '.$id;
                $this->Item->query($sql);
                $this->redirect('shokushu');
                $this->Session->setFlash('ID='.$id.'を削除しました。');
            } else { 
            }
        } elseif ($this->request->is('get')) {
            if (!empty($_id) && !empty($_sequence) && !empty($direction)) {
                // 順序のアップデート
                if ($direction == 'up' && $_sequence != 1) {
                    $sql1 = '';
                    $sql1 = $sql1.' UPDATE item SET sequence = '.$_sequence;
                    $sql1 = $sql1.' WHERE item = 16 AND sequence = '.($_sequence-1).';';
                    $sql2 = '';
                    $sql2 = $sql2.' UPDATE item SET sequence = '.($_sequence-1);
                    $sql2 = $sql2.' WHERE item = 16 AND id = '.$_id.' AND sequence = '.$_sequence.';'; 
                } elseif ($direction == 'down') {
                    $sql1 = '';
                    $sql1 = $sql1.' UPDATE item SET sequence = '.$_sequence;
                    $sql1 = $sql1.' WHERE item = 16 AND sequence = '.($_sequence+1).';';
                    $sql2 = '';
                    $sql2 = $sql2.' UPDATE item SET sequence = '.($_sequence+1);
                    $sql2 = $sql2.' WHERE item = 16 AND id = '.$_id.' AND sequence = '.$_sequence.';'; 
                } else {
                    // 無処理
                    $this->redirect('shokushu');
                    return;
                }
                $this->Item->query($sql1);
                $this->Item->query($sql2);
                $this->redirect('shokushu');
            } 
        } else {
            //$this->request->data = $this->User->read(null, $this->Auth->user('username'));    
        }
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
    
    /*** 登録担当者の検索 ***/
    public function getTantou(){
        // 所属を配列に
        $this->User->virtualFields['name'] = 'CONCAT(name_sei, " ", name_mei)';
        $result = $this->User->find('list', array('fields' => array('username', 'name')));
        $result = $result + array('', '');
        
        return $result;
    } 
    
    /*** 所属により参照するテーブルを変更 ***/
    public function setTable($val){
        $tablename = '';
        if (isset($val) && $val != 0) {
            $tablename = 'staff_'.$val;
            $this->StaffMaster->setSource($tablename);
            //$this->log($this->StaffMaster->useTable);
        } else {
            $this->StaffMaster->setSource('staff_00');
        }
    }  
    
    /** 生年月日から年齢を割り出しマスタ更新 **/
    // 年齢換算
    public function setAge($class) {
        $sql = '';
        $sql = $sql. ' UPDATE staff_'.$class;
        $sql = $sql. ' SET age = (YEAR(CURDATE())-YEAR(birthday)) - (RIGHT(CURDATE(),5)<RIGHT(birthday,5));';
        
        // sqlの実行
        $ret = $this->StaffMaster->query($sql);
        
        return $ret;
    }
    
    // 路線のコンボセット
    function getLine($code) {
        if (!is_null($code) && !empty($code)) {
            $xml = "http://www.ekidata.jp/api/p/".$code.".xml";//ファイルを指定
            // simplexml_load_fileは使えない処理
            $xml_data = "";
            $cp = curl_init();
            curl_setopt($cp, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt( $cp, CURLOPT_HEADER, false );
            curl_setopt($cp, CURLOPT_URL, $xml);
            curl_setopt($cp, CURLOPT_TIMEOUT, 60);
            $xml_data = curl_exec($cp);
            curl_close($cp);
            $original_xml = simplexml_load_string($xml_data);
            $xml_ary = json_decode(json_encode($original_xml), true);
            $line_ary = $xml_ary['line'];

            foreach ($line_ary as $value) {
                $ret[$value['line_cd']] = $value['line_name'];
            }

            //$ret = $xml_ary['pref']['name'];
        } else {
            $ret = '';
        }
        
        return $ret;
    }

    // 駅のコンボセット
    function getStation($code) {
    //$code = $data['StaffMaster']['s0_1'];
        if (!is_null($code) && !empty($code)) {
            $xml = "http://www.ekidata.jp/api/l/".$code.".xml";//ファイルを指定
            // simplexml_load_fileは使えない処理
            $xml_data = "";
            $cp = curl_init();
            curl_setopt($cp, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt( $cp, CURLOPT_HEADER, false );
            curl_setopt($cp, CURLOPT_URL, $xml);
            curl_setopt($cp, CURLOPT_TIMEOUT, 60);
            $xml_data = curl_exec($cp);
            curl_close($cp);
            $original_xml = simplexml_load_string($xml_data);
            $xml_ary = json_decode(json_encode($original_xml), true);
            $station_ary = $xml_ary['station'];

            foreach ($station_ary as $value) {
                $ret[$value['station_cd']] = $value['station_name'];
            }

            //$ret = $xml_ary['pref']['name'];
        } else {
            $ret = '';
        }
        
        return $ret;
    }
    
    /** マスタ更新ログ書き込み **/
    public function setSMLog($username, $class, $staff_id, $staff_name, $kaijo_flag, $status, $ip_address) {
        $sql = '';
        $sql = $sql. ' INSERT INTO staff_master_logs (username, class, staff_id, staff_name, kaijo_flag, status, ip_address, created)';
        $sql = $sql. ' VALUES ('.$username.', '.$class.', '.$staff_id.', "'.$staff_name.'", '.$kaijo_flag.', '.$status.', "'.$ip_address.'", now())';
        
        // sqlの実行
        $ret = $this->StaffMasterLog->query($sql);
        
        return $ret;
    }
}
