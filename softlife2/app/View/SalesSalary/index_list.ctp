<?php
    echo $this->Html->css('staffmaster');
    echo $this->Html->script('fixed_midashi');
?>
<?php require('calender.ctp'); ?>
<?php
    // 所属
    $list_division = array(
        '1' => 'スタッフ',
        '2' => '社員',
        '3' => 'ベルサンテ',
    );
    // 日付のフォーマット
    function setDate($date) {
        if (empty($date)) {
            return '';
        }
        $ret = date('n月j日', strtotime($date));
        return $ret;
    }
?>
<style>
#loading{
    position:absolute;
    left:50%;
    top:60%;
    margin-left:-30px;
}
</style>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
<script type="text/javascript">
  <!--
//ページの読み込み完了後に実行
window.onload = function(){
    FixedMidashi.create();
    $(function() {
        //ページの読み込みが完了したのでアニメーションはフェードアウトさせる
        $("#loading").fadeOut();
        //ページの表示準備が整ったのでコンテンツをフェードインさせる
        //$("#staff_master").fadeIn();
    });
}
  //-->
</script>
<script language="javascript">
function getCELL() {
 var myTbl = document.getElementById('staff_master');
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
var startrow = 24;
function Mdblclk(Cell) {
 var rowINX = '行位置：'+Cell.parentNode.rowIndex;//Cellの親ノード'tr'の行位置
 var cellINX = 'セル位置：'+Cell.cellIndex;
 var cellVal = 'セルの内容：'+Cell.innerHTML;
  var cellDivNum = 'セル内のDivの数：'+Cell.getElementsByTagName("DIV").length;
    if (Cell.parentNode.rowIndex > 2) {
        // スタッフ選択
        if (Cell.cellIndex == 2) {
            window.open('<?=ROOTDIR ?>/ShiftManagement/select/2','スタッフ選択','width=800,height=700,scrollbars=yes');
        } else if (Cell.cellIndex == 4) {
            window.open('<?=ROOTDIR ?>/ShiftManagement/select/4','スタッフ選択','width=800,height=700,scrollbars=yes');
        }
        alert("("+cellINX+","+rowINX+")");
    }
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
    window.open('<?=ROOTDIR ?>/ShiftManagement/select/','スタッフ選択','width=800,height=700,scrollbars=yes');
}
      // try ～ catch 例外処理、エラー処理
      // イベントリスナーaddEventListener,attachEventメソッド
try{
 window.addEventListener("load",getCELL,false);
     }catch(e){
   window.attachEvent("onload",getCELL);
  }
</script>
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
  $('.date').datepicker({ dateFormat: 'm月d日' });
});
</script>
<style type="text/css" media="screen">
  div.scroll_div { 
      overflow: auto;
      height: 500px;
      width: auto;
      margin-top: 0px;
  }
  input [type=select] {
      font-size:90%;
  }
</style>
<!--
<div id="loading"><img src="<?=ROOTDIR ?>/img/loading.gif"></div>
-->
<!-- 見出し１ -->
<div id='headline' style="padding:10px 10px 10px 10px;">
    ★ 売上給与
    &nbsp;&nbsp;
    <b><font Style="font-size:95%;color: yellow;">[売上給与データ]</font></b>
    &nbsp;
    <a href="<?=ROOTDIR ?>/SalesSalary/bill" target="" class="load"><font Style="font-size:95%;">請求書作成</font></a>        <!-- alert("制作中");return false; -->
    &nbsp;
    <a href="<?=ROOTDIR ?>/SalesSalary/salary" target="" class="load" onclick=''><font Style="font-size:95%;">給与金額</font></a>        <!-- alert("制作中");return false; -->
    &nbsp;
    <a href="<?=ROOTDIR ?>/SalesSalary/account" target="" onclick=''><font Style="font-size:95%;">銀行口座</font></a>
    &nbsp;
    <a href="<?=ROOTDIR ?>/SalesSalary/address" target="" onclick=''><font Style="font-size:95%;">スタッフ住所覧</font></a>
    &nbsp;
</div>
<!-- 見出し１ END -->

<?php echo $this->Form->create('SalesSalary', array('name' => 'form')); ?>
<?php
    // 当月ならば、月を黄色に
    if ($y == date('Y') && $m == date('m')) {
        $color = 'color:#ffffcc;font-weight:bold;';
    } else {
        $color = 'color:white;';
    }
