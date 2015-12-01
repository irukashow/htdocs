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
    echo $this->Html->script('jquery.tablefix');
    echo $this->Html->script('script');
    //echo $this->Html->css('evol.colorpicker.min');
    echo $this->Html->css('staffmaster');
    echo $this->Html->css('style_1');
?>

<?php
    $font_normal = "font-family: Meiryo, メイリオ,'lucida grande',verdana,helvetica,arial,sans-serif;";
?>

<script>
onload = function() {
    //FixedMidashi.create();
    // ヘッダを隠す
    document.getElementById("header").style.display = 'none';
    //document.getElementById("footer").style.display = 'none';
    //ページの読み込みが完了したのでアニメーションはフェードアウトさせる
    $("#loading").fadeOut();
    //ページの表示準備が整ったのでコンテンツをフェードインさせる
    $("#staff_master").fadeIn();
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
  var divs = "";
 for(i=0; i<Cell.getElementsByTagName("DIV").length; i++) {
    if (i == 0) {
         divs = "&s1=" + Cell.getElementsByTagName("DIV")[0].id;
    } else {
         divs = divs + "&s" + (i+1) + "=" + Cell.getElementsByTagName("DIV")[i].id;       
     }
 }
    if (Cell.parentNode.rowIndex == 0) {
        location.href = "<?=ROOTDIR ?>/ShiftManagement/setting";
    } else if (Cell.parentNode.rowIndex < startrow || Cell.parentNode.rowIndex > startrow+31 || Cell.cellIndex < 0) {
        return false;
    }
    // class名が「redips-drag t1」以外ならばNG
    if (Cell.getAttribute("class") == "redips-mark") {
        return false;
    }
    //Cell.innerHTML += '<div id="d2" class="redips-drag t1" style="border-style: solid; cursor: move;">加藤愛子</div>';
    window.open('<?=ROOTDIR ?>/ShiftManagement/select/'+Cell.getElementsByTagName("span")[0].id+'/0/'+(Cell.parentNode.rowIndex-(startrow-1))+'/'+(Cell.cellIndex+1)
            +'/'+Cell.getElementsByTagName("span")[1].id+'?date=<?=$year.'-'.$month ?>'+divs,'スタッフ選択','width=800,height=700,scrollbars=yes');
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
#loading{
    position:absolute;
    left:50%;
    top:40%;
    margin-left:-30px;
}
</style>
<style type="text/css">
#corner {
   position: absolute;left:0px;top:0px;
   width:925px;
}
#header_v {
   position: absolute;left:0px;top:83px;
   width:925px;
   height:582px; 
   overflow-x:hidden;
   overflow-y:hidden;
   }
#header_h {
   position: absolute;left:925px;top:0px;
   width:832px;
   overflow-x:hidden;overflow-y:hidden;
   }
#data {
   position: absolute;left:925px;top:83px;
   overflow-x:scroll;overflow-y:scroll;
   width:850px;
   height:600px;
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