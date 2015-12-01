<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

/**
 * CakePHP SampleController
 * @author M-YOKOI
 */
class SampleController extends AppController {

    public function index() {
        $this->layout = '';
    }
    
    // 路線・駅名表示テスト
    public function station() {
        $this->set('xmlArray', null);
        
        if ($this->request->is('post') || $this->request->is('put')) {
            //$code = $this->request->data['code'];
            $code = '3300610';
            $xml = "http://www.ekidata.jp/api/s/".$code.".xml";//ファイルを指定
            $xmlData = simplexml_load_file($xml);//xmlを読み込む

            // CakePHPのxmlパーサを利用
            App::uses('Xml','Utility');
            $xmlArray = Xml::toArray(Xml::build($xml));
            
            $this->set('xmlArray', $xmlArray);

        }

        
    }

}
