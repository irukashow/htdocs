<?php
    // 初期値セット
    $created = date('Y/m/d', strtotime($datas['StuffMaster']['created']));
    $modified = date('Y/m/d', strtotime($datas['StuffMaster']['modified']));
    $selected1 = explode(',',$data['StuffMaster']['shokushu_shoukai']);
    $selected2 = explode(',',$data['StuffMaster']['shokushu_kibou']);
    $selected3 = explode(',',$data['StuffMaster']['shokushu_keiken']);
    $selected4 = explode(',',$data['StuffMaster']['extra_job']);
    $selected5 = explode(',',$data['StuffMaster']['workable_day']);
    $selected6 = explode(',',$data['StuffMaster']['regist_trigger']);
    
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
    
    $line1 = getLine($data['StuffMaster']['pref1']);
    $line2 = getLine($data['StuffMaster']['pref2']);
    $line3 = getLine($data['StuffMaster']['pref3']);
    
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
    
    $station1 = getStation($data['StuffMaster']['s0_1']);
    $station2 = getStation($data['StuffMaster']['s0_2']);
    $station3 = getStation($data['StuffMaster']['s0_3']);
    
?>