<?php
    echo $this->Html->script( 'tools');
    //echo $this->Html->script('dropzone');
    echo $this->Html->script('jquery-1.9.1');
    //echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js');
    echo $this->Html->script('jquery.timepicker');
    echo $this->Html->script('fixed_midashi');
    echo $this->Html->css('jquery.timepicker');
?>
<?php require('calender.ctp'); ?>
<?php
//JQueryのコントロールを使ったりして2000-12-23等の形式の文字列が渡すように限定するかんじ
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
            $wadate = $gengo."元年".$month."月".$day."日";
            break;
        default:
            $wadate = $gengo.sprintf("%02d", $wayear)."年".$month."月".$day."日";
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
    /** 番号のマークをセット **/
    function setNum($number) {
        $arr = array('', '①', '②', '③', '④', '⑤', '⑥','⑦','⑧','⑨','⑩');
        return $arr[$number];
    }
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
  $('.date').datepicker({ dateFormat: 'yy/mm/dd' });
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
      height: 800px;
      width: auto;
      margin-top: 5px;
  }
</style>

<div style="width:90%;margin-top: 20px;margin-left: auto; margin-right: auto;">
    <fieldset style="border:none;margin-bottom: 5px;">
        <legend style="font-size: 150%;color: red;"><?php echo __('案件登録<font color=gray> （オーダー情報）</font>'); ?></legend>
        <!-- ページ選択 -->
        <font style="font-size: 110%;">
<?php if ($case_id == 0) { ?>
        <font color=blue style="background-color: yellow;">【基本情報】</font>&nbsp;&gt;&gt;&nbsp;
            オーダー情報&nbsp;&gt;&gt;&nbsp;
            契約書情報&nbsp;
<?php } else { ?>
            <a href="<?=ROOTDIR ?>/CaseManagement/reg1/<?=$case_id ?>/<?=$koushin_flag ?>" onclick="">【基本情報】</a>&nbsp;&gt;&gt;&nbsp;
            <font color=blue style="background-color: yellow;">オーダー情報</font>&nbsp;&gt;&gt;&nbsp;
            <a href="<?=ROOTDIR ?>/CaseManagement/reg3/<?=$case_id ?>/<?=$koushin_flag ?>" onclick="alert('制作前');return false;">【契約書情報】</a>&nbsp;
<?php } ?>
        </font>
        <!-- ページ選択 END -->
