<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

/**
 * CakePHP ShiftManagementController
 * @author M-YOKOI
 */
class ShiftManagementController extends AppController {
    public $uses = array('StaffSchedule' ,'WorkTable' ,'Item', 'User', 
        'StaffMaster', 'CaseManagement', 'OrderInfo', 'OrderInfoDetail', 'OrderCalender', 'Customer', 'WkShift');
    public $title_for_layout = "シフト管理 - 派遣管理システム";
    
    public function index($date = null) {
        // レイアウト関係
        $this->layout = "main";
        $this->set("title_for_layout", $this->title_for_layout);
        // タブの状態
        $this->set('active1', '');
        $this->set('active2', '');
        $this->set('active3', '');
        $this->set('active4', '');
        $this->set('active5', 'active');
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
        //$this->CaseManagement->setSource('CaseManagement');
        // 引数の受け取り
        if (isset($this->params['named']['limit'])) {
            $limit = $this->params['named']['limit'];
        } else {
            $limit = '10';
        }
        // 月の取得
        if (isset($this->request->query['date'])) {
            $month = str_replace('-', '', $this->request->query['date']);
        } elseif (isset ($date)) {
            $month = str_replace('-', '', $date);
        } else {
            $month = date('Ym');
        }
        $this->set('month', $month);
        //$this->log($month, LOG_DEBUG);
        // 職種マスタ配列
        $conditions0 = array('item' => 17);
        $list_shokushu = $this->Item->find('list', array('fields' => array('id', 'value'), 'conditions' => $conditions0));
        $this->set('list_shokushu', $list_shokushu);
        // 表示件数の初期値
        $this->set('limit', $limit);
        
        // スタッフの抽出条件
        $joins = array(
            array(
                'type' => 'left',// innerもしくはleft
                'table' => 'staff_'.$selected_class,
                'alias' => 'StaffMaster',
                'conditions' => array(
                    'StaffSchedule.staff_id = StaffMaster.id',
                )    
            )
        );
        $options = array(
            'fields'=> array('StaffSchedule.staff_id', 'StaffMaster.name_sei', 'StaffMaster.name_mei', 'StaffMaster.shokushu_shoukai'),
            'conditions' => array(
                'StaffSchedule.class' => $selected_class,
                'StaffSchedule.work_date >=' => $month.'01',
                'StaffSchedule.work_date <= ' => $month.'31',
                ),
            'limit' => $limit,
            'group' => array('staff_id'),
            'joins' => $joins
        );

        // POSTの場合
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->log($this->request->data, LOG_DEBUG);
            $conditions2 = null;
            if (isset($this->data['search'])) {
                // 氏名での検索
                if (!empty($this->data['StaffSchedule']['search_name'])){
                    $search_name = $this->data['StaffSchedule']['search_name'];
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
                    $options['conditions'] += array('OR'=>array($conditions1, $conditions2));
                }
            // 職種
            } elseif (!empty($this->data['StaffSchedule']['search_shokushu'])){
                $search_shokushu = $this->data['StaffSchedule']['search_shokushu'];
                $options['conditions'] += array('FIND_IN_SET('.$search_shokushu.', shokushu_id)');
            // 所属の変更
            } elseif (isset($this->request->data['class'])) {
                $this->selected_class = $this->request->data['class'];
                //$this->Session->setFlash($class);
                $this->set('selected_class', $this->selected_class);
                $this->Session->write('selected_class', $this->selected_class);
                // テーブル変更
                $this->StaffMaster->setSource('staff_'.$this->Session->read('selected_class'));
                $this->redirect(array('page' => 1, $month));  
            // 表示件数の変更
            } elseif (isset($this->request->data['limit'])) {
                $limit = $this->request->data['limit'];
                $this->set('limit', $limit);
                $this->redirect(array('limit' => $limit, $month));
            }
            // ページネーションの実行
            //$this->request->params['named']['page'] = 1;
            $this->paginate = $options;
            $datas1 = $this->paginate('StaffSchedule');
            $this->log($this->StaffSchedule->getDataSource()->getLog(), LOG_DEBUG);
            $this->set('datas1', $datas1);
        } else {
            // スタッフの抽出実行
            $this->paginate = $options;
            $datas1 = $this->paginate('StaffSchedule');
            //$this->log($this->StaffSchedule->getDataSource()->getLog(), LOG_DEBUG);
            $this->set('datas1', $datas1);
        }
        