?>
<table border='1' cellspacing="0" cellpadding="3" style="width:100%;margin-top: 10px;border-spacing: 0px;background-color: white;">
        <tr align="center">
                <td style='width:25%;'></td>
                <td style='background-color: #006699;color: white;'><font style='font-size: 110%;'>売上給与データ一覧</font></td>
                <td style='width:25%;'></td>
        </tr>
</table>

<!-- ページネーション -->
<div class="pageNav03" style="margin-top:5px; margin-bottom: 30px;">
    <div style="float:left;margin-left: 10px;margin-top: 5px;">
        【入力】<a href="<?=ROOTDIR ?>/SalesSalary/index?date=<?=$date ?>">自動</a> | 
        <a href="<?=ROOTDIR ?>/SalesSalary/index_manual?date=<?=$date ?>">手動</a> |
        <font style="font-weight: bold;background-color: #ffffcc;padding:0px 5px;">一覧</font>
    </div>
    <div style="float:left;margin-left: 20px;margin-top: 5px;">
        <button type="button" style="cursor: pointer;background-color: #FF5F17;color:white;padding:3px 10px;" 
                onclick="window.open('<?=ROOTDIR ?>/SalesSalary/reg_ss/0','新規登録','width=800,height=950,scrollbars=yes');">新規登録</button>
        <button type="button" style="cursor: pointer;" 
                onclick="window.open('<?=ROOTDIR ?>/SalesSalary/property_info','物件情報','width=800,height=700,scrollbars=yes');">物件情報</button>
    </div>
    <div style="float:right;margin-top: 5px;margin-right: 10px;">
        <?php echo '総件数  <b>'.count($datas).'</b> 件';?>
    </div>
 </div>
<div style="clear:both;"></div>