<div style="font-size: 80%;margin-bottom: 10px;">
<?php echo $this->Form->create('OrderInfo'); ?>  
<?php echo $this->Form->input('OrderInfo.id', array('type'=>'hidden', 'value' => $order_id)); ?>
<?php echo $this->Form->input('OrderInfo.case_id', array('type'=>'hidden', 'value' => $case_id)); ?>   
<?php echo $this->Form->input('OrderInfo.username', array('type'=>'hidden', 'value' => $username)); ?>
<?php echo $this->Form->input('OrderInfo.class', array('type'=>'hidden', 'value' => $selected_class)); ?>
        <!-- 基本情報 -->
        <table border='1' cellspacing="0" cellpadding="5" style='width: 1000px;margin-top: 10px;border-spacing: 0px;'>
            <tr>
                <th colspan="5" style='background:#99ccff;text-align: center;'>登録済オーダー</th>
            </tr>
            <?php foreach($datas0 as $key=>$data0) { ?>
            <tr>
                <td align="center" style='background-color: #e8ffff;width:20%;'><?=setNum($key+1) ?></td>
                <?php if ($data0['OrderInfo']['id'] == $order_id) { ?>
                <td colspan="3" style="background-color: #ffffcc;">
                    <a href="<?=ROOTDIR ?>/CaseManagement/reg2/<?=$case_id ?>/<?=$koushin_flag ?>/<?=$data0['OrderInfo']['id']  ?>">
                    <?php echo '自&nbsp;'.convGtJDate($data0['OrderInfo']['period_from'])
                            .'&nbsp;～&nbsp;至&nbsp;'.convGtJDate($data0['OrderInfo']['period_to']).'&nbsp;&nbsp;&nbsp;'.$data0['OrderInfo']['order_name']; ?>
                    </a>
                </td>
                <td align="center" style="background-color: #ffffcc;width: 50px;">
                    <?php echo $this->Form->input('削　除',
                            array('type'=>'submit','div'=>false,'label'=>false,
                                'name'=>'delete_order['.$data0['OrderInfo']['id'].']','id'=>'button-delete', 
                                'onclick' => 'return confirm("削除してもよろしいですか？");', 'style'=>'margin-top:-10px;padding:3px 10px 3px 10px;')); ?>
                </td>
                <?php } else { ?>
                <td colspan="3">
                    <a href="<?=ROOTDIR ?>/CaseManagement/reg2/<?=$case_id ?>/<?=$koushin_flag ?>/<?=$data0['OrderInfo']['id']  ?>">
                    <?php echo '自&nbsp;'.convGtJDate($data0['OrderInfo']['period_from'])
                            .'&nbsp;～&nbsp;至&nbsp;'.convGtJDate($data0['OrderInfo']['period_to']).'&nbsp;&nbsp;&nbsp;'.$data0['OrderInfo']['order_name']; ?>
                    </a>
                </td>
                <td></td>
                <?php } ?>
            </tr>
            <?php } ?>
            <?php if (empty($datas0)) { ?>
            <tr>
                <td align="center" colspan="5" style="background-color: #fff9ff;">登録されたデータはありません。</td>
            </tr>
            <?php } ?>
            <?php 
                if (empty($order_id)) { 
                    $style = 'background-color: #ffffcc;';
                } else {
                    $style = 'background-color: #fff9ff;';
                }
            ?>
            <tr>
                <td align="center" colspan="5" style="<?=$style ?>">
                    <a href="<?=ROOTDIR ?>/CaseManagement/reg2/<?=$case_id ?>/<?=$koushin_flag ?>/">▶ 新規登録 ◀</a>
                </td>
            </tr>
        </table>
        
        <table border='1' cellspacing="0" cellpadding="5" style='width: 1000px;margin-top: 10px;border-spacing: 0px;'>
            <tr>
                <th colspan="4" style='background:#99ccff;text-align: center;'>オーダー入力</th>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>保存名（帳票単位）</td>
                <td colspan="3">
                    <?php echo $this->Form->input('OrderInfo.order_name',
                            array('type'=>'text','div'=>false,'maxlength'=>'30','label'=>false,'style'=>'width:500px;','value'=>setData2($datas, 'OrderInfo', 'order_name'))); ?>
                </td>
            </tr>
            <tr>
                <td style='background-color: #e8ffff;width:20%;'>契約期間</td>
                <td colspan="1">
                    自&nbsp;<?php echo $this->Form->input('OrderInfo.period_from',
                            array('type'=>'text','div'=>false,'class'=>'date','label'=>false, 'placeholder' => '開始日','style'=>'width:150px;','value'=>setData2($datas, 'OrderInfo', 'period_from'))); ?>
                    ～
                    至&nbsp;<?php echo $this->Form->input('OrderInfo.period_to',
                            array('type'=>'text','div'=>false,'class'=>'date','label'=>false, 'placeholder' => '終了日','style'=>'width:150px;','value'=>setData2($datas, 'OrderInfo', 'period_to'))); ?>
                </td>
                <td style='background-color: #e8ffff;width:20%;'>登録職種数</td>
                <td style='width:20%;'>
                    <?php $list = array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12','13'=>'13','14'=>'14','15'=>'15'); ?>
                    <?php echo $this->Form->input('OrderInfo.shokushu_num',
                            array('type'=>'select','div'=>false,'options'=>$list,'label'=>false,'style'=>'width:50px;','value'=>setData2($datas, 'OrderInfo', 'shokushu_num'))); ?>
                </td>
            </tr>
        </table>
        <!-- 追加ボタン -->
        <div style="margin-left: 400px;">
            <?php echo $this->Form->submit('▼ (1) 登 録（職種入力へ） ▼',array('label'=>false,'name'=>'insert','id'=>'', 'style'=>'font-size:110%;')); ?>
        </div>
        <?php echo $this->Form->end(); ?>
        <!-- 追加ボタン END -->
        
        <!-- 職種入力 -->
        <?php
            if ($row <5) {
                $width = 'auto';
            } else {
                $width = '100%';
            }
            $width = 'auto';
        ?>
        <?php echo $this->Form->create('OrderInfoDetail', array('name'=>'form1')); ?>
        <div class="scroll_div">
        <table border='1' cellspacing="0" cellpadding="5"
               style="width:<?=$width ?>;margin-top: 10px;margin-bottom: 10px;border-spacing: 0px;" _fixedhead="rows:2; cols:1">
            <thead>
            <tr>
                <th style='background:#99ccff;text-align: center;width:100px;'>
                    <a href="#" onclick="setHidden();"><span id="ActiveDisplay">表示切り替え</span></a>
                </th>
                <?php for ($count = 0; $count < $row; $count++){ ?>
                <th style='background:#99ccff;text-align: center;width:200px;'>
                    【<?= $count+1 ?>】
                </th>
                <?php } ?>
            </tr>
            <tr>
                <td style='width:100px;background-color: #e8ffff;'>職種</td>
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td style='width:200px;'>
                    <?php echo $this->Form->input('OrderInfoDetail.'.$count.'.id',array('type'=>'hidden', 'value'=>setData($datas2,'id',$count,$record))); ?>
                    <?php echo $this->Form->input('OrderInfoDetail.'.$count.'.order_id',array('type'=>'hidden', 'value'=>$order_id)); ?>
                    <?php echo $this->Form->input('OrderInfoDetail.'.$count.'.case_id',array('type'=>'hidden','value'=>$case_id)); ?>
                    <?php echo $this->Form->input('OrderInfoDetail.'.$count.'.shokushu_num',array('type'=>'hidden','value'=>$count+1)); ?>
                    <?php echo $this->Form->input('OrderInfoDetail.'.$count.'.username', array('type'=>'hidden', 'value' => $username)); ?>
                    <?php echo $this->Form->input('OrderInfoDetail.'.$count.'.class', array('type'=>'hidden', 'value' => $selected_class)); ?>
                    
                    <?php echo $this->Form->input('OrderInfoDetail.'.$count.'.shokushu_id',array('type'=>'select','div'=>false,'label'=>false, 'options' => $list_shokushu,
                        'value'=>setData($datas2,'shokushu_id',$count,$record), 'empty'=>array(''=>'職種を選んでください'), 'style'=>'width:200px;text-align: left;')); ?>
                    （<?php echo $this->Form->input('OrderInfoDetail.'.$count.'.shokushu_memo',array('type'=>'text','div'=>false,'label'=>false, 'placeholder'=>'備考',
                        'value'=>setData($datas2,'shokushu_memo',$count,$record), 'style'=>'width:85%;text-align: left;')); ?>）
                </td>
                <?php } ?>
            </tr>
            </thead>
            <tbody>
            <tr id="OrderDetail1">
                <td style='background-color: #e8ffff;'>基本<br>就業時間</td>
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td style=''>
                    <?php echo $this->Form->input('OrderInfoDetail.'.$count.'.worktime_from',
                            array('type'=>'text','id'=>'time','div'=>false,'label'=>false,
                                'style'=>'width:50px;text-align: left;', 'value'=>setData($datas2,'worktime_from',$count,$record), 'onchange'=>'doAlert(this.value, this)'));
                    ?>
                    ～
                    <?php echo $this->Form->input('OrderInfoDetail.'.$count.'.worktime_to',
                            array('type'=>'text','id'=>'time','div'=>false,'label'=>false,
                                'style'=>'width:50px;text-align: left;', 'value'=>setData($datas2,'worktime_to',$count,$record), 'onchange'=>'doAlert(this.value, this)')); ?>
                    <span style="color:red;">※例 9:00</span>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail2">
                <td style='background-color: #e8ffff;'>休憩時間</td>
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td style=''>
                    <?php echo $this->Form->input('OrderInfoDetail.'.$count.'.resttime_from',
                        array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:50px;text-align: left;', 
                            'value'=>setData($datas2,'resttime_from',$count,$record), 'onchange'=>'doAlert(this.value, this)')); ?>&nbsp;～
                    <?php echo $this->Form->input('OrderInfoDetail.'.$count.'.resttime_to',
                        array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:50px;text-align: left;', 
                            'value'=>setData($datas2,'resttime_to',$count,$record), 'onchange'=>'doAlert(this.value, this)')); ?>
                        <span style="color:red;">※例 12:30</span>
                </td>
                <?php } ?>
            </tr>
            <!-- 受注 -->
            <?php $list1 = array('1'=>'時間', '2'=>'日払', '3'=>'月払'); ?>
            <?php $list2 = array('1'=>'有', '0'=>'無'); ?>
            <tr id="OrderDetail3">
                <td rowspan="4" style='background-color: #e8ffff;'>受注</td>
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td style=''>
                    <?php echo $this->Form->input('OrderInfoDetail.'.$count.'.juchuu_shiharai',
                            array('type'=>'radio','div'=>false,'label'=>false,'legend'=>false,'options'=>$list1, 'default' => 1, 'value'=>setData($datas2,'juchuu_shiharai',$count,$record))); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail4">
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td style=''>
                    金額：<?php echo $this->Form->input('OrderInfoDetail.'.$count.'.juchuu_money',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:90px;text-align: left;', 'value'=>setData($datas2,'juchuu_money',$count,$record))); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail5">
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td style=''>
                    交通費：<?php echo $this->Form->input('OrderInfoDetail.'.$count.'.juchuu_koutsuuhi',
                            array('type'=>'radio','div'=>false,'legend'=>false,'label'=>false, 'options'=>$list2, 'value'=>setData($datas2,'juchuu_koutsuuhi',$count,$record))); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail6">
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td style=''>
                    計算方法：<?php echo $this->Form->input('OrderInfoDetail.'.$count.'.juchuu_cal',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:140px;text-align: left;', 'value'=>setData($datas2,'juchuu_cal',$count,$record))); ?>
                </td>
                <?php } ?>
            </tr>
            <!-- 受注 END -->
            <!-- 給与 -->
            <tr id="OrderDetail7">
                <td rowspan="4" style='background-color: #e8ffff;'>給与</td>
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td style=''>
                    <?php echo $this->Form->input('OrderInfoDetail.'.$count.'.kyuuyo_shiharai',
                            array('type'=>'radio','div'=>false,'label'=>false,'legend'=>false,'options'=>$list1, 'default' => 1, 'value'=>setData($datas2,'kyuuyo_shiharai',$count,$record))); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail8">
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td style=''>
                    金額：<?php echo $this->Form->input('OrderInfoDetail.'.$count.'.kyuuyo_money',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:90px;text-align: left;', 'value'=>setData($datas2,'kyuuyo_money',$count,$record))); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail9">
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td style=''>
                    交通費：<?php echo $this->Form->input('OrderInfoDetail.'.$count.'.kyuuyo_koutsuuhi',
                            array('type'=>'radio','div'=>false,'legend'=>false,'label'=>false, 'options'=>$list2, 'value'=>setData($datas2,'kyuuyo_koutsuuhi',$count,$record))); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail10">
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td style=''>
                    計算方法：<?php echo $this->Form->input('OrderInfoDetail.'.$count.'.kyuuyo_cal',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:140px;text-align: left;', 'value'=>setData($datas2,'kyuuyo_cal',$count,$record))); ?>
                </td>
                <?php } ?>
            </tr>
            <!-- 給与 END -->
            <!-- 推奨スタッフ -->
            <tr id="OrderDetail11">
                <td rowspan="1" style='background-color: #e8ffff;'>推奨スタッフ</td>
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td>
                    <?php
                        if (!empty($staff_ids[$count])) {
                            $staff_id = $staff_ids[$count];
                            echo $this->Form->input('OrderInfoDetail.'.$count.'.staff_ids',
                                array('type'=>'hidden', 'value'=> implode(',', $staff_id))); 
                            foreach($staff_names[$count] as $staff_name) {
                                echo $staff_name.'<br>';
                            }
                        } else {
                            $staff_id = null;
                        }
                    ?>
                    <input type="button" value="スタッフ選択" 
                           onclick="window.open('<?=ROOTDIR ?>/CaseManagement/select/<?=$order_id ?>/<?=$count ?>',
                                'スタッフ選択','width=800,height=600,scrollbars=yes');">
                </td>
                <?php } ?>
            </tr>
            <!-- 推奨スタッフ END -->
            <tr id="OrderDetail12">
                <td rowspan="1" style='background-color: #e8ffff;'>
                </td>
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td align='center' style='background-color: #e8ffff;'>
                    <?php echo $this->Form->submit('(2) 登 録', array('name' => 'register','div' => false, 'style'=>'margin-top:0px;padding: 5px 15px 5px 15px;')); ?>
                        &nbsp;&nbsp;
                    <?php echo $this->Form->submit('↑消去↓',
                            array('div'=>false,'label'=>false,
                                'name'=>'delete['.setData($datas2,'id',$count,$record).']','id'=>'button-delete', 
                                'onclick' => 'return confirm("削除してもよろしいですか？");', 'style'=>'margin-top:-10px;padding: 5px 15px 5px 15px;')); ?>
                </td>
                <?php } ?>
            </tr>
