<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

/**
 * CakePHP StaffMasterController
 * @author M-YOKOI
 */
class StaffMastersController extends AppController {
    public $uses = array('StaffMaster', 'User', 'Item', 'StaffMemo', 'StaffMasterLog');
    // Paginationの設定（スタッフマスタ）
    public $paginate = array(
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
    // Paginationの設定（スタッフ詳細） 
    public $paginate2 = array (
    //モデルの指定
    'StaffMaster' => array(
    //1ページ表示できるデータ数の設定
    'limit' =>1,
    //データを降順に並べる
    'order' => array('id' => 'asc'),
    )); 
    
    static public $selected_class;
    
    public $title_for_layout = "スタッフマスタ - 派遣管理システム";

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
        
        $this->log($this->request, LOG_DEBUG);
        // POSTの場合
        if ($this->request->is('post') || $this->request->is('put') || $this->request->is('get')) {
            // 初期表示
            if ($flag == 1) {
                $conditions2 = array('kaijo_flag' => 1);
            } else {
                $flag = 0;
                $conditions2 = array('kaijo_flag' => 0);
            }
            $this->set('flag', $flag);
            
            // 最寄り駅での絞り込み
            if(isset($this->request->data['search1'])) {
                // 駅コンボ値セット
                $line1 = $this->getLine($this->request->data['StaffMaster']['pref1']);
                $line2 = $this->getLine($this->request->data['StaffMaster']['pref2']);
                $line3 = $this->getLine($this->request->data['StaffMaster']['pref3']);
                $station1 = $this->getStation($this->request->data['StaffMaster']['s0_1']);
                $station2 = $this->getStation($this->request->data['StaffMaster']['s0_2']);
                $station3 = $this->getStation($this->request->data['StaffMaster']['s0_3']);
                
                if (!empty($this->request->data['StaffMaster']['s1_1']) && !empty($this->request->data['StaffMaster']['s2_1'])) {
                    $array_11 = array(array('StaffMaster.s1_1 >=' => $this->request->data['StaffMaster']['s1_1']), array('StaffMaster.s1_1 <= ' => $this->request->data['StaffMaster']['s2_1']));
                    $array_12 = array(array('StaffMaster.s1_2 >=' => $this->request->data['StaffMaster']['s1_1']), array('StaffMaster.s1_2 <= ' => $this->request->data['StaffMaster']['s2_1']));
                    $array_13 = array(array('StaffMaster.s1_3 >=' => $this->request->data['StaffMaster']['s1_1']), array('StaffMaster.s1_3 <= ' => $this->request->data['StaffMaster']['s2_1']));
                }
                if (!empty($this->request->data['StaffMaster']['s1_1']) && !empty($this->request->data['StaffMaster']['s2_1'])) {
                    $array_21 = array(array('StaffMaster.s1_1 >=' => $this->request->data['StaffMaster']['s1_2']), array('StaffMaster.s1_1 <= ' => $this->request->data['StaffMaster']['s2_2']));
                    $array_22 = array(array('StaffMaster.s1_2 >=' => $this->request->data['StaffMaster']['s1_2']), array('StaffMaster.s1_2 <= ' => $this->request->data['StaffMaster']['s2_2']));
                    $array_23 = array(array('StaffMaster.s1_3 >=' => $this->request->data['StaffMaster']['s1_2']), array('StaffMaster.s1_3 <= ' => $this->request->data['StaffMaster']['s2_2']));
                }
                if (!empty($this->request->data['StaffMaster']['s1_1']) && !empty($this->request->data['StaffMaster']['s2_1'])) {
                    $array_31 = array(array('StaffMaster.s1_1 >=' => $this->request->data['StaffMaster']['s1_3']), array('StaffMaster.s1_1 <= ' => $this->request->data['StaffMaster']['s2_3']));
                    $array_32 = array(array('StaffMaster.s1_2 >=' => $this->request->data['StaffMaster']['s1_3']), array('StaffMaster.s1_2 <= ' => $this->request->data['StaffMaster']['s2_3']));
                    $array_33 = array(array('StaffMaster.s1_3 >=' => $this->request->data['StaffMaster']['s1_3']), array('StaffMaster.s1_3 <= ' => $this->request->data['StaffMaster']['s2_3']));
                }
                $conditions2 += array('OR' =>
                    array($array_11, $array_12, $array_13,
                        $array_21, $array_22, $array_23,
                        $array_31, $array_32, $array_33)
                    );
                /**
                $conditions2 += array('OR' =>
                    array(
                        // 第一候補
                        array(array('StaffMaster.s1_1 >=' => $this->request->data['StaffMaster']['s1_1']), array('StaffMaster.s1_1 <= ' => $this->request->data['StaffMaster']['s2_1'])),
                        array(array('StaffMaster.s1_2 >=' => $this->request->data['StaffMaster']['s1_1']), array('StaffMaster.s1_2 <= ' => $this->request->data['StaffMaster']['s2_1'])),
                        array(array('StaffMaster.s1_3 >=' => $this->request->data['StaffMaster']['s1_1']), array('StaffMaster.s1_3 <= ' => $this->request->data['StaffMaster']['s2_1'])),
                        // 第二候補
                        array(array('StaffMaster.s1_1 >=' => $this->request->data['StaffMaster']['s1_2']), array('StaffMaster.s1_1 <= ' => $this->request->data['StaffMaster']['s2_2'])),
                        array(array('StaffMaster.s1_2 >=' => $this->request->data['StaffMaster']['s1_2']), array('StaffMaster.s1_2 <= ' => $this->request->data['StaffMaster']['s2_2'])),
                        array(array('StaffMaster.s1_3 >=' => $this->request->data['StaffMaster']['s1_2']), array('StaffMaster.s1_3 <= ' => $this->request->data['StaffMaster']['s2_2'])),
                        // 第三候補
                        array(array('StaffMaster.s1_1 >=' => $this->request->data['StaffMaster']['s1_3']), array('StaffMaster.s1_1 <= ' => $this->request->data['StaffMaster']['s2_3'])),
                        array(array('StaffMaster.s1_2 >=' => $this->request->data['StaffMaster']['s1_3']), array('StaffMaster.s1_2 <= ' => $this->request->data['StaffMaster']['s2_3'])),
                        array(array('StaffMaster.s1_3 >=' => $this->request->data['StaffMaster']['s1_3']), array('StaffMaster.s1_3 <= ' => $this->request->data['StaffMaster']['s2_3'])),
                    )
                );
                 * 
                 */
                //$this->log($conditions2, LOG_DEBUG);
                
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
            // プロフィールページへ
            } elseif (isset($profile)) {
                // ページ数（レコード番号）を取得
                $conditions1 = array('kaijo_flag' => $flag, 'id <= ' => $staff_id);
                $page = $this->StaffMaster->find('count', array('fields' => array('*'), 'conditions' => $conditions1));
                //$this->log($this->StaffMaster->getDataSource()->getLog(), LOG_DEBUG);
                //$this->log($page, LOG_DEBUG);
                $this->redirect(array('action' => 'profile', $flag, $staff_id, 'page' => $page));
                exit();
            }

            // 年齢の計算
            $this->setAge($this->Session->read('selected_class'));
            // ページネーションの実行
            //$this->request->params['named']['page'] = 1;
            $this->set('datas', $this->paginate('StaffMaster', $conditions2));
            $this->log($this->StaffMaster->getDataSource()->getLog(), LOG_DEBUG);
            //$this->log($conditions2, LOG_DEBUG);
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

    // プロフィールページ
    public function profile($flag = null, $staff_id = null) {
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
        $this->set('id', $staff_id); 
        $username = $this->Auth->user('username');
        $this->set('username', $username); 
        // テーブルの設定
        $selected_class = $this->Session->read('selected_class');
        $this->StaffMaster->setSource('staff_'.$selected_class);
        $this->set('class', $selected_class);
        //$this->log('staff_'.$this->Session->read('selected_class'), LOG_DEBUG);
        //$this->log($this->StaffMaster->useTable);
        $this->StaffMemo->setSource('staff_memos');
        // 登録していた値をセット
        $this->set('memo_datas', $this->StaffMemo->find('all', array('conditions' => array('class' => $selected_class, 'staff_id' => $staff_id), 'order' => array('id' => 'desc')))); 
        //$this->log($this->StaffMemo->getDataSource()->getLog(), LOG_DEBUG);
        
        // ページネーション
        //$conditions2 = array('id' => $staff_id, 'kaijo_flag' => $flag);
        $conditions2 = array('kaijo_flag' => $flag);
        //$conditions2 = null;
        $this->paginate = array(
            'fields' => '*' ,
            'limit' =>  '1',
            //'page' => $page,
            'order' => 'id',
            'conditions' => $conditions2
        );
        $this->set('datas', $this->paginate('StaffMaster'));

        // post時の処理
        if ($this->request->is('post') || $this->request->is('put')) {
            // 登録編集
            if (isset($this->request->data['submit'])) {
                $this->redirect(array('action' => 'reg1', $staff_id, 1));
            // 登録解除
            } elseif (isset($this->request->data['release'])) {
                $sql = '';
                $sql = $sql.' UPDATE softlife.staff_'.$selected_class; 
                $sql = $sql.' SET id = '.$this->request->data['StaffMaster']['staff_id'].', kaijo_flag = 1, modified = CURRENT_TIMESTAMP()';  
                $sql = $sql.' WHERE softlife.staff_'.$selected_class.'.id = '.$this->request->data['StaffMaster']['staff_id'];
                //$this->log($sql, LOG_DEBUG);
                $this->StaffMaster->query($sql);
                // ログ書き込み
                $this->setSMLog($username, $selected_class, $staff_id, $this->request->data['StaffMaster']['staff_name'], $flag, 9, $this->request->clientIp()); // 登録解除コード:9
                $this->redirect(array('action' => 'profile', $flag, $staff_id, 'page' => 1));
                //$this->StaffMaster->save($this->request->data);
                //$this->log($this->StaffMaster->getDataSource()->getLog(), LOG_DEBUG);
                $this->Session->setFlash('登録解除しました。');
                /**
            // メモ追加
            } elseif (isset($this->request->data['comment'])) {
                $sql = '';
                $sql = $sql.' INSERT INTO softlife.staff_memos (memo, class, username, staff_id, created)';
                $sql = $sql.' VALUES ("'.$this->request->data['StaffMemo']['memo'].'", '.$selected_class.', '
                    .$this->request->data['StaffMemo']['username'].','.$staff_id.', CURRENT_TIMESTAMP())';
                $this->StaffMemo->query($sql);
                $this->redirect(array('action' => 'profile', $flag, $staff_id));
                //$this->StaffMemo->save($this->request->data);
                //$this->log($this->StaffMemo->getDataSource()->getLog(), LOG_DEBUG);
                //$this->redirect($this->referer());
                //$this->Session->setFlash('メモを追加しました。');
            // メモ削除
            } elseif (isset($this->request->data['delete'])) {
                $id_array = array_keys($this->request->data['delete']);
                $id = $id_array[0];
                $sql = '';
                $sql = $sql.' DELETE FROM staff_memos';
                $sql = $sql.' WHERE id = '.$id;
                $this->StaffMemo->query($sql);
                $this->redirect(array('action' => 'profile', $flag, $staff_id));
                 * 
                 */
            } 
        } else {
            
        }
    }
    
    // メモ組み込みページ
    public function memo($staff_id = null) {
        $this->layout = false;
        $this->StaffMemo->setSource('staff_memos');
        $selected_class = $this->Session->read('selected_class');
        $this->set('class', $selected_class);
        $this->set('id', $staff_id);
        $this->set('username', $this->Auth->user('username')); 
        // 登録していた値をセット
        $this->set('memo_datas', $this->StaffMemo->find('all', array('conditions' => array('class' => $selected_class, 'staff_id' => $staff_id), 'order' => array('id' => 'desc'))));  
        
        // post時の処理
        if ($this->request->is('post') || $this->request->is('put')) {        
            // メモ追加
            if (isset($this->request->data['comment'])) {
                $sql = '';
                $sql = $sql.' INSERT INTO softlife.staff_memos (memo, class, username, staff_id, created)';
                $sql = $sql.' VALUES ("'.$this->request->data['StaffMemo']['memo'].'", '.$selected_class.', '
                    .$this->request->data['StaffMemo']['username'].','.$staff_id.', CURRENT_TIMESTAMP())';
                $this->StaffMemo->query($sql);
                $this->redirect(array('action' => 'memo', $staff_id));
                //$this->StaffMemo->save($this->request->data);
                //$this->log($this->StaffMemo->getDataSource()->getLog(), LOG_DEBUG);
                //$this->redirect($this->referer());
                //$this->Session->setFlash('メモを追加しました。');
            // メモ削除
            } elseif (isset($this->request->data['delete'])) {
                $id_array = array_keys($this->request->data['delete']);
                $id = $id_array[0];
                $sql = '';
                $sql = $sql.' DELETE FROM staff_memos';
                $sql = $sql.' WHERE id = '.$id;
                $this->StaffMemo->query($sql);
                $this->redirect(array('action' => 'memo', $staff_id));
            }   
        }
    }
    
    // 登録ページ（その１）
    public function reg1($staff_id = null, $koushin_flag = null) {
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
        $conditions2 = array('area' => substr($selected_class, 0, 1));
        $this->User->virtualFields['name'] = 'CONCAT(name_sei, " ", name_mei)';
        $name_arr = $this->User->find('list', array('fields' => array('username', 'name'), 'conditions' => $conditions2));
        $this->set('name_arr', $name_arr); 
        // その他
        $this->set('staff_id', $staff_id); 
        $this->StaffMaster->id = $staff_id;
        $username = $this->Auth->user('username');
        $this->set('username', $username); 
        $this->set('koushin_flag', $koushin_flag);

        //$this->StaffMaster->id = $staff_id;
        // テーブルの設定
        $this->StaffMaster->setSource('staff_'.$selected_class);

        // post時の処理
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->StaffMaster->validates($this->request->data)) {
                // バリデーションOKの場合の処理
                $this->log('OK!', LOG_DEBUG);
            } else {
                // バリデーションNGの場合の処理
                $this->log( $this->StaffMaster->validationErrors, LOG_DEBUG);
                exit();
            }
            if (isset($this->request->data['submit'])) {
                // 都道府県の名称のセット
                if (!empty($this->request->data['StaffMaster']['address1'])) {
                    $conditions = array('item' => 10, 'id' => $this->request->data['StaffMaster']['address1']);
                    $result = $this->Item->find('first', array('conditions' => $conditions));
                    $this->request->data['StaffMaster']['address1_2'] = $result['Item']['value'];
                }
                // モデルの状態をリセットする
                //$this->StaffMaster->create();
                // データを登録する
                if ($this->StaffMaster->save($this->request->data)) {
                    if ($staff_id == 0) {
                        // 新規登録したIDを取得
                        $id = $this->StaffMaster->getLastInsertID();
                        // ログ書き込み
                        $this->setSMLog($username, $selected_class, $id, $this->request->data['StaffMaster']['name_sei'].' '.$this->request->data['StaffMaster']['name_mei'], 9, 1, $this->request->clientIp()); // 新規登録１コード:1
                    } else {
                        $id = $staff_id;
                        // ログ書き込み
                        $this->setSMLog($username, $selected_class, $id, $this->request->data['StaffMaster']['name_sei'].' '.$this->request->data['StaffMaster']['name_mei'], 9, 11, $this->request->clientIp()); // 更新登録１コード:11
                    }
                    
                    // 登録２にリダイレクト
                    //$this->redirect(array('action' => 'reg2', $id, $koushin_flag));
                    // 登録完了メッセージ
                    $this->Session->setFlash('登録しました。');
                    $this->redirect(array('action' => 'reg1', $id, $koushin_flag));
                } else {
                    $this->Session->setFlash('登録時にエラーが発生しました。');
                }
            }    
        } else {
            // 登録していた値をセット
            $this->request->data = $this->StaffMaster->read(null, $staff_id);
        }
    }
    
