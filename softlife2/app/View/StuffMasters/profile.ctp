<?php
    echo $this->Html->script( 'tools');
    //echo $this->Html->script('dropzone');
    echo $this->Html->script('jquery-1.9.1');
    echo $this->Html->script('station');
    echo $this->Html->script('lightbox');
    echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js');
    echo $this->Html->css('stuffmaster');
    echo $this->Html->css('lightbox');
    
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
                $ret = $ret.', '.getShokushu($value);
            }  
        }
        return $ret;
    }
     function getShokushu3($array) {
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

<?php foreach ($datas as $data): ?>
<table border="0" style="margin:10px;width:98%;">
    <tr>
        <td style="width:50%;">
            <div style="color: black;background-color: #99ccff;border:1px solid #0099cc;padding:3px;vertical-align: middle;padding-right: 5px;">
                <font style="font-size: 150%;">■登録者情報</font>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <font style="font-size: 100%;">登録年月日：<?=date('Y-m-d', strtotime($data['StuffMaster']['created'])); ?>&nbsp;&nbsp;登録番号：<?=$id ?></font>
            </div>
            
                    <!-- プロフィール -->
                    <table border='0' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 2px;border-spacing: 1px;">
                        <tr>
                            <td style='width:50%;'>
                                <?=$data['StuffMaster']['name_sei2'] ?>&nbsp;<?=$data['StuffMaster']['name_mei2'] ?><br>
                                <div style="float:left;">
                                    <font style='font-size:150%;'>
                                        <?=$data['StuffMaster']['name_sei'] ?>&nbsp;<?=$data['StuffMaster']['name_mei'] ?>&nbsp;
                                        <?=  getAge(str_replace('-','',$data['StuffMaster']['birthday'])) ?>歳&nbsp;&nbsp;
                                    </font>    
                                </div>
                                <div style="vertical-align: 0px;float: left;"><?=getGender($data['StuffMaster']['gender']) ?></div>
                                <div style="clear:both;"></div>
                            </td>
                            <td style='width:50%;text-align: center;' rowspan="5">
                    <?php
                        $after = $data['StuffMaster']['pic_extension'];
                        if (is_null($after)) {
                    ?>
                                <img src='<?=ROOTDIR ?>/img/noimage.jpg ?>' style='border:1px black solid; width:150px;'>
                    <?php } else { ?>
                                <a href="<?=ROOTDIR ?>/files/stuff_reg/<?=$class ?>/<?=$id ?>/<?=$id ?>.<?=$data['StuffMaster']['pic_extension'] ?>" rel="lightbox">
                                    <img src='<?=ROOTDIR ?>/files/stuff_reg/<?=$class ?>/<?=$id ?>/<?=$id ?>.<?=$data['StuffMaster']['pic_extension'] ?>' style='border:1px black solid; width:150px;'>
                                </a>
                    <?php } ?>
                            </td>
                        </tr>
                        <tr>
                            <td style=''>雇用形態：&nbsp;<?= getStatus($data['StuffMaster']['employment_status']) ?></td>
                        </tr>
                        <tr>
                            <td style=''>勤務回数：&nbsp;<?='＜不明＞' ?>回</td>
                        </tr>
                        <tr>
                            <td style='background-color:#ffcc66;'>就業状況：&nbsp;<?='＜不明＞' ?></td>
                        </tr>
                        <tr>
                            <td style=''>
                                <font style='font-size:130%;'><?=getShokushu3($data['StuffMaster']['shokushu_shoukai']) ?></font><br>
                            </td>
                        </tr>
                    </table>
                    
                    <!-- 左項目１ -->
                    <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;border-spacing: 1px;">
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>勤務開始希望日</td>
                            <td style='width:70%;'><?=$data['StuffMaster']['job_startdate_kibou'] ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>研修希望日</td>
                            <td style='width:70%;'><?=$data['StuffMaster']['training_date_kibou'] ?></td>
                        </tr>
                    </table>
                    
                    <!-- 左項目２ -->
                    <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;border-spacing: 1px;">
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>電話番号１</td>
                            <td style='width:70%;'><?=$data['StuffMaster']['telno1'] ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>電話番号２</td>
                            <td style='width:70%;'><?=$data['StuffMaster']['telno2'] ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>メールアドレス１</td>
                            <td style='width:70%;'><?=$data['StuffMaster']['email1'] ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>メールアドレス２</td>
                            <td style='width:70%;'><?=$data['StuffMaster']['email2'] ?></td>
                        </tr>
                    </table>
                    
                    <!-- 左項目３ -->
                    <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;border-spacing: 1px;">
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>勤務開始希望日</td>
                            <td style='width:70%;'><?=$data['StuffMaster']['job_startdate_kibou'] ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>研修希望日</td>
                            <td style='width:70%;'><?=$data['StuffMaster']['training_date_kibou'] ?></td>
                        </tr>
                    </table>
                    
                    <!-- 左項目４ -->
                    <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;border-spacing: 1px;">
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>最寄駅①</td>
                            <td style='width:70%;'><?=getStation($data['StuffMaster']['s1_1']) ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>最寄駅②</td>
                            <td style='width:70%;'><?=getStation($data['StuffMaster']['s1_2']) ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>最寄駅③</td>
                            <td style='width:70%;'><?=getStation($data['StuffMaster']['s1_3']) ?></td>
                        </tr>
                    </table>                    
                    
                    <!-- 左項目５ -->
                    <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;border-spacing: 1px;">
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>郵便番号</td>
                            <td style='width:70%;'><?=$data['StuffMaster']['zipcode1'] ?>-<?=$data['StuffMaster']['zipcode2'] ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>都道府県</td>
                            <td style='width:70%;'><?=$data['StuffMaster']['address1_2'] ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>市区町村</td>
                            <td style='width:70%;'>
                                    <?=$data['StuffMaster']['address2'] ?><?=$data['StuffMaster']['address3'] ?><?=$data['StuffMaster']['address4'] ?>&nbsp;&nbsp;<?=$data['StuffMaster']['address5'] ?>
                            </td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>生年月日</td>
                            <td style='width:70%;'><?=$data['StuffMaster']['birthday'] ?></td>
                        </tr>
                    </table>  
                    
                    <!-- 左項目６ -->
                    <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;border-spacing: 1px;">
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>希望職種</td>
                            <td style='width:70%;'><?=getShokushu2($data['StuffMaster']['shokushu_kibou']) ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>経験職種</td>
                            <td style='width:70%;'><?=getShokushu2($data['StuffMaster']['shokushu_keiken']) ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>マンションギャラリー<br>経験</td>
                            <td style='width:70%;'><?=getTF($data['StuffMaster']['keiken_mansion']) ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>勤務可能曜日</td>
                            <td style='width:70%;'><?=getWorkable2($data['StuffMaster']['workable_day']) ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>希望勤務回数</td>
                            <td style='width:70%;'>
                                週 <?=$data['StuffMaster']['per_week'] ?> 回　月 <?=$data['StuffMaster']['per_month'] ?> 回
                            </td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>希望エリア</td>
                            <td style='width:70%;'><?=$data['StuffMaster']['kibou_area'] ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>通勤可能時間</td>
                            <td style='width:70%;'><?=getComuterTime($data['StuffMaster']['commuter_time']) ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>当社以外の職業</td>
                            <td style='width:70%;'><?=getShokugyou2($data['StuffMaster']['extra_job']) ?><?=getShokugyou3($data['StuffMaster']['extra_job_etc']); ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>配偶者</td>
                            <td style='width:70%;'><?=getTF($data['StuffMaster']['haiguusha']) ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>身長</td>
                            <td style='width:70%;'><?=$data['StuffMaster']['height'] ?> cm</td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>制服サイズ</td>
                            <td style='width:70%;'>上：<?=$data['StuffMaster']['size_1'] ?>号　下：<?=$data['StuffMaster']['size_2'] ?>号</td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>喫煙について</td>
                            <td style='width:70%;'><?=getTF($data['StuffMaster']['smoking']) ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>眼鏡使用について</td>
                            <td style='width:70%;'><?=getTF($data['StuffMaster']['glasses']) ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>給与振込先銀行</td>
                            <td style='width:70%;'><?=$data['StuffMaster']['bank_name'] ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>支店名</td>
                            <td style='width:70%;'><?=$data['StuffMaster']['bank_shiten'] ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>口座番号</td>
                            <td style='width:70%;'><?=getKouza($data['StuffMaster']['bank_type']) ?> <?=$data['StuffMaster']['bank_kouza_num'] ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>口座名義</td>
                            <td style='width:70%;'><?=$data['StuffMaster']['bank_kouza_meigi'] ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>社会保険希望</td>
                            <td style='width:70%;'><?=getTF($data['StuffMaster']['shaho_kibou']) ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>社会保険未加入の理由</td>
                            <td style='width:70%;'><?=$data['StuffMaster']['shaho_mikanyuu'] ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>年末調整</td>
                            <td style='width:70%;'><?php echo getNenmatsu($data['StuffMaster']['nenmatsu_chousei']); ?></td>
                        </tr>
                        <tr>
                            <td style='background-color: #e8ffff;width:30%;'>備考</td>
                            <td style='width:70%;'><?= str_replace("\n","<br />",$data['StuffMaster']['remarks']); ?></td>
                        </tr>
                    </table>  

                <div style='margin-left: 10px;'>
            
        </td>
        <td style="width:50%;vertical-align: top;padding-left: 5px;">
            <div style="color: black;background-color: #ffff99;border:1px solid orange;padding:0px;vertical-align: middle;padding-left: 10px;margin-bottom: 10px;">
                <?php echo $this->Form->create('StuffMaster'); ?>
                <?php echo $this->Form->submit('編集', array('name' => 'submit','div' => false)); ?>
                &nbsp;&nbsp;
                <?php $comment = __('本当に登録解除してよろしいですか？', true); ?>
                <?php echo $this->Form->submit('登録解除', array('name' => 'release', 'div' => false, 'onclick' => 'return confirm("'.$comment.'");')); ?>
                &nbsp;&nbsp;
                <?php print($this->Html->link('閉じる', 'javascript:void(0);', array('class'=>'button-rink', 'onclick'=>'javascript:window.opener.location.reload();window.close();'))); ?>
                &nbsp;&nbsp;
                <?php print($this->Html->link('印刷する', 'javascript:void(0);', array('class'=>'button-rink', 'onclick'=>'javascript:window.close();'))); ?>
                &nbsp;&nbsp;
                <?php print($this->Html->link('◀前へ', 'javascript:void(0);', array('class'=>'button-rink', 'onclick'=>'javascript:window.close();'))); ?>
                &nbsp;&nbsp;
                <?php print($this->Html->link('次へ▶', 'javascript:void(0);', array('class'=>'button-rink', 'onclick'=>'javascript:window.close();'))); ?>
                <?php echo $this->Form->input('id', array('type'=>'hidden', 'value' => $id)); ?>
                <?php echo $this->Form->input('kaijo_flag', array('type'=>'hidden', 'value' => 1)); ?>
                <?php echo $this->Form->end(); ?>  
            </div>
            
            <!-- 登録者メモ -->
            <font style="font-size: 120%;">登録者メモ</font>
            <?php echo $this->Form->create('StuffMemo'); ?>
            <table border='1' cellspacing="0" cellpadding="3" style="width:100%;margin-top: 0px;margin-bottom: 10px;border-spacing: 1px;">
                <tr>
                    <td colspan="2" style='background-color: #e8ffff;'>メモ一覧</td>
                </tr>
                <tr>
                    <td align="center" style="width:80%;">
                        <?php echo $this->Form->input('memo',array('label'=>false,'div'=>false,'maxlength'=>'30','style'=>'width:95%;padding:3px;')); ?>
                        <?php echo $this->Form->input('username',array('type'=>'hidden', 'value' => $username)); ?>
                        <?php echo $this->Form->input('stuff_id',array('type'=>'hidden', 'value' => $id)); ?>
                    </td>
                    <td align="center"><?php echo $this->Form->submit('書き込み', array('name' => 'comment','div' => false)); ?></td>
                </tr>
                <?php foreach($memo_datas as $data) { ?>
                <tr>
                    <td align="left"><?=$data['StuffMemo']['memo'] ?></td>
                    <td align="center"><?php echo $this->Form->submit('削　除', array('name' => 'delete','div' => false)); ?></td>
                </tr>
                <?php } ?>
            </table>
            <?php echo $this->Form->end(); ?>  
            
            <!-- 勤務実績一覧 -->
            <font style="font-size: 120%;">勤務実績一覧</font>
            <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 0px;margin-bottom: 10px;border-spacing: 1px;">
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>日付</td>
                    <td style='background-color: #e8ffff;width:70%;'>案件名</td>
                </tr>
                <tr>
                    <td style='width:30%;'></td>
                    <td style='width:70%;'></td>
                </tr>
            </table>
            
            <!-- メールボックス -->
            <font style="font-size: 120%;">メールボックス</font>
            <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 0px;margin-bottom: 10px;border-spacing: 1px;">
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>日付</td>
                    <td style='background-color: #e8ffff;width:70%;'>タイトル</td>
                </tr>
                <tr>
                    <td style='width:30%;'></td>
                    <td style='width:70%;'></td>
                </tr>
            </table>
            
            <!-- 評価項目 -->
            <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 0px;margin-bottom: 10px;border-spacing: 1px;">
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>OJT/実施日</td>
                    <td style='width:70%;'><?= getOjt($data['StuffMaster']['ojt']); ?> / <?= $data['StuffMaster']['ojt_date']; ?></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>表情</td>
                    <td style='width:70%;'><?=getHyouka($data['StuffMaster']['hyouka_hyoujou']); ?></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>発声・滑舌</td>
                    <td style='width:70%;'><?=getHyouka($data['StuffMaster']['hyouka_hassei']); ?></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>明るさ</td>
                    <td style='width:70%;'><?=getHyouka($data['StuffMaster']['hyouka_akarusa']); ?></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>華やかさ</td>
                    <td style='width:70%;'><?=getHyouka($data['StuffMaster']['hyouka_hanayakasa']); ?></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>清潔感</td>
                    <td style='width:70%;'><?=getHyouka($data['StuffMaster']['hyouka_seiketsukan']); ?></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>メイク</td>
                    <td style='width:70%;'><?=getHyouka($data['StuffMaster']['hyouka_make']); ?></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>髪型</td>
                    <td style='width:70%;'><?=getHyouka($data['StuffMaster']['hyouka_hairstyle']); ?></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>姿勢</td>
                    <td style='width:70%;'><?=getHyouka($data['StuffMaster']['hyouka_shisei']); ?></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>所作</td>
                    <td style='width:70%;'><?=getHyouka($data['StuffMaster']['hyouka_shosa']); ?></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>柔軟さ</td>
                    <td style='width:70%;'><?=getHyouka($data['StuffMaster']['hyouka_juunansa']); ?></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>ハキハキ感</td>
                    <td style='width:70%;'><?=getHyouka($data['StuffMaster']['hyouka_hakihaki']); ?></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>協力度</td>
                    <td style='width:70%;'><?=getHyouka($data['StuffMaster']['hyouka_kyouryoku']); ?></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>雰囲気</td>
                    <td style='width:70%;'><?=getHyouka($data['StuffMaster']['hyouka_funiki']); ?></td>
                </tr>
                <tr>
                    <td style='background-color: #e8ffff;width:30%;'>備考</td>
                    <td style='width:70%;'><?= str_replace("\n","<br />",$data['StuffMaster']['hyouka_remarks']); ?></td>
                </tr>
            </table>  
                  
        </td>
    </tr>
</table>

<?php endforeach; ?>


