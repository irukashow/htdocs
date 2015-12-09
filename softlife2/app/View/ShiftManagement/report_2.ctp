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
  $('.date').datepicker({ dateFormat: 'yy-mm-dd' });
});
</script>
<script>
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
<script>
onload = function() {
    FixedMidashi.create();
    // チェックのあるセルを着色
    for(var col=0; col<<?=$row ?> ;col++) {
        for(var i=1; i<=31 ;i++) {
            if (document.getElementById("OrderCalendar"+col+"D"+i) == null) {
                break;
            }
            if (document.getElementById("OrderCalendar"+col+"D"+i).checked) {
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
</script>
<style type="text/css" media="screen">
  div.scroll_div { 
      overflow: auto;
      height: auto;
      width: auto;
      margin-top: 5px;
  }
</style>

<div style="width:90%;margin-top: 20px;margin-left: auto; margin-right: auto;">
    <fieldset style="border:none;margin-bottom: 5px;">
        <legend style="font-size: 150%;color: red;"><?php echo __('案件登録<font color=gray> （契約書作成）</font>'); ?></legend>
        <!-- ページ選択 -->
        <font style="font-size: 110%;">
<?php if ($case_id == 0) { ?>
        <font color=blue style="background-color: yellow;">【基本情報】</font>&nbsp;&gt;&gt;&nbsp;
            オーダー情報&nbsp;&gt;&gt;&nbsp;
            契約書情報&nbsp;
<?php } else { ?>
            <a href="<?=ROOTDIR ?>/CaseManagement/reg1/<?=$case_id ?>/<?=$koushin_flag ?>" onclick="">【基本情報】</a>&nbsp;&gt;&gt;&nbsp;
            <a href="<?=ROOTDIR ?>/CaseManagement/reg2/<?=$case_id ?>/<?=$koushin_flag ?>" onclick="">【オーダー情報】</a>&nbsp;&gt;&gt;&nbsp;
            <font color=blue style="background-color: yellow;">契約書作成（入力ページ、その②）</font>&nbsp;
<?php } ?>
        </font>
        <!-- ページ選択 END -->
<div style="font-size: 90%;margin-bottom: 10px;">
<?php echo $this->Form->create('ReportTable', array('name'=>'form')); ?>  
    <div class="scroll_div">
        <!-- 基本情報 -->
        <table border='1' cellspacing="0" cellpadding="5" style='width: 1000px;margin-top: 0px;border-spacing: 0px;overflow-y: scroll;'>
            <tr>
                <th style='background:#99ccff;text-align: center;'>案件・オーダー情報</th>
            </tr>
            <tr>
                <td align="left" style="padding-left: 10px;background-color: #FFFFCC;">
                    <font style="font-size: 110%;font-weight: bold;"><?=$case_arr[$case_id] ?></font><br>
                    <?=$order_info ?>
                </td>
            </tr>
        </table>
    </div>
    
        <!-- 通知書の内容 -->
        <table style="padding-top:5px;">
            <tr>
                <td style="font-size:110%;">■通知書の内容<span style="font-size:90%;margin-left: 10px;">※出力しないスタッフは「なし」に変えてください。</span></td>
            </tr>
        </table>
        <table border='1' cellspacing="0" cellpadding="5" style='width: 1000px;margin-top: 0px;border-spacing: 0px;table-layout: fixed;'>
            <colgroup>
                <col style="width:50px;" />
                <col style="width:125px;" />
                <col style="width:75px;" />
                <?php for($i=0; $i<8; $i++) { ?>
                <col style="width:100px;" />
                <?php } ?>
            </colgroup>
            <tr>
                <td style='background-color: #e8ffff;text-align: center;'>№</td>
                <td style='background-color: #e8ffff;text-align: center;'>氏名</td>
                <td style='background-color: #e8ffff;text-align: center;'>性別</td>
                <td style='background-color: #e8ffff;text-align: center;'>健康保険</td>
                <td style='background-color: #e8ffff;text-align: center;'>厚生年金</td>
                <td style='background-color: #e8ffff;text-align: center;'>雇用保険</td>
                <td style='background-color: #e8ffff;text-align: center;'>未加入理由<br>雇用保険</td>
                <td style='background-color: #e8ffff;text-align: center;'>未加入理由<br>厚生年金</td>
                <td style='background-color: #e8ffff;text-align: center;'>未加入理由<br>健康保険</td>
                <td style='background-color: #e8ffff;text-align: center;'>通知事項</td>
                <td style='background-color: #e8ffff;text-align: center;'>年齢</td>
            </tr>
            <?php foreach($staff_ids as $key=>$staff_id) { ?>
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: center;'>
                    <?=$key+1 ?>
                    <?php echo $this->Form->input('ReportTable.'.$key.'.id', array('type'=>'hidden', 'value' => '')); ?>   
                    <?php echo $this->Form->input('ReportTable.'.$key.'.class', array('type'=>'hidden', 'value' => $selected_class)); ?>
                    <?php echo $this->Form->input('ReportTable.'.$key.'.case_id', array('type'=>'hidden', 'value' => $case_id)); ?>
                    <?php echo $this->Form->input('ReportTable.'.$key.'.order_id', array('type'=>'hidden', 'value' => $order_id)); ?>
                    <?php echo $this->Form->input('ReportTable.'.$key.'.no', array('type'=>'hidden', 'value' => $key+1)); ?>
                </td>
                <?php
                    $gender_arr = array('0'=>'-', '1'=>'女', '2'=>'男');
                    $insurance_arr = array('0'=>'-', '1'=>'加入', '2'=>'未加入');
                    $reason = array('0'=>'-', '1'=>'1:1週間の労働時間が20時間に満たないため', '2'=>'2:1週間の労働時間が正社員の3/4に満たないため');
                    $employment = array('0'=>'-', '1'=>'無期雇用', '2'=>'有期雇用');
                    $age = array('0'=>'-', '1'=>'45歳以上60歳未満', '2'=>'60歳以上');
                ?>
                <td style="font-size: 100%;">
                    <?php echo $this->Form->input('ReportTable.'.$key.'.staff_id',
                            array('type'=>'select','div'=>false,'label'=>false,'style'=>'width:95%;text-align:left;','options'=>$staff_arr,'selected'=>$staff_id)); ?>
                </td>
                <td style="font-size: 100%;">
                    <?php echo $this->Form->input('ReportTable.'.$key.'.gender',
                            array('type'=>'select','div'=>false,'label'=>false,'style'=>'width:95%;text-align:left;','options'=>$gender_arr,'selected'=>$gender_arr2[$staff_id])); ?>
                </td>
                <td style="font-size: 100%;">
                    <?php echo $this->Form->input('ReportTable.'.$key.'.insurance1',
                            array('type'=>'select','div'=>false,'label'=>false,'style'=>'width:95%;text-align:left;','options'=>$insurance_arr)); ?>
                </td>
                <td style="font-size: 100%;">
                    <?php echo $this->Form->input('ReportTable.'.$key.'.insurance2',
                            array('type'=>'select','div'=>false,'label'=>false,'style'=>'width:95%;text-align:left;','options'=>$insurance_arr)); ?>
                </td>
                <td style="font-size: 100%;">
                    <?php echo $this->Form->input('ReportTable.'.$key.'.insurance3',
                            array('type'=>'select','div'=>false,'label'=>false,'style'=>'width:95%;text-align:left;','options'=>$insurance_arr)); ?>
                </td>
                <td style="font-size: 100%;">
                    <?php echo $this->Form->input('ReportTable.'.$key.'.reason1',
                            array('type'=>'select','div'=>false,'label'=>false,'style'=>'width:95%;text-align:left;','options'=>$reason)); ?>
                </td>
                <td style="font-size: 100%;">
                    <?php echo $this->Form->input('ReportTable.'.$key.'.reason2',
                            array('type'=>'select','div'=>false,'label'=>false,'style'=>'width:95%;text-align:left;','options'=>$reason)); ?>
                </td>
                <td style="font-size: 100%;">
                    <?php echo $this->Form->input('ReportTable.'.$key.'.reason3',
                            array('type'=>'select','div'=>false,'label'=>false,'style'=>'width:95%;text-align:left;','options'=>$reason)); ?>
                </td>
                <td style="font-size: 100%;">
                    <?php echo $this->Form->input('ReportTable.'.$key.'.employment',
                            array('type'=>'select','div'=>false,'label'=>false,'style'=>'width:95%;text-align:left;','options'=>$employment)); ?>
                </td>
                <td style="font-size: 100%;">
                    <?php echo $this->Form->input('ReportTable.'.$key.'.age',
                            array('type'=>'select','div'=>false,'label'=>false,'style'=>'width:95%;text-align:left;','options'=>$age)); ?>
                </td>
            </tr>
            <?php } ?>
        </table>
        <!-- 通知書の内容 END -->
        <!-- 労働条件通知書（兼）就業条件明示書の内容 -->
        <table style="padding-top:5px;">
            <tr>
                <td style="font-size:110%;">■労働条件通知書（兼）就業条件明示書の内容<span style="font-size:90%;margin-left: 10px;">※出力しないスタッフは「なし」に変えてください。</span></td>
            </tr>
        </table>
        <table border='1' cellspacing="0" cellpadding="5" style='width: 1000px;margin-top: 0px;border-spacing: 0px;table-layout: fixed;'>
            <colgroup>
                <col style="width:50px;" />
                <col style="width:125px;" />
                <col style="width:100px;" />
                <col style="width:125px;" />
                <col style="width:200px;" />
                <col style="width:100px;" />
                <col style="width:150px;" />
                <col style="width:150px;" />
            </colgroup>
            <tr>
                <td style='background-color: #e8ffff;text-align: center;'>№</td>
                <td style='background-color: #e8ffff;text-align: center;'>氏名</td>
                <td style='background-color: #e8ffff;text-align: center;'>通知日	</td>
                <td style='background-color: #e8ffff;text-align: center;'>派遣料金</td>
                <td style='background-color: #e8ffff;text-align: center;'>時間外</td>
                <td style='background-color: #e8ffff;text-align: center;'>交通費</td>
                <td style='background-color: #e8ffff;text-align: center;'>その他<br>特記事項</td>
                <td style='background-color: #e8ffff;text-align: center;'>抵触日<br>（個人）</td>
            </tr>
            <?php foreach($staff_ids as $key=>$staff_id) { ?>
            <tr>
                <td style='background-color: #e8ffff;width:20%;text-align: center;'>
                    <?=$key+1 ?>
                    <?php echo $this->Form->input('ReportTable.'.$key.'.id', array('type'=>'hidden')); ?>   
                    <?php echo $this->Form->input('ReportTable.'.$key.'.class', array('type'=>'hidden', 'value' => $selected_class)); ?>
                    <?php echo $this->Form->input('ReportTable.'.$key.'.case_id', array('type'=>'hidden', 'value' => $case_id)); ?>
                    <?php echo $this->Form->input('ReportTable.'.$key.'.order_id', array('type'=>'hidden', 'value' => $order_id)); ?>
                    <?php echo $this->Form->input('ReportTable.'.$key.'.no', array('type'=>'hidden', 'value' => $key+1)); ?>
                </td>
                <?php
                    $gender_arr = array('0'=>'-', '1'=>'女', '2'=>'男');
                    $insurance_arr = array('0'=>'-', '1'=>'加入', '2'=>'未加入');
                    $reason = array('0'=>'-', '1'=>'1:1週間の労働時間が20時間に満たないため', '2'=>'2:1週間の労働時間が正社員の3/4に満たないため');
                    $employment = array('0'=>'-', '1'=>'無期雇用', '2'=>'有期雇用');
                    $age = array('0'=>'-', '1'=>'45歳以上60歳未満', '2'=>'60歳以上');
                ?>
                <td style="font-size: 100%;">
                    <?php echo $this->Form->input('ReportTable.'.$key.'.staff_id',
                            array('type'=>'select','div'=>false,'label'=>false,'style'=>'width:95%;text-align:left;','options'=>$staff_arr,'selected'=>$staff_id)); ?>
                </td>
                <td style="font-size: 100%;">
                    <?php echo $this->Form->input('ReportTable.'.$key.'.notice_date',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:95%;text-align:left;','class'=>'date')); ?>
                </td>
                <td style="font-size: 100%;">
                    時給
                    <?php echo $this->Form->input('ReportTable.'.$key.'.salary',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:50%;text-align:right;','options'=>$insurance_arr)); ?> 円
                </td>
                <td style="font-size: 100%;">
                    <?php
                        $offhours = '実働８時間を超える時間外勤務については、時給×1.25とし、計算単位は15分単位とする。但し、甲の指揮命令者の指示した時間外勤務のみとする。';
                    ?>
                    <?php echo $this->Form->input('ReportTable.'.$key.'.offhours',
                            array('type'=>'text','div'=>false,'label'=>false,'rows'=>3,'style'=>'width:95%;text-align:left;font-size:90%;','value'=>$offhours)); ?>
                </td>
                <td style="font-size: 100%;">
                    <?php echo $this->Form->input('ReportTable.'.$key.'.transportation',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:95%;text-align:right;','options'=>$insurance_arr)); ?>
                </td>
                <td style="font-size: 100%;">
                    <?php echo $this->Form->input('ReportTable.'.$key.'.remarks',
                            array('type'=>'text','div'=>false,'label'=>false,'rows'=>3,'style'=>'width:95%;text-align:left;font-size:90%;','options'=>$reason)); ?>
                </td>
                <td style="font-size: 100%;">
                    <?php echo $this->Form->input('ReportTable.'.$key.'.conflict_date',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:95%;text-align:left;','value'=>'平成30年10月1日')); ?>
                </td>
            </tr>
            <?php } ?>
        </table>
        <!-- 労働条件通知書（兼）就業条件明示書の内容 END -->
        
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
            <font color=blue style="background-color: yellow;">契約書作成（入力ページ、その②） </font>&nbsp;
<?php } ?>
        </font>
        <!-- ページ選択 END -->
    </fieldset>
    <div style='margin-left: 10px;'>
<?php echo $this->Form->submit('出　力', array('id' => 'button-create','name' => 'forward','div' => false, 'style' => 'padding:10px 15px;', 'onclick' => '')); ?>
    &nbsp;&nbsp;
<?php echo $this->Form->submit('戻　る', array('id'=>'button-delete', 'name' => 'previous','div' => false, 'onclick' => '')); ?>
    &nbsp;&nbsp;
<?php print($this->Form->submit('閉 じ る', array('id'=>'button-delete', 'name'=>'close','div' => false , 'onclick'=>'window.opener.location.reload();window.close();'))); ?>
    </div>
<?php echo $this->Form->end(); ?>
</div>