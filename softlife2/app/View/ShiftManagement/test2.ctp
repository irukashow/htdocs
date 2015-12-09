<?php
    //echo $this->Html->script( 'tools');
    //echo $this->Html->script('dropzone');
    //echo $this->Html->script('jquery-1.9.1');
    //echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js');
    //echo $this->Html->script('jquery.timepicker');
    echo $this->Html->script('fixed_midashi');
    echo $this->Html->script('jquery.tablefix');
    echo $this->Html->script('redips-drag-min');
    echo $this->Html->script('script');
    echo $this->Html->css('evol.colorpicker.min');
    //echo $this->Html->css('jquery.timepicker');
    echo $this->Html->css('style_1');
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
$font_normal = "font-family: Meiryo, メイリオ,'lucida grande',verdana,helvetica,arial,sans-serif;";
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
        $ret = '('.$value.')';
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
// 配列を処理する
function setArray($array) {
    if (empty($array)) {
        $ret = '';
    } else {
        foreach($array as $key=>$value) {
            if ($key == 0) {
                $ret = $value['StaffMaster']['name'];
            } else {
                $ret = $ret.'<br>'.$value['StaffMaster']['name'];
            }
        }
    }
    return $ret;
}
// 推奨スタッフ
function setRecoStaff($count, $datas) {
    if (empty($datas[$count])) {
        $ret = '';
    } else {
        asort($datas[$count]);
        foreach ($datas[$count] as $value) {
            if (empty($ret)) {
                $ret = $value['StaffMaster']['name'].'('.$value['StaffMaster']['id'].')';
            } else {
                $ret = $ret.'<br>'.$value['StaffMaster']['name'].'('.$value['StaffMaster']['id'].')';
            }
        }
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
    /** 幅 **/
    function setWidth($row) {
        $width = 1200;
        if (120+$row*120+20 > $width) {
            $ret = 120+$row*120+20;
        } else {
            $ret = $width;
        } 
        return $ret;
    }
?>

<script>
onload = function() {
    FixedMidashi.create();
    REDIPS.drag.dropMode = 'multiple';
    var width = 1200;
    // ヘッダを隠す
    document.getElementById("header").style.display = 'none';
    //document.getElementById("menu_table").style.display = 'none';
    if (120+<?=$row ?>*120+20 > width) {
        document.body.style.width = '<?=120+$row*120+20 ?>px';
    } else {
        document.body.style.width = width + 'px';
    }
    // 待機マーク
    $(function() {
        //ページの読み込みが完了したのでアニメーションはフェードアウトさせる
        $("#loading").fadeOut();
        //ページの表示準備が整ったのでコンテンツをフェードインさせる
        $("#table1").fadeIn();
    });
    getCELL();
    // シフト編集モードのセット
    if (getCookie("edit") == 1) {
        for(i=1; i<=18; i++) {
            document.getElementById("OrderDetail"+i).style.display = 'none';
        }
    } else {
        for(i=1; i<=18; i++) {
            document.getElementById("OrderDetail"+i).style.display = 'table-row';
        }
    }
}
</script>
<script>
// カレンダー月指定
function setCalendar(year, month) {
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
        for(i=1; i<=18; i++) {
            document.getElementById("OrderDetail"+i).style.display = 'table-row';
            document.cookie = "edit=0;";
        }
        //target.innerHTML = '<span>シフト編集</span>';
    } else {
        for(i=1; i<=18; i++) {
            document.getElementById("OrderDetail"+i).style.display = 'none';
            document.cookie = "edit=1;";
        }
        //target.innerHTML = '<span>全表示</span>';
    }
}
// クッキーの取得
function getCookie(key) {
　// Cookieから値を取得する
　var cookieString = document.cookie;

　// 要素ごとに ";" で区切られているので、";" で切り出しを行う
　var cookieKeyArray = cookieString.split(";");

　// 要素分ループを行う
　for (var i=0; i<cookieKeyArray.length; i++) {
　　var targetCookie = cookieKeyArray[i];

　　// 前後のスペースをカットする
　　targetCookie = targetCookie.replace(/^\s+|\s+$/g, "");

　　var valueIndex = targetCookie.indexOf("=");
　　if (targetCookie.substring(0, valueIndex) == key) {
　　　// キーが引数と一致した場合、値を返す
　　　return unescape(targetCookie.slice(valueIndex + 1));
　　}
　}

　return "";
}
// クッキーを削除する関数
function deleteCookie( $cookieName ){
    // 過ぎた有効期限を設定することで削除できる
    document.cookie = $cookieName + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT"; 
}

</script>
<script language="javascript">
function getCELL() {
 var myTbl = document.getElementById('table1');
    // trをループ。rowsコレクションで,行位置取得。
　for (var i=0; i<myTbl.rows.length; i++) {
     // tr内のtdをループ。cellsコレクションで行内セル位置取得。
    for (var j=0; j<myTbl.rows[i].cells.length; j++) {
    var Cells=myTbl.rows[i].cells[j]; //i番行のj番列のセル "td"
　       // onclickで 'Mclk'を実行。thisはクリックしたセル"td"のオブジェクトを返す。
    Cells.onclick =function(){Mclk(this);}
    Cells.ondblclick =function(){Mdblclk(this);}
　  }
　 }
　}
function Mclk(Cell) { 
 var rowINX = '行位置：'+Cell.parentNode.rowIndex;//Cellの親ノード'tr'の行位置
 var cellINX = 'セル位置：'+Cell.cellIndex;
 var cellVal = 'セルの内容：'+Cell.innerHTML;
  var cellDivNum = 'セル内のDivの数：'+Cell.getElementsByTagName("DIV").length;
  var divs = "";
 for(i=0; i<Cell.getElementsByTagName("DIV").length; i++) {
    if (i == 0) {
         divs = Cell.getElementsByTagName("DIV")[0].id;
    } else {
         divs = divs + "," + Cell.getElementsByTagName("DIV")[i].id;       
     }
 }
    //alert("移動確定!");
 //console.log('ID:'+divs);
 var cellDivIDs = 'セル内のDivのID：'+divs;
    //取得した値の書き出し
    res=rowINX + '<br/> '+ cellINX + '<br/>' + cellVal + '<br/>' + cellDivNum + '<br/>' + cellDivIDs;
      document.getElementById('Mbox0').innerHTML=res;
       var Ms1=document.getElementById('Mbox1')
        Ms1.innerText=Cell.innerHTML;
        Ms1.textContent=Cell.innerHTML;
}
var startrow = 24;
function Mdblclk(Cell) {
    if (Cell.parentNode.rowIndex < startrow || Cell.cellIndex < 1) {
        return false;
    }
    // class名が「redips-drag t1」以外ならばNG
    if (Cell.getAttribute("class") == "redips-mark") {
        return false;
    }
    //Cell.innerHTML += '<div id="d2" class="redips-drag t1" style="border-style: solid; cursor: move;">加藤愛子</div>';
    window.open('<?=ROOTDIR ?>/ShiftManagement/select/0/0/'+(Cell.parentNode.rowIndex-(startrow-1))+'/'+(Cell.cellIndex)+'?date=<?=$year.'-'.$month ?>','スタッフ選択','width=800,height=600,scrollbars=yes');
}
      // try ～ catch 例外処理、エラー処理
      // イベントリスナーaddEventListener,attachEventメソッド
/**
try{
 window.addEventListener("load",getCELL,false);
     }catch(e){
   window.attachEvent("onload",getCELL);
  }
**/
</script>
<script>
function doAccount(year, month, mode) {
    var myTbl = document.getElementById('table1');
    var form = document.getElementById('form');
    //var form = document.createElement('form');
    //document.body.appendChild(form);
    var input = document.createElement('input');
    input.setAttribute('type', 'hidden');
    input.setAttribute('name', 'month');
    input.setAttribute('value', year+"-"+month+"-01");
    form.appendChild(input);
    // データ列数
    var input = document.createElement('input');
    input.setAttribute('type', 'hidden');
    input.setAttribute('name', 'row');
    input.setAttribute('value', <?=$row ?>);
    form.appendChild(input);
    // シフト編集モード
    var input = document.createElement('input');
    input.setAttribute('type', 'hidden');
    input.setAttribute('name', 'edit');
    if (document.getElementById("OrderDetail1").style.display == 'none') {
        input.setAttribute('value', 1);
    } else {
        input.setAttribute('value', 0); 
    }
    form.appendChild(input);
    
    // 保存モードの場合
    if (mode == 1) {
        var input = document.createElement('input');
        input.setAttribute('type', 'hidden');
        input.setAttribute('name', 'mode');
        input.setAttribute('value', 1);
        form.appendChild(input);
        for (var i=startrow; i<myTbl.rows.length; i++) {
            for (var j=1; j<myTbl.rows[i].cells.length; j++) {
                var val = [];
                Cell = myTbl.rows[i].cells[j];

                if (Cell.innerHTML.length == 0) {
                    continue;
                }
                for(k=0; k<Cell.getElementsByTagName("DIV").length; k++) {
                    if (k == 0) {
                        val = Cell.getElementsByTagName("DIV")[0].id;
                    } else {
                        val = val + "," + Cell.getElementsByTagName("DIV")[k].id;
                    }
                }
                if (val.length > 0) {
                    var input = document.createElement('input');
                    input.setAttribute('type', 'hidden');
                    input.setAttribute('name', (i-(startrow-1))+'_'+(j));
                    input.setAttribute('value', val);
                    form.appendChild(input);
                }
            }
        }
    }
    form.setAttribute('action', '<?=ROOTDIR ?>/ShiftManagement/test2');
    form.setAttribute('method', 'post');
    form.submit();
}
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
<script src="<?=ROOTDIR ?>/js/jquery-hex-colorpicker.js"></script>
<link rel="stylesheet" href="<?=ROOTDIR ?>/css/jquery-hex-colorpicker.css" />

<script>
$(document).ready(function() {
  $(".demo").hexColorPicker();
});
</script>
<style>
    .redips-drag t1 {
        text-align: center;
    }    
</style>
<style>
#loading{
    position:absolute;
    left:50%;
    top:40%;
    margin-left:-30px;
}
</style>
<style type="text/css" media="screen">
  div.scroll_div { 
      overflow: auto;
      height: 500px;
      width: auto;
      margin-top: 5px;
  }
