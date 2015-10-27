<?php require 'schedule_element.ctp'; ?>
<!--
<div id="loading"><img src="<?=ROOTDIR ?>/img/loading.gif"></div>
-->
<?php echo $this->Form->create('WorkTable', array('name'=>'frm', 'id'=>'form')); ?> 
<!-- 見出し１ -->
<div id='headline' style="padding:4px 10px 4px 10px;">
    <div style="float: left;padding-top: 5px;">
        ★ シフト管理
        &nbsp;&nbsp;
        <a href="<?=ROOTDIR ?>/ShiftManagement/index?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' 0 month')); ?>" target=""><font Style="font-size:95%;">スタッフシフト希望</font></a>
        &nbsp;
        <b><font Style="font-size:95%;color: yellow;">[シフト作成]</font></b>        <!-- alert("制作中");return false; -->
        &nbsp;
        <a href="<?=ROOTDIR ?>/ShiftManagement/schedule3?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' 0 month')); ?>" target="" id="shift" class="load" onclick=''><font Style="font-size:95%;">確定シフト</font></a>        <!-- alert("制作中");return false; -->
        &nbsp;
        <a href="<?=ROOTDIR ?>/ShiftManagement/uri9" target=""><font Style="font-size:95%;">勤務実績</font></a>
        &nbsp;
        <a href="<?=ROOTDIR ?>/ShiftManagement/setting" target="" onclick=''><font Style="font-size:95%;">詳細設定</font></a>
        &nbsp;
    </div>
    <div style="float:right;padding-top: 1px;">
        <?php $comment = '【注意！】いままで保存した当月のシフトデータは消去されます。\n自動割付を実行しますか？'; ?>
        <input type="submit" name="assignment" value="シフト自動割付" id="<?=$button_type2 ?>" class="check" style="" onclick="return window.confirm('<?=$comment ?>');" <?=$disabled ?>>
            &nbsp;
            <input type="button" id="<?=$button_type2 ?>" class="check" value="一時保存" style="cursor: pointer;border:1px solid black;" onclick="doAccount(<?=$y ?>,<?=sprintf("%02d", $m) ?>, 1);" <?=$disabled ?>>
            &nbsp;
        <input type="button" name="check_duplication" value="重複チェック" id="<?=$button_type3 ?>" class="check"
               style="cursor: pointer;border:1px solid black;padding: 5px 10px;" onclick="doAccount(<?=$y ?>,<?=sprintf("%02d", $m) ?>, 2);" <?=$disabled ?>>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="text" value="<?=displayCommit($flag); ?>" 
               style="text-align: center;width: 100px;font-size: 110%;margin-right:30px;font-family: メイリオ;<?=commitStyle($flag); ?>" disabled="disabled">
    </div>
    <div style="clear:both;"></div>
</div>
<!-- 見出し１ END -->

<?php
    $year_arr = array();
    $year_arr = array('1999'=>'1999');
    for($j=2000; $j<2100; $j++) {
        $year_arr += array($j => $j); 
    }
    $month_arr = array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12'); 
