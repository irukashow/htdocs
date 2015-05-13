<?php
class BoardsController extends AppController {
 
    public $name = 'Boards';
 
    /**
     * 初期表示
     */
    public function index() {
        // 初期表示。
        $data = $this->Board->find('all');
        // ビューで使えるように DB データをセット
        $this->set('data', $data);
    }
 
    /**
     * Boards テーブルにデータ追加
     */
    public function addRecord() {
        if ($this->request->is('post')) {
            $res = $this->Board->save($this->data);
            if ($this->Board->validates()){
                echo 'バリデーションOK';
            } else {
                $this->redirect('.');
                echo 'バリデーションNG';
            }
            if ($res) {
                //$this->redirect('.');
            }
        }
    }
}
?>