        // スタッフあたりのスケジュール
        if (!empty($datas1)) {
            foreach($datas1 as $key => $val) {
                $data[$key] = $this->StaffSchedule->find('all',
                    array(
                    'fields' => array('StaffSchedule.*'),
                    //データを降順に並べる
                    'order' => array('StaffSchedule.id' => 'asc', 'StaffSchedule.staff_id' => 'asc'),
                    'conditions' => array(
                        'staff_id' => $val['StaffSchedule']['staff_id'],
                        'StaffSchedule.class' => $selected_class,
                        'StaffSchedule.work_date >= ' => $month.'01',
                        'StaffSchedule.work_date <= ' => $month.'31',
                        )
                    )
                );
            }
            //$this->log($this->StaffSchedule->getDataSource()->getLog(), LOG_DEBUG);
            $this->set('datas2', $data);
        } else {
            $this->set('datas2', null);
        }
    }

    /**
     * 稼働表作成
     */
    public function schedule() {
        // レイアウト関係
        $this->layout = "main";
        $this->set("title_for_layout", $this->title_for_layout);
        // タブの状態
        $this->set('active1', '');
        $this->set('active2', '');
        $this->set('active3', '');
        $this->set('active4', '');
        $this->set('active5', 'active');
        $this->set('active6', '');
        $this->set('active7', '');
        $this->set('active8', '');
        $this->set('active9', '');
        $this->set('active10', '');
        // 絞り込みセッションを消去
        $this->Session->delete('filter');
        // 職種マスタ配列
        $conditions0 = array('item' => 17);
        $list_shokushu = $this->Item->find('list', array('fields' => array('id', 'value'), 'conditions' => $conditions0));
        $this->set('list_shokushu', $list_shokushu);
        // その他
        $username = $this->Auth->user('username');
        $this->set('username', $username); 
        $user_name = $this->Auth->user('name_sei').' '.$this->Auth->user('name_mei');
        $this->set('user_name', $user_name); 
        $selected_class = $this->Session->read('selected_class');
        $this->set('selected_class', $selected_class);
        // テーブルの設定
        $this->StaffMaster->setSource('staff_'.$selected_class);
        $this->WorkTable->setSource('work_tables');
        // 初期化
        $staff_ids2 = null;
        $staff_ids3 = null;
        $staff_ids = null;
        $data_staffs = null;
        $this->set('row', null);
        $this->set('datas', null);
        $data2 = null;
        $list_recommend = null;
        // 案件名の取得
        $conditions1 = array('class'=>$selected_class);
        $getCasename = $this->CaseManagement->find('list', array('fields'=>array('id', 'case_name'), 'conditions' => $conditions1));
        $this->set('getCasename', $getCasename);
        //$this->log($getCasename, LOG_DEBUG);
        // 取引先の取得
        $list_customer = $this->Customer->find('list', array('fields'=>array('id', 'corp_name'), 'conditions' => $conditions1));
        $this->set('list_customer', $list_customer);
        //$this->log($list_customer, LOG_DEBUG);
        // 事業主の取得
        $result1 = $this->CaseManagement->find('all', array('conditions' => $conditions1));
        //$this->log($result1, LOG_DEBUG);
        $datas1 = null;
        foreach ($result1 as $key=>$value) {
            for ($i=0; $i<10; $i++) {
                //$this->log($value['CaseManagement']['entrepreneur2'], LOG_DEBUG);
                if ($i == 0) {
                    if (empty($value['CaseManagement']['entrepreneur1'])) {
                        $datas1[$value['CaseManagement']['id']] = '';
                        break;
                    }
                    $datas1[$value['CaseManagement']['id']] = $list_customer[$value['CaseManagement']['entrepreneur1']];
                } else {
                    if (empty($value['CaseManagement']['entrepreneur'.($i+1)])) {
                        break;
                    }
                    $datas1[$value['CaseManagement']['id']] .= '/'.$list_customer[$value['CaseManagement']['entrepreneur'.($i+1)]];
                }
            }
        }
        //$this->log($datas1, LOG_DEBUG);
        $this->set('list_entrepreneur', $datas1);
        // 依頼主
        $result1 = $this->CaseManagement->find('all', array(
            'fields'=>array('id', 'client'), 'conditions' => $conditions1));
        //$this->log($result1, LOG_DEBUG);
        $datas2 = null;
        foreach ($result1 as $value) {
            if (empty($value['CaseManagement']['client'])) {
                $datas2[$value['CaseManagement']['id']] = '';
                continue;
            }
            $datas2[$value['CaseManagement']['id']] = $list_customer[$value['CaseManagement']['client']];
        }
        $this->set('list_client', $datas2);
        //$this->log($datas2, LOG_DEBUG);
        // 指揮命令者・担当者
        $conditions2 = array('class'=>$selected_class);
        $this->CaseManagement->virtualFields['director2'] = 'CONCAT(position, "：", director)';
        $list_director = $this->CaseManagement->find('list', array('fields' => array('id', 'director2'), 'conditions' => $conditions2));
        $this->set('list_director', $list_director);
        // 住所
        $list_address = $this->CaseManagement->find('list', array('fields' => array('id', 'address'), 'conditions' => $conditions2));
        $this->set('list_address', $list_address);
        // TEL
        $list_telno = $this->CaseManagement->find('list', array('fields' => array('id', 'telno'), 'conditions' => $conditions2));
        $this->set('list_telno', $list_telno);
        // FAX
        $list_faxno = $this->CaseManagement->find('list', array('fields' => array('id', 'faxno'), 'conditions' => $conditions2));
        $this->set('list_faxno', $list_faxno);
        // 請求先担当者
        $this->CaseManagement->virtualFields['tantou2'] = 'CONCAT(Customer.corp_name, "<br>", Customer.tantou)';
        $option = array();
        $option['fields'] = array('CaseManagement.id', 'tantou2'); 
        //$option['order'] = array('OrderInfoDetail.case_id' => 'asc', 'OrderInfoDetail.order_id' => 'asc', 'OrderInfoDetail.shokushu_num' => 'asc');
        $option['conditions'] = array('CaseManagement.class'=>$selected_class); 
        $option['joins'] = array(
        array(
            'type' => 'LEFT',   //LEFT, INNER, OUTER
            'table' => 'customer',
            'alias' => 'Customer',    //下でPost.user_idと書くために
            'conditions' => array('CaseManagement.billing_destination1 = Customer.id')
            ),
        ); 
        $datas = $this->CaseManagement->find('list', $option);
        //$this->log($datas, LOG_DEBUG);
        $this->set('list_bill', $datas);
        // 請求書締日
        $option = array();
        $option['fields'] = array('CaseManagement.id', 'Customer.bill_cutoff'); 
        //$option['order'] = array('OrderInfoDetail.case_id' => 'asc', 'OrderInfoDetail.order_id' => 'asc', 'OrderInfoDetail.shokushu_num' => 'asc');
        $option['conditions'] = array('CaseManagement.class'=>$selected_class); 
        $option['joins'] = array(
        array(
            'type' => 'LEFT',   //LEFT, INNER, OUTER
            'table' => 'customer',
            'alias' => 'Customer',    //下でPost.user_idと書くために
            'conditions' => array('CaseManagement.billing_destination1 = Customer.id')
            ),
        ); 
        $list_cutoff = $this->CaseManagement->find('list', $option);
        //$this->log($datas, LOG_DEBUG);
        $this->set('list_cutoff', $list_cutoff);
        // 推奨スタッフ
        for ($i=1; $i<=20; $i++) {
            $results = $this->OrderInfo->find('all', array('fields'=>array('id', 'staff_ids'.$i)));
            
            //$this->log($results, LOG_DEBUG);
            foreach ($results as $result) {
                $list_staffs[$result['OrderInfo']['id']][$i] = explode(',', $result['OrderInfo']['staff_ids'.$i]);
                foreach($list_staffs[$result['OrderInfo']['id']][$i] as $j=>$staff_id) {
                    $this->StaffMaster->virtualFields['name'] = 'CONCAT(name_sei, " ", name_mei)';
                    $list_staffs2[$result['OrderInfo']['id']][$i][$j] = $this->StaffMaster->find('first', array('fields'=>array('id', 'name'), 'conditions'=>array('id'=>$staff_id)));
                }
            }
        }
        //$this->log($list_staffs, LOG_DEBUG);
        //$this->log($list_staffs2, LOG_DEBUG);
        $this->set('list_staffs', $list_staffs);        // 推奨スタッフ（氏名）
        $this->set('list_staffs2', $list_staffs2);      // 推奨スタッフ（ID）
        
        // post時の処理
        if ($this->request->is('post') || $this->request->is('put')) {
            //$this->log($this->request->data, LOG_DEBUG);
            $data = $this->request->data;
            if (isset($data['mode'])) {
                $row = $data['row'];
                for ($i=1; $i<=$row; $i++) {
                    for ($d=1; $d<=31; $d++) {
                        if (empty($data[$d.'_'.$i])) {
                            continue;
                        }
                        $data2[$i]['column'] = $i;
                        $data2[$i]['class'] = $selected_class;
                        $data2[$i]['username'] = $username;
                        $data2[$i]['month'] = $data['month'];
                        $data2[$i]['d'.$d] = $data[$d.'_'.$i];
                        $data2[$i]['case_id'] = $data['WorkTable'][$i]['case_id'];
                        $data2[$i]['order_id'] = $data['WorkTable'][$i]['order_id'];
                        $data2[$i]['shokushu_num'] = $data['WorkTable'][$i]['shokushu_num'];
                    }
                }
                // データがなければ処理停止
                if (empty($data2)) {
                    $this->redirect(array('action'=>'schedule', '?date='.date('Y-m', strtotime($data['month']))));
                    return;
                }
                // 該当月を削除
                $param = array('class' => $selected_class, 'month' => $data['month']);
                if ($this->WorkTable->deleteAll($param)) {
                    // データを登録する
                    if ($this->WorkTable->saveAll($data2)) {
                        $this->Session->setFlash('保存を完了しました。');
                        // セッション削除
                        $this->Session->delete('staff_cell');
                        // シフト編集モード
                        //$this->Session->write('edit', $data['edit']);
                        //$this->set('edit', $data['edit']);
                        //$this->log('$edit='.$data['edit']);
                        $this->redirect(array('action'=>'schedule', '?date='.date('Y-m', strtotime($data['month']))));
                    } else {

                    }
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
            } else {

            }
        } elseif ($this->request->is('get')) {
            if (!empty($this->request->query('date'))) {
                $date = $this->request->query('date');
                //$this->log($date, LOG_DEBUG);
                $date_arr = explode('-',$date);
                $year = $date_arr[0];
                $month = $date_arr[1];
            } else {
                $year = date('Y', strtotime('+1 month'));
                $month = date('n', strtotime('+1 month'));
            }
            $month = ltrim($month, '0');
            $this->set('year', $year);
            $this->set('month', ltrim($month, '0'));
            
            // 登録していた値をセット
            // 登録データのセット
            //$conditions1 = array('id' => $order_id, 'case_id' => $case_id);
            $conditions1 = array('class'=>$selected_class, 'OrderCalender.year' => $year, 'OrderCalender.month' => $month);
            $row = $this->OrderCalender->find('count', array('conditions' => $conditions1));
            $this->set('row', $row);
            // 案件あたりの職種数
            $conditions1 = array('class'=>$selected_class, 'OrderCalender.year' => $year, 'OrderCalender.month' => $month);
            $datas = $this->OrderCalender->find('all', array('fields'=>array('case_id', 'count(case_id) as cnt'), 
                'conditions' => $conditions1, 'group' => array('case_id'), 'order' => array('case_id', 'order_id')));
            $this->set('datas', $datas);
            //$this->log($datas, LOG_DEBUG);
            // 職種以下
            $option = array();
            $option['fields'] = array('OrderInfoDetail.*', 'OrderCalender.*'); 
            $option['order'] = array('OrderInfoDetail.case_id' => 'asc', 'OrderInfoDetail.order_id' => 'asc', 'OrderInfoDetail.shokushu_num' => 'asc');
            $option['conditions'] = array('OrderInfoDetail.class'=>$selected_class, 'OrderCalender.year' => $year, 'OrderCalender.month' => $month); 
            $option['joins'] = array(
            array(
                'type' => 'RIGHT',   //LEFT, INNER, OUTER
                'table' => 'order_calenders',
                'alias' => 'OrderCalender',    //下でPost.user_idと書くために
                'conditions' => array('OrderInfoDetail.order_id = OrderCalender.order_id AND OrderInfoDetail.shokushu_num = OrderCalender.shokushu_num')
                ),
            );
            // オーダー入力欄以下
            $datas2 = $this->OrderInfoDetail->find('all', $option);
            $this->set('datas2', $datas2);
            $data_wk = null;
            
            // 前月のスタッフ
            $m = date('Y-m-d', strtotime('-1 month', strtotime($year.'-'.$month.'-01')));
            //$this->log($m, LOG_DEBUG);
            $datas3 = null;$datas4 = null;
            foreach($datas2 as $key=>$data) {
                $conditions2 = array('class'=>$selected_class, 'order_id'=>$data['OrderInfoDetail']['order_id'], 
                    'shokushu_num'=>$data['OrderInfoDetail']['shokushu_num'], 'month' => $m);
                for($i=1; $i<=31; $i++) {
                    $results = $this->WorkTable->find('first', array('fields'=>array('d'.$i), 
                        'conditions' => $conditions2, 'order' => array('case_id', 'order_id', 'shokushu_num')));
                    if (empty($results)) {
                        $datas3[$key] = null;
                        continue;
                    }
                    $datas3[$key][$i-1] = $results['WorkTable']['d'.$i];
                }
                // 推奨スタッフ
                foreach ($list_staffs2[$data['OrderInfoDetail']['order_id']][$data['OrderInfoDetail']['shokushu_num']] as $key2=>$value) {
                    if ($key2 == 0) {
                        $ret[$key] = $value['StaffMaster']['id'];
                    } else {
                        $ret[$key] = $ret[$key].','.$value['StaffMaster']['id'];
                    }
                }
                if (empty($datas3[$key])) {
                    $list_recommend[$key] = null;
                    // ワークテーブル配列
                    $data_wk[$key] = array('WkShift' => array('month' => $year.'-'.$month.'-01', 'order_id' => $data['OrderInfoDetail']['order_id'], 
                        'shokushu_num' => $data['OrderInfoDetail']['shokushu_num'], 'column' => $key+1, 'shokushu_id' => $data['OrderInfoDetail']['shokushu_id'], 
                        'pre_month' =>  '', 
                        'recommend_staff' => $ret[$key], 'class' => $selected_class));
                } else {
                    $datas3[$key] = array_filter($datas3[$key], 'strlen');      // 空を削除
                    $datas3[$key] = array_unique($datas3[$key]);                // 重複を削除

                    // ワークテーブル配列
                    $data_wk[$key] = array('WkShift' => array('month' => $year.'-'.$month.'-01', 'order_id' => $data['OrderInfoDetail']['order_id'], 
                        'shokushu_num' => $data['OrderInfoDetail']['shokushu_num'], 'column' => $key+1, 'shokushu_id' => $data['OrderInfoDetail']['shokushu_id'], 
                        'pre_month' =>  implode(',', $datas3[$key]),
                        'recommend_staff' => $ret[$key], 'class' => $selected_class));
                    // 氏名に変換
                    foreach ($datas3[$key] as $j=>$value) {
                        $condition = array('id'=>$value);
                        $this->StaffMaster->virtualFields['name'] = 'CONCAT(name_sei, " ", name_mei)';
                        $list_recommend[$key][$j] = $this->StaffMaster->find('first', array('fields'=>array('id', 'name'), 'conditions'=>$condition));
                    }
                }
            }
            $this->set('list_recommend', $list_recommend);
            
            if (!empty($data_wk)) {
                // 既存ワークデータ削除（該当月）
                $conditions5 = array('class' => $selected_class, 'month' => $year.'-'.$month.'-01');
                $this->WkShift->deleteAll($conditions5, false);
                // ワークテーブルに書き込み
                //$fields = array('column', 'shokushu_id', 'recommend_staff', 'pre_month');
                $this->WkShift->saveAll($data_wk);
            }
            // 総列数
            $record = $this->OrderInfoDetail->find('count', $option);
            $this->set('record', $record);

            /**
             *  シフト希望スタッフのポイント
             */
            $conditions6 = array(
                'StaffSchedule.class'=>$selected_class, 
                'work_date >= '=>$year.'-'.$month.'-01',
                'work_date <= '=>$year.'-'.$month.'-31',
                'OR'=>array(array('work_flag'=>1), array('work_flag'=>2))
                );
            $request_staffs = $this->StaffSchedule->find('all', array('conditions'=>$conditions6, 'order'=>array('staff_id')));
            
            $conditions7 = array(
                'class'=>$selected_class, 
                'month'=>$year.'-'.$month.'-01',
                );
            $datas5 = $this->WkShift->find('all', array('conditions'=>$conditions7));
            //$this->log($datas5, LOG_DEBUG);
            
            foreach($request_staffs as $key=>$data) {
                $id = $data['StaffSchedule']['id'];
                $staff_id = $data['StaffSchedule']['staff_id'];
                $point = null;
                foreach($datas5 as $col=>$data5) {
                    $point[$col] = 0;
                    // 推奨スタッフに一致する場合、ポイント＋２
                    if (!empty($data5['WkShift']['recommend_staff'])) {
                        $recommends = explode(',', $data5['WkShift']['recommend_staff']);
                        //$this->log($recommends, LOG_DEBUG);
                        if (in_array($staff_id, $recommends)) {
                            $point[$col] = 2;
                        }
                    }
                    // 前月スタッフに一致する場合、ポイント＋１
                    if (!empty($data5['WkShift']['pre_month'])) {
                        $pre_month = explode(',', $data5['WkShift']['pre_month']);
                        if (in_array($staff_id, $pre_month)) {
                            $point[$col] = $point[$col] + 1;
                        } 
                    }
                }
                //$this->log($point, LOG_DEBUG);
                // ポイントの更新
                $point = implode(',', $point);
                //$this->log($point, LOG_DEBUG);
                $data = array('point'=>$point);
                $this->StaffSchedule->id = $id;
                $this->StaffSchedule->save($data);
            }
            // スタッフのスケジュールデータ
            $joins = array(
            array(
                'type' => 'LEFT',   //LEFT, INNER, OUTER
                'table' => 'staff_'.$selected_class,
                'alias' => 'StaffMaster',    //下でPost.user_idと書くために
                'conditions' => array('StaffSchedule.staff_id = StaffMaster.id')
                ),
            );
            $request_staffs2 = $this->StaffSchedule->find('all', array('fields'=>array('StaffSchedule.*', 'StaffMaster.name_sei', 'StaffMaster.name_mei'), 'conditions'=>$conditions6, 'joins'=>$joins, 'order'=>array('staff_id')));
            $this->log($request_staffs2, LOG_DEBUG);
            $this->set('request_staffs', $request_staffs2 );

            // セッション保存データ
            // セッション削除
            //$this->Session->delete('staff_cell');
            // スタッフIDをカンマ区切りにする
            $staff_cell = $this->Session->read('staff_cell');
            //$this->log($staff_cell, LOG_DEBUG);
            $staff_cell2 = null;
            if (!empty($staff_cell) && $staff_cell[0][0] == $year.'-'.$month) {
                for($i=1; $i<=31; $i++) {
                    for($j=1; $j<=200; $j++) {
                        if (empty($staff_cell[$j][$i])) {
                            continue;
                        }
                        $staff_cell2[$j][$i] = implode(',', $staff_cell[$j][$i]);
                    }
                }
                //$this->log($staff_cell2, LOG_DEBUG);
                $this->set('staff_cell', $staff_cell2);
            } else {
                for($i=1; $i<=200; $i++) {
                    $conditions1 = array('class'=>$selected_class, 'month'=>$year.'-'.$month.'-01', 'column'=>$i);
                    $results= $this->WorkTable->find('first', array('conditions'=>$conditions1));
                    //$this->log($results, LOG_DEBUG);
                    if (empty($results)) {
                        continue;
                    }
                    for($d=1; $d<=31; $d++) {
                        $staff_ids[$d][$i] = $results['WorkTable']['d'.$d];
                        if (!empty($results['WorkTable']['d'.$d])) {
                            $staff_ids2[$d][$i] = explode(',', $results['WorkTable']['d'.$d]);
                            $staff_ids3[$d][$i] = $results['WorkTable']['d'.$d];
                        }
                    }
                }

                $this->set('staff_ids', $staff_ids);
                $staff_cell = $staff_ids2;
                $staff_cell[0][0] = $year.'-'.$month;     // 該当月セット
                $this->Session->write('staff_cell', $staff_cell);
                $this->set('staff_cell', $staff_ids3);
                //$this->log($this->Session->read('staff_cell'), LOG_DEBUG);
            }
            
            // 氏名のセット
            if (empty($staff_cell)) {
                $this->set('data_staffs', null);
            } else {
                for($row=1; $row<=31; $row++) {
                    for($col=1; $col<200; $col++) {
                        if (empty($staff_cell[$row][$col])) {
                            continue;
                        }
                        foreach ($staff_cell[$row][$col] as $key=>$staff_id) {
                            $conditions1 = array('id'=>$staff_id);
                            $data_staffs[$row][$col][$key] = $this->StaffMaster->find('first', array('fields'=>array('id', 'name_sei', 'name_mei'), 'conditions'=>$conditions1));
                        }
                    }
                }
                $this->set('data_staffs', $data_staffs);
                //$this->log($data_staffs, LOG_DEBUG);
                // セッション削除
                //$this->Session->delete('staff_cell');
            }
        } else {
            // DBの保存データ
            // 指定月の取得
            if (!empty($this->request->query('date'))) {
                $date = $this->request->query('date');
                //$this->log($date, LOG_DEBUG);
                $date_arr = explode('-',$date);
                $year = $date_arr[0];
                $month = $date_arr[1];
            } else {
                $year = date('Y', strtotime('+1 month'));
                $month = date('n', strtotime('+1 month'));
            }
            $month = ltrim($month, '0');
            $this->set('year', $year);
            $this->set('month', ltrim($month, '0'));
            
            // セッション削除
            //$this->Session->delete('staff_cell');
            // スタッフIDをカンマ区切りにする
            $staff_cell = $this->Session->read('staff_cell');
            //$this->log($staff_cell, LOG_DEBUG);
            $staff_cell2 = null;
            if (!empty($staff_cell) && $staff_cell[0][0] == $month) {
                for($i=1; $i<=31; $i++) {
                    for($j=1; $j<=200; $j++) {
                        if (empty($staff_cell[$j][$i])) {
                            continue;
                        }
                        $staff_cell2[$j][$i] = implode(',', $staff_cell[$j][$i]);
                    }
                }
                //$this->log($staff_cell2, LOG_DEBUG);
                $this->set('staff_cell', $staff_cell2);
            } else {
                for($i=1; $i<=200; $i++) {
                    $conditions1 = array('class'=>$selected_class, 'month'=>$month.'-01', 'column'=>$i);
                    $results= $this->WorkTable->find('first', array('conditions'=>$conditions1));
                    //$this->log($results, LOG_DEBUG);
                    if (empty($results)) {
                        continue;
                    }
                    for($d=1; $d<=31; $d++) {
                        $staff_ids[$d][$i] = $results['WorkTable']['d'.$d];
                        if (!empty($results['WorkTable']['d'.$d])) {
                            $staff_ids2[$d][$i] = explode(',', $results['WorkTable']['d'.$d]);
                            $staff_ids3[$d][$i] = $results['WorkTable']['d'.$d];
                        }
                    }
                }

                $this->set('staff_ids', $staff_ids);
                $staff_cell = $staff_ids2;
                $staff_cell[0][0] = $month;     // 該当月セット
                $this->Session->write('staff_cell', $staff_cell);
                $this->set('staff_cell', $staff_ids3);
                //$this->log($this->Session->read('staff_cell'), LOG_DEBUG);
            }
            
            // データ
            if (empty($staff_cell)) {
                $this->set('data_staffs', null);
            } else {
                for($row=1; $row<=31; $row++) {
                    for($col=1; $col<200; $col++) {
                        if (empty($staff_cell[$row][$col])) {
                            continue;
                        }
                        foreach ($staff_cell[$row][$col] as $key=>$staff_id) {
                            $conditions1 = array('id'=>$staff_id);
                            $data_staffs[$row][$col][$key] = $this->StaffMaster->find('first', array('fields'=>array('id', 'name_sei', 'name_mei'), 'conditions'=>$conditions1));
                        }
                    }
                }
                $this->set('data_staffs', $data_staffs);
                //$this->log($data_staffs, LOG_DEBUG);
                // セッション削除
                //$this->Session->delete('staff_cell');
            }
        }
    }
    
    
    /**
     * 売上給与一覧ページ
     */
    public function uri9() {
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
        $this->set('active4', '');
        $this->set('active5', 'active');
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
        // データ
        $this->set('datas', $this->paginate('CaseManagement'));
        
        
    }
    
    /**
     * 稼働表技術検証
     */
    public function test($date = null) {
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
        $this->set('active4', '');
        $this->set('active5', 'active');
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
        $username = $this->Auth->user('username');
        $this->set('username', $username);
        $selected_class = $this->Session->read('selected_class');
        $this->set('selected_class', $selected_class);
        $data_staffs = null;
        // テーブルの設定
        $this->StaffMaster->setSource('staff_'.$selected_class);
        $this->WorkTable->setSource('work_tables');
        // 初期化
        $staff_ids2 = null;
        $staff_ids3 = null;
        $staff_ids = null;

        // post時の処理
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->log($this->request->data, LOG_DEBUG);
            $data = $this->request->data;
            for ($i=1; $i<200; $i++) {
                for ($d=1; $d<=31; $d++) {
                    if (empty($data[$d.'_'.$i])) {
                        continue;
                    }
                    $data2[$i]['column'] = $i;
                    $data2[$i]['class'] = $selected_class;
                    $data2[$i]['username'] = $username;
                    $data2[$i]['month'] = $data['month'];
                    $data2[$i]['d'.$d] = $data[$d.'_'.$i];
                }
            }
            //$this->log($data2, LOG_DEBUG);
            //$this->log($data['month'], LOG_DEBUG);
            /**
            for ($i=1; $i<200; $i++) {
                for ($d=1; $d<=31; $d++) {
                    if (empty($this->request->data['WorkTable'][$i]['d'.$d])) {
                        continue;
                    }
                    $this->request->data['WorkTable'][$i]['d'.$d] = implode(',', $this->request->data['WorkTable'][$i]['d'.$d]);
                }
            }
             * 
             */
            // 該当月を削除
            $param = array('class' => $selected_class, 'month' => $data['month']);
            if ($this->WorkTable->deleteAll($param)) {
                // データを登録する
                if ($this->WorkTable->saveAll($data2)) {
                    $this->Session->setFlash('保存を完了しました。');
                    // セッション削除
                    $this->Session->delete('staff_cell');
                    $this->redirect(array('action'=>'test', '?date='.date('Y-m', strtotime($data['month']))));
                } else {

                }
            }

        } else {
            // DBの保存データ
            // 指定月の取得
            if (isset($this->request->query['date'])) {
                $month = $this->request->query['date'];
            } else {
                $month = date('Y-m');
            }
            $this->set('month', $month);
            //$this->log($month, LOG_DEBUG);
            
            // セッション削除
            //$this->Session->delete('staff_cell');
            // スタッフIDをカンマ区切りにする
            $staff_cell = $this->Session->read('staff_cell');
            $this->log($staff_cell, LOG_DEBUG);
            $staff_cell2 = null;
            if (!empty($staff_cell) && $staff_cell[0][0] == $month) {
                for($i=1; $i<=31; $i++) {
                    for($j=1; $j<=200; $j++) {
                        if (empty($staff_cell[$j][$i])) {
                            continue;
                        }
                        $staff_cell2[$j][$i] = implode(',', $staff_cell[$j][$i]);
                    }
                }
                //$this->log($staff_cell2, LOG_DEBUG);
                $this->set('staff_cell', $staff_cell2);
            } else {
                for($i=1; $i<=200; $i++) {
                    $conditions1 = array('class'=>$selected_class, 'month'=>$month.'-01', 'column'=>$i);
                    $results= $this->WorkTable->find('first', array('conditions'=>$conditions1));
                    //$this->log($results, LOG_DEBUG);
                    if (empty($results)) {
                        continue;
                    }
                    for($d=1; $d<=31; $d++) {
                        $staff_ids[$d][$i] = $results['WorkTable']['d'.$d];
                        if (!empty($results['WorkTable']['d'.$d])) {
                            $staff_ids2[$d][$i] = explode(',', $results['WorkTable']['d'.$d]);
                            $staff_ids3[$d][$i] = $results['WorkTable']['d'.$d];
                        }
                    }
                }

                $this->set('staff_ids', $staff_ids);
                $staff_cell = $staff_ids2;
                $staff_cell[0][0] = $month;     // 該当月セット
                $this->Session->write('staff_cell', $staff_cell);
                $this->set('staff_cell', $staff_ids3);
                $this->log($this->Session->read('staff_cell'), LOG_DEBUG);
            }

            //$this->log($staff_ids2, LOG_DEBUG);
            /**
            for($row=1; $row<=31; $row++) {
                for($col=1; $col<200; $col++) {
                    if (empty($staff_ids[$row][$col])) {
                        continue;
                    }
                    //$this->log($staff_ids[$row][$col], LOG_DEBUG);
                    $staff_ids2 = explode(',', $staff_ids[$row][$col]);
                    foreach ($staff_ids2 as $key=>$staff_id) {
                        $conditions1 = array('id'=>$staff_id);
                        $data_staffs2[$row][$col][$key] = $this->StaffMaster->find('first', array('fields'=>array('id', 'name_sei', 'name_mei'), 'conditions'=>$conditions1));
                    }
                }
            }
            $this->set('data_staffs2', $data_staffs2);
            //$this->log($data_staffs2, LOG_DEBUG);
             * 
             */
            
            // データ
            if (empty($staff_cell)) {
                $this->set('data_staffs', null);
            } else {
                for($row=1; $row<=31; $row++) {
                    for($col=1; $col<200; $col++) {
                        if (empty($staff_cell[$row][$col])) {
                            continue;
                        }
                        foreach ($staff_cell[$row][$col] as $key=>$staff_id) {
                            $conditions1 = array('id'=>$staff_id);
                            $data_staffs[$row][$col][$key] = $this->StaffMaster->find('first', array('fields'=>array('id', 'name_sei', 'name_mei'), 'conditions'=>$conditions1));
                        }
                    }
                }
                $this->set('data_staffs', $data_staffs);
                //$this->log($data_staffs, LOG_DEBUG);
                // セッション削除
                //$this->Session->delete('staff_cell');
            }
        }
        
    }

    /**
     * 稼働表ベース表検証
     */
    public function test2() {
        // レイアウト関係
        $this->layout = "main";
        $this->set("title_for_layout", $this->title_for_layout);
        // タブの状態
        $this->set('active1', '');
        $this->set('active2', '');
        $this->set('active3', '');
        $this->set('active4', '');
        $this->set('active5', 'active');
        $this->set('active6', '');
        $this->set('active7', '');
        $this->set('active8', '');
        $this->set('active9', '');
        $this->set('active10', '');
        // 絞り込みセッションを消去
        $this->Session->delete('filter');
        // 職種マスタ配列
        $conditions0 = array('item' => 17);
        $list_shokushu = $this->Item->find('list', array('fields' => array('id', 'value'), 'conditions' => $conditions0));
        $this->set('list_shokushu', $list_shokushu);
        // その他
        $username = $this->Auth->user('username');
        $this->set('username', $username); 
        $user_name = $this->Auth->user('name_sei').' '.$this->Auth->user('name_mei');
        $this->set('user_name', $user_name); 
        $selected_class = $this->Session->read('selected_class');
        $this->set('selected_class', $selected_class);
        // テーブルの設定
        $this->StaffMaster->setSource('staff_'.$selected_class);
        $this->WorkTable->setSource('work_tables');
        // 初期化
        $staff_ids2 = null;
        $staff_ids3 = null;
        $staff_ids = null;
        $data_staffs = null;
        $this->set('row', null);
        $this->set('datas', null);
        $data2 = null;
        $list_recommend = null;
        // 案件名の取得
        $conditions1 = array('class'=>$selected_class);
        $getCasename = $this->CaseManagement->find('list', array('fields'=>array('id', 'case_name'), 'conditions' => $conditions1));
        $this->set('getCasename', $getCasename);
        //$this->log($getCasename, LOG_DEBUG);
        // 取引先の取得
        $conditions1 = array('class'=>$selected_class);
        $list_customer = $this->Customer->find('list', array('fields'=>array('id', 'corp_name'), 'conditions' => $conditions1));
        $this->set('list_customer', $list_customer);
        //$this->log($list_customer, LOG_DEBUG);
        // 事業主の取得
        $conditions1 = array('class'=>$selected_class);
        $result1 = $this->CaseManagement->find('all', array('conditions' => $conditions1));
        //$this->log($result1, LOG_DEBUG);
        $datas1 = null;
        foreach ($result1 as $key=>$value) {
            for ($i=0; $i<10; $i++) {
                $this->log($value['CaseManagement']['entrepreneur2'], LOG_DEBUG);
                if ($i == 0) {
                    if (empty($value['CaseManagement']['entrepreneur1'])) {
                        $datas1[$value['CaseManagement']['id']] = '';
                        break;
                    }
                    $datas1[$value['CaseManagement']['id']] = $list_customer[$value['CaseManagement']['entrepreneur1']];
                } else {
                    if (empty($value['CaseManagement']['entrepreneur'.($i+1)])) {
                        break;
                    }
                    $datas1[$value['CaseManagement']['id']] .= '/'.$list_customer[$value['CaseManagement']['entrepreneur'.($i+1)]];
                }
            }
        }
        //$this->log($datas1, LOG_DEBUG);
        $this->set('list_entrepreneur', $datas1);
        // 依頼主
        $conditions1 = array('class'=>$selected_class);
        $result1 = $this->CaseManagement->find('all', array(
            'fields'=>array('id', 'client'), 'conditions' => $conditions1));
        //$this->log($result1, LOG_DEBUG);
        $datas2 = null;
        foreach ($result1 as $value) {
            if (empty($value['CaseManagement']['client'])) {
                $datas2[$value['CaseManagement']['id']] = '';
                continue;
            }
            $datas2[$value['CaseManagement']['id']] = $list_customer[$value['CaseManagement']['client']];
        }
        $this->set('list_client', $datas2);
        //$this->log($datas2, LOG_DEBUG);
        // 指揮命令者・担当者
        $conditions2 = array('class'=>$selected_class);
        $this->CaseManagement->virtualFields['director2'] = 'CONCAT(position, "：", director)';
        $list_director = $this->CaseManagement->find('list', array('fields' => array('id', 'director2'), 'conditions' => $conditions2));
        $this->set('list_director', $list_director);
        // 住所
        $list_address = $this->CaseManagement->find('list', array('fields' => array('id', 'address'), 'conditions' => $conditions2));
        $this->set('list_address', $list_address);
        // TEL
        $list_telno = $this->CaseManagement->find('list', array('fields' => array('id', 'telno'), 'conditions' => $conditions2));
        $this->set('list_telno', $list_telno);
        // FAX
        $list_faxno = $this->CaseManagement->find('list', array('fields' => array('id', 'faxno'), 'conditions' => $conditions2));
        $this->set('list_faxno', $list_faxno);
        // 請求先担当者
        $this->CaseManagement->virtualFields['tantou2'] = 'CONCAT(Customer.corp_name, "<br>", Customer.tantou)';
        $option = array();
        $option['fields'] = array('CaseManagement.id', 'tantou2'); 
        //$option['order'] = array('OrderInfoDetail.case_id' => 'asc', 'OrderInfoDetail.order_id' => 'asc', 'OrderInfoDetail.shokushu_num' => 'asc');
        //$option['conditions'] = array('OrderInfoDetail.class'=>$selected_class, 'OrderCalender.year' => $year, 'OrderCalender.month' => $month); 
        $option['joins'] = array(
        array(
            'type' => 'LEFT',   //LEFT, INNER, OUTER
            'table' => 'customer',
            'alias' => 'Customer',    //下でPost.user_idと書くために
            'conditions' => array('CaseManagement.billing_destination1 = Customer.id')
            ),
        ); 
        $datas = $this->CaseManagement->find('list', $option);
        //$this->log($datas, LOG_DEBUG);
        $this->set('list_bill', $datas);
        // 請求書締日
        $option = array();
        $option['fields'] = array('CaseManagement.id', 'Customer.bill_cutoff'); 
        //$option['order'] = array('OrderInfoDetail.case_id' => 'asc', 'OrderInfoDetail.order_id' => 'asc', 'OrderInfoDetail.shokushu_num' => 'asc');
        //$option['conditions'] = array('OrderInfoDetail.class'=>$selected_class, 'OrderCalender.year' => $year, 'OrderCalender.month' => $month); 
        $option['joins'] = array(
        array(
            'type' => 'LEFT',   //LEFT, INNER, OUTER
            'table' => 'customer',
            'alias' => 'Customer',    //下でPost.user_idと書くために
            'conditions' => array('CaseManagement.billing_destination1 = Customer.id')
            ),
        ); 
        $list_cutoff = $this->CaseManagement->find('list', $option);
        //$this->log($datas, LOG_DEBUG);
        $this->set('list_cutoff', $list_cutoff);
        // 推奨スタッフ
        for ($i=1; $i<=20; $i++) {
            $results = $this->OrderInfo->find('list', array('fields'=>array('id', 'staff_ids'.$i)));
            foreach ($results as $key=>$result) {
                if (empty($result)) {
                    $list_staffs2[$key][$i] = '';
                    continue;
                }
                $list_staffs[$key][$i] = explode(',', $result);
                foreach($list_staffs[$key][$i] as $j=>$staff_id) {
                    $this->StaffMaster->virtualFields['name'] = 'CONCAT(name_sei, " ", name_mei)';
                    $list_staffs2[$key][$i][$j] = $this->StaffMaster->find('first', array('fields'=>'name', 'conditions'=>array('id'=>$staff_id)));
                }
            }
        }
        //$this->log($list_staffs2, LOG_DEBUG);
        $this->set('list_staffs', $list_staffs2);
        
        // post時の処理
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->log($this->request->data, LOG_DEBUG);
            $data = $this->request->data;
            if (isset($data['mode'])) {
                $row = $data['row'];
                for ($i=1; $i<=$row; $i++) {
                    for ($d=1; $d<=31; $d++) {
                        if (empty($data[$d.'_'.$i])) {
                            continue;
                        }
                        $data2[$i]['column'] = $i;
                        $data2[$i]['class'] = $selected_class;
                        $data2[$i]['username'] = $username;
                        $data2[$i]['month'] = $data['month'];
                        $data2[$i]['d'.$d] = $data[$d.'_'.$i];
                        $data2[$i]['case_id'] = $data['WorkTable'][$i]['case_id'];
                        $data2[$i]['order_id'] = $data['WorkTable'][$i]['order_id'];
                        $data2[$i]['shokushu_num'] = $data['WorkTable'][$i]['shokushu_num'];
                    }
                }
                // データがなければ処理停止
                if (empty($data2)) {
                    $this->redirect(array('action'=>'$list_staffs', '?date='.date('Y-m', strtotime($data['month']))));
                    return;
                }
                // 該当月を削除
                $param = array('class' => $selected_class, 'month' => $data['month']);
                if ($this->WorkTable->deleteAll($param)) {
                    // データを登録する
                    if ($this->WorkTable->saveAll($data2)) {
                        $this->Session->setFlash('保存を完了しました。');
                        // セッション削除
                        $this->Session->delete('staff_cell');
                        // シフト編集モード
                        //$this->Session->write('edit', $data['edit']);
                        //$this->set('edit', $data['edit']);
                        //$this->log('$edit='.$data['edit']);
                        $this->redirect(array('action'=>'test2', '?date='.date('Y-m', strtotime($data['month']))));
                    } else {

                    }
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
            } else {

            }
        } elseif ($this->request->is('get')) {
            if (!empty($this->request->query('date'))) {
                $date = $this->request->query('date');
                //$this->log($date, LOG_DEBUG);
                $date_arr = explode('-',$date);
                $year = $date_arr[0];
                $month = $date_arr[1];
            } else {
                $year = date('Y', strtotime('+1 month'));
                $month = date('n', strtotime('+1 month'));
            }
            $month = ltrim($month, '0');
            $this->set('year', $year);
            $this->set('month', ltrim($month, '0'));
            
            // 登録していた値をセット
            // 登録データのセット
            //$conditions1 = array('id' => $order_id, 'case_id' => $case_id);
            $conditions1 = array('class'=>$selected_class, 'OrderCalender.year' => $year, 'OrderCalender.month' => $month);
            $row = $this->OrderCalender->find('count', array('conditions' => $conditions1));
            $this->set('row', $row);
            // 案件あたりの職種数
            $conditions1 = array('class'=>$selected_class, 'OrderCalender.year' => $year, 'OrderCalender.month' => $month);
            $datas = $this->OrderCalender->find('all', array('fields'=>array('case_id', 'count(case_id) as cnt'), 
                'conditions' => $conditions1, 'group' => array('case_id'), 'order' => array('case_id', 'order_id')));
            $this->set('datas', $datas);
            //$this->log($datas, LOG_DEBUG);
            // 職種以下
            $option = array();
            $option['fields'] = array('OrderInfoDetail.*', 'OrderCalender.*'); 
            $option['order'] = array('OrderInfoDetail.case_id' => 'asc', 'OrderInfoDetail.order_id' => 'asc', 'OrderInfoDetail.shokushu_num' => 'asc');
            $option['conditions'] = array('OrderInfoDetail.class'=>$selected_class, 'OrderCalender.year' => $year, 'OrderCalender.month' => $month); 
            $option['joins'] = array(
            array(
                'type' => 'RIGHT',   //LEFT, INNER, OUTER
                'table' => 'order_calenders',
                'alias' => 'OrderCalender',    //下でPost.user_idと書くために
                'conditions' => array('OrderInfoDetail.order_id = OrderCalender.order_id AND OrderInfoDetail.shokushu_num = OrderCalender.shokushu_num')
                ),
            );
            // オーダー入力欄以下
            $conditions = array('class'=>$selected_class);
            $datas2 = $this->OrderInfoDetail->find('all', $option);
            $this->set('datas2', $datas2);
            
            // 前月のスタッフ
            $m = date('Y-m-d', strtotime('-1 month', strtotime($year.'-'.$month.'-01')));
            //$this->log($m, LOG_DEBUG);
            $datas3 = null;$datas4 = null;
            foreach($datas2 as $key=>$data) {
                $conditions2 = array('class'=>$selected_class, 'order_id'=>$data['OrderInfoDetail']['order_id'], 
                    'shokushu_num'=>$data['OrderInfoDetail']['shokushu_num'], 'month' => $m);
                for($i=1; $i<=31; $i++) {
                    $results = $this->WorkTable->find('first', array('fields'=>array('d'.$i), 
                        'conditions' => $conditions2, 'order' => array('case_id', 'order_id', 'shokushu_num')));
                    if (empty($results)) {
                        $datas3[$key] = null;
                        continue;
                    }
                    $datas3[$key][$i-1] = $results['WorkTable']['d'.$i];
                }
                if (empty($datas3[$key])) {
                    $list_recommend = null;
                } else {
                    $datas3[$key] = array_filter($datas3[$key], 'strlen');      // 空を削除
                    $datas3[$key] = array_unique($datas3[$key]);                // 重複を削除
                    // 氏名に変換
                    foreach ($datas3[$key] as $j=>$value) {
                        $condition = array('id'=>$value);
                        $this->StaffMaster->virtualFields['name'] = 'CONCAT(name_sei, " ", name_mei)';
                        $list_recommend[$key][$j] = $this->StaffMaster->find('first', array('fields'=>array('id', 'name'), 'conditions'=>$condition));
                    }
                }
            }
            $this->set('list_recommend', $list_recommend);
            $this->log($list_recommend, LOG_DEBUG);
            // カレンダー部分のデータ・セット

            $record = $this->OrderInfoDetail->find('count', $option);
            $this->set('record', $record);
            //$this->set('y', date('Y'));
            //$this->set('m', date('n')+1);
            
            // セッション保存データ
            // セッション削除
            //$this->Session->delete('staff_cell');
            // スタッフIDをカンマ区切りにする
            $staff_cell = $this->Session->read('staff_cell');
            //$this->log($staff_cell, LOG_DEBUG);
            $staff_cell2 = null;
            if (!empty($staff_cell) && $staff_cell[0][0] == $year.'-'.$month) {
                for($i=1; $i<=31; $i++) {
                    for($j=1; $j<=200; $j++) {
                        if (empty($staff_cell[$j][$i])) {
                            continue;
                        }
                        $staff_cell2[$j][$i] = implode(',', $staff_cell[$j][$i]);
                    }
                }
                //$this->log($staff_cell2, LOG_DEBUG);
                $this->set('staff_cell', $staff_cell2);
            } else {
                for($i=1; $i<=200; $i++) {
                    $conditions1 = array('class'=>$selected_class, 'month'=>$year.'-'.$month.'-01', 'column'=>$i);
                    $results= $this->WorkTable->find('first', array('conditions'=>$conditions1));
                    //$this->log($results, LOG_DEBUG);
                    if (empty($results)) {
                        continue;
                    }
                    for($d=1; $d<=31; $d++) {
                        $staff_ids[$d][$i] = $results['WorkTable']['d'.$d];
                        if (!empty($results['WorkTable']['d'.$d])) {
                            $staff_ids2[$d][$i] = explode(',', $results['WorkTable']['d'.$d]);
                            $staff_ids3[$d][$i] = $results['WorkTable']['d'.$d];
                        }
                    }
                }

                $this->set('staff_ids', $staff_ids);
                $staff_cell = $staff_ids2;
                $staff_cell[0][0] = $year.'-'.$month;     // 該当月セット
                $this->Session->write('staff_cell', $staff_cell);
                $this->set('staff_cell', $staff_ids3);
                //$this->log($this->Session->read('staff_cell'), LOG_DEBUG);
            }
            
            // 氏名のセット
            if (empty($staff_cell)) {
                $this->set('data_staffs', null);
            } else {
                for($row=1; $row<=31; $row++) {
                    for($col=1; $col<200; $col++) {
                        if (empty($staff_cell[$row][$col])) {
                            continue;
                        }
                        foreach ($staff_cell[$row][$col] as $key=>$staff_id) {
                            $conditions1 = array('id'=>$staff_id);
                            $data_staffs[$row][$col][$key] = $this->StaffMaster->find('first', array('fields'=>array('id', 'name_sei', 'name_mei'), 'conditions'=>$conditions1));
                        }
                    }
                }
                $this->set('data_staffs', $data_staffs);
                //$this->log($data_staffs, LOG_DEBUG);
                // セッション削除
                //$this->Session->delete('staff_cell');
            }
        } else {
            // DBの保存データ
            // 指定月の取得
            if (!empty($this->request->query('date'))) {
                $date = $this->request->query('date');
                //$this->log($date, LOG_DEBUG);
                $date_arr = explode('-',$date);
                $year = $date_arr[0];
                $month = $date_arr[1];
            } else {
                $year = date('Y', strtotime('+1 month'));
                $month = date('n', strtotime('+1 month'));
            }
            $month = ltrim($month, '0');
            $this->set('year', $year);
            $this->set('month', ltrim($month, '0'));
            
            // セッション削除
            //$this->Session->delete('staff_cell');
            // スタッフIDをカンマ区切りにする
            $staff_cell = $this->Session->read('staff_cell');
            //$this->log($staff_cell, LOG_DEBUG);
            $staff_cell2 = null;
            if (!empty($staff_cell) && $staff_cell[0][0] == $month) {
                for($i=1; $i<=31; $i++) {
                    for($j=1; $j<=200; $j++) {
                        if (empty($staff_cell[$j][$i])) {
                            continue;
                        }
                        $staff_cell2[$j][$i] = implode(',', $staff_cell[$j][$i]);
                    }
                }
                //$this->log($staff_cell2, LOG_DEBUG);
                $this->set('staff_cell', $staff_cell2);
            } else {
                for($i=1; $i<=200; $i++) {
                    $conditions1 = array('class'=>$selected_class, 'month'=>$month.'-01', 'column'=>$i);
                    $results= $this->WorkTable->find('first', array('conditions'=>$conditions1));
                    //$this->log($results, LOG_DEBUG);
                    if (empty($results)) {
                        continue;
                    }
                    for($d=1; $d<=31; $d++) {
                        $staff_ids[$d][$i] = $results['WorkTable']['d'.$d];
                        if (!empty($results['WorkTable']['d'.$d])) {
                            $staff_ids2[$d][$i] = explode(',', $results['WorkTable']['d'.$d]);
                            $staff_ids3[$d][$i] = $results['WorkTable']['d'.$d];
                        }
                    }
                }

                $this->set('staff_ids', $staff_ids);
                $staff_cell = $staff_ids2;
                $staff_cell[0][0] = $month;     // 該当月セット
                $this->Session->write('staff_cell', $staff_cell);
                $this->set('staff_cell', $staff_ids3);
                //$this->log($this->Session->read('staff_cell'), LOG_DEBUG);
            }
            
            // データ
            if (empty($staff_cell)) {
                $this->set('data_staffs', null);
            } else {
                for($row=1; $row<=31; $row++) {
                    for($col=1; $col<200; $col++) {
                        if (empty($staff_cell[$row][$col])) {
                            continue;
                        }
                        foreach ($staff_cell[$row][$col] as $key=>$staff_id) {
                            $conditions1 = array('id'=>$staff_id);
                            $data_staffs[$row][$col][$key] = $this->StaffMaster->find('first', array('fields'=>array('id', 'name_sei', 'name_mei'), 'conditions'=>$conditions1));
                        }
                    }
                }
                $this->set('data_staffs', $data_staffs);
                //$this->log($data_staffs, LOG_DEBUG);
                // セッション削除
                //$this->Session->delete('staff_cell');
            }
        }
    }

    // スタッフの選択（小画面）
    public function select($order_id = null, $col = null, $cell_row = null, $cell_col = null, $shokushu_num = null) {
        // レイアウト関係
        $this->layout = "sub";
        $this->set("title_for_layout", $this->title_for_layout);
        // 初期セット
        $username = $this->Auth->user('username').' '.$this->Auth->user('name_mei');
        $this->set('username', $username);
        $selected_class = $this->Session->read('selected_class');
        $this->set('selected_class', $selected_class);
        $this->set('datas1', null);
        $datas2 = null;
        $this->set('datas2', $datas2);
        $this->set('order_id', $order_id);
        $this->set('shokushu_num', $shokushu_num);
        $staff_cell = $this->Session->read('staff_cell');
        //$this->Session->write('staff_cell', $staff_cell);
        // テーブルの設定
        $this->StaffMaster->setSource('staff_'.$selected_class);
        // 指定月の取得
        if (isset($this->request->query['date'])) {
            $month = $this->request->query['date'];
        } else {
            $month = date('Y-m');
        }
        // 列番号（１はじまり）
        $this->set('col', $cell_col);
        /**
        // 推奨スタッフ
        for ($i=1; $i<=20; $i++) {
            $results = $this->OrderInfo->find('all', array('fields'=>array('id', 'staff_ids'.$i)));
            //$this->log($results, LOG_DEBUG);
            foreach ($results as $result) {
                $list_staffs[$result['OrderInfo']['id']][$i] = explode(',', $result['OrderInfo']['staff_ids'.$i]);
                
                foreach($list_staffs[$result['OrderInfo']['id']][$i] as $j=>$staff_id) {
                    $this->StaffMaster->virtualFields['name'] = 'CONCAT(name_sei, " ", name_mei)';
                    $list_staffs2[$result['OrderInfo']['id']][$i][$j] = $this->StaffMaster->find('first', array('fields'=>array('id', 'name'), 'conditions'=>array('id'=>$staff_id)));
                }
            }
        }
        $this->set('list_staffs2', $list_staffs2);
        $this->log($list_staffs2, LOG_DEBUG);
        //　前月スタッフ
        if (isset($this->request->query['pre_month'])) {
            $staff_ids = explode(',', $this->request->query['pre_month']);
        } else {
            $staff_ids = null;
        }
        //$this->log($staff_ids, LOG_DEBUG);
        foreach($staff_ids as $key=>$staff_id) {
            $this->StaffMaster->virtualFields['name'] = 'CONCAT(name_sei, " ", name_mei)';
            $data_staff[$key] = $this->StaffMaster->find('first', array('fields'=>array('id', 'name'), 'conditions'=>array('id'=>$staff_id)));
        }
        //$this->log($data_staff, LOG_DEBUG);
        $this->set('data_staff', $data_staff);
         * 
         */
        
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
                    // ひらがなでの検索
                    foreach( $ary_keyword as $val ){
                        // 検索条件を設定するコードをここに書く
                        $conditions2[] = array('CONCAT(StaffMaster.name_sei2, StaffMaster.name_mei2) LIKE ' => '%'.mb_convert_kana($val, "C", "UTF-8").'%');
                    }
                    $datas1 = $this->StaffMaster->find('all', array('conditions'=>array('OR'=>array($conditions1, $conditions2))));
                    $this->log($this->StaffMaster->getDataSource()->getLog(), LOG_DEBUG);
                    $this->set('datas1', $datas1);
                }
            // 選択
            } elseif (isset($this->request->data['select'])) {
                $id_array = array_keys($this->request->data['select']);
                $id = $id_array[0];
                // 選択は５つまで
                /**
                $session_id = $this->Session->read('staff_id');
                if (count($session_id) == 5) {
                    $this->Session->setFlash('【エラー】選択できるのは5つまでです。');
                    $this->redirect(array('action' => 'select', $order_id ));
                    return;
                }
                 * 
                 */
                // セッション格納
                if (empty($staff_cell[$cell_row][$cell_col])) {
                    $staff_cell[$cell_row][$cell_col][0] = $id;
                } else {
                    $flag = false;
                    for($i=0; $i<count($staff_cell[$cell_row][$cell_col]) ;$i++) {
                        if ($staff_cell[$cell_row][$cell_col][$i] == $id) {
                            $flag = true;
                            continue;
                        }
                    }
                    if (!$flag) {
                        $staff_cell[$cell_row][$cell_col][] += $id;
                    }
                }
                $staff_cell[0][0] = $month;
                //$this->log($staff_cell, LOG_DEBUG);
                $this->Session->write('staff_cell', $staff_cell);
                // 選択中スタッフ
                $this->StaffMaster->virtualFields['name'] = 'CONCAT(name_sei, " ", name_mei)';
                foreach($staff_cell[$cell_row][$cell_col] as $key=>$staff_id) {
                    if (empty($datas2)) {
                        $datas2[0] = $this->StaffMaster->find('first', array('fields'=>array('id', 'name'), 'conditions'=>array('id'=>$staff_id)));
                    } else {
                        $datas2[$key] = $this->StaffMaster->find('first', array('fields'=>array('id', 'name'), 'conditions'=>array('id'=>$staff_id)));
                    }
                }
                $this->set('datas2', $datas2);
                //$this->log($datas2, LOG_DEBUG);
                $this->redirect(array('action'=>'select', $order_id, $col, $cell_row, $cell_col, $shokushu_num, '?date='.$month));
            // 消去
            } elseif (isset($this->request->data['erasure'])) {
                $id_array = array_keys($this->request->data['erasure']);
                $id = $id_array[0];
                $key = array_search($id, $staff_cell[$cell_row][$cell_col]);
                unset($staff_cell[$cell_row][$cell_col][$key]);
                //$staff_cell[$cell_row][$cell_col] = null;
                $this->Session->write('staff_cell', $staff_cell);
                //$this->log(array_search($id, $staff_cell[$cell_row][$cell_col]), LOG_DEBUG);
                //$this->Session->delete('staff_cell');
                $this->redirect(array('action'=>'select', $order_id, $col, $cell_row, $cell_col, $shokushu_num, '?date='.$month));
            } else {
                
            }
        } elseif ($this->request->is('get')) {

        } else {
            
        }
        // 推奨スタッフ
        $data1 = $this->WkShift->find('first', array('conditions'=>array('order_id'=>$order_id, 'shokushu_num'=>$shokushu_num, 'month'=>$month.'-01', 'class'=>$selected_class)));
        $recommend_staff = explode(',', $data1['WkShift']['recommend_staff']);
        //$this->log($month, LOG_DEBUG);
        foreach($recommend_staff as $key=>$staff_id) {
            $this->StaffMaster->virtualFields['name'] = 'CONCAT(name_sei, " ", name_mei)';
            $recommend_staff2[$key] = $this->StaffMaster->find('first', array('fields'=>array('id', 'name'), 'conditions'=>array('id'=>$staff_id)));
        }
        foreach ($recommend_staff2 as $key => $value){
          $key_id[$key] = $value['StaffMaster']['id'];
        }
        array_multisort($key_id , SORT_ASC , $recommend_staff2);
        $this->set('recommend_staff2', $recommend_staff2);
        //$this->log($recommend_staff2, LOG_DEBUG);
        //　前月スタッフ
        if (!empty($data1['WkShift']['pre_month'])) {
            $premonth_staff = explode(',', $data1['WkShift']['pre_month']);
            foreach($premonth_staff as $key=>$staff_id) {
                $this->StaffMaster->virtualFields['name'] = 'CONCAT(name_sei, " ", name_mei)';
                $premonth_staff2[$key] = $this->StaffMaster->find('first', array('fields'=>array('id', 'name'), 'conditions'=>array('id'=>$staff_id)));
            }
            foreach ($premonth_staff2 as $key2 => $value2){
              $key_id2[$key2] = $value2['StaffMaster']['id'];
            }
            array_multisort($key_id2 , SORT_ASC , $premonth_staff2);
        } else {
            $premonth_staff2 = null;
        }
        $this->set('premonth_staff2', $premonth_staff2);
        // シフト希望スタッフ
        $shokushu_id = $data1['WkShift']['shokushu_id'];
        $conditions6 = array(
            'StaffSchedule.class'=>$selected_class, 
            'work_date'=>$month.'-'.$cell_row,
            'FIND_IN_SET('.$shokushu_id.', shokushu_id)',
            'OR'=>array(array('work_flag'=>1), array('work_flag'=>2))
            );
        $joins = array(
        array(
            'type' => 'LEFT',   //LEFT, INNER, OUTER
            'table' => 'staff_'.$selected_class,
            'alias' => 'StaffMaster',    //下でPost.user_idと書くために
            'conditions' => array('StaffSchedule.staff_id = StaffMaster.id')
            ),
        );
        $datas3 = $this->StaffSchedule->find('all', array('fields'=>array('StaffSchedule.*','StaffMaster.name_sei','StaffMaster.name_mei'), 'conditions'=>$conditions6, 'joins'=>$joins));
        foreach ($datas3 as $key => $value){
            $key_staff_id[$key] = $value['StaffSchedule']['staff_id'];
            $point_arr = explode(',', $value['StaffSchedule']['point']);
            $key_point[$key] = $point_arr[$cell_col-1];
        }
        array_multisort ( $key_point , SORT_DESC , $key_staff_id , SORT_ASC , $datas3 );
        $this->log($datas3, LOG_DEBUG);
        $this->set('request_staffs', $datas3 );
        // 選択済みスタッフ
        //$this->log($staff_cell, LOG_DEBUG);
        if (!empty($staff_cell[$cell_row][$cell_col])) {
            $this->StaffMaster->virtualFields['name'] = 'CONCAT(name_sei, " ", name_mei)';
            foreach($staff_cell[$cell_row][$cell_col] as $key=>$staff_id) {
                if (empty($staff_id)) {
                    continue;
                }
                if (empty($datas2)) {
                    $datas2[0] = $this->StaffMaster->find('first', array('fields'=>array('id', 'name'), 'conditions'=>array('id'=>$staff_id)));
                } else {
                    $datas2[$key] = $this->StaffMaster->find('first', array('fields'=>array('id', 'name'), 'conditions'=>array('id'=>$staff_id)));
                }
            }
            $this->set('datas2', $datas2);
        }
}
    
    /**
     * 稼働表技術検証（断念）
     */
    public function test_3() {
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
        $this->set('active4', '');
        $this->set('active5', 'active');
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
        $username = $this->Auth->user('username');
        $this->set('username', $username);
        $selected_class = $this->Session->read('selected_class');
        $this->set('selected_class', $selected_class);
        $data_staffs = null;
        // テーブルの設定
        $this->StaffMaster->setSource('staff_'.$selected_class);
        $this->WorkTable->setSource('work_tables');

        // post時の処理
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->log($this->request->data, LOG_DEBUG);
            for ($i=1; $i<200; $i++) {
                for ($d=1; $d<=31; $d++) {
                    if (empty($this->request->data['WorkTable'][$i]['d'.$d])) {
                        continue;
                    }
                    $this->request->data['WorkTable'][$i]['d'.$d] = implode(',', $this->request->data['WorkTable'][$i]['d'.$d]);
                }
            }
            // データを登録する
            if ($this->WorkTable->saveAll($this->request->data['WorkTable'])) {
                $this->Session->setFlash('保存を完了しました。');
                // セッション削除
                $this->Session->delete('staff_cell');
                $this->redirect(array('action'=>'test'));
            } else {

            }
        } else {
            // DBの保存データ
            // 指定月の取得
            if (isset($this->request->query['date'])) {
                $month = str_replace('-', '', $this->request->query['date']);
            } else {
                $month = date('Ym');
            }
            
            // スタッフIDをカンマ区切りにする
            $staff_cell = $this->Session->read('staff_cell');
            $staff_cell2 = null;
            if (!empty($staff_cell)) {
                for($i=1; $i<=31; $i++) {
                    for($j=1; $j<=200; $j++) {
                        if (empty($staff_cell[$j][$i])) {
                            continue;
                        }
                        $staff_cell2[$j][$i] = implode(',', $staff_cell[$j][$i]);
                    }
                }
                //$this->log($staff_cell2, LOG_DEBUG);
                $this->set('staff_cell', $staff_cell2);
            } else {
                for($i=1; $i<=200; $i++) {
                    $conditions1 = array('class'=>$selected_class, 'work_date >= '=>$month.'01', 'work_date <= '=>$month.'31', 'column'=>$i);
                    $results= $this->WorkTable->find('first', array('conditions'=>$conditions1));
                    //$this->log($results, LOG_DEBUG);
                    if (empty($results)) {
                        continue;
                    }
                    for($d=1; $d<=31; $d++) {
                        $staff_ids[$d][$i] = $results['WorkTable']['d'.$d];
                        if (!empty($results['WorkTable']['d'.$d])) {
                            $staff_ids2[$d][$i] = explode(',', $results['WorkTable']['d'.$d]);
                            $staff_ids3[$d][$i] = $results['WorkTable']['d'.$d];
                        }
                    }
                }
                $this->set('staff_ids', $staff_ids);
                $staff_cell = $staff_ids2;
                $this->Session->write('staff_cell', $staff_cell);
                $this->set('staff_cell', $staff_ids3);
                //$this->log($staff_ids3, LOG_DEBUG);
            }

            //$this->log($staff_ids2, LOG_DEBUG);
            /**
            for($row=1; $row<=31; $row++) {
                for($col=1; $col<200; $col++) {
                    if (empty($staff_ids[$row][$col])) {
                        continue;
                    }
                    //$this->log($staff_ids[$row][$col], LOG_DEBUG);
                    $staff_ids2 = explode(',', $staff_ids[$row][$col]);
                    foreach ($staff_ids2 as $key=>$staff_id) {
                        $conditions1 = array('id'=>$staff_id);
                        $data_staffs2[$row][$col][$key] = $this->StaffMaster->find('first', array('fields'=>array('id', 'name_sei', 'name_mei'), 'conditions'=>$conditions1));
                    }
                }
            }
            $this->set('data_staffs2', $data_staffs2);
            //$this->log($data_staffs2, LOG_DEBUG);
             * 
             */
            
            // データ
            if (empty($staff_cell)) {
                $this->set('data_staffs', null);
            } else {
                for($row=1; $row<=31; $row++) {
                    for($col=1; $col<200; $col++) {
                        if (empty($staff_cell[$row][$col])) {
                            continue;
                        }
                        foreach ($staff_cell[$row][$col] as $key=>$staff_id) {
                            $conditions1 = array('id'=>$staff_id);
                            $data_staffs[$row][$col][$key] = $this->StaffMaster->find('first', array('fields'=>array('id', 'name_sei', 'name_mei'), 'conditions'=>$conditions1));
                        }
                    }
                }
                $this->set('data_staffs', $data_staffs);
                //$this->log($data_staffs, LOG_DEBUG);
                // セッション削除
                //$this->Session->delete('staff_cell');
            }
        }
        
    }
}
