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
    public $uses = array('StaffSchedule' ,'WorkTable' ,'Item', 'User', 'TimeCard', 'ShiftLog',
        'StaffMaster', 'CaseManagement', 'OrderInfo', 'OrderInfoDetail', 'OrderCalender', 'Customer', 'WkShift', 'WkSchedule');
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
            $date2 = $this->request->query['date'];
            $month = str_replace('-', '', $this->request->query['date']);
        } elseif (isset ($date)) {
            $month = str_replace('-', '', $date);
            $date2 = date('Y-m', strtotime($date.'01'));
        } else {
            //$month = date('Ym');
            $month = date('Ym', strtotime('+1 month'));
            $date2 = date('Y-m', strtotime('+1 month'));
        }
        $this->set('month', $month);
        $this->set('date2', $date2);
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
            'fields'=> array('StaffSchedule.staff_id', 'StaffMaster.name_sei', 'StaffMaster.name_mei', 'StaffMaster.name_sei2', 'StaffMaster.shokushu_shoukai'),
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
        $this->WkSchedule->setSource('wk_schedules');
        // 初期化
        $staff_ids2 = null;
        $staff_ids3 = null;
        $staff_ids = null;
        $data_staffs = null;
        $this->set('row', null);
        $this->set('datas', null);
        $data2 = null;
        $list_premonth = null;
        // 案件名の取得
        $conditions1 = array('class'=>$selected_class);
        $getCasename = $this->CaseManagement->find('list', array('fields'=>array('id', 'case_name'), 'conditions' => $conditions1, 'order' => array('sequence')));
        $this->set('getCasename', $getCasename);
        //$this->log($getCasename, LOG_DEBUG);
        // 案件背景色の取得
        $list_bgcolor = $this->CaseManagement->find('list', array('fields'=>array('id', 'bgcolor'), 'conditions' => $conditions1));
        $this->set('list_bgcolor', $list_bgcolor);
        $list_color = $this->CaseManagement->find('list', array('fields'=>array('id', 'color'), 'conditions' => $conditions1));
        $this->set('list_color', $list_color);
        // 取引先の取得
        $list_customer = $this->Customer->find('list', array('fields'=>array('id', 'corp_name'), 'conditions' => $conditions1));
        $this->set('list_customer', $list_customer);
        //$this->log($list_customer, LOG_DEBUG);
        // 事業主の取得
        $result1 = $this->CaseManagement->find('all', array('conditions' => $conditions1, 'order' => array('sequence')));
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
        // 事業主の取得
        //$result1 = $this->CaseManagement->find('all', array('conditions' => $conditions1, 'order' => array('sequence')));
        //$this->log($result1, LOG_DEBUG);
        $datas11 = null;
        foreach ($result1 as $key=>$value) {
            for ($i=0; $i<10; $i++) {
                //$this->log($value['CaseManagement']['distributor2'], LOG_DEBUG);
                if ($i == 0) {
                    if (empty($value['CaseManagement']['distributor1'])) {
                        $datas11[$value['CaseManagement']['id']] = '';
                        break;
                    }
                    $datas11[$value['CaseManagement']['id']] = $list_customer[$value['CaseManagement']['distributor1']];
                } else {
                    if (empty($value['CaseManagement']['distributor'.($i+1)])) {
                        break;
                    }
                    $datas11[$value['CaseManagement']['id']] .= '/'.$list_customer[$value['CaseManagement']['distributor'.($i+1)]];
                }
            }
        }
        //$this->log($datas1, LOG_DEBUG);
        $this->set('list_distributor', $datas11);
        // 依頼主
        $result1 = $this->CaseManagement->find('all', array(
            'fields'=>array('id', 'client'), 'conditions' => $conditions1, 'order' => array('sequence')));
        //$this->log($result1, LOG_DEBUG);
        $datas22 = null;
        foreach ($result1 as $value) {
            if (empty($value['CaseManagement']['client'])) {
                $datas22[$value['CaseManagement']['id']] = '';
                continue;
            }
            $datas22[$value['CaseManagement']['id']] = $list_customer[$value['CaseManagement']['client']];
        }
        $this->set('list_client', $datas22);
        //$this->log($datas22, LOG_DEBUG);
        // 指揮命令者・担当者の企業名
        $result2 = $this->CaseManagement->find('all', array(
            'fields'=>array('id', 'director_corp'), 'conditions' => $conditions1, 'order' => array('sequence')));
        //$this->log($result2, LOG_DEBUG);
        $datas23 = null;
        foreach ($result2 as $value) {
            if (empty($value['CaseManagement']['director_corp'])) {
                $datas23[$value['CaseManagement']['id']] = '';
                continue;
            }
            $datas23[$value['CaseManagement']['id']] = $list_customer[$value['CaseManagement']['director_corp']];
        }
        $this->set('list_director_corp', $datas23);
        //$this->log($datas23, LOG_DEBUG);
        // 指揮命令者・担当者
        $conditions2 = array('class'=>$selected_class);
        $this->CaseManagement->virtualFields['director2'] = 'CONCAT(position, "：", director)';
        $list_director = $this->CaseManagement->find('list', array('fields' => array('id', 'director2'), 'conditions' => $conditions2, 'order' => array('sequence')));
        $this->set('list_director', $list_director);
        // 住所
        $list_address = $this->CaseManagement->find('list', array('fields' => array('id', 'address'), 'conditions' => $conditions2, 'order' => array('sequence')));
        $this->set('list_address', $list_address);
        // TEL
        $list_telno = $this->CaseManagement->find('list', array('fields' => array('id', 'telno'), 'conditions' => $conditions2, 'order' => array('sequence')));
        $this->set('list_telno', $list_telno);
        // FAX
        $list_faxno = $this->CaseManagement->find('list', array('fields' => array('id', 'faxno'), 'conditions' => $conditions2, 'order' => array('sequence')));
        $this->set('list_faxno', $list_faxno);
        // 請求先担当者
        $this->CaseManagement->virtualFields['tantou2'] = 'CONCAT(Customer.corp_name, "<br>", CaseManagement.billing_tantou1)';
        $option = array();
        $option['fields'] = array('CaseManagement.id', 'tantou2'); 
        $option['order'] = array('CaseManagement.sequence' => 'asc');
        $option['conditions'] = array('CaseManagement.class'=>$selected_class); 
        $option['joins'] = array(
        array(
            'type' => 'LEFT',   //LEFT, INNER, OUTER
            'table' => 'customer',
            'alias' => 'Customer',    //下でPost.user_idと書くために
            'conditions' => array('CaseManagement.billing_destination1 = Customer.id')
            ),
        ); 
        $datas8 = $this->CaseManagement->find('list', $option);
        $this->set('list_bill', $datas8);
        // 請求書締日
        $option = array();
        $option['fields'] = array('CaseManagement.id', 'Customer.bill_cutoff'); 
        $option['order'] = array('CaseManagement.sequence' => 'asc');
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
        // 請求書請求日
        $option = array();
        $option['fields'] = array('CaseManagement.id', 'Customer.bill_arrival'); 
        $option['order'] = array('CaseManagement.sequence' => 'asc');
        $option['conditions'] = array('CaseManagement.class'=>$selected_class); 
        $option['joins'] = array(
        array(
            'type' => 'LEFT',   //LEFT, INNER, OUTER
            'table' => 'customer',
            'alias' => 'Customer',    //下でPost.user_idと書くために
            'conditions' => array('CaseManagement.billing_destination1 = Customer.id')
            ),
        ); 
        $bill_arrival = $this->CaseManagement->find('list', $option);
        //$this->log($datas, LOG_DEBUG);
        $this->set('bill_arrival', $bill_arrival);
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
        // 該当月
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
        $col = $this->OrderCalender->find('count', array('conditions' => $conditions1));
        $this->set('col', $col);
        // 案件あたりの職種数
        $datas = $this->OrderCalender->find('all', array('fields'=>array('*', 'count(case_id) as cnt'), 
            'conditions' => $conditions1, 'group' => array('case_id'), 'order' => array('sequence', 'case_id', 'order_id')));
        $this->set('datas', $datas);
        //$this->log($datas, LOG_DEBUG);
        // 職種以下
        $option = array();
        $option['fields'] = array('OrderInfoDetail.*', 'OrderCalender.*'); 
        $option['order'] = array('OrderCalender.sequence' => 'asc', 'OrderInfoDetail.case_id' => 'asc', 'OrderInfoDetail.order_id' => 'asc', 'OrderInfoDetail.shokushu_num' => 'asc');
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
        //$this->log($datas2, LOG_DEBUG);
        $data_wk = null;

        // 前月のスタッフ
        $m = date('Y-m-d', strtotime('-1 month', strtotime($year.'-'.$month.'-01')));
        //$this->log($m, LOG_DEBUG);
        $datas3 = null;$datas4 = null;$ret = null;
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
                if (empty($value['StaffMaster']['id'])) {
                    $value['StaffMaster']['id'] = '';
                }
                if ($key2 == 0) {
                    $ret[$key] = $value['StaffMaster']['id'];
                } else {
                    $ret[$key] = $ret[$key].','.$value['StaffMaster']['id'];
                }
            }
            //$this->log($ret, LOG_DEBUG);
            if (empty($datas3[$key])) {
                $list_premonth[$key] = null;
                // ワークテーブル配列
                $data_wk[$key] = array('WkShift' => array('month' => $year.'-'.$month.'-01', 'order_id' => $data['OrderInfoDetail']['order_id'], 
                    'shokushu_num' => $data['OrderInfoDetail']['shokushu_num'], 'column' => $key+1, 
                    //'shokushu_id' => $data['OrderInfoDetail']['shokushu_id'], 
                    'pre_month' =>  '', 
                    'recommend_staff' => $ret[$key], 'class' => $selected_class));
            } else {
                $datas3[$key] = array_filter($datas3[$key], 'strlen');      // 空を削除
                $datas3[$key] = array_unique($datas3[$key]);                // 重複を削除

                // ワークテーブル配列
                $data_wk[$key] = array('WkShift' => array('month' => $year.'-'.$month.'-01', 'order_id' => $data['OrderInfoDetail']['order_id'], 
                    'shokushu_num' => $data['OrderInfoDetail']['shokushu_num'], 'column' => $key+1, 
                    //'shokushu_id' => $data['OrderInfoDetail']['shokushu_id'], 
                    'pre_month' =>  implode(',', $datas3[$key]),
                    'recommend_staff' => $ret[$key], 'class' => $selected_class));
                // 氏名に変換
                foreach ($datas3[$key] as $j=>$value) {
                    $condition = array('id'=>$value);
                    $this->StaffMaster->virtualFields['name'] = 'CONCAT(name_sei, " ", name_mei)';
                    $list_premonth[$key][$j] = $this->StaffMaster->find('first', array('fields'=>array('id', 'name'), 'conditions'=>$condition));
                }
            }
        }
        $this->set('list_premonth', $list_premonth);
        // 待ち合わせ
        $data_aps = null;
        $conditions3 = array('month'=>$year.'-'.$month.'-01', 'class'=>$selected_class);
        $datas9 = $this->WorkTable->find('all', array('conditions'=>$conditions3));
        //$this->log($this->WorkTable->getDataSource()->getLog(), LOG_DEBUG);
        foreach($datas9 as $data9) {
            $order_id = $data9['WorkTable']['order_id'];
            $shokushu_num = $data9['WorkTable']['shokushu_num'];
            for ($d=1; $d<=31; $d++) {
                $data_aps[$order_id][$shokushu_num][$d] =  $data9['WorkTable']['ap'.$d];
            }
        }
        $this->set('data_aps', $data_aps);
        //$this->log($data_aps, LOG_DEBUG);

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
        // シフト自動割付のデータはなし
        if (empty($request_staffs)) {
            $this->set('request_staffs', null );
        }
        // 編集確定フラグ
        $conditions5 = array('class' => $selected_class, 'month' => $year.'-'.$month.'-01');
        $data3 = $this->WorkTable->find('first', array('conditions' => $conditions5));
        if (!empty($data3)) {
            $flag = $data3['WorkTable']['flag'];
        } else {
            $flag = 0;
        }
        $this->set('flag', $flag);
        // 案件の表示順の更新処理
        $conditions7 = array('class' => $selected_class);
        $datas5 = $this->CaseManagement->find('all', array('fields'=>array('id', 'sequence'), 'conditions' => $conditions7));
        //$this->log($datas5, LOG_DEBUG);
        foreach($datas5 as $data5) {
            $data = array('sequence' => $data5['CaseManagement']['sequence']);
            $condtion2 = array('case_id' => $data5['CaseManagement']['id'] );
            $this->OrderCalender->updateAll($data, $condtion2);
        }

        // post時の処理
        if ($this->request->is('post') || $this->request->is('put')) {
            $data = $this->request->data;
            $this->log($data, LOG_DEBUG);
            $this->log('ここまで', LOG_DEBUG);
            /** シフト自動割付 **/
            if (isset($data['assignment'])) {
                $conditions6 = array(
                    'StaffSchedule.class'=>$selected_class, 
                    'work_date >= '=>$year.'-'.$month.'-01',
                    'work_date <= '=>$year.'-'.$month.'-31',
                    'work_flag'=>1
                    );
                $request_staffs = $this->StaffSchedule->find('all', array('conditions'=>$conditions6, 'order'=>array('staff_id')));
                //$this->log($request_staffs, LOG_DEBUG);
                if (empty($request_staffs)) {
                    $this->Session->setFlash('【情報】スタッフからのシフト希望がないので、割付できません。');
                    $this->redirect(array('?date='.$this->request->query('date')));
                    return;
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
                $request_staffs2 = $this->StaffSchedule->find('all', 
                        array('fields'=>array('StaffSchedule.*', 'StaffMaster.name_sei', 'StaffMaster.name_mei', 'StaffMaster.shokushu_shoukai'), 
                    'conditions'=>$conditions6, 'joins'=>$joins, 'order'=>array('staff_id')));
                //$this->log($request_staffs2, LOG_DEBUG);
                $this->set('request_staffs', $request_staffs2 );
                /**
                 *  稼働表テーブルの該当月分の作成
                 */
                $col = sizeof($data['WorkTable']);
                for ($i=1; $i<=$col; $i++) {
                    for ($d=1; $d<=31; $d++) {
                        $data2[$i]['column'] = $i;
                        $data2[$i]['class'] = $selected_class;
                        $data2[$i]['username'] = $username;
                        $data2[$i]['month'] = $year.'-'.$month.'-01';
                        //$data2[$i]['d'.$d] = $data['WorkTable'][$i]['staff_id'];
                        $data2[$i]['case_id'] = $data['WorkTable'][$i]['case_id'];
                        $data2[$i]['order_id'] = $data['WorkTable'][$i]['order_id'];
                        $data2[$i]['shokushu_num'] = $data['WorkTable'][$i]['shokushu_num'];
                        $data2[$i]['shokushu_id'] = $data['WorkTable'][$i]['shokushu_id'];
                    }
                }
                // データがなければ処理停止
                /**
                if (empty($data2)) {
                    $this->redirect(array('action'=>'schedule', '?date='.date('Y-m', strtotime($data['month']))));
                    return;
                }
                 * 
                 */
                // 該当月を削除
                $param = array('class' => $selected_class, 'month' => $year.'-'.$month.'-01');
                if ($this->WorkTable->deleteAll($param)) {
                    // データを登録する
                    if ($this->WorkTable->saveAll($data2)) {
                        //$this->Session->setFlash('保存を完了しました。');
                        // セッション削除
                        $this->Session->delete('staff_cell');
                        // シフト編集モード
                        //$this->Session->write('edit', $data['edit']);
                        //$this->redirect(array('action'=>'schedule', '?date='.date('Y-m', strtotime($data['month']))));
                    } else {

                    }
                }
            /** 保存、重複チェック、確定 **/
            } elseif (isset($data['mode'])) {
                $mode = $data['mode'];
                $month2 = $data['month'];
                $col = $data['col'];
                for ($i=1; $i<=$col; $i++) {
                    for ($d=1; $d<=31; $d++) {
                        if (empty($data[$d.'_'.$i])) {
                            continue;
                        }
                        $data2[$i]['column'] = $i;
                        $data2[$i]['class'] = $selected_class;
                        $data2[$i]['username'] = $username;
                        $data2[$i]['month'] = '"'.date('Y-m-d', strtotime($data['month'])).'"';
                        $data2[$i]['d'.$d] = $data[$d.'_'.$i];
                        $data2[$i]['case_id'] = $data['WorkTable'][$i]['case_id'];
                        $data2[$i]['order_id'] = $data['WorkTable'][$i]['order_id'];
                        $data2[$i]['shokushu_num'] = $data['WorkTable'][$i]['shokushu_num'];
                        $data2[$i]['shokushu_id'] = $data['WorkTable'][$i]['shokushu_id'];
                    }
                }
                // データがなければ処理停止
                if (empty($data2)) {
                    $this->redirect(array('action'=>'schedule', '?date='.date('Y-m', strtotime($data['month']))));
                    return;
                }
                // 該当月の更新
                for ($i=1; $i<=$col; $i++) {
                    $conditions = array(
                        'class' => $selected_class,
                        'order_id' => $data2[$i]['order_id'],
                        'shokushu_num' => $data2[$i]['shokushu_num'],
                        'month' => $data['month']
                    );
                    if ($this->WorkTable->updateAll($data2[$i], $conditions)) {
                        //$this->log($this->WorkTable->getDataSource()->getLog(), LOG_DEBUG);
                    } else {
                        break;
                    }
                }
                // 該当月を削除
                // 職種ごとの金額計算の情報
                if (!$this->OrderCalender->saveAll($this->request->data['OrderCalender'])) {
                    $this->Session->setFlash('【エラー】保存に失敗しました。');
                }
                // 時給の更新
                foreach ($this->request->data['OrderCalender'] as $key => $value) {
                    /**
                    if ($value['juchuu_money_h'] == 0 || $value['staff_money_h'] == 0) {
                        continue;
                    }
                     * 
                     */
                    $data7 = array('juchuu_shiharai' => 1, 'juchuu_money'=>str_replace(',','',$value['juchuu_money_h']), 
                        'kyuuyo_shiharai' => 1, 'kyuuyo_money'=>str_replace(',','',$value['staff_money_h']), 'modified'=>'"'.date("Y-m-d H:i:s").'"');
                    $conditions8 = array('class' => $value['class'], 'order_id' => $value['order_id'], 'shokushu_num' => $value['shokushu_num']);
                    //$result = $this->OrderInfoDetail->find('first', array('conditions'=>$conditions8));
                    //if (empty($result['OrderInfoDetail']['kyuuyo_money']) && empty($result['OrderInfoDetail']['kyuuyo_money'])) {
                        if ($this->OrderInfoDetail->updateAll($data7, $conditions8)) {
                            $this->Session->setFlash('【エラー】保存に失敗しました。');
                        }
                    //}
                }
                //$this->log($this->OrderInfoDetail->getDataSource()->getLog(), LOG_DEBUG);
                // 「保存」の場合
                if ($mode == 1) {
                    $this->Session->setFlash('【情報】保存を完了しました。');
                    // ログ書き込み
                    $this->setShiftLog($username, $selected_class, '', 11);
                }
                // セッション削除
                $this->Session->delete('staff_cell');
                // 重複チェック
                if ($mode == 2 || $mode == 3) {
                    //$this->log($data2, LOG_DEBUG);
                    for ($d=1; $d<=31; $d++) {
                        $check_arr = null;
                        $value_arr = null;
                        foreach($data2 as $value) {
                            if (empty($value['d'.$d])) {
                                continue;
                            }
                            $value_arr = explode(',', $value['d'.$d]);
                            foreach($value_arr as $val) {
                                $check_arr[] = $val;
                            }
                        }
                        //$this->log($check_arr, LOG_DEBUG);
                        // チェック処理
                        if ($mode == 3) {
                            $commet2 = '確定できません。';
                            $status = 25;
                        } else {
                            $commet2 = '';
                            $status = 22;
                        }
                        if ($this->array_isunique($check_arr) != false) {
                            $data9 = $this->StaffMaster->find('first', array('conditions'=>array('id'=>key($this->array_isunique($check_arr)))));
                            $this->Session->setFlash('【エラー】'.date('n', strtotime($data['month'])).'/'.$d.'に'.$data9['StaffMaster']['name_sei'].$data9['StaffMaster']['name_mei'].'さんが重複しています。'.$commet2);
                            $this->redirect(array('action'=>'schedule', '?date='.date('Y-m', strtotime($data['month']))));
                            // ログ書き込み
                            $this->setShiftLog($username, $selected_class, '', $status);
                            return;
                        }
                    }
                    if ($mode == 2) {
                        $this->Session->setFlash('【情報】重複はありません。');
                        // ログ書き込み
                        $this->setShiftLog($username, $selected_class, '', 12);
                    } elseif ($mode == 3) {
                        if ($data['flag'] == 0) {
                            $flag2 = 1;
                            $commet = '【情報】当月シフトを確定しました。';
                            $status = 15;
                            /** シフト確定のお知らせメール **/
                            /**
                            $email = new CakeEmail('system');                        // インスタンス化
                            $email->from(array('system@softlife.biz' => '㈱ソフトライフ'));  // 送信元
                            $email->to(array('yokoi-masahiro@softlife.co.jp', 'crossroads.2009@gmail.com'));                      // 送信先
                            $email->subject('【派遣管理システム】シフト確定のお知らせ（自動送信メール）');                      // メールタイトル
                            if ($selected_class = 11) {
                                $area = '大阪';
                            } elseif ($selected_class = 21) {
                                $area = '東京';
                            } elseif ($selected_class = 31) {
                                $area = '名古屋';
                            }
                            $text = $area.'の'.date('Y年n月度', strtotime($data['month'])).'のシフトを確定いたしました。';
                            $email->send($text);                             // メール本文送信
                             * 
                             */
                        } else {
                            $flag2 = 0;
                            $commet = '【情報】当月シフトの確定解除を行いました。';
                            $status = 16;
                        }
                        // 該当月を確定
                        $data4 = array(
                            'flag' => $flag2,
                            //'modified' => "'" . date("Y-m-d H:i:s") . "'",
                        );
                        $conditions8 = array('class' => $selected_class, 'month' => $data['month']);
                        if ($this->WorkTable->updateAll($data4, $conditions8)) {
                            //$this->log($this->WorkTable->getDataSource()->getLog(), LOG_DEBUG);
                            // 成功
                            $this->Session->setFlash($commet);
                            // ログ書き込み
                            $this->setShiftLog($username, $selected_class, '', $status);

                            /** 確定シフトテーブルの更新 **/
                            if ($flag2 == 1) {
                                /** スタッフスケジュールの抽出実行 **/
                                $conditions4 = array('class' => $selected_class, 'month' => $month2);
                                $datas10 = $this->WorkTable->find('all', array('conditions'=>$conditions4));
                                $this->log($this->WorkTable->getDataSource()->getLog(), LOG_DEBUG);
                                $data_schedules = null;
                                $case_ids = null;
                                foreach ($datas10 as $key=>$data) {
                                    for ($d=1; $d<=31; $d++) {
                                        if (empty($data['WorkTable']['d'.$d])) {
                                            continue;
                                        }
                                        if (empty($data_schedules[$data['WorkTable']['d'.$d]])) {
                                            $data4 = $this->StaffMaster->find('first', array('conditions'=>array('id'=>$data['WorkTable']['d'.$d])));
                                            $data_schedules[$data['WorkTable']['d'.$d]] = array(
                                                'class'=>$data['WorkTable']['class'],
                                                'month'=>$data['WorkTable']['month'],
                                                'staff_id'=>$data['WorkTable']['d'.$d], 
                                                'name'=>$data4['StaffMaster']['name_sei'].' '.$data4['StaffMaster']['name_mei'], 
                                                'name2'=>$data4['StaffMaster']['name_sei2'].' '.$data4['StaffMaster']['name_mei2'], 
                                                'case_id'=>null,
                                                'shokushu_id'=>null
                                                    );
                                        }
                                        $data_schedules[$data['WorkTable']['d'.$d]]['c'.$d] = array(
                                            $data['WorkTable']['case_id'],          // 'case_id'=>
                                            $data['WorkTable']['order_id'],         // 'order_id'=>
                                            $data['WorkTable']['shokushu_num'],     // 'shokushu_num'=>
                                            $data['WorkTable']['shokushu_id'],      // 'shokushu_id'=>
                                            $data['WorkTable']['ap'.$d]             // 'appointment'=>
                                                );
                                    }
                                }
                                if (!empty($data_schedules)) {
                                    // 案件、職種の集計
                                    foreach ($data_schedules as $sid=>$data2) {
                                        $case_ids = null;
                                        $shokushu_ids = null;
                                        for ($d=1; $d<=31; $d++) {
                                            // カンマ区切り用
                                            if (!empty($data2['c'.$d])) {
                                                $case_ids[$key][] = $data2['c'.$d][0];
                                                $shokushu_ids[$key][] = $data2['c'.$d][3];
                                                $data_schedules[$sid]['c'.$d] = implode(',', $data2['c'.$d]);
                                            }
                                        }
                                        $case_ids2 = implode(',', array_unique($case_ids[$key]));
                                        $shokushu_ids2 = implode(',', array_unique($shokushu_ids[$key]));
                                        $data_schedules[$sid]['case_id'] = $case_ids2;
                                        $data_schedules[$sid]['shokushu_id'] = $shokushu_ids2;
                                    }
                                    // 今あるデータを削除
                                    $conditions = array('class' => $selected_class, 'month' => $month2);
                                    $this->WkSchedule->deleteAll($conditions, false);
                                    // ワークテーブルに保存
                                    $this->WkSchedule->saveAll($data_schedules);
                                }
                                $this->log('ここ', LOG_DEBUG);
                            } elseif ($flag2 == 0) {
                                // 今あるデータを削除
                                $conditions = array('class' => $selected_class, 'month' => $month2);
                                $this->WkSchedule->deleteAll($conditions, false);
                                $this->log('解除', LOG_DEBUG);
                            }
                        }
                    }
                }
                $this->redirect(array('action'=>'schedule', '?date='.date('Y-m', strtotime($month2))));
            /** シフトの全クリア **/
            } elseif (isset($this->request->data['all_clear'])) {
                // 該当月を削除
                $param = array('class' => $selected_class, 'month' => $data['month']);
                if ($this->WorkTable->deleteAll($param)) {
                    // 成功
                    $this->Session->setFlash('【情報】シフトを全クリアしました。');
                    // セッション削除
                    $this->Session->delete('staff_cell');
                    $this->redirect(array('action'=>'schedule', '?date='.date('Y-m', strtotime($data['month']))));
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
        /**
         * ここからGETの処理
         */
        } elseif ($this->request->is('get')) {
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
                $this->log('セッションあり', LOG_DEBUG);
                //$this->log($staff_cell2, LOG_DEBUG);
                $this->set('staff_cell', $staff_cell2);
            } else {
                for($i=1; $i<$record+1; $i++) {
                    $conditions1 = array('class'=>$selected_class, 'month'=>$year.'-'.$month.'-01', 
                        'order_id'=>$datas2[$i-1]['OrderInfoDetail']['order_id'], 'shokushu_num'=>$datas2[$i-1]['OrderInfoDetail']['shokushu_num']);
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
                $this->log('セッションなし', LOG_DEBUG);
                //$this->log($this->Session->read('staff_cell'), LOG_DEBUG);
            }
            // 氏名のセット
            if (empty($staff_cell)) {
                $this->set('data_staffs', null);
            } else {
                for($d=1; $d<=31; $d++) {
                    for($i=1; $i<200; $i++) {
                        if (empty($staff_cell[$d][$i])) {
                            continue;
                        }
                        foreach ($staff_cell[$d][$i] as $key=>$staff_id) {
                            $conditions1 = array('id'=>$staff_id);
                            $data_staffs[$d][$i][$key] = $this->StaffMaster->find('first', array('fields'=>array('id', 'name_sei', 'name_mei'), 'conditions'=>$conditions1));
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
                for($i=1; $i<$record+1; $i++) {
                    $conditions1 = array('class'=>$selected_class, 'month'=>$month.'-01', 'order_id'=>$datas2[$i-1]['OrderInfoDetail']['order_id'], 'shokushu_num'=>$datas2[$i-1]['OrderInfoDetail']['shokushu_num']);
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
        /**
         *  シフト希望スタッフのポイント
         */
        $conditions6 = array(
            'StaffSchedule.class'=>$selected_class, 
            'work_date >= '=>$year.'-'.$month.'-01',
            'work_date <= '=>$year.'-'.$month.'-31',
            'OR'=>array(array('work_flag'=>1), array('work_flag'=>2))
            );
        $request_staffs = $this->StaffSchedule->find('all', array('conditions'=>$conditions6, 'order'=>array('point', 'staff_id')));
        //$this->log($request_staffs, LOG_DEBUG);
        /**
        if (empty($request_staffs)) {
            $this->Session->setFlash('【情報】スタッフからのシフト希望がないので、割付できません。');
            $this->redirect(array('?date='.$this->request->query('date')));
        }
         * 
         */
        for($i=0; $i<$record; $i++) {
            $conditions7 = array(
                'class'=>$selected_class, 
                'month'=>$year.'-'.$month.'-01',
                'order_id'=>$datas2[$i]['OrderInfoDetail']['order_id'],
                'shokushu_num'=>$datas2[$i]['OrderInfoDetail']['shokushu_num'],
                );
            $datas5[$i] = $this->WkShift->find('first', array('conditions'=>$conditions7));
        }
        //$this->log($datas5, LOG_DEBUG);
        foreach($request_staffs as $key=>$data6) {
            $id = $data6['StaffSchedule']['id'];
            $staff_id = $data6['StaffSchedule']['staff_id'];
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
            //$this->log($staff_id.':'.$point, LOG_DEBUG);
            $data6 = array('point'=>$point);
            $this->StaffSchedule->id = $id;
            $this->StaffSchedule->save($data6);
        }
    }
 
    /**
     * 確定シフト（スタッフ別）
     */
    public function schedule2($date = null) {
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
        // 引数の受け取り
        if (isset($this->params['named']['limit'])) {
            $limit = $this->params['named']['limit'];
        } else {
            $limit = '20';
        }
        // 月の取得
        if (isset($this->request->query['date'])) {
            $date2 = $this->request->query['date'];
            $month = str_replace('-', '', $this->request->query['date']);
        } elseif (isset ($date)) {
            $month = str_replace('-', '', $date);
            $date2 = date('Y-m', strtotime($date.'01'));
        } else {
            //$month = date('Ym');
            $month = date('Ym', strtotime('+1 month'));
            $date2 = date('Y-m', strtotime('+1 month'));
        }
        $this->set('month', $month);
        $this->set('date2', $date2);
        //$this->log($month, LOG_DEBUG);
        // 表示件数の初期値
        $this->set('limit', $limit);
        // 案件情報
        $conditions0 = array('class'=>$selected_class);
        $datas1 = $this->CaseManagement->find('all', array('conditions'=>$conditions0));
        $list_case = null;
        foreach($datas1 as $key=>$data1) {
            $list_case[$data1['CaseManagement']['id']] = array('case_name'=>$data1['CaseManagement']['case_name'],
                'bgcolor'=>$data1['CaseManagement']['bgcolor'],'color'=>$data1['CaseManagement']['color']);
        }
        $this->set('list_case', $list_case);
        // 案件リスト
        $list_case2 = $this->CaseManagement->find('list', array('fields'=>array('id', 'case_name'), 'conditions'=>$conditions0, 'order'=>array('sequence'=>'asc')));
        $this->set('list_case2', $list_case2);
        // スタッフの抽出条件
        $joins = array(
            array(
                'type' => 'left',// innerもしくはleft
                'table' => 'staff_'.$selected_class,
                'alias' => 'StaffMaster',
                'conditions' => array(
                    'WkSchedule.staff_id = StaffMaster.id',
                )    
            )
        );
        $options = array(
            'fields'=> array('WkSchedule.*', 'StaffMaster.*'),
            'conditions' => array(
                'WkSchedule.class' => $selected_class,
                'WkSchedule.month' => $month.'01',
                ),
            'limit' => $limit,
            //'group' => array('staff_id'),
            'joins' => $joins
        );

        // POSTの場合
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->log($this->request->data, LOG_DEBUG);
            $conditions2 = null;
            if (isset($this->data['search'])) {
                // 氏名での検索
                if (!empty($this->data['WkSchedule']['search_name'])){
                    $search_name = $this->data['WkSchedule']['search_name'];
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
            } elseif (!empty($this->data['WkSchedule']['search_shokushu'])){
                $search_shokushu = $this->data['WkSchedule']['search_shokushu'];
                $options['conditions'] += array('FIND_IN_SET('.$search_shokushu.', WkSchedule.shokushu_id)');
            // 案件
            } elseif (!empty($this->data['WkSchedule']['search_case'])){
                $search_case = $this->data['WkSchedule']['search_case'];
                $options['conditions'] += array('FIND_IN_SET('.$search_case.', WkSchedule.case_id)');
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
            $this->log($options, LOG_DEBUG);
            $datas2 = $this->paginate('WkSchedule');
            $this->set('datas2', $datas2);
        } else {
            // ページネーション
            $this->paginate = $options;
            $datas2 = $this->paginate('WkSchedule');
            //$this->log($this->StaffSchedule->getDataSource()->getLog(), LOG_DEBUG);
            $this->set('datas2', $datas2);
            //$this->log($datas2, LOG_DEBUG);
        }
        
    }
    
    /**
     * スタッフ別スケジュール
     */
    public function check_schedule($staff_id = null) {
        // レイアウト関係
        $this->layout = "sub";
        $this->set("title_for_layout", $this->title_for_layout);
        // 初期セット
        $username = $this->Auth->user('username').' '.$this->Auth->user('name_mei');
        $this->set('username', $username);
        $selected_class = $this->Session->read('selected_class');
        $this->set('selected_class', $selected_class);
        $this->set('datas1', null);
        if (empty($staff_id)) {
            //$staff_id = $this->Session->read('schedule_staff'); 
        }
        $this->set('staff_id', $staff_id);
        $datas2 = null;
        //$this->Session->write('staff_cell', $staff_cell);
        // 職種マスタ配列
        $conditions0 = array('item' => 17);
        $shokushu_arr = $this->Item->find('list', array('fields' => array('id', 'value'), 'conditions' => $conditions0));
        $this->set('shokushu_arr', $shokushu_arr);
        // テーブルの設定
        $this->StaffMaster->setSource('staff_'.$selected_class);
        // 該当月
        if (!empty($this->request->query('date'))) {
            $date = $this->request->query('date');
            //$this->log($date, LOG_DEBUG);
            $date_arr = explode('-',$date);
            $year = $date_arr[0];
            $month = $date_arr[1];
        } else {
            $year = date('Y', strtotime('+1 month'));
            $month = date('n', strtotime('+1 month'));
            $date = $year.'-'.$month;
        }
        $this->set('date', $date);
        // 案件リスト
        $conditions1 = array('class'=>$selected_class);
        $list_case2 = $this->CaseManagement->find('list', array('fields'=>array('id', 'case_name'), 'conditions'=>$conditions1, 'order'=>array('sequence'=>'asc')));
        $list_case2 += array(''=>'');
        $this->set('list_case2', $list_case2);
        
        // post時の処理
        if ($this->request->is('post') || $this->request->is('put')) {
            //$this->log($this->request->data, LOG_DEBUG);
            // 検索
            if (isset($this->request->data['search'])) {
                $search_name = $this->data['StaffSchedule']['search_name'];
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
                    $datas1 = $this->StaffMaster->find('all', array('conditions'=>array('OR'=>array($conditions1, $conditions2)), 'order'=>array('id')));
                    //$this->log($this->StaffMaster->getDataSource()->getLog(), LOG_DEBUG);
                    $this->set('datas1', $datas1);
                }
            // 選択
            } elseif (isset($this->request->data['select'])) {
                $id_array = array_keys($this->request->data['select']);
                $id = $id_array[0];
                // 選択は一つだけ
                $staff_id = $this->Session->read('schedule_staff');
                if (count($staff_id) == 1) {
                    $this->Session->setFlash('【エラー】すでにスタッフが選択されています。');
                    $this->redirect(array('action' => 'input_schedule', $staff_id ));
                    return;
                }
                // セッション格納
                $this->Session->write('schedule_staff', $id);
                // 選択中スタッフ
                $this->StaffMaster->virtualFields['name'] = 'CONCAT(name_sei, " ", name_mei)';
                $datas2 = $this->StaffMaster->find('first', array('fields'=>array('*', 'name'), 'conditions'=>array('id'=>$id)));
                $this->set('datas2', $datas2);
                //$this->log($datas2, LOG_DEBUG);
                $this->redirect(array('action'=>'input_schedule', $id));
            // 消去
            } elseif (isset($this->request->data['erasure'])) {
                // セッション削除
                $this->Session->delete('schedule_staff');
                $this->redirect(array('action'=>'input_schedule'));
            // 登録
            } elseif (isset($this->request->data['commit'])) {
                if ($this->StaffSchedule->saveAll($this->request->data['StaffSchedule'])) {
                    $this->StaffMaster->virtualFields['name'] = 'CONCAT(name_sei, " ", name_mei)';
                    $datas = $this->StaffMaster->find('first', array('fields'=>array('*', 'name'), 'conditions'=>array('id'=>$staff_id)));
                    // ログ書き込み
                    $this->setShiftLog($username, $selected_class, 
                            'シフト希望：'.$datas['StaffMaster']['name'].'('.$staff_id.') '.  str_replace('-', '年', $date).'月分', 1);
                    $this->Session->setFlash('【情報】シフト希望を登録いたしました。');
                    $this->redirect(array('action'=>'input_schedule', $staff_id, '?date='.$date));
                }
            } else {
                
            }
        } elseif ($this->request->is('get')) {

        } else {
            
        }
        
        // 選択済みスタッフ
        //$staff_id = $this->Session->read('schedule_staff');
        $this->StaffMaster->virtualFields['name'] = 'CONCAT(name_sei, " ", name_mei)';
        $data2 = $this->StaffMaster->find('first', array('fields'=>array('*', 'name'), 'conditions'=>array('id'=>$staff_id)));
        $this->set('data2', $data2);
        //$this->log($data2, LOG_DEBUG);
        // 登録済みデータ
        $conditions3 = array('staff_id'=>$staff_id, 'class'=>$selected_class, 'month'=>$year.'-'.$month.'-01');
        $datas3 = $this->WkSchedule->find('all', array('conditions'=>$conditions3));
        $this->set('datas3', $datas3);
        $this->log($datas3, LOG_DEBUG);
        
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
        // 所属
        $conditions0 = array('item' => 2);
        $list_class = $this->Item->find('list', array('fields' => array('id', 'value'), 'conditions' => $conditions0));
        $this->set('list_class', $list_class);
        // 案件リスト
        $conditions1 = array('class'=>$selected_class);
        $list_case2 = $this->CaseManagement->find('list', array('fields'=>array('id', 'case_name'), 'conditions'=>$conditions1, 'order'=>array('sequence'=>'asc')));
        $list_case2 += array(''=>'');
        $this->set('list_case2', $list_case2);
        // 引数の受け取り
        if (isset($this->params['named']['limit'])) {
            $limit = $this->params['named']['limit'];
        } else {
            $limit = '20';
        }
        $this->set('limit', $limit);
        // 該当月
        if (!empty($this->request->query('date'))) {
            $date = $this->request->query('date');
            //$this->log($date, LOG_DEBUG);
            $date_arr = explode('-',$date);
            $year = $date_arr[0];
            $month = $date_arr[1];
        } else {
            $year = date('Y', strtotime('+1 month'));
            $month = date('n', strtotime('+1 month'));
            $date = $year.'-'.$month;
        }
        $this->set('date', $date);
        // スタッフの抽出条件
        $joins = array(
            array(
                'type' => 'left',// innerもしくはleft
                'table' => 'staff_'.$selected_class,
                'alias' => 'StaffMaster',
                'conditions' => array(
                    'TimeCard.staff_id = StaffMaster.id',
                )    
            )
        );
        $options = array(
            'fields'=> array('TimeCard.*', 'StaffMaster.name_sei', 'StaffMaster.name_mei', 
                'StaffMaster.name_sei2', 'StaffMaster.name_mei2', 'StaffMaster.shokushu_shoukai'),
            'conditions' => array(
                'TimeCard.class' => $selected_class,
                'TimeCard.work_date >=' => $date.'-01',
                'TimeCard.work_date <= ' => $date.'-31',
                ),
            'limit' => $limit,
            //'group' => array('staff_id'),
            'joins' => $joins
        );
        $this->paginate = $options;
        // データ
        $this->set('datas', $this->paginate('TimeCard'));
        
        $this->log($this->request->data, LOG_DEBUG);
        // post時の処理
        if ($this->request->is('post') || $this->request->is('put')) {
            if (1 == 1) {
                
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
        } elseif ($this->request->is('get')) {
            
        } else {
            
        }
        
    }
    
    /**
     * 設定
     */
    public function setting($id = null, $id2 = null, $row =null, $direction = null) {
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
        //$this->StaffMaster->setSource('staff_'.$selected_class);
        //$this->WorkTable->setSource('work_tables');
        // レコード数
        $option = array(
            'conditions' => array('class' => $selected_class),
            'limit' => '30',
            'order' => array('sequence' => 'asc', 'id' => 'asc'));
        $record = $this->CaseManagement->find('count', $option);
        $this->set('record', $record);
        //$this->log($record, LOG_DEBUG);
        // 

        $this->log($this->request->data, LOG_DEBUG);
        // post時の処理
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->CaseManagement->saveAll($this->request->data['CaseManagement']);
            $this->Session->setFlash('【情報】背景色の登録が完了しました。');
        } elseif ($this->request->is('get')) {
            // 順序の変更
            if ($direction == 'up') {
                if ($row == 1) {
                    return;
                }
                // $idを$row-1
                $data = array('CaseManagement' => array('id' => $id, 'sequence' => $row-1));
                $fields = array('sequence');
                $this->CaseManagement->save($data, false, $fields);
                $data_2 = array('sequence' => $row-1);
                $condtion = array('case_id' => $id );
                $this->OrderCalender->updateAll($data_2, $condtion);
                // $id2を$row
                $data2 = array('CaseManagement' => array('id' => $id2, 'sequence' => $row));
                $fields2 = array('sequence');
                $this->CaseManagement->save($data2, false, $fields2);
                $data2_2 = array('sequence' => $row);
                $condtion2 = array('case_id' => $id2 );
                $this->OrderCalender->updateAll($data2_2, $condtion2);
            } elseif ($direction == 'down') {
                if ($row == $record) {
                    return;
                }
                // $idを$row+1
                $data = array('CaseManagement' => array('id' => $id, 'sequence' => $row+1));
                $fields = array('sequence');
                $this->CaseManagement->save($data, false, $fields);
                $data_2 = array('sequence' => $row+1);
                $condtion = array('case_id' => $id );
                $this->OrderCalender->updateAll($data_2, $condtion);
                // $id2を$row
                $data2 = array('CaseManagement' => array('id' => $id2, 'sequence' => $row));
                $fields2 = array('sequence');
                $this->CaseManagement->save($data2, false, $fields2);
                $data2_2 = array('sequence' => $row);
                $condtion2 = array('case_id' => $id2 );
                $this->OrderCalender->updateAll($data2_2, $condtion2);
            }
        } else {

        }
        // 案件マスタ
        $this->paginate = $option;
        $this->set('datas', $this->paginate('CaseManagement'));
    }

    /**
     * スタッフシフト希望手動入力
     * @param type $order_id
     * @param type $col
     * @param type $cell_row
     * @param type $cell_col
     * @param type $shokushu_num
     */
    public function input_schedule($staff_id = null) {
        // レイアウト関係
        $this->layout = "sub";
        $this->set("title_for_layout", $this->title_for_layout);
        // 初期セット
        $username = $this->Auth->user('username').' '.$this->Auth->user('name_mei');
        $this->set('username', $username);
        $selected_class = $this->Session->read('selected_class');
        $this->set('selected_class', $selected_class);
        $this->set('datas1', null);
        if (empty($staff_id)) {
            //$staff_id = $this->Session->read('schedule_staff'); 
        }
        $this->set('staff_id', $staff_id);
        $datas2 = null;
        //$this->Session->write('staff_cell', $staff_cell);
        // 職種マスタ配列
        $conditions0 = array('item' => 17);
        $shokushu_arr = $this->Item->find('list', array('fields' => array('id', 'value'), 'conditions' => $conditions0));
        $this->set('shokushu_arr', $shokushu_arr);
        // テーブルの設定
        $this->StaffMaster->setSource('staff_'.$selected_class);
        // 該当月
        if (!empty($this->request->query('date'))) {
            $date = $this->request->query('date');
            //$this->log($date, LOG_DEBUG);
            $date_arr = explode('-',$date);
            $year = $date_arr[0];
            $month = $date_arr[1];
        } else {
            $year = date('Y', strtotime('+1 month'));
            $month = date('n', strtotime('+1 month'));
            $date = $year.'-'.$month;
        }
        $this->set('date', $date);
        /**
        $month = ltrim($month, '0');
        $this->set('year', $year);
        $this->set('month', ltrim($month, '0'));
         * 
         */
        
        // post時の処理
        if ($this->request->is('post') || $this->request->is('put')) {
            //$this->log($this->request->data, LOG_DEBUG);
            // 検索
            if (isset($this->request->data['search'])) {
                $search_name = $this->data['StaffSchedule']['search_name'];
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
                    $datas1 = $this->StaffMaster->find('all', array('conditions'=>array('OR'=>array($conditions1, $conditions2)), 'order'=>array('id')));
                    //$this->log($this->StaffMaster->getDataSource()->getLog(), LOG_DEBUG);
                    $this->set('datas1', $datas1);
                }
            // 選択
            } elseif (isset($this->request->data['select'])) {
                $id_array = array_keys($this->request->data['select']);
                $id = $id_array[0];
                // 選択は一つだけ
                $staff_id = $this->Session->read('schedule_staff');
                if (count($staff_id) == 1) {
                    $this->Session->setFlash('【エラー】すでにスタッフが選択されています。');
                    $this->redirect(array('action' => 'input_schedule', $staff_id ));
                    return;
                }
                // セッション格納
                $this->Session->write('schedule_staff', $id);
                // 選択中スタッフ
                $this->StaffMaster->virtualFields['name'] = 'CONCAT(name_sei, " ", name_mei)';
                $datas2 = $this->StaffMaster->find('first', array('fields'=>array('*', 'name'), 'conditions'=>array('id'=>$id)));
                $this->set('datas2', $datas2);
                //$this->log($datas2, LOG_DEBUG);
                $this->redirect(array('action'=>'input_schedule', $id));
            // 消去
            } elseif (isset($this->request->data['erasure'])) {
                // セッション削除
                $this->Session->delete('schedule_staff');
                $this->redirect(array('action'=>'input_schedule'));
            // 登録
            } elseif (isset($this->request->data['commit'])) {
                if ($this->StaffSchedule->saveAll($this->request->data['StaffSchedule'])) {
                    $this->StaffMaster->virtualFields['name'] = 'CONCAT(name_sei, " ", name_mei)';
                    $datas = $this->StaffMaster->find('first', array('fields'=>array('*', 'name'), 'conditions'=>array('id'=>$staff_id)));
                    // ログ書き込み
                    $this->setShiftLog($username, $selected_class, 
                            'シフト希望：'.$datas['StaffMaster']['name'].'('.$staff_id.') '.  str_replace('-', '年', $date).'月分', 1);
                    $this->Session->setFlash('【情報】シフト希望を登録いたしました。');
                    $this->redirect(array('action'=>'input_schedule', $staff_id, '?date='.$date));
                }
            } else {
                
            }
        } elseif ($this->request->is('get')) {

        } else {
            
        }
        
        // 選択済みスタッフ
        //$staff_id = $this->Session->read('schedule_staff');
        $this->StaffMaster->virtualFields['name'] = 'CONCAT(name_sei, " ", name_mei)';
        $data2 = $this->StaffMaster->find('first', array('fields'=>array('*', 'name'), 'conditions'=>array('id'=>$staff_id)));
        $this->set('data2', $data2);
        //$this->log($data2, LOG_DEBUG);
        // 登録済みデータ
        $conditions3 = array('staff_id'=>$staff_id, 'class'=>$selected_class, 'work_date >='=>$year.'-'.$month.'-01', 'work_date <='=>$year.'-'.$month.'-31');
        $datas3 = $this->StaffSchedule->find('all', array('conditions'=>$conditions3));
        $this->set('datas3', $datas3);
        //$this->log($datas3, LOG_DEBUG);
        
    }

    /**
     * 稼働表出力
     */
    public function output_excel() {
        // レイアウト関係
        $this->layout = "excel";
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
        // 職種マスタ配列
        $conditions0 = array('item' => 17);
        $shokushu_arr = $this->Item->find('list', array('fields' => array('id', 'value'), 'conditions' => $conditions0));
        $this->set('shokushu_arr', $shokushu_arr);
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
        // 日付
        $this->set('year', date('Y', strtotime($month)));
        $this->set('month', date('n', strtotime($month)));
        $this->set('day', $cell_row);
        $date = $month.'-'.$cell_row;
        $datetime = new DateTime($date);
        $week = array("日", "月", "火", "水", "木", "金", "土");
        $w = (int)$datetime->format('w');
        $this->set('week', $week[$w]);

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
                    $datas1 = $this->StaffMaster->find('all', array('conditions'=>array('OR'=>array($conditions1, $conditions2)), 'order'=>array('id')));
                    //$this->log($this->StaffMaster->getDataSource()->getLog(), LOG_DEBUG);
                    $this->set('datas1', $datas1);
                }
            // 選択
            } elseif (isset($this->request->data['select'])) {
                $id_array = array_keys($this->request->data['select']);
                $id = $id_array[0];
                // 選択は1つまで
                //$session_id = $this->Session->read('staff_cell');
                if (!empty($this->request->data['staff_id40'])) {
                    $this->Session->setFlash('【エラー】選択できるのは1つだけです。');
                    $this->redirect(array('action'=>'select', $order_id, $col, $cell_row, $cell_col, $shokushu_num, '?date='.$month));
                    return;
                }
                // セッション格納
                if (empty($staff_cell[$cell_row][$cell_col])) {
                    $staff_cell[$cell_row][$cell_col][0] = $id;
                } else {
                    $flag = false;
                    //$this->log($staff_cell[$cell_row][$cell_col], LOG_DEBUG);
                    for($i=0; $i<20 ;$i++) {
                        if (empty($staff_cell[$cell_row][$cell_col][$i])) {
                            continue;
                        }
                        // 重複はエラー
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
            // 待ち合わせ登録
            } elseif (isset($this->request->data['register'])) {
                $id_array = array_keys($this->request->data['register']);
                $id = $id_array[0];
                
                // 待ち合わせ登録
                if (empty($this->request->data['StaffMaster']['appointment_memo'])) {
                    if (empty($this->request->data['StaffMaster']['appointment'])) {
                        $value = '';
                    } else {
                        $value = $this->request->data['StaffMaster']['appointment'];
                    }
                } else {
                    $value = $this->request->data['StaffMaster']['appointment_memo'];
                }
                $data = array(
                    'ap'.$cell_row => '"'.$value.'"',
                );
                $conditions = array(
                    'order_id' => $order_id,
                    'shokushu_num' => $shokushu_num,
                    'month' => $month.'-01'
                );
                $data1 = array('WorkTable'=>array('order_id'));
                if ($this->WorkTable->updateAll($data, $conditions)) {
                    $this->Session->setFlash('【情報】待ち合わせに登録しました。');
                    $this->redirect(array('action'=>'select', $order_id, $col, $cell_row, $cell_col, $shokushu_num, '?date='.$month));
                }
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
            if (empty($value['StaffMaster']['id'])) {
                $key_id[$key] = '';
            } else {
                $key_id[$key] = $value['StaffMaster']['id'];
            }
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
        //$shokushu_id = $data1['WkShift']['shokushu_id'];
        $conditions6 = array(
            'StaffSchedule.class'=>$selected_class,
            'work_date'=>$month.'-'.$cell_row,
            //'FIND_IN_SET('.$shokushu_id.', shokushu_id)',
            'work_flag'=>1
            );
        $joins = array(
        array(
            'type' => 'LEFT',   //LEFT, INNER, OUTER
            'table' => 'staff_'.$selected_class,
            'alias' => 'StaffMaster',    //下でPost.user_idと書くために
            'conditions' => array('StaffSchedule.staff_id = StaffMaster.id')
            ),
        );
        $datas3 = $this->StaffSchedule->find('all', array('fields'=>array('StaffSchedule.*','StaffMaster.name_sei','StaffMaster.name_mei','StaffMaster.shokushu_shoukai'), 
            'conditions'=>$conditions6, 'joins'=>$joins));
        //$this->log($datas3, LOG_DEBUG);
        if (!empty($datas3)) {
            $key_point = null;
            $key_staff_id = null;
            foreach ($datas3 as $key => $value){
                $key_staff_id[$key] = $value['StaffSchedule']['staff_id'];
                $point_arr = explode(',', $value['StaffSchedule']['point']);
                if (empty($point_arr[$cell_col-1])) {
                    $key_point[$key] = 0;
                } else {
                    $key_point[$key] = $point_arr[$cell_col-1];
                }
            }
            array_multisort ( $key_point , SORT_DESC , $key_staff_id , SORT_ASC , $datas3 );
        }
        $this->set('request_staffs', $datas3 );
        // 条件付きスタッフ
        $conditions7 = array(
            'StaffSchedule.class'=>$selected_class,
            'StaffSchedule.work_date'=>$month.'-'.$cell_row,
            //'FIND_IN_SET('.$shokushu_id.', shokushu_id)',
            'StaffSchedule.work_flag'=>2
            );
        $datas4 = $this->StaffSchedule->find('all', array('fields'=>array('StaffSchedule.*','StaffMaster.name_sei','StaffMaster.name_mei','StaffMaster.shokushu_shoukai'), 
            'conditions'=>$conditions7, 'joins'=>$joins));
        if (!empty($datas4)) {
            $key_point = null;
            $key_staff_id = null;
            foreach ($datas4 as $key => $value){
                $key_staff_id[$key] = $value['StaffSchedule']['staff_id'];
                $point_arr = explode(',', $value['StaffSchedule']['point']);
                if (empty($point_arr[$cell_col-1])) {
                    $key_point[$key] = 0;
                } else {
                    $key_point[$key] = $point_arr[$cell_col-1];
                }
            }
            array_multisort ( $key_point , SORT_DESC , $key_staff_id , SORT_ASC , $datas4 );
        }
        $this->set('request_staffs2', $datas4 );
        
        // 選択済みスタッフ
        if (!empty($staff_cell[$cell_row][$cell_col])) {
            $this->StaffMaster->virtualFields['name'] = 'CONCAT(name_sei, " ", name_mei)';
            foreach($staff_cell[$cell_row][$cell_col] as $key=>$staff_id) {
                if (empty($staff_id)) {
                    continue;
                }
                if (empty($datas2)) {
                    $datas2[0] = $this->StaffMaster->find('first', array('fields'=>array('id', 'name'), 'conditions'=>array('id'=>$staff_id)));
                    $datas22[0] = $this->StaffSchedule->find('first', array('fields'=>array('conditions'), 'conditions'=>$conditions7 + array('staff_id'=>$datas2[0]['StaffMaster']['id']))); 
                } else {
                    $datas2[$key] = $this->StaffMaster->find('first', array('fields'=>array('conditions'), 'conditions'=>array('id'=>$staff_id)));
                    $datas22[$key] = $this->StaffSchedule->find('first', array('fields'=>array('conditions'), 'conditions'=>$conditions7 + array('staff_id'=>$datas2[$key]['StaffMaster']['id']))); 
                }
            }
            $this->set('datas2', $datas2);
            $this->set('datas22', $datas22);
        }
        // 待ち合わせ
        $conditions8 = array('order_id'=>$order_id, 'shokushu_num'=>$shokushu_num, 'month'=>$month.'-01');
        $data2 = $this->WorkTable->find('first', array('conditions' => $conditions8));
        $this->set('data_ap', $data2);
        
    }
    
    /**
     * 重複チェック
     * @param type $datas
     */
    function array_isunique($array){

            if(!is_array($array)){
                    return false;
            }

            $arrayValue = array_count_values($array);	//配列の値の数をカウントする
            $arraykey = array_keys($arrayValue,1);	//重複していない値のキーを取り出す

            for($i=0;$i<count($arraykey);$i++){
                    unset($arrayValue[$arraykey[$i]]);	//重複していない要素を削除
            }
            if(count($arrayValue)!=0){
                    return $arrayValue;
            }else{
                    return false;
            }
    }
    
    /** シフト作成ログ書き込み **/
    public function setShiftLog($username, $class, $remarks, $status) {
        // 登録する内容を設定
        $data = array('ShiftLog' => array('username' => $username, 'class' => $class, 'remarks' => $remarks, 'status' => $status, 'ip_address' => $this->request->clientIp()));
        // 登録する項目（フィールド指定）
        $fields = array('username', 'class', 'remarks', 'status', 'ip_address');
        // 新規登録
        $ret = $this->ShiftLog->save($data, false, $fields);
        
        return $ret;
    }
}
