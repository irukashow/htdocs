<?php
    echo $this->Html->script( 'tools');
    //echo $this->Html->script('dropzone');
    echo $this->Html->script('jquery-1.9.1');
    //echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js');
    echo $this->Html->script('jquery.timepicker');
    echo $this->Html->script('fixed_midashi');
    echo $this->Html->css('jquery.timepicker');
?>
<?php require('holiday.ctp'); ?>
<?php
    // 初期値
    $y = date('Y', strtotime('+1 month'));
    $m = date('n', strtotime('+1 month'));
		
    // 日付の指定がある場合
    if(!empty($_GET['date'])){
        $arr_date = explode('-', $_GET['date']);

        if(count($arr_date) == 2 and is_numeric($arr_date[0]) and is_numeric($arr_date[1])) {
                $y = (int)$arr_date[0];
                $m = (int)$arr_date[1];
        }
    }
    // 祝日取得
    $national_holiday = japan_holiday($y);
?>
<?php
//JQueryのコントロールを使ったりして2015-4-23等の形式の文字列が渡すように限定するかんじ
function convGtJDate($src) {
    list($year, $month, $day) = explode("-", $src);
    if (!@checkdate($month, $day, $year) || $year < 1869 || strlen($year) !== 4
            || strlen($month) !== 2 || strlen($day) !== 2) return false;
    $date = str_replace("-", "", $src);
    $gengo = "";
    $wayear = 0;
    if ($date >= 19890108) {
        $gengo = "平成";
        $wayear = $year - 1988;
    } elseif ($date >= 19261225) {
        $gengo = "昭和";
        $wayear = $year - 1925;
    } elseif ($date >= 19120730) {
        $gengo = "大正";
        $wayear = $year - 1911;
    } else {
        $gengo = "明治";
        $wayear = $year - 1868;
    }
    switch ($wayear) {
        case 1:
            $wadate = $gengo."元年".ltrim($month, '0')."月".ltrim($day, '0')."日";
            break;
        default:
            $wadate = $gengo.$wayear."年".ltrim($month, '0')."月".ltrim($day, '0')."日";
    }
    return $wadate;
}
// 指定の職種数が保存データ数を超えるときの対策
function setData($datas, $col, $shitei, $reserved) {
    if (empty($datas) || empty($datas[$shitei])) {
        return '';
    }
    if (intval($shitei)+1 > intval($reserved)) {
        $ret = '';
    } else {
        $ret = $datas[$shitei]['OrderInfoDetail'][$col];
    }
    return $ret;
} 
// 指定データがないときの対策
function setData2($datas, $table, $col) {
    if (empty($datas)) {
        $ret = '';
    } else {
        $ret = $datas[0][$table][$col];
    }
    return $ret;
}
?>
<?php
    /**  **/
    function NZ($value) {
        for ($i=0; $i<count($value) ;$i++) {
            $ret[$i] = $value[$i];
        }
        for ($i=count($value); $i<5 ;$i++) {
            $ret[$i] = '';
        }
        return $ret;
    }
