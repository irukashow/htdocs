<?php require('calender.ctp'); ?>
<?php
    function setStatus($val) {
        if ($val == '1') {
            $ret = '申請';
        } elseif ($val == '2') {
            $ret = '承認';
        } else {
            $ret = '';
        }
        return $ret;
    }

?>
<div id="timecard" data-role="page">
    <div data-role="header" data-theme="c">
            <h1>タイムカード</h1>
            <!-- class="ui-btn-right" -->
            <!--
            <a href="#" data-role="button" data-icon="refresh" data-iconpos="notext" class="ui-btn-right" data-inline="true" onclick="location.reload();"></a>
            -->
            <a href="#dialog_menu" data-role="button" data-transition="slidedown" data-icon="bars" data-iconpos="notext" class="ui-btn-right" data-inline="true"></a>
    </div>			
    <div data-role="content" style="font-size: 70%;">
        <?php echo $this->Form->create('TimeCard', array('name' => 'form')); ?>
        <?php echo $this->Form->input('staff_id', array('type'=>'hidden', 'value' => $id)); ?> 
        <table border='1' cellspacing="0" cellpadding="3" style="width:100%;margin-top: 10px;border-spacing: 0px;background-color: white;font-size:120%;">
                <tr align="center">
                        <td><a href="<?=ROOTDIR ?>/users/work_timecard?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' -1 month')); ?>">&lt; 前の月</a></td>
                        <td>
                            <b><a href="#" onclick="location.reload();">【<?php echo $y ?>年<?php echo $m ?>月】</a></b>
                        </td>
                        <td><a href="<?=ROOTDIR ?>/users/work_timecard?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' +1 month')); ?>">次の月 &gt;</a></td>
                </tr>
        </table>
        
        <table border="1" cellspacing="0" cellpadding="5" width="100%" style="width:100%;margin-top: 5px;">
            <tr>
                <td style='background-color: #e8ffff;width:10%;'>日付</td>
                <td style='background-color: #e8ffff;width:10%;'>状況</td>
                <td style='background-color: #e8ffff;width:10%;'>始業</td>
                <td style='background-color: #e8ffff;width:10%;'>終業</td>
                <td style='background-color: #e8ffff;width:10%;'>休憩</td>
                <td style='background-color: #e8ffff;width:10%;'>入力</td>
            </tr>
        <?php
            //$now_year = date("Y"); // 現在の年を取得
            //$now_month = date("n"); // 在の月を取得
            //$now_day = date("j"); // 現在の日を取得
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
                    if ($data[$d]['work_date'] == $selected_date) {
                        // 日付セル作成とスタイルシートの挿入
                        echo '<tr style="'.$style2.';">';
                        echo '<td align="center" style="color:'.$style.';">'.$d.'('.$weekday[$i].')</td>';
                        echo '<td align="center">'.setStatus($data[$d]['status']).'</td>';
                        echo '<td align="center">'.$data[$d]['start_time_h'].':'.$data[$d]['start_time_m'].'</td>';
                        echo '<td align="center">'.$data[$d]['end_time_h'].':'.$data[$d]['end_time_m'].'</td>';
                        echo '<td align="center">'.$data[$d]['rest_time_from_h'].':'.$data[$d]['rest_time_from_m'].'～'.$data[$d]['rest_time_to_h'].':'.$data[$d]['rest_time_to_m'].'</td>';
                        if ($data[$d]['status'] == 2) {
                            echo '<td align="center"></td>';
                        } else {
                            echo '<td align="center"><input type="submit" name="input['.$selected_date.']" data-theme="e" data-icon="edit" data-iconpos="notext"></td>';
                        }
                        echo '</tr>';
                    } else {
                        
                    }
                } else {
                    // 日付セル作成とスタイルシートの挿入
                    echo '<tr style="'.$style2.';">';
                    echo '<td align="center" style="color:'.$style.';">'.$d.'('.$weekday[$i].')</td>';
                    echo '<td align="center"></td>';
                    echo '<td align="center"></td>';
                    echo '<td align="center"></td>';
                    echo '<td align="center"></td>';
                    echo '<td align="center"><input type="submit" name="input['.$selected_date.']" data-theme="e" data-icon="edit" data-iconpos="notext"></td>';
                    echo '</tr>';
                }
                $i++; //カウント値（曜日カウンター）+1
            }
        ?>
        </table>
        <div style='float:left;'>          
            <input type="button" value="戻　る" data-inline="true" onclick='location.href="<?=ROOTDIR ?>/users/work"'>
        </div>  
        <?php echo $this->Form->end(); ?>
    </div>
    <div class="pagetop">
            <a href="#timecard">
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
