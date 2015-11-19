<?php require('holiday.ctp'); ?>
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

    // 祝日取得
    $national_holiday = japan_holiday($y);
?>
<?php
    //echo $this->Html->script( 'tools');
    //echo $this->Html->script('dropzone');
    //echo $this->Html->script('jquery-1.9.1');
    //echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js');
    //echo $this->Html->script('jquery.timepicker');
    echo $this->Html->script('fixed_midashi');
    echo $this->Html->script('jquery.fixedtable');
    if ($flag == 0) {
        echo $this->Html->script('redips-drag-min');
    }
    echo $this->Html->script('script');
    //echo $this->Html->css('evol.colorpicker.min');
    echo $this->Html->css('staffmaster');
    echo $this->Html->css('style_1');
?>

<?php
$font_normal = "font-family: Meiryo, メイリオ,'lucida grande',verdana,helvetica,arial,sans-serif;";
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
            if (empty($value['StaffMaster']['name'])) {
                $ret = '';
                continue;
            }
            if ($key == 0) {
                $ret = $value['StaffMaster']['name'];
            } else {
                $ret = $ret.'<br>'.$value['StaffMaster']['name'];
            }
        }
    }
    return $ret;
}
// 配列を処理する2
function setArray2($array) {
    $ret = '';
    if (empty($array)) {
        return '';
    }
    foreach($array as $key=>$value) {
        if (empty($value)) {
            if ($key == 0) {
                $ret = 's1=';
            } else {
                $ret = $ret.'&s'.($key+1).'=';
            }
        } else {
            if ($key == 0) {
                $ret = 's1='.$value;
            } else {
                $ret = $ret.'&s'.($key+1).'='.$value;
            }
        }
    }

    return $ret;
}
// 前月スタッフ
function setPMStaff($count, $datas) {
    if (empty($datas[$count])) {
        $ret = '';
    } else {
        asort($datas[$count]);
        foreach ($datas[$count] as $value) {
            if (empty($ret)) {
                $ret = $value['StaffMaster']['name'];
            } else {
                $ret = $ret.'<br>'.$value['StaffMaster']['name'];
            }
        }
    }
    return $ret;
}
// 前月スタッフ（隠しデータ）
function setRecoStaff2($count, $datas) {
    if (empty($datas[$count])) {
        $ret = '';
    } else {
        asort($datas[$count]);
        foreach ($datas[$count] as $value) {
            if (empty($ret)) {
                $ret = $value['StaffMaster']['id'];
            } else {
                $ret = $ret.','.$value['StaffMaster']['id'];
            }
        }
    }
    return '<span id="'.$ret.'"></span>';
}
// 指定した職種が含まれるか判定
function chkShokushu($shokushu_id, $list) {
    if (empty($list)) {
        return false;
    }
    $array = explode(',', $list);
    if (array_search($shokushu_id, $array)) {
        return true;
    } else {
        return false;
    }
}
// 空またはNULLの場合、0とする
function setPoint($array, $column) {
    if (is_null($array)) {
        $ret = 0;
    } else {
        if (empty($array[$column])) {
            $ret = 0;
        } else {
            $ret = $array[$column];
        }
    }
    return $ret;
}
// 案件名称の背景色の指定
function setBGColor($case_id, $list_array) {
    $ret = $list_array[$case_id];
    if (empty($ret)) {
        $ret = '99ccff';
    }
    return $ret;
}
// 案件名称の文字色の指定
function setColor($case_id, $list_array) {
    $ret = $list_array[$case_id];
    if (empty($ret)) {
        $ret = 'black';
    }
    return $ret;
}
// 時給（受注）
function setHMoney($count, $data_array) {
    $ret = number_format($data_array[$count]['OrderInfoDetail']['juchuu_money']);
    if ($data_array[$count]['OrderInfoDetail']['juchuu_shiharai'] != 1) {
        $ret = 0;
    }
    return $ret;
}
// 日給（受注）
function setDMoney($count, $data_array) {
    $ret = 0;
    if ($data_array[$count]['OrderInfoDetail']['juchuu_shiharai'] == 1) {
        $ret = number_format($data_array[$count]['OrderInfoDetail']['juchuu_money']*setWorktime($count, $data_array) );
    } elseif ($data_array[$count]['OrderInfoDetail']['juchuu_shiharai'] == 2) {
        $ret = number_format($data_array[$count]['OrderInfoDetail']['juchuu_money']);
    }
    return $ret;
}
// 残業代（受注）
function setZMoney($count, $data_array) {
    $ret = 0;
    if ($data_array[$count]['OrderInfoDetail']['juchuu_shiharai'] == 1) {
        $ret = number_format($data_array[$count]['OrderInfoDetail']['juchuu_money']*1.25);
    }
    return $ret;
}
// 売上見込み合計	
function setUriSum($count, $data_array, $kadou_num) {
    $ret = number_format(str_replace(',', '', setDMoney($count, $data_array))*$kadou_num);
    return $ret;
}
// 日給（給与）
function setDMoney2($count, $data_array) {
    $ret = 0;
    if ($data_array[$count]['OrderInfoDetail']['kyuuyo_shiharai'] == 1) {
        $ret = number_format($data_array[$count]['OrderInfoDetail']['kyuuyo_money']*setWorktime($count, $data_array));
    } elseif ($data_array[$count]['OrderInfoDetail']['kyuuyo_shiharai'] == 2) {
        $ret = number_format($data_array[$count]['OrderInfoDetail']['kyuuyo_money']);
    }
    return $ret;
}
// 時給（給与）
function setHMoney2($count, $data_array) {
    $ret = 0;
    if ($data_array[$count]['OrderInfoDetail']['kyuuyo_shiharai'] == 1) {
        $ret = number_format($data_array[$count]['OrderInfoDetail']['kyuuyo_money']);
    }
    return $ret;
}
// 残業代（給与）
function setZMoney2($count, $data_array) {
    $ret = 0;
    if ($data_array[$count]['OrderInfoDetail']['kyuuyo_shiharai'] == 1) {
        $ret = number_format($data_array[$count]['OrderInfoDetail']['kyuuyo_money']*1.25);
    }
    return $ret;
}
// 研修中（給与）
function setTrMoney2($count, $data_array) {
    $ret = 0;
    if (is_null($data_array[$count]['OrderCalender']['staff_money_tr'])) {
        $ret = '1,000';
    } else {
        $ret = number_format(str_replace(',', '', $data_array[$count]['OrderCalender']['staff_money_tr']));
    }
    return $ret;
}
// 人件費見込み合計	
function setJinkenhiSum($count, $data_array, $kadou_num) {
    $ret = number_format(str_replace(',', '', setDMoney2($count, $data_array))*$kadou_num);
    return $ret;
}
// 今月の売上見込み
function setUriMSum($col, $data_array, $kadou_num) {
    $ret = 0;
    for ($count=0; $count<$col; $count++) {
        $ret += str_replace(',', '', setDMoney($count, $data_array))*$kadou_num;
    }
    return number_format($ret);
}
// 人件費見込み合計

