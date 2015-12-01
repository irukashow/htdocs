<?php require('holiday.ctp'); ?>
<?php
    // 初期値
    $y = date('Y', strtotime('+1 month'));
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
<script type="text/javascript">
<!--
onload = function() {
    for(i=0; i<31; i++) {
        $('#flag1_'+(i+1)).val([0]).checkboxradio('refresh');
        $('#flag2_'+(i+1)).val([0]).checkboxradio('refresh');
        $('#flag0_'+(i+1)).val([0]).checkboxradio('refresh');
    }
}
$(function() {
    // 全選択・全解除
    $('#SelectAll').on('change', function(){
        if($("#SelectAll:checked").val()) {
            for(i=0; i<31; i++) {
                $('#flag1_'+(i+1)).val([1]).checkboxradio('refresh');
                $('#flag2_'+(i+1)).val([0]).checkboxradio('refresh');
                $('#flag0_'+(i+1)).val([1]).checkboxradio('refresh');
            }
            $('#SelectClear').val([0]).checkboxradio('refresh');
            $('#SelectHoliday').val([0]).checkboxradio('refresh');
        }
        else {
            for(i=0; i<31; i++) {
                $('#flag1_'+(i+1)).val([0]).checkboxradio('refresh');
                $('#flag0_'+(i+1)).val([0]).checkboxradio('refresh');
            }
        } 
    });
    // 土日祝選択・解除
    $('#SelectHoliday').on('change', function(){
        if($("#SelectHoliday:checked").val()) {
            for(i=0; i<31; i++) {
                if ($("#Holiday"+(i+1)).val() == 0) {
                    $('#flag1_'+(i+1)).val([0]).checkboxradio('refresh');
                    $('#flag0_'+(i+1)).val([0]).checkboxradio('refresh');
                    continue;
                }
                $('#flag1_'+(i+1)).val([1]).checkboxradio('refresh');
                $('#flag0_'+(i+1)).val([1]).checkboxradio('refresh');
            }
            $('#SelectClear').val([0]).checkboxradio('refresh');
            $('#SelectAll').val([0]).checkboxradio('refresh');
        } else {
            for(i=0; i<31; i++) {
                if ($("#Holiday"+(i+1)).val() == 0) {
                    continue;
                }
                $('#flag1_'+(i+1)).val([0]).checkboxradio('refresh');
                $('#flag0_'+(i+1)).val([0]).checkboxradio('refresh');
            }
        } 
    });
    // すべてクリアする
    $('#SelectClear').on('change', function(){
        if($("#SelectClear:checked").val()) {
            for(i=0; i<31; i++) {
                $('#flag0_'+(i+1)).val([0]).checkboxradio('refresh');
                $('#flag1_'+(i+1)).val([0]).checkboxradio('refresh');
                $('#flag2_'+(i+1)).val([0]).checkboxradio('refresh');
                $('#SelectAll').val([0]).checkboxradio('refresh');
                $('#SelectHoliday').val([0]).checkboxradio('refresh');
            }
        }
    });
});
-->
</script>  
<style>
input[type=checkbox] {
    width: 15px;
    height: 15px;
    margin-left: -15px;
    vertical-align: middle;
}
</style>
<div id="page2" data-role="page" data-url="<?=ROOTDIR ?>/users/schedule?date=<?=$date1 ?>">
    <?php
        if ($class == '11') {
            $area = '関西';
        } elseif ($class == '21') {
            $area = '関東';
        } elseif ($class == '31') {
            $area = '中部';
        } else {
            $area = '？';
        }
    ?>
    <div data-role="header" data-theme="c">
        <h1>シフト希望<span style="font-size: 90%;margin-left: 5px;">（<?=$area ?>エリア）</span></h1>
            <!--
            <a href="#" data-role="button" data-icon="refresh" data-iconpos="notext" data-inline="true" onclick="location.reload();"></a>
            -->
            <a href="#dialog_menu" class="ui-btn-right" data-role="button" data-transition="slidedown" data-icon="bars" data-iconpos="notext"></a>
    </div>
        <div data-role="content" style="font-size: 80%;">
            <!--- シフト希望表 --->
            <!-- カレンダー -->
        <?php echo $this->Form->create('StaffSchedule', array('name' => 'form')); ?>
            <!-- メッセージ -->
            <?php
                if (empty($msg)) {
                    echo '';
                } else {
                    echo '<div style="font-size:120%;color:red;margin-bottom:5px;margin-top:-5px;">'.$msg.'</div>';
                }
            ?>
            <table border='1' cellspacing="0" cellpadding="3" style="width:100%;margin-top: 0px;border-spacing: 0px;background-color: white;">
                <tr align="center">
                    <td><a href="<?=ROOTDIR ?>/users/schedule?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' -1 month')); ?>" data-ajax="false" style="font-size:110%;">&lt; 前の月</a></td>
                    <td style="background-color: #D7EEFF;"><div style="font-size:120%;">【<?php echo $y ?>年<?php echo $m ?>月】</div></td>
                    <td><a href="<?=ROOTDIR ?>/users/schedule?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' +1 month')); ?>" data-ajax="false" style="font-size:110%;">次の月 &gt;</a></td>
                </tr>
            </table>
            
            <?php
                if (empty($data)) {
            ?>
            <div style="margin-top: 5px;font-size: 120%;">
                <font style="color:blue;font-size:100%;">【未申請】</font>勤務可能な日を◎に、不可の日を✕に、可能かもしれない日を△にしてください。
            </div>
            <!-- 選択 -->
            <div data-role="fieldcontain">
                <fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">
                    <input type="checkbox" name="SelectAll" id="SelectAll">
                    <label for="SelectAll">全てを◎</label> 
                    <input type="checkbox" name="SelectHoliday" id="SelectHoliday">
                    <label for="SelectHoliday">土日祝を◎</label> 
                    <input type="checkbox" name="SelectClear" id="SelectClear">
                    <label for="SelectClear">すべてクリア</label> 
                </fieldset>
            </div>
            <!-- 選択 END -->
            <table border='1' cellspacing="0" cellpadding="3" style="width:100%;margin-top: 5px;margin-bottom: 10px;border-spacing: 0px;background-color: white;">
                <tr align="center" style="background-color: #cccccc;">
                    <th style="width:10%">日付</th>
                    <th style="width:40%">勤務可能</th>
                    <th style="width:50%">備考</th>
                </tr>
            <?php
                } else {
            ?>
            <div style="margin-top: 5px;font-size: 120%;">
                <font style="color:red;font-size:100%;">【申請済】<?=date('Y年n月j日 H時i分', strtotime($data[1]['modified'])) ?></font>
                　<a href="<?=ROOTDIR ?>/users/schedule_edit?date=<?=$date1 ?>" data-ajax="false">変更</a>
            </div>
            <table border='1' cellspacing="0" cellpadding="3" style="width:100%;margin-top: 5px;margin-bottom: 10px;border-spacing: 0px;background-color: white;">
                <tr align="center" style="background-color: #cccccc;">
                    <th style="width:15%">日付</th>
                    <th style="width:25%">勤務可能</th>
                    <th style="width:60%">備考</th>
                </tr>
            <?php
                }
            ?>

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
                if( $i == 0 || !empty($national_holiday[date("Ymd", mktime(0, 0, 0, $m, $d, $y))]) ){ //日曜日の文字色
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
                if (!empty($data[$d])) {
                    // 日付セル作成とスタイルシートの挿入
                    echo '<tr style="'.$style2.';">';
                    echo '<td align="center" style="color:'.$style.';">'.$d.'('.$weekday[$i].')';
                    if ($i==0 || $i==6 || !empty($national_holiday[date("Ymd", mktime(0, 0, 0, $m, $d, $y))])) {
                        echo '<input type="hidden" id="Holiday'.$d.'" value="1">';
                    } else {
                        echo '<input type="hidden" id="Holiday'.$d.'" value="0">';
                    }
                    echo $this->Form->input('StaffSchedule.'.$d.'.id', array('type'=>'hidden', 'value'=>$data[$d]['id']));
                    echo $this->Form->input('StaffSchedule.'.$d.'.class', array('type'=>'hidden', 'value' => $class));
                    echo $this->Form->input('StaffSchedule.'.$d.'.staff_id', array('type'=>'hidden', 'value' => $id));
                    echo $this->Form->input('StaffSchedule.'.$d.'.shokushu_id', array('type'=>'hidden', 'value' => $shokushu_id));
                    $list_work = array('0'=>'✕', '1'=>'◎','2'=>'△'); 
                    echo '<td align="center">';
                    echo $list_work[$data[$d]['work_flag']];   
                    echo '</td>';
                    echo '<td align="left">';
                    echo $data[$d]['conditions'];
                    echo '</td>';
                    echo '</tr>';
                } else {
                    // 日付セル作成とスタイルシートの挿入
                    echo '<tr style="'.$style2.';">';
                    echo '<td align="center" style="color:'.$style.';">'.$d.'('.$weekday[$i].')';
                    if ($i==0 || $i==6 || !empty($national_holiday[date("Ymd", mktime(0, 0, 0, $m, $d, $y))])) {
                        echo '<input type="hidden" id="Holiday'.$d.'" value="1">';
                    } else {
                        echo '<input type="hidden" id="Holiday'.$d.'" value="0">';
                    }
                    echo $this->Form->input('StaffSchedule.'.$d.'.id', array('type'=>'hidden'));
                    echo $this->Form->input('StaffSchedule.'.$d.'.class', array('type'=>'hidden', 'value' => $class));
                    echo $this->Form->input('StaffSchedule.'.$d.'.staff_id', array('type'=>'hidden', 'value' => $id));
                    echo $this->Form->input('StaffSchedule.'.$d.'.work_date', array('type'=>'hidden', 'value' => $selected_date));
                    echo $this->Form->input('StaffSchedule.'.$d.'.shokushu_id', array('type'=>'hidden', 'value' => $shokushu_id));
                    echo '</td>';
                    echo '<td align="center">';
        ?>
            <div data-role="fieldcontain">
                <fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">
                    <input type="radio" name="data[StaffSchedule][<?=$d ?>][work_flag]" id="flag1_<?=$d ?>" value="1">
                    <label for="flag1_<?=$d ?>">◎</label> 
                    <input type="radio" name="data[StaffSchedule][<?=$d ?>][work_flag]" id="flag2_<?=$d ?>" value="2">
                    <label for="flag2_<?=$d ?>">△</label> 
                    <input type="radio" name="data[StaffSchedule][<?=$d ?>][work_flag]" id="flag0_<?=$d ?>" value="0">
                    <label for="flag0_<?=$d ?>">✕</label> 
                </fieldset>
            </div>   
        <?php
                    echo '</td>';
                    echo '<td align="center">';
                    echo $this->Form->input('StaffSchedule.'.$d.'.conditions',array('label'=>false, 'div'=>'float:left;','style'=>'font-size:90%;','data-inline'=>'true'));
                    echo '</td>';
                    echo '</tr>';
                }
                $i++; //カウント値（曜日カウンター）+1
            }
        ?>
                </tr>
            </table>
            <!-- カレンダー END-->
            <div style='float:left;'>
            <?php
                if (empty($data)) {
            ?>
                <input type="submit" value="入力確認" data-theme="e" data-icon="check" data-inline="true">
            <?php
                }
            ?>
                <input type="button" value="戻　る" data-inline="true" onclick='location.href="<?=ROOTDIR ?>/users/schedule#page3";'>
            </div>  
            <?php echo $this->Form->end(); ?>
        </div>
        <div class="pagetop">
                <a href="#page2">
                    <?php echo $this->Html->image('pagetop.png'); ?>
                </a>
        </div>			
        <div id="footer">
            <?=FOOTER ?>
        </div>
