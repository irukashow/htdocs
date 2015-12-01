<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('CakeEmail', 'Network/Email');

/**
 * CakePHP ContactController
 * @author M-YOKOI
 */
class ContactController extends AppController {

    public function index() {
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->Contact->set($this->request->data);
            if ($this->Contact->Validates()) {
            
                $vars = $this->request->data['Contact'];
 
                // メール送信実行
                $email = new CakeEmail('gmail');     // ←手順2で編集した配列名を指定
                $sent = $email
                    ->template('contact', 'contact')         // ←テンプレ, Layout
                    ->viewVars($vars)           // ←メール内容配列をテンプレに渡す
                    ->from(array('system.softlife@gmail.com' => '横井　政広'))
                    ->to($this->request->data['Contact']['email'])
                    ->subject('件名')
                    ->send();
 
                // 送信
                // 送信したメールのヘッダーとメッセージを配列で返します
                if ($email->send()) {
                    $this->Session->setFlash('問い合わせ完了');
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash('問い合わせに失敗しました。');
                }
            }
        }    
    }

}
