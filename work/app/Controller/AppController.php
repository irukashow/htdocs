<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    public $uses = array('User', 'Item');
    
    public $components = array(
		'Session',
		'Auth' => array(
                    // 認証時の設定
                    'authenticate' => array(
                        'Form' => array(
                            // 認証時に使用するモデル
                            'userModel' => 'Client',
                            // 認証時に使用するモデルのユーザ名とパスワードの対象カラム
                            'fields' => array('username' => 'username' , 'password'=>'password'),
                        ),
                    ),
                    'loginRedirect' => array('controller' => 'users', 'action' => 'index'),
                    'logoutRedirect' => array('controller' => 'users', 'action' => 'login')
		)
	);
    public function beforeFilter() {
        // 認証コンポーネントをViewで利用可能にしておく
        $this->set('auth',$this->Auth);
        
        // 所属のセット
        $username = $this->Auth->user('username');
        $conditions = array('username' => $username);
        $result = $this->User->find('first', array('conditions' => $conditions));
        $this->set('result', $result);
    }
    
    public function isAuthorized($user) {
        if (isset($user['role']) && $user['role'] === 'admin') {
            return true;
        }

        // デフォルトは拒否
        return false;
    }
    
    // 項目テーブルからの値変換関数
    /**
    public function getValue($item, $id) {
        $conditions = array('item' => $item, 'id' => $id);
        $value = $this->Item->find('first', array('conditions' => $conditions));
        return $value;
    } 
     * 
     */
}