<div class="scroll_div">
<!--- スタッフマスタ本体 START --->
<table id="staff_master" border="1" width="1750px" cellspacing="0" cellpadding="1" 
       bordercolor="#333333" align="center" style="font-size: 80%;margin: 5px 0px 5px 0px;table-layout: fixed;" _fixedhead="rows:1; cols:1">
    <colgroup>
      <col style='width:50px;'>
      <col style='width:60px;'>
      
      <col style='width:80px;'>
      <col style='width:60px;'>
      
      <col style='width:50px;'>
      <col style='width:250px;'>
      <col style='width:100px;'>
      
      <col style='width:50px;'>
      <col style='width:50px;'>
      <col style='width:50px;'>
      <col style='width:50px;'>
      <col style='width:50px;'>
      <col style='width:50px;'>
      <col style='width:100px;'>
      
      <col style='width:50px;'>
      <col style='width:50px;'>
      <col style='width:50px;'>
      <col style='width:50px;'>
      <col style='width:50px;'>
      <col style='width:50px;'>
      <col style='width:50px;'>
      <col style='width:100px;'>
    </colgroup>
    <thead>
  <tr style="font-size: 100%;margin-top: -10px;">
    <th rowspan="2" style="width:50px;"><?php echo $this->Paginator->sort('no',"No.");?></th>
    <th rowspan="2" style="width:50px;"><?php echo $this->Paginator->sort('id','勤務日付', array('escape' => false));?></th>
    <th rowspan="1" colspan="2" style="width:150px;"><?php echo $this->Paginator->sort('name_sei','勤務者', array('escape' => false));?></th>
    <th rowspan="1" colspan="3" style="width:350px;"><?php echo $this->Paginator->sort('name_sei','物件（案件）', array('escape' => false));?></th>
    <th rowspan="1" colspan="7" style="width:500px;"><?php echo $this->Paginator->sort('name_sei','売上金額', array('escape' => false));?></th>
    <th rowspan="1" colspan="8" style="width:500px;"><?php echo $this->Paginator->sort('name_sei','給与金額', array('escape' => false));?></th>
    </tr>
    <tr>
        <th style="color: white;width:100px;">氏名</th>
        <th style="color: white;width:50px;">所属</th>
        
        <th style="color: white;width:30px;">№</th>
        <th style="color: white;width:150px;">現場①</th>
        <th style="color: white;width:120px;">勤務時間</th>
        <th style="color: white;width:20px;">売上</th>
        <th style="color: white;width:40px;">時間外費</th>
        <th style="color: white;width:40px;">遅刻早退</th>
        <th style="color: white;width:40px;">その他</th>
        <th style="color: white;width:40px;">交通費</th>
        <th style="color: white;width:40px;">合計</th>
        <th style="color: white;width:100px;">備考</th>
        
        <th style="color: white;width:40px;">給与</th>
        <th style="color: white;width:40px;">時間外費</th>
        <th style="color: white;width:40px;">遅刻早退</th>
        <th style="color: white;width:40px;">その他</th>
        <th style="color: white;width:40px;">小計</th>
        <th style="color: white;width:40px;">交通費</th>
        <th style="color: white;width:40px;">合計</th>
        <th style="color: white;width:100px;">備考</th>
    </tr>
    <tr>
        <?php for ($i=0; $i<22; $i++) { ?>
        <td style="background-color: #ffffe6;"><?=$i+1 ?></td>
        <?php } ?>
  </tr>
    </thead>
  <tbody style="overflow-y:scroll;">
  <?php foreach ($datas as $count => $data): ?>
  <tr>
    <!-- No -->
    <td align="center">
        <button type="button" style="cursor: pointer;" 
                onclick="window.open('<?=ROOTDIR ?>/SalesSalary/reg_ss/<?=$data['SalesSalary']['id'] ?>','新規登録','width=800,height=950,scrollbars=yes');"><?php echo $data['SalesSalary']['id']; ?></button>
    </td>
    <!-- 勤務日付 -->
    <td align="center" style="font-size: 100%;">
        <?php echo $this->Form->input(false, 
                array('type'=>'text', 'label' => false, 'class' => 'date', 'style' => 'width:80%;text-align:center;', 'value'=>setDate($data['SalesSalary']['work_date']))); ?>
        <?php echo $this->Form->input('SalesSalary.'.$count.'.work_date', array('type'=>'hidden', 'value' => $data['SalesSalary']['work_date'])); ?>
    </td>
    <!-- 氏名 -->
    <td align="center" style="font-size: 100%;">
        <?php echo $this->Form->input('SalesSalary.'.$count.'.name', 
                array('type'=>'text', 'label' => false, 'style' => 'width:80%;text-align:left;', 'value' => $data['SalesSalary']['name'])); ?>
        <?php echo $this->Form->input('SalesSalary.'.$count.'.staff_id', array('type'=>'hidden', 'value' => $data['SalesSalary']['staff_id'])); ?>
    </td>
    <!-- 所属 -->
    <td align="center" style="font-size: 100%;">
        <?php echo $this->Form->input('SalesSalary.'.$count.'.division', 
                array('type'=>'select', 'label' => false, 'options' => $list_division, 'selected' => $data['SalesSalary']['division'], 'style' => 'width:95%;font-size:90%;')); ?>
    </td>
    <!-- 物件№ -->
    <td align="center" style="font-size: 100%;">
        <?php echo $data['SalesSalary']['case_id']; ?>
    </td>
    <!-- 現場① -->
    <td align="left" style="font-size: 100%;">
        <?php echo $this->Form->input('SalesSalary.'.$count.'.case_id', 
                array('type'=>'select', 'label' => false, 'options' => $list_case3, 'selected'=>$data['SalesSalary']['case_id'], 'style' => 'width:95%;font-size:80%;')); ?>
    </td>
    <!-- 勤務時間 -->
    <td align="center" style="font-size: 100%;">
        <?php echo $this->Form->input('SalesSalary.'.$count.'.name', 
                array('type'=>'text', 'label' => false, 'div' => false, 'style' => 'width:40px;text-align:left;', 'value' =>$data['SalesSalary']['work_time_from'])); ?>
        ~
        <?php echo $this->Form->input('SalesSalary.'.$count.'.name', 
                array('type'=>'text', 'label' => false, 'div' => false, 'style' => 'width:40px;text-align:left;', 'value' =>$data['SalesSalary']['work_time_to'])); ?>
    </td>
    <!-- 売上 -->
    <td align="center" style="font-size: 100%;padding: 0px;">
        <?php echo $this->Form->input('SalesSalary.'.$count.'.sales', 
                array('type'=>'text', 'label' => false, 'style' => 'width:80%;text-align:right;', 
                    'value' => $data['SalesSalary']['sales'])); ?>
    </td>
    <!-- 時間外費 -->
    <td align="center" style="font-size: 100%;">
        <?php echo $this->Form->input('SalesSalary.'.$count.'.sales', 
                array('type'=>'text', 'label' => false, 'style' => 'width:80%;text-align:right;', 
                    'value' => $data['SalesSalary']['offhours_1'])); ?>
    </td>
    <!-- 遅刻早退 -->
    <td align="center" style="font-size: 100%;">
        <?php echo $this->Form->input('SalesSalary.'.$count.'.sales', 
                array('type'=>'text', 'label' => false, 'style' => 'width:80%;text-align:right;', 
                    'value' => $data['SalesSalary']['adjustment_1'])); ?>
    </td>
    <!-- その他 -->
    <td align="center" style="font-size: 100%;">
        <?php echo $this->Form->input('SalesSalary.'.$count.'.sales', 
                array('type'=>'text', 'label' => false, 'style' => 'width:50px;text-align:right;', 
                    'value' => $data['SalesSalary']['etc_1'])); ?>
    </td>
    <!-- 交通費 -->
    <td align="center" style="font-size: 100%;">
        <?php echo $this->Form->input('SalesSalary.'.$count.'.sales', 
                array('type'=>'text', 'label' => false, 'style' => 'width:50px;text-align:right;', 
                    'value' => $data['SalesSalary']['transportation_1'])); ?>
    </td>
    <!-- 合計 -->
    <td align="center" style="font-size: 100%;">
        <?php echo $this->Form->input('SalesSalary.'.$count.'.sales', 
                array('type'=>'text', 'label' => false, 'style' => 'width:50px;text-align:right;', 
                    'value' => $data['SalesSalary']['total_1'])); ?>
    </td>
    <!-- 備考 -->
    <td align="center" style="font-size: 100%;">
        <?php echo $this->Form->input('SalesSalary.'.$count.'.remarks', 
                array('type'=>'text', 'label' => false, 'style' => 'width:95%;text-align:left;', 
                    'value' => $data['SalesSalary']['remarks_1'])); ?>
    </td>
    <!-- 給与 -->
    <td align="center" style="font-size: 100%;">
        <?php echo $this->Form->input('SalesSalary.'.$count.'.sales', 
                array('type'=>'text', 'label' => false, 'style' => 'width:50px;text-align:right;', 
                    'value' => $data['SalesSalary']['salary'])); ?>
    </td>
    <!-- 時間外費 -->
    <td align="center" style="font-size: 100%;">
        <?php echo $this->Form->input('SalesSalary.'.$count.'.sales', 
                array('type'=>'text', 'label' => false, 'style' => 'width:50px;text-align:right;', 
                    'value' => $data['SalesSalary']['offhours_2'])); ?>
    </td>
    <!-- 遅刻早退 -->
    <td align="center" style="font-size: 100%;">
        <?php echo $this->Form->input('SalesSalary.'.$count.'.sales', 
                array('type'=>'text', 'label' => false, 'style' => 'width:50px;text-align:right;', 
                    'value' => $data['SalesSalary']['adjustment_2'])); ?>
    </td>
    <!-- その他 -->
    <td align="center" style="font-size: 100%;">
        <?php echo $this->Form->input('SalesSalary.'.$count.'.sales', 
                array('type'=>'text', 'label' => false, 'style' => 'width:50px;text-align:right;', 
                    'value' => $data['SalesSalary']['etc_2'])); ?>
    </td>
    <!-- 小計 -->
    <td align="center" style="font-size: 100%;">
        <?php echo $this->Form->input('SalesSalary.'.$count.'.sales', 
                array('type'=>'text', 'label' => false, 'style' => 'width:50px;text-align:right;', 
                    'value' => $data['SalesSalary']['sum'])); ?>
    </td>
    <!-- 交通費 -->
    <td align="center" style="font-size: 100%;">
        <?php echo $this->Form->input('SalesSalary.'.$count.'.sales', 
                array('type'=>'text', 'label' => false, 'style' => 'width:50px;text-align:right;', 
                    'value' => $data['SalesSalary']['transportation_2'])); ?>
    </td>
    <!-- 合計 -->
    <td align="center" style="font-size: 100%;">
        <?php echo $this->Form->input('SalesSalary.'.$count.'.sales', 
                array('type'=>'text', 'label' => false, 'style' => 'width:50px;text-align:right;', 
                    'value' => $data['SalesSalary']['total_2'])); ?>
    </td>
    <!-- 備考 -->
    <td align="center" style="font-size: 100%;">
        <?php echo $this->Form->input('SalesSalary.'.$count.'.sales', 
                array('type'=>'text', 'label' => false, 'style' => 'width:95%;text-align:left;', 
                    'value' => $data['SalesSalary']['remarks_2'])); ?>
    </td>
  </tr>
  <?php endforeach; ?>
<?php if (count($datas) == 0) { ?>
<tr>
    <td colspan="22" align="center">表示するデータはありません。</td>
</tr>
<?php } ?>
  </tbody>
</table>
</div>

<!--- スタッフマスタ本体 END --->
<?php echo $this->Form->end(); ?>
