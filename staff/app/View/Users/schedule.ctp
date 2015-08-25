<?php require('calender.ctp'); ?>
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
<script>
$(document).delegate("#page2", "pageinit", function() {
    $('input[type="checkbox"]').bind('change', function() {
        selectAll($('#selectAll'));
    });
});

function selectAll(element) {
    for(i=0; i<31; i++) {
        if (element.checked) {
            $('#check'+(i+1)).prop('checked', true).trigger('change');
            //document.getElementById('check'+(i+1)).checked=true;
        } else {
            $('#check'+(i+1)).prop('checked', true);
            //document.getElementById('check'+(i+1)).checked=false;
        }
    }
    //location.reload();
}
function selectHoliday(element) {
    for(i=0; i<31; i++) {
        if (document.getElementById("HolidayD"+(i+1)).value == 0) {
            continue;
        }
        if (element.checked) {
            document.getElementById('check'+(i+1)).checked=true;
        } else {
            document.getElementById('check'+(i+1)).checked=false;
        }
    }
    location.reload();
}
</script>
<div id="page2" data-role="page">
        <div data-role="header" data-theme="c">
                <h1>スケジュール</h1>
                <!--
                <a href="#" data-role="button" data-icon="refresh" data-iconpos="notext" data-inline="true" onclick="location.reload();"></a>
                -->
                <a href="#dialog_menu" class="ui-btn-right" data-role="button" data-transition="slidedown" data-icon="bars" data-iconpos="notext"></a>
        </div>
        <div data-role="content" style="font-size: 70%;">
            <p>シフト希望は来月以降で願います。</p>
            <!--- シフト希望表 --->
            <!-- カレンダー -->
        <?php echo $this->Form->create('StaffSchedule', array('name' => 'form', 'url' => array('controller' => 'users', 'action' => 'schedule_input'))); ?>
        <?php echo $this->Form->input('id', array('type'=>'hidden')); ?>
        <?php echo $this->Form->input('class', array('type'=>'hidden', 'value' => $class)); ?>
        <?php echo $this->Form->input('staff_id', array('type'=>'hidden', 'value' => $id)); ?>
            
            <table border='1' cellspacing="0" cellpadding="3" style="width:100%;margin-top: 10px;border-spacing: 0px;background-color: white;">
                    <tr align="center">
                            <td><a href="<?=ROOTDIR ?>/users/schedule?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' -1 month')); ?>">&lt; 前の月</a></td>
                            <td><?php echo $y ?>年<?php echo $m ?>月</td>
                            <td><a href="<?=ROOTDIR ?>/users/schedule?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' +1 month')); ?>">次の月 &gt;</a></td>
                    </tr>
            </table>

            <!-- 選択 -->
            <label>
                <input type="checkbox" name="SelectAll" id="SelectAll" onclick="selectAll(this);" data-mini="true">全選択・全解除
            </label>
            <label>
                <input type="checkbox" name="SelectHoliday" id="SelectHoliday" onclick="selectHoliday(this);" data-mini="true">土日選択・解除
            </label>
            <!-- 選択 END -->
            <table border='1' cellspacing="0" cellpadding="3" style="width:100%;margin-top: 5px;margin-bottom: 10px;border-spacing: 0px;background-color: white;">
                <tr align="center" style="background-color: #cccccc;">
                    <th style="width:10%">日付</th>
                    <th style="width:10%">選択</th>
                    <th style="width:20%">勤務可能</th>
                    <th style="width:30%">条件付き</th>
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
                if( $i == 0 ){ //日曜日の文字色
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
                    if ($i==0 || $i==6) {
                        echo '<input type="hidden" id="HolidayD'.$d.'" value="1">';
                    } else {
                        echo '<input type="hidden" id="HolidayD'.$d.'" value="0">';
                    }
                    echo '</td>';
                    echo '<td align="center" width="10%">';
                    echo '<label>';
                    echo '<input type="checkbox" name="check['.$selected_date.']" id="check'.$d.'">';
                    echo '</label>';
                    echo '</td>';
                    $list_work = array('0'=>'✕', '1'=>'◎','2'=>'△'); 
                    echo '<td align="center">';
                    echo $this->Form->input(false, array('type'=>'select', 'name'=>'work_flag['.$selected_date.']', 'value'=>$data[$d]['work_flag'], 'legend'=>false,
                        'label'=>false, 'div'=>false,'style'=>'font-weight:bold;','data-mini'=>'true', 'options'=>$list_work));
                    echo '</td>';
                    echo '<td align="center">';
                    echo $this->Form->input('conditions',array('label'=>false, 'div'=>'float:left;','style'=>'font-size:80%;','data-inline'=>'true', 'value'=>$data[$d]['conditions']));
                    echo '</td>';
                    echo '</tr>';
                } else {
                    // 日付セル作成とスタイルシートの挿入
                    echo '<tr style="'.$style2.';">';
                    echo '<td align="center" style="color:'.$style.';">'.$d.'('.$weekday[$i].')</td>';
                    echo '<td align="center">';
                    echo '<label>';
                    echo '<input type="checkbox" name="check['.$selected_date.']" id="check'.$d.'">';
                    echo '</label>';
                    echo '</td>';
                    $list_work = array('0'=>'✕', '1'=>'◎','2'=>'△'); 
                    echo '<td align="center">';
                    echo $this->Form->input('work_flag',array('type'=>'select','legend'=>false,
                        'label'=>false, 'div'=>false,'style'=>'','data-mini'=>'true', 'options'=>$list_work));
                    echo '</td>';
                    echo '<td align="center">';
                    echo $this->Form->input('conditions',array('label'=>false, 'div'=>'float:left;','style'=>'font-size:80%;','data-inline'=>'true'));
                    echo '</td>';
                    echo '</tr>';
                }
                $i++; //カウント値（曜日カウンター）+1
            }
        ?>
                </tr>
            </table>
            <!-- カレンダー END-->
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

<!--ダイアログメニュー-->
<?php require('dialog_menu.ctp'); ?>
<!--ダイアログメニュー end-->