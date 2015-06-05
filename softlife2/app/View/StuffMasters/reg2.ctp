<?php
    echo $this->Html->script( 'tools');
    //echo $this->Html->script('dropzone');
    echo $this->Html->script('jquery-1.9.1');
    echo $this->Html->script('station3');
?>
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
<!-- for Datepicker -->
<link type="text/css" rel="stylesheet"
  href="http://code.jquery.com/ui/1.10.3/themes/cupertino/jquery-ui.min.css" />
<script type="text/javascript"
  src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script type="text/javascript"
  src="http://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
<!--1国際化対応のライブラリをインポート-->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/i18n/jquery-ui-i18n.min.js"></script>
<script type="text/javascript">
$(function() {
  // 2日本語を有効化
  $.datepicker.setDefaults($.datepicker.regional['ja']);
  // 3日付選択ボックスを生成
  $('.date').datepicker({ dateFormat: 'yy/mm/dd' });
});
</script>

<div style="width:90%;margin-top: 20px;margin-left: auto; margin-right: auto;">
    <fieldset style="border:none;margin-bottom: 20px;">
        <legend style="font-size: 150%;color: red;"><?php echo __('スタッフ登録 （基本情報）'); ?></legend>
<?php echo $this->Form->create('StuffMaster', array('name' => 'form','enctype' => 'multipart/form-data','id' => 'regist')); ?>
<?php echo $this->Form->input('id', array('type'=>'hidden', 'value' => $stuff_id)); ?>   
<?php echo $this->Form->input('username', array('type'=>'hidden', 'value' => $username)); ?>
        
        <!-- スタッフ情報 -->
        <table border='1' cellspacing="0" cellpadding="5" style='width: 100%;margin-top: 10px;border-spacing: 0px;'>
            <tr>
                <th colspan="2" style='background:#99ccff;text-align: center;'>スタッフ情報</th>
            </tr>
            <tr>
                <td colspan="2">
                    登録番号：<?=$stuff_id ?>&nbsp;&nbsp;
                    作成日：<?=$created ?>&nbsp;&nbsp;更新日：<?=$modified ?>&nbsp;&nbsp;所属：<?=$class ?>
                </td>
            </tr>
        </table>
        <!-- 個人情報付則 -->
        <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;border-spacing: 0px;">
            <tr>
                <th colspan="7" style='background:#99ccff;text-align: center;'>個人情報付則</th>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:100px;'>証明写真</td>
                <td colspan="4">
                    <!-- 証明写真ドラッグ＆ドロップ -->
                    <input type="file" name="upfile[]" size="30" onchange=""  style="
                        border: 2px dotted #000000;
                        font-size: 100%;
                        width:300px;
                        height: 25px;
                        padding-top: 50px;
                        padding-bottom: 50px;
                        background-color: #ffffcc;
                        border-radius: 10px;        /* CSS3草案 */  
                        -webkit-border-radius: 10px;    /* Safari,Google Chrome用 */  
                        -moz-border-radius: 10px;   /* Firefox用 */
                        vertical-align: middle;
                       ">
                    <!-- 証明写真ファイルのリンク -->
                    <?php
                        $after = $data['StuffMaster']['pic_extension'];
                        if (is_null($after)) {
                            echo '';
                        } else {
                            echo '<br>';
                            echo '<a href="javascript:void(0);" onclick=window.open("'.ROOTDIR.'/files/stuff_reg/'.$class.'/'.$stuff_id.'/'.$stuff_id.'.'.$after.'","証明写真","width=800,height=800,scrollbars=yes"); style="color:red;">【保存している証明写真】</a>';
                        }
                    ?>
                </td>
                <td style='background-color: #e8ffff;width:100px;'>履歴書<br><font style='color: red;'>PDFファイル</font></td>
                <td colspan="1">
                    <!-- 履歴書ドラッグ＆ドロップ -->
                    <input type="file" name="upfile[]" size="30" onchange="fileCheck(this, 'pdf');"  style="
                        border: 2px dotted #000000;
                        font-size: 100%;
                        width:300px;
                        height: 25px;
                        padding-top: 50px;
                        padding-bottom: 50px;
                        background-color: #ffffcc;
                        border-radius: 10px;        /* CSS3草案 */  
                        -webkit-border-radius: 10px;    /* Safari,Google Chrome用 */  
                        -moz-border-radius: 10px;   /* Firefox用 */
                        vertical-align: middle;
                       ">
                    <!-- 保存ファイルのリンク -->
                    <?php
                        $after2 = $data['StuffMaster']['pic_extension2'];
                        if (is_null($after2)) {
                            echo '';
                        } else {
                            echo '<br>';
                            echo '<a href="javascript:void(0);" onclick=window.open("'.ROOTDIR.'/files/stuff_reg/'.$class.'/'.$stuff_id.'/'.$stuff_id.'.'.$after2.'","履歴書","width=800,height=800,scrollbars=yes"); style="color:red;">【保存している履歴書】</a>';
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;' rowspan="2">身長</td>
                <td style='width:150px;' rowspan="2"><?php echo $this->Form->input('height',array('label'=>false,'div'=>false,'style'=>'width:100px;')); ?>&nbsp;cm</td>
                <td style='background-color: #e8ffff;' rowspan="2">制服サイズ</td>
                <td style='width:30px;'>上</td>
                <td colspan='3' style='width:200px;'>
                <?php
                    $list=array('5'=>'5号','7'=>'7号','9'=>'9号','11'=>'11号','13'=>'13号');
                    echo $this->Form->input( 'size_1', array('legend' => false, 'type' => 'radio','div'=>'radio',
                        'options' => $list));
                ?>
                </td>
            </tr>
            <tr>
                <td style='width:30px;'>下</td>
                <td colspan='3' style='width:200px;'>
                <?php
                    $list1=array('5'=>'5号','7'=>'7号','9'=>'9号','11'=>'11号','13'=>'13号');
                    echo $this->Form->input( 'size_2', array('legend' => false, 'type' => 'radio','div'=>'radio',
                        'options' => $list1));
                ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;'>最寄駅①</td>
                <td colspan="6">
                    <?php echo $this->Form->input('pref1',array('type'=>'select','label'=>false,'div'=>false, 'empty'=>'都道府県を選択してください', 'style' => 'width: 100px;', 
                        'onChange'=>'setMenuItem1(0,this[this.selectedIndex].value)', 'options'=>$pref_arr)); ?>
                    &nbsp;→              
<?php echo $this->Form->input('s0_1',array('type'=>'select','label'=>false,'div'=>false, 'empty'=>'路線を選択してください', 'style' => 'width: 200px;', 
    'onChange'=>'setMenuItem1(1,this[this.selectedIndex].value)', 'options' => $line1)); ?>
                    →               
<?php echo $this->Form->input('s1_1',array('type'=>'select','label'=>false,'div'=>false, 'empty'=>'駅を選択してください', 'style' => 'width: 150px;', 'options' => $station1)); ?>
                    駅
<?php echo $this->Form->input('s2_1',array('type'=>'select','label'=>false,'div'=>false, 'empty'=>'駅を選択してください', 'style' => 'width: 150px;display:none;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;'>最寄駅②</td>
                <td colspan="6">
                    <?php echo $this->Form->input('pref2',array('type'=>'select','label'=>false,'div'=>false, 'empty'=>'都道府県を選択してください', 'style' => 'width: 100px;', 
                        'onChange'=>'setMenuItem2(0,this[this.selectedIndex].value)', 'options'=>$pref_arr)); ?>
                    &nbsp;→
<?php echo $this->Form->input('s0_2',array('type'=>'select','label'=>false,'div'=>false, 'empty'=>'路線を選択してください', 'style' => 'width: 200px;', 
    'onChange'=>'setMenuItem2(1,this[this.selectedIndex].value)', 'options' => $line2)); ?>
                    →
<?php echo $this->Form->input('s1_2',array('type'=>'select','label'=>false,'div'=>false, 'empty'=>'駅を選択してください', 'style' => 'width: 150px;', 'options' => $station2)); ?>
                    駅
<?php echo $this->Form->input('s2_2',array('type'=>'select','label'=>false,'div'=>false, 'empty'=>'駅を選択してください', 'style' => 'width: 150px;display:none;')); ?>
                    </select> 
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;'>最寄駅③</td>
                <td colspan="6">
                    <?php echo $this->Form->input('pref3',array('type'=>'select','label'=>false,'div'=>false, 'empty'=>'都道府県を選択してください', 'style' => 'width: 100px;', 
                        'onChange'=>'setMenuItem3(0,this[this.selectedIndex].value)', 'options'=>$pref_arr)); ?>
                    &nbsp;→
<?php echo $this->Form->input('s0_3',array('type'=>'select','label'=>false,'div'=>false, 'empty'=>'路線を選択してください', 'style' => 'width: 200px;', 
    'onChange'=>'setMenuItem3(1,this[this.selectedIndex].value)', 'options' => $line3)); ?>
                    →
<?php echo $this->Form->input('s1_3',array('type'=>'select','label'=>false,'div'=>false, 'empty'=>'駅を選択してください', 'style' => 'width: 150px;', 'options' => $station3)); ?>
                    駅
<?php echo $this->Form->input('s2_3',array('type'=>'select','label'=>false,'div'=>false, 'empty'=>'駅を選択してください', 'style' => 'width: 150px;display:none;')); ?>
                    </select> 
                </td>
            </tr>
        </table>
        
        <!-- 勤務について -->
        <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;border-spacing: 0px;">
            <tr>
                <th colspan="4" style='background:#99ccff;text-align: center;'>勤務について</th>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>勤務開始希望日</td>
                <td style='width:30%;'>
                    <?php echo $this->Form->input('job_startdate_kibou',array('type'=>'text','div'=>false,'label'=>false,'class'=>'date','style'=>'width:50%;text-align: left;')); ?>
                </td>
                <td style='background-color: #e8ffff;width:20%;'>研修希望日</td>
                <td style='width:30%;'>
                    <?php echo $this->Form->input('training_date_kibou',array('type'=>'text','div'=>false,'label'=>false,'class'=>'date','style'=>'width:50%;text-align: left;')); ?>
                </td>
            </tr>
<?php 
    $list_shokushu = array('1'=>'受付　', '2'=>'フロア受付　', '3'=>'シッター　', '4'=>'ナレーター　', '5'=>'ＤＨ　', '6'=>'看板持ち　', '7'=>'事務　', '8'=>'誘導案内　', '9'=>'内覧会スタッフ '); 
    //$selected = array('1', '3', '7');
    $list_shokugyou = array('1'=>'会社員　', '2'=>'主婦　', '3'=>'学生　', '4'=>'派遣　', '5'=>'アルバイト　', '6'=>'その他');
    $list_workable = array('1'=>'特になし ', '2'=>'平日のみ ', '3'=>'土日のみ ', '4'=>'土日祝のみ ', '5'=>'月 ', '6'=>'火 ', '7'=>'水 ', '8'=>'木 ', '9'=>'金 ', '10'=>'土 ', '11'=>'日 ');
    $list_trigger = array('1' => '紹介　', '2' => 'インターネット求人媒体　', '3' => '紙面求人媒体　', '4' => '当社ＨＰ　', '5' => 'その他　');
?>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>紹介可能職種</td>
                <td colspan="3">
                    <?php echo $this->Form->input('shokushu_shoukai', array('type'=>'select','multiple' => 'checkbox','div'=>'checkbox','label'=>false, 'style'=>'width:70%;text-align: left;','selected'=>$selected1, 'options'=>$list_shokushu)); ?>
		</td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>希望職種</td>
                <td colspan="3">
                    <?php echo $this->Form->input('shokushu_kibou', array('type'=>'select','multiple' => 'checkbox','div'=>'checkbox','label'=>false, 'style'=>'width:70%;text-align: left;','selected'=>$selected2, 'options'=>$list_shokushu)); ?>
		</td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>希望勤務回数</td>
                <td colspan="3">週<?php echo $this->Form->input('per_week',array('type'=>'text','div'=>false,'maxlength'=>'1','label'=>false,'style'=>'width:50px;')); ?>回
                    &nbsp;／&nbsp;
                    月<?php echo $this->Form->input('per_month',array('type'=>'text','div'=>false,'maxlength'=>'2','label'=>false,'style'=>'width:50px;')); ?>回</td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>希望エリア</td>
                <td colspan="3"><?php echo $this->Form->input('kibou_area',array('type'=>'text','div'=>false,'maxlength'=>'30','label'=>false,'style'=>'width:500px;')); ?></td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>通勤可能時間</td>
                <td colspan="3">
                <?php
                    $list2=array('30'=>'30分以内','60'=>'1時間以内','90'=>'1時間30分以内','100'=>'それ以上可');
                    echo $this->Form->input( 'commuter_time', array('legend' => false, 'type' => 'radio','div'=>'radio',
                        'options' => $list2));
                ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>勤務可能曜日</td>
                <td colspan="3">
                    <?php echo $this->Form->input('workable_day', array('type'=>'select','multiple' => 'checkbox','div'=>'checkbox','label'=>false, 'style'=>'width:70%;text-align: left;','selected'=>$selected5, 'options'=>$list_workable)); ?>
                </td>
            </tr>
        </table>
         
        <!-- 経理関係 -->
        <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;border-spacing: 0px;">
            <tr>
                <th colspan="8" style='background:#99ccff;text-align: center;'>経理関係</th>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:15%;' rowspan="2">給与振込先</td>
                <td style='background-color: #e8ffff;width:20%;'>銀行名</td>
                <td colspan="2"><?php echo $this->Form->input('bank_name',array('type'=>'text','div'=>false,'maxlength'=>'30','label'=>false,'style'=>'width:150px;')); ?></td>
                <td style='background-color: #e8ffff;width:20%;'>支店名</td>
                <td colspan="3"><?php echo $this->Form->input('bank_shiten',array('type'=>'text','div'=>false,'maxlength'=>'30','label'=>false,'style'=>'width:200px;')); ?></td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>普通・当座</td>
                <td colspan="2">
                <?php
                    $list3=array('1'=>'普通','2'=>'当座');
                    echo $this->Form->input( 'bank_type', array('legend' => false, 'type' => 'radio','div'=>'radio',
                        'options' => $list3));
                ?>
                </td>
                <td style='background-color: #e8ffff;width:20%;'>口座番号</td>
                <td><?php echo $this->Form->input('bank_kouza_num',array('type'=>'text','div'=>false,'maxlength'=>'10','label'=>false,'style'=>'width:70px;')); ?></td>
                <td style='background-color: #e8ffff;width:20%;'>口座名義</td>
                <td><?php echo $this->Form->input('bank_kouza_meigi',array('type'=>'text','div'=>false,'maxlength'=>'20','label'=>false,'style'=>'width:150px;')); ?></td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>社会保険希望</td>
                <td>
                <?php
                    $list4=array('1'=>'無','2'=>'有');
                    echo $this->Form->input( 'shaho_kibou', array('legend' => false, 'type' => 'radio','div'=>'radio',
                        'options' => $list4));
                ?>
                </td>
                <td style='background-color: #e8ffff;width:20%;'>社会保険未加入の理由</td>
                <td colspan="5"><?php echo $this->Form->input('shaho_mikanyuu',array('type'=>'text','div'=>false,'maxlength'=>'50','label'=>false,'style'=>'width:500px;')); ?></td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>年末調整希望</td>
                <td>
                <?php
                    $list5=array('1'=>'無','2'=>'有');
                    echo $this->Form->input( 'nenmatsu_chousei', array('legend' => false, 'type' => 'radio','div'=>'radio',
                        'options' => $list5));
                ?>
                </td>
                <td style='background-color: #e8ffff;width:20%;'>配偶者</td>
                <td colspan="5">
                <?php
                    $list6=array('1'=>'無','2'=>'有');
                    echo $this->Form->input( 'haiguusha', array('legend' => false, 'type' => 'radio','div'=>'radio',
                        'options' => $list6));
                ?>
                </td>
            </tr>
        </table>
         
        <!-- その他 -->
        <table border='1' cellspacing="0" cellpadding="5" style="width:100%;margin-top: 10px;border-spacing: 0px;">
            <tr>
                <th colspan="6" style='background:#99ccff;text-align: center;'>その他</th>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>経験職種</td>
                <td colspan="5">
                    <?php echo $this->Form->input('shokushu_keiken', array('type'=>'select','multiple' => 'checkbox','div'=>'checkbox','label'=>false, 'style'=>'width:70%;text-align: left;','selected'=>$selected3, 'options'=>$list_shokushu)); ?>
		</td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>マンションギャラリー経験</td>
                <td>
                <?php
                    $list7=array('1'=>'無','2'=>'有');
                    echo $this->Form->input( 'keiken_mansion', array('legend' => false, 'type' => 'radio','div'=>'radio',
                        'options' => $list7));
                ?>
                </td>
                <td style='background-color: #e8ffff;width:20%;'>喫煙について</td>
                <td>
                <?php
                    $list8=array('1'=>'禁煙','2'=>'喫煙');
                    echo $this->Form->input( 'smoking', array('legend' => false, 'type' => 'radio','div'=>'radio',
                        'options' => $list8));
                ?>
                </td>
                <td style='background-color: #e8ffff;width:20%;'>眼鏡使用について</td>
                <td>
                <?php
                    $list9=array('1'=>'無','2'=>'有');
                    echo $this->Form->input( 'glasses', array('legend' => false, 'type' => 'radio','div'=>'radio',
                        'options' => $list9));
                ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:15%;'>当社以外の職業</td>
                <td colspan="5">
                    <?php echo $this->Form->input('extra_job', array('type'=>'select','multiple' => 'checkbox','div'=>'checkbox','label'=>false, 'style'=>'width:70%;text-align: left;','selected'=>$selected4, 'options'=>$list_shokugyou)); ?>
                    &nbsp;
                    <?php echo $this->Form->input('extra_job_etc',array('type'=>'text','div'=>false,'maxlength'=>'30','label'=>false,'style'=>'width:40%;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:15%;'>登録のきっかけ</td>
                <td colspan="5">
                    <?php echo $this->Form->input('regist_trigger', array('type'=>'select','multiple' => 'checkbox','div'=>'checkbox','label'=>false, 'style'=>'width:70%;text-align: left;','selected'=>$selected6, 'options'=>$list_trigger)); ?>
                </td> 
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:15%;'>備考</td>
                <td colspan="5"><?php echo $this->Form->input('remarks',array('type'=>'textarea','div'=>false,'maxlength'=>'500','label'=>false,'style'=>'width:90%;height:100px;')); ?></td> 
            </tr>
        </table>


    </fieldset>
    <div style='margin-left: 10px;'>
<?php echo $this->Form->submit('次へ進む', array('name' => 'submit','div' => false)); ?>
    &nbsp;&nbsp;
<?php $back_url = '/stuff_masters/reg1/'.$stuff_id; ?>
<?php print($this->Html->link('戻　る', $back_url, array('class'=>'button-rink'))); ?>
    </div>
<?php echo $this->Form->end(); ?>
</div>