    // 登録ページ（その２）
    public function reg2($staff_id = null, $koushin_flag = null) {
        // レイアウト関係
        $this->layout = "sub";
        $this->set("title_for_layout",$this->title_for_layout);
        // 都道府県のセット
        mb_language("uni");
        mb_internal_encoding("utf-8"); //内部文字コードを変更
        mb_http_input("auto");
        mb_http_output("utf-8");
        $selected_class = $this->Session->read('selected_class');
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
        }
        $pref_arr = $this->Item->find('list', array('fields' => array( 'id', 'value'), 'conditions' => $conditions));
        $this->set('pref_arr', $pref_arr); 
        // 職種マスタ配列
        $conditions2 = array('item' => 16);
        $list_shokushu = $this->Item->find('list', array('fields' => array( 'id', 'value'), 'conditions' => $conditions2));
        $this->set('list_shokushu', $list_shokushu); 
        $this->set('staff_id', $staff_id); 
        // テーブルの設定
        $this->StaffMaster->setSource('staff_'.$selected_class);
        // 初期値設定
        $this->set('data', $this->StaffMaster->find('list', 
                array('fields' => array('*'), 'conditions' => array('id' => $staff_id) )));
        $username = $this->Auth->user('username');
        $this->set('username', $username); 
        $this->set('class_name', $this->getClass($selected_class));
        $this->set('class', $selected_class);
        $this->set('koushin_flag', $koushin_flag);

