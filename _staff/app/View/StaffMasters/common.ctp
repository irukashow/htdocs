<?php
    // 職種のセット
    function getShokushu($value, $list_shokushu) {
        $ret = "";
        //$list_shokushu = Configure::read("shokushu");
        
        if (!empty($value) && $value != 0) {
            $ret = $list_shokushu[$value];  
        }

        return $ret;
    }
    function getShokushu2($array, $list_shokushu) {
        $ret = "";
        $_array = explode(',', $array);
        foreach ($_array as $key => $value) {
            if (empty($ret)) {
                $ret = getShokushu($value, $list_shokushu);
            } else {
                $ret = $ret.'<br>'.getShokushu($value, $list_shokushu);
            }  
        }
        return $ret;
    }
?>