</div>

<div id="page3" data-role="page">
    <div data-role="header" data-theme="c">
            <h1>スケジュール<span style="font-size: 90%;margin-left: 5px;">（<?=$area ?>エリア）</span></h1>
            <a href="#dialog_menu" class="ui-btn-right" data-role="button" data-transition="slidedown" data-icon="bars" data-iconpos="notext"></a>
    </div>			
    <div data-role="content">
        <p>以下の入力ができます。</p>
        <input type="button" value="１．シフト希望" data-icon="arrow-r" data-iconpos="right" onclick='location.href="?date=<?=$date1 ?>"'>
        <input type="button" value="２．確定スケジュール" data-icon="arrow-r" data-iconpos="right" onclick='location.href="#message_s"'>
        <input type="button" value="３．スタッフシフト表" data-icon="arrow-r" data-iconpos="right" onclick='location.href="#message_s"'>
        <!--
        <input type="button" value="２．確定スケジュール" data-icon="arrow-r" data-iconpos="right" onclick='location.href="<?=ROOTDIR ?>/users/schedule2?date=<?=$date1 ?>"'>
        -->
        <!--
        <input type="button" value="３．スタッフシフト表" data-icon="arrow-r" data-iconpos="right" onclick='location.href="<?=ROOTDIR ?>/users/schedule3?date=<?=$date1 ?>"'>
        -->
        <div style='float:left;'>       
            <input type="button" value="ホーム" data-theme="b" data-icon="home" onclick='location.href="<?=ROOTDIR ?>/users/index#home"'>
        </div> 
    </div>
    <div class="pagetop">
            <a href="#page3">
                <?php echo $this->Html->image('pagetop.png'); ?>
            </a>
    </div>
    <div id="footer">
        <?=FOOTER ?>
    </div>
</div>
<!-- 制作中 -->
<section id="message_s" data-role="dialog" data-close-btn-text="閉じる">
  <header data-role="header">
    <h3>　　メッセージ</h3>
  </header>
  <article data-role="content">
    <p>現在、調整中です。</p>
    <a href="#" data-role="button" data-rel="back">閉じる</a>
  </article>
</section>
<!-- 制作中 END -->

<!--ダイアログメニュー-->
<?php require('dialog_menu.ctp'); ?>
<!--ダイアログメニュー end-->