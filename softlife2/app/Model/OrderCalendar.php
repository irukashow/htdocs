<?php

App::uses('AppModel', 'Model');

/**
 * CakePHP Account
 * @author M-YOKOI
 */
class OrderCalendar extends AppModel {
    var $name = 'OrderCalendar';

    // デフォルトのソート条件は何もなし
    var $order = array();

    function setOrder($order) {

      // controllerから渡された$orderを変数に持っておく
      $this->order = $order;

    }

    function beforeFind($queryData) {

      // $queryData['order'] の最初に、そのとき
      // $this->orderに代入されている検索条件を追加する
      array_unshift($queryData['order'], $this->order);

      // 終わったら$this->orderは空にしておく
      // (じゃないと次回以降の検索時に条件が適用されてしまうので)
      $this->order = array();

      return $queryData;

    }
  
}