<?php echo $this->Form->end(); ?>
<?php echo $this->Form->create('OrderCalender', array('name'=>'form2')); ?>
            <tr>
                <!-- カレンダー月指定 -->
                <td rowspan="1" align="center" style='background-color: #e8ffff;'>
                    <?php
                        $year_arr = array();
                        $year_arr = array('1999'=>'1999');
                        for($j=2000; $j<2100; $j++) {
                            $year_arr += array($j => $j); 
                        }
                    ?>
                    <?php echo $this->Form->input(false,array('name'=>'year', 'type'=>'select','div'=>false,'label'=>false, 'options' => $year_arr,
                        'value'=>$year, 'style'=>'text-align: left;',
                        'onchange'=>'setCalender('.$case_id.','.$koushin_flag.','.$order_id.', this, document.form2.month)')); ?>年<br>
                        <a href="<?=ROOTDIR ?>/CaseManagement/reg2/<?=$case_id ?>/<?=$koushin_flag ?>/<?=$order_id ?>?date=<?=date('Y-m', strtotime($y .'-' . $m . ' -1 month')); ?>">▲</a>
                    <?php $month_arr = array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12'); ?>
                    <?php echo $this->Form->input(false,array('name'=>'month', 'type'=>'select','div'=>false,'label'=>false, 'options' => $month_arr,
                        'value'=>$month, 'style'=>'text-align: right;', 
                        'onchange'=>'setCalender('.$case_id.','.$koushin_flag.','.$order_id.', document.form2.year, this)')); ?>月
                        <a href="<?=ROOTDIR ?>/CaseManagement/reg2/<?=$case_id ?>/<?=$koushin_flag ?>/<?=$order_id ?>?date=<?=date('Y-m', strtotime($y .'-' . $m . ' +1 month')); ?>">▼</a>
                </td>
                <!-- カレンダー月指定 END -->
                <?php for ($count=0; $count<$row; $count++){ ?>
                    <?php if (empty($datas1) || empty($datas1[$count])) { ?>
                        <?php echo $this->Form->input('OrderCalender.'.$count.'.id',array('type'=>'hidden')); ?>
                    <?php } elseif ($datas1[$count]['OrderCalender']['year'] != $year || $datas1[$count]['OrderCalender']['month'] != $month) { ?>
                        <?php echo $this->Form->input('OrderCalender.'.$count.'.id',array('type'=>'hidden')); ?>
                    <?php } else { ?>
                        <?php echo $this->Form->input('OrderCalender.'.$count.'.id',array('type'=>'hidden', 'value'=>$datas1[$count]['OrderCalender']['id'])); ?>
                    <?php } ?>
                    <?php echo $this->Form->input('OrderCalender.'.$count.'.order_id',array('type'=>'hidden', 'value'=>$order_id)); ?>
                    <?php echo $this->Form->input('OrderCalender.'.$count.'.case_id',array('type'=>'hidden','value'=>$case_id)); ?>
                    <?php echo $this->Form->input('OrderCalender.'.$count.'.shokushu_num',array('type'=>'hidden','value'=>$count+1)); ?>
                    <?php echo $this->Form->input('OrderCalender.'.$count.'.username', array('type'=>'hidden', 'value' => $username)); ?>
                    <?php echo $this->Form->input('OrderCalender.'.$count.'.class', array('type'=>'hidden', 'value' => $selected_class)); ?>
                    <?php echo $this->Form->input('OrderCalender.'.$count.'.year',array('type'=>'hidden','value'=>'')); ?>
                    <?php echo $this->Form->input('OrderCalender.'.$count.'.month',array('type'=>'hidden','value'=>'')); ?>
                <td align='center' style='background-color: #e8ffff;'>
                    <?php echo $this->Form->input(false,array('name'=>'check1', 'type'=>'checkbox','div'=>true,'label'=>'全選択・全解除',
                        'value'=>1, 'style'=>'text-align: left;',
                        'onclick'=>'setAllSelect('.$count.', this);')); ?><br>
                    <?php echo $this->Form->input(false,array('name'=>'check1', 'type'=>'checkbox','div'=>true,'label'=>'土日選択・解除',
                        'value'=>1, 'style'=>'text-align: left;',
                        'onclick'=>'setAllSelect2('.$count.', this);')); ?>
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
                    echo '<td align="center" style="color:'.$style.';background-color: #e8ffff;">'.$m.'/'.$d.'('.$weekday[$i].')</td>';
                    if ($i==0 || $i==6) {
                        echo '<input type="hidden" id="HolidayD'.$d.'" value="1">';
                    } else {
                        echo '<input type="hidden" id="HolidayD'.$d.'" value="0">';
                    }
                    for ($count=0; $count<$row; $count++){
            ?>
                <td id="Cell<?=$count ?>D<?=$d ?>">
                    <div style='color:<?=$style ?>;' class='input checkbox'>
                        <?php if (empty($datas1) || empty($datas1[$count])) { ?>
                        <?php echo $this->Form->input('OrderCalender.'.$count.'.d'.$d,
                                    array('type'=>'checkbox','div'=>false,'legend'=>false,'label'=>'選択', 'checked'=>0,
                                        'value'=>1, 'onclick'=>'changeColor('.$count.','.$d.',this.checked);')); ?>
                        <?php } elseif ($datas1[$count]['OrderCalender']['year'] != $year || $datas1[$count]['OrderCalender']['month'] != $month ) { ?>
                        <?php echo $this->Form->input('OrderCalender.'.$count.'.d'.$d,
                                    array('type'=>'checkbox','div'=>false,'legend'=>false,'label'=>'選択', 'checked'=>0,
                                        'value'=>1, 'onclick'=>'changeColor('.$count.','.$d.',this.checked);')); ?>
                        <?php } else { ?>
                        <?php echo $this->Form->input('OrderCalender.'.$count.'.d'.$d,
                                    array('type'=>'checkbox','div'=>false,'legend'=>false,'label'=>'選択', 'checked'=>$datas1[$count]['OrderCalender']['d'.$d],
                                        'value'=>1, 'onclick'=>'changeColor('.$count.','.$d.',this.checked);')); ?>
                        <input type="hidden" name="shokushu_num" value="<?=$datas1[$count]['OrderCalender']['shokushu_num'] ?>">
                        <?php } ?>
                        
                    </div>
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
</div>
        <!-- ページ選択 -->
        <font style="font-size: 110%;">
<?php if ($case_id == 0) { ?>
        <font color=blue style="background-color: yellow;">【基本情報】</font>&nbsp;&gt;&gt;&nbsp;
            オーダー情報&nbsp;&gt;&gt;&nbsp;
            契約書情報&nbsp;
<?php } else { ?>
            <a href="<?=ROOTDIR ?>/CaseManagement/reg1/<?=$case_id ?>/<?=$koushin_flag ?>" onclick="">【基本情報】</a>&nbsp;&gt;&gt;&nbsp;
            <font color=blue style="background-color: yellow;">オーダー情報</font>&nbsp;&gt;&gt;&nbsp;
            <a href="<?=ROOTDIR ?>/CaseManagement/reg3/<?=$case_id ?>/<?=$koushin_flag ?>" onclick="alert('制作前');return false;">【契約書情報】</a>&nbsp;
<?php } ?>
        </font>
        <!-- ページ選択 END -->
    </fieldset>
    <div style='margin-left: 10px;'>
<?php echo $this->Form->submit('(3) 登録する', array('name' => 'register2','div' => false, 'onclick' => 'form1.submit();form2.submit();')); ?>
    &nbsp;&nbsp;
<?php print($this->Form->submit('閉 じ る', array('id'=>'button-delete', 'name'=>'close','div' => false , 'onclick'=>'window.opener.location.reload();window.close();'))); ?>
<!--
    &nbsp;&nbsp;
<?php print($this->Html->link('ﾌﾟﾛﾌｨｰﾙ', $_SESSION['cm_profile_url'], array('id'=>'button-create', 'style'=>'padding:10px;'))); ?> 
-->
    </div>
<?php echo $this->Form->end(); ?>
</div>
