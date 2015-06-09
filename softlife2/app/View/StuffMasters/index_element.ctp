<?php
    echo $this->Html->css( 'stuffmaster');
    echo $this->Html->script('station3');
    
    // 年齢換算
    function getAge($str) {
        return floor ((date('Ymd') - $str)/10000).'歳';
    }
    // 性別変換
    function getGender($value) {
        $ret = null;
        if ($value == 1) {
            $ret = '<img src="'.ROOTDIR.'/img/woman.png" style="width:50%">';
        } elseif ($value == 2) {
            $ret = '<img src="'.ROOTDIR.'/img/man.png" style="width:50%">';
        } else {
            $ret = '未分類';
        }
        return $ret;
    }
    // OJT済未済
    function getOjt($value) {
        $ret = '&nbsp;';
        if ($value == 0) {
            $ret = '未済';
        } elseif ($value == 1) {
            $ret = '済';
        }
        return $ret;
    }
    // 職種
    function getShokushu($value) {
        $ret = "";
        if ($value == 1) {
            $ret = '受付';
        } elseif ($value == 2) {
            $ret = 'フロア受付';
        } elseif ($value == 3) {
            $ret = 'シッター';
        } elseif ($value == 4) {
            $ret = 'ナレーター';  
        } elseif ($value == 5) {
            $ret = 'ＤＨ';
        } elseif ($value == 6) {
            $ret = '看板持ち';
        } elseif ($value == 7) {
            $ret = '事務';
        } elseif ($value == 8) {
            $ret = '誘導案内';
        } elseif ($value == 9) {
            $ret = '内覧会スタッフ';
        } else {
            $ret = '';
        }
        return $ret;
    }
    function getShokushu2($array) {
        $ret = "";
        $_array = explode(',', $array);
        foreach ($_array as $key => $value) {
            if ($key <= 1) {
                $ret = getShokushu($value);
            } else {
                $ret = $ret.'<br>'.getShokushu($value);
            }  
        }
        return $ret;
    }
    // 年末調整
    function getNenmatsu($value) {
        $ret = null;
        if ($value == 1) {
            $ret = '&nbsp;';
        } elseif ($value == 2) {
            $ret = '希望';
        } else {
            $ret = '不明';
        }
        return $ret;
    }
    
    // 路線・駅の表示（スタッフマスタ内）
    function getStation0($code, $flag) {
        if (!is_null($code) && !empty($code)) {
            $xml = "http://www.ekidata.jp/api/s/".$code.".xml";//ファイルを指定
            //$xml = "http://www.ekidata.jp/api/s/3300610.xml";//ファイルを指定
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

            $line_name = $xml_ary['station']['line_name'];
            $station_name = $xml_ary['station']['station_name'];
            $ret = $line_name.' '.$station_name.'駅';
            if ($flag == 1) {
                $ret = $ret.'<br>';
            }
        } else {
            $ret = '';
        }
        
        return $ret;
        
        
    }
    
    /**
    // 都道府県の表示
    function getPref($code) {
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

            $ret = $xml_ary['pref']['name'];
        } else {
            $ret = '';
        }
        return $ret;
    }
     * 
     */

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

    /**
    $line1 = getLine($data['StuffMaster']['pref1']);
    $line2 = getLine($data['StuffMaster']['pref2']);
    $line3 = getLine($data['StuffMaster']['pref3']);
     * 
     */

    // 駅のコンボセット
    function getStation($code) {
    //$code = $data['StuffMaster']['s0_1'];
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
    /**
    $station1 = getStation($data['StuffMaster']['s0_1']);
    $station2 = getStation($data['StuffMaster']['s0_2']);
    $station3 = getStation($data['StuffMaster']['s0_3']);
     * 
     */
?>