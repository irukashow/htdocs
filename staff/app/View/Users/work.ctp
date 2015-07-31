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
<div id="page3" data-role="page">
    <div data-role="header" data-theme="c">
            <h1>勤務関連</h1>
            <a href="#dialog_menu" class="ui-btn-right" data-role="button" data-transition="slidedown" data-icon="bars" data-iconpos="notext"></a>
    </div>			
    <div data-role="content">
        <b>勤務関連</b>
        <p>以下の変更ができます。</p>
        <input type="button" value="１．タイムカード" data-icon="arrow-r" data-iconpos="right" onclick='location.href="#timecard"'>
        <input type="button" value="２．給与確認" data-icon="arrow-r" data-iconpos="right" onclick='location.href="#salary"'>
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

<div id="timecard" data-role="page">
    <div data-role="header" data-theme="c">
            <h1>タイムカード</h1>
            <!-- class="ui-btn-right" -->
            <a href="#" data-role="button" data-icon="refresh" data-iconpos="notext" data-inline="true" onclick="location.reload();"></a>
            <a href="#dialog_menu" data-role="button" data-transition="slidedown" data-icon="bars" data-iconpos="notext" data-inline="true"></a>
    </div>			
    <div data-role="content" style="font-size: 70%;">
        <?php echo $this->Form->create('TimeCard', array('name' => 'form')); ?>
        <?php echo $this->Form->input('staff_id', array('type'=>'hidden', 'value' => $id)); ?> 
        <table border="1" cellspacing="0" cellpadding="5" width="100%">
            <tr>
                <td style='background-color: #e8ffff;width:10%;'>日付</td>
                <td style='background-color: #e8ffff;width:10%;'>状況</td>
                <td style='background-color: #e8ffff;width:10%;'>始業</td>
                <td style='background-color: #e8ffff;width:10%;'>終業</td>
                <td style='background-color: #e8ffff;width:10%;'>休憩時間</td>
                <td style='background-color: #e8ffff;width:10%;'>入力</td>
            </tr>
        <?php
            $now_year = date("Y"); // 現在の年を取得
            $now_month = date("n"); // 在の月を取得
            $now_day = date("j"); // 現在の日を取得
            // 曜日の配列作成
            $weekday = array( "日", "月", "火", "水", "木", "金", "土" );
            // 1日の曜日を数値で取得
            $fir_weekday = date( "w", mktime( 0, 0, 0, $now_month, 1, $now_year ) );
            // 1日の曜日設定
            $i = $fir_weekday; // カウント値リセット
            // 見出し部分<caption>タグ出力
            echo "<b>【".$now_year."年".$now_month."月度】</b>\n";
            // 行の変更
            echo "<tr>";
            // 今月の日付が存在している間ループする
            for( $day=1; checkdate( $now_month, $day, $now_year ); $day++ ){
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
                if( $day == $now_day ){
                    $style2 = "background: #ffffcc;";
                } else {
                    $style2 = '';
                }
            //-------------スタイルシート設定終わり-----------------------------
                $selected_date = $now_year.'-'.sprintf('%02d', $now_month).'-'.sprintf('%02d', $day);
                if ($data['work_date'] == $selected_date) {
                    // 日付セル作成とスタイルシートの挿入
                    echo '<tr style="'.$style2.';">';
                    echo '<td align="center" style="color:'.$style.';">'.$day.'('.$weekday[$i].')</td>';
                    echo '<td align="center">'.setStatus($data['status']).'</td>';
                    echo '<td align="center">'.$data['start_time_h'].':'.$data['start_time_m'].'</td>';
                    echo '<td align="center">'.$data['end_time_h'].':'.$data['end_time_m'].'</td>';
                    echo '<td align="center">'.$data['rest_time'].'</td>';
                    echo '<td align="center"><input type="submit" name="input['.$day.']" data-theme="e" data-icon="edit" data-iconpos="notext"></td>';
                    echo '</tr>';
                } else {
                    // 日付セル作成とスタイルシートの挿入
                    echo '<tr style="'.$style2.';">';
                    echo '<td align="center" style="color:'.$style.';">'.$day.'('.$weekday[$i].')</td>';
                    echo '<td align="center"></td>';
                    echo '<td align="center"></td>';
                    echo '<td align="center"></td>';
                    echo '<td align="center"></td>';
                    echo '<td align="center"><input type="submit" name="input['.$day.']" data-theme="e" data-icon="edit" data-iconpos="notext"></td>';
                    echo '</tr>';
                }
                $i++; //カウント値（曜日カウンター）+1
            }
        ?>
        </table>
        <div style='float:left;'>          
            <input type="button" value="戻　る" data-inline="true" onclick='location.href="#page3"'>
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

