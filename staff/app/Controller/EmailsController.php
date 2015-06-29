<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('CakeEmail', 'Network/Email');

/**
 * CakePHP EmailsController
 * @author M-YOKOI
 */
class EmailsController extends AppController {
    
    public function index() {
        
    }

    public function send() {
        // メール内容
        $mailbody = array(
            'name' => '山田太郎',
            'content' => "テスト送信です。\nあああああ\n\n123",
        );

        // メール送信実行
        $email = new CakeEmail('gmail');     // ←手順2で編集した配列名を指定
        $sent = $email
            ->template('text_mail', 'text_layout')         // ←テンプレ, Layout
            ->viewVars($mailbody)           // ←メール内容配列をテンプレに渡す
            ->from(array('system.softlife@gmail.com' => '横井　政広'))
            ->to('yokoi-masahiro@softlife.co.jp')
            ->subject('件名')
            ->send();

        if ( $sent ) {
             echo 'メール送信成功！' ;
        } else {
             echo 'メール送信失敗' ;
        }
    }

}
