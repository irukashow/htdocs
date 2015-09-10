<?php
    echo $this->Html->css('staffmaster');
?>
<?php require('calender.ctp'); ?>
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
    <b><font Style="font-size:95%;color: yellow;">[スタッフシフト希望]</font></b>
    &nbsp;
    <a href="<?=ROOTDIR ?>/ShiftManagement/schedule" target="" onclick=''><font Style="font-size:95%;">シフト作成</font></a>        <!-- alert("制作中");return false; -->
    &nbsp;
    <a href="<?=ROOTDIR ?>/ShiftManagement/uri9" target=""><font Style="font-size:95%;">勤務実績</font></a>
    &nbsp;
    <a href="<?=ROOTDIR ?>/ShiftManagement/test2" target="" onclick=''><font Style="font-size:95%;">稼働表ベース表テスト</font></a>
    &nbsp;
    <a href="<?=ROOTDIR ?>/ShiftManagement/test" target="" onclick=''><font Style="font-size:95%;">稼働表技術テスト</font></a>
</div>
<!-- 見出し１ END -->

<?php echo $this->Form->create('StaffSchedule', array('name' => 'form')); ?>
<table border='1' cellspacing="0" cellpadding="3" style="width:100%;margin-top: 10px;border-spacing: 0px;background-color: white;">
        <tr align="center">
                <td><a href="<?=ROOTDIR ?>/ShiftManagement/index?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' -1 month')); ?>">&lt; 前の月</a></td>
                <td style='background-color: #006699;color: white;'><font style='font-size: 110%;'>【<?php echo $y ?>年<?php echo $m ?>月】</font></td>
                <td><a href="<?=ROOTDIR ?>/ShiftManagement/index?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' +1 month')); ?>">次の月 &gt;</a></td>
        </tr>
</table>

<div style="width:100%;overflow-x:scroll;">
<table border='1' cellspacing="0" cellpadding="2" style="width:2000px;margin-top: 5px;margin-bottom: 10px;border-spacing: 0px;background-color: white;">
    <tr style="background-color: #cccccc;">
        <td align="center" rowspan="2" style="width:20px;">スタッフ</td>
<?php
    // 1日の曜日を取得
    $wd1 = date("w", mktime(0, 0, 0, $m, 1, $y));
    $week = array("日", "月", "火", "水", "木", "金", "土");
    $d = 1;
    while (checkdate($m, $d, $y)) {
        $wd2 = date("w", mktime(0, 0, 0, $m, $d, $y));
        echo '<td align="center" style="width:10px;">'.$week[$wd2].'</td>';
        $d++;
    }
?>
    </tr>
    <tr>
<?php
    $d = 1;
    while (checkdate($m, $d, $y)) {
        // 日付出力（土日祝には色付け）
        if(date("w", mktime(0, 0, 0, $m, $d, $y)) == 0) {
                $style = 'color:red;';
        } elseif(date("w", mktime(0, 0, 0, $m, $d, $y)) == 6) {
                $style = 'color:blue;';
        } elseif(!empty($national_holiday[date("Ymd", mktime(0, 0, 0, $m, $d, $y))])) {
                $style = 'color:red;';
        } else {
                $style = '';
        }
        // 本日
        if ($m == date("n") && $d == date("j") && $y == date("Y")) {
            $style = $style.'font-weight: bold;background-color: #ffffcc;color:green;';
        }
        // 出力
        echo "<td align=\"center\" style='".$style."'>".$d."</td>";
        $d++;
    }
?>
    </tr>
    <?php foreach($datas1 as $key => $data1) { ?>
    <tr>
        <td align="center"><?=$data1['StaffMaster']['name_sei'].' '.$data1['StaffMaster']['name_mei']; ?> (<?=$data1['StaffSchedule']['staff_id']; ?>)</td>
<?php
    $d = 1;
    while (checkdate($m, $d, $y)) {
        // 日付出力（土日祝には色付け）
        if(date("w", mktime(0, 0, 0, $m, $d, $y)) == 0) {
                $style = 'color:red;';
        } elseif(date("w", mktime(0, 0, 0, $m, $d, $y)) == 6) {
                $style = 'color:blue;';
        } elseif(!empty($national_holiday[date("Ymd", mktime(0, 0, 0, $m, $d, $y))])) {
                $style = 'color:red;';
        } else {
                $style = '';
        }
        // 本日
        if ($m == date("n") && $d == date("j") && $y == date("Y")) {
            $style = $style.'font-weight: bold;background-color: #ffffcc;color:green;';
        }
        //$style = $style.'font-weight: bold;';
        // 予定ありかどうか
        $nodata = true;
        foreach ($datas2[$key] as $data2) {
            if ($y.'-'.sprintf("%02d", $m).'-'.sprintf("%02d", $d) == $data2['StaffSchedule']['work_date']) {
                // 出力
                if ($data2['StaffSchedule']['work_flag'] == 1) {
                    echo "<td align=\"center\" style='".$style."'>○</td>";
                } elseif($data2['StaffSchedule']['work_flag'] == 2) {
                    echo "<td align=\"center\" style='".$style."'>△<br><font style='font-size:70%;'>".$data2['StaffSchedule']['conditions']."</font></td>";
                }
                $nodata = false;
            }
        }
       if ($nodata) {
            echo "<td align=\"center\" style='".$style."'></td>";
        }

        $d++;
    }
?>
    </tr>        
    <?php } ?>
<?php if (count($datas1) == 0) { ?>
<tr>
    <td colspan="32" align="center" style="background-color: #fff9ff;">表示するデータはありません。</td>
</tr>
<?php } ?>
</table>
<!-- カレンダー END-->
</div>

<!--- スタッフマスタ本体 END --->
<?php echo $this->Form->end(); ?>

<!-- 機能紹介 -->
<script type="text/javascript">
/**
$(function() {
    //alert('制作中です');
  // 2ダイアログ機能を適用
  $('#dialog').dialog({
    modal: true,
    buttons: {
　　　　"OK": function(){
　　　　$(this).dialog('close');
　　　　}
　　　}
  });
});
**/
</script>
<div id="dialog" title="勤務管理の紹介" style="display: none">
<p style="font-size: 90%;">
    この機能を使って、各案件のシフト決めや勤怠管理、給与管理が可能になります。<br>
    <br>
    ※ただいま<font color="red">制作中</font>です。</p>
</div>