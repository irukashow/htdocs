<?php
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
    
    if (!empty($data)) {
        $line1 = getLine($data['CaseManagement']['pref1']);
        $line2 = getLine($data['CaseManagement']['pref2']);
        $line3 = getLine($data['CaseManagement']['pref3']);
    }
    
    // 駅のコンボセット
    function getStation($code) {
    //$code = $data['CaseManagement']['s0_1'];
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
    
    if (!empty($data)) {
        $station1 = getStation($data['CaseManagement']['s0_1']);
        $station2 = getStation($data['CaseManagement']['s0_2']);
        $station3 = getStation($data['CaseManagement']['s0_3']);
    }
    
    
?>