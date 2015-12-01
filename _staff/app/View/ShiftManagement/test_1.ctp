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
    window.open('<?=ROOTDIR ?>/ShiftManagement/select/0/0/'+Cell.parentNode.rowIndex+'/'+Cell.cellIndex,'スタッフ選択','width=800,height=600,scrollbars=yes');
}
      // try ～ catch 例外処理、エラー処理
      // イベントリスナーaddEventListener,attachEventメソッド
try{
 window.addEventListener("load",getCELL,false);
     }catch(e){
   window.attachEvent("onload",getCELL);
  }
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

<?php echo $this->Form->create('StaffSchedule', array('name' => 'form')); ?>
<table border='1' cellspacing="0" cellpadding="3" style="width:100%;margin-top: 10px;border-spacing: 0px;background-color: white;">
        <tr align="center">
                <td style=''><a href="<?=ROOTDIR ?>/ShiftManagement/schedule?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' -1 month')); ?>">&lt; 前の月</a></td>
                <td style='background-color: #006699;color: white;'><font style='font-size: 110%;'>【<?php echo $y ?>年<?php echo $m ?>月】</font></td>
                <td style=''><a href="<?=ROOTDIR ?>/ShiftManagement/schedule?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' +1 month')); ?>">次の月 &gt;</a></td>
        </tr>
</table>