?>
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
  $('.date').datepicker("option", "showOn", 'button');
});
</script>
<script>
onload = function() {
    //FixedMidashi.create();
}
</script>
<script>
// カレンダー月指定
function setCalendar(case_id, koushin_flag, order_id, year, month) {
    var options1 = year.options;
    var value1 = options1[year.options.selectedIndex].value;
    var options2 = month.options;
    var value2 = options2[month.options.selectedIndex].value;
    location.href="<?=ROOTDIR ?>/CaseManagement/reg2/" + case_id + "/" + koushin_flag + "/" + order_id + "?date=" +value1 + "-" + value2;
}
// 全選択・全解除
function setAllSelect(col, element) {
    for(var i=1; i<=31 ;i++) {
        if (element.checked) {
            document.getElementById("OrderCalendar"+col+"D"+i).checked=true;
            changeColor(col, i, 1);
        } else {
            document.getElementById("OrderCalendar"+col+"D"+i).checked=false;
            changeColor(col, i, 0);
        }
    }
}
// 土日選択・解除
function setAllSelect2(col, element) {
    for(var i=1; i<=31 ;i++) {
        if (document.getElementById("HolidayD"+i).value == 0) {
            continue;
        }
        if (element.checked) {
            document.getElementById("OrderCalendar"+col+"D"+i).checked=true;
            changeColor(col, i, 1);
        } else {
            document.getElementById("OrderCalendar"+col+"D"+i).checked=false;
            changeColor(col, i, 0);
        }
    }
}
// 職種の詳細を隠す
function setHidden() {
    target = document.getElementById("ActiveDisplay");
    if (document.getElementById("OrderDetail12").style.display == 'none') {
        for(i=1; i<=12; i++) {
            document.getElementById("OrderDetail"+i).style.display = 'table-row';
        }
        //target.innerHTML = '<span>詳細を隠す</span>';
    } else {
        for(i=1; i<=12; i++) {
            document.getElementById("OrderDetail"+i).style.display = 'none';
        }
        //target.innerHTML = '<span>詳細を表示する</span>';
    }
}
// チェックを入れたセルを黄色にする
function changeColor(col, day, flag) {
    if (flag == 0) {
        document.getElementById("Cell"+col+"D"+day).style.background = 'white';
    } else {
        document.getElementById("Cell"+col+"D"+day).style.background = '#ffffcc';
    }
}
/****************************************************************
* 機　能： 入力された値が時間でHH:MM形式になっているか調べる
* 引　数： str　入力された値
* 戻り値： 正：true　不正：false
****************************************************************/
function ckTime(str) {
    // 正規表現による書式チェック
    if(!str.match(/^\d{2}\:\d{2}$/)){
        return false;
    }
    var vHour = str.substr(0, 2) - 0;
    var vMinutes = str.substr(3, 2) - 0;
    if(vHour >= 0 && vHour <= 24 && vMinutes >= 0 && vMinutes <= 59){
        return true;
    }else{
    }
}
// エラーメッセージの表示
function doAlert(str, element) {
    if (!ckTime(str)) {
        alert("時刻の入力形式が不正です。");
        element.focus();
    }
}
// 和暦に変換
function setDate2(element, destination) {
    document.getElementById(destination).value = SeirekiToWareki(element.value);
}
function SeirekiToWareki(str){
    var gengou = "";
    var year = "";
    a = str.split("-");
    a[0] = parseInt(a[0]);
    a[1] = parseInt(a[1]);
    a[2] = parseInt(a[2]);
    if(a[0] > 1989 || (a[0] == 1989 && a[1] == 1 && a[2] > 6)){
    a[0] = a[0] - 1988;
    gengou = "平成";
    }else if(a[0] > 1926 || (a[0] == 1926 && a[1] == 12 && a[2] > 24)){
    a[0] = a[0] - 1925;
    gengou = "昭和";
    }else if(a[0] > 1912 || (a[0] == 1912 && a[1] == 7 && a[2] > 30)){
    a[0] = a[0] - 1911;
    gengou = "大正";
    }else if(a[0] > 1868 || (a[0] == 1868 && a[1] == 1 && a[2] > 24)){
    a[0] = a[0] - 1867;
    gengou = "明治";
    }
    if(a[0] == 1){
    a[0] = "元";
    }
    return gengou + a[0] + "年" + a[1] + "月" + a[2] + "日";
}
</script>
<style type="text/css" media="screen">
  div.scroll_div { 
      overflow: auto;
      height: auto;
      width: auto;
      margin-top: 5px;
  }
</style>
<style>
    input[type=text],input[type=text]:hover {
        font-size: 90%;
    }
</style>

<div style="width:90%;margin-top: 20px;margin-left: auto; margin-right: auto;">
    <fieldset style="border:none;margin-bottom: 5px;">
        <legend style="font-size: 150%;color: red;"><?php echo __('案件登録<font color=gray> （契約書情報）</font>'); ?></legend>
        <!-- ページ選択 -->
        <font style="font-size: 110%;">