?>
<div id="main" style="width:100%;height:720px;margin-top: 0px;<?=$font_normal ?>;">
    <table border='1' cellspacing="0" cellpadding="3" style="width:100%;margin-top: -5px;border-spacing: 0px;background-color: white;">
        <tr align="center">
                <td style=''><a href="<?=ROOTDIR ?>/ShiftManagement/schedule?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' -1 month')); ?>" class="load">&lt; 前の月</a></td>
                <td style='background-color: #006699;color: white;width: 700px;'>
                    <font style='font-size: 110%;'>
                        <a href="<?=ROOTDIR ?>/ShiftManagement/schedule?date=<?=date('Y-m', strtotime($y .'-' . $m . ' -1 month')); ?>" style="color:white;" class="load">◀</a>
                            【<?php echo $this->Form->input(false, array('id'=>'year', 'type'=>'select','div'=>false,'label'=>false, 'options' => $year_arr,
                                    'value'=>$year, 'style'=>'text-align: left;font-size: 100%;', 'class'=>'load2',
                                    'onchange'=>'setCalender(this, document.getElementById("month"))')); ?>&nbsp;年
                                <?php echo $this->Form->input(false, array('id'=>'month', 'type'=>'select','div'=>false,'label'=>false, 'options' => $month_arr,
                                    'value'=>$month, 'style'=>'text-align: right;font-size: 100%;',  'class'=>'load2',
                                    'onchange'=>'setCalender(document.getElementById("year"), this)')); ?>
                        <a href="#" style="color: white; text-decoration: none;" onclick="location.reload();" class="load">
                            月&nbsp;稼働表】
                        </a>
                        <a href="<?=ROOTDIR ?>/ShiftManagement/schedule?date=<?=date('Y-m', strtotime($y .'-' . $m . ' +1 month')); ?>" style="color:white;" class="load">▶</a>
                    </font>
                    <input type="hidden" name="month" value="<?=$y.'-'.$m ?>">
                </td>
                <td style=''><a href="<?=ROOTDIR ?>/ShiftManagement/schedule?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' +1 month')); ?>" class="load">次の月 &gt;</a></td>
        </tr>
    </table>
    
    <!-- 外枠 -->      
    <div id="redips-drag" class="x_data_area" style="position: relative;margin-top: 5px;margin-bottom: 10px;height: 90%;">
        <!-- ロック部分（左上） -->
        <table class=t  style="width:120px;height:51px;position:absolute;left:0px;top:0px;table-layout: fixed;text-align: center;">
            <tr>
                <th style='background:#99ccff;text-align: center;width:120px;height: 50px;font-size: 80%;' colspan="2">
                    <a href="#" onclick="setHidden();">
                        <span id="ActiveDisplay" onclick="">【表示切り替え】</span>
                    </a>
                </th>
            </tr>
        </table>
        <!-- ロック部分（上） -->
        <div id="header_h">
            <table border='1' cellspacing="0" cellpadding="5" id=""
                   style="width:<?=$col*120 ?>px;margin-top: 0px;margin-bottom: 0px;border-spacing: 0px;table-layout: fixed;font-size: 90%;">
                <colgroup> 
                  <?php for ($count=0; $count<$col; $count++){ ?>
                  <col style='width:120px;'>
                  <?php } ?>
                </colgroup>
                <tr>
                    <?php foreach ($datas as $key=>$data){ ?>
                    <th id="case_<?=$data['OrderCalender']['case_id'] ?>" 
                        style='background:#99ccff;text-align: center;height: 36px;background-color: <?=setBGColor($data['OrderCalender']['case_id'], $list_bgcolor) ?>;
                        color: <?=setColor($data['OrderCalender']['case_id'], $list_color) ?>;' colspan="<?=$data[0]['cnt'] ?>">
                    <?php echo $getCasename[$data['OrderCalender']['case_id']]; ?>
                    </th>
                    <?php } ?>
                </tr>
            </table>
        </div>
        <!-- ロック部分（左） -->
        <div class="lock_box" id="header_v">
            <table border='1' cellspacing="0" cellpadding="5" class="data" 
                   style="background-color: #e8ffff;margin-top: 0px;margin-bottom: 0px;border-spacing: 0px;table-layout: fixed;font-size: 90%;">
                <col style="width: 25px;" />
                <col style="width: 95px;" />
                <tr id="OrderDetail0_0">
                    <td colspan="2" style="height:30px;text-align: center;">弊社担当</td>
                </tr>
                <tr id="OrderDetail0_1">
                    <td colspan="2" style="height:57px;text-align: center;">事業主</td>
                </tr>
            <tr id="OrderDetail0_2">
                <td colspan="2" style="height:36px;text-align: center;">販売会社</td>
            </tr>
            <tr id="OrderDetail0_3">
                <td colspan="2" style="height:55px;text-align: center;">指揮命令者/<br>担当者</td>
            </tr>
            <tr id="OrderDetail0_4">
                <td colspan="2" style="height:50px;text-align: center;">現場住所</td>
            </tr>
            <tr id="OrderDetail0_5">
                <td colspan="2" style="height:50px;text-align: center;">現場連絡先</td>
            </tr>
            <tr id="OrderDetail0_6">
                <td colspan="2" style="height:67px;text-align: center;">待ち合わせ</td>
            </tr>
            <tr id="OrderDetail0_7">
                <td colspan="2" style="height:56px;text-align: center;">請求先担当者</td>
            </tr>
            <tr id="OrderDetail0_8">
                <td colspan="2" style="height:30px;text-align: center;">請求書締日</td>
            </tr>
            <tr id="OrderDetail0_19">
                <td colspan="2" style="height:30px;text-align: center;">請求書郵送日</td>
            </tr>
            <tr id="OrderDetail0_9">
                <td colspan="2" style="height:30px;text-align: center;">クリーニング</td>
            </tr>
            <!-- 受注 -->
            <tr id="OrderDetail0_10">
                <td rowspan="3" style='background-color: #e8ffff;height:81px;'>請<br>求<br>分</td>
                <td rowspan="2" style='background-color: #e8ffff;height:56px;'>単価</td>
            </tr>
            <tr id="OrderDetail0_11">
            </tr>
            <tr id="OrderDetail0_12">
                <td rowspan="1" style='background-color: #e8ffff;height:25px;'>残業／ｈ</td>
            </tr>
            <!-- 受注 END -->
            <!-- 給与 -->
            <tr id="OrderDetail0_13">
                <td rowspan="4" style='background-color: #e8ffff;height:100px;'>ス<br>タ<br>ッ<br>フ<br>分</td>
                <td style='background-color: #e8ffff;height:25px;'>時給</td>
            </tr>
            <tr id="OrderDetail0_14">
                <td style='background-color: #e8ffff;height:25px;'>基本日給</td>
            </tr>
            <tr id="OrderDetail0_15">
                <td style='background-color: #e8ffff;height:25px;'>残業／ｈ</td>
            </tr>
            <tr id="OrderDetail0_16">
                <td style='background-color: #e8ffff;height:25px;'>研修中（時給）</td>
            </tr>
            <!-- 給与 END -->
                <tr>
                    <td colspan="2" style="height:30px;text-align: center;">
                        職種
                        <div id="message" style="display: none;"></div>
                    </td>
                </tr>
            <tr id="OrderDetail0_17">
                <td style='background-color: #e8ffff;height:70px;' colspan="2">勤務時間</td>
            </tr>
            <tr id="OrderDetail0_18">
                <td style='background-color: #e8ffff;height:30px;' colspan="2">休憩時間</td>
            </tr>
                <tr>
                    <td colspan="2" style="height:75px;text-align: center;">推奨スタッフ</td>
                </tr>
                <tr>
                    <td colspan="2" style="height:50px;text-align: center;">前月スタッフ</td>
                </tr>
                <tr>
                    <td class="redips-trash" style='background-color: #999999;color: white;height:25px;' colspan="2">削除</td>
                </tr>
                <?php
                    // 曜日の配列作成
                    $weekday = array( "日", "月", "火", "水", "木", "金", "土" );
                    // 1日の曜日を数値で取得
                    $fir_weekday = date( "w", mktime( 0, 0, 0, $m, 1, $y ) );
                    // 1日の曜日設定
                    $i = $fir_weekday; // カウント値リセット
                ?>
                <!-- カレンダー部分 --> 
                <?php
                    // 今月の日付が存在している間ループする
                    for( $d=1; checkdate( $m, $d, $y ); $d++ ){
                        //曜日の最後まできたらカウント値（曜日カウンター）を戻して行を変える
                        if( $i > 6 ){
                            $i = 0;
                        }
                    //-------------スタイルシート設定-----------------------------------
                        if( $i == 0 || !empty($national_holiday[date("Ymd", mktime(0, 0, 0, $m, $d, $y))])){ //日曜日の文字色
                            $style = "#C30";
                        }
                        else if( $i == 6 ){ //土曜日の文字色
                            $style = "#03C";
                        } else{ //月曜～金曜日の文字色
                            $style = "black";
                        }
                        $style2 = '';
                    //-------------スタイルシート設定終わり-----------------------------

                        // 日付セル作成とスタイルシートの挿入
                        echo '<tr style="'.$style2.';">';
                        echo '<td align="center" style="color:'.$style.';background-color: #e8ffff;height:30px;" colspan="2">'.$m.'/'.$d.'('.$weekday[$i].')';
                        if ($i==0 || $i==6) {
                            echo '<input type="hidden" id="HolidayD'.$d.'" value="1">';
                        } else {
                            echo '<input type="hidden" id="HolidayD'.$d.'" value="0">';
                        }
                        for ($count=0; $count<$col; $count++){
                            if (empty($datas2) || empty($datas2[$count])) {
                                $class_name = 'redips-mark';
                            } elseif ($datas2[$count]['OrderCalender']['d'.$d] == 0) {
                                $class_name = 'redips-mark';
                            } elseif ($datas2[$count]['OrderCalender']['d'.$d] == 1) {
                                $class_name = '';
                            }
                        } 
                        echo '</td>';
                ?>
                    </tr>
                <?php
                            $i++; //カウント値（曜日カウンター）+1
                        } 
                ?>
                <!-- カレンダー部分 END -->
                <tr style="">
                    <td class="redips-trash" style='background-color: #999999;color: white;height:25px;' colspan="2">削除</td>
                </tr>
                <tr>
                    <td colspan="2" style="height:30px;text-align: center;">予定稼働人数</td>
                </tr>
                <tr>
                    <td colspan="2" style="height:30px;text-align: center;">売上見込み合計</td>
                </tr>
                <tr>
                    <td colspan="2" style="height:30px;text-align: center;">人件費見込み合計</td>
                </tr>
                <tr>
                    <td colspan="2" style="height:40px;text-align: center;background-color: #ffecde;">物件別売上見込み</td>
                </tr>
                <tr>
                    <td colspan="2" style="height:85px;text-align: center;background-color: #99ccff;"><b>交通費について<br>（ｲﾚｷﾞｭﾗｰ別途）</b></td>
                </tr>
                <tr>
                    <td rowspan="1" align="center" style='background-color: #e8ffff;height:165px;' colspan="2">
                        備考
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="height:30px;text-align: center;">注意事項</td>
                </tr>
                <tr>
                    <td colspan="2" style="height:30px;text-align: center;">契約書</td>
                </tr>
                <tr>
                    <td rowspan="3" colspan="2" style="height:75px;"></td>
                </tr>
            </table>
        </div>
        <!-- /ロック部分 -->
        <!-- 横スクロール部分 -->
        <div class="x_scroll_box" id="data">  
        <!-- 職種入力 -->   
        <table border='1' cellspacing="0" cellpadding="5" id="table1"
               style="width:<?=$col*120 ?>px;margin-top: 0px;margin-bottom: 0px;border-spacing: 0px;table-layout: fixed;">
            <colgroup> 
              <?php for ($count=0; $count<$col; $count++){ ?>
              <col style='width:120px;'>
              <?php } ?>
            </colgroup>
            <tbody>
                <!--
            <tr style="">
                <td class="redips-trash" style='background-color: #999999;color: white;' colspan="2">削除</td>
                <?php for ($count=0; $count<$col; $count++){ ?>
                <td class="redips-trash" style='background-color: #999999;color: white;'>
                    <?php echo $count+1; ?>
                    <?php echo $this->Form->input('WorkTable.'.($count+1).'.case_id',array('type'=>'hidden', 'value'=>setData($datas2,'case_id',$count,$record))); ?>
                    <?php echo $this->Form->input('WorkTable.'.($count+1).'.order_id',array('type'=>'hidden', 'value'=>setData($datas2,'order_id',$count,$record))); ?>
                    <?php echo $this->Form->input('WorkTable.'.($count+1).'.shokushu_num',array('type'=>'hidden','value'=>setData($datas2,'shokushu_num',$count,$record))); ?>
                    <?php echo $this->Form->input('WorkTable.'.($count+1).'.shokushu_id',array('type'=>'hidden','value'=>setData($datas2,'shokushu_id',$count,$record))); ?>
                    <?php echo $this->Form->input('WorkTable.'.($count+1).'.username', array('type'=>'hidden', 'value' => $username)); ?>
                    <?php echo $this->Form->input('WorkTable.'.($count+1).'.class', array('type'=>'hidden', 'value' => $selected_class)); ?>
                </td>
                <?php } ?>
            </tr>
                -->
            <tr id="OrderDetail0">
                <?php 
                    $total_col = 0;
                    foreach ($datas as $key=>$data){
                        $from = $total_col;
                        //$to = $total_col + $data[0]['cnt'] - 1;
                ?>
                <td style='background:white;text-align: center;height:30px;' colspan="<?=$data[0]['cnt'] ?>">
                    <?php echo $this->Form->input('OrderCalender.'.$from.'.tantou',
                            array('type'=>'text','div'=>false,'label'=>false, 
                                'value'=>NZ($data['OrderCalender']['tantou']), 'style'=>'text-align: left;width:95%;')); ?>
                </td>
                <?php
                        $total_col += $data[0]['cnt'];
                    } 
                ?>
            </tr>
            <!-- 事業主 -->
            <tr id="OrderDetail1">
                <?php foreach ($datas as $data){ ?>
                <td style='background:#ffffcc;text-align: center;height:57px;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo NZ($list_entrepreneur[$data['OrderCalender']['case_id']]); ?>
                </td>
                <?php } ?>
            </tr>
            <!-- 販売会社 -->
            <tr id="OrderDetail2">
                <?php foreach ($datas as $data){ ?>
                <td style='text-align: center;background-color: white;height:36px;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo NZ($list_distributor[$data['OrderCalender']['case_id']]); ?>
                </td>
                <?php } ?>
            </tr>
            <!-- 指揮命令者/担当者 -->
            <tr id="OrderDetail3">
                <?php foreach ($datas as $data){ ?>
                <td style='text-align: center;background-color: white;height:55px;' colspan="<?=$data[0]['cnt'] ?>">
                    <?php
                        if (!empty($list_director_corp) && !empty($list_director_corp[$data['OrderCalender']['case_id']])) {
                            echo $list_director_corp[$data['OrderCalender']['case_id']].'<br>';
                        }
                    ?>
                <?php echo ltrim(NZ($list_director[$data['OrderCalender']['case_id']]), '：'); ?> 様
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail4">
                <?php foreach ($datas as $data){ ?>
                <td style='text-align: center;background-color: white;height:50px;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo NZ($list_address[$data['OrderCalender']['case_id']]); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail5">
                <?php foreach ($datas as $data){ ?>
                <td style='text-align: center;background-color: white;height:50px;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo 'TEL:'.NZ($list_telno[$data['OrderCalender']['case_id']]); ?><br>
                <?php echo 'FAX:'.NZ($list_faxno[$data['OrderCalender']['case_id']]); ?>
                </td>
                <?php } ?>
            </tr>
            <!-- 待ち合わせ -->
            <tr id="OrderDetail6">
                <?php 
                    $total_col = 0;
                    foreach ($datas as $key=>$data){
                        $from = $total_col;
                        //$to = $total_col + $data[0]['cnt'] - 1;
                ?>
                <td style='text-align: center;background-color: white;height:67px;' colspan="<?=$data[0]['cnt'] ?>">
                    <?php echo $this->Form->input('OrderCalender.'.$from.'.appointment',
                            array('type'=>'textarea','div'=>false,'label'=>false,'rows'=>'3', 
                                'value'=>NZ($data['OrderCalender']['appointment']), 'style'=>'text-align: left;font-size:90%;width: 95%;')); ?>
                </td>
                <?php
                        $total_col += $data[0]['cnt'];
                    } 
                ?>
            </tr>
            <!-- 請求先担当者 -->
            <tr id="OrderDetail7">
                <?php foreach ($datas as $data){ ?>
                <td style='text-align: center;background-color: white;height:56px;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo NZ($list_bill[$data['OrderCalender']['case_id']]); ?> 様
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail8">
                <?php foreach ($datas as $data){ ?>
                <td style='text-align: center;background-color: white;height:30px;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo NZ($list_cutoff[$data['OrderCalender']['case_id']]); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail19">
                <?php foreach ($datas as $data){ ?>
                <td style='text-align: center;background-color: white;height:30px;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo NZ($bill_arrival[$data['OrderCalender']['case_id']]); ?>
                </td>
                <?php } ?>
            </tr>
            <!-- クリーニング -->
            <tr id="OrderDetail9">
                <?php 
                    $total_col = 0;
                    foreach ($datas as $key=>$data){
                        $from = $total_col;
                        //$to = $total_col + $data[0]['cnt'] - 1;
                ?>
                <td style='text-align: center;background-color: white;height:30px;' colspan="<?=$data[0]['cnt'] ?>">
                    <?php echo $this->Form->input('OrderCalender.'.$from.'.cleanning',
                            array('type'=>'text','div'=>false,'label'=>false, 
                                'value'=>NZ($data['OrderCalender']['cleanning']), 'style'=>'text-align: center;width:95%;')); ?>
                </td>
                <?php
                        $total_col += $data[0]['cnt'];
                    } 
                ?>
            </tr>
            <!-- 受注 -->
            <?php $list1 = array('1'=>'時間', '2'=>'日払', '3'=>'月払'); ?>
            <?php $list2 = array('1'=>'有', '0'=>'無'); ?>
            <tr id="OrderDetail10">
                <?php for ($count=0; $count<$col; $count++){ ?>
                <td style='background-color: white;height:25px;'>
                    \ <?php echo $this->Form->input('OrderCalender.'.$count.'.juchuu_money_d',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:90px;text-align: right;', 
                                //'onchange'=>'calUri1(this,'.$count.')', 
                                'value'=>setDMoney($count, $datas2))); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail11">
                <?php for ($count=0; $count<$col; $count++){ ?>
                <td style='background-color: white;height:25px;'>
                    \ <?php echo $this->Form->input('OrderCalender.'.$count.'.juchuu_money_h',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:90px;text-align: right;', 
                                'value'=>setHMoney($count, $datas2))); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail12">
                <?php for ($count=0; $count<$col; $count++){ ?>
                <td style='background-color: white;height:25px;'>
                    \ <?php echo $this->Form->input('OrderCalender.'.$count.'.juchuu_money_z',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:90px;text-align: right;', 'value'=>setZMoney($count, $datas2))); ?>
                </td>
                <?php } ?>
            </tr>
            <!-- 受注 END -->
            <!-- 給与 -->
            <!-- 時給（スタッフ分） -->
            <tr id="OrderDetail13">
                <?php for ($count=0; $count<$col; $count++){ ?>
                <td style='background-color: white;height:25px;'>
                    \ <?php echo $this->Form->input('OrderCalender.'.$count.'.staff_money_h',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:90px;text-align: right;', 'value'=>setHMoney2($count, $datas2))); ?>
                </td>
                <?php } ?>
            </tr>
            <!-- 基本日給（スタッフ分） -->
            <tr id="OrderDetail14">
                <?php for ($count=0; $count<$col; $count++){ ?>
                <td style='background-color: white;height:25px;'>
                    \ <?php echo $this->Form->input('OrderCalender.'.$count.'.staff_money_d',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:90px;text-align: right;', 
                                'value'=>setDMoney2($count, $datas2),
                                //'onchange'=>'calJinkenhi1(this,'.$count.')'
                                )); ?>
                </td>
                <?php } ?>
            </tr>
            <!-- 残業（スタッフ分） -->
            <tr id="OrderDetail15">
                <?php for ($count=0; $count<$col; $count++){ ?>
                <td style='background-color: white;height:25px;'>
                    \ <?php echo $this->Form->input('OrderCalender.'.$count.'.staff_money_z',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:90px;text-align: right;', 'value'=>setZMoney2($count, $datas2))); ?>
                </td>
                <?php } ?>
            </tr>
            <!-- 研修中（スタッフ分） -->
            <tr id="OrderDetail16">
                <?php for ($count=0; $count<$col; $count++){ ?>
                <td style='background-color: white;height:25px;'>
                    \ <?php echo $this->Form->input('OrderCalender.'.$count.'.staff_money_tr',
                            array('type'=>'text','div'=>false,'label'=>false,
                                'style'=>'width:90px;text-align: right;', 'value'=>setTrMoney2($count, $datas2))); ?>
                </td>
                <?php } ?>
            </tr>
            <!-- 給与 END -->
            <!-- 職種 -->
            <tr>
                <?php for ($count=0; $count<$col; $count++){ ?>
                <td style='background-color: #ffffcc;height:30px;'>
                    <?php echo $list_shokushu[setData($datas2,'shokushu_id',$count,$record)]; ?>
                    <?php echo setKakko(setData($datas2,'shokushu_memo',$count,$record)); ?>
                </td>
                <?php } ?>
            </tr>
            <!-- 勤務時間 -->
            <tr id="OrderDetail17">
                <?php for ($count=0; $count<$col; $count++){ ?>
                <td style='background-color: #ffffcc;height:70px;'>
                    <?php echo setData($datas2,'worktime_from',$count,$record).'～'.setData($datas2,'worktime_to',$count,$record) ?>
                    <?php if (empty($datas2) || empty($datas2[$count])) { ?>
                        <?php echo $this->Form->input('OrderCalender.'.$count.'.id',array('type'=>'hidden')); ?>
                    <?php } elseif ($datas2[$count]['OrderCalender']['year'] != $year || $datas2[$count]['OrderCalender']['month'] != $month) { ?>
                        <?php echo $this->Form->input('OrderCalender.'.$count.'.id',array('type'=>'hidden')); ?>
                    <?php } else { ?>
                        <?php echo $this->Form->input('OrderCalender.'.$count.'.id',array('type'=>'hidden', 'value'=>$datas2[$count]['OrderCalender']['id'])); ?>
                    <?php } ?>
                    <?php echo $this->Form->input('OrderCalender.'.$count.'.case_id',array('type'=>'hidden','value'=>$datas2[$count]['OrderCalender']['case_id'])); ?>
                    <?php echo $this->Form->input('OrderCalender.'.$count.'.order_id',array('type'=>'hidden','value'=>$datas2[$count]['OrderCalender']['order_id'])); ?>
                    <?php echo $this->Form->input('OrderCalender.'.$count.'.shokushu_num',array('type'=>'hidden','value'=>$datas2[$count]['OrderCalender']['shokushu_num'])); ?>
                    <?php echo $this->Form->input('OrderCalender.'.$count.'.username', array('type'=>'hidden', 'value' => $username)); ?>
                    <?php echo $this->Form->input('OrderCalender.'.$count.'.class', array('type'=>'hidden', 'value' => $selected_class)); ?>
                    <?php echo $this->Form->input('OrderCalender.'.$count.'.year',array('type'=>'hidden','value'=>$year)); ?>
                    <?php echo $this->Form->input('OrderCalender.'.$count.'.month',array('type'=>'hidden','value'=>$month)); ?>
                    <?php echo $this->Form->input('OrderCalender.'.$count.'.work_time_memo',
                        array('type'=>'textarea','div'=>false,'label'=>false,
                            'style'=>'width:100px;text-align: left;background-color: #ffffcc;font-size:90%;', 
                            'value'=>$datas2[$count]['OrderCalender']['work_time_memo'], 'rows'=>2)); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail18">
                <?php for ($count=0; $count<$col; $count++){ ?>
                <td style='background-color: #ffffcc;height:30px;'>
                    <?php echo setData($datas2,'resttime_from',$count,$record); ?>&nbsp;～
                    <?php echo setData($datas2,'resttime_to',$count,$record); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="">
                <?php for ($count=0; $count<$col; $count++){ ?>
                <td style='background-color: #ffffcc;vertical-align: top;font-size: 90%;height:75px;'>
                    <div style="overflow-x: hidden;overflow-y: scroll;height:50px;" title="<?php echo br2nl(setArray($list_staffs2[$datas2[$count]['OrderCalender']['order_id']][$datas2[$count]['OrderCalender']['shokushu_num']])); ?>">
                        <?php echo setArray($list_staffs2[$datas2[$count]['OrderCalender']['order_id']][$datas2[$count]['OrderCalender']['shokushu_num']]); ?>
                    </div>
                    <input type="button" value="スタッフ選択" 
                           onclick="window.open('<?=ROOTDIR ?>/CaseManagement/select/<?=$datas2[$count]['OrderCalender']['order_id'] ?>/<?=$datas2[$count]['OrderCalender']['shokushu_num']-1 ?>?<?=setArray2($list_staffs[$datas2[$count]['OrderCalender']['order_id']][$datas2[$count]['OrderCalender']['shokushu_num']]); ?>','スタッフ選択','width=800,height=600,scrollbars=yes');">
                    
                </td>
                <?php } ?>
            </tr>
            <tr id="">
                <?php for ($count=0; $count<$col; $count++){ ?>
                <td style='background-color: #ffffcc;vertical-align: top;font-size: 90%;'>
                    <div style="overflow-x: hidden;overflow-y: scroll;height:50px;" title="<?php echo br2nl(setPMStaff($count, $list_premonth)); ?>">
                    <?php echo setPMStaff($count, $list_premonth); ?>
                    </div>
                </td>
                <?php } ?>
            </tr>
            <tr style="">
                <?php for ($count=0; $count<$col; $count++){ ?>
                <td class="redips-trash" style='background-color: #999999;color: white;height:25px;'>
                    <?php echo $count+1; ?>
                    <?php echo $this->Form->input('WorkTable.'.($count+1).'.case_id',array('type'=>'hidden', 'value'=>setData($datas2,'case_id',$count,$record))); ?>
                    <?php echo $this->Form->input('WorkTable.'.($count+1).'.order_id',array('type'=>'hidden', 'value'=>setData($datas2,'order_id',$count,$record))); ?>
                    <?php echo $this->Form->input('WorkTable.'.($count+1).'.shokushu_num',array('type'=>'hidden','value'=>setData($datas2,'shokushu_num',$count,$record))); ?>
                    <?php echo $this->Form->input('WorkTable.'.($count+1).'.shokushu_id',array('type'=>'hidden','value'=>setData($datas2,'shokushu_id',$count,$record))); ?>
                    <?php echo $this->Form->input('WorkTable.'.($count+1).'.username', array('type'=>'hidden', 'value' => $username)); ?>
                    <?php echo $this->Form->input('WorkTable.'.($count+1).'.class', array('type'=>'hidden', 'value' => $selected_class)); ?>
                </td>
                <?php } ?>
            </tr>
            <!-- カレンダー部分 --> 
            <?php
                // 今月の日付が存在している間ループする
                for( $d=1; checkdate( $m, $d, $y ); $d++ ){
                    //曜日の最後まできたらカウント値（曜日カウンター）を戻して行を変える
                    if( $i > 6 ){
                        $i = 0;
                    }
                //-------------スタイルシート設定-----------------------------------
                    if( $i == 0 ){ //日曜日の文字色
                        $style = "#C30";
                    }
                    else if( $i == 6 ){ //土曜日の文字色
                        $style = "#03C";
                    }
                    else{ //月曜～金曜日の文字色
                        $style = "black";
                    }
                    $style2 = '';
                //-------------スタイルシート設定終わり-----------------------------

                    // 日付セル作成とスタイルシートの挿入
                    echo '<tr style="'.$style2.';">';
                    $kadou[] = NULL;
                    for ($count=0; $count<$col; $count++){
                        if (empty($datas2) || empty($datas2[$count])) {
                            $class_name = 'redips-mark';
                            if (empty($kadou[$count])) {
                                $kadou[$count] = 0;
                            }
                        } elseif ($datas2[$count]['OrderCalender']['d'.$d] == 0) {
                            $class_name = 'redips-mark';
                            if (empty($kadou[$count])) {
                                $kadou[$count] = 0;
                            }
                        } elseif ($datas2[$count]['OrderCalender']['d'.$d] == 1) {
                            $class_name = '';
                            if (empty($kadou[$count])) {
                                $kadou[$count] = 1;
                            } else {
                                $kadou[$count] += 1;
                            }
                        }
            ?>
                <td id="Cell<?=$count ?>D<?=$d ?>" class="<?=$class_name ?>" style="height:30px;">
                    <?php if (!empty($class_name)) { ?>
                    <?php echo ''; ?>
                    <?php } else { ?>
                    <?php //echo $datas2[$count]['OrderCalender']['d'.$d]; ?>
                    <span id="<?=setData($datas2,'order_id',$count,$record) ?>"></span>
                    <span id="<?=setData($datas2,'shokushu_num',$count,$record) ?>"></span>
                    <?php
                        // 待ち合わせ
                        $order_id = setData($datas2,'order_id',$count,$record);
                        $shokushu_num = setData($datas2,'shokushu_num',$count,$record);
                        if (empty($data_aps[$order_id][$shokushu_num][$d])) {
                            $style = '';
                        } else {
                            $style = 'background-color:#ffcc66;';
                        }
                        if (!empty($staff_cell[$d][$count+1])) {
                            if (!empty($data_staffs[$d][$count+1])) {
                                //$this->log($data_staffs[$d][$count+1], LOG_DEBUG);
                                foreach($data_staffs[$d][$count+1] as $key=>$data_staff) {
                                    echo '<div id="'.$data_staff['StaffMaster']['id'].'" class="redips-drag t1" style="'.$style.'">';
                                    echo $data_staff['StaffMaster']['name_sei'].' '.$data_staff['StaffMaster']['name_mei'];
                                    echo '</div>';
                                }
                            }
                        }
                    ?>
                    <?php
                    $j = 0;
                    if (!empty($request_staffs)) {
                        foreach ($request_staffs as $data) {
                            $point = $data['StaffSchedule']['point'];
                            if (!empty($point)) {
                                $point2 = explode(',', $point);
                            } else {
                                $point2 = null;
                            }
                            if (date('j', strtotime($data['StaffSchedule']['work_date'])) == $d 
                                    //&& chkShokushu(setData($datas2,'shokushu_id',$count,$record), $data['StaffSchedule']['shokushu_id'])
                                    ) {
                                $datas3[$count][$d][$j]['staff_id'] = $data['StaffSchedule']['staff_id'];
                                $datas3[$count][$d][$j]['name'] = $data['StaffMaster']['name_sei'].' '.$data['StaffMaster']['name_mei'];
                                $datas3[$count][$d][$j]['point'] = setPoint($point2, $count);

                                $j++;
                            }
                        }
                        // ポイント順、ID順に並び替え
                        if (!empty($datas3[$count][$d])) {
                            foreach ($datas3[$count][$d] as $key => $value){
                                $key_point[$key] = $value['point'];
                                $key_staff_id[$key] = $value['staff_id'];
                            }
                            if (!array_multisort($key_point, SORT_DESC ,$key_staff_id , SORT_ASC , $datas3[$count][$d])) {
                                $this->log($key_point, LOG_DEBUG);
                                $this->log($key_staff_id, LOG_DEBUG);
                            }
                            // 初期化
                            $key_point = null;
                            $key_staff_id = null;

                            // 優先順に表示
                            $flag3 = false;
                            $flag2 = false;
                            $flag1 = false;
                            foreach ($datas3[$count][$d] as $key => $value){
                                if ($key > 0) {
                                    break;
                                }
                                if ($value['point'] == 3) {
                                        echo '<div id="'.$value['staff_id'].'" class="redips-drag t1">';
                                        echo $value['name'].' ('.$value['point'].')';
                                        echo '</div>';
                                    $flag3 = true;
                                } elseif ($flag3 == false && $value['point'] == 2) {
                                        echo '<div id="'.$value['staff_id'].'" class="redips-drag t1">';
                                        echo $value['name'].' ('.$value['point'].')';
                                        echo '</div>';
                                        $flag2 = true;
                                } elseif (($flag3 == false && $flag2 == false) && $value['point'] == 1) {
                                        echo '<div id="'.$value['staff_id'].'" class="redips-drag t1">';
                                        echo $value['name'].' ('.$value['point'].')';
                                        echo '</div>';
                                        $flag1 = true;
                                } elseif (($flag3 == false && $flag2 == false && $flag1 == false) && $value['point'] == 0) {
                                        echo '<div id="'.$value['staff_id'].'" class="redips-drag t1">';
                                        echo $value['name'].' ('.$value['point'].')';
                                        echo '</div>';
                                } else {
                                    //echo $value['staff_id'].'('.$value['point'].')'.'<br>';
                                }
                            }
                        }
                    }
                    ?>
                    <?php } ?>
                </td>
            <?php
                    }
                    echo '</tr>';
                    $i++; //カウント値（曜日カウンター）+1
                }
            ?>
            <tr style="">
                <?php for ($count=0; $count<$col; $count++){ ?>
                <td class="redips-trash" style='background-color: #999999;color: white;height:25px;'>
                    <?php echo $count+1; ?>
                </td>
                <?php } ?>
            </tr>
            <!-- カレンダー部分 END -->
            <!-- 予定稼働人数 -->
            <tr>
                <?php for ($count=0; $count<$col; $count++){ ?>
                <td style="background-color: white;height:30px;text-align: right;padding-right: 10px;">
                    <?=$kadou[$count] ?>
                    <input type="hidden" id="running_num<?=$count?>" value="<?=$kadou[$count] ?>">
                </td>
                <?php } ?>
            </tr>
            <!-- 売上見込み合計 -->
            <tr>
                <?php for ($count=0; $count<$col; $count++){ ?>
                <td style="background-color: white;height:30px;">
                    \ <?php echo $this->Form->input('OrderCalender.'.$count.'.uriage',
                            array('type'=>'text','id'=>'uri1_'.$count,'div'=>false,'label'=>false,
                                'value'=>setUriSum($count, $datas2, $kadou[$count]), 'style'=>'text-align: right;width: 80%;', 'disabled')); ?>
                    <input type="hidden" name="data[OrderCalender][<?=$count ?>][uriage]" value="<?=setUriSum($count, $datas2, $kadou[$count]) ?>">
                </td>
                <?php } ?>
            </tr>
            <!-- 人件費見込み合計 -->
            <tr>
                <?php for ($count=0; $count<$col; $count++){ ?>
                <td style="background-color: white;height:30px;">
                    \ <?php echo $this->Form->input('OrderCalender.'.$count.'.jinkenhi',
                            array('type'=>'text','id'=>'jinkenhi1_'.$count,'div'=>false,'label'=>false,
                                'value'=>setJinkenhiSum($count, $datas2, $kadou[$count]), 'style'=>'text-align: right;width: 80%;', 'disabled')); ?>
                    <input type="hidden" name="data[OrderCalender][<?=$count ?>][jinkenhi]" value="<?=setJinkenhiSum($count, $datas2, $kadou[$count]) ?>">
                </td>
                <?php } ?>
            </tr>
            <!-- 物件別売上見込み -->
            <tr>
                <?php 
                    $total_col = 0;
                    foreach ($datas as $key=>$data){
                        $from = $total_col;
                        //$to = $total_col + $data[0]['cnt'] - 1;
                ?>
                <td style="background-color: #ffecde;height:40px;" colspan="<?=$data[0]['cnt'] ?>">
                    <?php
                        $ret = 0;
                        for($i=$from; $i<$from + $data[0]['cnt']; $i++) {
                            $ret += str_replace(',', '', setUriSum($i, $datas2, $kadou[$i]));
                        }
                        if ($data[0]['cnt'] == 1) {
                            $width = '80%';
                        } else {
                            $width = '90px';
                        }
                        echo '\\ '.$this->Form->input('OrderCalender.'.$from.'.uriage_case',
                            array('type'=>'text','id'=>'jinkenhi1_'.$count,'div'=>false,'label'=>false,
                                'value'=>number_format($ret), 'style'=>'text-align:right;font-size:14px;background-color: #ffecde; width:'.$width.';', 'disabled'));
                    ?>
                    <input type="hidden" name="data[OrderCalender][<?=$from ?>][uriage_case]" value="<?=number_format($ret) ?>">
                </td>
                <?php
                        $total_col += $data[0]['cnt'];
                    } 
                ?>
            </tr>
            <!-- 交通費について -->
            <tr>
                <?php for ($count=0; $count<$col; $count++){ ?>
                <td style="background-color: white;height:85px;">
                    <?php
                        if (is_null($datas2[$count]['OrderInfoDetail']['kyuuyo_koutsuuhi'])) {
                            //echo '交通費支給：不明';
                        } elseif ($datas2[$count]['OrderInfoDetail']['kyuuyo_koutsuuhi'] == 0) {
                            echo '交通費支給：なし';
                        } elseif ($datas2[$count]['OrderInfoDetail']['kyuuyo_koutsuuhi'] == 1) {
                            echo '交通費支給：あり';
                        } else {
                            //echo '交通費支給：不明';
                        }
                    ?>
                    <?php echo $this->Form->input('OrderCalender.'.$count.'.koutsuuhi',
                            array('type'=>'textarea','div'=>false,'label'=>false,'rows'=>'3',
                                'value'=>$datas2[$count]['OrderCalender']['koutsuuhi'], 'style'=>'text-align: left;width: 95%;font-size:90%;')); ?>
                </td>
                <?php } ?>
            </tr>
            <!-- 備考 -->
            <tr>
                <?php
                    $total_col = 0;
                    foreach ($datas as $key=>$data){
                        $from = $total_col;
                ?>
                <td align='left' style='background-color:white;height:165px;' colspan="<?=$data[0]['cnt'] ?>">
                    <?php echo $this->Form->input('OrderCalender.'.$from.'.remarks',
                        array('type'=>'textarea','div'=>false,'label'=>false, 
                            'value'=>$data['OrderCalender']['remarks'], 'style'=>'width:90%;text-align: left;font-size:90%;font-weight:bold;', 'rows'=>10)); ?>
                </td>
                <?php
                        $total_col += $data[0]['cnt'];
                    } 
                ?>
            </tr>
            <!-- 注意事項 -->
            <tr>
                <?php
                    $total_col = 0;
                    foreach ($datas as $key=>$data){
                        $from = $total_col;
                ?>
                <td style="background-color: white;height:30px;" colspan="<?=$data[0]['cnt'] ?>">
                    <?php echo $this->Form->input('OrderCalender.'.$from.'.caution',
                            array('type'=>'text','div'=>false,'label'=>false,
                                'value'=>$data['OrderCalender']['caution'], 'style'=>'text-align:left;width: 95%;font-size:90%;')); ?>
                </td>
                <?php
                        $total_col += $data[0]['cnt'];
                    } 
                ?>
            </tr>
            <!-- 契約書 -->
            <tr>
                <?php
                    $total_col = 0;
                    foreach ($datas as $key=>$data){
                        $from = $total_col;
                ?>
                <td style="background-color: white;height:30px;" colspan="<?=$data[0]['cnt'] ?>">
                    <?php echo $this->Form->input('OrderCalender.'.$from.'.contract',
                            array('type'=>'text','div'=>false,'label'=>false,
                                'value'=>$data['OrderCalender']['contract'], 'style'=>'text-align:center;width: 95%;font-size:90%;')); ?>
                </td>
                <?php
                        $total_col += $data[0]['cnt'];
                    } 
                ?>
            </tr>
            <!-- 月の合計 -->
            <?php if (!empty($datas) && !empty($datas2)) { ?>
            <tr style="background-color:white;">
                <td colspan="2" algin="center" style="font-size:110%;height:30px;background-color: #ffccff;">今月の売上見込み</td>
                <td colspan="2" algin="center" style="font-size:110%;background-color: #ffcccc;">人件費見込み合計</td>
            <?php if ($col > 4) { ?>
                <td colspan="<?=$col-4 ?>" rowspan="2"style="background-color: white;"></td>
            </tr>
            <?php } ?>
            <tr style="background-color:white;">
                <td colspan="2" algin="center" style="font-size:120%;height:40px;">
                    <?php
                        $ret = 0;
                        for ($count=0; $count<$col; $count++) {
                            $ret += str_replace(',', '', setDMoney($count, $datas2))*$kadou[$count];
                        }
                        echo '\\ '.$this->Form->input('OrderCalender.0.uriage_monthly',
                            array('type'=>'text','div'=>false,'label'=>false,'value'=>number_format($ret),
                                'style'=>'text-align:right;width: 60%;font-size:120%;background-color:white;', 'disabled'));
                    ?>
                    <input type="hidden" name="data[OrderCalender][0][uriage_monthly]" value="<?=number_format($ret) ?>">
                </td>
                <td colspan="2" algin="center" style="font-size:120%;">
                    <?php
                        $ret2 = 0;
                        for ($count=0; $count<$col; $count++) {
                            $ret2 += str_replace(',', '', setDMoney2($count, $datas2))*$kadou[$count];
                        }
                        echo '\\ '.$this->Form->input('OrderCalender.0.jinnkenhi_monthly',
                            array('type'=>'text','div'=>false,'label'=>false,'value'=>number_format($ret2),
                                'style'=>'text-align:right;width: 60%;font-size:120%;background-color:white;', 'disabled'));
                    ?>
                    <input type="hidden" name="data[OrderCalender][0][jinnkenhi_monthly]" value="<?=number_format($ret2) ?>">
                </td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
        </div>
<div id="Div" style="display: none;clear:both;"><p id="Mbox0">セルをクリックしたらここに書き出します。</p>
 <p id="Mbox1">インデックス値は '0'から始まります。</p>
</div>
    </div>
<script type="text/javascript">
function $E(name){ return document.getElementById(name); }
function scroll(){
   $E("header_h").scrollLeft= $E("data").scrollLeft;// データ部のスクロールをヘッダに反映
   $E("header_v").scrollTop = $E("data").scrollTop;// データ部のスクロールをヘッダに反映
   }
$E("data").onscroll=scroll;
</script>
    
    <div style='margin-left: 10px;'>
    <button type="button" id="<?=$button_type2 ?>" style="cursor: pointer;border:1px solid black;" class="check" 
            onclick="doAccount(<?=$y ?>,<?=sprintf("%02d", $m) ?>, 1);" <?=$disabled ?>>一時保存</button>
    &nbsp;&nbsp;
<?php
    if ($flag == 0) {
        $commet2 = '★ 確定する ★';
        $commet3 = '【注意！】当月シフトを確定しますか？';
        $button_type = 'button-release';
    } elseif ($flag == 1) {
        $commet2 = '★ 確定解除 ★';
        $commet3 = '【注意！】当月のシフト確定を解除しますか？';
        $button_type = 'button-release';
    } else {
        $commet2 = 'エラー';
        $button_type = '';
    }
?>
<?php print($this->Form->submit($commet2, array('type'=>'button', 'id'=>$button_type, 'name'=>'confirm','div' => false, 'label'=>false,  'class'=>'check',
    'style' => 'padding: 10px 15px;font-size: 110%;cursor:pointer;', 'onclick' => 'doCommit("'.$commet3.'",'.$y.','.sprintf("%02d", $m).', 2);'))); ?>
    &nbsp;&nbsp;
<?php print($this->Form->submit('EXCEL出力', array('id'=>'', 'name'=>'output_excel','div' => false, 'onclick'=>'alert("工事中");return false;'))); ?>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php $comment2 = '【注意！】いままで保存した当月のシフトデータは消去されます。\nシフトの全クリアを実行しますか？'; ?>
<?php print($this->Form->submit('シフトの全クリア', array('id'=>'button-delete', 'class'=>'check', 'name'=>'all_clear', 'div'=>false, $disabled, 'onclick'=>'return window.confirm(\''.$comment2.'\');'))); ?>
    </div>
<?php echo $this->Form->end(); ?>  
    
</div>