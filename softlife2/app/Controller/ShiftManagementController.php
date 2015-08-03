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
    public $uses = array('StaffSchedule', 'Item', 'User', 'StaffMaster');
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
                    'StaffSchedule.staff_id = StaffMaster.id', //ここ文字列なので注意
                    )    
                )
            );
            $result = $this->StaffSchedule->find('all', array(
                'fields'=> array('StaffSchedule.staff_id', 'StaffMaster.name_sei', 'StaffMaster.name_mei'),
                'conditions' => array('StaffSchedule.class' => $selected_class),
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

}
