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
        ★ シフト編集（案件単位）
    </div>
    <div style="float:right;">
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
    <div id="redips-drag" style="margin-top: 5px;margin-bottom: 10px;">  
        <!-- 職種入力 -->   
        <table border='1' cellspacing="0" cellpadding="5" id="table1"
               style="width:<?=120+$col*100+count($datas)*50 ?>px;margin-top: 0px;margin-bottom: 0px;border-spacing: 0px;table-layout: fixed;">
            <colgroup> 
              <col style='width:25px;'>
              <col style='width:95px;'>
            <?php 
                $class_mask = 'redips-mark';
                $ii = 0;
                for ($count=0; $count<$col+count($datas); $count++){
                    if ($ii == count($datas)) {
                        break;
                    }
                    echo "<col style='width:110px;'>";
                    if ($count == $cal_arr[$ii]) {
                        $ii += 1;
                        echo "<col style='width:50px;'>";
                    }
                }
                if ($flag == 0) {
            ?>
                <col style='width:110px;'>
                <col style='width:110px;'>
                <col style='width:110px;'>
                <col style='width:110px;'>
                <col style='width:110px;'>
                <?php } ?>
            </colgroup>
            <thead>
            <tr>
                <th style='background:#99ccff;text-align: center;width:120px;height: 30px;' colspan="2">
                </th>
                <?php foreach ($datas as $key=>$data){ ?>
                <th id="case_<?=$data['OrderCalendar']['case_id'] ?>" 
                    style='background:#99ccff;text-align: center;background-color: <?=setBGColor($data['OrderCalendar']['case_id'], $list_bgcolor) ?>;
                    color: <?=setColor($data['OrderCalendar']['case_id'], $list_color) ?>;' colspan="<?=$data[0]['cnt'] ?>">
                    <div id="<?=$data['OrderCalendar']['case_id'] ?>"></div>
                    <div id="<?=$year.'-'.sprintf('%02d', $month) ?>"></div>
                    <?php echo $getCasename[$data['OrderCalendar']['case_id']]; ?>
                </th>
                <th style="background-color: #99ccff;" align="center">
                </th>
                <?php } ?>
                <?php if ($flag == 0) { ?>
                <th colspan="5" align="center" style="background-color: #66CCFF;">未定</th>
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
                    <?php 
                        if (empty(setData($datas2,'shokushu_id',$count,$record))) {
                            echo '';
                        } else {
                            echo preg_replace('/^[ 　]+|[ 　]+$/', '', $list_shokushu[setData($datas2,'shokushu_id',$count,$record)]);
                        }
                    ?>
                    <?php echo setKakko(setData($datas2,'shokushu_memo',$count,$record)); ?>
                </td>
                <?php
                        if ($count == $cal_arr[$ii]) {
                            $ii += 1;
                            echo '<td style="background-color: #e8ffff;">職種</td>';
                        }
                    }
                ?>
                <?php if ($flag == 0) { ?>
                <td style='background-color: #FFFFCC;font-weight: bold;color:#555555;' colspan="2">受付</td>
                <td style='background-color: #FFFFCC;font-weight: bold;color:#555555;'>保育</td>
                <td style='background-color: #FFFFCC;font-weight: bold;color:#555555;'>その他</td>
                <td style='background-color: #FFFFCC;color:red;font-weight: bold;'>条件付き</td>
                <?php } ?>
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
                        <?php echo $this->Form->input('OrderCalendar.'.$count.'.id',array('type'=>'hidden')); ?>
                        <?php echo $this->Form->input('OrderCalendar.'.$count.'.case_id',array('type'=>'hidden')); ?>
                        <?php echo $this->Form->input('OrderCalendar.'.$count.'.order_id',array('type'=>'hidden')); ?>
                        <?php echo $this->Form->input('OrderCalendar.'.$count.'.shokushu_num',array('type'=>'hidden')); ?>
                        <?php echo $this->Form->input('OrderCalendar.'.$count.'.work_time_memo',
                                   array('type'=>'textarea','div'=>false,'label'=>false,'style'=>'width:100px;text-align: left;background-color: #ffffcc;', 'rows'=>2)); ?>
                    <?php } elseif ($datas2[$count]['OrderCalendar']['year'] != $year || $datas2[$count]['OrderCalendar']['month'] != $month) { ?>
                        <?php echo $this->Form->input('OrderCalendar.'.$count.'.id',array('type'=>'hidden')); ?>
                       <?php echo $this->Form->input('OrderCalendar.'.$count.'.case_id',array('type'=>'hidden')); ?>
                        <?php echo $this->Form->input('OrderCalendar.'.$count.'.order_id',array('type'=>'hidden')); ?>
                        <?php echo $this->Form->input('OrderCalendar.'.$count.'.shokushu_num',array('type'=>'hidden')); ?>
                        <?php echo $this->Form->input('OrderCalendar.'.$count.'.work_time_memo',
                                   array('type'=>'textarea','div'=>false,'label'=>false,'style'=>'width:100px;text-align: left;background-color: #ffffcc;', 'rows'=>2)); ?>
                    <?php } else { ?>
                        <?php echo $this->Form->input('OrderCalendar.'.$count.'.id',array('type'=>'hidden', 'value'=>$datas2[$count]['OrderCalendar']['id'])); ?>
                       <?php echo $this->Form->input('OrderCalendar.'.$count.'.case_id',array('type'=>'hidden','value'=>$datas2[$count]['OrderCalendar']['case_id'])); ?>
                        <?php echo $this->Form->input('OrderCalendar.'.$count.'.order_id',array('type'=>'hidden','value'=>$datas2[$count]['OrderCalendar']['order_id'])); ?>
                        <?php echo $this->Form->input('OrderCalendar.'.$count.'.shokushu_num',array('type'=>'hidden','value'=>$datas2[$count]['OrderCalendar']['shokushu_num'])); ?>
                        <?php echo $this->Form->input('OrderCalendar.'.$count.'.work_time_memo',
                            array('type'=>'textarea','div'=>false,'label'=>false,'style'=>'width:100px;text-align: left;background-color: #ffffcc;', 
                                'rows'=>2, 'value'=>$datas2[$count]['OrderCalendar']['work_time_memo'])); ?>
                        <?php } ?>

                    <?php echo $this->Form->input('OrderCalendar.'.$count.'.username', array('type'=>'hidden', 'value' => $username)); ?>
                    <?php echo $this->Form->input('OrderCalendar.'.$count.'.class', array('type'=>'hidden', 'value' => $selected_class)); ?>
                    <?php echo $this->Form->input('OrderCalendar.'.$count.'.year',array('type'=>'hidden','value'=>$year)); ?>
                    <?php echo $this->Form->input('OrderCalendar.'.$count.'.month',array('type'=>'hidden','value'=>$month)); ?>
                </td>
                <?php
                        if ($count == $cal_arr[$ii]) {
                            $ii += 1;
                            echo '<td style="background-color: #e8ffff;">勤務</td>';
                        }
                    }
                ?>
                <td colspan="2" rowspan="2" style='background-color: #FFFFDD;'></td>
                <td colspan="1" rowspan="2" style='background-color: #FFFFDD;'></td>
                <td colspan="1" rowspan="2" style='background-color: #FFFFDD;'></td>
                <td colspan="1" rowspan="2" style='background-color: #FFFFDD;'></td>
            </tr>
            <tr id="">
                <td style='background-color: #e8ffff;' colspan="2">推奨スタッフ</td>
            <?php 
                $ii = 0;
                for ($count=0; $count<$col+count($datas); $count++){
                    if ($ii == count($datas)) {
                        break;
                    }
                    if (!empty($datas2[$count])) {
            ?>
                <td style='background-color: #FFFFDD;vertical-align: top;'>
                    <?php echo setArray($list_staffs2[$datas2[$count]['OrderCalendar']['order_id']][$datas2[$count]['OrderCalendar']['shokushu_num']]); ?>
                    <input type="button" value="スタッフ選択" 
                           onclick="window.open('<?=ROOTDIR ?>/ShiftManagement/select2/<?=$datas2[$count]['OrderCalendar']['order_id'] ?>/<?=$datas2[$count]['OrderCalendar']['shokushu_num']-1 ?>?date=<?=$year.'-'.$month ?>&<?=setArray2($list_staffs[$datas2[$count]['OrderCalendar']['order_id']][$datas2[$count]['OrderCalendar']['shokushu_num']]); ?>','スタッフ選択','width=800,height=600,scrollbars=yes');">
                </td>
            <?php
                    } else {
            ?>
                <td style='background-color: #FFFFDD;vertical-align: top;'></td>
            <?php
                    }
                    if ($count == $cal_arr[$ii]) {
                        $ii += 1;
                        echo '<td style="background-color: #e8ffff;">推奨</td>';
                    }
                }
            ?>
                <td style='background-color: #FFFFDD;' colspan="2"></td>
                <td style='background-color: #FFFFDD;'></td>
                <td style='background-color: #FFFFDD;'></td>
                <td style='background-color: #FFFFDD;'></td>
            </tr>
            <tr id="">
                <td style='background-color: #e8ffff;' colspan="2">前月スタッフ</td>
                <?php 
                    $ii = 0;
                    for ($count=0; $count<$col+count($datas); $count++){
                        if ($ii == count($datas)) {
                            break;
                        }
                ?>
                <td style='background-color: #FFFFDD;'>
                    <?php echo setPMStaff($count, $list_premonth); ?>
                </td>
                <?php
                        if ($count == $cal_arr[$ii]) {
                            $ii += 1;
                            echo '<td style="background-color: #e8ffff;">前月</td>';
                        }
                    }
                ?>
                <td style='background-color: #FFFFDD;' colspan="2"></td>
                <td style='background-color: #FFFFDD;'></td>
                <td style='background-color: #FFFFDD;'></td>
                <td style='background-color: #FFFFDD;'></td>
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
                        'onchange'=>'setCalendar(this, document.getElementById("month"))')); ?>年<br>
                        <a href="<?=ROOTDIR ?>/ShiftManagement/schedule?date=<?=date('Y-m', strtotime($y .'-' . $m . ' -1 month')); ?>">▲</a>
                    <?php $month_arr = array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12'); ?>
                    <?php echo $this->Form->input(false, array('id'=>'month', 'type'=>'select','div'=>false,'label'=>false, 'options' => $month_arr,
                        'value'=>$month, 'style'=>'text-align: right;', 'onchange'=>'setCalendar(document.getElementById("year"), this)')); ?>月
                        <a href="<?=ROOTDIR ?>/ShiftManagement/schedule?date=<?=date('Y-m', strtotime($y .'-' . $m . ' +1 month')); ?>">▼</a>
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
                    <?php echo $this->Form->input('OrderCalendar.'.$count.'.remarks',
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
                        } elseif ($datas2[$count]['OrderCalendar']['d'.$d] == 0) {
                            $class_name = 'redips-mark';
                            if (empty($kadou[$count])) {
                                $kadou[$count] = 0;
                            }
                        } elseif ($datas2[$count]['OrderCalendar']['d'.$d] == 1) {
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
                    <?php if (!empty($class_name)) { ?>
                    <span id="null"></span>
                    <?php echo ''; ?>
                    <?php } else { ?>
                    <?php //echo $datas2[$count]['OrderCalendar']['d'.$d]; ?>
                    <span id="<?=setData($datas2,'order_id',$count,$record) ?>"></span>
                    <span id="<?=setData($datas2,'shokushu_num',$count,$record) ?>"></span>
                    <span id="<?=$count+1 ?>"></span>
                    <?php
                        // 待ち合わせ
                        $order_id = setData($datas2,'order_id',$count,$record);
                        $shokushu_num = setData($datas2,'shokushu_num',$count,$record);
                        if (empty($data_aps[$order_id][$shokushu_num][$d])) {
                            $style0 = '';
                        } else {
                            $style0 = 'background-color:#ffcc66;';
                        }
                        if (!empty($staff_cell[$d][$count+1])) {
                            if (!empty($data_staffs[$d][$count+1])) {
                                //$this->log($data_staffs[$d][$count+1], LOG_DEBUG);
                                foreach($data_staffs[$d][$count+1] as $data_staff) {
                                    $point3 = $point_arr[$d][$data_staff['id']];
                                    if (empty($point3)) {
                                        $point3_2 = '';
                                    } else {
                                        $point3_2 = explode(',', $point3);
                                    }
                                    if ($flag == 0) {
                                        $point_str = '('.$point3_2[$count].')';
                                    } else {
                                        $point_str = '';
                                    }
                                    echo '<div id="'.$data_staff['id'].'" class="redips-drag t1" name="'.$data_staff['id'].'_'.$d.'" ' 
                                            //. 'onClick="getStaffProf('.$data_staff['StaffMaster']['id']
                                            .')" style="'.$style0.'">';
                                    //echo '<input type="checkbox" onclick="alert();return false;">';
                                    echo $data_staff['name'].$point_str;
                                    echo '</div>';
                                }
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
                $count = $extra - 5;
                // 未定欄
                if ($flag == 0) {
                    for($k=$count+1; $k<=$count+5; $k++) {
                        if (!empty($data_staffs[$d][$k])) {
                            $span[0] = '';$span[1] = '';$div2 = '';
                            // span
                            $span[0] = '<span id=""></span>';
                            $span[0] = $span[0].'<span id=""></span>';
                            $span[1] = $span[0].'<span id="'.$k.'"></span>';
                            foreach($data_staffs[$d][$k] as $key=>$data_staff) {
                                $this->log($data_staff, LOG_DEBUG);
                                // div
                                $div2 .= '<div id="'.$data_staff['id'].'" class="redips-drag t1" style="'.$style.'" '
                                            //. 'ondblclick="getStaffProf('.$data_staff['StaffMaster']['id']
                                        .')">';
                                $div2 .= $data_staff['name'];
                                $div2 .=  '</div>';
                            }
                            if ($k == $count+1) {
                                echo '<td id="Cell'.$count.'D'.$d.'" class="" style="height:30px;background-color:'.$bgcolor_cal.';border-right-style: dotted;">'.$span[1].$div2.'</td>';
                            } elseif ($k == $count+2) {
                                echo '<td id="Cell'.$count.'D'.$d.'" class="" style="height:30px;background-color:'.$bgcolor_cal.';border-left-style: dotted;">'.$span[1].$div2.'</td>';
                            } else {
                                echo '<td id="Cell'.$count.'D'.$d.'" class="" style="height:30px;background-color:'.$bgcolor_cal.';">'.$span[1].$div2.'</td>';
                            }
                        } else {
                            $span[0] = '';$span[1] = '';
                            // span
                            $span[0] = '<span id=""></span>';
                            $span[0] = $span[0].'<span id=""></span>';
                            $span[1] = $span[0].'<span id="'.$k.'"></span>';
                            if ($k == $count+1) {
                                echo '<td class="" style="height:30px;background-color:'.$bgcolor_cal.';border-right-style: dotted;">'.$span[1].'</td>';
                            } elseif ($k == $count+2) {
                                echo '<td class="" style="height:30px;background-color:'.$bgcolor_cal.';border-left-style: dotted;">'.$span[1].'</td>';
                            } else {
                                echo '<td class="" style="height:30px;background-color:'.$bgcolor_cal.';">'.$span[1].'</td>';
                            }
                        }
                    }
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
                    if (!empty($datas2[$count])) {
            ?>
                <td style='background-color: #FFFFCC;color:#555555;font-weight: bold;'>
                    <?php echo preg_replace('/^[ 　]+|[ 　]+$/', '', $list_shokushu[setData($datas2,'shokushu_id',$count,$record)]); ?>
                    <?php echo setKakko(setData($datas2,'shokushu_memo',$count,$record)); ?>
                </td>
                <?php
                    } else {
                ?>
                <td style='background-color: #FFFFCC;color:#555555;font-weight: bold;'></td>
                <?php
                    }
                    if ($count == $cal_arr[$ii]) {
                        $ii += 1;
                        echo '<td  class="'.$class_mask.'" style="background-color: #e8ffff;color:black;">職種</td>';
                    }
                }
            ?>
                <?php if ($flag == 0) { ?>
                <td style='background-color: #FFFFCC;color:#555555;font-weight: bold;' colspan="2">受付</td>
                <td style='background-color: #FFFFCC;color:#555555;font-weight: bold;'>保育</td>
                <td style='background-color: #FFFFCC;color:#555555;font-weight: bold;'>その他</td>
                <td style='background-color: #FFFFCC;color:red;font-weight: bold;'>条件付き</td>
                <?php } ?>
            </tr>
            <!-- 案件 -->
            <tr>
                <th style='background:#99ccff;text-align: center;width:120px;height: 30px;' colspan="2" class="<?=$class_mask ?>">
                </th>
                <?php foreach ($datas as $key=>$data){ ?>
                <th id="case_<?=$data['OrderCalendar']['case_id'] ?>" 
                    style='background:#99ccff;text-align: center;background-color: <?=setBGColor($data['OrderCalendar']['case_id'], $list_bgcolor) ?>;
                    color: <?=setColor($data['OrderCalendar']['case_id'], $list_color) ?>;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo $getCasename[$data['OrderCalendar']['case_id']]; ?>
                </th>
                <th style="background-color: #99ccff;" align="center">
                </th>
                <?php } ?>
                <?php if ($flag == 0) { ?>
                <th colspan="5" align="center" style="background-color: #66CCFF;color:black;">未定</th>
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
<?php print($this->Form->submit('閉 じ る', array('id'=>'button-delete', 'div'=>false, 'style'=>'' , 'onclick'=>'window.opener.location.reload();window.close();'))); ?>
    </div>
<?php echo $this->Form->end(); ?>  
</div>