// 実働労働時間
function setWorktime($count, $data_array) {
    // 値の取得
    $worktime_from = $data_array[$count]['OrderInfoDetail']['worktime_from'];
    $worktime_to = $data_array[$count]['OrderInfoDetail']['worktime_to'];
    $resttime_from = $data_array[$count]['OrderInfoDetail']['resttime_from'];
    $resttime_to = $data_array[$count]['OrderInfoDetail']['resttime_to'];
    // 空ならば抜ける
    if (empty($worktime_from) || empty($worktime_to) || empty($resttime_from) || empty($resttime_to)) {
        return '0';
    }
    // 勤務時間
    $worktime_from2 = explode(':', $worktime_from);
    $worktime_to2 = explode(':', $worktime_to);
    // 休憩時間
    $resttime_from2 = explode(':', $resttime_from);
    $resttime_to2 = explode(':', $resttime_to);
    
    $ret = $worktime_to2[0] + abs($worktime_to2[1])/60 - $worktime_from2[0] - abs($worktime_from2[1])/60;
    $ret = $ret - ($resttime_to2[0] + abs($resttime_to2[1])/60 - $resttime_from2[0] - abs($resttime_from2[1])/60);
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
    function setWidth($col) {
        $width = 1200;
        if (120+$col*120+20 > $width) {
            $ret = 120+$col*120+20;
        } else {
            $ret = $width;
        } 
        return $ret;
    }
/*
 * BR タグを改行コードに変換する
 */
function br2nl($string) {
    // 大文字・小文字を区別しない
    return preg_replace('/<br[[:space:]]*\/?[[:space:]]*>/i', "\n", $string);
}
?>
<?php
    if ($flag == 0) {
        $disabled = '';
        $button_type2 = 'button-create';
        $button_type3 = 'button-release';
    } else {
        $disabled = 'disabled';
        $button_type2 = 'button-delete';
        $button_type3 = 'button-delete';
    }
?>
<?php
    // 確定表示
    function displayCommit($flag) {
        if ($flag == 1) {
            $ret = "確定";
        } else {
            $ret = "未確定";
        }
        return $ret;
    }
    // 確定スタイル
    function commitStyle($flag) {
        if ($flag == 1) {
            $color = 'background-color:#ff0000;color:white;';
        } else {
            $color = 'background-color:#006699;color:white;';
        }
        return $color;
    }
?>

<script>
onload = function() {
    //FixedMidashi.create();
    //var width = 1200;
    // ヘッダを隠す
    <?php
        if ($flag == 0) {
            $width_extra = 120*3;
        } else {
            $width_extra = 0;
        }
    ?>
    document.getElementById("header").style.display = 'none';
    document.getElementById("footer").style.display = 'none';
    var width = <?=120+$col*120+count($datas)*50+$width_extra+30 ?>;
    if (width > 1200) {
        document.body.style.width = '<?=120+$col*120+count($datas)*50+$width_extra+30 ?>px';
    } else {
        document.body.style.width = '1300px';
    }
    document.getElementById("headline").style.width = '1200px';
    document.getElementById("menu_table").style.width = '1200px';
    /**
    if (120+<?=$col ?>*120+20 > width) {
        document.body.style.width = '<?=120+$col*120+20 ?>px';
    } else {
        document.body.style.width = width + 'px';
    }
        **/
    // 待機マーク
    $(function() {
        /**
        //ページの読み込みが完了したのでアニメーションはフェードアウトさせる
        $("#loading").fadeOut();
        //ページの表示準備が整ったのでコンテンツをフェードインさせる
        $("#table1").fadeIn();
        **/
    });
    //getCELL();
    edit = getCookie("edit");
    // シフト編集モードのセット
    if (edit == 1) {
        for(i=0; i<=29; i++) {
            document.getElementById("OrderDetail"+i).style.display = 'none';
            //document.getElementById("OrderDetail0_"+i).style.display = 'none';
        }
    } else {
        for(i=0; i<=29; i++) {
            document.getElementById("OrderDetail"+i).style.display = 'table-row';
            //document.getElementById("OrderDetail0_"+i).style.display = 'table-row';
        }
    }
    REDIPS.drag.dropMode = 'multiple';
}
</script>
<script>
// カレンダー月指定
function setCalender(year, month) {
    var options1 = year.options;
    var value1 = options1[year.options.selectedIndex].value;
    var options2 = month.options;
    var value2 = options2[month.options.selectedIndex].value;
    location.href="<?=ROOTDIR ?>/ShiftManagement/schedule?date=" +value1 + "-" + value2;
}
// 職種の詳細を隠す
function setHidden() {
    target = document.getElementById("ActiveDisplay");
    if (document.getElementById("OrderDetail1").style.display == 'none') {
        for(i=0; i<=29; i++) {
            var id1 = "OrderDetail"+i;
            //var id2 = "OrderDetail0_"+i;
            document.getElementById(id1).style.display = 'table-row'; 
            //document.getElementById(id2).style.display = 'table-row'; 
        }
        deleteCookie("edit");
        document.cookie = "edit=0;";
        //target.innerHTML = '<span>シフト編集</span>';
    } else {
        for(i=0; i<=29; i++) {
            var id1 = "OrderDetail"+i;
            //var id2 = "OrderDetail0_"+i;
            document.getElementById(id1).style.display = 'none';
            //document.getElementById(id2).style.display = 'none';
        }
        deleteCookie("edit");
        document.cookie = "edit=1;";
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
// スタッフプロフページ
function getStaffProf(staff_id) {
    //window.open("<?=ROOTDIR?>/StaffMasters/index/0/" + staff_id +"/profile","スタッフ登録","width=1200,height=900,scrollbars=yes");
}
</script>
<script language="javascript">
function getCELL() {
    if (<?=$flag ?> == 1) {
        return false;
    }
 var myTbl = document.getElementById('table1');
    // trをループ。rowsコレクションで,行位置取得。
　for (var i=0; i<myTbl.rows.length; i++) {
     // tr内のtdをループ。cellsコレクションで行内セル位置取得。
    for (var j=0; j<myTbl.rows[i].cells.length; j++) {
    var Cells=myTbl.rows[i].cells[j]; //i番行のj番列のセル "td"
　       // onclickで 'Mclk'を実行。thisはクリックしたセル"td"のオブジェクトを返す。
    //Cells.onclick =function(){Mclk(this);}
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
var startrow = 25;
function Mdblclk(Cell) {
  var divs = "";
 for(i=0; i<Cell.getElementsByTagName("DIV").length; i++) {
    if (i == 0) {
         divs = "&s1=" + Cell.getElementsByTagName("DIV")[0].id;
    } else {
         divs = divs + "&s" + (i+1) + "=" + Cell.getElementsByTagName("DIV")[i].id;       
     }
 }
    if (Cell.parentNode.rowIndex == 0) {
        //location.href = "<?=ROOTDIR ?>/ShiftManagement/setting";
        window.open('<?=ROOTDIR ?>/CaseManagement/reg2/'+Cell.getElementsByTagName("div")[0].id+'/1?date='+Cell.getElementsByTagName("div")[1].id, 
        'オーダー入力','width=1200,height=800,scrollbars=yes');
    } else if (Cell.parentNode.rowIndex < startrow || Cell.parentNode.rowIndex > startrow+31 || Cell.cellIndex < 0) {
        return false;
    }
    // class名が「redips-drag t1」以外ならばNG
    if (Cell.getAttribute("class") == "redips-mark") {
        return false;
    }
    //Cell.innerHTML += '<div id="d2" class="redips-drag t1" style="border-style: solid; cursor: move;">加藤愛子</div>';
    if (Cell.getElementsByTagName("span")[0].id == '') {
        window.open('<?=ROOTDIR ?>/ShiftManagement/select/0/0/'+(Cell.parentNode.rowIndex-(startrow-1))+'/0'
                +'/'+Cell.getElementsByTagName("span")[1].id+'?date=<?=$year.'-'.$month ?>'+divs,'スタッフ選択','width=800,height=700,scrollbars=yes');
    } else {
        window.open('<?=ROOTDIR ?>/ShiftManagement/select/'+Cell.getElementsByTagName("span")[0].id+'/0/'+(Cell.parentNode.rowIndex-(startrow-1))+'/'+Cell.getElementsByTagName("span")[2].id
                +'/'+Cell.getElementsByTagName("span")[1].id+'?date=<?=$year.'-'.$month ?>'+divs,'スタッフ選択','width=800,height=700,scrollbars=yes');
    }
}
function Mdblclk2(Cell) {
    window.open('<?=ROOTDIR ?>/CaseManagement/reg2/'+Cell.getElementsByTagName("div")[0].id+'/1?date='+Cell.getElementsByTagName("div")[1].id, 
    'オーダー入力','width=1200,height=800,scrollbars=yes');
}
      // try ～ catch 例外処理、エラー処理
      // イベントリスナーaddEventListener,attachEventメソッド
try{
 window.addEventListener("load",getCELL,false);
     }catch(e){
   window.attachEvent("onload",getCELL);
  }
</script>
<script>
/** 保存処理 **/
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
    input.setAttribute('name', 'col');
    input.setAttribute('value', <?=$col ?>);
    form.appendChild(input);
    // フラグ
    var input = document.createElement('input');
    input.setAttribute('type', 'hidden');
    input.setAttribute('name', 'flag');
    input.setAttribute('value', <?=$flag ?>);
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
    
    // 保存モードの場合(mode=1)
    // 保存＆チェックモードの場合(mode=2)
    // 確定の場合(mode=3)
    var input = document.createElement('input');
    input.setAttribute('type', 'hidden');
    input.setAttribute('name', 'mode');
    input.setAttribute('value', mode);
    form.appendChild(input);
    for (var i=startrow; i<myTbl.rows.length; i++) {
        for (var j=1; j<myTbl.rows[i].cells.length; j++) {
            var val = [];
            Cell = myTbl.rows[i].cells[j];
            if (Cell.id == null) {
                continue;
            }
            // spanタグがあって、divタグがないものはエラー（一時保存以外）
            if (mode != 1 && Cell.getElementsByTagName("span").length > 1 && j < myTbl.rows[i].cells.length-3 && Cell.getElementsByTagName("DIV").length == 0) {
                alert("【エラー】"+(i-startrow+1)+"日に埋まっていないシフトが存在します。");
                return;
            }
            // テスト
            //alert(Cell.getElementsByTagName("span")[2].id);
            
            for(k=0; k<Cell.getElementsByTagName("DIV").length; k++) {
                // コピーの文字列を削る
                var str = Cell.getElementsByTagName("DIV")[k].id;
                var index = str.indexOf("c");
                if (index != -1) {
                    str = str.substring(0, index);
                }
                if (k == 0) {
                    val = str;
                } else {
                    val = val + "," + str;
                }
            }
            if (val.length > 0) {
                var input = document.createElement('input');
                input.setAttribute('type', 'hidden');
                input.setAttribute('name', (i-(startrow-1))+'_'+Cell.getElementsByTagName("span")[2].id);
                input.setAttribute('value', val);
                form.appendChild(input);
            }
        }
    }
    form.setAttribute('action', '<?=ROOTDIR ?>/ShiftManagement/schedule');
    form.setAttribute('method', 'post');
    form.submit();
}
// 確定処理
function doCommit(msg, year, month) {
    if (window.confirm(msg)) {
        doAccount(year, month, 3);
    }
    
}
</script>
<script>
$('#help01').mouseover(function() {
  alert("シフトに推奨するスタッフです。");
});
</script>
<script>
    // 売上見込み合計
    function calUri1(source, column) {
        source_yen = source.value;
        r_num = document.getElementById("running_num"+column).value;
        if (source_yen == null || source_yen.length == 0) {
            source_yen = 0;
        }
        cal_result = source_yen*r_num;
        document.getElementById('uri1_'+column).value = separate(cal_result);
    }
    // 人件費見込み合計
    function calJinkenhi1(source, column) {
        source_yen = source.value;
        r_num = document.getElementById("running_num"+column).value;
        if (source_yen == null || source_yen.length == 0) {
            source_yen = 0;
        }
        cal_result = source_yen*r_num;
        document.getElementById('jinkenhi1_'+column).value = separate(cal_result);
    }
    // カンマ入れる
    function separate(num){
        // 文字列にする
        num = String(num);

        var len = num.length;

        // 再帰的に呼び出すよ
        if(len > 3){
            // 前半を引数に再帰呼び出し + 後半3桁
            return separate(num.substring(0,len-3))+','+num.substring(len-3);
        } else {
            return num;
        }
    }
</script>


<!--
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
-->
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
<style type="text/css">
/* 基本のテーブル定義 */
table.t {border:1px solid   #000000;border-collapse:collapse;table-layout:fixed;font-size:16px}
table.t td{border:1px solid #000000;height:16px;}
table.t th{border:1px solid #000000;font-size:16px}
table.t th{background-color:#FFBB88;color:#000000;}
table.t tr:nth-child(odd)  td{background-color:#C8C8E8;color:#000000;}
table.t tr:nth-child(even) td{background-color:#E8E8FF;color:#000000;}
/*
  データ域        90×3+110 = 380
  ＋スクロール域  +16       = 396
  ＋垂直ヘッダ    +90       = 486
  スクロール範囲      (w×h) 280×130
  バー付データ部サイズ(w×h) 296×145  (バー　v16:h15)
  ヘッダを含むサイズ  (w×h) 386×167  (ヘッダ１行18px)
 */
[name="T"] {width:360px;}
[name="T"]  th{width:90px}
[name="T"]  td{width:90px}
[name="T"]  th:nth-child(4){width:110px}
[name="T"]  td:nth-child(4){width:110px}
[name="TV"] th{width:90px}

#header_h {
   position: absolute;left:120px;top:0px;
   width:89.6%;
   overflow-x:hidden;overflow-y:hidden;
   }
#header_v {
   position: absolute;left:0px;top:50px;
   width:122px;
   height:582px; 
   overflow-x:hidden;
   overflow-y:hidden;
   }
#data {
   position: absolute;left:120px;top:50px;
   overflow-x:scroll;overflow-y:scroll;
   width:91%;
   height:600px;
   }
/** schedule3 **/   
#header_h3 {
   position: relative;left:120px;top:0px;
   width:89.6%;
   overflow-x:hidden;overflow-y:hidden;
   }
#header_v3 {
   position: relative;left:0px;top:0px;
   width:122px;
   //height:582px; 
   overflow-x:hidden;
   overflow-y:hidden;
   }
#data3 {
   position: relative;left:120px;top:0px;
   //overflow-x:scroll;overflow-y:scroll;
   overflow-x:hidden;
   overflow-y:hidden;
   width:91%;
   //height:600px;
   }
</style>
<script type="text/javascript">
jQuery(function() {
  // 2ツールチップ機能を適用
  jQuery('#main').tooltip({
      content: function() {
          var name = $(this).data('name');
          return name;
      }
  });
});
</script>
<style>
  .ui-tooltip {
    font-family: Osaka-mono, "Osaka-等幅", "ＭＳ ゴシック", monospace;
    font-size: 90%;
    width: 80px;
    word-wrap: break-word;
    border-radius: 6px;
    background: #FEFFED;
  }
</style>