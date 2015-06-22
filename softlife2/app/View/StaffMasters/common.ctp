<?php
    // 職種のセット
    function getShokushu($value) {
        $ret = "";
        $list_shokushu = Configure::read("shokushu");
        
        if (!empty($value) && $value != 0) {
            $ret = $list_shokushu[$value];  
        }
        
        /**
        if ($value == 1) {
            $ret = '受付';
        } elseif ($value == 2) {
            $ret = '内覧会受付';
        } elseif ($value == 3) {
            $ret = '内覧会スタッフ';
        } elseif ($value == 4) {
            $ret = 'ナレーター';  
        } elseif ($value == 5) {
            $ret = 'MC';
        } elseif ($value == 6) {
            $ret = '説明';
        } elseif ($value == 7) {
            $ret = '事務';
        } elseif ($value == 8) {
            $ret = '誘導案内';
        } elseif ($value == 9) {
            $ret = '保育';
        } elseif ($value == 10) {
            $ret = 'イベント';
        } elseif ($value == 11) {
            $ret = 'DH';
        } elseif ($value == 12) {
            $ret = '看板持ち';
        } else {
            $ret = '';
        }
         * 
         */

        return $ret;
    }
    function getShokushu2($array) {
        $ret = "";
        $_array = explode(',', $array);
        foreach ($_array as $key => $value) {
            if (empty($ret)) {
                $ret = getShokushu($value);
            } else {
                $ret = $ret.'<br>'.getShokushu($value);
            }  
        }
        return $ret;
    }
?>