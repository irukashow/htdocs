<?php
    echo $this->Html->css('staffmaster');
?>
<?php require('calender.ctp'); ?>
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
//コンテンツの非表示
$(function(){
    $('#staff_master').css('display', 'none');
});
//ページの読み込み完了後に実行
window.onload = function(){
    $(function() {
        //ページの読み込みが完了したのでアニメーションはフェードアウトさせる
        $("#loading").fadeOut();
        //ページの表示準備が整ったのでコンテンツをフェードインさせる
        $("#staff_master").fadeIn();
    });
}
  //-->
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
  $('.date').datepicker({ dateFormat: 'yy-mm-dd' });
});
</script>

<div id="loading"><img src="<?=ROOTDIR ?>/img/loading.gif"></div>
<!-- 見出し１ -->
<div id='headline' style="padding:10px 10px 10px 10px;">
    ★ シフト管理
    &nbsp;&nbsp;
    <a href="<?=ROOTDIR ?>/ShiftManagement/index" target="" onclick=''><font Style="font-size:95%;">スタッフシフト希望</font></a>
    &nbsp;
    <a href="<?=ROOTDIR ?>/ShiftManagement/schedule" target="" class="load"><font Style="font-size:95%;">シフト作成</font></a>        <!-- alert("制作中");return false; -->
    &nbsp;
    <b><font Style="font-size:95%;color: yellow;">[勤務実績]</font></b>
    &nbsp;
    <a href="<?=ROOTDIR ?>/ShiftManagement/setting" target="" onclick=''><font Style="font-size:95%;">設定</font></a>
    &nbsp;
</div>
<!-- 見出し１ END -->

<?php echo $this->Form->create('TimeCard', array('name' => 'form')); ?>
<table border='1' cellspacing="0" cellpadding="3" style="width:100%;margin-top: 10px;border-spacing: 0px;background-color: white;">
        <tr align="center">
                <td style=''><a href="<?=ROOTDIR ?>/ShiftManagement/schedule?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' -1 month')); ?>">&lt; 前の月</a></td>
                <td style='background-color: #006699;color: white;'><font style='font-size: 110%;'>【<?php echo $y ?>年<?php echo $m ?>月】</font></td>
                <td style=''><a href="<?=ROOTDIR ?>/ShiftManagement/schedule?date=<?php echo date('Y-m', strtotime($y .'-' . $m . ' +1 month')); ?>">次の月 &gt;</a></td>
        </tr>
</table>

<!-- ページネーション -->
<div class="pageNav03" style="margin-top:5px; margin-bottom: 30px;">
<?php
	echo $this->Paginator->first('<< 最初', array(), null, array('class' => 'first disabled'));
	echo $this->Paginator->prev('< 前へ', array(), null, array('class' => 'prev disabled'));
	echo $this->Paginator->numbers(array('separator' => ''));
	echo $this->Paginator->next('次へ >', array(), null, array('class' => 'next disabled'));
        echo $this->Paginator->last('最後 >>', array(), null, array('class' => 'last disabled'));
?>
    <div style="float:right;margin-top: 5px;">
        <?php echo $this->Paginator->counter(array('format' => __('総件数  <b>{:count}</b> 件')));?>
        &nbsp;&nbsp;&nbsp;
        表示件数：
        <?php
            $list = array('5'=>'5','10'=>'10','20'=>'20','50'=>'50','100'=>'100');
            echo $this->Form->input('limit', array('name' => 'limit', 'type' => 'select','label' => false,'div' => false, 'options' => $list, //'selected' => $limit,
                'onchange' => 'form.submit();'));
        ?>
    </div>
 </div>
<div style="clear:both;"></div>

