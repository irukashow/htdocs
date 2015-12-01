<?php require('holiday.ctp'); ?>
<?php
    // 初期値
    //$y = date('Y');
    $y = date('Y', strtotime('+1 month'));
    //$m = date('n');
    $m = date('n', strtotime('+1 month'));

    // 日付の指定がある場合
    if(!empty($_GET['date']))
    {
            $arr_date = explode('-', $_GET['date']);

            if(count($arr_date) == 2 and is_numeric($arr_date[0]) and is_numeric($arr_date[1]))
            {
                    $y = (int)$arr_date[0];
                    $m = (int)$arr_date[1];
            }
    }
    // 祝日取得
    $national_holiday = japan_holiday($y);
?>
<?php
    function setFlag($val) {
        if ($val == 1) {
            $ret = '◎';
        } elseif ($val == 2) {
            $ret = '△';
        } else {
            $ret = '　';
        }
        return $ret;
    }
?>
<?php
// 紹介可能職種コード（カンマ区切り）から職種名称
function setShokushu($shokushu_ids, $list_arr) {
    $ret = '';
    if (empty($shokushu_ids)) {
        return $ret;
    }
    $shokushu_arr = explode(',', $shokushu_ids);
    foreach($shokushu_arr as $key=>$value) {
        if (empty($value)) {
            continue;
        }
        if (empty($ret)) {
            $ret = trim(mb_convert_kana($list_arr[$value], "s", 'UTF-8'));
        } else {
            $ret = $ret.', '.trim(mb_convert_kana($list_arr[$value], "s", 'UTF-8'));
        }
    }
    return $ret;
}
// NULLはスペースに
function NZ($value, $array) {
    if (count($array) == 0) {
        $ret = '';
    } else {
        $ret = $value;
    }
    return $ret;
}
?>
<script>
onload = function() {
    //FixedMidashi.create();
    document.getElementById('StaffScheduleSearchName').focus();
}
</script>
<style type="text/css" media="screen">
  div.scroll_div { 
      overflow: auto;
<?php if (empty($datas1)) { ?>
      height: auto;
<?php } else { ?>
      height: 200px;
<?php } ?>
      width: 100%;
      margin-top: 5px;
  }
</style>
<style type="text/css" media="screen">
    table {
        font-size: 90%;
        padding: 1px;
    }
    table th {
        font-size: 110%;
    }
