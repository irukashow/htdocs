<?php require 'schedule_element.ctp'; ?>
<?php
    if ($flag == 0) {
        $disabled = '';
        $button_type2 = 'button-create';
        $button_type3 = 'button-release';
    } else {
        $disabled = 'disabled';
        $button_type2 = 'button-delete';
        $button_type3 = 'button-delete';
    }
?>
<!--
<div id="loading"><img src="<?=ROOTDIR ?>/img/loading.gif"></div>
-->
<?php echo $this->Form->create('WorkTable', array('name'=>'frm', 'id'=>'form')); ?> 
<!-- 見出し１ -->
<div id='headline' style="padding:2px 10px 2px 10px;">
    <div style="float:left;padding-top:6px;">
        ★ シフト管理
        &nbsp;&nbsp;
        <a href="<?=ROOTDIR ?>/ShiftManagement/index?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' 0 month')); ?>" target=""><font Style="font-size:95%;">スタッフシフト希望</font></a>
        &nbsp;
        <a href="<?=ROOTDIR ?>/ShiftManagement/schedule?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' 0 month')); ?>" target=""><font Style="font-size:95%;">シフト作成</font></a>
        &nbsp;
        <a href="<?=ROOTDIR ?>/ShiftManagement/schedule3?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' 0 month')); ?>" target=""><font Style="font-size:95%;">確定シフト</font></a>
        &nbsp;
        <a href="<?=ROOTDIR ?>/ShiftManagement/setting" target="" onclick=''><font Style="font-size:95%;">詳細設定</font></a>
        &nbsp;&nbsp;&nbsp;
        <b><font Style="font-size:95%;color: yellow;">[シフト作成（新）]</font></b> 
    </div>
    <div style="float:right;">
        <?php $comment = '【注意！】いままで保存した当月のシフトデータは消去されます。\n自動割付を実行しますか？'; ?>
        <input type="submit" name="assignment" value="シフト自動割付" id="<?=$button_type2 ?>" class="check" style="margin-left: 50px;" onclick="return window.confirm('<?=$comment ?>');" <?=$disabled ?>>
            &nbsp;
            <input type="button" id="<?=$button_type2 ?>" class="check" value="一時保存" style="cursor: pointer;border:1px solid black;" onclick="doAccount(<?=$y ?>,<?=sprintf("%02d", $m) ?>, 1);" <?=$disabled ?>>
            &nbsp;
        <input type="button" name="check_duplication" value="チェック" id="<?=$button_type3 ?>" class="check"
               style="cursor: pointer;border:1px solid black;padding: 5px 10px;" onclick="doAccount(<?=$y ?>,<?=sprintf("%02d", $m) ?>, 2);" <?=$disabled ?>>
        &nbsp;&nbsp;&nbsp;
        <input type="text" value="<?=displayCommit($flag); ?>" style="text-align: center;width: 100px;font-size: 110%;vertical-align: -1px;font-family: メイリオ;<?=commitStyle($flag); ?>" disabled="disabled">
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
<div style="width:100%;margin-top: 0px;<?=$font_normal ?>;">
    <table border='1' cellspacing="0" cellpadding="3" style="width:1200px;margin-top: -5px;border-spacing: 0px;background-color: white;">
            <tr align="center">
                    <td style=''><a href="<?=ROOTDIR ?>/ShiftManagement/schedule_new?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' -1 month')); ?>" class="load">&lt; 前の月</a></td>
                    <td style='background-color: #006699;color: white;width: 700px;'>
                        <font style='font-size: 110%;'>
                            <a href="<?=ROOTDIR ?>/ShiftManagement/schedule_new?date=<?=date('Y-m', strtotime($y .'-' . $m . ' -1 month')); ?>" style="color:white;" class="load">◀</a>
                                【<?php echo $this->Form->input(false, array('id'=>'year', 'type'=>'select','div'=>false,'label'=>false, 'options' => $year_arr,
                                        'value'=>$year, 'style'=>'text-align: left;font-size: 100%;', 'class'=>'load2',
                                        'onchange'=>'setCalender(this, document.getElementById("month"))')); ?>&nbsp;年
                                    <?php echo $this->Form->input(false, array('id'=>'month', 'type'=>'select','div'=>false,'label'=>false, 'options' => $month_arr,
                                        'value'=>$month, 'style'=>'text-align: right;font-size: 100%;',  'class'=>'load2',
                                        'onchange'=>'setCalender(document.getElementById("year"), this)')); ?>
                            <a href="#" style="color: white; text-decoration: none;" onclick="location.reload();" class="load">
                                月&nbsp;稼働表】
                            </a>
                            <a href="<?=ROOTDIR ?>/ShiftManagement/schedule_new?date=<?=date('Y-m', strtotime($y .'-' . $m . ' +1 month')); ?>" style="color:white;" class="load">▶</a>
                        </font>
                        <input type="hidden" name="month" value="<?=$y.'-'.$m ?>">
                    </td>
                    <td style=''><a href="<?=ROOTDIR ?>/ShiftManagement/schedule_new?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' +1 month')); ?>" class="load">次の月 &gt;</a></td>
            </tr>
    </table>
        
    <div id="redips-drag" style="margin-top: 10px;margin-bottom: 10px;"> 
        <!-- 職種入力 -->   
        <table border='1' cellspacing="0" cellpadding="5" id="table1"
               style="width:<?=60+$col*30+count($datas)*50 ?>px;margin-top: 0px;margin-bottom: 0px;border-spacing: 0px;table-layout: fixed;">
            <colgroup> 
              <col style='width:20px;'>
              <col style='width:40px;'>
            <?php 
                $class_mask = 'redips-mark';
                $ii = 0;
                for ($count=0; $count<$col+count($datas); $count++){
                    if ($ii == count($datas)) {
                        break;
                    }
                    echo "<col style='width:30px;'>";
                    if ($count == $cal_arr[$ii]) {
                        $ii += 1;
                        echo "<col style='width:50px;'>";
                    }
                }
                if ($flag == 0) {
            ?>
                <?php } ?>
            </colgroup>
            <thead>
            <tr>
                <th style='background:#99ccff;text-align: center;width:120px;height: 30px;' colspan="2">
                </th>
                <?php foreach ($datas as $key=>$data){ ?>
                <th id="case_<?=$data['OrderCalender']['case_id'] ?>" 
                    style='background:#99ccff;text-align: center;background-color: <?=setBGColor($data['OrderCalender']['case_id'], $list_bgcolor) ?>;
                    color: <?=setColor($data['OrderCalender']['case_id'], $list_color) ?>;' colspan="<?=$data[0]['cnt'] ?>">
                    <div id="<?=$data['OrderCalender']['case_id'] ?>"></div>
                    <div id="<?=$year.'-'.sprintf('%02d', $month) ?>"></div>
                    <?php echo mb_strimwidth($getCasename[$data['OrderCalender']['case_id']],0, 11, '...'); ?>
                </th>
                <th style="background-color: #99ccff;" align="center">
                </th>
                <?php } ?>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td style='width:80px;background-color: #e8ffff;' colspan="2">職種<span id="message" style="display:none;"></span></td>
            <?php 
                $ii = 0;
                for ($count=0; $count<$col+count($datas); $count++){
                    if ($ii == count($datas)) {
                        break;
                    }
            ?>
                <td style='background-color: #FFFFCC;font-weight: bold;color:#555555;'>
                    <?php echo mb_substr(preg_replace('/^[ 　]+|[ 　]+$/', '', $list_shokushu[setData($datas2,'shokushu_id',$count,$record)]), 0, 1); ?>
                </td>
                <?php
                        if ($count == $cal_arr[$ii]) {
                            $ii += 1;
                            echo '<td style="background-color: #e8ffff;">職種</td>';
                        }
                    }
                ?>
            </tr>
            <tr id="OrderDetail17" style="display:none;">
                <td style='background-color: #e8ffff;' colspan="2">勤務時間</td>
            <?php 
                $ii = 0;
                for ($count=0; $count<$col+count($datas); $count++){
                    if ($ii == count($datas)) {
                        break;
                    }
            ?>
                <td style='background-color: #FFFFDD;'>
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
                        array('type'=>'textarea','div'=>false,'label'=>false,'style'=>'width:100px;text-align: left;background-color: #ffffcc;', 
                            'rows'=>2, 'value'=>$datas2[$count]['OrderCalender']['work_time_memo'])); ?>
                </td>
                <?php
                        if ($count == $cal_arr[$ii]) {
                            $ii += 1;
                            echo '<td style="background-color: #e8ffff;">勤務</td>';
                        }
                    }
                ?>
            </tr>
            <tr style="display:none;">
                <!-- カレンダー月指定 -->
                <td rowspan="1" align="center" style='background-color: #e8ffff;' colspan="2">
                    <?php
                        $year_arr = array();
                        $year_arr = array('1999'=>'1999');
                        for($j=2000; $j<2100; $j++) {
                            $year_arr += array($j => $j); 
                        }
                    ?>
                    <?php echo $this->Form->input(false, array('id'=>'year', 'type'=>'select','div'=>false,'label'=>false, 'options' => $year_arr,
                        'value'=>$year, 'style'=>'text-align: left;', 
                        'onchange'=>'setCalender(this, document.getElementById("month"))')); ?>年<br>
                        <a href="<?=ROOTDIR ?>/ShiftManagement/schedule_new?date=<?=date('Y-m', strtotime($y .'-' . $m . ' -1 month')); ?>">▲</a>
                    <?php $month_arr = array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12'); ?>
                    <?php echo $this->Form->input(false, array('id'=>'month', 'type'=>'select','div'=>false,'label'=>false, 'options' => $month_arr,
                        'value'=>$month, 'style'=>'text-align: right;', 'onchange'=>'setCalender(document.getElementById("year"), this)')); ?>月
                        <a href="<?=ROOTDIR ?>/ShiftManagement/schedule_new?date=<?=date('Y-m', strtotime($y .'-' . $m . ' +1 month')); ?>">▼</a>
                </td>
                <!-- カレンダー月指定 END -->
                <?php 
                    $ii = 0; $count_end = 0;
                    for ($count=0; $count<$col+count($datas); $count++){
                        if ($ii == count($datas)) {
                            $count_end = $count;
                            break;
                        }
                ?>
                <td align='left' style='background-color: #e8ffff;'>
                    <?php echo $this->Form->input('OrderCalender.'.$count.'.remarks',
                        array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:100px;text-align: left;', 'rows'=>2)); ?>
                    <?php echo $this->Form->input('WorkTable.'.($count+1).'.case_id',array('type'=>'hidden', 'value'=>setData($datas2,'case_id',$count,$record))); ?>
                    <?php echo $this->Form->input('WorkTable.'.($count+1).'.order_id',array('type'=>'hidden', 'value'=>setData($datas2,'order_id',$count,$record))); ?>
                    <?php echo $this->Form->input('WorkTable.'.($count+1).'.shokushu_num',array('type'=>'hidden','value'=>setData($datas2,'shokushu_num',$count,$record))); ?>
                    <?php echo $this->Form->input('WorkTable.'.($count+1).'.shokushu_id',array('type'=>'hidden','value'=>setData($datas2,'shokushu_id',$count,$record))); ?>
                    <?php echo $this->Form->input('WorkTable.'.($count+1).'.username', array('type'=>'hidden', 'value' => $username)); ?>
                    <?php echo $this->Form->input('WorkTable.'.($count+1).'.class', array('type'=>'hidden', 'value' => $selected_class)); ?>
                </td>
                <?php
                        if ($count == $cal_arr[$ii]) {
                            $ii += 1;
                            echo '<td style="background-color: #e8ffff;"></td>';
                        }
                    }
                    for ($count=$count_end; $count<$count_end+5; $count++){
                        if ($count == $count_end) {
                            $jj = 1;
                            $shokushu_id = 2;
                        } elseif ($count == $count_end+1) {
                            $jj = 2;
                            $shokushu_id = 2;
                        } elseif ($count == $count_end+2) {
                            $shokushu_id = 9;
                            $jj = 3;
                        } elseif ($count == $count_end+3) {
                            $shokushu_id = 0;
                            $jj = 4;
                        } elseif ($count == $count_end+4) {
                            $shokushu_id = 0;
                            $jj = 5;
                        }
                ?>
                <td align='left' style='background-color: #e8ffff;'>
                    <?php echo $this->Form->input('WorkTable.'.($count+1).'.case_id',array('type'=>'hidden', 'value'=>0)); ?>
                    <?php echo $this->Form->input('WorkTable.'.($count+1).'.order_id',array('type'=>'hidden', 'value'=>0)); ?>
                    <?php echo $this->Form->input('WorkTable.'.($count+1).'.shokushu_num',array('type'=>'hidden','value'=>$jj)); ?>
                    <?php echo $this->Form->input('WorkTable.'.($count+1).'.shokushu_id',array('type'=>'hidden','value'=>$shokushu_id)); ?>
                    <?php echo $this->Form->input('WorkTable.'.($count+1).'.username', array('type'=>'hidden', 'value' => $username)); ?>
                    <?php echo $this->Form->input('WorkTable.'.($count+1).'.class', array('type'=>'hidden', 'value' => $selected_class)); ?>
                </td>
                <?php
                    }
                ?>
            </tr>
            <!-- カレンダー部分 --> 
            <?php
                // 曜日の配列作成
                $weekday = array( "日", "月", "火", "水", "木", "金", "土" );
                // 1日の曜日を数値で取得
                $fir_weekday = date( "w", mktime( 0, 0, 0, $m, 1, $y ) );
                // 1日の曜日設定
                $i = $fir_weekday; // カウント値リセット
            ?>
            <?php
                // 今月の日付が存在している間ループする
                for( $d=1; checkdate( $m, $d, $y ); $d++ ){
                    //曜日の最後まできたらカウント値（曜日カウンター）を戻して行を変える
                    if( $i > 6 ){
                        $i = 0;
                    }
                //-------------スタイルシート設定-----------------------------------
                    if( $i == 0 || !empty($national_holiday[date("Y-m-d", mktime(0, 0, 0, $m, $d, $y))])){ //日曜日の文字色
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
                    // 背景色
                    if ($d%2 == 0) {
                        $bgcolor_cal = '#e8ffff'; 
                    } else {
                        $bgcolor_cal = '#e8ffff'; 
                    }
                    echo '<td align="center" class="'.$class_mask.'" style="color:'.$style.';background-color: '.$bgcolor_cal.';" colspan="2"><span id="null"></span>'.$m.'/'.$d.'('.$weekday[$i].')</td>';
                    if ($i==0 || $i==6 || !empty($national_holiday[date("Y-m-d", mktime(0, 0, 0, $m, $d, $y))])) {
                        echo '<input type="hidden" id="HolidayD'.$d.'" value="1">';
                    } else {
                        echo '<input type="hidden" id="HolidayD'.$d.'" value="0">';
                    }
                    $ii = 0;
                    for ($count=0; $count<$col+count($datas); $count++){
                        if ($ii == count($datas)) {
                            break;
                        }
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
                <?php
                    // 背景色
                    if (empty($class_name)) {
                        if ($d%2 == 0) {
                            $bgcolor_cal2 = '#CEF9DC'; 
                        } else {
                            $bgcolor_cal2 = ''; 
                        }
                    } else {
                        $bgcolor_cal2 = ''; 
                    }
                ?>
                <td id="Cell<?=$count ?>D<?=$d ?>" class="<?=$class_name ?>" style="background-color: <?=$bgcolor_cal2 ?>;">
                    <?php if (empty($class_name)) { ?>
                    <?php
                        if (!empty($staff_cell[$d][$count+1])) {
                            if (!empty($data_staffs[$d][$count+1])) {
                                    echo '<script>';
                                    echo 'document.getElementById("Cell'.$count.'D'.$d.'").style.backgroundColor = "#FFFFCC"';
                                    echo '</script>';
                            }
                        }
                    ?>
                    <?php } ?>
                </td>
            <?php
                    if ($count == $cal_arr[$ii]) {
                        $ii += 1;
                        echo '<td class="'.$class_mask.'" style="color:'.$style.';background-color: #e8ffff;"><span id="null"></span>'.$d.'('.$weekday[$i].')</td>';
                    }
                }
                // 背景色
                if ($d%2 == 0) {
                    $bgcolor_cal = '#CEF9DC'; 
                } else {
                    $bgcolor_cal = ''; 
                }
            ?>
            </tr>
            <?php
                    $i++; //カウント値（曜日カウンター）+1
                }
            ?>
            <!-- カレンダー部分 END -->
            <!-- 職種 -->
            <tr>
                <td style='width:80px;background-color: #e8ffff;color: black;' colspan="2" id="message" class="<?=$class_mask ?>">職種</td>
            <?php 
                $ii = 0;
                for ($count=0; $count<$col+count($datas); $count++){
                    if ($ii == count($datas)) {
                        break;
                    }
            ?>
                <td style='background-color: #FFFFCC;color:#555555;font-weight: bold;'>
                    <?php echo mb_substr(preg_replace('/^[ 　]+|[ 　]+$/', '', $list_shokushu[setData($datas2,'shokushu_id',$count,$record)]), 0, 1); ?>
                </td>
                <?php
                        if ($count == $cal_arr[$ii]) {
                            $ii += 1;
                            echo '<td  class="'.$class_mask.'" style="background-color: #e8ffff;color:black;">職種</td>';
                        }
                    }
                ?>
            </tr>
            <!-- 案件 -->
            <tr>
                <th style='background:#99ccff;text-align: center;width:120px;height: 30px;' colspan="2" class="<?=$class_mask ?>">
                </th>
                <?php foreach ($datas as $key=>$data){ ?>
                <th id="case_<?=$data['OrderCalender']['case_id'] ?>" 
                    style='background:#99ccff;text-align: center;background-color: <?=setBGColor($data['OrderCalender']['case_id'], $list_bgcolor) ?>;
                    color: <?=setColor($data['OrderCalender']['case_id'], $list_color) ?>;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo mb_strimwidth($getCasename[$data['OrderCalender']['case_id']],0, 11, '...'); ?>
                </th>
                <th style="background-color: #99ccff;" align="center">
                </th>
                <?php } ?>
            </tr>
            </tbody>
        </table>
    </div>
<div id="Div" style="display: none;"><p id="Mbox0">セルをクリックしたらここに書き出します。</p>
 <p id="Mbox1">インデックス値は '0'から始まります。</p>
</div>
    
    <div style='margin-left: 10px;'>
<button type="button" id="<?=$button_type2 ?>" style="cursor: pointer;border:1px solid black;" class="check" onclick="doAccount(<?=$y ?>,<?=sprintf("%02d", $m) ?>, 1);" <?=$disabled ?>>一時保存</button>
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
<?php print($this->Form->submit('>>スタッフ送信<<', array('id'=>'button-create', 'name'=>'send', 'div' => false, 'style' => 'padding:10px 20px', 'onclick'=>'alert("工事中");return false;'))); ?>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php $comment2 = '【注意！】いままで保存した当月のシフトデータは消去されます。\nシフトの全クリアを実行しますか？'; ?>
<?php print($this->Form->submit('シフトの全クリア', array('id'=>'button-delete', 'class'=>'check', 'name'=>'all_clear', 'div'=>false, 'onclick'=>'return window.confirm(\''.$comment2.'\');'))); ?>
    </div>
<?php echo $this->Form->end(); ?>  
</div>
