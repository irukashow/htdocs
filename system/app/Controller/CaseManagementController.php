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
    public $uses = array('CaseManagement', 'Item', 'User', 'Customer', 'OrderInfo', 
        'OrderInfoDetail', 'OrderCalender', 'CaseLog', 'StaffMaster', 'WorkTable', 'ReportTable');
    
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
        // 登録担当者配列
        $this->set('getTantou', $this->getTantou());
        // テーブルの設定
        //$this->CaseManagement->setSource('CaseManagement');
        // 引数の受け取り
        if (isset($this->params['named']['limit'])) {
            $limit = $this->params['named']['limit'];
        } else {
            $limit = '10';
        }
        // フラグ
        if (empty($flag)) {
            $flag = 0;
        }
        $this->set('flag', $flag);
        // 登録担当者
        $conditions = array('area' => substr($selected_class, 0, 1));
        $this->User->virtualFields['name'] = 'CONCAT(name_sei, " ", name_mei)';
        $name_arr = $this->User->find('list', array('fields' => array('username', 'name'), 'conditions' => $conditions));
        $this->set('name_arr', $name_arr); 
        // 職種マスタ配列
        $conditions0 = array('item' => 17, 'sequence != ' => '99');
        $list_shokushu = $this->Item->find('list', array('fields' => array('id', 'value'), 'conditions' => $conditions0, 'order' => 'sequence'));
        $this->set('list_shokushu', $list_shokushu);
        // 取引先配列
        $customer_array = $this->Customer->find('list', array('fields'=>array('id', 'corp_name')));
        $customer_array += array(''=>'');
        $this->set('customer_array', $customer_array);
        //$this->log($customer_array, LOG_DEBUG);
        // 表示件数の初期値
        $this->set('limit', $limit);
        $conditions1 = null;$conditions2 = null;$conditions3 = null;
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
        
        $this->log($this->request->data, LOG_DEBUG);
        // POSTの場合
        if ($this->request->is('post') || $this->request->is('put')) {
            // フラグの書き換え
            if (isset($this->request->data['delete'])) {
                $id_array = array_keys($this->request->data['delete']);
                $id = $id_array[0];
                // 完全削除
                if ($flag == 1) {
                    if ($this->CaseManagement->delete($id)) {
                        $this->Session->setFlash('【情報】完全削除いたしました。');
                    } else {
                        $this->Session->setFlash('【エラー】完全削除時にエラーが発生しました。');
                    }
                } else {
                    // 登録する内容を設定
                    $data = array('CaseManagement' => array('id' => $id, 'kaijo_flag' => 1));
                    // 登録する項目（フィールド指定）
                    $fields = array('kaijo_flag');
                    // 更新登録
                    if ($this->CaseManagement->save($data, false, $fields)) {
                        $this->Session->setFlash('【情報】削除が完了しました。');
                    } else {
                        $this->Session->setFlash('【エラー】削除時にエラーが発生しました。');
                    }
                }
                $this->redirect(array('action' => 'index', $flag));
            } elseif (isset($this->request->data['close'])) {
                $id_array = array_keys($this->request->data['close']);
                $id = $id_array[0];
                // 登録する内容を設定
                $data = array('CaseManagement' => array('id' => $id, 'kaijo_flag' => 2));
                // 登録する項目（フィールド指定）
                $fields = array('kaijo_flag');
                // 更新登録
                $this->CaseManagement->save($data, false, $fields);
                $this->Session->setFlash('【情報】クローズ処理が完了しました。');
                $this->redirect(array('action' => 'index', $flag));
            // 削除取り消し
            } elseif (isset($this->request->data['cancel'])) {
                $id_array = array_keys($this->request->data['cancel']);
                $id = $id_array[0];
                // 登録する内容を設定
                $data = array('CaseManagement' => array('id' => $id, 'kaijo_flag' => 0));
                // 登録する項目（フィールド指定）
                $fields = array('kaijo_flag');
                // 更新登録
                if ($this->CaseManagement->save($data, false, $fields)) {
                    if ($flag == 1) {
                        $this->Session->setFlash('【情報】削除を取り消しました。');
                    } elseif ($flag == 2) {
                        $this->Session->setFlash('【情報】クローズを取り消しました。');
                    }
                }
                $this->redirect(array('action' => 'index', $flag));
            // 絞り込み
            } elseif(isset($this->request->data['search'])) {
                // 依頼主で検索（部分一致）
                if (!empty($this->data['CaseManagement']['search_client'])){
                    $search_client_name = $this->data['CaseManagement']['search_client'];
                    $result_arr = preg_grep('/'.$search_client_name.'/', $customer_array);
                    if (!empty($result_arr)) {
                        $conditions2 += array('client' => key($result_arr));
                    } else {
                        $conditions2 += array('client' => 0);
                    }
                }
                // 事業主で検索（部分一致）
                if (!empty($this->data['CaseManagement']['search_entrepreneur'])){
                    $search_entrepreneur = $this->data['CaseManagement']['search_entrepreneur'];
                    $result_arr = preg_grep('/'.$search_entrepreneur.'/', $customer_array);
                    $conditions = null;
                    if (!empty($result_arr)) {
                        for ($i=1; $i<=10; $i++) {
                            if ($i == 1) {
                                $conditions = array('entrepreneur'.$i => key($result_arr));
                            } else {
                                $conditions += array('entrepreneur'.$i => key($result_arr));
                            }
                        }
                        $conditions2 += array('OR' => $conditions);
                    } else {
                        $conditions2 += array('entrepreneur1' => 0);
                    }
                    $this->log($result_arr, LOG_DEBUG);
                }
                // 契約形態で検索
                if (!empty($this->data['CaseManagement']['search_contract'])){
                    $search_contract = $this->data['CaseManagement']['search_contract'];
                    $conditions2 += array('CaseManagement.contract_type' => $search_contract);
                    //$this->log($search_contract, LOG_DEBUG);
                }
                // 開始日
                if (!empty($this->data['CaseManagement']['search_start_date'])){
                    $start_date = $this->data['CaseManagement']['search_start_date'];
                    //$this->log($search_area);
                    $conditions2 += array('start_date' => $start_date);
                }
                // 担当者（弊社）
                if (!empty($this->data['CaseManagement']['search_tantou'])){
                    $tantou = $this->data['CaseManagement']['search_tantou'];
                    //$this->log($search_area);
                    $conditions2 += array('CaseManagement.username' => $tantou);
                }
                // 就業場所住所（部分一致）
                if (!empty($this->data['CaseManagement']['search_place'])){
                    $search_area = $this->data['CaseManagement']['search_place'];
                    //$this->log($search_area);
                    $conditions2 += array('CaseManagement.address LIKE ' => '%'.$search_area.'%');
                }
                // 職種
                if (!empty($this->data['CaseManagement']['search_shokushu'])){
                    $search_shokushu = $this->data['CaseManagement']['search_shokushu'];
                    // オーダー内容用
                    $joins = array(
                      array(
                        'type' => 'left',// innerもしくはleft
                        'table' => 'order_infos',
                        'alias' => 'OrderInfo',
                        'conditions' => array(
                          'OrderInfoDetail.order_id = OrderInfo.id', //ここ文字列なので注意
                        ),
                      ),
                    );
                    $conditions4 = array('OrderInfoDetail.class'=>$selected_class, 
                        'OrderInfoDetail.shokushu_id'=>$search_shokushu,
                        'OR' => array(
                            array('OrderInfo.period_to >= '=>date('Ym').'01', 'OrderInfo.period_to <= '=>date('Ym', strtotime('+1 month')).'31'),
                            array('OrderInfo.period_from >= '=>date('Ym').'01', 'OrderInfo.period_from <= '=>date('Ym', strtotime('+1 month')).'31')
                            )
                        );
                    $result = $this->OrderInfoDetail->find('all', 
                            array('conditions'=>$conditions4, 'fields'=>array('OrderInfoDetail.case_id', 'OrderInfoDetail.shokushu_id'), 
                                'joins'=>$joins, 
                                'order'=>array('OrderInfoDetail.case_id', 'OrderInfoDetail.order_id', 'OrderInfoDetail.shokushu_num')));
                    foreach ($result as $key=>$value) {
                        $array1[$key] = $value['OrderInfoDetail']['case_id'];
                    }
                    if (!empty($array1)) {
                        $array2 = array_unique($array1);
                    }
                    $array3 = array();
                    if (!empty($array2)) {
                        foreach($array2 as $key=>$value) {
                            $array3[$key] = array('CaseManagement.id' => $value);
                        }
                        $conditions2 += array('OR' => $array3);
                    } else {
                        $conditions2 += array('CaseManagement.id' => 0);
                    }
                    //$this->log($conditions2, LOG_DEBUG);
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
            $datas = $this->paginate('CaseManagement', $conditions2);
            $this->set('datas', $datas);
            //$this->log($this->CaseManagement->getDataSource()->getLog(), LOG_DEBUG);
            
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
            $conditions3 += array('class'=>$selected_class);
            //$this->request->params['named']['page'] = 1;
            $datas = $this->paginate('CaseManagement', $conditions3);
            $this->set('datas', $datas);
        } else {
            /**
            $this->log('ここ', LOG_DEBUG);
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
             * 
             */
        }
        $this->set('selected_class', $this->Session->read('selected_class'));
        
        // 共通処理
        if (!empty($datas)) {
            // オーダー内容用
            foreach($datas as $key=>$data) {
                $joins = array(
                  array(
                    'type' => 'left',// innerもしくはleft
                    'table' => 'order_infos',
                    'alias' => 'OrderInfo',
                    'conditions' => array(
                      'OrderInfoDetail.order_id = OrderInfo.id', //ここ文字列なので注意
                    ),
                  ),
                );
                $conditions2 = array('OrderInfoDetail.case_id'=>$data['CaseManagement']['id'], 
                    'OR' => array(
                        array('OrderInfo.period_to >= '=>date('Ym').'01', 'OrderInfo.period_to <= '=>date('Ym', strtotime('+1 month')).'31'),
                        array('OrderInfo.period_from >= '=>date('Ym').'01', 'OrderInfo.period_from <= '=>date('Ym', strtotime('+1 month')).'31')
                        )
                    );
                $result_order[$key] = $this->OrderInfoDetail->find('all', 
                        array('conditions'=>$conditions2, 'fields'=>array('*', 'COUNT(OrderInfoDetail.shokushu_id) AS cnt'), 
                            'group'=>array('OrderInfoDetail.shokushu_id', 'OrderInfoDetail.shokushu_memo'), 'joins'=>$joins, 
                            'order'=>array('OrderInfoDetail.order_id', 'OrderInfoDetail.shokushu_num')));
            }
            //$this->log($result_order, LOG_DEBUG);
            //$this->log('レコード数は、'.count($result_order), LOG_DEBUG);
            $this->set('datas_order', $result_order);
            // オーダー情報の更新日
            foreach($datas as $key=>$data) {
                $conditions2 = array('case_id'=>$data['CaseManagement']['id'], 'status LIKE '=>'2%');
                $result[$key] = $this->CaseLog->find('first', array('conditions'=>$conditions2, 'order'=>array('created'=>'desc')));
            }
            //$this->log($result, LOG_DEBUG);
            $this->set('order_update_date', $result);
            // シフト入力の更新日
            foreach($datas as $key=>$data) {
                $conditions3 = array('case_id'=>$data['CaseManagement']['id']);
                $result2[$key] = $this->WorkTable->find('first', array('conditions'=>$conditions3, 'order'=>array('modified'=>'desc')));
            }
            $this->log($result2, LOG_DEBUG);
            $this->set('shift_update_date', $result2);
        } else {
            $this->set('order_update_date', null);
            $this->set('shift_update_date', null);
        }
             
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
        $this->set('case_id', $case_id);
                
        // ページネーション
        //$conditions2 = array('id' => $case_id, 'kaijo_flag' => $flag);
        $conditions2 = array('kaijo_flag' => $flag);
        //$conditions2 = null;
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
        if (empty($datas[0]['CaseManagement']['username'])) {
            $this->set('contact', '');
        } else {
            $condition0 = array('username' => $datas[0]['CaseManagement']['username']);
            $data = $this->User->find('first', array('conditions' => $condition0));
            $this->set('contact', $data['User']['busho_name'].'　'.$data['User']['name_sei'].' '.$data['User']['name_mei']);
        }
        // 依頼主データ
        $condition1 = array('id' => $datas[0]['CaseManagement']['client']);
        $data_client = $this->Customer->find('first', array('conditions' => $condition1));
        $this->set('data_client', $data_client);
        // 依頼主データ
        $condition3 = array('id' => $datas[0]['CaseManagement']['director_corp']);
        $data_director = $this->Customer->find('first', array('conditions' => $condition3));
        $this->set('data_director', $data_director);
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
        // 販売会社
        $distributor = '';
        for($i=0; $i<10; $i++) {
            $condition3 = array('id' => $datas[0]['CaseManagement']['distributor'.($i+1)]);
            $data1 = $this->Customer->find('first', array('conditions' => $condition3));
            $this->log($data1, LOG_DEBUG);
            if (!empty($data1)) {
                $distributor1 = $data1['Customer']['corp_name'];
                if (empty($distributor)) {
                    $distributor = $distributor1;
                } else {
                    $distributor .= '<br>'.$distributor1;
                }
            } else {
                $distributor1 = '';
            }
        }
        $this->set('distributor', $distributor);
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
                // 現在のURLをセッションに保存
                $this->Session->write('cm_profile_url', Router::reverse($this->request, true));
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
        } elseif ($this->request->is('get')) {
            // ページ引数
            if (empty($this->params['named']['page'])) {
                $page = 1;
            } else {
                $page = $this->params['named']['page'];
            }
            $this->set('page', $page);
            // 指定月
            if (!empty($this->request->query('year'))) {
                $year = $this->request->query('year');
            } else {
                $year = date('Y');
            }
            $this->set('year', $year);
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
        $this->Customer->virtualFields['corp_name2'] = 'CONCAT("（", LEFT(corp_name_kana,1), "）", corp_name)';
        $customer_arr = $this->Customer->find('list', array('fields' => array( 'id', 'corp_name2'), 'conditions' => $conditions2, 'order' => array('corp_name_kana'=>'asc')));
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
        // 販売会社の数
        $count1 = 0;
        $count_distributor = 0;
        for ($i=0; $i < 10; $i++) {
            if (!empty($data['CaseManagement']['distributor'.($i+1)])) {
                $count1 = $i+1;
            }
        }
        $count_distributor = $count1;
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
        $data_billing = null;
        
        // post時の処理
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->log($this->request->data, LOG_DEBUG);
            if (isset($this->request->data['submit'])) {
                // モデルの状態をリセットする
                //$this->CaseManagement->create();
                // データを登録する
                if ($this->CaseManagement->save($this->request->data)) {
                    if ($case_id == 0) {
                        $case_id = $this->CaseManagement->getLastInsertID();
                    }
                    // ログ書き込み
                    $this->setCaseLog($username, $selected_class, $case_id, $this->request->data['CaseManagement']['case_name'], 0, 11, $this->request->clientIp()); // 案件基本情報登録コード:11
                    // 登録完了メッセージ
                    $this->Session->setFlash('【情報】登録を完了しました。');
                    $this->redirect(array('action'=>'reg1', $case_id, 1));
                } else {
                    $this->Session->setFlash('【エラー】登録時にエラーが発生しました。');
                }
            // 事業主追加
            } elseif (isset($this->request->data['insert_entrepreneur'])) {
                // 重複チェック
                $flag = false;
                $condition1 = array('id' => $case_id);
                $data = $this->CaseManagement->find('first', array('conditions'=>$condition1));
                //$this->log($data, LOG_DEBUG);
                for ($j=0; $j<10; $j++) {
                    if (empty($data['CaseManagement']['entrepreneur'.($j+1)])) {
                        continue;
                    }
                    if ($this->request->data['CaseManagement']['entrepreneur'] == $data['CaseManagement']['entrepreneur'.($j+1)]) {
                        $flag = true;
                    }
                }
                if ($flag) {
                    $this->Session->setFlash('【エラー】事業主が既に存在します。');
                    $this->redirect(array('action'=>'./reg1/'.$case_id.'/'.$koushin_flag));
                    return;
                }
                // 登録する内容を設定
                $data2 = array('CaseManagement' => array('id' => $this->request->data['CaseManagement']['id'], 'class' => $selected_class,
                    'case_name' => $this->request->data['CaseManagement']['case_name'], 'username' => $this->request->data['CaseManagement']['username'], 
                    'contract_type' => $this->request->data['CaseManagement']['contract_type'], 
                    'entrepreneur'.($count_entrepreneur+1) => $this->request->data['CaseManagement']['entrepreneur']));
                // 登録する項目（フィールド指定）
                $fields = array('case_name','class', 'username','contract_type','entrepreneur'.($count_entrepreneur+1)); 
                // 更新登録
                $this->CaseManagement->save($data2, false, $fields);
                if ($case_id == 0) {
                    $case_id = $this->CaseManagement->getLastInsertID();
                }
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
            // 販売会社の追加
            } elseif (isset($this->request->data['insert_distributor'])) {
                // 重複チェック
                $flag = false;
                $condition1 = array('id' => $case_id);
                $data = $this->CaseManagement->find('first', array('conditions'=>$condition1));
                //$this->log($data, LOG_DEBUG);
                for ($j=0; $j<10; $j++) {
                    if (empty($data['CaseManagement']['distributor'.($j+1)])) {
                        continue;
                    }
                    if ($this->request->data['CaseManagement']['distributor'] == $data['CaseManagement']['distributor'.($j+1)]) {
                        $flag = true;
                    }
                }
                if ($flag) {
                    $this->Session->setFlash('【エラー】販売会社が既に存在します。');
                    $this->redirect(array('action'=>'./reg1/'.$case_id.'/'.$koushin_flag));
                    return;
                }
                // 登録する内容を設定
                $data2 = array('CaseManagement' => array('id' => $this->request->data['CaseManagement']['id'], 'class' => $selected_class,
                    'case_name' => $this->request->data['CaseManagement']['case_name'], 'username' => $this->request->data['CaseManagement']['username'], 
                    'contract_type' => $this->request->data['CaseManagement']['contract_type'], 
                    'distributor'.($count_distributor+1) => $this->request->data['CaseManagement']['distributor']));
                // 登録する項目（フィールド指定）
                $fields = array('case_name','class', 'username','contract_type','distributor'.($count_distributor+1)); 
                // 更新登録
                $this->CaseManagement->save($data2, false, $fields);
                if ($case_id == 0) {
                    $case_id = $this->CaseManagement->getLastInsertID();
                }
                $this->redirect(array('action'=>'./reg1/'.$case_id.'/'.$koushin_flag));
            // 販売会社の削除
            } elseif (isset($this->request->data['delete_distributor'])) {
                $i_array = array_keys($this->request->data['delete_distributor']);
                $i = $i_array[0];
                // 登録する内容を設定
                $data = array('CaseManagement' => array('id' => $this->request->data['CaseManagement']['id'], 'distributor'.$i => null));
                // 登録する項目（フィールド指定）
                $fields = array('distributor'.$i); 
                // 更新登録
                if ($this->CaseManagement->save($data, false, $fields)) {
                    // 成功
                    $this->redirect(array('action'=>'./reg1/'.$case_id.'/'.$koushin_flag));
                }
            // 請求先追加
            } elseif (isset($this->request->data['insert_billing'])) { 
                $this->Session->write('insert_billing', 1);
                $this->set('insert_billing', 1);
                // 更新登録
                $this->CaseManagement->save($this->request->data);
                if ($case_id == 0) {
                    $case_id = $this->CaseManagement->getLastInsertID();
                }
                $this->redirect(array('action'=>'reg1', $case_id, $koushin_flag));
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
            // 依頼主
            } elseif (isset($this->request->data['select_client'])) {
                if (empty($this->request->data['CaseManagement']['client'])) {
                    return;
                }
                // 新規・更新登録
                if ($this->CaseManagement->save($this->request->data)) {
                    if ($case_id == 0) {
                        $case_id = $this->CaseManagement->getLastInsertID();
                    }
                    $this->log('案件ID:'.$case_id, LOG_DEBUG);
                    $this->redirect(array('action'=>'reg1', $case_id, $koushin_flag));
                }
            // 請求先
            } elseif (isset($this->request->data['select_billing'])) {
                /**
                $j_array = array_keys($this->request->data['select_billing']);
                $j = $j_array[0];
                 * 
                 */
                // 更新登録
                if ($this->CaseManagement->save($this->request->data)) {
                    // 成功
                    if ($case_id == 0) {
                        $case_id = $this->CaseManagement->getLastInsertID();
                    }
                }
                $this->redirect(array('action'=>'reg1', $case_id, $koushin_flag));
            // 登録削除
            } elseif (isset($this->request->data['delete'])) {
                if ($this->CaseManagement->delete($case_id)) {
                    $this->Session->setFlash('【情報】登録を取り消しました。ウィンドウを閉じてください。');
                }
                $this->redirect(array('action'=>'reg1', 0, 0));
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
                //$this->log($data_billing, LOG_DEBUG);
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
        // その他
        $username = $this->Auth->user('username');
        $this->set('username', $username); 
        $this->set('koushin_flag', $koushin_flag);
        $this->set('order_id', $order_id);
        $selected_class = $this->Session->read('selected_class');
        $this->set('selected_class', $selected_class);
        $this->StaffMaster->setSource('staff_'.$selected_class);
        // 初期化
        if (empty($data['OrderInfo']['shokushu_num'])) {
            $row = 1;
        } else {
            $row = $data['OrderInfo']['shokushu_num'];
        }
        $this->set('row', $row);
        $option = array();
        $option['fields'] = array('OrderInfo.*', 'OrderInfoDetail.*', 'OrderCalender.*'); 
        $option['order'] = array('OrderInfo.id' => 'asc');
        $option['joins'] = array(
        array(
            'type' => 'LEFT',   //LEFT, INNER, OUTER
            'table' => 'order_info_details',
            'alias' => 'OrderInfoDetail',    //下でPost.user_idと書くために
            'conditions' => 'OrderInfo.id = OrderInfoDetail.order_id'
            ),
        array(
            'type' => 'LEFT',   //LEFT, INNER, OUTER
            'table' => 'order_calenders',
            'alias' => 'OrderCalender',    //下でPost.user_idと書くために
            'conditions' => 'OrderInfo.id = OrderCalender.order_id AND OrderInfoDetail.shokushu_num = OrderCalender.shokushu_num'
            ),
        );
        // 職種マスタ配列
        $conditions0 = array('item' => 17, 'sequence != ' => '99');
        $list_shokushu = $this->Item->find('list', array('fields' => array('id', 'value'), 'conditions' => $conditions0, 'order'=>array('sequence')));
        $this->set('list_shokushu', $list_shokushu);
        // 案件配列
        $conditions5 = array('class' => $selected_class);
        $case_arr = $this->CaseManagement->find('list', array('fields' => array('id', 'case_name'), 'conditions' => $conditions5, 'order' => array('id'=>'asc')));
        $this->set('case_arr', $case_arr); 

        //$this->log($this->request->data['OrderInfo'], LOG_DEBUG);
        //$this->log('$row='.$row, LOG_DEBUG);
        // post時の処理
        if ($this->request->is('post') || $this->request->is('put')) {
            //$this->log($this->request->data, LOG_DEBUG);
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
                $data4 = $this->request->data;
                if ($this->OrderInfo->save($data4)) {
                    //$this->log($this->OrderInfo->getDataSource()->getLog(), LOG_DEBUG);
                    if (empty($order_id)) {
                        $order_id = $this->OrderInfo->getLastInsertID();
                    }
                    // ログ書き込み
                    $conditions = array('id' => $case_id);
                    $result = $this->CaseManagement->find('first', array('conditions' => $conditions));
                    $this->setCaseLog($username, $selected_class, $case_id, $result['CaseManagement']['case_name'], 
                            '('.$order_id.')'.$this->request->data['OrderInfo']['order_name'], 21, $this->request->clientIp()); // (2)オーダー名登録コード:21
                    $this->Session->setFlash('２．次に、職種情報を入力してください。');
                    // 月の差分
                    $diff_month = date('n', strtotime($data4['OrderInfo']['period_to']) - strtotime($data4['OrderInfo']['period_from']));
                    $this->log($diff_month, LOG_DEBUG);
                    // sequenceの取得
                    $conditions3 = array(
                        'case_id' => $case_id,
                        'order_id' => $order_id,
                        'class' => $selected_class,
                    );
                    $result2 = $this->OrderCalender->find('first', array('conditions'=>$conditions3));
                    if (empty($result2)) {
                        $sequence = 0;
                    } else {
                        $sequence = $result2['OrderCalender']['sequence'];
                    }
                    // 契約期間の空のカレンダーを作成
                    $datas3 = null;
                    for ($j=0; $j<$diff_month; $j++) {
                        $year = date('Y', strtotime($j.' month '.$data4['OrderInfo']['period_from']));
                        $month = date('n', strtotime($j.' month '.$data4['OrderInfo']['period_from']));
                        for ($i=1; $i<=$row; $i++) {
                            $conditions2 = array(
                                'case_id' => $case_id,
                                'order_id' => $order_id,
                                'shokushu_num' => $i,
                                'year' => $year,
                                'month' => $month,
                                'sequence' => $sequence,
                                'class' => $selected_class,
                            );
                            $count = $this->OrderCalender->find('count', array('conditions'=>$conditions2));
                            if ($count == 0) {
                                $datas3[] = array('OrderCalender'=>$conditions2);
                            }
                        }
                    }
                    if (!empty($datas3)) {
                        $this->OrderCalender->saveAll($datas3);
                    }
                    // 契約期間外の月を削除
                    $conditions5 = array('case_id' => $case_id,'order_id' => $order_id,'class' => $selected_class);
                    $datas5 = $this->OrderCalender->find('all', array('conditions'=>$conditions5));
                    foreach($datas5 as $data5) {
                        if (strtotime($data4['OrderInfo']['period_from']) > strtotime($data5['OrderCalender']['year'].'-'.$data5['OrderCalender']['month'].'-31') 
                                || strtotime($data4['OrderInfo']['period_to']) < strtotime($data5['OrderCalender']['year'].'-'.$data5['OrderCalender']['month'].'-01') ) {
                            $this->log($data5['OrderCalender']['year'].'/'.$data5['OrderCalender']['month'].'はダメ！', LOG_DEBUG);
                            $this->OrderCalender->delete($data5['OrderCalender']['id']);
                        }
                    }
                    $this->log($datas3, LOG_DEBUG);
                } else {
                    $this->Session->setFlash('【エラー】登録時にエラーが発生しました。');
                    exit();
                }
                $this->redirect(array('action' => 'reg2', $case_id, $koushin_flag, $order_id, 'row'=>$row));
            // 登録（職種等）
            } elseif (isset($this->request->data['register'])) {
                $this->log($this->request->data, LOG_DEBUG);
                // オーダーの登録がまだな場合、エラー
                if (is_null($order_id)) {
                    $this->Session->setFlash('【エラー】『オーダー入力』を入力の上、『(1)登録』ボタンを押してください。');
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
                    $this->Session->setFlash('３．カレンダーで勤務日を指定してください。');
                    $this->redirect(array('action'=>'reg2/'.$case_id.'/'.$koushin_flag.'/'.$order_id));
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
                    $this->Session->setFlash('【エラー】『オーダー入力』を入力の上、『(1)登録』ボタンを押してください。');
                    $this->redirect(array('action'=>'reg2/'.$case_id.'/'.$koushin_flag));
                    return;
                }
                // 職種等の情報を入力しているかチェック
                $conditions4 = array('class'=>$selected_class, 'order_id'=>$order_id);
                if ($this->OrderInfoDetail->find('count', array('conditions'=>$conditions4)) == 0) {
                    $this->Session->setFlash('【エラー】職種以下を入力の上、『(2)登録』ボタンを押してください。');
                    $this->redirect(array('action'=>'reg2/'.$case_id.'/'.$koushin_flag.'/'.$order_id));
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
                    // 推奨スタッフのセッションの削除
                    for($i=0; $i<$row; $i++) {
                        $this->Session->delete('staff_id-'.$order_id.'_'.$i);
                    }
                    // スケジュールが空の職種レコードを削除
                    $conditions3 = array('class'=>$selected_class, 'order_id'=>$order_id);
                    $datas3 = $this->OrderCalender->find('all', array('conditions'=>$conditions3));
                    $this->log($datas3, LOG_DEBUG);
                    $val1 = 0;
                    foreach($datas3 as $j=>$data3) {
                        for ($d=1; $d<=31; $d++) {
                            if ($d == 1) {
                                $val1 = $data3['OrderCalender']['d'.$d];
                            } else {
                                $val1 = $val1 + $data3['OrderCalender']['d'.$d];
                            }
                        }
                        if ($val1 == 0) {
                            $this->log('からのカラム：'.$data3['OrderCalender']['id'], LOG_DEBUG);
                            $this->OrderCalender->delete($data3['OrderCalender']['id']);
                        }
                    }
                    // 登録完了メッセージ
                    $this->Session->setFlash('【情報】登録を完了しました。');
                    $date = $this->request->query('date');
                    if (empty($date)) {
                        $date2 = null;
                    } else {
                        $date2 = '?date='.$date;
                    }
                    $this->redirect(array('action'=>'reg2/'.$case_id.'/'.$koushin_flag.'/'.$order_id, $date2));
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
                $this->redirect(array('action'=>'reg2/'.$case_id.'/'.$koushin_flag));
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
            // 閉じる
            } elseif (isset($this->request->data['close'])) {
                // 推奨スタッフのセッションの削除
                for($i=0; $i<$row; $i++) {
                    $this->Session->delete('staff_id-'.$order_id.'_'.$i);
                }
            // カレンダー変更
            } else {
                $this->set('y', $this->request->data['OrderInfoDetail']['year']);
                $this->set('m', $this->request->data['OrderInfoDetail']['month']);
                //$this->redirect(array('action'=>'reg2/'.$case_id.'/'.$koushin_flag.'/'.$order_id));
            } 
        } elseif ($this->request->is('get')) {
            // 登録していた値をセット
            // オーダー一覧用
            $conditions = array('OrderInfo.case_id' => $case_id);
            $datas0 = $this->OrderInfo->find('all', array('conditions'=>$conditions));
            $this->set('datas0', $datas0);
            //$this->log($datas0, LOG_DEBUG);
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
            // 年月
            if (!empty($this->params['named']['row'])) {
                $row = $this->params['named']['row'];
            }
            $selected_date = null;
            if (!empty($this->request->query('date'))) {
                $date = $this->request->query('date');
                $date_arr = explode('-',$date);
                $year = $date_arr[0];
                $month = $date_arr[1];
                $selected_date = $date;
            } else {
                if (empty($datas)) {
                    $year = date('Y', strtotime('+1 month'));
                    $month = date('n', strtotime('+1 month'));
                } else {
                    $year = date('Y', strtotime($datas[0]['OrderInfo']['period_from']));
                    $month = date('n', strtotime($datas[0]['OrderInfo']['period_from']));  
                }
            }
            $month = ltrim($month, '0');
            $this->set('row', $row);
            $this->set('year', $year);
            $this->set('month', $month);
            $this->set('selected_date', $selected_date);
            // 職種以下
            // オーダー入力欄以下
            if (is_null($order_id)) {
                $this->set('datas2', null);
            } else {
                $conditions = array('OrderInfoDetail.case_id' => $case_id, 'OrderInfoDetail.order_id' => $order_id);
                $datas2 = $this->OrderInfoDetail->find('all', array('conditions'=>$conditions));
                $this->set('datas2', $datas2);
                //$this->log($datas2, LOG_DEBUG);
            }
            // レコード数
            $record = $this->OrderInfo->find('count', $option);
            $this->set('record', $record);
            // カレンダー部分のデータ・セット
            //$conditions = array('OrderCalender.case_id' => $case_id, 'OrderCalender.order_id' => $order_id, 'OrderCalender.year' => $year, 'OrderCalender.month' => $month);
            //$datas1 = $this->OrderCalender->find('all', array('conditions'=>$conditions, 'order'=>array('shokushu_num')));
            for ($i=0; $i<20; $i++) {
                $conditions = array('OrderCalender.case_id' => $case_id, 'OrderCalender.order_id' => $order_id, 
                    'OrderCalender.year' => $year, 'OrderCalender.month' => $month, 'OrderCalender.shokushu_num' => $i+1);
                $result3 = $this->OrderCalender->find('first', array('conditions'=>$conditions));
                if (empty($result3)) {
                    $datas1[$i] = null;
                } else {
                    $datas1[$i] = $result3;
                }
            }
            $this->set('datas1', $datas1);
            $this->log($datas1, LOG_DEBUG);
            
            // スタッフ選択の値を渡す
            $results = null;
            $values = $this->OrderInfo->find('first', array('conditions'=>array('id'=>$order_id)));
            for($i=0; $i<$row; $i++) {
                $result = null;
                if (!empty($values['OrderInfo']['staff_ids'.($i+1)])) {
                    $ids = explode(',', $values['OrderInfo']['staff_ids'.($i+1)]);
        $this->log($ids, LOG_DEBUG);
                    $result = $ids;
                } else {
                    $result =null;
                }
                $results[$i] = $result;
            }
            $this->set('staff_ids', $results);
            //$this->log($results, LOG_DEBUG);
            // スタッフ名の検索
            $results2 = null;
            for($i=0; $i<$row; $i++) {
                $values = $this->OrderInfo->find('first', array('conditions'=>array('id'=>$order_id)));
                //$this->log($values, LOG_DEBUG);
                $result2 = null;
                if (!empty($values['OrderInfo']['staff_ids'.($i+1)])) {
                    $ids = explode(',', $values['OrderInfo']['staff_ids'.($i+1)]);
                    foreach($ids as $key=>$id) {
                        if (empty($id)) {
                            continue;
                        }
                        if (strstr($id, 'u')) {
                            $res = $this->User->find('first', array('conditions'=>array('username'=>ltrim($id, 'u'))));
                            $result2[$key] = $res['User']['name_sei'].' '.$res['User']['name_mei'];
                        } else {
                            $res = $this->StaffMaster->find('first', array('conditions'=>array('id'=>$id)));
                            $result2[$key] = $res['StaffMaster']['name_sei'].' '.$res['StaffMaster']['name_mei'];
                        }
                    }
                } else {
                    $result2 = null;
                }
                $results2[$i] = $result2;
                //$this->log($result2, LOG_DEBUG);
            }
            //$this->log($results2, LOG_DEBUG);
            $this->set('staff_names', $results2);
            //$this->log($results2, LOG_DEBUG);
            //$this->Session->delete('staff_id');
        } else {
            $this->Session->setFlash('【エラー】登録時にエラーが発生しました。（？）');
        }
    }
    
    // 登録ページ（契約書作成、入力２）
    public function reg3($case_id = null, $koushin_flag = null, $order_id = null) {
        // レイアウト関係
        $this->layout = "sub";
        $this->set("title_for_layout", $this->title_for_layout);
        // オーダー一覧用
        $conditions = array('OrderInfo.case_id' => $case_id);
        $this->set('case_id', $case_id);
        $datas0 = $this->OrderInfo->find('all', array('conditions'=>$conditions));
        $this->set('datas0', $datas0);
        // オーダー選択コンボ用
        if (!empty($datas0)) {
            foreach($datas0 as $data0) {
                $order_arr[$data0['OrderInfo']['id']] = '★　自 '.$this->convGtJDate($data0['OrderInfo']['period_from'])
                        .' ～ 至 '.$this->convGtJDate($data0['OrderInfo']['period_to']).'   '.$data0['OrderInfo']['order_name'];;
            }
        } else {
            $order_arr = null;
        }
        $this->set('order_arr', $order_arr);
        // その他
        $username = $this->Auth->user('username');
        $this->set('username', $username); 
        $this->set('koushin_flag', $koushin_flag);
        $this->set('order_id', $order_id);
        $selected_class = $this->Session->read('selected_class');
        $this->set('selected_class', $selected_class);
        $this->StaffMaster->setSource('staff_'.$selected_class);
        // 社員配列
        $conditions2 = array('area' => substr($selected_class, 0, 1));
        $this->User->virtualFields['name'] = 'CONCAT(name_sei, " ", name_mei)';
        $user_arr = $this->User->find('list', array('fields' => array('username', 'name'), 'conditions' => $conditions2));
        $this->set('user_arr', $user_arr); 
        // 職種マスタ配列
        $conditions0 = array('item' => 17);
        $list_shokushu = $this->Item->find('list', array('fields' => array('id', 'value'), 'conditions' => $conditions0, 'order'=>array('sequence')));
        $this->set('list_shokushu', $list_shokushu);
        // 案件配列
        $conditions3 = array('class' => $selected_class);
        $case_arr = $this->CaseManagement->find('list', array('fields' => array('id', 'case_name'), 'conditions' => $conditions3, 'order' => array('id'=>'asc')));
        $this->set('case_arr', $case_arr); 
        // 和暦配列
        $conditions4 = array('item' => 30);
        $jyear_arr = $this->Item->find('list', array('fields' => array('id', 'value'), 'conditions' => $conditions4, 'order'=>array('sequence')));
        $this->set('jyear_arr', $jyear_arr);
        // 書類配列
        $datas2= array(
            0=>'労働者派遣契約書【個別】',
            1=>'派遣先管理台帳（兼）通知書',
            2=>'派遣元管理台帳',
            3=>'労働条件通知書（兼）就業条件明示書',
            4=>'業務委託契約書',
            //5=>'その他',
            );
        $this->set('datas2', $datas2);

        // post時の処理
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->log($this->request->data, LOG_DEBUG);
            // 次へ進む
            if (isset($this->request->data['forward'])) {
                if (empty($order_id)) {
                    $this->Session->setFlash('【エラー】オーダーを選択してください。');
                    $this->redirect(array('action' => 'reg3', $case_id, $koushin_flag));
                } else {
                    // POST情報をセッションにセット
                    if (!empty($this->Session->read('data_report'))) {
                        $this->Session->delete('data_report');
                    }
                    $this->Session->write('data_report', $this->request->data['ReportTable']);
                    $this->redirect(array('action' => 'reg3_2', $case_id, $koushin_flag, $order_id));
                }
            // オーダー選択
            } else {
                if (!empty($this->request->data)) {
                    $order_id = $this->request->data['OrderInfo']['id'];
                    $this->redirect(array('action' => 'reg3', $case_id, $koushin_flag, $order_id));
                }
            } 
        } elseif ($this->request->is('get')) {
            if (!empty($order_id)) {
                // 登録データのセット
                $conditions1 = array('id' => $order_id, 'case_id' => $case_id);
                $data = $this->OrderInfo->find('first', array('conditions' => $conditions1));
                $this->set('data', $data);
                // 契約期間
                $period_from = $data['OrderInfo']['period_from'];
                $period_to = $data['OrderInfo']['period_to'];
                $order_name = $data['OrderInfo']['order_name'];
            } else {
                $period_from = '';
                $period_to = '';
                $order_name = '';
                $this->set('data', null);
            }
            $this->set('period_from', $period_from);
            $this->set('period_to', $period_to);
            $this->set('order_name', $order_name);
        } else {
            $this->Session->setFlash('【エラー】エラーが発生しました。（？）');
        }
    }
    
    // 登録ページ（契約書作成、入力２）
    public function reg3_2($case_id = null, $koushin_flag = null, $order_id = null) {
        // レイアウト関係
        $this->layout = "sub";
        $this->set("title_for_layout", $this->title_for_layout);
        // オーダー一覧用
        $conditions = array('OrderInfo.case_id' => $case_id);
        $this->set('case_id', $case_id);
        $datas0 = $this->OrderInfo->find('all', array('conditions'=>$conditions));
        $this->set('datas0', $datas0);
        // その他
        $username = $this->Auth->user('username');
        $this->set('username', $username); 
        $this->set('koushin_flag', $koushin_flag);
        $this->set('order_id', $order_id);
        $selected_class = $this->Session->read('selected_class');
        $this->set('selected_class', $selected_class);
        $this->StaffMaster->setSource('staff_'.$selected_class);
        // 社員配列
        $conditions2 = array('area' => substr($selected_class, 0, 1));
        $this->User->virtualFields['name'] = 'CONCAT(name_sei, " ", name_mei)';
        $user_arr = $this->User->find('list', array('fields' => array('username', 'name'), 'conditions' => $conditions2));
        $this->set('user_arr', $user_arr);  
        // 職種マスタ配列
        $conditions0 = array('item' => 17);
        $list_shokushu = $this->Item->find('list', array('fields' => array('id', 'value'), 'conditions' => $conditions0, 'order'=>array('sequence')));
        $this->set('list_shokushu', $list_shokushu);
        // 案件配列
        $conditions3 = array('class' => $selected_class);
        $case_arr = $this->CaseManagement->find('list', array('fields' => array('id', 'case_name'), 'conditions' => $conditions3, 'order' => array('id'=>'asc')));
        $this->set('case_arr', $case_arr); 
        // 和暦配列
        $conditions4 = array('item' => 30);
        $jyear_arr = $this->Item->find('list', array('fields' => array('id', 'value'), 'conditions' => $conditions4, 'order'=>array('sequence')));
        $this->set('jyear_arr', $jyear_arr);
        // 書類配列
        $datas2= array(
            0=>'労働者派遣契約書【個別】',
            1=>'派遣先管理台帳（兼）通知書',
            2=>'派遣元管理台帳',
            3=>'労働条件通知書（兼）就業条件明示書',
            4=>'業務委託契約書',
            //5=>'その他',
            );
        $this->set('datas2', $datas2);
        // 初期化
        if (empty($data['OrderInfo']['shokushu_num'])) {
            $row = 1;
        } else {
            $row = $data['OrderInfo']['shokushu_num'];
        }
        $this->set('row', $row);
        $option = array();
        $option['fields'] = array('OrderInfo.*', 'OrderInfoDetail.*', 'OrderCalender.*'); 
        $option['order'] = array('OrderInfo.id' => 'asc');
        $option['joins'] = array(
        array(
            'type' => 'LEFT',   //LEFT, INNER, OUTER
            'table' => 'order_info_details',
            'alias' => 'OrderInfoDetail',    //下でPost.user_idと書くために
            'conditions' => 'OrderInfo.id = OrderInfoDetail.order_id'
            ),
        array(
            'type' => 'LEFT',   //LEFT, INNER, OUTER
            'table' => 'order_calenders',
            'alias' => 'OrderCalender',    //下でPost.user_idと書くために
            'conditions' => 'OrderInfo.id = OrderCalender.order_id AND OrderInfoDetail.shokushu_num = OrderCalender.shokushu_num'
            ),
        );

        // post時の処理
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->log($this->request->data, LOG_DEBUG);
            // 次へ進む
            if (isset($this->request->data['forward'])) {
                // POST情報をセッションにセット
                $data_report = $this->request->data['ReportTable'];
                $sessions = $this->Session->read('data_report');
                foreach($data_report as $key=>$value) {
                    $data_report[$key] += array(
                        'case_id' => $sessions['case_id'],
                        'order_id' => $sessions['order_id'],
                        'class' => $sessions['class'],
                        'username' => $sessions['username'],
                        'dispatch_destination' => $sessions['dispatch_destination'],
                        'contract_date' => $sessions['contract_date'],
                        'conflict_date' => $sessions['conflict_date'],
                        );
                }

                $this->Session->write('data_report2', $data_report);
                                $this->log($data_report, LOG_DEBUG);
                $this->redirect(array('action' => 'reg3_output', $case_id, $koushin_flag, $order_id));
            // 戻る
            } elseif (isset($this->request->data['previous'])) {
                $this->redirect(array('action' => 'reg3', $case_id, $koushin_flag, $order_id));
            // オーダー選択
            } else {
                if (!empty($this->request->data)) {
                    $order_id = $this->request->data['OrderInfo']['id'];
                    $this->redirect(array('action' => 'reg3', $case_id, $koushin_flag, $order_id));
                }
            } 
        } elseif ($this->request->is('get')) {
            // 登録データのセット
            $conditions1 = array('id' => $order_id, 'case_id' => $case_id);
            $data = $this->OrderInfo->find('first', array('conditions' => $conditions1));
            $this->set('data', $data);
            $conditions2 = array('class'=>$selected_class, 'order_id' => $order_id, 'flag' => 1);
            $datas2 = $this->WorkTable->find('all', array('conditions'=>$conditions2));
            $this->set('datas2', $datas2);
            // スタッフの総和
            $staff_ids = null;
            foreach ($datas2 as $data2) {
                for ($i=0; $i<31; $i++) {
                    $staff_ids[] = $data2['WorkTable']['d'.($i+1)];
                }
            }
            $staff_ids2 = array_unique($staff_ids);     // ユニークに
            $staff_ids3 = array_filter($staff_ids2, "strlen");      // 空白を除く
            asort($staff_ids3);            // ソート
            $staff_ids4 = array_merge($staff_ids3);      // キー振り直し
            $this->set('staff_ids', $staff_ids4);
            // スタッフ配列
            foreach($staff_ids4 as $id) {
                $conditions5 = array('id' => $id);
                $this->StaffMaster->virtualFields['name'] = 'CONCAT(name_sei, " ", name_mei)';
                $result = $this->StaffMaster->find('first', array('fields' => array('id', 'name', 'gender'), 'conditions' => $conditions5));
                $staff_arr[$result['StaffMaster']['id']] = $result['StaffMaster']['name'];
                $gender_arr2[$result['StaffMaster']['id']] = $result['StaffMaster']['gender'];
            }
            $staff_arr += array(''=>'（なし）');
            $this->set('staff_arr', $staff_arr);
            $this->set('gender_arr2', $gender_arr2);
            // オーダー選択コンボ用
            if (!empty($datas0)) {
                    $order_info = '自 '.$this->convGtJDate($data['OrderInfo']['period_from'])
                            .' ～ 至 '.$this->convGtJDate($data['OrderInfo']['period_to']).'   '.$data['OrderInfo']['order_name'];;
            } else {
                $order_info = '';
            }
            $this->set('order_info', $order_info);
            // 契約期間
            $period_from = $data['OrderInfo']['period_from'];
            $period_to = $data['OrderInfo']['period_to'];
            $order_name = $data['OrderInfo']['order_name'];
            $this->set('period_from', $period_from);
            $this->set('period_to', $period_to);
            $this->set('order_name', $order_name);
        } else {
            $this->Session->setFlash('【エラー】エラーが発生しました。（？）');
        }
    }
    
    // 登録ページ（契約書情報）
    public function reg3_output($case_id = null, $koushin_flag = null, $order_id = null, 
            $order_name = null, $period_from = null, $period_to = null, $file = null) {
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
            'type' => 'LEFT',   //LEFT, INNER, OUTER
            'table' => 'order_info_details',
            'alias' => 'OrderInfoDetail',    //下でPost.user_idと書くために
            'conditions' => 'OrderInfo.id = OrderInfoDetail.order_id'
            ),
        array(
            'type' => 'LEFT',   //LEFT, INNER, OUTER
            'table' => 'order_calenders',
            'alias' => 'OrderCalender',    //下でPost.user_idと書くために
            'conditions' => 'OrderInfo.id = OrderCalender.order_id AND OrderInfoDetail.shokushu_num = OrderCalender.shokushu_num'
            ),
        );
        // その他
        $username = $this->Auth->user('username');
        $this->set('username', $username); 
        $this->set('koushin_flag', $koushin_flag);
        $this->set('order_id', $order_id);
        $selected_class = $this->Session->read('selected_class');
        $this->set('selected_class', $selected_class);
        $this->StaffMaster->setSource('staff_'.$selected_class);
        $this->set('order_name', $order_name);
        $this->set('period_from', $period_from);
        $this->set('period_to', $period_to);
        $this->set('file', $file);
        // 社員配列
        $conditions2 = array('area' => substr($selected_class, 0, 1));
        $this->User->virtualFields['name'] = 'CONCAT(name_sei, " ", name_mei)';
        $user_arr = $this->User->find('list', array('fields' => array('username', 'name'), 'conditions' => $conditions2));
        $this->set('user_arr', $user_arr); 
        // 職種マスタ配列
        $conditions0 = array('item' => 17);
        $list_shokushu = $this->Item->find('list', array('fields' => array('id', 'value'), 'conditions' => $conditions0, 'order'=>array('sequence')));
        $this->set('list_shokushu', $list_shokushu);
        // 案件配列
        $conditions1 = array('class' => $selected_class);
        $case_arr = $this->CaseManagement->find('list', array('fields' => array('id', 'case_name'), 'conditions' => $conditions1, 'order' => array('id'=>'asc')));
        $this->set('case_arr', $case_arr); 
        // 和暦配列
        $conditions0 = array('item' => 30);
        $jyear_arr = $this->Item->find('list', array('fields' => array('id', 'value'), 'conditions' => $conditions0, 'order'=>array('sequence')));
        $this->set('jyear_arr', $jyear_arr);
        // 書類配列
        $datas2= array(
            0=>'労働者派遣契約書【個別】',
            1=>'派遣先管理台帳（兼）通知書',
            2=>'派遣元管理台帳',
            3=>'労働条件通知書（兼）就業条件明示書',
            4=>'業務委託契約書',
            //5=>'その他',
            );
        $this->set('datas2', $datas2);

        // post時の処理
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->log($this->request->data, LOG_DEBUG);
            
        } else {
            // 登録データのセット
            $conditions1 = array('id' => $order_id, 'case_id' => $case_id);
            $data = $this->OrderInfo->find('first', array('conditions' => $conditions1));
            $this->set('data', $data);
            $conditions2 = array('class'=>$selected_class, 'order_id' => $order_id);
            $datas2 = $this->WorkTable->find('all', array('conditions'=>$conditions2));
            $this->set('datas2', $datas2);
            // 派遣期間
            if (!empty($data)) {
                    $order_info = '自 '.$this->convGtJDate($data['OrderInfo']['period_from']).'<br>'
                            .' 至 '.$this->convGtJDate($data['OrderInfo']['period_to']);
            } else {
                $order_info = '';
            }
            $this->set('order_info', $order_info);
            // スタッフの総和
            $staff_ids = null;
            foreach ($datas2 as $data2) {
                for ($i=0; $i<31; $i++) {
                    $staff_ids[] = $data2['WorkTable']['d'.($i+1)];
                }
            }
            $staff_ids2 = array_unique($staff_ids);     // ユニークに
            $staff_ids3 = array_filter($staff_ids2, "strlen");      // 空白を除く
            asort($staff_ids3);            // ソート
            $staff_ids4 = array_merge($staff_ids3);      // キー振り直し
            $this->set('staff_ids', $staff_ids4);
            // スタッフ配列
            foreach($staff_ids4 as $id) {
                $conditions5 = array('id' => $id);
                $this->StaffMaster->virtualFields['name'] = 'CONCAT(name_sei, " ", name_mei)';
                $result = $this->StaffMaster->find('first', array('fields' => array('id', 'name', 'gender'), 'conditions' => $conditions5));
                $staff_arr[$result['StaffMaster']['id']] = $result['StaffMaster']['name'];
                $gender_arr2[$result['StaffMaster']['id']] = $result['StaffMaster']['gender'];
            }
            $staff_arr += array(''=>'（なし）');
            $this->set('staff_arr', $staff_arr);
            $this->set('gender_arr2', $gender_arr2);
            // 職種
            $conditions6 = array('case_id' => $case_id, 'order_id' => $order_id);
            $data3 = $this->OrderInfoDetail->find('first', array('conditions' => $conditions6));
            $this->set('shokushu_id', $data3['OrderInfoDetail']['shokushu_id']);
            $this->set('data3', $data3);
        }
    }
    
    // オーダー表（指定月）
    public function order($case_id = null, $yyyy = null, $mm = null, $order_id = null) {
        // レイアウト関係
        $this->layout = "sub";
        $this->set("title_for_layout", $this->title_for_layout);
        // 登録データのセット
        $koushin_flag = null;
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
        $this->set('yyyy', $yyyy);
        $this->set('mm', $mm);
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
                    $this->Session->setFlash('２．次に、職種情報を入力してください。');
                } else {
                    $this->Session->setFlash('登録時にエラーが発生しました。');
                    exit();
                }
                $this->redirect(array('action' => 'reg2', $case_id, $koushin_flag, $order_id, 'row'=>$row));
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
                $year = $yyyy;
                $month = $mm;
            }
            $this->set('row', $row);
            $this->set('year', $year);
            $this->set('month', $month);
            
            // 登録していた値をセット
            // オーダー一覧用
            $conditions = array('OrderInfo.case_id' => $case_id, 
                'OR' => array(
                    array('period_from >= ' => $yyyy.sprintf("%02d", $mm).'01', 'period_from <= ' => $yyyy.sprintf("%02d", $mm).'31'),
                    array('period_to >= ' => $yyyy.sprintf("%02d", $mm).'01', 'period_to <= ' => $yyyy.sprintf("%02d", $mm).'31'),
                    array('period_from < ' => $yyyy.sprintf("%02d", $mm).'01', 'period_to > ' => $yyyy.sprintf("%02d", $mm).'31')
                    )
                );
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
    
    // スタッフの選択（小画面）
    public function select($order_id = null, $col = null, $cell_row = null, $cell_col = null) {
        // レイアウト関係
        $this->layout = "sub";
        $this->set("title_for_layout", $this->title_for_layout);
        // 初期セット
        $username = $this->Auth->user('username').' '.$this->Auth->user('name_mei');
        $this->set('username', $username);
        $selected_class = $this->Session->read('selected_class');
        $this->set('selected_class', $selected_class);
        $this->set('datas1', null);
        $this->set('datas2', null);
        $this->set('order_id', $order_id);
        $this->set('cell_row', $cell_row);
        $this->set('cell_col', $cell_col);
        $session_id = null;
        $datas2 = null;
        $this->set('datas2', $datas2);
        //$session_name = null;
        // テーブルの設定
        $this->StaffMaster->setSource('staff_'.$selected_class);
        // スタッフ配列
        $this->StaffMaster->virtualFields['name'] = 'CONCAT(name_sei, " ", name_mei)';
        $staff_arr = $this->StaffMaster->find('list', array('fields'=>array('id', 'name')));
        $this->set('staff_arr', $staff_arr);
        // 社員配列
        $this->User->virtualFields['name'] = 'CONCAT(name_sei, " ", name_mei)';
        $user_arr = $this->User->find('list', array('fields'=>array('username', 'name'), 'conditions'=>array('FIND_IN_SET('.substr($selected_class, 0,1).'3, busho_id)')));
        $this->set('user_arr', $user_arr);
        
        // post時の処理
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->log($this->request->data, LOG_DEBUG);
            // 検索
            if (isset($this->request->data['search'])) {
                $search_name = $this->data['StaffMaster']['search_name'];
                if (!empty($search_name)) {
                    $keyword = mb_convert_kana($search_name, 's');
                    $ary_keyword = preg_split('/[\s]+/', $keyword, -1, PREG_SPLIT_NO_EMPTY);
                    // 漢字での検索
                    foreach( $ary_keyword as $val ){
                        // 検索条件を設定するコードをここに書く
                        $conditions1[] = array('CONCAT(StaffMaster.name_sei, StaffMaster.name_mei) LIKE ' => '%'.$val.'%');
                    }
                    // ひらがな（カタカナ）での検索
                    foreach( $ary_keyword as $val ){
                        // 検索条件を設定するコードをここに書く
                        $conditions2[] = array('CONCAT(StaffMaster.name_sei2, StaffMaster.name_mei2) LIKE ' => '%'.mb_convert_kana($val, "C", "UTF-8").'%');
                    }
                    $datas1 = $this->StaffMaster->find('all', array('conditions'=>array('OR'=>array($conditions1, $conditions2))));
                    //$this->log($this->StaffMaster->getDataSource()->getLog(), LOG_DEBUG);
                    $this->set('datas1', $datas1);
                }
                // セッション
                $session_id = $this->Session->read('staff_id-'.$order_id.'_'.$col);
                // 選択済みスタッフ
                if (!empty($session_id)) {
                    $this->StaffMaster->virtualFields['name'] = 'CONCAT(name_sei, " ", name_mei)';
                    foreach($session_id as $key=>$staff_id) {
                        if (strstr($staff_id, 'u')) {
                            $datas2[$key] = array('id'=>$staff_id, 'name'=>$user_arr[ltrim($staff_id, 'u')]);
                        } else {
                            $datas2[$key] = array('id'=>$staff_id, 'name'=>$staff_arr[$staff_id]);
                        }
                    }
                    $this->set('datas2', $datas2);
                }
            // 選択（スタッフ）
            } elseif (isset($this->request->data['select'])) {
                $id_array = array_keys($this->request->data['select']);
                $id = $id_array[0];
                // 選択は５つまで
                $session_id = $this->Session->read('staff_id-'.$order_id.'_'.$col);
                if (count($session_id) == 5) {
                    $this->Session->setFlash('【エラー】選択できるのは5人までです。');
                    $this->redirect(array('action' => 'select', $order_id ,$col));
                    return;
                }
                // セッション格納
                if (empty($session_id)) {
                    $session_id[0] = $id;
                } else {
                    $flag = false;
                    for($i=0; $i<count($session_id) ;$i++) {
                        if ($session_id[$i] == $id) {
                            $flag = true;
                            break;
                        }
                    }
                    if (!$flag) {
                        $session_id[] += $id;
                    }
                }
                $this->Session->write('staff_id-'.$order_id.'_'.$col, $session_id);
                $this->log($session_id, LOG_DEBUG);
                // 選択済みスタッフ
                $this->StaffMaster->virtualFields['name'] = 'CONCAT(name_sei, " ", name_mei)';
                foreach($session_id as $key=>$staff_id) {
                    if (strstr($staff_id, 'u')) {
                        $datas2[$key] = array('id'=>$staff_id, 'name'=>$user_arr[ltrim($staff_id, 'u')]);
                    } else {
                        $datas2[$key] = array('id'=>$staff_id, 'name'=>$staff_arr[$staff_id]);
                    }
                }
                $this->set('datas2', $datas2);
                //$this->log($datas2, LOG_DEBUG);
            // 選択（社員）
            } elseif (isset($this->request->data['select2'])) {
                $id = 'u'.$this->request->data['StaffMaster']['select_user'];
                $this->log($id, LOG_DEBUG);
                // 選択は５つまで
                $session_id = $this->Session->read('staff_id-'.$order_id.'_'.$col);
                if (count($session_id) == 5) {
                    $this->Session->setFlash('【エラー】選択できるのは5人までです。');
                    $this->redirect(array('action' => 'select', $order_id ,$col));
                    return;
                }
                // セッション格納
                if (empty($session_id)) {
                    $session_id[0] = $id;
                } else {
                    $flag = false;
                    for($i=0; $i<count($session_id) ;$i++) {
                        if ($session_id[$i] == $id) {
                            $flag = true;
                            break;
                        }
                    }
                    if (!$flag) {
                        $session_id[] = $id;
                    }
                }
                $this->Session->write('staff_id-'.$order_id.'_'.$col, $session_id);
                $this->log($session_id, LOG_DEBUG);
                // 選択済みスタッフ
                foreach($session_id as $key=>$staff_id) {
                    if (strstr($staff_id, 'u')) {
                        $datas2[$key] = array('id'=>$staff_id, 'name'=>$user_arr[ltrim($staff_id, 'u')]);
                    } else {
                        $datas2[$key] = array('id'=>$staff_id, 'name'=>$staff_arr[$staff_id]);
                    }
                }
                $this->set('datas2', $datas2);
                $this->log($datas2, LOG_DEBUG);
            // 決定
            } elseif (isset($this->request->data['decision'])) {
                $this->log($this->request->data, LOG_DEBUG);
                $staff_ids = $this->Session->read('staff_id-'.$order_id.'_'.$col);
                if (empty($staff_ids)) {
                    //$this->Session->setFlash('【エラー】スタッフが選択されていません。');
                    //return;
                }
                // データベースに保存
                // 登録する内容を設定
                for($i=0; $i<5 ;$i++) {
                    if (!empty($this->request->data['staff_id'.$i])) {
                        $staff_ids[$i] = $this->request->data['staff_id'.$i];
                    } else {
                        break;
                    }
                }
                $this->log($staff_ids, LOG_DEBUG);
                if (empty($staff_ids)) {
                    $values = '';
                } else {
                    $values = implode(',', $staff_ids);
                }
                $data = array('OrderInfo' => 
                    array('id' => $order_id, 'staff_ids'.($col+1) => $values));
                // 登録する項目（フィールド指定）
                $fields = array('staff_ids'.($col+1)); 
                // 更新登録
                if ($this->OrderInfo->save($data, false, $fields)) {
                    $this->log($this->OrderInfo->getDataSource()->getLog(), LOG_DEBUG);
                    // 成功
                    $this->Session->delete('staff_id-'.$order_id.'_'.$col);
                    // メッセージ
                    $this->Session->setFlash('スタッフを選択完了しました。閉じてください。');
                    $this->redirect(array('action'=>'select', $order_id, $col));
                }
            // 消去
            } elseif (isset($this->request->data['erasure'])) {
                $id_array = array_keys($this->request->data['erasure']);
                $staff_id = $id_array[0];
                $staff_ids = $this->Session->read('staff_id-'.$order_id.'_'.$col);
                $key =array_search($staff_id, $staff_ids);
                unset($staff_ids[$key]);
                $this->Session->write('staff_id-'.$order_id.'_'.$col, $staff_ids);
                // データベースに保存
                // 登録する内容を設定
                $this->log($staff_ids, LOG_DEBUG);
                if (empty($staff_ids)) {
                    $values = '';
                } else {
                    $values = implode(',', $staff_ids);
                }
                $data = array('OrderInfo' => 
                    array('id' => $order_id, 'staff_ids'.($col+1) => $values));
                // 登録する項目（フィールド指定）
                $fields = array('staff_ids'.($col+1)); 
                // 更新登録
                if ($this->OrderInfo->save($data, false, $fields)) {
                    //$this->log($this->OrderInfo->getDataSource()->getLog(), LOG_DEBUG);
                    // 成功
                    //$this->Session->delete('staff_id-'.$order_id.'_'.$col);
                    // メッセージ
                    //$this->Session->setFlash('スタッフを選択完了しました。閉じてください。');
                    $this->redirect(array('action'=>'select', $order_id, $col));
                }
            // 閉じる
            } elseif (isset($this->request->data['close'])) {
                $this->Session->delete('staff_id-'.$order_id.'_'.$col);
            } else {
                
            }
        } elseif ($this->request->is('get')) {
            // セッション
            $session_id = $this->Session->read('staff_id-'.$order_id.'_'.$col);
            $session_id = null;
            // 選択済みスタッフ
            if (!empty($session_id)) {
                foreach($session_id as $key=>$staff_id) {
                    if (strstr($staff_id, 'u')) {
                        $datas2[$key] = array('id'=>$staff_id, 'name'=>$user_arr[ltrim($staff_id, 'u')]);
                    } else {
                        $datas2[$key] = array('id'=>$staff_id, 'name'=>$staff_arr[$staff_id]);
                    }
                }
                $this->set('datas2', $datas2);
                $this->log($datas2, LOG_DEBUG);
            // セッションがない場合、GET値で
            } else {
                /**
                $staff = null;
                for ($i=0; $i<5 ;$i++) {
                    if (empty($this->request->query('s'.($i+1)))) {
                        continue;
                    }
                    $staff[$i] = $this->request->query('s'.($i+1));
                }
                 * 
                 */
                // データベースから
                $result = $this->OrderInfo->find('first', array('fields'=>array('id', 'staff_ids'.($col+1)), 'conditions'=>array('id'=>$order_id)));
                $this->log($result, LOG_DEBUG);
                if (empty($result['OrderInfo']['staff_ids'.($col+1)])) {
                    $staff = null;
                    $datas2 = null;
                } else {
                    $staff = explode(',', $result['OrderInfo']['staff_ids'.($col+1)]);
                    // セッション保存
                    $this->Session->write('staff_id-'.$order_id.'_'.$col, $staff);
                    // セッション
                    $session_id = $this->Session->read('staff_id-'.$order_id.'_'.$col);
                    foreach($session_id as $key=>$staff_id) {
                        if (strstr($staff_id, 'u')) {
                            $datas2[$key] = array('id'=>$staff_id, 'name'=>$user_arr[ltrim($staff_id, 'u')]);
                        } else {
                            $datas2[$key] = array('id'=>$staff_id, 'name'=>$staff_arr[$staff_id]);
                        }
                    }
                }
                $this->set('datas2', $datas2);
                $this->log($datas2, LOG_DEBUG);
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
                    // 漢字での検索
                    foreach( $ary_keyword as $val ){
                        // 検索条件を設定するコードをここに書く
                        $conditions1_1[] = array('Customer.corp_name LIKE ' => '%'.$val.'%');
                    }
                    // ひらがなでの検索
                    foreach( $ary_keyword as $val ){
                        // 検索条件を設定するコードをここに書く
                        $conditions1_2[] = array('Customer.corp_name_kana LIKE ' => '%'.$val.'%');
                    }
                    $conditions2 += array('OR'=>array($conditions1_1, $conditions1_2));
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
            //$this->log($this->CaseManagement->getDataSource()->getLog(), LOG_DEBUG);
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
        // 解除フラグ
        if (empty($flag)) {
            $flag = 0;
        }
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
                $conditions = array('class'=>$selected_class, 'kaijo_flag'=>$flag, 'corp_name LIKE '=> '%'.trim($this->request->data['Customer']['corp_name'], '株式会社').'%');
                $count = $this->Customer->find('count', array('conditions' => $conditions));
                if (empty($this->request->data['Customer']['id']) && $count > 0) {
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
    
    // 取引先追加ページ
    public function client($case_id = null, $koushin_flag = null) {
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
                    $this->Session->setFlash('【情報】登録しました。');
                    $this->redirect(array('action'=>'./reg1/'.$case_id.'/'.$koushin_flag));

                } else {
                    $this->Session->setFlash('【エラー】登録時にエラーが発生しました。');
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
                    $this->Session->setFlash('【エラー】事業主が既に存在します。');
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
                $this->redirect(array('action'=>'reg1', 0, 0));
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
                $sql = $sql.' WHERE item = 17 AND id = '.$id;
                $this->log($this->Item->query($sql));
                // 追加
                $sql = "";
                $sql = $sql." INSERT INTO item (item, id, value, sequence, created)";
                $sql = $sql." VALUES (17, ".$id.", '".$value."', ".$sequence.", now())";
                $this->log($this->Item->query($sql));
                $this->redirect('shokushu');
                $this->Session->setFlash('ID='.$id.', 値='.$value.'を追加しました。');
            } elseif (isset($this->request->data['delete'])) {
                $id_array = array_keys($this->request->data['delete']);
                $id = $id_array[0];
                $sql = '';
                $sql = $sql.' DELETE FROM item';
                $sql = $sql.' WHERE item = 17 AND id = '.$id;
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
                    $sql1 = $sql1.' WHERE item = 17 AND sequence = '.($_sequence-1).';';
                    $sql2 = '';
                    $sql2 = $sql2.' UPDATE item SET sequence = '.($_sequence-1);
                    $sql2 = $sql2.' WHERE item = 17 AND id = '.$_id.' AND sequence = '.$_sequence.';'; 
                } elseif ($direction == 'down') {
                    $sql1 = '';
                    $sql1 = $sql1.' UPDATE item SET sequence = '.$_sequence;
                    $sql1 = $sql1.' WHERE item = 17 AND sequence = '.($_sequence+1).';';
                    $sql2 = '';
                    $sql2 = $sql2.' UPDATE item SET sequence = '.($_sequence+1);
                    $sql2 = $sql2.' WHERE item = 17 AND id = '.$_id.' AND sequence = '.$_sequence.';'; 
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
    
    //JQueryのコントロールを使ったりして2000-12-23等の形式の文字列が渡すように限定するかんじ
    public function convGtJDate($src) {
        list($year, $month, $day) = explode("-", $src);
        if (!@checkdate($month, $day, $year) || $year < 1869 || strlen($year) !== 4
                || strlen($month) !== 2 || strlen($day) !== 2) return false;
        $date = str_replace("-", "", $src);
        $gengo = "";
        $wayear = 0;
        if ($date >= 19890108) {
            $gengo = "平成";
            $wayear = $year - 1988;
        } elseif ($date >= 19261225) {
            $gengo = "昭和";
            $wayear = $year - 1925;
        } elseif ($date >= 19120730) {
            $gengo = "大正";
            $wayear = $year - 1911;
        } else {
            $gengo = "明治";
            $wayear = $year - 1868;
        }
        switch ($wayear) {
            case 1:
                $wadate = $gengo."元年".$month."月".$day."日";
                break;
            default:
                $wadate = $gengo.sprintf("%02d", $wayear)."年".$month."月".$day."日";
        }
        return $wadate;
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
