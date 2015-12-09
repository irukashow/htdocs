<?php
    echo $this->Html->css('staffmaster');
?>
<?php require('calendar.ctp'); ?>
<style>
#loading{
    position:absolute;
    left:50%;
    top:60%;
    margin-left:-30px;
}
</style>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
<script type="text/javascript">
  <!--
//コンテンツの非表示
$(function(){
    $('#staff_master').css('display', 'none');
});
//ページの読み込み完了後に実行
window.onload = function(){
    $(function() {
        //ページの読み込みが完了したのでアニメーションはフェードアウトさせる
        $("#loading").fadeOut();
        //ページの表示準備が整ったのでコンテンツをフェードインさせる
        $("#staff_master").fadeIn();
    });
}
  //-->
</script>
<!-- for Datepicker -->
<link type="text/css" rel="stylesheet"
  href="http://code.jquery.com/ui/1.10.3/themes/cupertino/jquery-ui.min.css" />
<script type="text/javascript"
  src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script type="text/javascript"
  src="http://code.jquery.com/ui/1.10.3/jquery-ui.min.js"></script>
<!--1国際化対応のライブラリをインポート-->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/i18n/jquery-ui-i18n.min.js"></script>
<script type="text/javascript">
$(function() {
  // 2日本語を有効化
  $.datepicker.setDefaults($.datepicker.regional['ja']);
  // 3日付選択ボックスを生成
  $('.date').datepicker({ dateFormat: 'yy-mm-dd' });
});
</script>

<div id="loading"><img src="<?=ROOTDIR ?>/img/loading.gif"></div>
<!-- 見出し１ -->
<div id='headline' style="padding:10px 10px 10px 10px;">
    ★ 勤務管理
    &nbsp;&nbsp;
    <a href="<?=ROOTDIR ?>/ShiftManagement/index" target="" onclick=''><font Style="font-size:95%;">スタッフシフト希望</font></a>
    &nbsp;
    <b><font Style="font-size:95%;color: yellow;">[稼働表]</font></b>        <!-- alert("制作中");return false; -->
    &nbsp;
    <a href="<?=ROOTDIR ?>/ShiftManagement/uri9" target=""><font Style="font-size:95%;">勤務実績</font></a>
</div>
<!-- 見出し１ END -->

<?php echo $this->Form->create('StaffSchedule', array('name' => 'form')); ?>
<table border='1' cellspacing="0" cellpadding="3" style="width:100%;margin-top: 10px;border-spacing: 0px;background-color: white;">
        <tr align="center">
                <td style=''><a href="<?=ROOTDIR ?>/ShiftManagement/schedule?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' -1 month')); ?>">&lt; 前の月</a></td>
                <td style='background-color: #006699;color: white;'><font style='font-size: 110%;'>【<?php echo $y ?>年<?php echo $m ?>月】</font></td>
                <td style=''><a href="<?=ROOTDIR ?>/ShiftManagement/schedule?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' +1 month')); ?>">次の月 &gt;</a></td>
        </tr>
</table>

