<?php require 'schedule_element.ctp'; ?>

<div id="loading"><img src="<?=ROOTDIR ?>/img/loading.gif"></div>
<!-- 見出し１ -->
<div id='headline' style="padding:10px 10px 10px 10px;">
    ★ シフト管理
    &nbsp;&nbsp;
    <a href="<?=ROOTDIR ?>/ShiftManagement/index" target=""><font Style="font-size:95%;">スタッフシフト希望</font></a>
    &nbsp;
    <b><font Style="font-size:95%;color: yellow;">[シフト作成]</font></b>        <!-- alert("制作中");return false; -->
    &nbsp;
    <a href="<?=ROOTDIR ?>/ShiftManagement/uri9" target=""><font Style="font-size:95%;">勤務実績</font></a>
    &nbsp;
    <a href="<?=ROOTDIR ?>/ShiftManagement/test2" target="" onclick=''><font Style="font-size:95%;">稼働表ベース表テスト</font></a>
    &nbsp;
    <a href="<?=ROOTDIR ?>/ShiftManagement/test" target="" onclick=''><font Style="font-size:95%;">稼働表技術テスト</font></a>
</div>
<!-- 見出し１ END -->

<div style="width:<?=setWidth($row) ?>px;margin-top: 0px;<?=$font_normal ?>;">
    <?php echo $this->Form->create('WorkTable', array('name'=>'frm', 'id'=>'form')); ?> 
    <table border='1' cellspacing="0" cellpadding="3" style="width:98%;margin-top: -5px;border-spacing: 0px;background-color: white;">
            <tr align="center">
                    <td style=''><a href="<?=ROOTDIR ?>/ShiftManagement/schedule?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' -1 month')); ?>">&lt; 前の月</a></td>
                    <td style='background-color: #006699;color: white;'>
                        <font style='font-size: 110%;'>【<?php echo $y ?>年<?php echo $m ?>月 稼働表】</font>
                    </td>
                    <td style=''><a href="<?=ROOTDIR ?>/ShiftManagement/schedule?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' +1 month')); ?>">次の月 &gt;</a></td>
            </tr>
    </table>
        
    <div id="redips-drag" style="margin-top: 5px;margin-bottom: 10px;">  
        <!-- 職種入力 -->   
        <table border='1' cellspacing="0" cellpadding="5" id="table1"
               style="width:<?=120+$row*120 ?>px;margin-top: 0px;margin-bottom: 10px;border-spacing: 0px;table-layout: fixed;" _fixedhead="rows:2; cols:1">
            <colgroup> 
              <col style='width:25px;'>
              <col style='width:95px;'>
              <?php for ($count=0; $count<$row; $count++){ ?>
              <col style='width:120px;'>
              <?php } ?>
            </colgroup>
            <thead>
            <tr>
                <th style='background:#99ccff;text-align: center;width:120px;height: 30px;' colspan="2">
                    <a href="#" onclick="setHidden();">
                        <span id="ActiveDisplay" onclick="">シフト編集</span>
                    </a>
                </th>
                <?php foreach ($datas as $key=>$data){ ?>
                <th class="demo" id="case_<?=$data['OrderCalender']['case_id'] ?>" style='background:#99ccff;text-align: center;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo $getCasename[$data['OrderCalender']['case_id']]; ?>
                </th>
                <?php } ?>
            </tr>
            </thead>
            <tbody style="overflow: auto;">
            <tr style="">
                <td class="redips-trash" style='background-color: #999999;color: white;' colspan="2">削除</td>
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td class="redips-trash" style='background-color: #999999;color: white;'>
                    <?php echo $count+1; ?>
                    <?php echo $this->Form->input('WorkTable.'.($count+1).'.case_id',array('type'=>'hidden', 'value'=>setData($datas2,'case_id',$count,$record))); ?>
                    <?php echo $this->Form->input('WorkTable.'.($count+1).'.order_id',array('type'=>'hidden', 'value'=>setData($datas2,'order_id',$count,$record))); ?>
                    <?php echo $this->Form->input('WorkTable.'.($count+1).'.shokushu_num',array('type'=>'hidden','value'=>setData($datas2,'shokushu_num',$count,$record))); ?>
                    <?php echo $this->Form->input('WorkTable.'.($count+1).'.username', array('type'=>'hidden', 'value' => $username)); ?>
                    <?php echo $this->Form->input('WorkTable.'.($count+1).'.class', array('type'=>'hidden', 'value' => $selected_class)); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail1">
                <td style='background-color: #e8ffff;' colspan="2">事業主</td>
                <?php foreach ($datas as $data){ ?>
                <td style='background:#ffffcc;text-align: center;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo NZ($list_entrepreneur[$data['OrderCalender']['case_id']]); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail2">
                <td style='background-color: #e8ffff;' colspan="2">販売会社</td>
                <?php foreach ($datas as $data){ ?>
                <td style='text-align: center;background-color: white;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo NZ($list_client[$data['OrderCalender']['case_id']]); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail3">
                <td style='background-color: #e8ffff;' colspan="2">指揮命令者/<br>担当者</td>
                <?php foreach ($datas as $data){ ?>
                <td style='text-align: center;background-color: white;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo NZ($list_director[$data['OrderCalender']['case_id']]); ?>様
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail4">
                <td style='background-color: #e8ffff;' colspan="2">現場住所</td>
                <?php foreach ($datas as $data){ ?>
                <td style='text-align: center;background-color: white;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo NZ($list_address[$data['OrderCalender']['case_id']]); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail5">
                <td style='background-color: #e8ffff;' colspan="2">現場連絡先</td>
                <?php foreach ($datas as $data){ ?>
                <td style='text-align: center;background-color: white;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo 'TEL:'.NZ($list_telno[$data['OrderCalender']['case_id']]); ?><br>
                <?php echo 'FAX:'.NZ($list_faxno[$data['OrderCalender']['case_id']]); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail6">
                <td style='background-color: #e8ffff;' colspan="2">待ち合わせ</td>
                <?php foreach ($datas as $data){ ?>
                <td style='text-align: center;background-color: white;' colspan="<?=$data[0]['cnt'] ?>">
                    <?php echo $this->Form->input('WorkTable.0.juchuu_cal',
                            array('type'=>'textarea','div'=>false,'label'=>false,'rows'=>2, 'style'=>'text-align: left;width: 95%;')); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail7">
                <td style='background-color: #e8ffff;' colspan="2">請求先担当者</td>
                <?php foreach ($datas as $data){ ?>
                <td style='text-align: center;background-color: white;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo NZ($list_bill[$data['OrderCalender']['case_id']]); ?>様
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail8">
                <td style='background-color: #e8ffff;' colspan="2">請求書締日</td>
                <?php foreach ($datas as $data){ ?>
                <td style='text-align: center;background-color: white;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo NZ($list_cutoff[$data['OrderCalender']['case_id']]); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail9">
                <td style='background-color: #e8ffff;' colspan="2">クリーニング</td>
                <?php foreach ($datas as $data){ ?>
                <td style='text-align: center;background-color: white;' colspan="<?=$data[0]['cnt'] ?>">
                    <?php echo $this->Form->input('WorkTable.0.juchuu_cal',
                            array('type'=>'text','div'=>false,'label'=>false, 'style'=>'text-align: left;')); ?>
                </td>
                <?php } ?>
            </tr>
            <!-- 受注 -->
            <?php $list1 = array('1'=>'時間', '2'=>'日払', '3'=>'月払'); ?>
            <?php $list2 = array('1'=>'有', '0'=>'無'); ?>
            <tr id="OrderDetail10">
                <td rowspan="3" style='background-color: #e8ffff;'></td>
                <td rowspan="2" style='background-color: #e8ffff;'>単価</td>
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td style='background-color: white;'>
                    \ <?php echo $this->Form->input('WorkTable.'.$count.'.kyuuyo_cal',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:90px;text-align: left;')); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail11">
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td style='background-color: white;'>
                    \ <?php echo $this->Form->input('WorkTable.'.$count.'.kyuuyo_cal',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:90px;text-align: left;')); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail12">
                <td rowspan="1" style='background-color: #e8ffff;'>残業／ｈ</td>
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td style='background-color: white;'>
                    \ <?php echo $this->Form->input('WorkTable.'.$count.'.kyuuyo_cal',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:90px;text-align: left;')); ?>
                </td>
                <?php } ?>
            </tr>
            <!-- 受注 END -->
            <!-- 給与 -->
            <tr id="OrderDetail13">
                <td rowspan="4" style='background-color: #e8ffff;'>ス<br>タ<br>ッ<br>フ<br>分</td>
                <td style='background-color: #e8ffff;'>時給</td>
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td style='background-color: white;'>
                    \ <?php echo $this->Form->input('WorkTable.'.$count.'.kyuuyo_cal',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:90px;text-align: left;')); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail14">
                <td style='background-color: #e8ffff;'>基本日給</td>
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td style='background-color: white;'>
                    \ <?php echo $this->Form->input('WorkTable.'.$count.'.kyuuyo_cal',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:90px;text-align: left;')); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail15">
                <td style='background-color: #e8ffff;'>残業／ｈ</td>
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td style='background-color: white;'>
                    \ <?php echo $this->Form->input('WorkTable.'.$count.'.kyuuyo_cal',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:90px;text-align: left;')); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail16">
                <td style='background-color: #e8ffff;'>研修中（時給）</td>
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td style='background-color: white;'>
                    \ <?php echo $this->Form->input('WorkTable.'.$count.'.kyuuyo_cal',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:90px;text-align: left;')); ?>
                </td>
                <?php } ?>
            </tr>
            <!-- 給与 END -->
            <tr>
                <td style='width:80px;background-color: #e8ffff;' colspan="2" id="message">職種</td>
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td style='background-color: #ffffcc;'>
                    <?php echo $list_shokushu[setData($datas2,'shokushu_id',$count,$record)]; ?>
                    <?php echo setKakko(setData($datas2,'shokushu_memo',$count,$record)); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail17">
                <td style='background-color: #e8ffff;' colspan="2">勤務時間</td>
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td style='background-color: #ffffcc;'>
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
                        array('type'=>'textarea','div'=>false,'label'=>false,'style'=>'width:100px;text-align: left;background-color: #ffffcc;', 'rows'=>2)); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail18">
                <td style='background-color: #e8ffff;' colspan="2">休憩時間</td>
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td style='background-color: #ffffcc;'>
                    <?php echo setData($datas2,'resttime_from',$count,$record); ?>&nbsp;～
                    <?php echo setData($datas2,'resttime_to',$count,$record); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="">
                <td style='background-color: #e8ffff;' colspan="2">推奨スタッフ</td>
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td style='background-color: #ffffcc;'>
                    <?php echo setArray($list_staffs2[$datas2[$count]['OrderCalender']['order_id']][$datas2[$count]['OrderCalender']['shokushu_num']]); ?>
                    <input type="button" value="スタッフ選択" 
                           onclick="window.open('<?=ROOTDIR ?>/CaseManagement/select/<?=$datas2[$count]['OrderCalender']['order_id'] ?>/<?=$datas2[$count]['OrderCalender']['shokushu_num']-1 ?>?<?=setArray2($list_staffs[$datas2[$count]['OrderCalender']['order_id']][$datas2[$count]['OrderCalender']['shokushu_num']]); ?>','スタッフ選択','width=800,height=600,scrollbars=yes');">
                </td>
                <?php } ?>
            </tr>
            <tr id="">
                <td style='background-color: #e8ffff;' colspan="2">前月スタッフ</td>
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td style='background-color: #ffffcc;'>
                    <?php echo setRecoStaff($count, $list_recommend); ?>
                </td>
                <?php } ?>
            </tr>
            <tr>
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
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td align='left' style='background-color: #e8ffff;'>
                    <?php echo $this->Form->input('OrderCalender.'.$count.'.remarks',
                        array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:100px;text-align: left;', 'rows'=>2)); ?>
                </td>
                <?php } ?>
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
                    echo '<td align="center" style="color:'.$style.';background-color: #e8ffff;" colspan="2">'.$m.'/'.$d.'('.$weekday[$i].')</td>';
                    if ($i==0 || $i==6) {
                        echo '<input type="hidden" id="HolidayD'.$d.'" value="1">';
                    } else {
                        echo '<input type="hidden" id="HolidayD'.$d.'" value="0">';
                    }
                    for ($count=0; $count<$row; $count++){
                        if (empty($datas2) || empty($datas2[$count])) {
                            $class_name = 'redips-mark';
                        } elseif ($datas2[$count]['OrderCalender']['d'.$d] == 0) {
                            $class_name = 'redips-mark';
                        } elseif ($datas2[$count]['OrderCalender']['d'.$d] == 1) {
                            $class_name = '';
                        }
            ?>
                <td id="Cell<?=$count ?>D<?=$d ?>" class="<?=$class_name ?>">
                    <?php if (empty($datas2) || empty($datas2[$count])) { ?>
                    <?php echo ''; ?>
                    <?php } else { ?>
                    <?php //echo $datas2[$count]['OrderCalender']['d'.$d]; ?>
                    <?php } ?>
                    <span id="<?=setData($datas2,'order_id',$count,$record) ?>"></span>
                    <span id="<?=setData($datas2,'shokushu_num',$count,$record) ?>"></span>
                    <?php
                        if (!empty($staff_cell[$d][$count+1])) {
                            if (!empty($data_staffs[$d][$count+1])) {
                                $this->log($data_staffs[$d][$count+1], LOG_DEBUG);
                                foreach($data_staffs[$d][$count+1] as $data_staff) {
                                    echo '<div id="'.$data_staff['StaffMaster']['id'].'" class="redips-drag t1">';
                                    echo $data_staff['StaffMaster']['name_sei'].$data_staff['StaffMaster']['name_mei'];
                                    echo '</div>';
                                }
                            }
                        }
                    ?>
                    <?php
                    foreach ($request_staffs as $data) {
                        if (date('j', strtotime($data['StaffSchedule']['work_date'])) == $d 
                                && chkShokushu(setData($datas2,'shokushu_id',$count,$record), $data['StaffSchedule']['shokushu_id'])) {
                            echo $data['StaffSchedule']['staff_id'].'<br>';
                        }
                    }
                    ?>
                </td>
            <?php
                    }
                    echo '</tr>';
                    $i++; //カウント値（曜日カウンター）+1
                }
            ?>
            <!-- カレンダー部分 END -->
            </tbody>
        </table>
    </div>
<div id="Div" style="display: none;"><p id="Mbox0">セルをクリックしたらここに書き出します。</p>
 <p id="Mbox1">インデックス値は '0'から始まります。</p>
</div>
    
    <div style='margin-left: 10px;'>
<button type="button" id="button-create" onclick="doAccount(<?=$y ?>,<?=sprintf("%02d", $m) ?>, 1);">保存</button>
    &nbsp;&nbsp;
<?php print($this->Form->submit('確定する', array('id'=>'button-create', 'name'=>'save','div' => false))); ?>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php print($this->Html->link('前回保存時まで戻す', 'javascript:void(0);', array('id'=>'button-delete', 'style'=>'' , 'onclick'=>'window.location.reload();'))); ?>
    &nbsp;&nbsp;
<?php print($this->Html->link('ページを戻る', 'javascript:void(0);', array('id'=>'button-delete', 'style'=>'padding:8px;', 
    'onclick'=>'deleteCookie("edit");location.href="'.ROOTDIR.'/ShiftManagement/index"'))); ?>
    </div>
<div style="margin-top: 5px;">
    ※「前回保存時まで戻す」は、保存していない分をキャンセルすることを指す。[F5]でも同様の動作をします。
</div>
<?php echo $this->Form->end(); ?>  
</div>