</style>

<div id="loading"><img src="<?=ROOTDIR ?>/img/loading.gif"></div>
<div style="width:<?=setWidth($row) ?>px;margin-top: 0px;<?=$font_normal ?>;">
    <?php echo $this->Form->create('WorkTable', array('name'=>'frm', 'id'=>'form')); ?> 
    <table border='1' cellspacing="0" cellpadding="3" style="width:95%;margin-top: -5px;border-spacing: 0px;background-color: white;">
            <tr align="center">
                    <td style=''><a href="<?=ROOTDIR ?>/ShiftManagement/test2?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' -1 month')); ?>">&lt; 前の月</a></td>
                    <td style='background-color: #006699;color: white;'>
                        <font style='font-size: 110%;'>【<?php echo $y ?>年<?php echo $m ?>月 稼働表】</font>
                    </td>
                    <td style=''><a href="<?=ROOTDIR ?>/ShiftManagement/test2?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' +1 month')); ?>">次の月 &gt;</a></td>
            </tr>
    </table>
        
    <div id="redips-drag" style="margin-top: 5px;margin-bottom: 10px;">  
        <!-- 職種入力 -->   
        <table border='1' cellspacing="0" cellpadding="5" id="table1"
               style="width:<?=120+$row*120 ?>px;margin-top: 0px;margin-bottom: 10px;border-spacing: 0px;table-layout: fixed;" _fixedhead="rows:2; cols:1">
            <colgroup> 
              <col style='width:25px;'>
              <col style='width:95px;'>
              <?php for ($count=0; $count<$row; $count++){ ?>
              <col style='width:120px;'>
              <?php } ?>
            </colgroup>
            <thead>
            <tr>
                <th style='background:#99ccff;text-align: center;width:120px;' colspan="2">
                    <a href="#" onclick="setHidden();">
                        <span id="ActiveDisplay" onclick="">シフト編集</span>
                    </a>
                </th>
                <?php foreach ($datas as $key=>$data){ ?>
                <th class="demo" style='background:#99ccff;text-align: center;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo $getCasename[$data['OrderCalendar']['case_id']]; ?>
                </th>
                <?php } ?>
            </tr>
            </thead>
            <tbody style="overflow: auto;">
            <tr style="">
                <td class="redips-trash" style='background-color: #999999;color: white;' colspan="2">削除</td>
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td class="redips-trash" style='background-color: #999999;color: white;'>
                    <?php echo $count+1; ?>
                    <?php echo $this->Form->input('WorkTable.'.($count+1).'.case_id',array('type'=>'hidden', 'value'=>setData($datas2,'case_id',$count,$record))); ?>
                    <?php echo $this->Form->input('WorkTable.'.($count+1).'.order_id',array('type'=>'hidden', 'value'=>setData($datas2,'order_id',$count,$record))); ?>
                    <?php echo $this->Form->input('WorkTable.'.($count+1).'.shokushu_num',array('type'=>'hidden','value'=>setData($datas2,'shokushu_num',$count,$record))); ?>
                    <?php echo $this->Form->input('WorkTable.'.($count+1).'.username', array('type'=>'hidden', 'value' => $username)); ?>
                    <?php echo $this->Form->input('WorkTable.'.($count+1).'.class', array('type'=>'hidden', 'value' => $selected_class)); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail1">
                <td style='background-color: #e8ffff;' colspan="2">事業主</td>
                <?php foreach ($datas as $data){ ?>
                <td style='background:#ffffcc;text-align: center;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo NZ($list_entrepreneur[$data['OrderCalendar']['case_id']]); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail2">
                <td style='background-color: #e8ffff;' colspan="2">販売会社</td>
                <?php foreach ($datas as $data){ ?>
                <td style='text-align: center;background-color: white;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo NZ($list_client[$data['OrderCalendar']['case_id']]); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail3">
                <td style='background-color: #e8ffff;' colspan="2">指揮命令者/<br>担当者</td>
                <?php foreach ($datas as $data){ ?>
                <td style='text-align: center;background-color: white;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo NZ($list_director[$data['OrderCalendar']['case_id']]); ?>様
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail4">
                <td style='background-color: #e8ffff;' colspan="2">現場住所</td>
                <?php foreach ($datas as $data){ ?>
                <td style='text-align: center;background-color: white;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo NZ($list_address[$data['OrderCalendar']['case_id']]); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail5">
                <td style='background-color: #e8ffff;' colspan="2">現場連絡先</td>
                <?php foreach ($datas as $data){ ?>
                <td style='text-align: center;background-color: white;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo 'TEL:'.NZ($list_telno[$data['OrderCalendar']['case_id']]); ?><br>
                <?php echo 'FAX:'.NZ($list_faxno[$data['OrderCalendar']['case_id']]); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail6">
                <td style='background-color: #e8ffff;' colspan="2">待ち合わせ</td>
                <?php foreach ($datas as $data){ ?>
                <td style='text-align: center;background-color: white;' colspan="<?=$data[0]['cnt'] ?>">
                    <?php echo $this->Form->input('WorkTable.0.juchuu_cal',
                            array('type'=>'textarea','div'=>false,'label'=>false,'rows'=>2, 'style'=>'text-align: left;width: 95%;')); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail7">
                <td style='background-color: #e8ffff;' colspan="2">請求先担当者</td>
                <?php foreach ($datas as $data){ ?>
                <td style='text-align: center;background-color: white;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo NZ($list_bill[$data['OrderCalendar']['case_id']]); ?>様
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail8">
                <td style='background-color: #e8ffff;' colspan="2">請求書締日</td>
                <?php foreach ($datas as $data){ ?>
                <td style='text-align: center;background-color: white;' colspan="<?=$data[0]['cnt'] ?>">
                <?php echo NZ($list_cutoff[$data['OrderCalendar']['case_id']]); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail9">
                <td style='background-color: #e8ffff;' colspan="2">クリーニング</td>
                <?php foreach ($datas as $data){ ?>
                <td style='text-align: center;background-color: white;' colspan="<?=$data[0]['cnt'] ?>">
                    <?php echo $this->Form->input('WorkTable.0.juchuu_cal',
                            array('type'=>'text','div'=>false,'label'=>false, 'style'=>'text-align: left;')); ?>
                </td>
                <?php } ?>
            </tr>
            <!-- 受注 -->
            <?php $list1 = array('1'=>'時間', '2'=>'日払', '3'=>'月払'); ?>
            <?php $list2 = array('1'=>'有', '0'=>'無'); ?>
            <tr id="OrderDetail10">
                <td rowspan="3" style='background-color: #e8ffff;'></td>
                <td rowspan="2" style='background-color: #e8ffff;'>単価</td>
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td style='background-color: white;'>
                    \ <?php echo $this->Form->input('WorkTable.'.$count.'.kyuuyo_cal',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:90px;text-align: left;')); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail11">
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td style='background-color: white;'>
                    \ <?php echo $this->Form->input('WorkTable.'.$count.'.kyuuyo_cal',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:90px;text-align: left;')); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail12">
                <td rowspan="1" style='background-color: #e8ffff;'>残業／ｈ</td>
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td style='background-color: white;'>
                    \ <?php echo $this->Form->input('WorkTable.'.$count.'.kyuuyo_cal',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:90px;text-align: left;')); ?>
                </td>
                <?php } ?>
            </tr>
            <!-- 受注 END -->
            <!-- 給与 -->
            <tr id="OrderDetail13">
                <td rowspan="4" style='background-color: #e8ffff;'>ス<br>タ<br>ッ<br>フ<br>分</td>
                <td style='background-color: #e8ffff;'>時給</td>
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td style='background-color: white;'>
                    \ <?php echo $this->Form->input('WorkTable.'.$count.'.kyuuyo_cal',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:90px;text-align: left;')); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail14">
                <td style='background-color: #e8ffff;'>基本日給</td>
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td style='background-color: white;'>
                    \ <?php echo $this->Form->input('WorkTable.'.$count.'.kyuuyo_cal',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:90px;text-align: left;')); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail15">
                <td style='background-color: #e8ffff;'>残業／ｈ</td>
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td style='background-color: white;'>
                    \ <?php echo $this->Form->input('WorkTable.'.$count.'.kyuuyo_cal',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:90px;text-align: left;')); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail16">
                <td style='background-color: #e8ffff;'>研修中（時給）</td>
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td style='background-color: white;'>
                    \ <?php echo $this->Form->input('WorkTable.'.$count.'.kyuuyo_cal',
                            array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:90px;text-align: left;')); ?>
                </td>
                <?php } ?>
            </tr>
            <!-- 給与 END -->
            <tr>
                <td style='width:80px;background-color: #e8ffff;' colspan="2" id="message">職種</td>
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td style='background-color: #ffffcc;'>
                    <?php echo $list_shokushu[setData($datas2,'shokushu_id',$count,$record)]; ?>
                    <?php echo setKakko(setData($datas2,'shokushu_memo',$count,$record)); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail17">
                <td style='background-color: #e8ffff;' colspan="2">勤務時間</td>
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td style='background-color: #ffffcc;'>
                    <?php echo setData($datas2,'worktime_from',$count,$record).'～'.setData($datas2,'worktime_to',$count,$record) ?>
                    <?php if (empty($datas2) || empty($datas2[$count])) { ?>
                        <?php echo $this->Form->input('OrderCalendar.'.$count.'.id',array('type'=>'hidden')); ?>
                    <?php } elseif ($datas2[$count]['OrderCalendar']['year'] != $year || $datas2[$count]['OrderCalendar']['month'] != $month) { ?>
                        <?php echo $this->Form->input('OrderCalendar.'.$count.'.id',array('type'=>'hidden')); ?>
                    <?php } else { ?>
                        <?php echo $this->Form->input('OrderCalendar.'.$count.'.id',array('type'=>'hidden', 'value'=>$datas2[$count]['OrderCalendar']['id'])); ?>
                    <?php } ?>
                    <?php echo $this->Form->input('OrderCalendar.'.$count.'.case_id',array('type'=>'hidden','value'=>$datas2[$count]['OrderCalendar']['case_id'])); ?>
                    <?php echo $this->Form->input('OrderCalendar.'.$count.'.order_id',array('type'=>'hidden','value'=>$datas2[$count]['OrderCalendar']['order_id'])); ?>
                    <?php echo $this->Form->input('OrderCalendar.'.$count.'.shokushu_num',array('type'=>'hidden','value'=>$datas2[$count]['OrderCalendar']['shokushu_num'])); ?>
                    <?php echo $this->Form->input('OrderCalendar.'.$count.'.username', array('type'=>'hidden', 'value' => $username)); ?>
                    <?php echo $this->Form->input('OrderCalendar.'.$count.'.class', array('type'=>'hidden', 'value' => $selected_class)); ?>
                    <?php echo $this->Form->input('OrderCalendar.'.$count.'.year',array('type'=>'hidden','value'=>$year)); ?>
                    <?php echo $this->Form->input('OrderCalendar.'.$count.'.month',array('type'=>'hidden','value'=>$month)); ?>
                    <?php echo $this->Form->input('OrderCalendar.'.$count.'.work_time_memo',
                        array('type'=>'textarea','div'=>false,'label'=>false,'style'=>'width:100px;text-align: left;background-color: #ffffcc;', 'rows'=>2)); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="OrderDetail18">
                <td style='background-color: #e8ffff;' colspan="2">休憩時間</td>
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td style='background-color: #ffffcc;'>
                    <?php echo setData($datas2,'resttime_from',$count,$record); ?>&nbsp;～
                    <?php echo setData($datas2,'resttime_to',$count,$record); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="">
                <td style='background-color: #e8ffff;' colspan="2">推奨スタッフ</td>
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td style='background-color: #ffffcc;'>
                    <?php echo setArray($list_staffs[$datas2[$count]['OrderCalendar']['order_id']][$datas2[$count]['OrderCalendar']['shokushu_num']]); ?>
                </td>
                <?php } ?>
            </tr>
            <tr id="">
                <td style='background-color: #e8ffff;' colspan="2">前月スタッフ</td>
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td style='background-color: #ffffcc;'>
                    <?php echo setRecoStaff($count, $list_recommend); ?>
                </td>
                <?php } ?>
            </tr>
            <tr>
                <!-- カレンダー月指定 -->
                <td rowspan="1" align="center" style='background-color: #e8ffff;' colspan="2">
                    <?php
                        $year_arr = array();
                        $year_arr = array('1999'=>'1999');
                        for($j=2000; $j<2100; $j++) {
                            $year_arr += array($j => $j); 
                        }
                    ?>
                    <?php echo $this->Form->input(false, array('id'=>'year', 'type'=>'select','div'=>false,'label'=>false, 'options' => $year_arr,
                        'value'=>$year, 'style'=>'text-align: left;', 
                        'onchange'=>'setCalendar(this, document.getElementById("month"))')); ?>年<br>
                        <a href="<?=ROOTDIR ?>/ShiftManagement/test2?date=<?=date('Y-m', strtotime($y .'-' . $m . ' -1 month')); ?>">▲</a>
                    <?php $month_arr = array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','11'=>'11','12'=>'12'); ?>
                    <?php echo $this->Form->input(false, array('id'=>'month', 'type'=>'select','div'=>false,'label'=>false, 'options' => $month_arr,
                        'value'=>$month, 'style'=>'text-align: right;', 'onchange'=>'setCalendar(document.getElementById("year"), this)')); ?>月
                        <a href="<?=ROOTDIR ?>/ShiftManagement/test2?date=<?=date('Y-m', strtotime($y .'-' . $m . ' +1 month')); ?>">▼</a>
                </td>
                <!-- カレンダー月指定 END -->
                <?php for ($count=0; $count<$row; $count++){ ?>
                <td align='left' style='background-color: #e8ffff;'>
                    <?php echo $this->Form->input('OrderCalendar.'.$count.'.remarks',
                        array('type'=>'text','div'=>false,'label'=>false,'style'=>'width:100px;text-align: left;', 'rows'=>2)); ?>
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
                    echo '<td align="center" style="color:'.$style.';background-color: #e8ffff;" colspan="2">'.$m.'/'.$d.'('.$weekday[$i].')</td>';
                    if ($i==0 || $i==6) {
                        echo '<input type="hidden" id="HolidayD'.$d.'" value="1">';
                    } else {
                        echo '<input type="hidden" id="HolidayD'.$d.'" value="0">';
                    }
                    for ($count=0; $count<$row; $count++){
                        if (empty($datas2) || empty($datas2[$count])) {
                            $class_name = 'redips-mark';
                        } elseif ($datas2[$count]['OrderCalendar']['d'.$d] == 0) {
                            $class_name = 'redips-mark';
                        } elseif ($datas2[$count]['OrderCalendar']['d'.$d] == 1) {
                            $class_name = '';
                        }
            ?>
                <td id="Cell<?=$count ?>D<?=$d ?>" class="<?=$class_name ?>">
                    <?php if (empty($datas2) || empty($datas2[$count])) { ?>
                    <?php echo ''; ?>
                    <?php } else { ?>
                    <?php //echo $datas2[$count]['OrderCalendar']['d'.$d]; ?>
                    <?php } ?>
                    <?php
                        if (!empty($staff_cell[$d][$count+1])) {
                            if (!empty($data_staffs[$d][$count+1])) {
                                $this->log($data_staffs[$d][$count+1], LOG_DEBUG);
                                foreach($data_staffs[$d][$count+1] as $data_staff) {
                                    echo '<div id="'.$data_staff['StaffMaster']['id'].'" class="redips-drag t1">';
                                    echo $data_staff['StaffMaster']['name_sei'].$data_staff['StaffMaster']['name_mei'];
                                    echo '</div>';
                                }
                            }
                        }
                    ?>
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
<div id="Div" style="display: none;"><p id="Mbox0">セルをクリックしたらここに書き出します。</p>
 <p id="Mbox1">インデックス値は '0'から始まります。</p>
</div>
    
    <div style='margin-left: 10px;'>
<button type="button" id="button-create" onclick="doAccount(<?=$y ?>,<?=sprintf("%02d", $m) ?>, 1);">保存</button>
    &nbsp;&nbsp;
<?php print($this->Form->submit('確定する', array('id'=>'button-create', 'name'=>'save','div' => false))); ?>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php print($this->Html->link('前回保存時まで戻す', 'javascript:void(0);', array('id'=>'button-delete', 'style'=>'' , 'onclick'=>'window.location.reload();'))); ?>
    &nbsp;&nbsp;
<?php print($this->Html->link('ページを戻る', 'javascript:void(0);', array('id'=>'button-delete', 'style'=>'padding:8px;', 
    'onclick'=>'deleteCookie("edit");location.href="'.ROOTDIR.'/ShiftManagement/index"'))); ?>
    </div>
<div style="margin-top: 5px;">
    ※「前回保存時まで戻す」は、保存していない分をキャンセルすることを指す。[F5]でも同様の動作をします。
</div>
<?php echo $this->Form->end(); ?>  
</div>