<div style="height:500px; width:100%; overflow-x:scroll;">
<!--- スタッフマスタ本体 START --->
<table id="staff_master" border="1" width="3000px" cellspacing="0" cellpadding="5" bordercolor="#333333" align="center" style="font-size: 80%;margin: 0px 0px 5px 0px;">
    <thead>
  <tr style="font-size: 100%;margin-top: -10px;">
      <th rowspan="2" style="width:3%;"><?php echo $this->Paginator->sort('no',"No.");?></th>
    <th rowspan="2" style="width:3%;"><?php echo $this->Paginator->sort('id','日付', array('escape' => false));?></th>
    <th rowspan="1" colspan="2" style="width:6%;"><?php echo $this->Paginator->sort('name_sei','案件', array('escape' => false));?></th>
    <th rowspan="1" colspan="2" style="width:6%;"><?php echo $this->Paginator->sort('name_sei','勤務者', array('escape' => false));?></th>
    <th rowspan="1" colspan="3" style="width:9%;"><?php echo $this->Paginator->sort('name_sei','就業時間', array('escape' => false));?></th>
    <th rowspan="1" colspan="6" style="width:18%;"><?php echo $this->Paginator->sort('name_sei','売上金額', array('escape' => false));?></th>
    <th rowspan="2" style="width:6%;"><?php echo $this->Paginator->sort('age','備考', array('escape' => false));?></th>
    <th rowspan="1" colspan="8" style="width:24%;"><?php echo $this->Paginator->sort('name_sei','給与', array('escape' => false));?></th>
    <th rowspan="1" colspan="4" style="width:12%;"><?php echo $this->Paginator->sort('name_sei','交通費', array('escape' => false));?></th>
    <th rowspan="1" colspan="1" style="width:3%;"><?php echo $this->Paginator->sort('name_sei','支給', array('escape' => false));?></th>
    <th rowspan="2" style="width:6%;"><?php echo $this->Paginator->sort('name_sei','備考', array('escape' => false));?></th>
  </tr>
  <tr>
      <th style="color: white;width:3%;">物件№</th>
      <th style="color: white;width:3%;">案件名</th>
      <th style="color: white;width:3%;">氏名</th>
      <th style="color: white;width:3%;">所属</th>
      <th style="color: white;width:3%;">就業時間</th>
      <th style="color: white;width:3%;">休憩時間</th>
      <th style="color: white;width:3%;">労働時間</th>
      <th style="color: white;width:3%;">売上</th>
      <th style="color: white;width:3%;">時間外費</th>
      <th style="color: white;width:3%;">遅刻早退<br>調整</th>
      <th style="color: white;width:3%;">その他</th>
      <th style="color: white;width:3%;">交通費</th>
      <th style="color: white;width:3%;">合計</th>
      <th style="color: white;width:3%;">研修<br>期間</th>
      <th style="color: white;width:3%;">給与<br>優遇</th>
      <th style="color: white;width:3%;">交通費<br>優遇</th>
      <th style="color: white;width:3%;">給与</th>
      <th style="color: white;width:3%;">時間外費</th>
      <th style="color: white;width:3%;">遅刻早退<br>調整</th>
      <th style="color: white;width:3%;">その他</th>
      <th style="color: white;width:3%;">小計</th>
      <th style="color: white;width:3%;">予定</th>
      <th style="color: white;width:3%;">申請類</th>
      <th style="color: white;width:3%;">ﾁｪｯｸ</th>
      <th style="color: white;width:3%;">支給額</th>
      <th style="color: white;width:3%;">合計</th>
  </tr>
  <tr>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">
      </td>
      <td style="background-color: #ffffe6;">
      </td>
      <td style="background-color: #ffffe6;">
      </td>
      <td style="background-color: #ffffe6;">
      </td>
      <td style="background-color: #ffffe6;">
      </td>
      <td style="background-color: #ffffe6;">
      </td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
      <td style="background-color: #ffffe6;">&nbsp;</td>
  </tr>
    </thead>
  <tbody style="overflow-y:scroll;">
  <?php foreach ($datas as $data): ?>
  <tr>
    <td align="center">
        <?php $case_id = $data['TimeCard']['id']; ?>
        <?php echo $case_id; ?>
    </td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
  </tr>
  <?php endforeach; ?>
<?php if (count($datas) == 0) { ?>
<tr>
    <td colspan="29" align="center">表示するデータはありません。</td>
</tr>
<?php } ?>
  <tr>
    <td align="center">例</td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 110%;">★</td>
    <td align="center" style="font-size: 110%;">★</td>
    <td align="center" style="font-size: 110%;">★</td>
    <td align="center" style="font-size: 90%;">
        <input type="text" style="font-size: 90%;width:95%;">
    </td>
    <td align="center" style="font-size: 90%;">
        <input type="text" style="font-size: 90%;width:95%;">
    </td>
    <td align="center" style="font-size: 90%;">
        <input type="text" style="font-size: 90%;width:95%;">
    </td>
    <td align="center" style="font-size: 90%;">
        <input type="text" style="font-size: 90%;width:95%;">
    </td>
    <td align="center" style="font-size: 90%;">
        <input type="text" style="font-size: 90%;width:95%;">
    </td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
    <td align="center" style="font-size: 90%;"></td>
  </tr>
  </tbody>
</table>
</div>

<!-- ページネーション -->
<div class="pageNav03" style="margin-bottom: 30px;">
<?php
	echo $this->Paginator->first('<< 最初', array(), null, array('class' => 'first disabled'));
	echo $this->Paginator->prev('< 前へ', array(), null, array('class' => 'prev disabled'));
	echo $this->Paginator->numbers(array('separator' => ''));
	echo $this->Paginator->next('次へ >', array(), null, array('class' => 'next disabled'));
        echo $this->Paginator->last('最後 >>', array(), null, array('class' => 'last disabled'));
?>
 </div>
<!--- スタッフマスタ本体 END --->
<?php echo $this->Form->end(); ?>