<div style="width:100%;overflow-x:scroll;">        
        <table border='1' cellspacing="0" cellpadding="2" style="width:2000px;margin-top: 5px;margin-bottom: 10px;border-spacing: 0px;background-color: white;">
            <tr>
                <td align='center' style='width:100px;'>案件</td>
                <td align='center' colspan="3" style='background-color: #006699;color:white;'>案件１</td>
                <td align='center' colspan="2" style='background-color: #006699;color:white;'>案件２</td>
                <td align='center' colspan="3" style='background-color: #006699;color:white;'>案件３</td>
                <td align='center' colspan="3" style='background-color: #006699;color:white;'>案件４</td>
                <td align='center' colspan="3" style='background-color: #006699;color:white;'>案件５</td>
                <td align='center' colspan="3" style='background-color: #006699;color:white;'>案件６</td>
                <td align='center' colspan="3" style='background-color: #006699;color:white;'>案件７</td>
                <td align='center' colspan="3" style='background-color: #006699;color:white;'>案件８</td>
                <td align='center' colspan="3" style='background-color: #006699;color:white;'>案件９</td>
                <td align='center' colspan="3" style='background-color: #006699;color:white;'>案件１０</td>
            </tr>
            <tr>
                <td align='center' style='width:100px;background-color: #ccffff;'>事業主</td>
                <td align='center' colspan="3" style='background-color: #ffff99;'>１</td>
                <td align='center' colspan="2" style='background-color: #ffff99;'>２</td>
                <td align='center' colspan="3" style='background-color: #ffff99;'>３</td>
                <td align='center' colspan="3" style='background-color: #ffff99;'>４</td>
                <td align='center' colspan="3" style='background-color: #ffff99;'>５</td>
            </tr>
            <tr>
                <td align='center' style='width:100px;background-color: #ccffff;'>販売会社</td>
                <td align='center' colspan="3" style=''>１</td>
                <td align='center' colspan="2" style=''>２</td>
                <td align='center' colspan="3" style=''>３</td>
                <td align='center' colspan="3" style=''>４</td>
                <td align='center' colspan="3" style=''>５</td>
            </tr>
            <tr>
                <td align='center' style='width:100px;background-color: #ccffff;'>指揮命令者<br>／担当者</td>
                <td align='center' colspan="3" style=''>１</td>
                <td align='center' colspan="2" style=''>２</td>
                <td align='center' colspan="3" style=''>３</td>
                <td align='center' colspan="3" style=''>４</td>
                <td align='center' colspan="3" style=''>５</td>
            </tr>
            <tr>
                <td align='center' style='width:100px;background-color: #ccffff;'>現場住所</td>
                <td align='center' colspan="3" style=''>１</td>
                <td align='center' colspan="2" style=''>２</td>
                <td align='center' colspan="3" style=''>３</td>
                <td align='center' colspan="3" style=''>４</td>
                <td align='center' colspan="3" style=''>５</td>
            </tr>
            <tr>
                <td align='center' style='width:100px;background-color: #ccffff;'>現場連絡先</td>
                <td align='center' colspan="3" style=''>１</td>
                <td align='center' colspan="2" style=''>２</td>
                <td align='center' colspan="3" style=''>３</td>
                <td align='center' colspan="3" style=''>４</td>
                <td align='center' colspan="3" style=''>５</td>
            </tr>
            <tr>
                <td align='center' style='width:100px;background-color: #ccffff;'>待ち合わせ</td>
                <td align='center' colspan="3" style=''>１</td>
                <td align='center' colspan="2" style=''>２</td>
                <td align='center' colspan="3" style=''>３</td>
                <td align='center' colspan="3" style=''>４</td>
                <td align='center' colspan="3" style=''>５</td>
            </tr>
            <tr>
                <td align='center' style='width:100px;background-color: #ccffff;'>請求先担当者</td>
                <td align='center' colspan="3" style=''>１</td>
                <td align='center' colspan="2" style=''>２</td>
                <td align='center' colspan="3" style=''>３</td>
                <td align='center' colspan="3" style=''>４</td>
                <td align='center' colspan="3" style=''>５</td>
            </tr>
            <tr>
                <td align='center' style='width:100px;background-color: #ccffff;'>請求書締日</td>
                <td align='center' colspan="3" style=''>１</td>
                <td align='center' colspan="2" style=''>２</td>
                <td align='center' colspan="3" style=''>３</td>
                <td align='center' colspan="3" style=''>４</td>
                <td align='center' colspan="3" style=''>５</td>
            </tr>
            <tr>
                <td align='center' style='width:100px;background-color: #ccffff;'>クリーニング</td>
                <td align='center' colspan="3" style=''>１</td>
                <td align='center' colspan="2" style=''>２</td>
                <td align='center' colspan="3" style=''>３</td>
                <td align='center' colspan="3" style=''>４</td>
                <td align='center' colspan="3" style=''>５</td>
            </tr>
            <tr>
                <td align='center' style='background-color: #ccffff;width:100px;'>職種</td>
                <!-- 案件１ -->
                <td align='center' style='background-color: #ffff99;width:120px;font-size:80%;'>受付(土日祝メイン)</td>
                <td align='center' style='background-color: #ffff99;width:120px;font-size:80%;'>受付(土日祝サブ)</td>
                <td align='center' style='background-color: #ffff99;width:120px;font-size:80%;'>受付(土日祝サブ)</td>
                <!-- 案件２ -->
                <td align='center' style='background-color: #ffff99;width:120px;font-size:80%;'>受付</td>
                <td align='center' style='background-color: #ffff99;width:120px;font-size:80%;'>保育</td>
            </tr>
            <tr>
                <!-- 案件１ -->
                <td align='center' style='background-color: #ccffff;width:100px;'>勤務時間</td>
                <td align='center' style='background-color: #ffff99;width:120px;font-size:80%;'>9:00～18:00</td>
                <td align='center' style='background-color: #ffff99;width:120px;font-size:80%;'>9:00～18:00</td>
                <td align='center' style='background-color: #ffff99;width:120px;font-size:80%;'>9:00～18:00</td>
            </tr>
        <?php
            // 曜日の配列作成
            $weekday = array( "日", "月", "火", "水", "木", "金", "土" );
            // 1日の曜日を数値で取得
            $fir_weekday = date( "w", mktime( 0, 0, 0, $m, 1, $y ) );
            // 1日の曜日設定
            $i = $fir_weekday; // カウント値リセット
        ?>
            <tr>
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
                        echo '<td align="center">'.$data[$d]['rest_time'].'</td>';
                        if ($data[$d]['status'] == 2) {
                            echo '<td align="center"></td>';
                        } else {
                            echo '<td align="center"></td>';
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
                    echo '<td align="center"></td>';
                    echo '</tr>';
                }
                $i++; //カウント値（曜日カウンター）+1
            }
        ?>
        </table>
<!-- カレンダー END-->
</div>

<!--- スタッフマスタ本体 END --->
<?php echo $this->Form->end(); ?>
