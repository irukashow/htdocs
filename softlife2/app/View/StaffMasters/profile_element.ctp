<?php  
    // 年齢換算
    function getAge($str) {
        return floor ((date('Ymd') - $str)/10000);
    }
    // 性別変換
    function getGender($value) {
        $ret = null;
        if ($value == 1) {
            $ret = '<img src="'.ROOTDIR.'/img/woman.png" style="width:30px;">';
        } elseif ($value == 2) {
            $ret = '<img src="'.ROOTDIR.'/img/man.png" style="width:30px;">';
        } else {
            $ret = '未分類';
        }
        return $ret;
    }
    // 有無
    function getTF($value) {
        $ret = null;
        if ($value == 1) {
            $ret = '無';
        }else if ($value == 2) {
            $ret = '有';
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
    // 雇用形態
    function getStatus($value) {
        $ret = null;
        if ($value == 1) {
            $ret = '正社員';
        } elseif ($value == 2) {
            $ret = '契約社員';
        } elseif ($value == 3) {
            $ret = '人材派遣スタッフ';
        }
        return $ret;
    }
    // 通勤時間
    function getComuterTime($value) {
        $ret = null;
        if ($value == 30) {
            $ret = '30分以内';
        } elseif ($value == 60) {
            $ret = '1時間以内';
        } elseif ($value == 90) {
            $ret = '1時間30分以内';
        } elseif ($value == 100) {
            $ret = '1時間30分以上可';   
        }
        return $ret;
    }
    // 年末調整
    function getNenmatsu($value) {
        $ret = null;
        if ($value == 1) {
            $ret = 'なし';
        } elseif ($value == 2) {
            $ret = '希望';
        }
        return $ret;
    }
    // その他の職業
    function getShokugyou($value) {
        $ret = "";
        if ($value == 1) {
            $ret = '会社員';
        } elseif ($value == 2) {
            $ret = '主婦';
        } elseif ($value == 3) {
            $ret = '学生';
        } elseif ($value == 4) {
            $ret = '派遣';  
        } elseif ($value == 5) {
            $ret = 'アルバイト';
        } elseif ($value == 6) {
            $ret = 'その他';
        } else {
            $ret = '';
        }
        return $ret;
    }
    function getShokugyou2($array) {
        $ret = "";
        $_array = explode(',', $array);
        foreach ($_array as $key => $value) {
            if ($key <= 1) {
                $ret = getShokugyou($value);
            } else {
                $ret = $ret.', '.getShokugyou($value);
            }  
        }
        return $ret;
    }
    // その他の職業（その他）
    function getShokugyou3($val) {
        $ret = "";
        if (is_null($val) || empty($val)) {
            $ret = "";
        } else {
            $ret = '('.$val.')';
        }
        return $ret;
    }
    // 勤務可能曜日
    function getWorkable($value) {
        $ret = "";
        if ($value == 1) {
            $ret = '特になし';
        } elseif ($value == 2) {
            $ret = '平日のみ';
        } elseif ($value == 3) {
            $ret = '土日のみ';
        } elseif ($value == 4) {
            $ret = '土日祝のみ';  
        } elseif ($value == 5) {
            $ret = '月';
        } elseif ($value == 6) {
            $ret = '火';
        } elseif ($value == 7) {
            $ret = '水';
        } elseif ($value == 8) {
            $ret = '木';
        } elseif ($value == 9) {
            $ret = '金';  
        } elseif ($value == 10) {
            $ret = '土';
        } elseif ($value == 11) {
            $ret = '日';
        } else {
            $ret = '';
        }
        return $ret;
    }
    function getWorkable2($array) {
        $ret = "";
        $_array = explode(',', $array);
        foreach ($_array as $key => $value) {
            if ($key <= 1) {
                $ret = getWorkable($value);
            } else {
                $ret = $ret.', '.getWorkable($value);
            }  
        }
        return $ret;
    }
    // 口座種別
    function getKouza($value) {
        $ret = null;
        if ($value == 1) {
            $ret = '普通';
        } elseif ($value == 2) {
            $ret = '当座';
        }
        return $ret;  
    }
    // 評価
    function getHyouka($value) {
        $ret = null;
        if ($value == 0) {
            $ret = '&nbsp;';
        } elseif ($value == 1) {
            $ret = '1 ■';
        } elseif ($value == 2) {
            $ret = '2 ■■';
        } elseif ($value == 3) {
            $ret = '3 ■■■';
        } elseif ($value == 4) {
            $ret = '4 ■■■■';
        } elseif ($value == 5) {
            $ret = '5 ■■■■■'; 
        }
        return $ret;
    }
    
    // 路線・駅の表示
    function getStation($code) {
        if (!is_null($code) && !empty($code)) {
            $xml = "http://www.ekidata.jp/api/s/".$code.".xml";//ファイルを指定
            //$xml = "http://www.ekidata.jp/api/s/3300610.xml";//ファイルを指定
            // simplexml_load_fileは使えない処理
            //$xml_data = "";
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
?>