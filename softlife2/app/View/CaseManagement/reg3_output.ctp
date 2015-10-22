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
});
</script>
<script>
$(function() {
	$('#time').timepicker();
});
</script>
<script>
onload = function() {
    FixedMidashi.create();
    // チェックのあるセルを着色
    for(var col=0; col<<?=$row ?> ;col++) {
        for(var i=1; i<=31 ;i++) {
            if (document.getElementById("OrderCalender"+col+"D"+i) == null) {
                break;
            }
            if (document.getElementById("OrderCalender"+col+"D"+i).checked) {
                changeColor(col, i, 1);
            } else {
                changeColor(col, i, 0);
            }
        }
    }
}
</script>
<script>
// カレンダー月指定
function setCalender(case_id, koushin_flag, order_id, year, month) {
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
            document.getElementById("OrderCalender"+col+"D"+i).checked=true;
            changeColor(col, i, 1);
        } else {
            document.getElementById("OrderCalender"+col+"D"+i).checked=false;
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
            document.getElementById("OrderCalender"+col+"D"+i).checked=true;
            changeColor(col, i, 1);
        } else {
            document.getElementById("OrderCalender"+col+"D"+i).checked=false;
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
    <div id='headline' style="font-size: 120%;margin-top: 5px;padding: 5px;border:1px solid black;background-color: #45bcd2;color:white;border-radius: 5px;width:1000px;">
        <span style="font-size: 100%;">★&nbsp;<?=$datas2[$file] ?>&nbsp;★</span>
    </div>
        
        <table border='1' cellspacing="0" cellpadding="5" style='width: 1000px;margin-top: 5px;border-spacing: 0px;'>
            <tr>
                <th colspan="5" style='background:#99ccff;text-align: left;padding-left: 10px;'>
                    <?php
                        $period ='自&nbsp;'.convGtJDate($period_from).'&nbsp;～至&nbsp;'.convGtJDate($period_to);
                        $period2 ='自 '.convGtJDate($period_from).' ～ 至 '.convGtJDate($period_to);
                    ?>
                    <?=$period ?>&nbsp;&nbsp;<?=$order_name ?>
                </th>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>
                    契約締結日
                </td>
                <td colspan="4" style="font-size: 100%;">
                    <?php echo $this->Form->input('OrderInfo.contract_date',
                            array('type'=>'text','div'=>false,'maxlength'=>'30','label'=>false,'style'=>'width:500px;','value'=>$data['OrderInfo']['order_name'])); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>
                    業務内容
                </td>
                <td colspan="4" style="font-size: 100%;">
                    <?php echo $this->Form->input('OrderInfo.contract_date',
                            array('type'=>'textarea','div'=>false,'rows'=>'3','label'=>false,'style'=>'width:700px;','value'=>$data['OrderInfo']['order_name'])); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: left;' rowspan="4">
                    就業場所
                </td>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>名称</td>
                <td colspan="3" style="font-size: 100%;">
                    <?php echo $this->Form->input('OrderInfo.contract_date',
                            array('type'=>'textarea','div'=>false,'rows'=>'2','label'=>false,'style'=>'width:700px;','value'=>$data['OrderInfo']['order_name'])); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>部署</td>
                <td colspan="3" style="font-size: 100%;">
                    <?php echo $this->Form->input('OrderInfo.contract_date',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:700px;','value'=>$data['OrderInfo']['order_name'])); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>住所・TEL</td>
                <td colspan="3" style="font-size: 100%;">
                    <?php echo $this->Form->input('OrderInfo.contract_date',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:700px;','value'=>$data['OrderInfo']['order_name'])); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>指揮命令者</td>
                <td style="font-size: 100%;">
                    <?php echo $this->Form->input('OrderInfo.contract_date',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:300px;','value'=>$data['OrderInfo']['order_name'])); ?>
                </td>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>役職</td>
                <td style="font-size: 100%;">
                    <?php echo $this->Form->input('OrderInfo.contract_date',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:300px;','value'=>$data['OrderInfo']['order_name'])); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: left;'>
                    派遣期間
                </td>
                <td colspan="4" style="font-size: 100%;">
                    <?php echo $this->Form->input('OrderInfo.contract_date',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:700px;','value'=>$period2)); ?>
                </td>
            </tr>
        </table>
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