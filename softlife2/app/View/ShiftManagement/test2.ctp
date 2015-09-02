<?php
    echo $this->Html->script( 'tools');
    //echo $this->Html->script('dropzone');
    echo $this->Html->script('jquery-1.9.1');
    //echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js');
    echo $this->Html->script('jquery.timepicker');
    echo $this->Html->script('fixed_midashi');
    echo $this->Html->css('jquery.timepicker');
?>
<?php
    // 初期値
    //$y = date('Y');
    $y = date('Y', strtotime('+1 month'));
    //$m = date('n');
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
?>
<?php
//JQueryのコントロールを使ったりして2000-12-23等の形式の文字列が渡すように限定するかんじ
function convGtJDate($src, $flag) {
    list($year, $month, $day) = explode("-", $src);
    if (!@checkdate($month, $day, $year) || $year < 1869 || strlen($year) !== 4) return false;
    $date = $year.sprintf("%02d", $month).sprintf("%02d", $day);
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
    if ($flag == 0) {
        switch ($wayear) {
            case 1:
                $wadate = $gengo."元年".$month."月".$day."日";
                break;
            default:
                $wadate = $gengo.sprintf("%02d", $wayear)."年".$month."月".$day."日";
        } 
    } elseif ($flag == 1) {
        switch ($wayear) {
            case 1:
                $wadate = $gengo."元年".$month."月";
                break;
            default:
                $wadate = $gengo.sprintf("%02d", $wayear)."年".$month."月";
        }
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
// 値があれば括弧で囲む
function setKakko($value) {
    if (!empty($value)) {
        $ret = '（'.$value.'）';
    } else {
        $ret = '';
    }
    return $ret;
}
// nullならば空を返す
function NZ($value) {
    if (empty($value)) {
        $ret = '';
    } else {
        $ret = $value;
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
function setCalender(year, month) {
    var options1 = year.options;
    var value1 = options1[year.options.selectedIndex].value;
    var options2 = month.options;
    var value2 = options2[month.options.selectedIndex].value;
    location.href="<?=ROOTDIR ?>/ShiftManagement/test2?date=" +value1 + "-" + value2;
}
// 職種の詳細を隠す
function setHidden() {
    target = document.getElementById("ActiveDisplay");
    if (document.getElementById("OrderDetail1").style.display == 'none') {
        for(i=1; i<=10; i++) {
            document.getElementById("OrderDetail"+i).style.display = 'table-row';
        }
        //target.innerHTML = '<span>詳細を隠す</span>';
    } else {
        for(i=1; i<=10; i++) {
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
</script>
<style type="text/css" media="screen">
  div.scroll_div { 
      overflow: auto;
      height: 600px;
      width: auto;
      margin-top: 5px;
  }
</style>

<div style="width:90%;margin-top: 0px;margin-right: auto;">
    <fieldset style="border:none;margin-bottom: 5px;">

<div style="font-size: 80%;margin-bottom: 10px;">  
        <!-- 職種入力 -->
        <?php echo $this->Form->create('OrderInfoDetail', array('name'=>'form1')); ?>
        <div class="scroll_div">
        <table border='1' cellspacing="0" cellpadding="5"
               style="width:<?=$row*80 ?>px;margin-top: 10px;margin-bottom: 10px;border-spacing: 0px;" _fixedhead="rows:2; cols:1">
            <thead>
            <tr>
                <th style='background:#99ccff;text-align: center;width:80px;'>
                    <a href="#" onclick="setHidden();"><span id="ActiveDisplay">表示切り替え</span></a>
                </th>
                <?php foreach ($datas as $data){ ?>
                <th style='background:#99ccff;text-align: center;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo $getCasename[$data['OrderCalender']['case_id']]; ?>
                </th>
                <?php } ?>
            </tr>
            </thead>
            <tbody>
            <tr style="">
                <td style='background-color: #e8ffff;'>番号</td>
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td style=''>
                    <?php echo $count+1; ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail1">
                <td style='background-color: #e8ffff;'>事業主</td>
                <?php foreach ($datas as $data){ ?>
                <td style='background:#ffffcc;text-align: center;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo NZ($list_entrepreneur[$data['OrderCalender']['case_id']]); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail1">
                <td style='background-color: #e8ffff;'>販売会社</td>
                <?php foreach ($datas as $data){ ?>
                <td style='text-align: center;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo NZ($list_client[$data['OrderCalender']['case_id']]); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail1">
                <td style='background-color: #e8ffff;'>指揮命令者/<br>担当者</td>
                <?php foreach ($datas as $data){ ?>
                <td style='text-align: center;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo NZ($list_director[$data['OrderCalender']['case_id']]); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail1">
                <td style='background-color: #e8ffff;'>現場住所</td>
                <?php foreach ($datas as $data){ ?>
                <td style='text-align: center;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo NZ($list_address[$data['OrderCalender']['case_id']]); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail1">
                <td style='background-color: #e8ffff;'>現場連絡先</td>
                <?php foreach ($datas as $data){ ?>
                <td style='text-align: center;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo 'TEL:'.NZ($list_telno[$data['OrderCalender']['case_id']]); ?><br>
                <?php echo 'FAX:'.NZ($list_faxno[$data['OrderCalender']['case_id']]); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail1">
                <td style='background-color: #e8ffff;'>待ち合わせ</td>
                <?php foreach ($datas as $data){ ?>
                <td style='text-align: center;' colspan="<?=$data[0]['cnt'] ?>">
                    <?php echo $this->Form->input('OrderInfoDetail.0.juchuu_cal',
                            array('type'=>'textarea','div'=>false,'label'=>false,'rows'=>2, 'style'=>'text-align: left;')); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail1">
                <td style='background-color: #e8ffff;'>請求先担当者</td>
                <?php foreach ($datas as $data){ ?>
                <td style='text-align: center;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo NZ($list_entrepreneur[$data['OrderCalender']['case_id']]); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail1">
                <td style='background-color: #e8ffff;'>請求書締日</td>
                <?php foreach ($datas as $data){ ?>
                <td style='text-align: center;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo NZ($list_entrepreneur[$data['OrderCalender']['case_id']]); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail1">
                <td style='background-color: #e8ffff;'>クリーニング</td>
                <?php foreach ($datas as $data){ ?>
                <td style='text-align: center;' colspan="<?=$data[0]['cnt'] ?>">
                    <?php echo $this->Form->input('OrderInfoDetail.0.juchuu_cal',
                            array('type'=>'text','div'=>false,'label'=>false, 'style'=>'text-align: left;')); ?>
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
                            array('type'=>'radio','div'=>false,'label'=>false,'legend'=>false,'options'=>$list1, 'value'=>setData($datas2,'juchuu_shiharai',$count,$record))); ?>
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
                            array('type'=>'radio','div'=>false,'label'=>false,'legend'=>false,'options'=>$list1, 'value'=>setData($datas2,'kyuuyo_shiharai',$count,$record))); ?>
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
            <tr>
                <td style='width:80px;background-color: #e8ffff;'>職種</td>
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td style='background-color: #ffffcc;'>
                    <?php echo $this->Form->input('OrderInfoDetail.'.$count.'.id',array('type'=>'hidden', 'value'=>setData($datas2,'id',$count,$record))); ?>
                    <?php echo $this->Form->input('OrderInfoDetail.'.$count.'.shokushu_num',array('type'=>'hidden','value'=>$count+1)); ?>
                    <?php echo $this->Form->input('OrderInfoDetail.'.$count.'.username', array('type'=>'hidden', 'value' => $username)); ?>
                    <?php echo $this->Form->input('OrderInfoDetail.'.$count.'.class', array('type'=>'hidden', 'value' => $selected_class)); ?>
                    
                    <?php echo $list_shokushu[setData($datas2,'shokushu_id',$count,$record)]; ?>
                    <?php echo setKakko(setData($datas2,'shokushu_memo',$count,$record)); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail1">
                <td style='background-color: #e8ffff;'>勤務時間</td>
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td style='background-color: #ffffcc;'>
                    <?php echo $this->Form->input('OrderInfoDetail.'.$count.'.resttime_from',
                        array('type'=>'textarea','div'=>false,'label'=>false,'style'=>'width:130px;text-align: left;background-color: #ffffcc;', 'rows'=>2,
                            'value'=>setData($datas2,'worktime_from',$count,$record).'～'.setData($datas2,'worktime_to',$count,$record))); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail2">
                <td style='background-color: #e8ffff;'>休憩時間</td>
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td style='background-color: #ffffcc;'>
                    <?php echo setData($datas2,'resttime_from',$count,$record); ?>&nbsp;～
                    <?php echo setData($datas2,'resttime_to',$count,$record); ?>
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
                        'value'=>$year, 'style'=>'text-align: left;width:80px;', 
                        'onchange'=>'setCalender(this, document.form2.month)')); ?><br>
                        <a href="<?=ROOTDIR ?>/ShiftManagement/test2?date=<?=date('Y-m', strtotime($y .'-' . $m . ' -1 month')); ?>">▲</a>
                    <?php $month_arr = array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12'); ?>
                    <?php echo $this->Form->input(false,array('name'=>'month', 'type'=>'select','div'=>false,'label'=>false, 'options' => $month_arr,
                        'value'=>$month, 'style'=>'text-align: right;', 'onchange'=>'setCalender(document.form2.year, this)')); ?>
                        <a href="<?=ROOTDIR ?>/ShiftManagement/test2?date=<?=date('Y-m', strtotime($y .'-' . $m . ' +1 month')); ?>">▼</a>
                </td>
                <!-- カレンダー月指定 END -->
                <?php for ($count=0; $count<$row; $count++){ ?>
                    <?php if (empty($datas2) || empty($datas2[$count])) { ?>
                        <?php echo $this->Form->input('OrderCalender.'.$count.'.id',array('type'=>'hidden')); ?>
                    <?php } elseif ($datas2[$count]['OrderCalender']['year'] != $year || $datas2[$count]['OrderCalender']['month'] != $month) { ?>
                        <?php echo $this->Form->input('OrderCalender.'.$count.'.id',array('type'=>'hidden')); ?>
                    <?php } else { ?>
                        <?php echo $this->Form->input('OrderCalender.'.$count.'.id',array('type'=>'hidden', 'value'=>$datas2[$count]['OrderCalender']['id'])); ?>
                    <?php } ?>
                    <?php echo $this->Form->input('OrderCalender.'.$count.'.shokushu_num',array('type'=>'hidden','value'=>$count+1)); ?>
                    <?php echo $this->Form->input('OrderCalender.'.$count.'.username', array('type'=>'hidden', 'value' => $username)); ?>
                    <?php echo $this->Form->input('OrderCalender.'.$count.'.class', array('type'=>'hidden', 'value' => $selected_class)); ?>
                    <?php echo $this->Form->input('OrderCalender.'.$count.'.year',array('type'=>'hidden','value'=>'')); ?>
                    <?php echo $this->Form->input('OrderCalender.'.$count.'.month',array('type'=>'hidden','value'=>'')); ?>
                <td align='left' style='background-color: #e8ffff;'>
                    <?='備考欄' ?>
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
                        <?php if (empty($datas2) || empty($datas2[$count])) { ?>
                        <?php echo ''; ?>
                        <?php } else { ?>
                        <?php echo $datas2[$count]['OrderCalender']['d'.$d]; ?>
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

    </fieldset>
    <div style='margin-left: 10px;'>
<?php print($this->Html->link('戻　る', 'javascript:void(0);', array('id'=>'button-create', 'style'=>'padding:11px;', 'onclick'=>'window.history.back(-1);return false;'))); ?>
    </div>
<?php echo $this->Form->end(); ?>
</div>
