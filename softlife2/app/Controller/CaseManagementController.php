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
    public $uses = array('CaseManagement', 'Item', 'User', 'Customer', 'OrderInfo', 'OrderInfoDetail');
    
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
        $conditions0 = array('item' => 16);
        $list_shokushu = $this->Item->find('list', array('fields' => array('id', 'value'), 'conditions' => $conditions0));
        $this->set('list_shokushu', $list_shokushu);
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
            $this->set('datas', $this->paginate('CaseManagement', $conditions3)); 
            $this->log($this->CaseManagement->getDataSource()->getLog(), LOG_DEBUG);
            //$this->log('GET', LOG_DEBUG);
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
        $condition2 = array('id' => $datas[0]['CaseManagement']['billing_destination']);
        $data_billing = $this->Customer->find('first', array('conditions' => $condition2));
        $this->set('data_billing', $data_billing);   
        // 事業主
        $condition3 = array('id' => $datas[0]['CaseManagement']['entrepreneur1']);
        $data1 = $this->Customer->find('first', array('conditions' => $condition3));
        if (!empty($data1)) {
            $entrepreneur1 = $data1['Customer']['corp_name'];
        } else {
            $entrepreneur1 = '';
        }
        $condition4 = array('id' => $datas[0]['CaseManagement']['entrepreneur2']);
        $data2 = $this->Customer->find('first', array('conditions' => $condition4));
        if (!empty($data2)) {
            $entrepreneur2 = $data2['Customer']['corp_name'];
        } else {
            $entrepreneur2 = '';
        }
        $condition5 = array('id' => $datas[0]['CaseManagement']['entrepreneur3']);
        $data3 = $this->Customer->find('first', array('conditions' => $condition5));
        if (!empty($data3)) {
            $entrepreneur3 = $data3['Customer']['corp_name'];
        } else {
            $entrepreneur3 = '';
        }
        $this->set('entrepreneur', $entrepreneur1.'<br>'.$entrepreneur2.'<br>'.$entrepreneur3);
        
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
        $conditions2 = array('class' => $selected_class);
        //$this->Customer->virtualFields['corp_info'] = 'CONCAT(corp_name, "　", busho, "　", tantou)';
        $customer_arr = $this->Customer->find('list', array('fields' => array( 'id', 'corp_name'), 'conditions' => $conditions2));
        $this->set('customer_arr', $customer_arr);
        // 登録データのセット
        $conditions3 = array('id' => $case_id);
        $data = $this->CaseManagement->find('first', array('conditions' => $conditions3));
        $this->set('data', $data);
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
        
        // post時の処理
        if ($this->request->is('post') || $this->request->is('put')) {
            if (isset($this->request->data['submit'])) {
                // モデルの状態をリセットする
                //$this->CaseManagement->create();
                // データを登録する
                if ($this->CaseManagement->save($this->request->data)) {
                    // 依頼主
                    $condition1 = array('id' => $this->request->data['CaseManagement']['client']);
                    $data_client = $this->Customer->find('first', array('conditions' => $condition1));
                    $this->set('data_client', $data_client);
                    // 請求先
                    $condition2 = array('id' => $this->request->data['CaseManagement']['billing_destination']);
                    $data_billing = $this->Customer->find('first', array('conditions' => $condition2));
                    $this->set('data_billing', $data_billing);
                    // 登録完了メッセージ
                    $this->Session->setFlash('登録しました。');

                } else {
                    $this->Session->setFlash('登録時にエラーが発生しました。');
                }
            //} elseif (isset($this->request->data['select_client']) || isset($this->request->data['select_billing'])) {
            } else {
                // 依頼主
                $condition1 = array('id' => $this->request->data['CaseManagement']['client']);
                $data_client = $this->Customer->find('first', array('conditions' => $condition1));
                $this->set('data_client', $data_client);
                // 請求先
                $condition2 = array('id' => $this->request->data['CaseManagement']['billing_destination']);
                $data_billing = $this->Customer->find('first', array('conditions' => $condition2));
                $this->set('data_billing', $data_billing);
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
                $condition2 = array('id' => $this->request->data['CaseManagement']['billing_destination']);
                $data_billing = $this->Customer->find('first', array('conditions' => $condition2));
                $this->set('data_billing', $data_billing);
            }
        }
    }
    
    // 登録ページ（オーダー情報）
    public function reg2($case_id = null, $koushin_flag = null) {
        // レイアウト関係
        $this->layout = "sub";
        $this->set("title_for_layout", $this->title_for_layout);
        // 登録データのセット
        $this->set('case_id', $case_id);
        $conditions3 = array('id' => $case_id);
        $data = $this->OrderInfo->find('first', array('conditions' => $conditions3));
        $this->set('data', $data);
        if (empty($data['OrderInfo']['shokushu_num'])) {
            $row = 1;
        } else {
            $row = $data['OrderInfo']['shokushu_num'];
        }
        $option = array();
        $option['recursive'] = -1; 
        $option['fields'] = array('OrderInfo.*', 'OrderInfoDetail.*'); 
        $option['joins'][] = array(
            'type' => 'LEFT',   //LEFT, INNER, OUTER
            'table' => 'order_info_details',
            'alias' => 'OrderInfoDetail',    //下でPost.user_idと書くために
            'conditions' => '`OrderInfo`.`id`=`OrderInfoDetail`.`case_id`',
        );
        $option['conditions'] = array('OrderInfo.id' => $case_id);
        // 職種マスタ配列
        $conditions0 = array('item' => 16);
        $list_shokushu = $this->Item->find('list', array('fields' => array('id', 'value'), 'conditions' => $conditions0));
        $this->set('list_shokushu', $list_shokushu);
        // その他
        $username = $this->Auth->user('username');
        $this->set('username', $username); 
        $this->set('koushin_flag', $koushin_flag);
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
                // データを登録する
                if ($this->OrderInfo->saveAll($this->request->data)) {
                    // 登録完了メッセージ
                    //$this->Session->setFlash('登録しました。');
                } else {
                    $this->Session->setFlash('登録時にエラーが発生しました。');
                    exit();
                }
                $this->redirect(array('action' => 'reg2', $case_id, $koushin_flag, 'row'=>$row));
            // 登録
            } elseif (isset($this->request->data['submit'])) {
                $data2 = $this->request->data['OrderInfoDetail'];
                // データを登録する
                //$this->OrderInfoDetail->create(); 
                if ($this->OrderInfoDetail->saveAll($data2)) {
                    // 登録完了メッセージ
                    $this->Session->setFlash('登録しました。');
                    // 登録していた値をセット
                    $this->request->data = $this->OrderInfo->find('all', $option);
                    $datas = $this->request->data;
                    $this->set('datas', $datas);
                    $record = $this->OrderInfo->find('count', $option);
                    $this->set('record', $record);
                } else {
                    $this->Session->setFlash('登録時にエラーが発生しました。');
                }
            } else {
                
            } 
        } elseif ($this->request->is('get')) {
            if (!empty($this->params['named']['row'])) {
                $row = $this->params['named']['row'];
            }
            $this->set('row', $row);
            // 登録していた値をセット
            $this->request->data = $this->OrderInfo->find('all', $option);
            $datas = $this->request->data;
            $this->set('datas', $datas);
            $this->log($this->request->data, LOG_DEBUG);
            $record = $this->OrderInfo->find('count', $option);
            $this->set('record', $record);
        } else {
            // 登録していた値をセット
            $this->request->data = $this->OrderInfo->find('all', $option);
            $datas = $this->request->data;
            $this->set('datas', $datas);
            $this->log($this->request->data, LOG_DEBUG);
            $record = $this->OrderInfo->find('count', $option);
            $this->set('record', $record);
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
    public function setSMLog($username, $class, $case_id, $staff_name, $kaijo_flag, $status, $ip_address) {
        $sql = '';
        $sql = $sql. ' INSERT INTO staff_master_logs (username, class, staff_id, staff_name, kaijo_flag, status, ip_address, created)';
        $sql = $sql. ' VALUES ('.$username.', '.$class.', '.$case_id.', "'.$staff_name.'", '.$kaijo_flag.', '.$status.', "'.$ip_address.'", now())';
        
        // sqlの実行
        $ret = $this->CaseManagementLog->query($sql);
        
        return $ret;
    }
}