<!-- tables inside this DIV could have draggable content -->
<div id="redips-drag" style="width: 5000px;">
        <table id="table1" style="margin-top: 5px;margin-bottom: 0px;"> <!--  _fixedhead="rows:2; cols:2" -->
            <colgroup><col width="100"/><col width="100"/><col width="100"/><col width="100"/><col width="100"/></colgroup>
            <tr>
                <td class="redips-mark" rowspan="2" style="width: 50px;">日付</td>
                <td class="redips-trash" rowspan="2" style="width: 50px;background-color: gray;color: white;">削除</td>
                <td class="redips-mark" colspan="2" style="height: 30px;">案件A</td>
                <td class="redips-mark" colspan="3" style="height: 30px;">案件B</td>
                <td class="redips-mark" colspan="6" style="height: 30px;">案件C</td>
                <td class="redips-mark" colspan="6" style="height: 30px;">案件C</td>
            </tr>
            <tr> 
                <td class="redips-mark" style="height: 30px;">受付（土日祝）</td>
                <td class="redips-mark" style="height: 30px;">受付（平日）</td>
                <td class="redips-mark" style="height: 30px;">受付（土日祝）</td>
                <td class="redips-mark" style="height: 30px;">受付（土日祝）</td>
                <td class="redips-mark" style="height: 30px;">保育</td>
                <td class="redips-mark" style="height: 30px;">受付（土日祝）</td>
                <td class="redips-mark" style="height: 30px;">受付（土日祝）</td>
                <td class="redips-mark" style="height: 30px;">受付（平日）</td>
                <td class="redips-mark" style="height: 30px;">受付（土日祝）</td>
                <td class="redips-mark" style="height: 30px;">受付（土日祝）</td>
                <td class="redips-mark" style="height: 30px;">保育</td>
                <td class="redips-mark" style="height: 30px;">受付（土日祝）</td>
                <td class="redips-mark" style="height: 30px;">受付（土日祝）</td>
                <td class="redips-mark" style="height: 30px;">受付（平日）</td>
                <td class="redips-mark" style="height: 30px;">受付（土日祝）</td>
                <td class="redips-mark" style="height: 30px;">受付（土日祝）</td>
                <td class="redips-mark" style="height: 30px;">保育</td>
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
                <td>
                    <?php
                        if (!empty($staff_cell[2][3])) {
                            if (!empty($data_staffs[2][3])) {
                                foreach($data_staffs[2][3] as $data_staff) {
                                    echo '<div id="'.$data_staff['StaffMaster']['id'].'" class="redips-drag t1">'.$data_staff['StaffMaster']['name_sei'].$data_staff['StaffMaster']['name_mei'].'</div>';
                                }
                            }
                        }
                    ?>
                </td>
                <td>
                    <?php
                        if (!empty($staff_cell[2][3])) {
                            if (!empty($data_staffs[2][3])) {
                                foreach($data_staffs[2][3] as $data_staff) {
                                    echo '<div id="'.$data_staff['StaffMaster']['id'].'" class="redips-drag t1">'.$data_staff['StaffMaster']['name_sei'].$data_staff['StaffMaster']['name_mei'].'</div>';
                                }
                            }
                        }
                    ?>
                </td>
                <td>
                    <div id="2_4" class="redips-drag t1" title="999">加藤愛子</div>
                    <?php
                        if (!empty($staff_cell[2][4])) {
                            if (!empty($data_staffs[2][4])) {
                                foreach($data_staffs[2][4] as $data_staff) {
                                    echo '<div id="'.$data_staff['StaffMaster']['id'].'" class="redips-drag t1">'.$data_staff['StaffMaster']['name_sei'].$data_staff['StaffMaster']['name_mei'].'</div>';
                                }
                            }
                        }
                    ?>
                </td>
                <td><div id="d3" class="redips-drag t1">植村麗美</div></td>
                <td>
                    <?php
                        if (!empty($staff_cell[2][6])) {
                            if (!empty($data_staffs[2][6])) {
                                foreach($data_staffs[2][6] as $data_staff) {
                                    echo '<div id="'.$data_staff['StaffMaster']['id'].'" class="redips-drag t1">'.$data_staff['StaffMaster']['name_sei'].$data_staff['StaffMaster']['name_mei'].'</div>';
                                }
                            }
                        }
                    ?> 
                </td>
                <td></td>
                <td><div id="d2" class="redips-drag t1">加藤愛子</div></td>
                <td><div id="d2" class="redips-drag t1">加藤愛子</div></td>
                <td><div id="d2" class="redips-drag t1">加藤愛子</div></td>
                <td><div id="d2" class="redips-drag t1">加藤愛子</div></td>
                <td><div id="d2" class="redips-drag t1">加藤愛子</div></td>
                <td id="here"><div id="d1" class="redips-drag t1">金川聡子</div></td>
                <td></td>
                <td><div id="d2" class="redips-drag t1">加藤愛子</div></td>
                <td><div id="d3" class="redips-drag t1">植村麗美</div></td>
                <td></td>
                <td></td>
            </tr>
            <?php
                    $i++; //カウント値（曜日カウンター）+1
                } 
            ?>
            
            <tr>
                <td>8/2（日）</td>
                <td style="height: 30px;"></td>
                <td><div id="d4" class="redips-drag t1">西尾理沙</div></td>
                <td></td>
                <td></td>
                <td></td>
                <td><div id="d5" class="redips-drag t1">前薗佐知</div></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="background-color: #eee">
                <td class="redips-mark">8/3（月）</td>
                <td style="height: 30px;"></td>
                <td class="redips-mark"></td>
                <td><div id="d6" class="redips-drag t1">松下千尋</div></td>
                <td class="redips-mark"></td>
                <td class="redips-mark"></td>
                <td class="redips-mark"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="redips-mark">8/4（火）</td>
                <td style="height: 30px;"></td>
                <td class="redips-mark"></td>
                <td><div id="d7" class="redips-drag t1">竹内深雪</div></td>
                <td class="redips-mark"></td>
                <td class="redips-mark"></td>
                <td class="redips-mark"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="background-color: #eee">
                <td class="redips-mark">8/5（水）</td>
                <td style="height: 30px;"></td>
                <td class="redips-mark"></td>
                <td><div id="d8" class="redips-drag t1">中畑有紀子</div></td>
                <td class="redips-mark"></td>
                <td class="redips-mark"></td>
                <td class="redips-mark"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <!-- <td><div id="d8" class="redips-drag t1"><img id="smile_img" src="/wp-includes/images/smilies/icon_smile.gif"/></div></td> -->
            </tr>
    </table>
        <table id="table2" style="display: none;">
                <colgroup><col width="100"/><col width="100"/><col width="100"/><col width="100"/><col width="100"/></colgroup>
                <tr>
                        <td class="redips-mark" title="You can not drop here">Table2</td>
                        <td style="background-color: #eee"><div id="d9" class="redips-drag t2">and</div></td>
                        <td rowspan="3" style="background-color: #C6C8CB" title="rowspan 3"></td>
                        <td style="background-color: #eee"></td>
                        <td></td>
                </tr>
                <tr>
                        <td><div id="d10" class="redips-drag t2">Drag</div></td>
                        <td style="background-color: #eee"></td>
                        <td style="background-color: #eee"><div id="d11" class="redips-drag t2">drop</div></td>
                        <td><div id="d12" class="redips-drag t2">table</div></td>
                </tr>
                <tr>
                        <td colspan="2" style="background-color: #C6C8CB" title="colspan 2"></td>
                        <td colspan="2" style="background-color: #C6C8CB" title="colspan 2"></td>
                </tr>
                <tr>
                        <td colspan="2" style="background-color: #C6C8CB" title="colspan 2"></td>
                        <td rowspan="3" style="background-color: #C6C8CB" title="rowspan 3"></td>
                        <td colspan="2" style="background-color: #C6C8CB" title="colspan 2"></td>
                </tr>
                <tr>
                        <td><div id="d13" class="redips-drag t2"><input type="text" style="width: 60px" value="content"/></div></td>
                        <td style="background-color: #eee"></td>
                        <td style="background-color: #eee"></td>
                        <td></td>
                </tr>
                <tr>
                        <td></td>
                        <td style="background-color: #eee"><div id="d14" class="redips-drag t2">with</div></td>
                        <td style="background-color: #eee"><div id="d15" class="redips-drag t2">JavaScript</div></td>
                        <td class="redips-mark smile" title="Only smile can be placed here"></td>
                </tr>
        </table>
        <table id="table3" style="display:none;">
                <colgroup><col width="100"/><col width="100"/><col width="100"/><col width="100"/><col width="100"/></colgroup>
                <tr style="background-color: #eee">
                        <td id="message" class="redips-mark" title="You can not drop here">Table3</td>
                        <!-- jump to smile image -->
                        <td><div id="link1" class="redips-drag t3"><a href="#smile_img" title="Jump to the smile image (links can be used as well)">Smile</a></div></td>
                        <td></td>
                        <td></td>
                        <td><div id="d16" class="redips-drag t3"><input type="checkbox" name="cb1"/><input type="checkbox" name="cb2"/><input type="checkbox" name="cb3"/></div></td>
                </tr>
                <tr>
                        <td></td>
                        <td></td>
                        <td><div id="d17" class="redips-drag t3 redips-clone" title="infinite cloning">Clone</div></td>
                        <td></td>
                        <td></td>
                </tr>
                <tr>
                        <td><div id="d18" class="redips-drag t3 redips-clone climit1_3" title="Clone three elements">(1) Clone</div></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><div id="d19" class="redips-drag t3 redips-clone climit2_2" title="Clone two elements and die">(2) Clone</div></td>
                </tr>
                <tr style="background-color: #eee">
                        <td><div id="d20" class="redips-drag t3"><input type="radio" name="radio1"/><input type="radio" name="radio1"/><input type="radio" name="radio1"/></div></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="redips-trash" title="Trash">Trash</td>
                </tr>
        </table>
        </div>
    <div style="display:none;">
    <div><input type="button" value="cells(1,1)の値" class="button" onclick="alert(document.getElementById('here').innerHTML);" title=""/></div>
        <div><input type="button" value="Save1" class="button" onclick="save('plain')" title="Send content to the server (it will only show accepted parameters)"/><span class="message_line">Save content of the first table (plain query string)</span></div>
        <div><input type="button" value="Save2" class="button" onclick="save('json')" title="Send content to the server (it will only show accepted parameters)"/><span class="message_line">Save content of the first table (JSON format)</span></div>
        <div><input type="radio" name="drop_option" id="drop_option1" class="checkbox" onclick="setMode(this)" value="multiple" title="Enabled dropping to already taken table cells" checked="true"/><span class="message_line">Enable dropping to already taken table cells</span></div>
        <div><input type="radio" name="drop_option" class="checkbox" onclick="setMode(this)" value="single" title="Disabled dropping to already taken table cells"/><span class="message_line">Disable dropping to already taken table cells</span></div>
        <div><input type="radio" name="drop_option" class="checkbox" onclick="setMode(this)" value="switch" title="Switch content"/><span class="message_line">Switch content</span></div>
        <div><input type="radio" name="drop_option" class="checkbox" onclick="setMode(this)" value="switching" title="Switching content continuously"/><span class="message_line">Switching content continuously</span></div>
        <div><input type="radio" name="drop_option" class="checkbox" onclick="setMode(this)" value="overwrite" title="Overwrite content"/><span class="message_line">Overwrite content</span></div>
        <div><input type="checkbox" class="checkbox" onclick="toggleDeleteCloned(this)" title="Remove cloned object if dragged outside of any table" checked="true"/><span class="message_line">Remove cloned element if dragged outside of any table</span></div>
        <div><input type="checkbox" class="checkbox" onclick="toggleConfirm(this)" title="Confirm delete"/><span class="message_line">Confirm delete</span></div>
        <div><input type="checkbox" class="checkbox" onclick="toggleDragging(this)" title="Enable dragging" checked="true"/><span class="message_line">Enable dragging</span></div>			
    </div>


<div id="Div"><p id="Mbox0">セルをクリックしたらここに書き出します。</p>
 <p id="Mbox1">インデックス値は '0'から始まります。</p>
</div>

    <div style='margin-top: 10px;margin-left: 10px;'>
<?php echo $this->Form->submit('確定する', array('name' => 'register2','div' => false)); ?>
    &nbsp;&nbsp;
<?php print($this->Form->submit('保存する', array('id'=>'button-create', 'name'=>'close','div' => false))); ?>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php print($this->Html->link('前回保存時まで戻す', 'javascript:void(0);', array('id'=>'button-delete', 'style'=>'' , 'onclick'=>'window.location.reload();'))); ?>
    </div>
<div style="margin-top: 5px;">
    ※「前回保存時まで戻す」は、保存していない分をキャンセルすることを指す。
</div>
