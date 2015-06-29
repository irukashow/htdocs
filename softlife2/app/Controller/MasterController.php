<?php
App::uses('AppController', 'Controller');

/**
 * CakePHP MasterController
 * @author M-YOKOI
 */
class MasterController extends AppController {
    var $uses = array('Item');
    public $title_for_layout = "マスタ管理 - 派遣管理システム";
    
    public $paginate = array (
    'Item' => array (
        'limit' => 10,
        'order' => 'id',
        'fields' => '*'
        ), 
        "Role" => array() 
    );
    
    public function index() {
        // レイアウト関係
        $this->layout = "log";
        $this->set("title_for_layout", $this->title_for_layout);
        $this->set("headline", '項目マスタ管理');
        // 項目区分セット
        $conditions2 = array('item' => 0);
        $list_item = $this->Item->find('list', array('fields' => array( 'id', 'value'), 'conditions' => $conditions2));
        $this->set('list_item', $list_item); 
        //$this->log($list_item, LOG_DEBUG);
        
        // POSTの場合
        if ($this->request->is('post') || $this->request->is('put')) {
            //$this->log($this->request, LOG_DEBUG);
            if (isset($this->request->data['insert'])) {
                // データを登録する
                $item = $this->request->data['Item']['item'];
                $id = $this->request->data['Item']['id'];
                $value = $this->request->data['Item']['value'];
                // 削除
                $sql = '';
                $sql = $sql.' DELETE FROM item';
                $sql = $sql.' WHERE item = '.$item.' AND id = '.$id;
                $this->log($this->Item->query($sql));
                // 追加
                $sql = "";
                $sql = $sql." INSERT INTO item (item, id, value, created)";
                $sql = $sql." VALUES (".$item.", ".$id.", '".$value."', now())";
                $this->log($this->Item->query($sql));
                $this->redirect('index');
                $this->Session->setFlash('ID='.$id.', 値='.$value.'を追加しました。');
            } elseif (isset($this->request->data['delete'])) {
                $item = $this->request->data['Item2']['item'];
                $id = $this->request->data['Item2']['id'];
                $this->log($item.'&'.$id, LOG_DEBUG);
                $sql = '';
                $sql = $sql.' DELETE FROM item';
                $sql = $sql.' WHERE item = '.$item.' AND id = '.$id;
                $this->Item->query($sql);
                $this->redirect('index');
                $this->Session->setFlash('Item='.$item.'かつID='.$id.'を削除しました。');
            } else {
                // 項目区分で絞り込んだ場合
                //$this->log($this->request->data, LOG_DEBUG);
                $item = $this->request->data['Item0']['item'];
                $this->Session->write('selected_item', $item);
                $this->paginate = array('Item' => array(
                    'conditions' => array('item' => $item),
                    'page' => '1',
                    'limit' => '10'));
                $this->set('datas', $this->paginate());
                //$this->redirect('index', array('item' => $item));
            }
        } else {
            $item = $this->Session->read('selected_item');
            $this->paginate = array('Item' => array(
                'conditions' => array('item' => $item),
                'page' => '1',
                'limit' => '10'));
            $this->set('datas', $this->paginate());
        }   
    }
    
    /** 職種マスタ管理 **/
    public function shokushu($_id = null, $_sequence = null, $direction = null) {
        // レイアウト関係
        $this->layout = "log";
        $this->set("title_for_layout", $this->title_for_layout);
        $this->set("headline", '職種マスタ管理');
        
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
                //$this->log($sql1.'/'.$sql2, LOG_DEBUG);
                //$this->log($this->Item->query($sql1), LOG_DEBUG);
                //$this->log($this->Item->query($sql2), LOG_DEBUG);
                $this->redirect('shokushu');
            } 
        } else {
            //$this->request->data = $this->User->read(null, $this->Auth->user('username'));    
        }
    }

}
