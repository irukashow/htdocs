<?php
    echo $this->Html->script('redips-drag-min');
    echo $this->Html->script('script');
    echo $this->Html->script('fixed_midashi');
    //echo $this->Html->script('header');
    echo $this->Html->css('style_1');
?>
<?php require('calender.ctp'); ?>
<?php
    function setID($id) {
        echo '<input type="hidden" id="'.$id.'" name="'.$id.'">';
    }

?>
<script>
onload = function() {
    FixedMidashi.create();
    REDIPS.drag.dropMode = 'multiple';
    
    $(function() {
        //ページの読み込みが完了したのでアニメーションはフェードアウトさせる
        $("#loading").fadeOut();
        //ページの表示準備が整ったのでコンテンツをフェードインさせる
        $("#table1").fadeIn();
    });
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
function Mdblclk(Cell) {
    if (Cell.parentNode.rowIndex < 2 || Cell.cellIndex < 1) {
        return false;
    }
    //Cell.innerHTML += '<div id="d2" class="redips-drag t1" style="border-style: solid; cursor: move;">加藤愛子</div>';
    window.open('<?=ROOTDIR ?>/ShiftManagement/select/0/0/'+(Cell.parentNode.rowIndex-1)+'/'+(Cell.cellIndex-1)+'?date=<?=$month ?>','スタッフ選択','width=800,height=600,scrollbars=yes');
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
function doAccount(year, month) {
    var myTbl = document.getElementById('table1');
    //var form = document.getElementById('form');
    var form = document.createElement('form');
    document.body.appendChild(form);
    var input = document.createElement('input');
    input.setAttribute('type', 'hidden');
    input.setAttribute('name', 'month');
    input.setAttribute('value', year+"-"+month+"-01");
    form.appendChild(input);

    for (var i=2; i<myTbl.rows.length; i++) {
        for (var j=2; j<myTbl.rows[i].cells.length; j++) {
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
                input.setAttribute('name', (i-1)+'_'+(j-1));
                input.setAttribute('value', val);
                form.appendChild(input);
            }
        }
    }
    form.setAttribute('action', '<?=ROOTDIR ?>/ShiftManagement/test');
    form.setAttribute('method', 'post');
    form.submit();
}
function setZero2(value) {
    if (value.length == 2) {
        ret = value;
    } else {
        ret = "0"+value;
    }
    return ret;
}
</script>
<style>
    .redips-drag t1 {
        text-align: center;
    }    
</style>
<style>
    .tag {
        text-align: center;
        border:1px solid black;
        background-color: #ffffcc;
        padding: 3px;
        width:100px;
        border-radius: 5px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
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
      height: 600px;
      width: auto;
      margin-top: 5px;
  }
</style>

<div id="loading"><img src="<?=ROOTDIR ?>/img/loading.gif"></div>
<!-- 見出し１ -->
<div id='headline' style="padding:10px 10px 10px 10px;font-family: Meiryo, メイリオ,'lucida grande',verdana,helvetica,arial,sans-serif;">
    ★ 勤務管理
    &nbsp;&nbsp;
    <a href="<?=ROOTDIR ?>/ShiftManagement/index" target="" onclick=''><font Style="font-size:95%;">スタッフシフト希望</font></a>
    &nbsp;
    <a href="<?=ROOTDIR ?>/ShiftManagement/schedule" target="" onclick=''><font Style="font-size:95%;">稼働表</font></a>        <!-- alert("制作中");return false; -->
    &nbsp;
    <a href="<?=ROOTDIR ?>/ShiftManagement/uri9" target=""><font Style="font-size:95%;">勤務実績</font></a>
    &nbsp;
    <b><font Style="font-size:95%;color: yellow;">[稼働表技術テスト]</font></b>
</div>
<!-- 見出し１ END -->

<?php echo $this->Form->create('WorkTable'); ?>
<table border='1' cellspacing="0" cellpadding="3" style="width:100%;margin-top: 10px;border-spacing: 0px;background-color: white;">
        <tr align="center">
                <td style=''><a href="<?=ROOTDIR ?>/ShiftManagement/test?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' -1 month')); ?>">&lt; 前の月</a></td>
                <td style='background-color: #006699;color: white;'>
                    <font style='font-size: 110%;'>【<?php echo $y ?>年<?php echo $m ?>月】</font>
                </td>
                <td style=''><a href="<?=ROOTDIR ?>/ShiftManagement/test?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' +1 month')); ?>">次の月 &gt;</a></td>
        </tr>
</table>

<!-- tables inside this DIV could have draggable content -->
<!-- <div id="redips-drag" style="width: 5000px;"> -->
    <div id="redips-drag" style="width: 5000px;">
        <table id="table1" style="margin-top: 5px;margin-bottom: 0px;" _fixedhead="rows:2; cols:2"> <!--  _fixedhead="rows:2; cols:2" -->
            <colgroup>
                <col width="100"/><col width="100"/><col width="100"/><col width="100"/><col width="100"/>
                <col width="100"/><col width="100"/><col width="100"/><col width="100"/><col width="100"/>
                <col width="100"/><col width="100"/><col width="100"/><col width="100"/><col width="100"/>
                <col width="100"/><col width="100"/><col width="100"/><col width="100"/><col width="100"/>
                <col width="100"/><col width="100"/><col width="100"/><col width="100"/><col width="100"/>
            </colgroup>
            <tr>
                <td class="redips-mark" rowspan="2" style="width: 50px;" id="message">日付</td>
                <td class="redips-trash" rowspan="2" style="width: 50px;background-color: gray;color: white;">削除</td>
                <td class="redips-mark" colspan="2" style="height: 30px;">案件A</td>
                <td class="redips-mark" colspan="3" style="height: 30px;">案件B</td>
                <td class="redips-mark" colspan="6" style="height: 30px;">案件C</td>
                <td class="redips-mark" colspan="6" style="height: 30px;">案件C</td>
            </tr>
            <tr> 
                <td class="redips-mark" style="height: 30px;width: 50px;">受付（土日祝）</td>
                <td class="redips-mark" style="height: 30px;width: 50px;">受付（平日）</td>
                <td class="redips-mark" style="height: 30px;width: 50px;">受付（土日祝）</td>
                <td class="redips-mark" style="height: 30px;width: 50px;">受付（土日祝）</td>
                <td class="redips-mark" style="height: 30px;width: 50px;">保育</td>
                <td class="redips-mark" style="height: 30px;width: 50px;">受付（土日祝）</td>
                <td class="redips-mark" style="height: 30px;width: 50px;">受付（土日祝）</td>
                <td class="redips-mark" style="height: 30px;width: 50px;">受付（平日）</td>
                <td class="redips-mark" style="height: 30px;width: 50px;">受付（土日祝）</td>
                <td class="redips-mark" style="height: 30px;width: 50px;">受付（土日祝）</td>
                <td class="redips-mark" style="height: 30px;width: 50px;">保育</td>
                <td class="redips-mark" style="height: 30px;width: 50px;">受付（土日祝）</td>
                <td class="redips-mark" style="height: 30px;width: 50px;">受付（土日祝）</td>
                <td class="redips-mark" style="height: 30px;width: 50px;">受付（平日）</td>
                <td class="redips-mark" style="height: 30px;width: 50px;">受付（土日祝）</td>
                <td class="redips-mark" style="height: 30px;width: 50px;">受付（土日祝）</td>
                <td class="redips-mark" style="height: 30px;width: 50px;">保育</td>
            </tr>
        <?php
            // 曜日の配列作成
            $weekday = array( "日", "月", "火", "水", "木", "金", "土" );
            // 1日の曜日を数値で取得
            $fir_weekday = date( "w", mktime( 0, 0, 0, $m, 1, $y ) );
            // 1日の曜日設定
            $i = $fir_weekday; // カウント値リセット
            
            // 今月の日付が存在している間ループする
            for( $d=1; checkdate( $m, $d, $y ); $d++ ){
                //曜日の最後まできたらカウント値（曜日カウンター）を戻して行を変える
                if( $i > 6 ){
                    $i = 0;
                }
            //-------------スタイルシート設定-----------------------------------
                if( $i == 0 ){ //日曜日の文字色
                    $style = "#ffccff";
                }
                else if( $i == 6 ){ //土曜日の文字色
                    $style = "#ccffff";
                }
                else{ //月曜～金曜日の文字色
                    $style = "white";
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
            //-------------行の背景色の設定-----------------------------------
                if ($d%2 == 1) {
                    $bgclr = 'background-color: #eee;';
                } else {
                    $bgclr = '';
                }
            //-------------行の背景色の設定 END-------------------------------
                
        ?>
            <tr style="<?=$bgclr ?>">
                <td class="redips-mark" style="color:<?=$style ?>;"><?=$m ?>/<?=$d ?>(<?=$weekday[$i] ?>)</td>
                <td style="height: 30px;"></td>
                <?php for($j=1; $j<=17; $j++) { ?>
                <td>
                    <?php
                        if (!empty($staff_cell[$d][$j])) {
                            if (!empty($data_staffs[$d][$j])) {
                                $this->log($data_staffs[$d][$j], LOG_DEBUG);
                                foreach($data_staffs[$d][$j] as $data_staff) {
                                    echo '<div id="'.$data_staff['StaffMaster']['id'].'" class="redips-drag t1">';
                                    echo '<input type="hidden" name="data[WorkTable]['.$j.'][id]">';
                                    echo '<input type="hidden" name="data[WorkTable]['.$j.'][class]" value="'.$selected_class.'">';
                                    echo '<input type="hidden" name="data[WorkTable]['.$j.'][column]" id="column" value="'.$j.'">';
                                    echo '<input type="hidden" name="data[WorkTable]['.$j.'][work_date]" value="'.$y.'-'.$m.'-'.$d.'">';
                                    echo '<input type="hidden" name="data[WorkTable]['.$j.'][d'.$d.'][]" value="'.$data_staff['StaffMaster']['id'].'">';
                                    echo '<input type="hidden" name="data[WorkTable]['.$j.'][username]" value="'.$username.'">';
                                    echo $data_staff['StaffMaster']['name_sei'].$data_staff['StaffMaster']['name_mei'];
                                    echo '</div>';
                                }
                            }
                        }
                    ?>
                </td>
                <?php } ?>
            </tr>
            <?php
                    $i++; //カウント値（曜日カウンター）+1
                } 
            ?>
    </table>

</div>

<div id="Div"><p id="Mbox0">セルをクリックしたらここに書き出します。</p>
 <p id="Mbox1">インデックス値は '0'から始まります。</p>
</div>

    <div style='margin-top: 10px;margin-left: 10px;'>
        <button type="button" id="button-create" onclick="doAccount(<?=$y ?>,<?=sprintf("%02d", $m) ?>);return false;">保存</button>
    &nbsp;&nbsp;
<?php print($this->Form->submit('確定する', array('id'=>'button-create', 'name'=>'save','div' => false))); ?>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php print($this->Html->link('前回保存時まで戻す', 'javascript:void(0);', array('id'=>'button-delete', 'style'=>'' , 'onclick'=>'window.location.reload();'))); ?>
    </div>
<div style="margin-top: 5px;">
    ※「前回保存時まで戻す」は、保存していない分をキャンセルすることを指す。[F5]でも同様の動作をします。
</div>
<?php echo $this->Form->end(); ?>

<?php
            print_r($staff_cell);
?>