</style>
<script type="text/javascript">
<!--
$(function() {
    // 全選択・全解除
    $('#SelectAll').on('change', function(){
        if($("#SelectAll:checked").val()) {
            for(i=0; i<31; i++) {
                $("#work_flag"+(i+1)).val("1");
            }
            for (j=0; j<=6; j++) {
                $("#SelectWeek"+j).prop({'checked':'checked'});
            }
        }
        else {
            for(i=0; i<31; i++) {
                $("#work_flag"+(i+1)).val("0");
            }
            for (j=0; j<=6; j++) {
                $("#SelectWeek"+j).prop({'checked':false});
            }
        } 
    });
    // 土日選択・解除
    $('#SelectHoliday').on('change', function(){
        if($("#SelectHoliday:checked").val()) {
            for(i=0; i<31; i++) {
                if ($("#Holiday"+(i+1)).val() == 0) {
                    $("#work_flag"+(i+1)).val("0");
                    continue;
                }
                $("#work_flag"+(i+1)).val("1");
            }
            for(j=1; j<6; j++) {
                $("#SelectWeek"+j).prop({'checked':false});
            }
            $("#SelectWeek0").prop({'checked':'checked'});
            $("#SelectWeek6").prop({'checked':'checked'});
        } else {
            for(i=0; i<31; i++) {
                if ($("#Holiday"+(i+1)).val() == 0) {
                    $("#work_flag"+(i+1)).val("0");
                    continue;
                }
                $("#work_flag"+(i+1)).val("0");
            }
            for(j=1; j<6; j++) {
                $("#SelectWeek"+j).prop({'checked':false});
            }
            $("#SelectWeek0").prop({'checked':false});
            $("#SelectWeek6").prop({'checked':false});
        } 
    });
    // 平日選択・解除
    $('#SelectWeekday').on('change', function(){
        if($("#SelectWeekday:checked").val()) {
            for(i=0; i<31; i++) {
                if ($("#Holiday"+(i+1)).val() == 1) {
                    $("#work_flag"+(i+1)).val("0");
                    continue;
                }
                $("#work_flag"+(i+1)).val("1");
            }
            for(j=1; j<6; j++) {
                $("#SelectWeek"+j).prop({'checked':'checked'});
            }
            $("#SelectWeek0").prop({'checked':false});
            $("#SelectWeek6").prop({'checked':false});
        } else {
            for(i=0; i<31; i++) {
                if ($("#Holiday"+(i+1)).val() == 1) {
                    $("#work_flag"+(i+1)).val("0");
                    continue;
                }
                $("#work_flag"+(i+1)).val("0");
            }
            for(j=1; j<6; j++) {
                $("#SelectWeek"+j).prop({'checked':false});
            }
            $("#SelectWeek0").prop({'checked':false});
            $("#SelectWeek6").prop({'checked':false});
        } 
    });
    // カスタム選択・解除
    <?php for($i=0; $i<=6; $i++) { ?>
    $('#SelectWeek<?=$i?>').on('change', function(){
        if($("#SelectWeek<?=$i?>:checked").val()) {
            for(i=0; i<31; i++) {
                /**
                if ($("#Holiday"+(i+1)).val() == 1) {
                    $("#work_flag"+(i+1)).val("0");
                    continue;
                }
                **/
                if ($("#WeekD"+(i+1)).val() == <?=$i?>) {
                    $("#work_flag"+(i+1)).val("1");
                }
            }
        } else {
            for(i=0; i<31; i++) {
                /**
                if ($("#Holiday"+(i+1)).val() == 1) {
                    $("#work_flag"+(i+1)).val("0");
                    continue;
                }
                **/
                if ($("#WeekD"+(i+1)).val() == <?=$i?>) {
                    $("#work_flag"+(i+1)).val("0");
                }
            }
        } 
    });
    <?php } ?>
    // 全クリア
    $('#SelectClear').on('change', function(){
        if($("#SelectClear:checked").val()) {
            for(i=0; i<31; i++) {
                $("#work_flag"+(i+1)).val("0");
            }
            for (j=0; j<=6; j++) {
                $("#SelectWeek"+j).prop({'checked':false});
            }
        } 
    });
});
-->
</script>  

<div style="width:90%;margin-top: 20px;margin-left: auto; margin-right: auto; height: auto;">
    <fieldset style="border:none;margin-bottom: 0px;">