<?php if ($case_id == 0) { ?>
        <font color=blue style="background-color: yellow;">【基本情報】</font>&nbsp;&gt;&gt;&nbsp;
            オーダー情報&nbsp;&gt;&gt;&nbsp;
            契約書情報&nbsp;
<?php } else { ?>
            <a href="<?=ROOTDIR ?>/CaseManagement/reg1/<?=$case_id ?>/<?=$koushin_flag ?>" onclick="">【基本情報】</a>&nbsp;&gt;&gt;&nbsp;
            <a href="<?=ROOTDIR ?>/CaseManagement/reg2/<?=$case_id ?>/<?=$koushin_flag ?>" onclick="">【オーダー情報】</a>&nbsp;&gt;&gt;&nbsp;
            <font color=blue style="background-color: yellow;">契約書情報（２ページ目）</font>&nbsp;
<?php } ?>
        </font>
        <!-- ページ選択 END -->
<div style="font-size: 100%;margin-bottom: 10px;">
<?php echo $this->Form->create('OrderInfo'); ?>  
<?php echo $this->Form->input('OrderInfo.id', array('type'=>'hidden', 'value' => $order_id)); ?>
<?php echo $this->Form->input('OrderInfo.case_id', array('type'=>'hidden', 'value' => $case_id)); ?>   
<?php echo $this->Form->input('OrderInfo.username', array('type'=>'hidden', 'value' => $username)); ?>
<?php echo $this->Form->input('OrderInfo.class', array('type'=>'hidden', 'value' => $selected_class)); ?>
    <div id='headline' style="font-size: 120%;margin: 5px 0px;padding: 5px;border:1px solid black;background-color: #45bcd2;color:white;border-radius: 5px;width:1000px;">
        <span style="font-size: 100%;">★&nbsp;<?=$datas2[$file] ?>&nbsp;★</span>
    </div>
        
        <table border='1' cellspacing="0" cellpadding="5" style='width: 1000px;margin-top: 5px;border-spacing: 0px;'>
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>
                    案件名称
                </td>
                <td colspan="5" style='text-align: left;padding-left: 10px;'>
                    <?=$case_arr[$case_id] ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>
                    派遣先企業名
                </td>
                <td colspan="5" style='text-align: left;'>
                    <?php echo $this->Form->input('OrderInfo.dispatch_destination',
                            array('type'=>'text','div'=>false,'maxlength'=>'30','label'=>false,'style'=>'width:500px;','value'=>$data['OrderInfo']['order_name'])); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>
                    契約締結日
                </td>
                <td colspan="5" style="font-size: 100%;">
                    <?php echo $this->Form->input('OrderInfo.contract_date',
                            array('type'=>'text','div'=>false,'label'=>false,'class'=>'date','style'=>'display:none;', 'onchange'=>'setDate2(this, "contract_date2");')); ?>
                    <input type="text" id="contract_date2" disabled="disabled" style="background-color: white;border:none;font-size: 100%;width:150px;">
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>
                    派遣期間
                </td>
                <td colspan="5" style='text-align: left;'>
                    <?php
                        $period ='自&nbsp;'.convGtJDate($period_from).'&nbsp;～至&nbsp;'.convGtJDate($period_to);
                        $period2 ='自 '.convGtJDate($period_from).' ～ 至 '.convGtJDate($period_to);
                    ?>
                    <?=$period ?>&nbsp;&nbsp;<?=$order_name ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>
                    抵触日(事業所)
                </td>
                <td colspan="5" style="font-size: 100%;">
                    <?php echo $this->Form->input('OrderInfo.conflict_date',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:150px;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>
                    派遣元責任者
                </td>
                <td colspan="5" style="font-size: 100%;">
                    <?php echo $this->Form->input('OrderInfo.contract_date',
                            array('type'=>'select','div'=>false,'label'=>false,'options'=>$user_arr,'empty'=>'選んでしてください', 'style'=>'')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>
                    派遣料金
                </td>
                <td colspan="5" style="font-size: 100%;">
                    <?php echo $this->Form->input('OrderInfo.contract_date',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:100px;text-align:right;')); ?>円
                </td>
            </tr>
        </table>
    
        <!-- 派遣契約書（個別）内容 -->
        <table style="padding-top:10px;">
            <tr>
                <td>■派遣契約書（個別）内容</td>
            </tr>
        </table>
        <?php
            $text1 = '（以下「甲」という。）と株式会社ソフトライフ（以下「乙」という。）とは、'
                    . '平成　　年　　月　　日締結の「労働者派遣基本契約書」に基づき、下記派遣概要の通り、労働者派遣契約書（個別）を締結する。';
        ?>
        <table border='1' cellspacing="0" cellpadding="5" style='width: 1000px;margin-top: 0px;border-spacing: 0px;'>
            <tr>
                <td style='background-color: #e8ffff;text-align: left;padding-left: 10px;'>
                    <?php echo $this->Form->input('OrderInfo.contract_date',
                            array('type'=>'textarea','div'=>false,'label'=>false,'rows'=>3,'style'=>'width:95%;text-align:left;','value'=>$text1)); ?>
                </td>
            </tr>
        </table>
        <table border='1' cellspacing="0" cellpadding="5" style='width: 1000px;margin-top: 10px;border-spacing: 0px;table-layout: fixed;'>
            <colgroup>
                <col style="width:150px;" />
                <col style="width:150px;" />
                <col style="width:150px;" />
                <col style="width:150px;" />
                <col style="width:150px;" />
                <col style="width:150px;" />
            </colgroup>
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>
                    業務内容
                </td>
                <?php
                    $text2 ='受付スタッフ（労働派遣事業の適正な運営の確保及び派遣労働者の保護などに関する法律執行令第４条第１２号）：受付及びそれらに付帯する業務	';
                ?>
                <td colspan="5" style="font-size: 100%;">
                    <?php echo $this->Form->input('OrderInfo.contract_date',
                            array('type'=>'textarea','div'=>false,'label'=>false,'rows'=>3,'style'=>'width:95%;text-align:left;','value'=>$text2)); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: left;' rowspan="5">
                    就業場所
                </td>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>名称</td>
                <td colspan="4" style="font-size: 100%;">
                    <?php echo $this->Form->input('OrderInfo.contract_date',
                            array('type'=>'textarea','div'=>false,'rows'=>'2','label'=>false,'style'=>'width:95%;','value'=>$data['OrderInfo']['order_name'])); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>組織単位</td>
                <td colspan="4" style="font-size: 100%;">
                    <?php echo $this->Form->input('OrderInfo.contract_date',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:95%;','value'=>$data['OrderInfo']['order_name'])); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>部署</td>
                <td colspan="4" style="font-size: 100%;">
                    <?php echo $this->Form->input('OrderInfo.contract_date',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:95%;','value'=>$data['OrderInfo']['order_name'])); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>住所・TEL</td>
                <td colspan="4" style="font-size: 100%;">
                    <?php echo $this->Form->input('OrderInfo.contract_date',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:95%;','value'=>$data['OrderInfo']['order_name'])); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>指揮命令者</td>
                <td colspan="2" style="font-size: 100%;">
                    <?php echo $this->Form->input('OrderInfo.contract_date',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:95%;','value'=>$data['OrderInfo']['order_name'])); ?>
                </td>
                <td style='background-color: #e8ffff;text-align: left;'>役職名</td>
                <td style="font-size: 100%;">
                    <?php echo $this->Form->input('OrderInfo.contract_date',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:95%;','value'=>$data['OrderInfo']['order_name'])); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>
                    派遣期間
                </td>
                <td colspan="5" style='text-align: left;'>
                    <?php
                        $period ='自&nbsp;'.convGtJDate($period_from).'&nbsp;～至&nbsp;'.convGtJDate($period_to);
                        $period2 ='自 '.convGtJDate($period_from).' ～ 至 '.convGtJDate($period_to);
                    ?>
                    <?=$period ?>&nbsp;&nbsp;<?=$order_name ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>
                    就業日
                </td>
                <td colspan="2" style='text-align: left;'>
                    <?php echo $this->Form->input('OrderInfo.contract_date',
                            array('type'=>'text','div'=>false,'label'=>false,'rows'=>1,'style'=>'width:95%;')); ?>
                </td>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>
                    休日出勤
                </td>
                <td colspan="2" style='text-align: left;'>
                    <?php echo $this->Form->input('OrderInfo.contract_date',
                            array('type'=>'text','div'=>false,'label'=>false,'rows'=>1,'style'=>'width:95%;')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>
                    就業時間算出
                </td>
                <?php
                    $text3 = '欠勤、遅刻、早退等で契約時間に満たない場合及び契約時間外勤務をした場合の労働時間は15分単位とし、端数を切り上げることとする。';
                ?>
                <td colspan="5" style="font-size: 100%;">
                    <?php echo $this->Form->input('OrderInfo.contract_date',
                            array('type'=>'text','div'=>false,'label'=>false,'rows'=>2,'style'=>'width:95%;','value'=>$text3)); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>
                    時間外勤務
                </td>
                <?php
                    $text4 = '法定時間外勤務については、1日8時間、1カ月45時間、1年360時間を超えない範囲とする。';
                ?>
                <td colspan="5" style="font-size: 100%;">
                    <?php echo $this->Form->input('OrderInfo.contract_date',
                            array('type'=>'text','div'=>false,'label'=>false,'rows'=>1,'style'=>'width:95%;','value'=>$text4)); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>
                    安全及び衛生
                </td>
                <?php
                    $text5 = '甲及び乙は労働者派遣法第44条から第47条の2までの規定により課せられた責任を負う。';
                ?>
                <td colspan="5" style="font-size: 100%;">
                    <?php echo $this->Form->input('OrderInfo.contract_date',
                            array('type'=>'text','div'=>false,'label'=>false,'rows'=>1,'style'=>'width:95%;','value'=>$text5)); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>
                    福利厚生
                </td>
                <?php
                    $text6 = '制服の貸与　　無　　　　　　ロッカーの使用　　無';
                ?>
                <td colspan="5" style="font-size: 100%;">
                    <?php echo $this->Form->input('OrderInfo.contract_date',
                            array('type'=>'text','div'=>false,'label'=>false,'rows'=>1,'style'=>'width:95%;','value'=>$text6)); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>
                    便宜供与
                </td>
                <?php
                    $text7 = '甲は、派遣労働者に対し、甲が雇用する労働者が利用する設備について同様に利用することが出来るように努める。';
                ?>
                <td colspan="5" style="font-size: 100%;">
                    <?php echo $this->Form->input('OrderInfo.contract_date',
                            array('type'=>'text','div'=>false,'label'=>false,'rows'=>1,'style'=>'width:95%;','value'=>$text7)); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: left;' rowspan="2">
                    派遣元<br>苦情処理申出先
                </td>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>
                    役職・氏名
                </td>
                <td colspan="4" style="font-size: 100%;">
                    <?php echo $this->Form->input('OrderInfo.contract_date',
                            array('type'=>'text','div'=>false,'label'=>false,'rows'=>1,'style'=>'width:95%;','value'=>'')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>
                    ＴＥＬ
                </td>
                <td colspan="4" style="font-size: 100%;">
                    <?php echo $this->Form->input('OrderInfo.contract_date',
                            array('type'=>'text','div'=>false,'label'=>false,'rows'=>1,'style'=>'width:95%;','value'=>'')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: left;' rowspan="2">
                    派遣先<br>苦情処理申出先
                </td>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>
                    役職・氏名
                </td>
                <td colspan="4" style="font-size: 100%;">
                    <?php echo $this->Form->input('OrderInfo.contract_date',
                            array('type'=>'text','div'=>false,'label'=>false,'rows'=>1,'style'=>'width:95%;','value'=>'')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>
                    ＴＥＬ
                </td>
                <td colspan="4" style="font-size: 100%;">
                    <?php echo $this->Form->input('OrderInfo.contract_date',
                            array('type'=>'text','div'=>false,'label'=>false,'rows'=>1,'style'=>'width:95%;','value'=>'')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: left;' rowspan="2">
                    派遣元責任者
                </td>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>
                    役職・氏名
                </td>
                <td colspan="4" style="font-size: 100%;">
                    <?php echo $this->Form->input('OrderInfo.contract_date',
                            array('type'=>'text','div'=>false,'label'=>false,'rows'=>1,'style'=>'width:95%;','value'=>'')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>
                    ＴＥＬ
                </td>
                <td colspan="4" style="font-size: 100%;">
                    <?php echo $this->Form->input('OrderInfo.contract_date',
                            array('type'=>'text','div'=>false,'label'=>false,'rows'=>1,'style'=>'width:95%;','value'=>'')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: left;' rowspan="2">
                    派遣先責任者
                </td>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>
                    役職・氏名
                </td>
                <td colspan="4" style="font-size: 100%;">
                    <?php echo $this->Form->input('OrderInfo.contract_date',
                            array('type'=>'text','div'=>false,'label'=>false,'rows'=>1,'style'=>'width:95%;','value'=>'')); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>
                    ＴＥＬ
                </td>
                <td colspan="4" style="font-size: 100%;">
                    <?php echo $this->Form->input('OrderInfo.contract_date',
                            array('type'=>'text','div'=>false,'label'=>false,'rows'=>1,'style'=>'width:95%;','value'=>'')); ?>
                </td>
            </tr>
            
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>
                    派遣人員
                </td>
                <td colspan="5" style="font-size: 100%;">
                    <?php echo $this->Form->input('OrderInfo.contract_date',
                            array('type'=>'text','div'=>false,'label'=>false, 'style'=>'width:50px;','value'=>2)); ?>名
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>
                    派遣料金請求に<br>関する項目
                </td>
                <?php
                    $text5 = '派遣人員１名につき、時給　　　　　　円（消費税別途）。'
                            . '※8時間超過分の時間外勤務に関しては、　　　　　円（各消費税別途）とする。但し、甲の指揮命令者の指示した残業のみとする。';
                ?>
                <td colspan="5" style="font-size: 100%;">
                    <?php echo $this->Form->input('OrderInfo.contract_date',
                            array('type'=>'text','div'=>false,'label'=>false,'rows'=>3,'style'=>'width:95%;','value'=>$text5)); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>
                    交通費
                </td>
                <?php
                    $text6 = '就業場所までの交通費については、　　の負担とする。';
                ?>
                <td colspan="5" style="font-size: 100%;">
                    <?php echo $this->Form->input('OrderInfo.contract_date',
                            array('type'=>'text','div'=>false,'label'=>false,'rows'=>1,'style'=>'width:95%;','value'=>$text6)); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>
                    その他<br>特記事項
                </td>
                <?php
                    $text7 = '派遣期間・派遣人員など、状況により内容の変更が生じた場合は、その都度甲乙協議の上、見直すものとする。';
                ?>
                <td colspan="5" style="font-size: 100%;">
                    <?php echo $this->Form->input('OrderInfo.contract_date',
                            array('type'=>'text','div'=>false,'label'=>false,'rows'=>5,'style'=>'width:95%;','value'=>$text7)); ?>
                </td>
            </tr>
        </table>
        <!-- 派遣契約書（個別）内容 END -->
</div>        
        <!-- ページ選択 -->
        <font style="font-size: 110%;">
<?php if ($case_id == 0) { ?>
        <font color=blue style="background-color: yellow;">【基本情報】</font>&nbsp;&gt;&gt;&nbsp;
            オーダー情報&nbsp;&gt;&gt;&nbsp;
            契約書情報&nbsp;
<?php } else { ?>
            <a href="<?=ROOTDIR ?>/CaseManagement/reg1/<?=$case_id ?>/<?=$koushin_flag ?>" onclick="">【基本情報】</a>&nbsp;&gt;&gt;&nbsp;
            <a href="<?=ROOTDIR ?>/CaseManagement/reg2/<?=$case_id ?>/<?=$koushin_flag ?>" onclick="">【オーダー情報】</a>&nbsp;&gt;&gt;&nbsp;
            <font color=blue style="background-color: yellow;">契約書情報（２ページ目）</font>&nbsp;
<?php } ?>
        </font>
        <!-- ページ選択 END -->
    </fieldset>
    <div style='margin-left: 10px;'>
<?php echo $this->Form->submit('出　力', array('id'=>'button-create', 'name' => 'output','div' => false, 'style' => 'padding:10px 15px;', 'onclick' => '')); ?>
    &nbsp;&nbsp;
<?php print($this->Form->submit('戻　る', array('id'=>'button-delete', 'name'=>'close','div' => false , 'onclick'=>'history.back();'))); ?>
    &nbsp;&nbsp;
<?php print($this->Form->submit('閉 じ る', array('id'=>'button-delete', 'name'=>'close','div' => false , 'onclick'=>'window.opener.location.reload();window.close();'))); ?>
<!--
    &nbsp;&nbsp;
<?php print($this->Html->link('ﾌﾟﾛﾌｨｰﾙ', $_SESSION['cm_profile_url'], array('id'=>'button-create', 'style'=>'padding:10px;'))); ?> 
-->
    </div>
<?php echo $this->Form->end(); ?>
</div>