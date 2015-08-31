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
    public $uses = array('StaffSchedule' ,'WorkTable' ,'Item', 'User', 'StaffMaster', 'CaseManagement');
    public $title_for_layout = "シフト管理 - 派遣管理システム";
    
    public function index() {
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
        } else {
            $month = date('Ym');
        }
        $this->log($month, LOG_DEBUG);
        
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
                // テーブル変更
                $this->StaffMaster->setSource('staff_'.$this->Session->read('selected_class'));
                $this->redirect(array('page' => 1));  
            // 表示件数の変更
            } elseif (isset($this->request->data['limit'])) {
                $limit = $this->request->data['limit'];
                $this->set('limit', $limit);
                $this->redirect(array('limit' => $limit));
            }
        } else {
            // スタッフの抽出
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
            $result = $this->StaffSchedule->find('all', array(
                'fields'=> array('StaffSchedule.staff_id', 'StaffMaster.name_sei', 'StaffMaster.name_mei'),
                'conditions' => array(
                    'StaffSchedule.class' => $selected_class,
                    'StaffSchedule.work_date >= '.$month.'01',
                    'StaffSchedule.work_date <= '.$month.'31',
                    ),
                'group' => array('staff_id'),
                'joins' => $joins
            ));
            //$this->log($result, LOG_DEBUG);
            $this->set('datas1', $result);
            // スタッフあたりのスケジュール
            if (!empty($result)) {
                foreach($result as $key => $val) {
                    // Paginationの設定
                    $this->paginate = array(
                        //モデルの指定
                        'StaffSchedule' => array(
                        //1ページ表示できるデータ数の設定
                        //'limit' =>15,
                        'fields' => array('*'),
                        //データを降順に並べる
                        'order' => array('id' => 'asc', 'staff_id' => 'asc'),
                        'conditions' => array('staff_id' => $val['StaffSchedule']['staff_id'])
                    ));
                    $data[$key] = $this->paginate();
                }
                $this->log($data, LOG_DEBUG);
                $this->set('datas2', $data);
            } else {
                $this->set('datas2', $this->paginate(null));
            }
            
            //$this->log($this->CaseManagement->getDataSource()->getLog(), LOG_DEBUG);
            //$this->log('そと通ってる', LOG_DEBUG);
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
        } else {
            $month = date('Ym');
        }
        $this->log($month, LOG_DEBUG);
        
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
                // テーブル変更
                $this->StaffMaster->setSource('staff_'.$this->Session->read('selected_class'));
                $this->redirect(array('page' => 1));  
            // 表示件数の変更
            } elseif (isset($this->request->data['limit'])) {
                $limit = $this->request->data['limit'];
                $this->set('limit', $limit);
                $this->redirect(array('limit' => $limit));
            }
        } else {
            // スタッフの抽出
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
            $result = $this->StaffSchedule->find('all', array(
                'fields'=> array('StaffSchedule.staff_id', 'StaffMaster.name_sei', 'StaffMaster.name_mei'),
                'conditions' => array(
                    'StaffSchedule.class' => $selected_class,
                    'StaffSchedule.work_date >= '.$month.'01',
                    'StaffSchedule.work_date <= '.$month.'31',
                    ),
                'group' => array('staff_id'),
                'joins' => $joins
            ));
            //$this->log($result, LOG_DEBUG);
            $this->set('datas1', $result);
            // スタッフあたりのスケジュール
            if (!empty($result)) {
                foreach($result as $key => $val) {
                    // Paginationの設定
                    $this->paginate = array(
                        //モデルの指定
                        'StaffSchedule' => array(
                        //1ページ表示できるデータ数の設定
                        //'limit' =>15,
                        'fields' => array('*'),
                        //データを降順に並べる
                        'order' => array('id' => 'asc', 'staff_id' => 'asc'),
                        'conditions' => array('staff_id' => $val['StaffSchedule']['staff_id'])
                    ));
                    $data[$key] = $this->paginate();
                }
                $this->log($data, LOG_DEBUG);
                $this->set('datas2', $data);
            } else {
                $this->set('datas2', $this->paginate(null));
            }
            
            //$this->log($this->CaseManagement->getDataSource()->getLog(), LOG_DEBUG);
            //$this->log('そと通ってる', LOG_DEBUG);
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
    public function test() {
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
        }
        //$this->log($staff_cell2, LOG_DEBUG);
        $this->set('staff_cell', $staff_cell2);
        // テーブルの設定
        $this->StaffMaster->setSource('staff_'.$selected_class);
        $this->WorkTable->setSource('work_tables');

        // post時の処理
        if ($this->request->is('post') || $this->request->is('put')) {
            //$this->log($this->request->data, LOG_DEBUG);
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
            for($i=1; $i<=200; $i++) {
                $conditions1 = array('class'=>$selected_class, 'work_date >= '=>$month.'01', 'work_date <= '=>$month.'31', 'column'=>$i);
                $results= $this->WorkTable->find('first', array('conditions'=>$conditions1));
                //$this->log($results, LOG_DEBUG);
                if (empty($results)) {
                    continue;
                }
                for($d=1; $d<=31; $d++) {
                    $staff_ids[$d][$i] = $results['WorkTable']['d'.$d];
                    $staff_ids2[$d][$i] = explode(',', $results['WorkTable']['d'.$d]);
                }
            }
            $this->set('staff_ids', $staff_ids);
            $this->log($staff_ids2, LOG_DEBUG);
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
            
            $staff_cell = $staff_ids2;
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
                $this->log($data_staffs, LOG_DEBUG);
                // セッション削除
                //$this->Session->delete('staff_cell');
            }
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
        $datas2 = null;
        $this->set('datas2', $datas2);
        $staff_cell = $this->Session->read('staff_cell');
        //$this->Session->write('staff_cell', $staff_cell);
        // テーブルの設定
        $this->StaffMaster->setSource('staff_'.$selected_class);
        
        // post時の処理
        if ($this->request->is('post') || $this->request->is('put')) {
            //$this->log($this->request->data, LOG_DEBUG);
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
                    //$this->log($this->StaffMaster->getDataSource()->getLog(), LOG_DEBUG);
                    $this->set('datas1', $datas1);
                }
                // 選択済みスタッフ
                $this->log($staff_cell, LOG_DEBUG);
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
                            break;
                        }
                    }
                    if (!$flag) {
                        $staff_cell[$cell_row][$cell_col][] += $id;
                    }
                }
                $this->log($staff_cell, LOG_DEBUG);
                $this->Session->write('staff_cell', $staff_cell);
                // 選択済みスタッフ
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
            // 消去
            } elseif (isset($this->request->data['erasure'])) {
                $staff_cell[$cell_row][$cell_col] = null;
                $this->Session->write('staff_cell', $staff_cell);
                //$this->Session->delete('staff_cell');
            } else {
                
            }
        } elseif ($this->request->is('get')) {
            // 選択済みスタッフ
            $this->log($staff_cell, LOG_DEBUG);
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
        } else {
            
        }
    }
}