<div style="font-size: 100%;margin-bottom: 0px;">
<?php echo $this->Form->create('StaffSchedule', array('name'=>'form')); ?>
<?php echo $this->Form->submit('検　索', array('name' => 'search', 'div' => false, 'style' => 'display:none;')); ?>
    
                <!-- 選択中スタッフ -->
                 <table border='1' cellspacing="0" cellpadding="1" style='margin-top: 0px;margin-bottom: 5px;border-spacing: 0px;width:100%;'>
                     <tr>
                         <th colspan="4" style='background:#99ccff;text-align: center;'>選択スタッフ</th>
                     </tr>
                     <?php if (!empty($data2)) { ?>
                     <tr style="">
                         <td align="center" style="width:15%;background-color: #ddffff;">
                         <?=$data2['StaffMaster']['id']; ?>
                             <?php $shokushu_id = $data2['StaffMaster']['shokushu_shoukai']; ?>
                             <input type="hidden" name="staff_id" value="<?=$data2['StaffMaster']['id']; ?>">
                         </td>
                         <td align="left" style="padding:0px 10px 0px 10px;width: 25%;font-size: 110%;background-color: #ffffcc;">
                             <?=$data2['StaffMaster']['name']; ?>
                         </td>
                        <td align="left" style="padding: 0 10px 0 10px;width: 50%;">
                            <?=setShokushu($data2['StaffMaster']['shokushu_shoukai'], $shokushu_arr); ?>
                        </td>
                         <td align="center" style="background-color: #ddffff;">
                             <?php 
                                if (!empty($datas3)) { 
                                    $disabled = 'disabled';
                                } else {
                                    $disabled = '';
                                }
                            ?>
                             <?php echo $this->Form->submit('削除', array('id'=>'button-delete', 
                                 'name' => 'erasure['.$data2['StaffMaster']['id'].']', 'div' => false, 
                                 'style'=>'font-size:110%;padding:2px 15px 2px 15px;', 'disabled'=>$disabled)); ?>
                         </td>
                     </tr>
                     <?php } else { ?>
                         <?php $shokushu_id = ''; ?>
                <!-- スタッフ検索 -->
                    <tr style="background-color: #ddffff;">
                        <td style='text-align: center;' style="width:15%;">氏　名</td>
                        <td align="center" colspan="2" style="width:75%;">
                            <?php echo $this->Form->input('search_name',array('label'=>false,'div'=>false,'maxlength'=>'30', 'placeholder'=>'漢字、もしくは、ひらがな', 'style'=>'width:95%;padding:3px;')); ?>
                        </td>
                        <td align="center" style="width:10%;">
                            <?php echo $this->Form->submit('検　索', array('name' => 'search', 'div' => false, 'style' => 'font-size:110%;padding: 5px 10px;')); ?>
                        </td>
                    </tr>
                    <?php if (!empty($datas1)) { ?>
                    <?php foreach ($datas1 as $data1) { ?>
                    <tr>
                        <td align="center"><?=$data1['StaffMaster']['id']; ?></td>
                        <td align="left" style="padding: 0 10px 0 10px;">
                            <?=$data1['StaffMaster']['name_sei'].' '.$data1['StaffMaster']['name_mei']; ?>
                        </td>
                        <td align="left" style="padding: 0 10px 0 10px;width: 50%;">
                            <?=setShokushu($data1['StaffMaster']['shokushu_shoukai'], $shokushu_arr); ?>
                        </td>
                        <td align="center">
                            <?php echo $this->Form->submit('選択', 
                                    array('name' => 'select['.$data1['StaffMaster']['id'].']', 'id' => 'button-create', 'div' => false, 'style'=>'font-size:110%;padding:3px 15px 3px 15px;')); ?>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php } else { ?>
                    <tr>
                        <td colspan="4" align="center">スタッフを指定してください。</td>
                    </tr>
                    <?php } ?>
                    <?php } ?>
                </table>

    <!-- 月選択 -->
    <table border='1' cellspacing="0" cellpadding="3" style="width:100%;margin-top: 0px;border-spacing: 0px;background-color: white;">
            <tr align="center">
                    <td style=''><a href="<?=ROOTDIR ?>/ShiftManagement/input_schedule/<?=$staff_id ?>?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' -1 month')); ?>">&lt; 前の月</a></td>
                    <td style='background-color: #006699;color: white;font-size: 110%;'>
                        <font style='font-size: 110%;'>
                            <a href="#" class="" style="color: white; text-decoration: none;" onclick="location.reload();">【<?php echo $y ?>年<?php echo $m ?>月 シフト希望】</a>
                        </font>
                        <input type="hidden" name="month" value="<?=$y.'-'.$m ?>">
                    </td>
                    <td style=''><a href="<?=ROOTDIR ?>/ShiftManagement/input_schedule/<?=$staff_id ?>?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' +1 month')); ?>">次の月 &gt;</a></td>
            </tr>
    </table>
    <!-- 月選択 END -->
    
    <!-- 制御 -->
    <table border="1" style="width:85%;margin-top: 5px;">
        <tr>
            <td>
                <div style="float: left;">
                    <label for="SelectAll">
                        <input type="radio" name="select" id="SelectAll" style="vertical-align: -3px;">
                        全て◎&nbsp;&nbsp;
                    </label> 
                </div>
                <div style="float: left;">
                    <label for="SelectHoliday">
                        <input type="radio" name="select" id="SelectHoliday" style="vertical-align: -3px;">
                        土日祝を◎&nbsp;&nbsp;
                    </label> 
                </div>
                <div style="float: left;">
                    <label for="SelectWeekday">
                        <input type="radio" name="select" id="SelectWeekday" style="vertical-align: -3px;">
                        平日を◎（祝日除く）&nbsp;&nbsp;
                    </label> 
                </div>
                <div style="float: left;">
                    <label for="SelectClear">
                        <input type="radio" name="select" id="SelectClear" style="vertical-align: -3px;">
                        全てクリア&nbsp;&nbsp;
                    </label> 
                </div>
                <div style="float: left;">
                【カスタム選択】
                </div>
                <div style="float: left;">
                    <!-- カスタム選択 -->
                    <label for="SelectWeek1">
                        <input type="checkbox" name="select1" id="SelectWeek1" style="vertical-align: -3px;">
                        月&nbsp;
                    </label>
                </div>
                <div style="float: left;">
                    <label for="SelectWeek2">
                        <input type="checkbox" name="select2" id="SelectWeek2" style="vertical-align: -3px;">
                        火&nbsp;
                    </label> 
                </div>
                <div style="float: left;">
                    <label for="SelectWeek3">
                        <input type="checkbox" name="select3" id="SelectWeek3" style="vertical-align: -3px;">
                        水&nbsp;
                    </label> 
                </div>
                <div style="float: left;">
                    <label for="SelectWeek4">
                        <input type="checkbox" name="select4" id="SelectWeek4" style="vertical-align: -3px;">
                        木&nbsp;
                    </label>
                </div>
                <div style="float: left;">
                    <label for="SelectWeek5">
                        <input type="checkbox" name="select5" id="SelectWeek5" style="vertical-align: -3px;">
                        金&nbsp;
                    </label>
                </div>
                <div style="float: left;">
                    <label for="SelectWeek6">
                        <input type="checkbox" name="select6" id="SelectWeek6" style="vertical-align: -3px;">
                        土&nbsp;
                    </label>
                </div>
                <div style="float: left;">
                    <label for="SelectWeek0">
                        <input type="checkbox" name="select0" id="SelectWeek0" style="vertical-align: -3px;">
                        日&nbsp;
                    </label>
                    <!-- カスタム選択 END -->
                </div>
            </td>
        </tr>
    </table>
    <!-- 制御 END -->
    
    <table border='1' cellspacing="0" cellpadding="3" style="width:100%;margin-top: 5px;margin-bottom: 10px;border-spacing: 0px;background-color: white;">
        <tr align="center" style="background-color: #cccccc;">
            <th style="width:10%">日付</th>
            <th style="width:10%">勤務可能</th>
            <th style="width:30%">備　考</th>
        </tr>
<?php
    // 曜日の配列作成
    $weekday = array( "日", "月", "火", "水", "木", "金", "土" );
    // 1日の曜日を数値で取得
    $fir_weekday = date( "w", mktime( 0, 0, 0, $m, 1, $y ) );
    // 1日の曜日設定
    $i = $fir_weekday; // カウント値リセット

    // 行の変更
    echo "<tr>";
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
    //-------------スタイルシート設定終わり---------------------------
        // 今日の日付の場合、背景色追加
        if( $y == date('Y') && $m == date('m') && $d == date('d') ){
            $style2 = "background: #ffffcc;";
        } else {
            $style2 = '';
        }
    //-------------スタイルシート設定終わり-----------------------------
        $selected_date = $y.'-'.sprintf('%02d', $m).'-'.sprintf('%02d', $d);
        if (!empty($datas3)) {
            // 日付セル作成とスタイルシートの挿入
            echo '<tr style="'.$style2.';">';
            echo '<td align="center" style="color:'.$style.';">'.$m.'/'.$d.'('.$weekday[$i].')';
            if ($i==0 || $i==6 || !empty($national_holiday[date("Y-m-d", mktime(0, 0, 0, $m, $d, $y))])) {
                echo '<input type="hidden" id="Holiday'.$d.'" value="1">';
            } else {
                echo '<input type="hidden" id="Holiday'.$d.'" value="0">';
            }
            echo '<input type="hidden" id="WeekD'.$d.'" value="'.$i.'">';
            echo $this->Form->input('StaffSchedule.'.$d.'.id', array('type'=>'hidden', 'value'=>$datas3[$d-1]['StaffSchedule']['id']));
            echo $this->Form->input('StaffSchedule.'.$d.'.class', array('type'=>'hidden', 'value' => $selected_class));
            echo $this->Form->input('StaffSchedule.'.$d.'.staff_id', array('type'=>'hidden', 'value' => $staff_id));
            echo $this->Form->input('StaffSchedule.'.$d.'.shokushu_id', array('type'=>'hidden', 'value' => $datas3[$d-1]['StaffSchedule']['shokushu_id']));
            echo '</td>';
            $list_work = array('0'=>'✕', '1'=>'◎','2'=>'△'); 
            echo '<td align="center">';
            echo $this->Form->input('StaffSchedule.'.$d.'.work_flag', array('type'=>'select', 'id'=>'work_flag'.$d , 'value'=>$datas3[$d-1]['StaffSchedule']['work_flag'], 'legend'=>false,
                'label'=>false, 'div'=>false,'style'=>'font-weight:bold;','options'=>$list_work));   
            echo '</td>';
            echo '<td align="left">';
            echo $this->Form->input('StaffSchedule.'.$d.'.conditions',array('label'=>false, 'div'=>'float:left;','style'=>'font-size:100%;width:80%;', 'value'=>$datas3[$d-1]['StaffSchedule']['conditions']));
            echo '</td>';
            echo '</tr>';
        } else {
            // 日付セル作成とスタイルシートの挿入
            echo '<tr style="'.$style2.';">';
            echo '<td align="center" style="color:'.$style.';">'.$m.'/'.$d.'('.$weekday[$i].')';
            if ($i==0 || $i==6 || !empty($national_holiday[date("Y-m-d", mktime(0, 0, 0, $m, $d, $y))])) {
                echo '<input type="hidden" id="Holiday'.$d.'" value="1">';
            } else {
                echo '<input type="hidden" id="Holiday'.$d.'" value="0">';
            }
            echo '<input type="hidden" id="WeekD'.$d.'" value="'.$i.'">';
            echo $this->Form->input('StaffSchedule.'.$d.'.id', array('type'=>'hidden'));
            echo $this->Form->input('StaffSchedule.'.$d.'.class', array('type'=>'hidden', 'value' => $selected_class));
            echo $this->Form->input('StaffSchedule.'.$d.'.staff_id', array('type'=>'hidden', 'value' => $staff_id));
            echo $this->Form->input('StaffSchedule.'.$d.'.work_date', array('type'=>'hidden', 'value' => $selected_date));
            echo $this->Form->input('StaffSchedule.'.$d.'.shokushu_id', array('type'=>'hidden', 'value' => $shokushu_id));
            echo '</td>';
            $list_work = array('0'=>'✕', '1'=>'◎','2'=>'△'); 
            echo '<td align="center">';
            echo $this->Form->input('StaffSchedule.'.$d.'.work_flag', array('type'=>'select', 'id'=>'work_flag'.$d, 'legend'=>false,
                'label'=>false, 'div'=>false,'style'=>'font-weight:bold;','options'=>$list_work));
            echo '</td>';
            echo '<td align="center">';
            echo $this->Form->input('StaffSchedule.'.$d.'.conditions',array('label'=>false, 'div'=>'float:left;', 'style'=>'font-size:100%;width:80%;'));
            echo '</td>';
            echo '</tr>';
        }
        $i++; //カウント値（曜日カウンター）+1
    }
?>
        </tr>
    </table>
    
    <div style='margin-top: 10px;margin-left: 10px;'>
<?php print($this->Form->submit('登　録', array('id'=>'button-create', 'name'=>'commit', 'div'=>false, 'style'=>''))); ?>
&nbsp;&nbsp;       
<?php print($this->Html->link('閉じる', '#', array('id'=>'button-delete', 'div'=>false, 'style'=>'' , 'onclick'=>'window.opener.location.reload();window.close();'))); ?>
    </div>
<?php echo $this->Form->end(); ?>        
    </fieldset>

</div>
        
