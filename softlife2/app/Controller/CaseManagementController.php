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
    public $uses = array('CaseManagement', 'Item', 'User', 'Customer', 'OrderInfo', 'OrderInfoDetail', 'OrderCalender', 'CaseLog');
    
    public $components = array('RequestHandler');
    
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

    public function index($flag = null, $case_id = null, $window = null) {
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
        //$this->CaseManagement->setSource('CaseManagement');
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
        // 職種マスタ配列
        $conditions0 = array('item' => 17);
        $list_shokushu = $this->Item->find('list', array('fields' => array('id', 'value'), 'conditions' => $conditions0));
        $this->set('list_shokushu', $list_shokushu);
        // 取引先配列
        $customer_array = $this->Customer->find('list', array('fields'=>array('id', 'corp_name')));
        $customer_array += array(''=>'');
        $this->set('customer_array', $customer_array);
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
        'CaseManagement' => array(
        //1ページ表示できるデータ数の設定
        'limit' =>10,
        'fields' => array('CaseManagement.*', 'User.*'),
        //データを降順に並べる
        'order' => array('id' => 'asc'),
        'joins' => array (
                array (
                    'type' => 'LEFT',
                    'table' => 'users',
                    'alias' => 'User',
                    'conditions' => 'CaseManagement.username = User.username' 
                ))
        )); 
        
        //$this->log($this->request, LOG_DEBUG);
        // POSTの場合
        if ($this->request->is('post') || $this->request->is('put')) {
            // 初期表示
            if ($flag == 1) {
                $conditions2 = array('kaijo_flag' => 1);
            } elseif ($flag == 2) {
                $conditions3 = array('kaijo_flag' => 2);
            } else {
                $flag = 0;
                $conditions2 = array('kaijo_flag' => 0);
            }
            $this->set('flag', $flag);
            
            // 絞り込み
            if(isset($this->request->data['search1'])) {
                // 登録番号で検索
                if (!empty($this->data['CaseManagement']['search_id'])){
                    $search_id = $this->data['CaseManagement']['search_id'];
                    $conditions2 += array('id' => $search_id);
                }
                // 氏名で検索
                if (!empty($this->data['CaseManagement']['search_name'])){
                    $search_name = $this->data['CaseManagement']['search_name'];
                    //$conditions2 += array( 'OR' => array(array('CaseManagement.name_sei LIKE ' => '%'.$search_name.'%'), array('CaseManagement.name_mei LIKE ' => '%'.$search_name.'%')));
                    $conditions2 += array('CONCAT(CaseManagement.name_sei, CaseManagement.name_mei) LIKE ' => '%'.preg_replace('/(\s|　)/','',$search_name).'%');
                    //$this->log(preg_replace('/(\s|　)/','',$search_name), LOG_DEBUG);
                }
                // 年齢で検索
                if (!empty($this->data['CaseManagement']['search_age'])){
                    $search_age = $this->data['CaseManagement']['search_age'];
                    $conditions2 += array('CaseManagement.age' => $search_age);
                }
                // 都道府県
                if (!empty($this->data['CaseManagement']['search_area'])){
                    $search_area = $this->data['CaseManagement']['search_area'];
                    //$this->log($search_area);
                    $conditions2 += array('CONCAT(CaseManagement.address1_2, CaseManagement.address2) LIKE ' => '%'.preg_replace('/(\s|　)/','',$search_area).'%');
                }
            // 担当者で絞り込み
            } elseif (!empty($this->data['CaseManagement']['search_tantou'])){
                $search_tantou = $this->data['CaseManagement']['search_tantou'];
                $conditions2 += array('CaseManagement.tantou' => $search_tantou);
            // 年齢での絞り込み
            } elseif (isset($this->request->data['search2'])) {
                //$this->Session->setFlash($this->request->data['CaseManagement']['search_age_lower'].'-'.$this->request->data['CaseManagement']['search_age_upper']);
                $lower = $this->request->data['CaseManagement']['search_age_lower'];
                $upper = $this->request->data['CaseManagement']['search_age_upper'];
                if (!empty($lower) && !empty($upper)) {
                    $conditions2 += array(
                        array('CaseManagement.age >=' => $this->request->data['CaseManagement']['search_age_lower']), 
                        array('CaseManagement.age <= ' => $this->request->data['CaseManagement']['search_age_upper']));
                } elseif (!empty($lower) && empty($upper)) {
                    $conditions2 += array('CaseManagement.age >=' => $this->request->data['CaseManagement']['search_age_lower']);
                } elseif (empty($lower) && !empty($upper)) {
                    $conditions2 += array('CaseManagement.age <= ' => $this->request->data['CaseManagement']['search_age_upper']);
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
                $this->CaseManagement->setSource('staff_'.$this->Session->read('selected_class'));
                $this->redirect(array('page' => 1));  
            // 表示件数の変更
            } elseif (isset($this->request->data['limit'])) {
                $limit = $this->request->data['limit'];
                $this->set('limit', $limit);
                $this->redirect(array('limit' => $limit));
            }
            $conditions2 += array('class'=>$selected_class);
            // ページネーションの実行
            //$this->request->params['named']['page'] = 1;
            $this->set('datas', $this->paginate('CaseManagement', $conditions2));
            $this->log($this->CaseManagement->getDataSource()->getLog(), LOG_DEBUG);
        } elseif ($this->request->is('get')) {
            // プロフィールページへ
            if ($window == 'profile') {
                // ページ数（レコード番号）を取得
                $conditions1 = array('kaijo_flag' => $flag, 'id <= ' => $case_id);
                $page = $this->CaseManagement->find('count', array('fields' => array('*'), 'conditions' => $conditions1));
                //$this->log($this->CaseManagement->getDataSource()->getLog(), LOG_DEBUG);
                //$this->log($page, LOG_DEBUG);
                $this->redirect(array('action' => 'profile', $flag, $case_id, 'page' => $page));
                exit();
            // 複製
            } elseif ($window == 'copy') {
                // ページ数（レコード番号）を取得
                $conditions1 = array('kaijo_flag' => $flag, 'id <= ' => $case_id);
                $page = $this->CaseManagement->find('count', array('fields' => array('*'), 'conditions' => $conditions1));
                //$this->log($this->CaseManagement->getDataSource()->getLog(), LOG_DEBUG);
                //$this->log($page, LOG_DEBUG);
                $this->redirect(array('action' => 'profile', $flag, $case_id, 'page' => $page));
                exit();
            }
            // テーブル変更
            //$this->CaseManagement->setSource('staff_'.$this->Session->read('selected_class'));
            // 年齢の計算
            $this->setAge($this->Session->read('selected_class'));
            // 初期表示
            if ($flag == 1) {
                $conditions3 = array('kaijo_flag' => 1);
            } elseif ($flag == 2) {
                $conditions3 = array('kaijo_flag' => 2);
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
            $conditions3 += array('class'=>$selected_class);
            //$this->request->params['named']['page'] = 1;
            $datas = $this->paginate('CaseManagement', $conditions3);
            $this->set('datas', $datas);
            if (!empty($datas)) {
                // オーダー内容
                foreach($datas as $key=>$data) {
                    $conditions2 = array('case_id'=>$data['CaseManagement']['id']);
                    $result_order[$key] = $this->OrderInfoDetail->find('all', array('conditions'=>$conditions2, 'fields'=>array('*', 'COUNT(shokushu_id) AS cnt'), 'group'=>array('shokushu_id')));
                }
                $this->log($result_order, LOG_DEBUG);
                $this->log('レコード数は、'.count($result_order), LOG_DEBUG);
                $this->set('datas_order', $result_order);
                // オーダー情報の更新日
                foreach($datas as $key=>$data) {
                    $conditions2 = array('case_id'=>$data['CaseManagement']['id'], 'status LIKE '=>'2%');
                    $result[$key] = $this->CaseLog->find('first', array('conditions'=>$conditions2, 'order'=>array('created'=>'desc')));
                }
                //$this->log($result, LOG_DEBUG);
                $this->set('order_update_date', $result);
            } else {
                $this->set('order_update_date', null);
            }
            
        } else {
            // 所属の取得とセット
            //$this->selected_class = $this->Session->read('selected_class');
            //$this->set('selected_class', $this->selected_class);
            // テーブル変更
            //$this->CaseManagement->setSource('staff_'.$this->Session->read('selected_class'));
            // 初期表示
            if ($flag == 1) {
                $conditions3 = array('kaijo_flag' => 1);
            } elseif ($flag == 2) {
                $conditions3 = array('kaijo_flag' => 2);
            } else {
                $flag = 0;
                $conditions3 = array('kaijo_flag' => 0);
            }
            $conditions3 += array('class'=>$selected_class);
            $this->set('flag', $flag);
            //$this->request->params['named']['page'] = 1;
            $this->set('datas', $this->paginate('CaseManagement', $conditions3));
            //$this->log($this->CaseManagement->getDataSource()->getLog(), LOG_DEBUG);
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
        $pref_arr = $this->Item->find('list', array('fields' => array('id', 'value'), 'conditions' => $conditions));
        $this->set('pref_arr', $pref_arr); 
        $this->set('id', $case_id); 
        $username = $this->Auth->user('username');
        $this->set('username', $username); 
        // テーブルの設定
        $selected_class = $this->Session->read('selected_class');
        //$this->CaseManagement->setSource('staff_'.$selected_class);
        $this->set('class', $selected_class);
        $this->set('flag', $flag);
                
        // ページネーション
        //$conditions2 = array('id' => $case_id, 'kaijo_flag' => $flag);
        //$conditions2 = array('kaijo_flag' => $flag);
        $conditions2 = null;
        $this->paginate = array('CaseManagement' => array(
            'fields' => '*' ,
            'limit' =>  '1',
            //'page' => $page,
            'order' => 'id',
            'conditions' => $conditions2
        ));
        $datas = $this->paginate('CaseManagement');
        $this->set('datas', $datas);
        $this->log($datas, LOG_DEBUG);
        // 担当者
        $condition0 = array('username' => $datas[0]['CaseManagement']['username']);
        $data = $this->User->find('first', array('conditions' => $condition0));
        $this->set('contact', $data['User']['name_sei'].' '.$data['User']['name_mei']);
        // 依頼主データ
        $condition1 = array('id' => $datas[0]['CaseManagement']['client']);
        $data_client = $this->Customer->find('first', array('conditions' => $condition1));
        $this->set('data_client', $data_client);
        // 請求先データ
        for($i=0; $i<10 ;$i++) {
            $condition2 = array('id' => $datas[0]['CaseManagement']['billing_destination'.($i+1)]);
            if (empty($data_billing)) {
                $data_billing[] = $this->Customer->find('first', array('conditions' => $condition2));
            } else {
                $data_billing[$i] = $this->Customer->find('first', array('conditions' => $condition2));
            }
        }
        $this->set('data_billing', $data_billing);   
        // 事業主
        $entrepreneur = '';
        for($i=0; $i<10; $i++) {
            $condition3 = array('id' => $datas[0]['CaseManagement']['entrepreneur'.($i+1)]);
            $data1 = $this->Customer->find('first', array('conditions' => $condition3));
            $this->log($data1, LOG_DEBUG);
            if (!empty($data1)) {
                $entrepreneur1 = $data1['Customer']['corp_name'];
                if (empty($entrepreneur)) {
                    $entrepreneur = $entrepreneur1;
                } else {
                    $entrepreneur .= '<br>'.$entrepreneur1;
                }
            } else {
                $entrepreneur1 = '';
            }
        }
        $this->set('entrepreneur', $entrepreneur);
        // 請求先の数
        $count2 = 0;
        $count_billing = 0;
        for ($i=0; $i < 10; $i++) {
            if (!empty($datas[0]['CaseManagement']['billing_destination'.($i+1)])) {
                $count2 = $i+1;
            }
        }
        $count_billing = $count2;
        $this->set('count_billing', $count_billing);
        
        //$this->log($this->request->data, LOG_DEBUG);
        // post時の処理
        if ($this->request->is('post') || $this->request->is('put')) {
            // 登録編集
            if (isset($this->request->data['submit'])) {
                $this->redirect(array('action' => 'reg1', $this->request->data['CaseManagement']['case_id'], 1));
            // 登録解除
            } elseif (isset($this->request->data['release'])) {
                $sql = '';
                $sql = $sql.' UPDATE case_managements'; 
                $sql = $sql.' SET kaijo_flag = 1, modified = CURRENT_TIMESTAMP()';  
                $sql = $sql.' WHERE id = '.$this->request->data['CaseManagement']['id'];
                $this->log($sql, LOG_DEBUG);
                $this->CaseManagement->query($sql);
                $this->redirect(array('action' => 'profile', $flag, $case_id, 'page' => 1));
                //$this->CaseManagement->save($this->request->data);
                //$this->log($this->CaseManagement->getDataSource()->getLog(), LOG_DEBUG);
                $this->Session->setFlash('登録解除しました。');
            } 
        } else {
            
        }
    }
    
    // 登録ページ（その１）
    public function reg1($case_id = null, $koushin_flag = null) {
        // レイアウト関係
        $this->layout = "sub";
        $this->set("title_for_layout", $this->title_for_layout);
        // 都道府県のセット
        mb_language("uni");
        mb_internal_encoding("utf-8"); //内部文字コードを変更
        mb_http_input("auto");
        mb_http_output("utf-8");
        $selected_class = $this->Session->read('selected_class');
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
        // 登録担当者
        $conditions1 = array('area' => substr($selected_class, 0, 1));
        $this->User->virtualFields['busho'] = 'CONCAT(busho_name, "　", name_sei, " ", name_mei)';
        $name_arr = $this->User->find('list', array('fields' => array('username', 'busho'), 'conditions' => $conditions1, 'order' => array('busho_id'=>'asc')));
        $this->set('name_arr', $name_arr); 
        // 取引先マスタのセット
        $conditions2 = array('class' => $selected_class, 'kaijo_flag' => 0);
        //$this->Customer->virtualFields['corp_info'] = 'CONCAT(corp_name, "　", busho, "　", tantou)';
        $customer_arr = $this->Customer->find('list', array('fields' => array( 'id', 'corp_name'), 'conditions' => $conditions2));
        $this->set('customer_arr', $customer_arr);
        // 登録データのセット
        $option = array();
        $option['recursive'] = -1; 
        /**
        $option['joins'][] = array(
            'type' => 'LEFT',   //LEFT, INNER, OUTER
            'table' => 'customers',
            'alias' => 'Customer',    //下でPost.user_idと書くために
            'conditions' => '`CaseManagement`.`entrepreneur1`=`Customer`.`user_id`',
        );
         * 
         */
        $option['conditions'] = array('CaseManagement.id' => $case_id);
        $data = $this->CaseManagement->find('first', $option);
        $this->set('data', $data);
        // 事業主の数
        $count = 0;
        $count_entrepreneur = 0;
        for ($i=0; $i < 10; $i++) {
            if (!empty($data['CaseManagement']['entrepreneur'.($i+1)])) {
                $count = $i+1;
            }
        }
        $count_entrepreneur = $count;
        // 請求先の数
        $count2 = 0;
        $count_billing = 0;
        for ($i=0; $i < 10; $i++) {
            if (!empty($data['CaseManagement']['billing_destination'.($i+1)])) {
                $count2 = $i+1;
            }
        }
        $count_billing = $count2;
        $this->set('count_billing', $count_billing);
        //$this->log($count_billing, LOG_DEBUG);
        if ($count_billing == 0) {
            $this->set('insert_billing', 1);
        } else {
            $this->set('insert_billing', $this->Session->read('insert_billing'));
        }
        
        // 取引先配列
        $customer_array = $this->Customer->find('list', array('fields'=>array('id', 'corp_name')));
        $this->set('customer_array', $customer_array);
        // その他
        $this->set('case_id', $case_id); 
        $this->CaseManagement->id = $case_id;
        $username = $this->Auth->user('username');
        $this->set('username', $username); 
        $this->set('koushin_flag', $koushin_flag);
        $selected_class = $this->Session->read('selected_class');
        $this->set('selected_class', $selected_class); 
        // 初期セット
        $this->set('line1', '');
        $this->set('station1', '');
        $this->set('line2', '');
        $this->set('station2', '');
        $this->set('line3', '');
        $this->set('station3', '');
        $this->Session->write('insert_billing', 0);
        
        // post時の処理
        if ($this->request->is('post') || $this->request->is('put')) {
            if (isset($this->request->data['submit'])) {
                // モデルの状態をリセットする
                //$this->CaseManagement->create();
                // データを登録する
                if ($this->CaseManagement->save($this->request->data)) {
                    /**
                    // 依頼主
                    $condition1 = array('id' => $this->request->data['CaseManagement']['client']);
                    $data_client = $this->Customer->find('first', array('conditions' => $condition1));
                    $this->set('data_client', $data_client);
                    // 請求先
                    $condition2 = array('id' => $this->request->data['CaseManagement']['billing_destination']);
                    $data_billing = $this->Customer->find('first', array('conditions' => $condition2));
                    $this->set('data_billing', $data_billing);
                     * 
                     */
                    // ログ書き込み
                    $this->setCaseLog($username, $selected_class, $case_id, $this->request->data['CaseManagement']['case_name'], 0, 11, $this->request->clientIp()); // 案件基本情報登録コード:11
                    // 登録完了メッセージ
                    $this->Session->setFlash('登録しました。');
                    $this->redirect(array('action'=>'./reg1/'.$case_id.'/'.$koushin_flag));

                } else {
                    $this->Session->setFlash('登録時にエラーが発生しました。');
                }
            // 事業主追加
            } elseif (isset($this->request->data['insert_entrepreneur'])) {
                // 重複チェック
                $flag = false;
                $condition1 = array('id' => $case_id);
                $data = $this->CaseManagement->find('first', array('conditions'=>$condition1));
                $this->log($data, LOG_DEBUG);
                for ($j=0; $j<10; $j++) {
                    if (empty($data['CaseManagement']['entrepreneur'.($j+1)])) {
                        continue;
                    }
                    if ($this->request->data['CaseManagement']['entrepreneur'] == $data['CaseManagement']['entrepreneur'.($j+1)]) {
                        $flag = true;
                    }
                }
                if ($flag) {
                    $this->Session->setFlash('事業主が既に存在します。');
                    $this->redirect(array('action'=>'./reg1/'.$case_id.'/'.$koushin_flag));
                    return;
                }
                // 登録する内容を設定
                $data = array('CaseManagement' => array('id' => $this->request->data['CaseManagement']['id'], 
                    'entrepreneur'.($count_entrepreneur+1) => $this->request->data['CaseManagement']['entrepreneur']));
                // 登録する項目（フィールド指定）
                $fields = array('entrepreneur'.($count_entrepreneur+1)); 
                // 更新登録
                $this->CaseManagement->save($data, false, $fields);
                $this->redirect(array('action'=>'./reg1/'.$case_id.'/'.$koushin_flag));
            // 事業主の削除
            } elseif (isset($this->request->data['delete_entrepreneur'])) {
                $i_array = array_keys($this->request->data['delete_entrepreneur']);
                $i = $i_array[0];
                // 登録する内容を設定
                $data = array('CaseManagement' => array('id' => $this->request->data['CaseManagement']['id'], 'entrepreneur'.$i => null, 'kubun2_'.$i => 0));
                // 登録する項目（フィールド指定）
                $fields = array('entrepreneur'.$i, 'kubun2_'.$i); 
                // 更新登録
                if ($this->CaseManagement->save($data, false, $fields)) {
                    // 成功
                    $this->redirect(array('action'=>'./reg1/'.$case_id.'/'.$koushin_flag));
                }
            // 請求先追加
            } elseif (isset($this->request->data['insert_billing'])) { 
                $this->Session->write('insert_billing', 1);
                $this->set('insert_billing', 1);
                $this->redirect(array('action'=>'./reg1/'.$case_id.'/'.$koushin_flag));
            // 請求先削除
            } elseif (isset($this->request->data['delete_billing'])) { 
                $i_array = array_keys($this->request->data['delete_billing']);
                $i = $i_array[0];
                //$this->log($i, LOG_DEBUG);
                // 登録する内容を設定
                $data = array('CaseManagement' => array('id' => $this->request->data['CaseManagement']['id'], 
                    'billing_destination'.$i => null, 'billing_busho'.$i => null, 'billing_tantou'.$i => null));
                // 登録する項目（フィールド指定）
                $fields = array('billing_destination'.$i, 'billing_busho'.$i, 'billing_tantou'.$i); 
                // 更新登録
                if ($this->CaseManagement->save($data, false, $fields)) {
                    //$this->log($this->CaseManagement->getDataSource()->getLog(), LOG_DEBUG);
                    // 成功
                    $this->redirect(array('action'=>'./reg1/'.$case_id.'/'.$koushin_flag));
                }
            } elseif (isset($this->request->data['select_client']) || isset($this->request->data['select_billing'])) {
                // 選択した項目番号
                $j_array = array_keys($this->request->data['select_billing']);
                $j = $j_array[0];
                $this->log($this->request->data, LOG_DEBUG);
                $this->log($j, LOG_DEBUG);
                // 依頼主
                $condition1 = array('id' => $this->request->data['CaseManagement']['client']);
                $data_client = $this->Customer->find('first', array('conditions' => $condition1));
                $this->set('data_client', $data_client);
                // 請求先
                for($i=0; $i<10 ;$i++) {
                    if (empty($this->request->data['CaseManagement']['billing_destination'.($i+1)])) {
                        continue;
                    } else {
                        // 登録する内容を設定
                        $data = array('CaseManagement' => 
                            array('id' => $this->request->data['CaseManagement']['id'], 
                                'billing_destination'.($i+1) => $this->request->data['CaseManagement']['billing_destination'.($i+1)]));
                        // 登録する項目（フィールド指定）
                        $fields = array('billing_destination'.($i+1)); 
                        // 更新登録
                        if ($this->CaseManagement->save($data, false, $fields)) {
                            // 成功
                            //$this->redirect(array('action'=>'./reg1/'.$case_id.'/'.$koushin_flag));
                        }
                    }
                    $condition2 = array('id' => $this->request->data['CaseManagement']['billing_destination'.($i+1)]);
                    if (empty($data_billing)) {
                        $data_billing[] = $this->Customer->find('first', array('conditions' => $condition2));
                    } else {
                        $data_billing[$i] = $this->Customer->find('first', array('conditions' => $condition2));
                    }
                    $this->log($data_billing, LOG_DEBUG);
                }
                $this->set('data_billing', $data_billing);
                $this->redirect(array('action'=>'./reg1/'.$case_id.'/'.$koushin_flag));
            // 登録削除
            } elseif (isset($this->request->data['delete'])) {
                if ($this->CaseManagement->delete($this->request->data['CaseManagement']['id'])) {
                    $this->Session->setFlash('登録をキャンセルしました。');
                }
            }    
        } else {
            // 登録していた値をセット
            $this->request->data = $this->CaseManagement->read(null, $case_id);
            if (!empty($this->request->data)) {
                // 依頼主
                $condition1 = array('id' => $this->request->data['CaseManagement']['client']);
                $data_client = $this->Customer->find('first', array('conditions' => $condition1));
                $this->set('data_client', $data_client);
                // 請求先
                for($i=0; $i<10 ;$i++) {
                    $condition2 = array('id' => $this->request->data['CaseManagement']['billing_destination'.($i+1)]);
                    if (empty($data_billing)) { 
                        $data_billing[] = $this->Customer->find('first', array('conditions' => $condition2));
                    } else {
                        $data_billing[$i] = $this->Customer->find('first', array('conditions' => $condition2));
                    }
                }
                $this->log($data_billing, LOG_DEBUG);
                $this->set('data_billing', $data_billing);
            }
        }
    }
    
    // 登録ページ（オーダー情報）
    public function reg2($case_id = null, $koushin_flag = null, $order_id = null) {
        // レイアウト関係
        $this->layout = "sub";
        $this->set("title_for_layout", $this->title_for_layout);
        // 登録データのセット
        $this->set('case_id', $case_id);
        $conditions1 = array('id' => $order_id, 'case_id' => $case_id);
        $data = $this->OrderInfo->find('first', array('conditions' => $conditions1));
        $this->set('data', $data);
        if (empty($data['OrderInfo']['shokushu_num'])) {
            $row = 1;
        } else {
            $row = $data['OrderInfo']['shokushu_num'];
        }
        $option = array();
        $option['fields'] = array('OrderInfo.*', 'OrderInfoDetail.*', 'OrderCalender.*'); 
        $option['order'] = array('OrderInfo.id' => 'asc');
        $option['joins'] = array(
        array(
            'type' => 'RIGHT',   //LEFT, INNER, OUTER
            'table' => 'order_info_details',
            'alias' => 'OrderInfoDetail',    //下でPost.user_idと書くために
            'conditions' => 'OrderInfo.id = OrderInfoDetail.order_id'
            ),
        array(
            'type' => 'RIGHT',   //LEFT, INNER, OUTER
            'table' => 'order_calenders',
            'alias' => 'OrderCalender',    //下でPost.user_idと書くために
            'conditions' => 'OrderInfo.id = OrderCalender.order_id'
            ),
        );
        // 職種マスタ配列
        $conditions0 = array('item' => 17);
        $list_shokushu = $this->Item->find('list', array('fields' => array('id', 'value'), 'conditions' => $conditions0));
        $this->set('list_shokushu', $list_shokushu);
        // その他
        $username = $this->Auth->user('username');
        $this->set('username', $username); 
        $this->set('koushin_flag', $koushin_flag);
        $this->set('order_id', $order_id);
        $selected_class = $this->Session->read('selected_class');
        $this->set('selected_class', $selected_class);
        // 初期化
        $this->set('row', $row);

        //$this->log($this->request->data['OrderInfo'], LOG_DEBUG);
        //$this->log('$row='.$row, LOG_DEBUG);
        // post時の処理
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->log($this->request->data, LOG_DEBUG);
            // 職種の追加
            if (isset($this->request->data['insert'])) {
                $row = $this->request->data['OrderInfo']['shokushu_num'];
                $this->set('row', $row);
                if (!empty($order_id)) {
                    // 既存データがある場合はチェック
                    $conditions = array('OrderInfoDetail.case_id' => $case_id, 'OrderInfoDetail.order_id' => $order_id);
                    $result = $this->OrderInfoDetail->find('count', array('conditions' => $conditions));
                    if ($result > $row) {
                        $this->Session->setFlash('【エラー】登録済みの職種データがあります。');
                        $this->redirect(array('action' => 'reg2', $case_id, $koushin_flag, $order_id));
                        return;
                    }
                }
                // データを登録する
                if ($this->OrderInfo->save($this->request->data)) {
                    //$this->log($this->OrderInfo->getDataSource()->getLog(), LOG_DEBUG);
                    if (empty($order_id)) {
                        $order_id = $this->OrderInfo->getLastInsertID();
                    }
                    // ログ書き込み
                    $conditions = array('id' => $case_id);
                    $result = $this->CaseManagement->find('first', array('conditions' => $conditions));
                    $this->setCaseLog($username, $selected_class, $case_id, $result['CaseManagement']['case_name'], 
                            '('.$order_id.')'.$this->request->data['OrderInfo']['order_name'], 21, $this->request->clientIp()); // (2)オーダー名登録コード:21
                } else {
                    $this->Session->setFlash('登録時にエラーが発生しました。');
                    exit();
                }
                $this->redirect(array('action' => 'reg2', $case_id, $koushin_flag, $order_id, 'row'=>$row));
            // 登録（職種等）
            } elseif (isset($this->request->data['register'])) {
                $this->log($this->request->data, LOG_DEBUG);
                // オーダーの登録がまだな場合、エラー
                if (is_null($order_id)) {
                    $this->Session->setFlash('【エラー】保存名などを入力の上、『職種入力』ボタンを押してください。');
                    $this->redirect(array('action'=>'reg2/'.$case_id.'/'.$koushin_flag));
                    return;
                }
                $data2 = $this->request->data['OrderInfoDetail'];
                // データを登録する（オーダー詳細）
                //$this->OrderInfoDetail->create(); 
                if ($this->OrderInfoDetail->saveAll($data2)) {
                    // ログ書き込み
                    $conditions = array('id' => $case_id);
                    $result = $this->CaseManagement->find('first', array('conditions' => $conditions));
                    $conditions2 = array('id' => $order_id);
                    $result2 = $this->OrderInfo->find('first', array('conditions' => $conditions2));
                    $this->setCaseLog($username, $selected_class, $case_id, $result['CaseManagement']['case_name'], 
                            '('.$order_id.')'.$result2['OrderInfo']['order_name'], 22, $this->request->clientIp()); // (2)オーダー職種登録コード:22
                    // 登録完了メッセージ
                    $this->Session->setFlash('登録しました。');
                    $this->redirect(array('action'=>'reg2/'.$case_id.'/'.$koushin_flag.'/'.$order_id));
                    /**
                    // 登録していた値をセット
                    $this->request->data = $this->OrderInfo->find('all', $option);
                    $datas = $this->request->data;
                    $this->set('datas', $datas);
                    $record = $this->OrderInfo->find('count', $option);
                    $this->set('record', $record);
                     * 
                     */
                } else {
                    $this->log($this->OrderInfoDetail->getDataSource()->getLog(), LOG_DEBUG);
                    $this->Session->setFlash('【エラー】登録時にエラーが発生しました。(0001)');
                    $this->redirect(array('action'=>'reg2/'.$case_id.'/'.$koushin_flag.'/'.$order_id));
                }
            // 登録（カレンダー）
            } elseif (isset($this->request->data['register2'])) {
                $this->log($this->request->data, LOG_DEBUG);
                // オーダーの登録がまだな場合、エラー
                if (is_null($order_id)) {
                    $this->Session->setFlash('【エラー】保存名などを入力の上、『職種入力』ボタンを押してください。');
                    $this->redirect(array('action'=>'reg2/'.$case_id.'/'.$koushin_flag));
                    return;
                }
                // 年月
                $year = $this->request->data['year'];
                $month = $this->request->data['month'];
                // 年月のセット
                $datas = $this->request->data['OrderCalender'];
                for ($i=0; $i<count($datas) ;$i++) {
                    $this->request->data['OrderCalender'][$i]['year'] = $this->request->data['year'];
                    $this->request->data['OrderCalender'][$i]['month'] = $this->request->data['month'];
                }
                $data3 = $this->request->data['OrderCalender'];
                $this->log($datas, LOG_DEBUG);
                // データを登録する（オーダー詳細）
                //$this->OrderInfoDetail->create(); 
                if ($this->OrderCalender->saveAll($data3)) {
                    // ログ書き込み
                    $conditions = array('id' => $case_id);
                    $result = $this->CaseManagement->find('first', array('conditions' => $conditions));
                    $conditions2 = array('id' => $order_id);
                    $result2 = $this->OrderInfo->find('first', array('conditions' => $conditions2));
                    $this->setCaseLog($username, $selected_class, $case_id, $result['CaseManagement']['case_name'], 
                            '('.$order_id.')'.$result2['OrderInfo']['order_name'], 23, $this->request->clientIp()); // (23)オーダーカレンダー登録コード:23
                    // 登録完了メッセージ
                    $this->Session->setFlash('登録しました。');
                    $this->redirect(array('action'=>'reg2/'.$case_id.'/'.$koushin_flag.'/'.$order_id));
                } else {
                    $this->log($this->OrderCalender->getDataSource()->getLog(), LOG_DEBUG);
                    $this->Session->setFlash('【エラー】登録時にエラーが発生しました。(0002)');
                    $this->redirect(array('action'=>'reg2/'.$case_id.'/'.$koushin_flag.'/'.$order_id));
                }
            // 削除（職種）
            } elseif (isset($this->request->data['delete'])) {
                $id_array = array_keys($this->request->data['delete']);
                $id = $id_array[0];
                // カレンダーの削除
                $conditions = array('id'=>$id);
                $result = $this->OrderInfoDetail->find('first', array('conditions'=>$conditions));
                //$this->log($result, LOG_DEBUG);
                $shokushu_num = $result['OrderInfoDetail']['shokushu_num'];
                $param = array('case_id' => $case_id, 'order_id' => $order_id, 'shokushu_num' => $shokushu_num);
                $this->OrderCalender->deleteAll($param);
                // 職種情報削除
                $this->OrderInfoDetail->delete($id);
                // ログ書き込み
                $conditions = array('id' => $case_id);
                $result = $this->CaseManagement->find('first', array('conditions' => $conditions));
                $conditions2 = array('id' => $order_id);
                $result2 = $this->OrderInfo->find('first', array('conditions' => $conditions2));
                $this->setCaseLog($username, $selected_class, $case_id, $result['CaseManagement']['case_name'], 
                        '('.$order_id.')'.$result2['OrderInfo']['order_name'], 26, $this->request->clientIp()); // (26)職種・カレンダー消去コード:26
                $this->redirect(array('action'=>'reg2/'.$case_id.'/'.$koushin_flag.'/'.$order_id));
            // 削除（オーダーごと）
            } elseif (isset($this->request->data['delete_order'])) {
                // オーダー名の取得
                $conditions2 = array('id' => $order_id);
                $result2 = $this->OrderInfo->find('first', array('conditions' => $conditions2));
                // 削除処理
                $id_array = array_keys($this->request->data['delete_order']);
                $id = $id_array[0];
                $this->OrderInfo->delete($id);
                $param = array('order_id' => $id);
                $this->OrderInfoDetail->deleteAll($param);
                $this->OrderCalender->deleteAll($param);
                // ログ書き込み
                $conditions = array('id' => $case_id);
                $result = $this->CaseManagement->find('first', array('conditions' => $conditions));
                $this->setCaseLog($username, $selected_class, $case_id, $result['CaseManagement']['case_name'], 
                        '('.$order_id.')'.$result2['OrderInfo']['order_name'], 25, $this->request->clientIp()); // (25)オーダー削除コード:25
                $this->Session->setFlash('オーダーを削除しました。');
                $this->redirect(array('action'=>'reg2/'.$case_id.'/'.$koushin_flag.'/'.$order_id));
            // カレンダー変更
            } else {
                $this->set('y', $this->request->data['OrderInfoDetail']['year']);
                $this->set('m', $this->request->data['OrderInfoDetail']['month']);
                //$this->redirect(array('action'=>'reg2/'.$case_id.'/'.$koushin_flag.'/'.$order_id));
            } 
        } elseif ($this->request->is('get')) {
            if (!empty($this->params['named']['row'])) {
                $row = $this->params['named']['row'];
            }
            if (!empty($this->request->query('date'))) {
                $date = $this->request->query('date');
                $date_arr = explode('-',$date);
                $year = $date_arr[0];
                $month = $date_arr[1];
            } else {
                //$year = date('Y');
                //$month = date('n');
                $year = date('Y', strtotime('+1 month'));
                $month = date('n', strtotime('+1 month'));
            }
            $this->set('row', $row);
            $this->set('year', $year);
            $this->set('month', $month);
            
            // 登録していた値をセット
            // オーダー一覧用
            $conditions = array('OrderInfo.case_id' => $case_id);
            $datas0 = $this->OrderInfo->find('all', array('conditions'=>$conditions));
            $this->set('datas0', $datas0);
            // オーダー入力欄以下
            if (is_null($order_id)) {
                $this->set('datas', null);
            } else {
                //$option['conditions'] = array('OrderInfo.case_id' => $case_id, 'OrderInfo.id' => $order_id);
                $conditions = array('OrderInfo.case_id' => $case_id, 'OrderInfo.id' => $order_id);
                $datas = $this->OrderInfo->find('all', array('conditions'=>$conditions));
                //$this->log($this->OrderInfo->getDataSource()->getLog(), LOG_DEBUG);
                $this->set('datas', $datas);
                $this->log($datas, LOG_DEBUG);
            }
            // 職種以下
            // オーダー入力欄以下
            if (is_null($order_id)) {
                $this->set('datas2', null);
            } else {
                $conditions = array('OrderInfoDetail.case_id' => $case_id, 'OrderInfoDetail.order_id' => $order_id);
                $datas2 = $this->OrderInfoDetail->find('all', array('conditions'=>$conditions));
                $this->set('datas2', $datas2);
                $this->log($datas2, LOG_DEBUG);
            }
            // カレンダー部分のデータ・セット
            $conditions = array('OrderCalender.case_id' => $case_id, 'OrderCalender.order_id' => $order_id, 'OrderCalender.year' => $year, 'OrderCalender.month' => $month);
            $datas1 = $this->OrderCalender->find('all', array('conditions'=>$conditions));
            $this->set('datas1', $datas1);
            $this->log($datas1, LOG_DEBUG);
            $record = $this->OrderInfo->find('count', $option);
            $this->set('record', $record);
            //$this->set('y', date('Y'));
            //$this->set('m', date('n')+1);
        } else {
            $this->Session->setFlash('【エラー】登録時にエラーが発生しました。（？）');
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
                $this->CaseManagement->setSource('staff_'.$this->Session->read('selected_class'));
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
            $this->log($this->CaseManagement->getDataSource()->getLog(), LOG_DEBUG);
            $this->log($conditions2, LOG_DEBUG);
        // GETの処理
        } elseif ($this->request->is('get')) {
            // プロフィールページへ
            if (isset($profile)) {
                // ページ数（レコード番号）を取得
                $conditions1 = array('kaijo_flag' => $flag, 'id <= ' => $case_id);
                $page = $this->CaseManagement->find('count', array('fields' => array('*'), 'conditions' => $conditions1));
                //$this->log($this->CaseManagement->getDataSource()->getLog(), LOG_DEBUG);
                //$this->log($page, LOG_DEBUG);
                $this->redirect(array('action' => 'profile', $flag, $case_id, 'page' => $page));
                exit();
            }
            // テーブル変更
            $this->CaseManagement->setSource('staff_'.$this->Session->read('selected_class'));
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
            //$this->log($this->CaseManagement->getDataSource()->getLog(), LOG_DEBUG);
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
                // 企業名の重複チェック
                $conditions = array('class'=>$selected_class, 'corp_name'=>$this->request->data['Customer']['corp_name']);
                $count = $this->Customer->find('count', array('conditions' => $conditions));
                if ($count > 0) {
                    $this->Session->setFlash('【エラー】企業名は既に登録されています。');
                    return;
                }
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
    
    /**
     * 帳票出力(excel)
     */
    public function download_excel($username) {
        // レイアウトは使わない
        $this -> layout = false;
        $data = $this -> User-> find('first', array('conditions'=>array('User.' . $this -> User -> primaryKey => $username)));
        $this -> set(compact('data'));
    }
    
    /**
     * 帳票出力(pdf)
     */
    public function download_pdf() {
        $this->response->type('pdf'); // Content-Type を指定
        $this->render(null, 'pdf');  // レイアウトを指定
    }
    
    /**
     * 帳票出力(pdf)
     */
    public function download_pdf2($username) {
        $data = $this -> User-> find('first', array('conditions'=>array('User.' . $this -> User -> primaryKey => $username)));
        $this -> set(compact('data'));
        $this->response->type('pdf'); // Content-Type を指定
        $this->render(null, 'pdf');  // レイアウトを指定
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
        $this->CaseManagement->setSource('item');
        // 職種２ :17
        $option = array(
            'conditions' => array('item' => '17'),
            'limit' => '15',
            'order' => array('sequence' => 'asc', 'id' => 'asc'));
        $this->paginate = $option;
        $this->set('datas', $this->paginate('Item'));
        
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
            $this->CaseManagement->setSource($tablename);
            //$this->log($this->CaseManagement->useTable);
        } else {
            $this->CaseManagement->setSource('staff_00');
        }
    }  
    
    /** 生年月日から年齢を割り出しマスタ更新 **/
    // 年齢換算
    public function setAge($class) {
        $sql = '';
        $sql = $sql. ' UPDATE staff_'.$class;
        $sql = $sql. ' SET age = (YEAR(CURDATE())-YEAR(birthday)) - (RIGHT(CURDATE(),5)<RIGHT(birthday,5));';
        
        // sqlの実行
        $ret = $this->CaseManagement->query($sql);
        
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
    //$code = $data['CaseManagement']['s0_1'];
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
    public function setCaseLog($username, $class, $case_id, $case_name, $order_name, $status, $ip_address) {
        $sql = '';
        $sql = $sql. ' INSERT INTO case_logs (username, class, case_id, case_name, order_name, status, ip_address, created)';
        $sql = $sql. ' VALUES ('.$username.', '.$class.', '.$case_id.', "'.$case_name.'", "'.$order_name.'", '.$status.', "'.$ip_address.'", now())';
        
        // sqlの実行
        $ret = $this->CaseLog->query($sql);
        
        return $ret;
    }
}
