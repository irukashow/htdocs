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
        <b><font Style="font-size:95%;color: yellow;">[シフト作成]</font></b> 
        &nbsp;
        <a href="<?=ROOTDIR ?>/ShiftManagement/schedule3?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' 0 month')); ?>" target=""><font Style="font-size:95%;">確定シフト</font></a>
        &nbsp;
        <a href="<?=ROOTDIR ?>/ShiftManagement/setting" target="" onclick=''><font Style="font-size:95%;">詳細設定</font></a>
        &nbsp;&nbsp;&nbsp;
        <a href="<?=ROOTDIR ?>/ShiftManagement/schedule_new?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' 0 month')); ?>" target=""><font Style="font-size:95%;">試作１</font></a>
        &nbsp;&nbsp;&nbsp;
        <a href="<?=ROOTDIR ?>/ShiftManagement/schedule_new2?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' 0 month')); ?>" target=""><font Style="font-size:95%;">試作２</font></a>
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
                    <a href="#" onclick="setHidden();">
                        <span id="ActiveDisplay" onclick="">【表示切り替え】</span>
                    </a>
                </th>
                <?php foreach ($datas as $key=>$data){ ?>
                <th id="case_<?=$data['OrderCalender']['case_id'] ?>" 
                    style='background:#99ccff;text-align: center;background-color: <?=setBGColor($data['OrderCalender']['case_id'], $list_bgcolor) ?>;
                    color: <?=setColor($data['OrderCalender']['case_id'], $list_color) ?>;' colspan="<?=$data[0]['cnt'] ?>">
                    <div id="<?=$data['OrderCalender']['case_id'] ?>"></div>
                    <div id="<?=$year.'-'.sprintf('%02d', $month) ?>"></div>
                    <?php echo $getCasename[$data['OrderCalender']['case_id']]; ?>
                </th>
                <th style="background-color: #99ccff;" align="center">
                    <a href="#" onclick="setHidden();">
                        <span id="ActiveDisplay" onclick="">表示</span>
                    </a>
                </th>
                <?php } ?>
                <?php if ($flag == 0) { ?>
                <th colspan="5" align="center" style="background-color: #66CCFF;">未定</th>
                <?php } ?>
            </tr>
            </thead>
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
                <td style='background-color: #e8ffff;' colspan="2">弊社担当</td>
                <?php 
                    $total_col = 0;
                    foreach ($datas as $key=>$data){
                        $from = $total_col;
                        //$to = $total_col + $data[0]['cnt'] - 1;
                ?>
                <td style='background:white;text-align: center;' colspan="<?=$data[0]['cnt'] ?>">
                    <?php echo $this->Form->input('OrderCalender.'.$from.'.tantou',
                            array('type'=>'text','div'=>false,'label'=>false, 
                                'value'=>NZ($data['OrderCalender']['tantou']), 'style'=>'text-align: left;width:95%;')); ?>
                </td>
                <td style="background-color: #e8ffff;">担当</td>
                <?php
                        $total_col += $data[0]['cnt'];
                    } 
                ?>
                <td colspan="5" rowspan="18" align="center" style="background-color: white;"></td>
            </tr>
            <tr id="OrderDetail1">
                <td style='background-color: #e8ffff;' colspan="2">事業主</td>
                <?php foreach ($datas as $data){ ?>
                <td style='background:#ffffcc;text-align: center;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo NZ($list_entrepreneur[$data['OrderCalender']['case_id']]); ?>
                </td>
                <td style="background-color: #e8ffff;">事業</td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail2">
                <td style='background-color: #e8ffff;' colspan="2">販売会社</td>
                <?php foreach ($datas as $data){ ?>
                <td style='text-align: center;background-color: white;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo NZ($list_client[$data['OrderCalender']['case_id']]); ?>
                </td>
                <td style="background-color: #e8ffff;">販売</td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail3">
                <td style='background-color: #e8ffff;' colspan="2">指揮命令者/<br>担当者</td>
                <?php foreach ($datas as $data){ ?>
                <td style='text-align: center;background-color: white;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo NZ($list_director[$data['OrderCalender']['case_id']]); ?>様
                </td>
                <td style="background-color: #e8ffff;">指揮</td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail4">
                <td style='background-color: #e8ffff;' colspan="2">現場住所</td>
                <?php foreach ($datas as $data){ ?>
                <td style='text-align: center;background-color: white;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo NZ($list_address[$data['OrderCalender']['case_id']]); ?>
                </td>
                <td style="background-color: #e8ffff;">現場</td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail5">
                <td style='background-color: #e8ffff;' colspan="2">現場連絡先</td>
                <?php foreach ($datas as $data){ ?>
                <td style='text-align: center;background-color: white;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo 'TEL:'.NZ($list_telno[$data['OrderCalender']['case_id']]); ?><br>
                <?php echo 'FAX:'.NZ($list_faxno[$data['OrderCalender']['case_id']]); ?>
                </td>
                <td style="background-color: #e8ffff;">連絡</td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail6">
                <td style='background-color: #e8ffff;' colspan="2">待ち合わせ</td>
                <?php foreach ($datas as $data){ ?>
                <td style='text-align: center;background-color: white;' colspan="<?=$data[0]['cnt'] ?>">
                    <?php echo $this->Form->input('OrderInfoDetail.0.juchuu_cal',
                            array('type'=>'textarea','div'=>false,'label'=>false,'rows'=>2, 'style'=>'text-align: left;width: 95%;')); ?>
                </td>
                <td style="background-color: #e8ffff;">待合</td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail7">
                <td style='background-color: #e8ffff;' colspan="2">請求先担当者</td>
                <?php foreach ($datas as $data){ ?>
                <td style='text-align: center;background-color: white;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo NZ($list_bill[$data['OrderCalender']['case_id']]); ?> 様
                </td>
                <td style="background-color: #e8ffff;">請・担</td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail8">
                <td style='background-color: #e8ffff;' colspan="2">請求書締日</td>
                <?php foreach ($datas as $data){ ?>
                <td style='text-align: center;background-color: white;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo NZ($list_cutoff[$data['OrderCalender']['case_id']]); ?>
                </td>
                <td style="background-color: #e8ffff;">請・締</td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail19">
                <td style='background-color: #e8ffff;' colspan="2">請求書郵送日</td>
                <?php foreach ($datas as $data){ ?>
                <td style='text-align: center;background-color: white;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo NZ($list_cutoff[$data['OrderCalender']['case_id']]); ?>
                </td>
                <td style="background-color: #e8ffff;">請・郵</td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail9">
                <td style='background-color: #e8ffff;' colspan="2">クリーニング</td>
                <?php 
                $total_col = 0;
                foreach ($datas as $data){ 
                    $from = $total_col;
                    ?>
                <td style='text-align: center;background-color: white;' colspan="<?=$data[0]['cnt'] ?>">
                    <?php echo $this->Form->input('OrderInfoDetail.'.$from.'.cleanning',
                            array('type'=>'text','div'=>false,'label'=>false, 'style'=>'text-align: left;width:95%;')); ?>
                </td>
                <td style="background-color: #e8ffff;">ｸﾘｰﾆﾝｸﾞ</td>
                <?php
                        $total_col += $data[0]['cnt'];
                    } 
                ?>
            </tr>
            <!-- 受注 -->
            <?php $list1 = array('1'=>'時給', '2'=>'日給', '3'=>'月給'); ?>
            <?php $list2 = array('1'=>'有', '0'=>'無'); ?>
            <tr id="OrderDetail10">
                <td rowspan="3" style='background-color: #e8ffff;'>請<br>求<br>分</td>
                <td rowspan="2" style='background-color: #e8ffff;'>単価</td>
                <?php 
                    $ii = 0;
                    for ($count=0; $count<$col+count($datas); $count++){
                        if ($ii == count($datas)) {
                            break;
                        }
                ?>
                <td style='background-color: white;'>
                    \ <?php echo $this->Form->input('OrderCalender.'.$count.'.juchuu_money_d',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:90px;text-align: right;', 
                                //'onchange'=>'calUri1(this,'.$count.')', 
                                'value'=>setDMoney($count, $datas2))); ?>
                </td>
                <?php
                        if ($count == $cal_arr[$ii]) {
                            $ii += 1;
                            echo '<td style="background-color: #e8ffff;">請｜日</td>';
                        }
                    }
                ?>
            </tr>
            <tr id="OrderDetail11">
                <?php 
                    $ii = 0;
                    for ($count=0; $count<$col+count($datas); $count++){
                        if ($ii == count($datas)) {
                            break;
                        }
                ?>
                <td style='background-color: white;'>
                    \ <?php echo $this->Form->input('OrderCalender.'.$count.'.juchuu_money_h',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:90px;text-align: right;', 
                                'value'=>setHMoney($count, $datas2))); ?>
                </td>
                <?php
                        if ($count == $cal_arr[$ii]) {
                            $ii += 1;
                            echo '<td style="background-color: #e8ffff;">請｜時</td>';
                        }
                    }
                ?>
            </tr>
            <tr id="OrderDetail12">
                <td rowspan="1" style='background-color: #e8ffff;'>残業／ｈ</td>
                <?php 
                    $ii = 0;
                    for ($count=0; $count<$col+count($datas); $count++){
                        if ($ii == count($datas)) {
                            break;
                        }
                ?>
                <td style='background-color: white;'>
                    \ <?php echo $this->Form->input('OrderCalender.'.$count.'.juchuu_money_z',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:90px;text-align: right;', 'value'=>setZMoney($count, $datas2))); ?>
                </td>
                <?php
                        if ($count == $cal_arr[$ii]) {
                            $ii += 1;
                            echo '<td style="background-color: #e8ffff;">請｜残</td>';
                        }
                    }
                ?>
            </tr>
            <!-- 受注 END -->
            <!-- 給与 -->
            <tr id="OrderDetail13">
                <td rowspan="4" style='background-color: #e8ffff;'>ス<br>タ<br>ッ<br>フ<br>分</td>
                <td style='background-color: #e8ffff;'>時給</td>
                <?php 
                    $ii = 0;
                    for ($count=0; $count<$col+count($datas); $count++){
                        if ($ii == count($datas)) {
                            break;
                        }
                ?>
                <td style='background-color: white;'>
                    \ <?php echo $this->Form->input('OrderCalender.'.$count.'.staff_money_h',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:90px;text-align: right;', 'value'=>setHMoney2($count, $datas2))); ?>
                </td>
                <?php
                        if ($count == $cal_arr[$ii]) {
                            $ii += 1;
                            echo '<td style="background-color: #e8ffff;">ス｜時</td>';
                        }
                    }
                ?>
            </tr>
            <tr id="OrderDetail14">
                <td style='background-color: #e8ffff;'>基本日給</td>
                <?php 
                    $ii = 0;
                    for ($count=0; $count<$col+count($datas); $count++){
                        if ($ii == count($datas)) {
                            break;
                        }
                ?>
                <td style='background-color: white;'>
                    \ <?php echo $this->Form->input('OrderCalender.'.$count.'.staff_money_d',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:90px;text-align: right;', 
                                'value'=>setDMoney2($count, $datas2),
                                //'onchange'=>'calJinkenhi1(this,'.$count.')'
                                )); ?>
                </td>
                <?php
                        if ($count == $cal_arr[$ii]) {
                            $ii += 1;
                            echo '<td style="background-color: #e8ffff;">ス｜日</td>';
                        }
                    }
                ?>
            </tr>
            <tr id="OrderDetail15">
                <td style='background-color: #e8ffff;'>残業／ｈ</td>
                <?php 
                    $ii = 0;
                    for ($count=0; $count<$col+count($datas); $count++){
                        if ($ii == count($datas)) {
                            break;
                        }
                ?>
                <td style='background-color: white;'>
                    \ <?php echo $this->Form->input('OrderCalender.'.$count.'.staff_money_z',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:90px;text-align: right;', 'value'=>setZMoney2($count, $datas2))); ?>
                </td>
                <?php
                        if ($count == $cal_arr[$ii]) {
                            $ii += 1;
                            echo '<td style="background-color: #e8ffff;">ス｜残</td>';
                        }
                    }
                ?>
            </tr>
            <tr id="OrderDetail16">
                <td style='background-color: #e8ffff;'>研修中（時給）</td>
                <?php 
                    $ii = 0;
                    for ($count=0; $count<$col+count($datas); $count++){
                        if ($ii == count($datas)) {
                            break;
                        }
                ?>
                <td style='background-color: white;'>
                    \ <?php echo $this->Form->input('OrderCalender.'.$count.'.staff_money_tr',
                            array('type'=>'text','div'=>false,'label'=>false,
                                'style'=>'width:90px;text-align: right;', 'value'=>setTrMoney2($count, $datas2))); ?>
                </td>
                <?php
                        if ($count == $cal_arr[$ii]) {
                            $ii += 1;
                            echo '<td style="background-color: #e8ffff;">ス｜研</td>';
                        }
                    }
                ?>
            </tr>
            <!-- 給与 END -->
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
            <tr id="OrderDetail17">
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
                        <?php echo $this->Form->input('OrderCalender.'.$count.'.case_id',array('type'=>'hidden')); ?>
                        <?php echo $this->Form->input('OrderCalender.'.$count.'.order_id',array('type'=>'hidden')); ?>
                        <?php echo $this->Form->input('OrderCalender.'.$count.'.shokushu_num',array('type'=>'hidden')); ?>
                        <?php echo $this->Form->input('OrderCalender.'.$count.'.work_time_memo',
                                   array('type'=>'textarea','div'=>false,'label'=>false,'style'=>'width:100px;text-align: left;background-color: #ffffcc;', 'rows'=>2)); ?>
                    <?php } elseif ($datas2[$count]['OrderCalender']['year'] != $year || $datas2[$count]['OrderCalender']['month'] != $month) { ?>
                        <?php echo $this->Form->input('OrderCalender.'.$count.'.id',array('type'=>'hidden')); ?>
                       <?php echo $this->Form->input('OrderCalender.'.$count.'.case_id',array('type'=>'hidden')); ?>
                        <?php echo $this->Form->input('OrderCalender.'.$count.'.order_id',array('type'=>'hidden')); ?>
                        <?php echo $this->Form->input('OrderCalender.'.$count.'.shokushu_num',array('type'=>'hidden')); ?>
                        <?php echo $this->Form->input('OrderCalender.'.$count.'.work_time_memo',
                                   array('type'=>'textarea','div'=>false,'label'=>false,'style'=>'width:100px;text-align: left;background-color: #ffffcc;', 'rows'=>2)); ?>
                    <?php } else { ?>
                        <?php echo $this->Form->input('OrderCalender.'.$count.'.id',array('type'=>'hidden', 'value'=>$datas2[$count]['OrderCalender']['id'])); ?>
                       <?php echo $this->Form->input('OrderCalender.'.$count.'.case_id',array('type'=>'hidden','value'=>$datas2[$count]['OrderCalender']['case_id'])); ?>
                        <?php echo $this->Form->input('OrderCalender.'.$count.'.order_id',array('type'=>'hidden','value'=>$datas2[$count]['OrderCalender']['order_id'])); ?>
                        <?php echo $this->Form->input('OrderCalender.'.$count.'.shokushu_num',array('type'=>'hidden','value'=>$datas2[$count]['OrderCalender']['shokushu_num'])); ?>
                        <?php echo $this->Form->input('OrderCalender.'.$count.'.work_time_memo',
                            array('type'=>'textarea','div'=>false,'label'=>false,'style'=>'width:100px;text-align: left;background-color: #ffffcc;', 
                                'rows'=>2, 'value'=>$datas2[$count]['OrderCalender']['work_time_memo'])); ?>
                        <?php } ?>

                    <?php echo $this->Form->input('OrderCalender.'.$count.'.username', array('type'=>'hidden', 'value' => $username)); ?>
                    <?php echo $this->Form->input('OrderCalender.'.$count.'.class', array('type'=>'hidden', 'value' => $selected_class)); ?>
                    <?php echo $this->Form->input('OrderCalender.'.$count.'.year',array('type'=>'hidden','value'=>$year)); ?>
                    <?php echo $this->Form->input('OrderCalender.'.$count.'.month',array('type'=>'hidden','value'=>$month)); ?>
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
            <tr id="OrderDetail18">
                <td style='background-color: #e8ffff;' colspan="2">休憩時間</td>
                <?php 
                    $ii = 0;
                    for ($count=0; $count<$col+count($datas); $count++){
                        if ($ii == count($datas)) {
                            break;
                        }
                ?>
                <td style='background-color: #FFFFDD;'>
                    <?php echo setData($datas2,'resttime_from',$count,$record); ?>&nbsp;～
                    <?php echo setData($datas2,'resttime_to',$count,$record); ?>
                </td>
                <?php
                        if ($count == $cal_arr[$ii]) {
                            $ii += 1;
                            echo '<td style="background-color: #e8ffff;">休憩</td>';
                        }
                    }
                ?>
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
                    <?php echo setArray($list_staffs2[$datas2[$count]['OrderCalender']['order_id']][$datas2[$count]['OrderCalender']['shokushu_num']]); ?>
                    <input type="button" value="スタッフ選択" 
                           onclick="window.open('<?=ROOTDIR ?>/ShiftManagement/select2/<?=$datas2[$count]['OrderCalender']['order_id'] ?>/<?=$datas2[$count]['OrderCalender']['shokushu_num']-1 ?>?date=<?=$year.'-'.$month ?>&<?=setArray2($list_staffs[$datas2[$count]['OrderCalender']['order_id']][$datas2[$count]['OrderCalender']['shokushu_num']]); ?>','スタッフ選択','width=800,height=600,scrollbars=yes');">
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
                        'onchange'=>'setCalender(this, document.getElementById("month"))')); ?>年<br>
                        <a href="<?=ROOTDIR ?>/ShiftManagement/schedule?date=<?=date('Y-m', strtotime($y .'-' . $m . ' -1 month')); ?>">▲</a>
                    <?php $month_arr = array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12'); ?>
                    <?php echo $this->Form->input(false, array('id'=>'month', 'type'=>'select','div'=>false,'label'=>false, 'options' => $month_arr,
                        'value'=>$month, 'style'=>'text-align: right;', 'onchange'=>'setCalender(document.getElementById("year"), this)')); ?>月
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
                    <?php if (!empty($class_name)) { ?>
                    <span id="null"></span>
                    <?php echo ''; ?>
                    <?php } else { ?>
                    <?php //echo $datas2[$count]['OrderCalender']['d'.$d]; ?>
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
                                //$this->log($data_staff, LOG_DEBUG);
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
                    <a href="#" onclick="setHidden();">
                        <span id="ActiveDisplay" onclick="">【表示切り替え】</span>
                    </a>
                </th>
                <?php foreach ($datas as $key=>$data){ ?>
                <th id="case_<?=$data['OrderCalender']['case_id'] ?>" 
                    style='background:#99ccff;text-align: center;background-color: <?=setBGColor($data['OrderCalender']['case_id'], $list_bgcolor) ?>;
                    color: <?=setColor($data['OrderCalender']['case_id'], $list_color) ?>;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo $getCasename[$data['OrderCalender']['case_id']]; ?>
                </th>
                <th style="background-color: #99ccff;" align="center">
                    <a href="#" onclick="setHidden();">
                        <span id="ActiveDisplay" onclick="">表示</span>
                    </a>
                </th>
                <?php } ?>
                <?php if ($flag == 0) { ?>
                <th colspan="5" align="center" style="background-color: #66CCFF;color:black;">未定</th>
                <?php } ?>
            </tr>
            <!-- 売上給与統計 -->
            <tr id="OrderDetail20">
                <td colspan="2" style="height:30px;text-align: center;background-color: #e8ffff;color:black;" class="<?=$class_mask ?>">予定稼働人数</td>
                <?php 
                    $ii = 0;
                    for ($count=0; $count<$col+count($datas); $count++){
                        if ($ii == count($datas)) {
                            break;
                        }
                ?>
                <td style="background-color: white;height:30px;text-align: right;padding-right: 10px;">
                    <?=$kadou[$count] ?>
                    <input type="hidden" id="running_num<?=$count?>" value="<?=$kadou[$count] ?>">
                </td>
                <?php
                        if ($count == $cal_arr[$ii]) {
                            $ii += 1;
                            echo '<td style="background-color: #e8ffff;">稼働</td>';
                        }
                    }
                ?>
                <td colspan="5" rowspan="10" style="background-color: white;"></td>
            </tr>
            <tr id="OrderDetail21">
                <td colspan="2" style="height:30px;text-align: center;background-color: #e8ffff;color:black;" class="<?=$class_mask ?>">売上見込み合計</td>
                <?php 
                    $ii = 0;
                    for ($count=0; $count<$col+count($datas); $count++){
                        if ($ii == count($datas)) {
                            break;
                        }
                ?>
                <td style="background-color: white;height:30px;">
                    \ <?php echo $this->Form->input('OrderCalender.'.$count.'.uriage',
                            array('type'=>'text','id'=>'uri1_'.$count,'div'=>false,'label'=>false,
                                'value'=>setUriSum($count, $datas2, $kadou[$count]), 'style'=>'text-align: right;width: 80%;', 'disabled')); ?>
                    <input type="hidden" name="data[OrderCalender][<?=$count ?>][uriage]" value="<?=setUriSum($count, $datas2, $kadou[$count]) ?>">
                </td>
                <?php
                        if ($count == $cal_arr[$ii]) {
                            $ii += 1;
                            echo '<td style="background-color: #e8ffff;">売上</td>';
                        }
                    }
                ?>
            </tr>
            <tr id="OrderDetail22">
                <td colspan="2" style="height:30px;text-align: center;background-color: #e8ffff;color:black;" class="<?=$class_mask ?>">人件費見込み合計</td>
                <?php 
                    $ii = 0;
                    for ($count=0; $count<$col+count($datas); $count++){
                        if ($ii == count($datas)) {
                            break;
                        }
                ?>
                <td style="background-color: white;height:30px;">
                    \ <?php echo $this->Form->input('OrderCalender.'.$count.'.jinkenhi',
                            array('type'=>'text','id'=>'jinkenhi1_'.$count,'div'=>false,'label'=>false,
                                'value'=>setJinkenhiSum($count, $datas2, $kadou[$count]), 'style'=>'text-align: right;width: 80%;', 'disabled')); ?>
                    <input type="hidden" name="data[OrderCalender][<?=$count ?>][jinkenhi]" value="<?=setJinkenhiSum($count, $datas2, $kadou[$count]) ?>">
                </td>
                <?php
                        if ($count == $cal_arr[$ii]) {
                            $ii += 1;
                            echo '<td style="background-color: #e8ffff;">人件</td>';
                        }
                    }
                ?>
            </tr>
            <tr id="OrderDetail23">
                <td colspan="2" style="height:40px;text-align: center;background-color: #ffecde;color:black;" class="<?=$class_mask ?>">物件別売上見込み</td>
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
                <td style="background-color: #e8ffff;">売上計</td>
                <?php
                        $total_col += $data[0]['cnt'];
                    } 
                ?>
            </tr>
            <tr id="OrderDetail24">
                <td colspan="2" style="height:85px;text-align: center;background-color: #99ccff;color:black;" class="<?=$class_mask ?>"><b>交通費について<br>（ｲﾚｷﾞｭﾗｰ別途）</b></td>
                <?php 
                    $ii = 0;
                    for ($count=0; $count<$col+count($datas); $count++){
                        if ($ii == count($datas)) {
                            break;
                        }
                ?>
                <td style="background-color: white;height:85px;">
                    <?php
                        if (empty($datas2[$count]['OrderInfoDetail']['kyuuyo_koutsuuhi'])) {
                            echo $this->Form->input('OrderCalender.'.$count.'.koutsuuhi',
                                    array('type'=>'textarea','div'=>false,'label'=>false,'rows'=>'3', 'style'=>'text-align: left;width: 95%;font-size:90%;')); 
                        } elseif ($datas2[$count]['OrderInfoDetail']['kyuuyo_koutsuuhi'] == 0) {
                            echo '交通費支給：なし';
                        } elseif ($datas2[$count]['OrderInfoDetail']['kyuuyo_koutsuuhi'] == 1) {
                            echo '交通費支給：あり<br>';
                            echo $this->Form->input('OrderCalender.'.$count.'.koutsuuhi',
                                    array('type'=>'textarea','div'=>false,'label'=>false,'rows'=>'3',
                                        'value'=>$datas2[$count]['OrderCalender']['koutsuuhi'], 'style'=>'text-align: left;width: 95%;font-size:90%;')); 
                        } else {
                            //echo '交通費支給：不明';
                        }
                    ?>
                </td>
                <?php
                        if ($count == $cal_arr[$ii]) {
                            $ii += 1;
                            echo '<td style="background-color: #99ccff;color:black;"><b>交通費</b></td>';
                        }
                    }
                ?>
            </tr>
            <tr id="OrderDetail25">
                <td rowspan="1" align="center" style='background-color: #e8ffff;height:165px;color:black;' colspan="2" class="<?=$class_mask ?>">
                    備考
                </td>
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
                <td style="background-color: #e8ffff;">備考</td>
                <?php
                        $total_col += $data[0]['cnt'];
                    } 
                ?>
            </tr>
            <tr id="OrderDetail26">
                <td colspan="2" style="height:30px;text-align: center;background-color: #e8ffff;color:black;" class="<?=$class_mask ?>">注意事項</td>
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
                <td style="background-color: #e8ffff;">注意</td>
                <?php
                        $total_col += $data[0]['cnt'];
                    } 
                ?>
            </tr>
            <tr id="OrderDetail27">
                <td colspan="2" style="height:30px;text-align: center;background-color: #e8ffff;color:black;" class="<?=$class_mask ?>">契約書</td>
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
                <td style="background-color: #e8ffff;">契約書</td>
                <?php
                        $total_col += $data[0]['cnt'];
                    } 
                ?>
            </tr>
            <!-- 月の合計 -->
            <?php if (!empty($datas) && !empty($datas2)) { ?>
            <tr  id="OrderDetail28" style="background-color:white;">
                <td rowspan="3" colspan="2" style="height:75px;background-color: #e8ffff;color:black;" class="<?=$class_mask ?>">総計</td>
                <td colspan="2" algin="center" style="font-size:110%;height:30px;background-color: #ffccff;">今月の売上見込み</td>
                <td colspan="2" algin="center" style="font-size:110%;background-color: #ffcccc;">人件費見込み合計</td>
            <?php if ($col > 5) { ?>
                <td colspan="<?=$col-5 ?>" rowspan="2"style="background-color: white;"></td>
            </tr>
            <?php } ?>
            <tr id="OrderDetail29" style="background-color:white;">
                <td colspan="2" algin="center" style="font-size:120%;height:40px;">
                    <?php
                        $ret = 0;
                        for ($count=0; $count<$col; $count++) {
                            $ret += str_replace(',', '', setDMoney($count, $datas2))*$kadou[$count];
                        }
                        echo '\\ '.$this->Form->input('OrderCalender.0.uriage_monthly',
                            array('type'=>'text','div'=>false,'label'=>false,'value'=>number_format($ret),
                                'style'=>'text-align:right;width: 130px;font-size:120%;background-color:white;', 'disabled'));
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
                                'style'=>'text-align:right;width: 130px;font-size:120%;background-color:white;', 'disabled'));
                    ?>
                    <input type="hidden" name="data[OrderCalender][0][jinnkenhi_monthly]" value="<?=number_format($ret2) ?>">
                </td>
            </tr>
            <?php } ?>
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