        // ファイルアップロード処理の初期セット
        $ds = DIRECTORY_SEPARATOR;  //1
        $storeFolder = 'files/staff_reg'.$ds.$this->Session->read('selected_class').$ds.sprintf('%07d', $staff_id).$ds;   //2
        
        // post時の処理
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->log($this->StaffMaster->validates($this->request->data), LOG_DEBUG);
            if (!$this->StaffMaster->validates($this->request->data)) {
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
                    $this->request->data['StaffMaster']['pic_extension'] = $_after;
                }
                // 履歴書ファイルの拡張子セット
                if (is_null($_after2) == false) {
                    $this->request->data['StaffMaster']['pic_extension2'] = $_after2;
                }
                // 職種のセット
                $val1 = $this->setShokushu($this->request->data['StaffMaster']['shokushu_shoukai']);
                $val2 = $this->setShokushu($this->request->data['StaffMaster']['shokushu_kibou']);
                $val3 = $this->setShokushu($this->request->data['StaffMaster']['shokushu_keiken']);
                // その他の職業セット
                $val4 = $this->setShokushu($this->request->data['StaffMaster']['extra_job']);
                // 勤務可能曜日
                $val5 = $this->setShokushu($this->request->data['StaffMaster']['workable_day']);
                // きっかけ
                $val6 = $this->setShokushu($this->request->data['StaffMaster']['regist_trigger']);
                // セット
                $this->request->data['StaffMaster']['shokushu_shoukai'] = $val1;
                $this->request->data['StaffMaster']['shokushu_kibou'] = $val2;
                $this->request->data['StaffMaster']['shokushu_keiken'] = $val3;
                $this->request->data['StaffMaster']['extra_job'] = $val4;
                $this->request->data['StaffMaster']['workable_day'] = $val5;
                $this->request->data['StaffMaster']['regist_trigger'] = $val6;
                // 駅を未入力ならばNULLをセットする
                if (empty($this->request->data['StaffMaster']['s1_1'])) {
                    //$this->request->data['StaffMaster']['pref1'] = null;
                    //$this->request->data['StaffMaster']['s0_1'] = null;
                    $this->request->data['StaffMaster']['s1_1'] = null;
                }
                if (empty($this->request->data['StaffMaster']['s1_2'])) {
                    //$this->request->data['StaffMaster']['pref2'] = null;
                    //$this->request->data['StaffMaster']['s0_2'] = null;
                    $this->request->data['StaffMaster']['s1_2'] = null;
                }
                if (empty($this->request->data['StaffMaster']['s1_3'])) {
                    //$this->request->data['StaffMaster']['pref3'] = null;
                    //$this->request->data['StaffMaster']['s0_3'] = null;
                    $this->request->data['StaffMaster']['s1_3'] = null;
                }
                // モデルの状態をリセットする
                //$this->StaffMaster->create();
                // データを登録する
                if ($this->StaffMaster->save($this->request->data)) {
                    // 登録したIDを取得
                    //$id = $this->StaffMaster->getLastInsertID();
                    // ログ書き込み
                    if ($koushin_flag == 0) {
                        $this->setSMLog($username, $selected_class, $staff_id, $this->request->data['StaffMaster']['name_sei'].' '.$this->request->data['StaffMaster']['name_mei'], 
                            9, 2, $this->request->clientIp()); // 新規登録２コード:2
                    } elseif ($koushin_flag == 1) {
                        $this->setSMLog($username, $selected_class, $staff_id, $this->request->data['StaffMaster']['name_sei'].' '.$this->request->data['StaffMaster']['name_mei'], 
                            9, 12, $this->request->clientIp()); // 更新登録２コード:12 
                    }
                    // 登録２にリダイレクト
                    //$this->redirect(array('action' => 'reg3', $staff_id, $koushin_flag));
                    // 登録完了メッセージ
                    $this->Session->setFlash('登録しました。');
                    $this->redirect(array('action' => 'reg2', $staff_id, $koushin_flag));
                } else {
                    // 登録していた値をセット
                    //$this->request->data = $this->StaffMaster->read(null, $staff_id);
                    $this->set('data', $this->request->data); 
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
            $this->request->data = $this->StaffMaster->read(null, $staff_id);
            $this->set('data', $this->request->data);
            //$this->set('selected', array(1,3,7));
        }
    }
    
    // 登録ページ（その３）
    public function reg3($staff_id = null, $koushin_flag = null) {
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
          $this->set('staff_id', $staff_id);
        // テーブルの設定
        $this->StaffMaster->setSource('staff_'.$this->Session->read('selected_class'));
        // 初期値設定
        $this->set('datas', $this->StaffMaster->find('first', 
                array('fields' => array('created', 'modified'), 'conditions' => array('id' => $staff_id) )));
        $username = $this->Auth->user('username');
        $this->set('username', $username); 
        $selected_class = $this->Session->read('selected_class');
        $class = $this->getClass($selected_class);
        $this->set('class', $class);
        $this->set('koushin_flag', $koushin_flag);

        // post時の処理
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->StaffMaster->validates() == false) {
                exit();
            }
            if (isset($this->request->data['submit'])) {
                // モデルの状態をリセットする
                //$this->StaffMaster->create();
                // データを登録する
                if ($this->StaffMaster->save($this->request->data)) {
                    // ログ書き込み
                    if ($koushin_flag == 0) {
                        $this->setSMLog($username, $selected_class, $staff_id, $this->request->data['StaffMaster']['name_sei'].' '.$this->request->data['StaffMaster']['name_mei'], 
                            9, 3, $this->request->clientIp()); // 新規登録３コード:3
                    } elseif ($koushin_flag == 1) {
                        $this->setSMLog($username, $selected_class, $staff_id, $this->request->data['StaffMaster']['name_sei'].' '.$this->request->data['StaffMaster']['name_mei'], 
                            9, 13, $this->request->clientIp()); // 更新登録３コード:13 
                    }
                    // 登録したIDを取得
                    //$id = $this->StaffMaster->getLastInsertID();
                    // 登録完了メッセージ
                    $this->Session->setFlash('登録しました。');
                } else {
                    $this->Session->setFlash('登録時にエラーが発生しました。');
                }
            }

        } else {
          // 登録していた値をセット
          $this->request->data = $this->StaffMaster->read(null, $staff_id);
        }
    }
    
    // パスワード変更ページ
    public function password($staff_id = null) {
          // レイアウト関係
          $this->layout = "sub";
          $this->set("title_for_layout",$this->title_for_layout);
          $this->set('staff_id', $staff_id);
        // テーブルの設定
        $this->StaffMaster->setSource('staff_'.$this->Session->read('selected_class'));
        // 初期値設定
        $this->set('data', $this->StaffMaster->find('first', 
                array('fields' => array('*'), 'conditions' => array('id' => $staff_id) )));
        $username = $this->Auth->user('username');
        $this->set('username', $username); 
        $selected_class = $this->Session->read('selected_class');
        $class = $this->getClass($selected_class);
        $this->set('class', $class);

        // POSTの場合
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->request->data['StaffMaster']['password'] != $this->request->data['StaffMaster']['password2']) {
                $this->Session->setFlash(__('パスワードが一致しません。'));
            } else {
                // データを登録する
                $this->StaffMaster->save($this->request->data);
                $this->log($this->request->data, LOG_DEBUG);
                $this->Session->setFlash(__('パスワードは変更されました。'));

                // indexに移動する
                $this->redirect($this->request->referer());
            }
        } else {
            //$this->request->data = $this->StuffMaster->read(null, $staff_id);    
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
